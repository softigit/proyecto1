emb.createAsyncLookup = function(){
  var _ = underscore,
      lookupReturned = false,
      lookupResult = null,
      callbacks = [],
      loginCallback;

  function rememberCallback(callback){
    callbacks.push(callback);
  }

  function fireAllWaitingCallbacks(){
    if (loginCallback) {
      loginCallback (lookupResult, true);
    }
    _.each( callbacks, function(callback){
      callback(lookupResult);  
    });
  }

  function lookupThen(callback){
    if( lookupReturned ){
      return callback(lookupResult);
    }else{
      return rememberCallback(callback);
    }
  }
  
  function callbackForPrelogonSplash(callback){
    if ( lookupReturned ) {
      return callback(lookupResult);
    } else {
      loginCallback = callback;
    }
  }

  function lookupReturnedWith(result){
    lookupReturned = true;
    lookupResult = result;
    fireAllWaitingCallbacks();
  }
  
  function clearLookupResult() {
    lookupResult = null;
    lookupReturned = false;
  }
  
  function hasResult() {
    return lookupReturned;
  }

  return {
    lookupThen: lookupThen,
    callbackForPrelogonSplash: callbackForPrelogonSplash,
    lookupReturnedWith: lookupReturnedWith,
    clearLookupResult: clearLookupResult,
    hasResult: hasResult
  };
};
