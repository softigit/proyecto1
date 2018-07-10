// Override Defaults
$(document).bind("mobileinit", function(){
  var _ = underscore,
    targetHash,
    loadedHash = $.mobile.path.parseUrl(window.location.href).hash,
    shutterManager;

  //look for the current hash in the pages configuration object
  //and redirect to a safe hash if found
  loadedHash = loadedHash.replace('#','').replace('&ui-state=dialog','');
  _.each(emb.pagesConfiguration.flows, function(flowData, flowName){
    _.each(flowData.pages, function(pageData){
      if( loadedHash === pageData.$el.attr('id') ){
        targetHash = flowData.whereToRedirectAfterRefreshing;
      }
    });
  });

  $.extend( $.mobile , {
    defaultPageTransition: 'none',
    defaultDialogTransition: 'none',
    loadingMessage: 'Loading...',
    useFastClick: true
  });

  // Whether or not touse native menus for dropdown select menus
  $.mobile.selectmenu.prototype.options.nativeMenu = true;

  // Whether or not to reset type=date inputs to text
  $.mobile.page.prototype.options.degradeInputs.date = true;

  $.mobile.listview.prototype.options.filterPlaceholder = "Find item...";

  //add custom validator to validation
  if( $.validator ){
    $.validator.addMethod('regexp', function(value, element, param) {
            return this.optional(element) || value.match(param);
        },
        'This value doesn\'t match the acceptable pattern.'
      );     
    $.validator.addMethod("notEqualTo", function(value, element, param) {
            return this.optional(element) || value !== $(param).val();
        }, "This has to be different..."
      );
    $.validator.addMethod("recipient", function(value, element, param) {
            return $(param).text() !== "";
        }, "Recipient is required"
      );
  }

  function highlightTabs($page, selectors) {
    _.each(selectors, function(selector) {
      var tab = $page.find(selector);
      tab.children('a').addClass('ui-btn-active');

      //added for ADA compliance.  indicates to AT tool which tab is currently selected
      tab.attr('aria-selected','true');
    });
  }

  // Page init for Accounts tab

  _.each( [ $('#accounts'), $('#accountscustomerlist'), $('#accountsummary'), $('#accountdetails'), $('#producttradeddetails'), $('#accountposition'),
            $('#accountpositiondetails'), $('#accounttransaction'), $('#accounttransactionfilter'), $('#investmentAccountTransactionDetail'),
            $('#accountactivity'), $('#rewarddetails'), $('#quote'), $('#article'), $('#legal-info'),$('#cpc-disclosures'), $('#privacy') , $('#legal-info-details'), $('#accountsAnnouncements'), $('#redeemrewardfailed'),
            $('#indicatorDetails')
          ],
    function( $page ) {
      highlightTabs($page, ['.accounts-navbar-item']);
    }
  );

  // Page init for Pay & Transfer tab
  _.each( [ $('#paytransfer'), $('#transfermoney'), $('#scheduletransfer'),
            $('#verifytransfer'), $('#transferactivity'), $('#transfercomplete'),

            $('#paybills'), $('#paybillsverifypayment'), $('#paybillsconfirmpayment'),
            $('#paybillsselectpayee'), $('#paybillsschedulepayment'),
            $('#paybills-confirm-cancel'), $('#billpayaddpayee'), $('#billpayaddpayeedetails'),
            $('#paybillsManagePayee'), $('#billpayaddpayeedetailsVerify'), $('#paybillsEditPayee'), $('#billpayeditpayeedetailsVerify'),
            $('#paybillsManagePayeeSearchResults'),

            $('#paybillsManagePayee-r2'), $('#billpayaddpayeedetailsVerify-r2'),
            $('#paybillsManagePayeeSearchResults-r2'), $('#billpayaddpayee-r2'),$('#billpayaddpayeedetails-r2'),
            $('#paybillsEditPayeeR2'),$('#bpEditPayeeDetailName-r2'),$('#billpayeditpayeedetailsVerifyR2'),

            $('#paybills-r2'),$('#paybillsconfirmpayment-r2'),$('#paybills-confirm-cancel-r2'),
            $('#paybillsverifypayment-r2'),$('#paybillsselectpayee-r2'),$('#paybillsschedulepayment-r2'),
            $('#paybillauthorize'),

            $('#quickpayoptions'), $('#quickpaytodolist'), $('#quickpayrecipients'),
            $('#quickpaytransactiondetails'), $('#quickpayaddrecipient'), $('#quickpayactivity'),
            $('#quickpay-send-money-recipients'),
            $('#qpsendmoneyenter'), $('#qpsendmoneyverify'), $('#qpsendmoneyconfirm'),
            $('#quickpayrecipientdetails'), $('#quickpayeditrecipient'), $('#qprecipientsnotification'),
            $('#quickpay-request-money-recipients'),
            $('#qprequestmoneyenter'), $('#qprequestmoneyverify'), $('#qprequestmoneyconfirm'),
            $('#qppendingtransactions'), $('#qppendingtransactiondetails'), $('#qppendingcancelconfirmation'),

            $('#paycard'), $('#paycardenter'), $('#paycardselectpayto'),
            $('#paycarddate'), $('#paycardverify'), $('#paycardauthorize'),
            $('#paycardconfirm'), $('#paycardhistory'), $('#paycarddetails'),

            $('#wireindex'), $('#wireselectpayee'), $('#wireschedulepayment'),
            $('#wireverifypayment'), $('#wireconfirmdialog'), $('#wireagreement'),$('#wirecanceldialog'),
            $('#wireconfirmpayment'), $('#wire-confirm-cancel'),
            
            $('#mmpaymentactivity'), $('#mmpaymentactivitydetails'),
            $('#mmpaymentactivity-r2'), $('#mmpaymentactivitydetails-r2')
          ],
    function( $page ) {
      highlightTabs($page, ['.paytransfer-navbar-item', '.quickpay-navbar-item']);
    }
  );

  // Page init for More tab
  _.each( [ $('#more'),

            $('#atmbranchlocations'), $('#locationdetailpage'), $('#locationResults'),

            $('#contactus'), $('#get-more-contacts-list'), $('#get-more-contacts-details'), $('#smc-overview'),

            $('#alertsmenu'), $('#alertshistory'), $('#alertsmanage'), $('#alertssubscriptionupdate'),
            
            $('#disclosures'), $('#disclosure-details'),
            $('#agreementList'), $('#moreAgreementContent'),
            $('#privacymenu'), $('#privacynotice'), $('#onlineprivacypolicy'),
            
            $('#logoffconfirm'),
            
            $('#faqs'), $('#faqs-questions'), $('#faqs-question-detail')
          ],
    function( $page ) {
      highlightTabs($page, ['.more-navbar-item']);
    }
  );
  

//refresh/back button functionality - this will load 1 time when the app loads or a user hits refresh...
//if the page hash is present in the refreshRedirect object, then we redirect to whatever the correct target page is.
//"Redirect" achieved by modifying data.options.toPage value.  See pagebeforechange event in jquery docs.
// targetHash = refreshRedirect[loadedHash];

$(document).one('pagebeforechange', function(evt, data){
	if (targetHash) {
		data.toPage = $.mobile.path.parseUrl(window.location.href).hrefNoHash + targetHash;
		data.options.fromHashChange = false;
		data.options.changeHash = true;
	}
	
});

//init shutter module. It'lltake care of shuttering every page that needs to be shattered by default, and unshutter them when appropriate

  shutterManager = emb.shutterManager(emb.console, emb.pageHelper, emb.pagesConfiguration);
  shutterManager.init(emb.messages.information.requestSubmitted);
  $(window).on('pagechange', function(toPage, params){
    //fix for a defect that when user on legal agreement dialog and clicks browser back button then its rereicting to black blue screen
    //in this case should be re-directed to logon page. here there is no direct way, so have to look for hash and back button then redirect him to logon page
    if(params.options.direction === 'back'){
      emb.pageHelper().backButtonClicked(params.options);
    }
      
    // This custom event is for the observer module. We use to listen to the pageshow event, but this triggered before pagechange
    // and therefore we couldn't receive accurate analytics data on the page since it's shuttered until the shutterManager
    // unshutters it.
    var title, e = $.Event("pageStart", {timeStamp: toPage.timeStamp, target: toPage.target});
    shutterManager.processNewPage(params.toPage.attr('id'), params.options && params.options.fromHashChange);
    $(document).trigger(e);
    //ADA default focus is set to log off in voice over.setting focus to ada only title on page.
    title = params.toPage.find('div.ui-content > h2, div.unshuttered h2').first().text();
    if(title)
    {
      params.toPage.find('.header .adatitle').text(title);
    }
  });
  
});
