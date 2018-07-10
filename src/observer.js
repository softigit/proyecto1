//Mobile behavior analytics module, implements an observer pattern by listening to events.
//when event occurs adds to internal collection, then submits immediately or when pagecount reaches a
//specified level.
emb.observer = function($, window, document, serviceLayer, authenticated) {
    if (typeof $ === "undefined") {
        window.alert("log-page-events.js requires jQuery core!");
        return;
    }

    var my = {},
        /* pageStart is a custom event I created to handle a transition to a new screen. I use it to bind to jquery mobile's
         * pageshow event. However, this event get's triggered before pagechange which the shutterManager handles. Therefore,
         * the page we are transitioning to is shuttered at this point. Therefore, I trigger pageStart in the pageshow
         * event handler after the shutterManager unshutters the newly transitioned to page.
         */
        screenEvents = "change pageStart serviceError alertEvent specialselect logon logoff touchstart mfa", //add new events to listen for here.
        limitBeforeServiceCall = 2, //set threshold for submitting pages here
        limitBeforeClearingData = 20, //this is use to make sure the data doesn't accumulate forever if you can't submit the data
        skipNextPageShow = false; //this is to get around dialog weirdness

    //screen collection object - holds an array of page objects.
    //Page objects contain the analytic data to be sent to the GWO service.
    my.screenCollection = (function() {
        var findLabelForInput = function(target) {
                    //look for a label that has a for attribute matching input
                    var $target = $(target),
                            moniker = $target.attr('id') || $target.attr('name'),
                            $label = $.mobile.activePage.find('label[for="' + moniker + '"]');

                    console.assert($label.length === 1, 'exactly one label should have a "for" attribute of "' + moniker + '"');

                    return {
                        label:$label,
                        labelText:$label ? $label.text() : ''};

                },
                screens =
                        [
                        ], //private screens array
                getHeaderText = function(screenObject) {
                  if (screenObject.find(".unshuttered").length) {
                    return screenObject.find(".unshuttered h2") && screenObject.find(".unshuttered h2").get(0) && screenObject.find(".unshuttered h2").get(0).childNodes && screenObject.find(".unshuttered h2").get(0).childNodes[0] && screenObject.find(".unshuttered h2").get(0).childNodes[0].data;
                  } else {
                    return screenObject.find("h2") && screenObject.find("h2").get(0) && screenObject.find("h2").get(0).childNodes && screenObject.find("h2").get(0).childNodes[0] && screenObject.find("h2").get(0).childNodes[0].data;
                  }
                },
        //creates a new screen/page object
                createScreen = function(screenObject, evt) {
                    var self = this, page = {
                        name:screenObject && screenObject.data().url, //screen name
                        title: getHeaderText(screenObject), //first (.unshuttered) h2(if it exist) should give us the title
                        timestamp:evt && evt.timeStamp, //timestamp
                        accountId:null,
                        errors:
                                [
                                ], //error collection
                        fields:
                                [
                                ], //fields - the element text
                        attributes:
                                [
                                ], //attributes - for future use

                        //parses a click/tap event and updates internal arrays
                        addClick:function(evt) {
                            var fieldData,
                                    self = this,
                                    $target,
                                    targetType,
                                    fieldText,
                            //parse event object
                                    clickEvent = {
                                        timeStamp:evt.timeStamp,
                                        target:$(evt.target)
                                    };

                            //This code is to get the name of the field the user clicked on
                            if (clickEvent.target) {
                                $target = $(clickEvent.target).get(0);

                                switch ($target.nodeName) {
                                    case 'INPUT' :
                                    case 'SELECT' :
                                        fieldText = findLabelForInput($target).labelText;
                                        break;
                                    case 'A' :
                                    case 'SPAN' :
                                    case 'LABEL' :
                                    case 'BUTTON' :
                                    case 'DIV' :
                                        fieldText = $target.innerText;
                                        break;
                                    default :
                                        console.warn('analytics - unable to find match for %s',
                                                $target.nodeName);
                                        return;
                                }
                            }


                            fieldData = {
                                label: fieldText && fieldText.trim()
                            };

                            if (!_.isEqual(self.fields[self.fields.length - 1],
                                    fieldData) && fieldText) {
                                self.fields.push(fieldData);
                            }
//
                            //if someone clicks the appstore link then we need to submit the
                            //data immediately. This code should handle that scenario
                            if (clickEvent.target.data("send") === "yes") {
                                my.screenCollection.submitData();
                            }
                        },
                        //adds an error object
                        addError:function(code, message) {
                            var self = this;
                            this.errors[this.errors.length] = {
                                "code":code,
                                "message":message
                            };
                        }
                    };

                    screens.push(page);

                    //normally we submit every 10th screen to service
                    if (screens.length >= limitBeforeServiceCall) {
                        this.submitData();
                    }

                    return screens;
                },

        //returns screen collection
                getScreens = function() {
                    return screens;
                },

        //gets current screen - top screen in array
                getCurrentScreen = function(page, event) {
                    if (screens.length === 0) {
                        my.screenCollection.createScreen(page,
                                event);
                    }
                    return screens[screens.length - 1];
                },

        //clears screens
                clearData = function() {
                    screens.splice(0,
                            screens.length - 1);
                },

        // returns correctly formatted analytics object.
                formatData = function() {
                    /* want to submit the screens but can't include the methods
                     because they don't serialize. Also they're useless data.
                     Furthermore, I have to clone the screens object, because
                     I can't directly change the screens object, because I'm
                     actually on a screen. The extend method copies the value
                     not the reference.*/
                    var cloneScreens = $.extend(true,
                            [
                            ],
                            screens), analyticDataObject;
                    cloneScreens = cloneScreens.splice(0,
                            cloneScreens.length - 1);
                    $.each(cloneScreens,
                            function(index, value) {
                                //check to see if the addClick method exist
                                if (cloneScreens[index].addClick) {
                                    //if so delete it
                                    delete cloneScreens[index].addClick;
                                }
                                if (cloneScreens[index].addError) {
                                    delete cloneScreens[index].addError;
                                }
                            });
                    analyticDataObject = {
                        "timestamp":new Date().getTime(),
                        "bandwidth":null,
                        "pushText":null,
                        "number of screens":cloneScreens.length,
                        "screens":cloneScreens,
                        "attributes":null,
                        "channelId":"MOE"
                    };
                    return analyticDataObject;
                },

        //coverts page collection into GWO json format, then submits to GWO service
                submitData = function() {
                    var analyticDataObject = formatData(),
                            request = {
                                "trackingData":JSON.stringify(analyticDataObject),
                                "channelId":"MOE",
                                "deviceType":null,
                                "deviceVersion":null,
                                "deviceAppVersion":null,
                                "deviceOS":null
                            },
                            url = (authenticated ? emb.urls.pingA : emb.urls.pingN);
                    serviceLayer.request('Analytics',
                            url,
                            request,
                            function errorHandler(errorText, errorData) {
                                if (screens.length > limitBeforeClearingData) {
                                    clearData();
                                }
                            },
                            function successHandler(data) {
                                clearData();
                            },
                            {displayScreenBlocker:false, isSerial:false, dataType:'text'}
                    );
                };

        return {
            //return object
            createScreen:createScreen,
            getScreens:getScreens,
            getCurrentScreen:getCurrentScreen,
            submitData:submitData
        };

    }());

    //event processing logic, check event and modify pageCollection accordingly.
    //Some events are triggered via custom events and are instrumented in other areas such as service calls.
    function logEvent(event, data, data2) {
        var result = event.type + " (" + (new Date()).getTime() + ")\n",
                targetText,
                page = $.mobile.activePage,
                nameOfPageOfCurrentScreen = ((my.screenCollection.getScreens().length > 1) ? my.screenCollection.getCurrentScreen().name : page.url),
                urlOfPageEventWasFiredOn,
                eventAncestory = event.target,
                domElementWasTemporary = false,
                arr,
                hash = window.location.hash,
                hashWithoutHashSymbolAndQuery;
                if (window.location.hash==="") {
                  hashWithoutHashSymbolAndQuery = (window.location.pathname === "/secure.html" ? "accounts" : "home");
                } else {
                  // We don't want the hash symbol so we start the substring at index 1 and we don't want the query parameters
                  // so we take index of the & and subtract 1 (the index of the first letter in the substr) as the length.
                  hashWithoutHashSymbolAndQuery = hash.substr(1, (hash.indexOf('&')!==-1 ? hash.indexOf('&') - 1 : undefined));
                }
        switch (event.type) {
            case "change" :
                my.screenCollection.getCurrentScreen(page,
                        event).addClick(event);
                break;
            case "serviceError":
                if (data && data.errors) {
                    my.screenCollection.getCurrentScreen(page,
                            event).addError(data.errors.code,
                            data.errors.message);
                } else if (data) {
                    my.screenCollection.getCurrentScreen(page,
                            event).addError("Unknown",
                            ("raw data: " + data));
                } else {
                    my.screenCollection.getCurrentScreen(page,
                            event).addError("Unknown",
                            "No data");
                }
                break;
            case "touchstart":
                my.screenCollection.getCurrentScreen(page,
                        event).addClick(event);
                break;
            case "pageStart":
                /* logic to see if we are on the same screen definition. Dialogs aren't unique pages even though their data url may be different
                 * therefore, we check the hash to see if it's the same value as the last screens data url if so we don't create a new screen
                 * otherwise we do.
                 */
                if (hashWithoutHashSymbolAndQuery!==my.screenCollection.getCurrentScreen(page, event).name) {
                  my.screenCollection.createScreen(page, event);
                }
                break;
            case "alertEvent":
                my.screenCollection.getCurrentScreen(page,
                        event).addError(null,
                        data);
                break;
            case "logon":
            case "mfa":
            case "logoff":
                /*
                this is a forced custom event that triggers during logon, logoff and mfa button clicked
                as logon button is simple POST and app reloads this screen was not able to capture
                so this custom event triggers force submit of captured screen
                according to current logic we sends data of previous page for e.g we are on page1 and moving to page 2
                then page1 data will be posted to analytics and page1 will be cleared from captured data
                as this is forced event there was only one screen in list, so logic of screens(screens.lenght -1) returns empty screen, thats why adding
                current(duplicate) screen to screens list so that above logic works fine.
                after app reloads duplicate screen will be cleared (anyway) from screens list
                */
                my.screenCollection.createScreen(page, event);
                my.screenCollection.submitData();
                break;
            case "specialselect":
                my.screenCollection.getCurrentScreen(page,
                        event).addClick(event);
                break;
        }
    }

    //initialization logic here
    function initialize() {
        //listen for events, pass events to logEvent function
        $(document).bind(screenEvents,
                logEvent);
        return my;
    }

    return initialize(); //run initializer function, then return object
};
