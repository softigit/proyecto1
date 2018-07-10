emb.createDeviceSignatureStore = function(){
  var _ = underscore,
      COOKIE_KEY = 'emb.deviceSig';

  function generateRandomString(){
    var str = '';
    _.times(32,function(){
      var r = Math.floor( Math.random()*16 );
      str = str + r.toString(16);
    });
    return str.toUpperCase();
  }

  function fetchDeviceSignatureFromCookie(){
    return $.cookie(COOKIE_KEY);
  }
  
  function setDeviceSignatureCookie(sig){
    $.cookie( COOKIE_KEY, sig, {
      expires: 4000, //days
      path: '/',
      secure: true
    });
  }

  function getSignature(){
    var sig = fetchDeviceSignatureFromCookie();
    if( !sig ){
      sig = generateRandomString();
      setDeviceSignatureCookie( sig );
    }
    return sig;
  } 
   
  return {
    getSignature: getSignature
  };
};
