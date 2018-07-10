(function() {
  
  function createAuthService( networkService ) {
    return emb.service.auth( networkService, emb.urls, emb.CHANNEL_ID, emb.createDeviceSignatureStore(), emb.cookieStore);
  }
  
  emb.initializePreLogon = function( networkService, changePageFn, goToNewPageFn, contentController ){
    
    var auth_error = $.query.get('auth_error'),
    pages = {
          home:      emb.page.home( $("#home") ),
          logon:     emb.page.logon( $("#logon") ),
          qpLanding: emb.page.logon( $("#qp") ),
          qpCxcLogon: emb.page.logon( $("#qpselectbank") ),
          ccoLogon:  emb.page.logon( $('#cco') ),
          bbLogon:  emb.page.logon( $('#bb') ),
          loggingOn: emb.page.loggingOn( $("#logging-on") ),
          mfaInit:   emb.page.mfaInit( $("#mfa-init") ),
          mfaChoose: emb.page.mfaChoose( $("#mfachoose") ),
          mfaEnter:  emb.page.mfaEnter( $("#mfaentercode") ),
          urLogon: emb.page.logon( $("#urlogon") ),
          logonError: emb.page.logonError( $('#logonError'))
        },
    deviceDetector = emb.deviceDetector( window.redirectShared(), emb.device() ),
    dateCalculator = emb.dateCalculator(),
    initializeRewards = emb.initializeRewards( window.location.href ),
    services = {
          auth:   createAuthService( networkService ),
          splash: emb.service.splash( networkService, emb.urls )
        },
 
    logonController = emb.controller.logon(
          pages,
          services,
          changePageFn,
          goToNewPageFn,
          emb.cookieStore,
          emb.alert,
          window.redirect( window.location, goToNewPageFn ),
          emb.qpLandingPageChecker( window.location.href ),
          auth_error === "rsa.secondcoderequired", //checking if redirect happned because of second rsa token required
          deviceDetector,
          initializeRewards,
          auth_error
        );

    logonController.initHomePage();
    logonController.initLogonPage(pages.logon);
    logonController.initQPLandingPage();
    //initialize CCO token login page
    logonController.initLogonPageForToken(pages.ccoLogon);
    //initialize business banking login page
    logonController.initLogonPageForToken(pages.bbLogon);
    

    $('#logon').on('pagebeforeshow', function() {
      logonController.resetCredentials();
      // added this line, trying to reduce cache id errors (2888)
      emb.cookieStore.deleteSessionCookies();
      logonController.showCorrectLogonPage();
    });

    $('#qp').on('pagebeforeshow', function() {
      emb.cookieStore.deleteSessionCookies();
    });

    if(emb.features.REDEEM_REWARDS) {
      $('#urlogon').on('pagebeforeshow', function() {
        emb.cookieStore.deleteSessionCookies();
        //Always initialise the urLogon cookie to false
        //emb.cookieStore.saveCookie('emb.urLogon', false );
      });
      logonController.initURLogonPage(pages.urLogon);
    } else {
      $("#urlogon").remove(); // remove the urlogon html from DOM 
    }

    $('#mfaentercode').on('pagehide', function() {
      logonController.resetMfaFields();
    });

    $('#bankredirect').on('change', function(e){
      logonController.qpBankRedirect(e);
    });
    
    $('#logonError').on('pagebeforeshow', function() {
      logonController.showCorrectErrorPage(auth_error);
    });
  };
}());
