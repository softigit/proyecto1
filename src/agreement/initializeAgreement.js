/*jslint regexp:true*/

emb.initializeAgreement = function(changePageFn, service, redirectToLogonFn) {
  delete emb.initializeAgreement;

  var _ = underscore,
      pages = {
        agreementDialog: emb.page.agreementDialog($('#agreementDialog')),
        agreementContent: emb.page.agreementContent($('#agreementContent'), emb.decorateAndDisplayAgreement),
        agreementConfirm: emb.page.agreementConfirm($('#agreementConfirm')),
        agreementList: emb.page.agreementList($('#agreementList')),
        moreAgreementContent: emb.page.moreAgreementContent($('#moreAgreementContent'), emb.decorateAndDisplayAgreement),
        privacyMenu: emb.page.privacyMenu($('#privacymenu'))
      },
      agreementService = emb.service.agreement(service, emb.urls),
      
      redirectToRootFn = function() {
        // I tried to do this pretty, but it proved very difficult without making some risky changes.
        // Instead, we'll completely reload the page to reinitialize profile.
        var reloadUrl = window.location.origin + window.location.pathname + window.location.search;
        window.location = reloadUrl;
      },
      
      goBackFn = function() {
        history.go(-1);
      },
      
      queryParameters = {
        showAcceptanceText: /\\?.*showAcceptanceText/.test(window.location.href),
        contentUrl: decodeURIComponent($.query.get('contentUrl')),
        previousContentUrl: decodeURIComponent($.query.get('previousContentUrl'))
      },

      agreementController = emb.controller.agreement( 
        pages,
        changePageFn,
        agreementService,
        emb.alert,
        redirectToRootFn,
        redirectToLogonFn,
        goBackFn,
        emb.cookieStore,
        emb.dateCalculator(),
        queryParameters
      );

  $('#agreementList').on('pagebeforeshow', function() {
    agreementController.loadAgreementList();
  });
  
  return {
    agreementController: agreementController
  };
};
