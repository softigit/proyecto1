emb.cookieStore = (function() {
  function getCookie( name ) {
    return $.cookie(name);
  }
  
  function removeCookie(name){
    $.cookie(name,null);
  }

  function saveCookie( name, value, options ) {
    $.cookie(name, value, options);
  }
  
  function areCookiesEnabled(){
    var testCookieName="emb.testCookie";
    saveCookie(testCookieName,"dummyValue",null);
    if(getCookie(testCookieName)!==null){
      removeCookie(testCookieName);
      return true;
    }else{
      return false;
    }
  }
  
  function deleteSessionCookies() {
    $.cookie("SMSESSION", null, {path: "/", domain: ".chase.com", secure: "true", expires: -5});
    $.cookie("auth-user-info", null, {path: "/", domain: ".chase.com", secure: "true", expires: -5});
    $.cookie("jisi.web.cacheId", null, {path: "/", domain: ".chase.com", secure: "true", expires: -5});
    $.cookie("csrfTokenCookie", null);
    $.cookie("emb.agreementdialog", null);
  }

  return {
    getCookie: getCookie,
    saveCookie: saveCookie,
    deleteSessionCookies: deleteSessionCookies,
    areCookiesEnabled: areCookiesEnabled,
    removeCookie: removeCookie
  };
}());  