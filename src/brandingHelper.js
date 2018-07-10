emb.brandingHelper = function(cookieStore) {

  function showHeaderBasedOnProfile(profile){
    // if logo type is set, create cookie
    // if logo type is undefined/changed/reset, delete cookie
    if (typeof profile.logoType !== 'undefined' && profile.logoType === 'cpcLogo')
      {
        if(cookieStore.getCookie('headerLogoCookie')===null){
           cookieStore.saveCookie('headerLogoCookie', 'true',{ expires: 1000, secure: true });
            $("div.logo").addClass('logoCPC');
          }
      }
    else
      {
        cookieStore.saveCookie('headerLogoCookie', null,{ expires: -1, secure: true });
         $("div.logo").removeClass('logoCPC');
      } // end if
  } // end function

  function setHeaderLogoifCookieExists(){
    if(cookieStore.getCookie('headerLogoCookie')!==null){
      $("div.logo").addClass('logoCPC');
    }// end if
  }// end function
  
return {
  showHeaderBasedOnProfile: showHeaderBasedOnProfile,
  setHeaderLogoifCookieExists: setHeaderLogoifCookieExists
  };
};  
