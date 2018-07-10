/*jslint regexp:true*/
window.redirect = function( currentLocation, newPageFn ) {
  var currentHostname = currentLocation.hostname,
      currentHref = currentLocation.href;

  function noRedirect() {
    return (/\\?.*noredirect/).test(currentHref);
  }
  
  function redirectToChaseSite( hostPrefix, path, overrideNoRedirect ) {
    var hostArray = currentHostname.split( '.' ),
        env = hostArray[ 0 ].split( /^m(q|ist)(\d)$/ ),
        envType = (env.length > 1) ? env[1].substring( 0, 1 ) : '',
        envNum = (env.length > 1) ? env[2] : '',
        domain = ( hostArray.length === 1 ) ? hostArray[ 0 ] : hostArray.slice( 1 ).join( '.' ),
        newHost = hostPrefix + envType + envNum,
        probablyOnLocalhost = hostArray.length === 1;

    path = path || '';

    if((!noRedirect() || overrideNoRedirect) && !probablyOnLocalhost) {
      newPageFn( 'http://' + newHost + '.' + domain + path );
    }
  }
  //mobilebanking
  function redirectToMBB() {
    redirectToChaseSite( 'www' );
  }
//mobilebanking
  function redirectToMBBLogin() {
    redirectToChaseSite( 'www', '/Public/Home/LogOnJp' );
  }

  function redirectToCOL() {
    redirectToChaseSite( 'chaseonline' );
  }
//mobilebanking
  function redirectToMBBAccounts( withFlowID ) {
    if ( withFlowID ) {
      redirectToChaseSite( 'www', '/Secure/Accounts/Index?flowID=quickpay' );
    } else {
      redirectToChaseSite( 'www', '/Secure/Accounts/Index' );
    }
  }
//mobilebanking
  function redirectToMBBQPLandingPage() {
    redirectToChaseSite('www', '/public/Home/LogOnJP?qp_landing=true');
  }
  
  function redirectToSmc() {
    redirectToChaseSite('messagecenter', '/smcPortal/web/user/session/SSOLogin.jsp?channelId=MOE', true);
  }
  
  return {
    redirectToMBB: redirectToMBB,
    redirectToMBBLogin: redirectToMBBLogin,
    redirectToCOL: redirectToCOL,
    redirectToMBBAccounts: redirectToMBBAccounts,
    redirectToMBBQPLandingPage: redirectToMBBQPLandingPage,
    redirectToSmc: redirectToSmc
  };
};
