emb.promise = function(){
  
  return {
    reportSuccess: function() {},
    reportError: function() {},
    success: function(successHandler){ this.reportSuccess = successHandler; return this; },
    error: function(errorHandler){ this.reportError = errorHandler; return this; }
  };
  
};