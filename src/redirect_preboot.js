// redirect logic
(function(){
  var
      goToNewPageFn = function(url) {window.location = url;},     // comment this out to disable redirects
      //goToNewPageFn = function(){},                                 // comment this out to enable redirects
      userAgent = navigator.userAgent.toLowerCase(),
      redirectShared = window.redirectShared( userAgent, document.cookie ),
      redirect = window.redirect( window.location, goToNewPageFn );

  if ( redirectShared.isTablet() ) {
    redirect.redirectToCOL();
  }
  if ( !redirectShared.isEMBDevice() ) {
    if (window.location.hash && window.location.hash.indexOf('#urlogon') > -1) {
      goToNewPageFn('/notsupported.html');
    } else {
      if (window.location.hash && (window.location.hash.indexOf('#cco') > -1 || window.location.hash.indexOf('#bb') > -1)) {
        window.alert("Your device is not compatible with Chase Mobile. To see your accounts, please log on from a computer.");
      }
      redirect.redirectToMBB();
    }
  }
  if ( redirectShared.isJPMUser() ) {
    redirect.redirectToMBB();
  }
}());
