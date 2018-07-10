/*jslint regexp:true*/
/*
NOTE: this file is shared across EMB and MBB to ensure they are both using the same browser detection logic
to prevent circular redirects.

NO JQUERY OR UNDERSCORE IN HERE PLEASE!!!!!
*/
window.redirectShared = function( userAgent, documentCookie ) {
  
  var userAgents ={
        iphone: /iphone os [4-9]/,                      // iPhone running iOS >=4.0
        // WARNING - ipod also contains "iphone" in its user agent string.
        ipod: /ipod.*os [4-9]/,                         // iPod running iOS >= 4.0 
        android: /android (2\.[1-9]|[3-9])/,                  // Android running OS >=2.1 (EXCEPT KINDLE FIRE)
        ipad: /ipad.*cpu os [4-9]/,                           // iPad running iOS >=4.0
        kindleFire: /kindle fire|silk/                        // Kindle fire
      },
      embUserAgentExpressions = [
        userAgents.iphone,
        userAgents.ipod,
        userAgents.android,
        userAgents.ipad,
        userAgents.kindleFire
      ],
      tabletUserAgentExpressions = [
        //ipad/                          // see if you can figure this one out
        // TODO: figure out how to tell an android phone from a tablet (or stop caring)
      ];
  
  
  // since we can't use jquery here, i borrowed (kinda) this from http://www.w3schools.com/JS/js_cookies.asp
  function getCookie(c_name) {
    var i,x,y,ARRcookies=documentCookie.split(";");
    for (i=0;i<ARRcookies.length;i+=1) {
      x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
      y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
      x=x.replace(/^\s+|\s+$/g,"");
      if (x.toLowerCase()===c_name) {
        return y;
      }
    }
  }
  
  function isJPMUser() {
    var brandingCookie = getCookie( 'branding' );
    return ( !!brandingCookie && brandingCookie === 'jp' );
  }
  
  function existsRegexMatchInUserAgent( expressionsArray ) {
    var i;
        
    for ( i = 0; i < expressionsArray.length; i += 1 ) {
      if ( userAgent.match( expressionsArray[ i ] )) {
        return true;
      }
    }
    return false;
  }    
    
  function isEMBDevice() {
    return existsRegexMatchInUserAgent( embUserAgentExpressions );
  }
  
  function isTablet() {
    return existsRegexMatchInUserAgent( tabletUserAgentExpressions );
  }
  
  return {
    isJPMUser: isJPMUser,
    isEMBDevice: isEMBDevice,
    isTablet: isTablet,
    userAgentRegexes: userAgents
  };
  
};
