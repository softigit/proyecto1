emb.service = emb.service || {};

emb.service.splash = function(serviceLayer,urls){
  var _ = underscore;

  function requestSplashInfo(){
    var promise = emb.promise(),
        useCache = false, 
        displayScreenBlocker = false;

    serviceLayer.request(
     'Splash',
      urls.splash,
      {},
      function errorHandler(errors) {
        promise.reportError(errors); 
      },
      function successHandler(responseData){ 
        // Should we parse raw response into something more useful?
        promise.reportSuccess(responseData);
      },
      {
        displayScreenBlocker: false,
        isSerial: false
      }
    );
    
    return promise;
  }

  return {
    requestSplashInfo: requestSplashInfo
  };

};
