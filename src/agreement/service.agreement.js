emb.service = emb.service || {};

emb.service.agreement = function(serviceLayer, urls){
  var _ = underscore;
  
  function loadAgreementContent(url) {

    var promise = emb.promise();

    serviceLayer.request(
      'Agreement Content',
      url,
      {},
      function errorHandler(errorData) {
        promise.reportError(errorData);
      },
      function successHandler(responseData) {
        promise.reportSuccess(responseData);
      },
      {
        isSerial: false,
        dataType: 'html',
        httpVerb: 'GET'
      }
    );

    return promise;
  }
  
  function acceptAgreement(code) {

    var promise = emb.promise();

    serviceLayer.request(
      'Agreement Accept',
      urls.agreementAccept,
      {code: code},
      function errorHandler(errorData) {
        promise.reportError(errorData);
      },
      function successHandler(responseData) {
        promise.reportSuccess(responseData);
      }
    );

    return promise;
  }
  
  function loadAgreementList() {

    var promise = emb.promise();

    serviceLayer.request(
      'Agreement List',
      urls.agreementList,
      {},
      function errorHandler(errorData) {
        promise.reportError(errorData);
      },
      function successHandler(responseData) {
        promise.reportSuccess(responseData);
      }
    );

    return promise;
  }
  
  return {
    loadAgreementContent: loadAgreementContent,
    acceptAgreement: acceptAgreement,
    loadAgreementList: loadAgreementList
  };
};
