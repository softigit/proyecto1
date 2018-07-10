emb.service = emb.service || {};

emb.service.faqs = function(serviceLayer,urls){
  var _ = underscore;
  function loadFaqs() {
    var promise = emb.promise();
    serviceLayer.request(
      'FAQ',
      urls.faqs,
      {
        type: 'rawjson',
        documentId: 'embfaq.json'
      },
      function errorHandler( errorData ) {
        emb.console.log( 'loadFaqs error: ', errorData );
        promise.reportError( errorData );
      },
      function successHandler( responseData ) {
        emb.console.log( 'loadFaqs success: ', responseData );
        promise.reportSuccess( responseData );
      },
      {isSerial: false}
    );

    return promise;
  }  
  return {
    loadFaqs: loadFaqs
  };
};
