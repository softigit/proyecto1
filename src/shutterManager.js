/*jslint debug: true */
emb.shutterManager = function(embConsole, embPageHelper, pagesConfiguration){

    var initialized, shutteringText, currentFlow, lastVisitiedPageType;

    function getCurrentFlowData(_flow){
        var flow = _flow || currentFlow;
        return pagesConfiguration.flows[flow] || {};
    }

    function getCurrentFlowName(toPageId){
        var flowName;
        _.each(pagesConfiguration.flows, function(flow, _flowName){
            _.each(flow.pages, function(page){
                if( page.$el.attr('id') === toPageId ){
                    flowName = _flowName;
                }
            });
        });
        return flowName;
    }

    function checkIsConfirmationPage(pageId){
        var flowData = getCurrentFlowData();
        //i should be using _.where, but the underscore version that EMB uses doesn't have it
        return _.filter(flowData.pages, function(page){
            return page.$el.attr('id') === pageId && page.type === 'confirm';
        }).length > 0;
    }

    //check if we're in a page where the flow is allowed to start.
    function checkIfEntryPoint(pageId){
        var flowData = getCurrentFlowData();
        //i should be using _.where, but the underscore version that EMB uses doesn't have it
        return _.filter(flowData.pages, function(page){
            return page.$el.attr('id') === pageId && page.type === 'entry-point';
        }).length > 0;
    }

    //shutter all pages that needs to be shutther when the flow starts (ideally, all pages except entry points).
    function shutterDefaultPages(_options){
        var options = _options || {};
        _.each(pagesConfiguration.flows, function(flow){
            if( flow.shouldBeShuttered ){
                _.each(flow.pages, function(page){
                    if( checkIsConfirmationPage(page.$el.attr('id')) ){
                        return;
                    }

                    embPageHelper( page.$el ).shutterWith( shutteringText );
                });
            }
        });
    }

    // Right now, there are two posible states: finalized and not finalized.
    // I've added this methods in case we need to add more states to handle issues yet to occur
    function setFlowState(state){
        var flowData = getCurrentFlowData();
        switch(state){
            case 'start':
                flowData.finalized = false;
                break;
            case 'finalizaed':
                flowData.finalized = true;
                break;
        }
    }

    function resetFlowState(){
        setFlowState('finalized');
    }

    function shutterCurrentPageIfAppropriate(toPageId, fromHashChange){
        // We need a way to determine if the user is navigating back or forward, and jquery mobile
        // provide a fromHashChange flag:
        //  When true, the user refreshed or clicked the back/forward button in the browser.
        //  When false, the user clicked on any button in the application
        //
        // So, based on that flag plus the finalized flow flag, we'll determine when and which pages should be shuttered:
        //   If the user is navigating through the app by clicking buttons ,that page should be unshuttered
        //   If the user is navigating via browser back/fordward button, no page will be change its state (shuttered/unshuttered)
        //   If the user reached a flow entry point AND the flow is finalizaed, we need to reset the flow state flag, and
        //   shutter all pages in the flow except the current one. Otherwise, the user would see the shuttering message

        var isEntryPoint = checkIfEntryPoint(toPageId),
            currentPageHelper = embPageHelper( $("#"+toPageId) ),
            flowData = getCurrentFlowData();

        //Is the user navigating the app? Then unshutter the current page.
        if( !fromHashChange ){
            currentPageHelper.unshutter();
        }

        //Entry point reached after finalizing the flow, so let's re-initialize the it and re-shutter all pages again
        if( flowData.finalized && isEntryPoint ){
            resetFlowState();

            //shutter all default pages but the current one
            shutterDefaultPages();
            currentPageHelper.unshutter();
        }
    }

    // It restarts the flow and shutters all pages that need to be shuttered when the flow starts.
    // This changes will only be applied when the user reaches the confirmation page navigating the app.
    function handleConfirmationPageScenario(fromHashChange){
        // Special case in billpay flow. From the confirmation page, i can start the flow again.
        // If i tap it, and then click back (go the confirmation page again) and then forward, i don't what that page
        // to be shuttered. So, page shuttering condition will only change when the user clicks buttons in the app,
        // never when clicking broeser back/forward buttons.
        if( !fromHashChange ){
            setFlowState('start');
            shutterDefaultPages({excludeConfirmPage: true});
        }
    }

    function isReady(){
        if( !initialized ){
            embConsole.error("Initialize shutterManager module by calling init method");
            return;
        }

        if( !shutteringText ){
            embConsole.error("You need to pass a shuttering message into the init method");
            return;
        }

        return true;
    }

    function processNewPage(_toPageId, fromHashChange){
        if( !isReady() ){
            return;
        }

        if( !_toPageId ){
            return;
        }

        var toPageId = (_toPageId.indexOf("#") === 0) ? _toPageId.slice(1) : _toPageId, //remove # sign at the end
            flow = getCurrentFlowName(toPageId),
            flowData;

        //couldn't find a flow that matches the idpage passed in, so let's get out
        if( !flow ){
            embConsole.error('Couldn\'t find a flow that matches the page id passed in');
            return;
        }

        if( flow !== currentFlow ){
            // We need to reset the flow we're leaving since the user can come back to it, and the process
            // have to start again with a fresh state.
            // Also, we need to do if before updating the currentFlow variable since resetFlowState makes use of it
            // and if we do it after, we would be reseting the state of the new flow.
            resetFlowState();
            // shutterDefaultPages();
            currentFlow = flow;
        }

        flowData = getCurrentFlowData();

        //check if the current flow needs to be shuttered
        if( !flowData.shouldBeShuttered ){
            return;
        }

        //if the last page visited was a confirmation one, shutter it as soon as you leave it
        if( lastVisitiedPageType === 'confirm' ){
             //i should be using _.where, but the underscore version that EMB uses doesn't have it
            _.each(flowData.pages, function(page){
                if( page.type === 'confirm' ){
                    embPageHelper( page.$el ).shutterWith(shutteringText);
                }
            });
        }

        shutterCurrentPageIfAppropriate(toPageId, fromHashChange);
 
        if( checkIsConfirmationPage(toPageId) ){
            handleConfirmationPageScenario(fromHashChange);
            lastVisitiedPageType = 'confirm';
        }else{
            lastVisitiedPageType = 'bulk';
        }
    }

    function init(_shutteringText){
        initialized = true;
        shutteringText = _shutteringText;

        if( !isReady() ){
            return;
        }

        //shutter all money flows and add manage payee/recipient flows pages.
        //They'll be unshutter when needed
        shutterDefaultPages();
    }

    return {
        init: init,
        processNewPage: processNewPage
    };

};