if( typeof emb.controller === 'undefined' ) {emb.controller = {};}

emb.controller.logon = function( pages, services, changePageFn, loadNewPageFn, cookieStore, alertFn, redirect, qpLandingPageChecker, isNextTokenRequired , deviceDetector, initializeRewards){
  var _              = underscore,
      splashChecker  = emb.splashChecker(services.splash),
      authService    = services.auth,
      credentials    = {},
      emailContacts  = [],
      phoneContacts  = [],
      dateCalculator = emb.dateCalculator(),
      device         = emb.device(),
      ccoTokenVal    = "CCOToken",
      ccoTokenKey    = "emb.ccotoken",
      bbTokenVal     = "BBToken",
      bbTokenKey     = "emb.bbtoken",
      logonTokenKey  = null;

  function initHomePage() {
    var userAgent = device.getUserAgent().toLowerCase();
    pages.home.makeSureCopyRightDateIsAccurate((new Date ()).getUTCFullYear());

    if ( userAgent.contains('iphone') || userAgent.contains('ipod') ) {
      pages.home.displayAppLogo( emb.urls.iPhoneApp, 'ios', 'iphone_logo.png' );
    } else if ( userAgent.contains('ipad') ) {
      pages.home.displayAppLogo( emb.urls.iPadApp, 'ios', 'iphone_logo.png' );
    //deferred until we get kindle fire assets
    //} else if ( deviceDetector.isKindleFire() ){
    //  pages.home.displayAppLogo( emb.urls.androidApp, 'kindle', 'kindle_logo.gif' );
    } else if ( userAgent.contains('android') ) {
      pages.home.displayAppLogo( emb.urls.androidApp, 'android', 'android_logo.png' );
    } else {
      pages.home.removeAppLogo();
    }
  }

  function getLogonTokenKey(logonPage){
    switch(logonPage){
      case pages.ccoLogon:
        return ccoTokenKey;
      case pages.bbLogon:
        return bbTokenKey;
    }
    return null;
  }

  function getLogonTokenVal(tokenKey){
    switch(tokenKey){
      case ccoTokenKey:
        return ccoTokenVal;
      case bbTokenKey:
        return bbTokenVal;
    }
    return null;
  }

  function getSavedUserId() {
    return cookieStore.getCookie('emb.userId');
  }

  function isUserIdSaved() {
    emb.console.debug("user id from cookie: " + cookieStore.getCookie('emb.userId'));
    return getSavedUserId() !== null;
  }

  //retireves the saved token cookie if any
  function getSavedToken(tokenKey){
    return cookieStore.getCookie(tokenKey);
  }

  //check query string and cookie
  function isCustomerUsingToken(tokenKey){
    emb.console.debug("cco token from cookie: " + getSavedToken(tokenKey));
    return ((getSavedToken(tokenKey) === getLogonTokenVal(tokenKey)));
  }

  function shouldShowFirstTokenField(logonPage) {
    return (logonPage.getTokenSelection()==="on");
  }

  function setTokenSliderSelection(logonPage)
  {
    //if cco rsa token was already saved in cook then set slider to 'ON' else set to 'OFF'
    if(isCustomerUsingToken(getLogonTokenKey(logonPage))){
      logonPage.setTokenSelection( "on" );
      logonPage.toggleSecondToken(isNextTokenRequired);
    }
    else{
      logonPage.setTokenSelection( "off" );
    }
    //reset token fields
    logonPage.setToken( null );
    logonPage.setNextToken( null );
  }

  function initLogonPage(logonPage) {
    credentials = {};
    // read from cookie, set slider
    if ( isUserIdSaved() ) {
      logonPage.setUserIdSelection( "on" );
      logonPage.setTitle( 'Returning User Log On' );
      logonPage.setUserId( getSavedUserId() );
    } else {
      logonPage.setUserIdSelection( "off" );
      logonPage.setTitle( 'Log On' );
      logonPage.setUserId( null );
    }
    logonPage.setPassword( null );

    //added for ADA compliance - story#8575
    logonPage.makeSlidersADACompliant();
  }

  function initLogonPageForToken(logonPage) {
    initLogonPage(logonPage);
    //call this to set the slider and cco rsa input depends on cookie
    setTokenSliderSelection(logonPage);

    logonPage.toggleFirstToken( shouldShowFirstTokenField(logonPage) );
    
    logonPage.onTokenSliderTouched( function() {
      logonPage.toggleFirstToken( shouldShowFirstTokenField(logonPage) );
    });
  }
  
  function resetCredentials() {
    credentials = {};
  }

  function initQPLandingPage() {
    resetCredentials();
    
    // read from cookie
    if ( isUserIdSaved() ) {
      pages.qpLanding.setUserId( getSavedUserId() );
    } else {
      pages.qpLanding.setUserId( null );
    }
    pages.qpLanding.setPassword( null );
  }

  function initURLogonPage(page) {
    resetCredentials();
    // read from cookie
     if ( isUserIdSaved() ) {
      page.setURUserIdSelection( true );
      page.setUserId( getSavedUserId() );
    } else {
      page.setUserIdSelection( false );
      page.setUserId( null );
    }
    page.setPassword( null );
  }

  function initMfaChoosePage() {
    pages.mfaChoose.clear();
    pages.mfaChoose.updateContactList(phoneContacts, emailContacts);
  }

  function onBeforeLogonShown( logonPage ){
    if( ! cookieStore.areCookiesEnabled() ){
      alertFn( emb.messages.warnings.cookiesDisabled );
      changePageFn( pages.home.$page, true );
    }
	initLogonPage( logonPage );
  }
  
  function resetMfaFields() {
    pages.mfaEnter.setPassword(null);
    pages.mfaEnter.setIdCode(null);
    pages.mfaEnter.setToken(null);
  }

  function separateEmailFromPhoneContacts(allContacts) {
    _.each(allContacts, function(contact) {
      if (contact.type === "EMAIL") {
        emailContacts.push(contact);
      } else if (contact.type === "PHONE") {
        phoneContacts.push(contact);
      }
    });
  }

  function goBackToLogonPage( logonPage ) {
    changePageFn( logonPage.$page, true );
    logonPage.setPassword("");
  }

  function getSignature() {
    // This signature format is required by auth
    return '{"navigator":{},"plugins":[{"name":"MOBID","version":"' + emb.createDeviceSignatureStore().getSignature() + '"}],"screen":{},"extra":{}}';
  }

  function getHiddenFormInputs(logonPage) {
    var hiddenInputs = {
      auth_passwd: credentials.password,
      auth_siteId: emb.CHANNEL_ID,
      auth_tokencode: credentials.token,
      auth_contextId: 'login',
      auth_deviceId: cookieStore.getCookie(emb.environmentConfig.deviceIdCookie),
      auth_deviceSignature: getSignature()
      },
      dest;
    
    if (logonPage && logonPage.getToken() && logonPage.getToken().length > 0) {
      hiddenInputs.auth_siteId = 'MER';
    }

    if ( credentials.addFlowID ) {
      hiddenInputs.auth_externalData = 'flowID=quickpay';
    } else if (credentials.addURFlowID) {
      dest = $.query.get('urlogon?dest');
      if(dest && dest !=="") {
        cookieStore.saveCookie('emb.urDest', dest);
      }
      hiddenInputs.auth_externalData = 'flowID=ultimaterewards';
    }

    if (credentials.userId) {
      hiddenInputs.auth_userId = credentials.userId;
    }

    if (credentials.idCode) {
      hiddenInputs.auth_otp = credentials.idCode;
      hiddenInputs.auth_passwd_org = credentials.password;
    }
    if(credentials.nextToken){
      hiddenInputs.auth_nexttokencode = credentials.nextToken;
    }

    if (credentials.prefix) {
      hiddenInputs.auth_otpprefix = credentials.prefix;
      hiddenInputs.auth_otpreason = "2";
    }

    return hiddenInputs;
  }

  function setTokenCookie(logonPage, tokenKey, tokenVal, otherTokenKey){
    if (logonPage.getTokenSelection() === 'on') {
      cookieStore.saveCookie(tokenKey, tokenVal, {expires: dateCalculator.yearsFromNow(3)} ); 
    } else {
      cookieStore.saveCookie(tokenKey, null);
    }
    //this is to invalidate other cookie. means if CML login then business cookie should be invalidated and vice versa
    cookieStore.saveCookie(otherTokenKey, null);
  }

  // This gets called just before the logon form is posted to Auth.
  function prepareForAuthentication( logonPage ) {
    //validating user-name, password and token fields
    if(isNextTokenRequired && !logonPage.getNextToken()){//validate second token 
      logonPage.showError("Please enter a User ID, Password and token codes to continue.");
      return false;
    }else if (logonPage.getTokenSelection() === 'on' && !logonPage.getToken()) {//validate first token
      logonPage.showError("Please enter a User ID, Password and token code to continue.");
      return false;
    }else if ( (!logonPage.getUserId()) || (!logonPage.getPassword()) ) {
      logonPage.showError("Please enter a User ID and Password to continue.");
      return false;
    }

    credentials.userId = logonPage.getUserId();
    credentials.password = logonPage.getPassword();
    credentials.token = logonPage.getToken();
    //check if second token required to send to auth
    if(isNextTokenRequired){
      credentials.nextToken = logonPage.getNextToken();
    }
    
    if ( logonPage !== pages.qpLanding ) {
      if (logonPage.getUserIdSelection() === 'on') {
        cookieStore.saveCookie('emb.userId', credentials.userId, {expires: dateCalculator.yearsFromNow(3)} );
      } else {
        cookieStore.saveCookie('emb.userId', null);
      }
    }
    
    if (logonPage === pages.ccoLogon) {
      //setting the token cookie if user selects token slider
      //this will be useful to hide or show the token input
      //4th param is to invalidate other cookie. means if CML login then business cookie should be invalidated and vice versa
      setTokenCookie(logonPage, ccoTokenKey, ccoTokenVal, bbTokenKey);
    }

    //busines banking cookie set
    if (logonPage === pages.bbLogon) {
      //setting the token cookie if user selects token slider
      //this will be useful to hide or show the token input
      setTokenCookie(logonPage, bbTokenKey, bbTokenVal, ccoTokenKey);
    }

    if (logonPage === pages.urLogon) {
      if(pages.urLogon.$page.find( "[name='logon-slider']" ).prop('checked') ) {
        cookieStore.saveCookie('emb.userId', credentials.userId, {expires: dateCalculator.yearsFromNow(3)} );
      } else {
        cookieStore.saveCookie('emb.userId', null);
      }
    }

    // Need to save a cookie regardless so that we know what the user's ID is
    // in case we get MFA'd (this one we will delete after logging in, though).
    cookieStore.saveCookie('emb.tempUserId', credentials.userId, {expires: dateCalculator.minutesFromNow(10)} );

    logonPage.pageHelper.populateFormWithHiddenInputs(getHiddenFormInputs( logonPage ), emb.urls.login);
    
    return true;
  }

  function isJPMUser( data ) {
    return data.errors[0].code === 3834;
  }

  function handleJPMUsers() {
    if ( qpLandingPageChecker.urlContainsFlowID() ) {
      redirect.redirectToMBBQPLandingPage();
    } else {
      redirect.redirectToMBBLogin();
    }
  }

  function prepareForMfa(spid) {
    if (_.isEmpty(emailContacts) && _.isEmpty(phoneContacts)) {
      var otpContactPromise = authService.requestOTPContactsAndPrefix( spid ),
          logonPage = ( qpLandingPageChecker.urlContainsFlowID() ) ? pages.qpLanding : ( initializeRewards.urlContainsFlowID() && emb.features.REDEEM_REWARDS ) ? pages.urLogon : pages.logon;

      credentials.userId = cookieStore.getCookie('emb.tempUserId');

      otpContactPromise.onSuccess( function(prefix, contacts){
        pages.mfaInit.showContent();
        emailContacts = [];
        phoneContacts = [];
        emb.console.debug('OTPContacts success');
        credentials.prefix = prefix;
        separateEmailFromPhoneContacts(contacts);
        pages.logon.setUserId(null);
        pages.logon.setPassword(null);
        initMfaChoosePage();
      });
      otpContactPromise.onError( function(message, data){
        emb.console.debug('OTPContacts error');
        if(data && data.errors && data.errors[0]) {
          if ( isJPMUser( data ) ) {
            handleJPMUsers( data );
            return;
          } else {
            logonPage.showError(data.errors[0].code + "\n" + data.errors[0].message);
          }
        }
        goBackToLogonPage( logonPage );
      });
      otpContactPromise.onFailure( function(){
        emb.console.debug('OTPContacts fail'); 
        alertFn( emb.messages.errors.signalServiceError );
        goBackToLogonPage( logonPage );
      });
    }
  }
  
  //this takes user to previsoulsy used logon page
  function showCorrectLogonPage() {
    if(initializeRewards.urlContainsFlowID()){
      changePageFn('#urlogon');
    } else if (isCustomerUsingToken(ccoTokenKey)) {
      changePageFn('#cco');
    }else if (isCustomerUsingToken(bbTokenKey)) {
      changePageFn('#bb');
    }
  }

  function showCorrectErrorPage(auth_error) {
    var index = +deviceDetector.supportCall(),
        errorsObject = emb.messages.logonErrors[index].user[auth_error.substr(5)];
    if (errorsObject) {
      pages.logonError.setTitle(errorsObject.title);
      pages.logonError.setMessage(errorsObject.message);
      if (errorsObject.number) {
        pages.logonError.setNumber(errorsObject.number.label, errorsObject.number.digits);
      }
      if (errorsObject.number2) {
        pages.logonError.setSecondCallOption(errorsObject.number2.label, errorsObject.number2.digits);
      }
      pages.logonError.setCancel(errorsObject.secondaryButton);
    }
  }
  
  splashChecker.requestSplashInfo();
  splashChecker.lookupMainOutageSplash(function(splashUrl){
    if( splashUrl ){
      loadNewPageFn(splashUrl);
    }
  });

  function trySubmitLogonFrom( page ) {
    // hadToWait lets us know if we had to wait for the splash service to return
    // before submiting the form. If so then we need to manually submit the form
    return splashChecker.lookupMainOutageSplash(function(splashUrl, hadToWait){
      if( !splashUrl && prepareForAuthentication( page )){
        changePageFn( pages.loggingOn.$page, false );
        if (hadToWait) {
          // manually submit the form. First we must change the submit handler
          page.$page.find('form').unbind('submit').submit(function(){return true;});
          page.$page.find('form').submit();
          return;
        }
        return true;
      }
      return false;
    }, true);
  }
  
  _.each( [ pages.logon, pages.qpLanding, pages.ccoLogon, pages.bbLogon ], function( logonPage ) {
    logonPage.onLogonSubmit(function() {
      credentials.addFlowID = ( logonPage === pages.qpLanding );
      return trySubmitLogonFrom( logonPage );
    });
  });

  _.each( [ pages.logon, pages.qpLanding, pages.ccoLogon, pages.bbLogon], function( logonPage ) {
    logonPage.$page.bind( 'pagebeforeshow', function(){
      onBeforeLogonShown(logonPage);
    });
  });

  if(emb.features.REDEEM_REWARDS) {
    pages.urLogon.onLogonSubmit(function() {
      credentials.addURFlowID = true;
      return trySubmitLogonFrom( pages.urLogon );
    });

    pages.urLogon.$page.bind( 'pagebeforeshow', function(){
      onBeforeLogonShown(pages.urLogon);
    });
  }

  pages.mfaInit.onPageShow( function( spid ) {
    prepareForMfa(spid);
  });

  //this is required to show token or not in MFA flow.
  //here we dont know from which login we came to mfa. so to display token on mfa we do check any cookie of cco or bb present.
  //if yes then display token
  function isTokenPresent(){
    return !!(getSavedToken(ccoTokenKey) || getSavedToken(bbTokenKey));
  }

  pages.mfaEnter.onPageShow( 
    function initMfaEnterPage() {
      //if cookie token saved then show mfa token field else hide
      pages.mfaEnter.toggleToken(isTokenPresent());   
  });

  pages.mfaChoose.onContactMethodTouched(function(contactId, method) {
    var promise;
    emb.console.log("contact touched: " + contactId + " " + method);

    promise = authService.requestOTP(credentials.userId, contactId, method);

    promise.success( function(response) {
      credentials.prefix = response.prefix;
      changePageFn( pages.mfaEnter.$page, true );
    });
    promise.error( function(errorText) {
      pages.mfaChoose.showError(errorText);
    });
  });

  pages.mfaEnter.onMfaSubmit(function(){
    emb.console.log("MFA submit clicked");

    if ( (!pages.mfaEnter.getIdCode()) || (!pages.mfaEnter.getPassword()) ) {
      pages.mfaEnter.showError("Please enter an Identification Code and Password to continue.");
      return false;
    }else if (isTokenPresent() && !pages.mfaEnter.getToken()) {
      pages.mfaEnter.showError("Please enter a token to continue.");
      return false;
    }

    credentials.addFlowID = qpLandingPageChecker.urlContainsFlowID();
    credentials.addURFlowID = initializeRewards.urlContainsFlowID();
    credentials.idCode = pages.mfaEnter.getIdCode();
    credentials.password = pages.mfaEnter.getPassword();
    credentials.token = pages.mfaEnter.getToken();

    pages.mfaEnter.pageHelper.populateFormWithHiddenInputs(getHiddenFormInputs(pages.mfaEnter), emb.urls.login);
    resetMfaFields();

    return true;
  });

  function qpBankRedirect(e) {
    var selectedValue = e.target.value;
    
    emb.nonBlockingAlert(   "",
                            "<span class='bold'>"+emb.messages.information.cxcRedirectTitle + ":" +
                            "</span> " + emb.messages.information.cxcRedirectMessage,
                            "Cancel",
                            "Proceed",
                            function(){
                                $('#bankredirect').prop('selectedIndex',0).selectmenu('refresh', true);
                                changePageFn( pages.qpCxcLogon.$page );
                                
                            },
                            function(){ 
                                if (selectedValue !== "#") {
                                  window.location.href = selectedValue;
                                }
                            }
    );
  }

  return {
    initHomePage: initHomePage,
    initLogonPage: initLogonPage,
    initLogonPageForToken: initLogonPageForToken,
    initURLogonPage: initURLogonPage,
    initMfaChoosePage: initMfaChoosePage,
    initQPLandingPage: initQPLandingPage,
    resetMfaFields: resetMfaFields,
    resetCredentials: resetCredentials,
    prepareForMfa: prepareForMfa,
    showCorrectLogonPage: showCorrectLogonPage,
    showCorrectErrorPage: showCorrectErrorPage,
    qpBankRedirect: qpBankRedirect
  };
};
