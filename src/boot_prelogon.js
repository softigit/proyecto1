// before anything else, check to see if we're loading as part of auth redirect
(function(){
    var auth_error = $.query.get('auth_error'),
        authErrors = emb.authErrors(emb.alert),
        // TODO - can we get rid of "isRefresh"??  It looks fishy.  -Greg
        // Assume that if the location hash is set to something besides #mfa-init,
        // the user is refreshing from a different page
        isRefresh = window.location.hash !== "" 
            && window.location.hash !== "#mfa-init"
            && window.location.hash !== "#cco"
            && window.location.hash !== "#bb";

    // Only handle auth redirect here if the user isn't refreshing
    // This will fix the case where user enters the MFA flow, clicks home, and then refreshes
    if( !auth_error || isRefresh){
        return;
    }

    if(auth_error === "secauth.required") {
        window.location.hash = '#mfa-init';
    } else {//aded new parameter for cco rsa cookie. if exists then need to show different error message
        if (auth_error === "user.locked" || auth_error === "user.fraud" || auth_error === "user.inactive" || auth_error === "user.suspend" || auth_error === "user.suspicious" || auth_error === "user.lockedexp") {
          window.location = "#logonError";
        } else {//checking both cco and bb cookies
          authErrors.errorFor(auth_error, (emb.cookieStore.getCookie('emb.ccotoken') !== null || emb.cookieStore.getCookie('emb.bbtoken') !== null));
          if ( emb.qpLandingPageChecker( window.location.href ).urlContainsFlowID() ) {
              window.location.hash = "#qp";
          } else if ( emb.initializeRewards( window.location.href ).urlContainsFlowID() ) {
              window.location.hash = "#urlogon";
          } else {
              window.location.hash = "#logon";
          }
        }
    }
}());

(function(){
    function createNetworkService() {
        return emb.service(emb.CHANNEL_ID, $.ajax, emb.page.loader, $.param, $("body"));
    }

    function goToNewPageFn(url) {
        window.location = url;
    }

    function changePageFn( $toPage, addHash ) {
        var changeHash = {changeHash:addHash};
        $.mobile.changePage($toPage, changeHash);
    }

    var networkService = createNetworkService();

    $(document).ready( function() {
      
        var contentController = emb.initializeContent(changePageFn, networkService).contentController,

        agreementController = emb.initializeAgreement(changePageFn, networkService, function(){});
        
        observer = emb.observer(jQuery, window, document, networkService, false);
        
        // TODO - this should be replaced by an object literal inserted by the build
        emb.environmentConfig = emb.environment(window.location).config;
        emb.initializeGeolocation( networkService, changePageFn);
        emb.initializePreLogon( networkService, changePageFn, goToNewPageFn, contentController );
        emb.brandingHelper(emb.cookieStore).setHeaderLogoifCookieExists();
        //emb.page.refreshRedirect();
        
        // Check query string to see if we need to hide header buttons.  This is currently sent by 3rd party B2S app that manages UR redemptions.
        if (emb.features.HIDE_HEADER_BUTTONS) {
          $('[data-role="page"]').find('[data-icon="home"]').remove();
        }
    });
}());
