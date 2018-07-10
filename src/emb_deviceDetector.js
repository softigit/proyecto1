
emb.deviceDetector=function(redirectShared,device){

  //############################################################################
  //---------------------------------------------------------------------------
  //pseudo-facading just in case decide to reduce dependency between theese functions
  function getUserAgent(){
    return device.getUserAgent();
  }
  
  function getRegexes(){
    return redirectShared.userAgentRegexes;
  }
  //----------------------------------------------------------------------------

  //############################################################################
  //----------------------------------------------------------------------------
  //private
  function matches(regex){
    //!! to make sure it is casted to boolean
    return !! getUserAgent().toLowerCase().match(regex);
  }
  //----------------------------------------------------------------------------
  
  
  //############################################################################
  //----------------------------------------------------------------------------
  //public functions
  function supportsNativeMapsApps(){
    return ! matches(getRegexes().kindleFire);
  }
  
  function supportCall(){
    // This looks strange.  Here's why: 
    //  ipod contains "iphone" in its user agent string.
    //  kindle fire contains "android" in its user agent string.
    return ( !matches(getRegexes().ipod) && matches(getRegexes().iphone) ) || 
        ( !matches(getRegexes().kindleFire) && matches(getRegexes().android) );
  }
  
  function isAndroidOs(){
    return ( matches(getRegexes().android)) ||
           ( matches(getRegexes().kindleFire));
  }

  function getAndroidVersionMajor() {
    if (!isAndroidOs()) {
      return;
    } else {
      var ua = getUserAgent().toLowerCase(),
          regexes = getRegexes(),
          androidMatch = ua.match(regexes.android),
          androidVersion;

      if (androidMatch) {
        androidVersion = +(androidMatch[0].split(' ')[1].substring(0, 1));
      }

      return androidVersion;
    }
  }

  function isKindleFire(){
    return matches(getRegexes().kindleFire);
  }
  
  function isIOs(){
    return ( matches(getRegexes().iphone)) ||
           ( matches(getRegexes().ipad)) ||
           ( matches(getRegexes().ipod));
  }
  //----------------------------------------------------------------------------

  return {
    supportCall:supportCall,
    supportsNativeMapsApps:supportsNativeMapsApps,
    isAndroid: isAndroidOs,
    getAndroidVersionMajor: getAndroidVersionMajor,
    isIOS: isIOs,
    isKindleFire: isKindleFire
  };
};
