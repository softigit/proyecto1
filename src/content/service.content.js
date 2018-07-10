emb.service = emb.service || {};

emb.service.content = function(serviceLayer,urls) {
  var _ = underscore;

  // TODO: Figure out if we need to remove superfluous data from the POST request in content service. [Dan]
  function loadPrivacyNotice() {
    var promise = emb.promise();
    serviceLayer.request(
     'Privacy Notice',
      urls.privacyNotice,
      {
        type: 'rawjson',
        documentId: 'privacyNoticeMobile.htm'
      },
      function errorHandler(errors) {
        promise.reportError(errors); 
      },
      function successHandler(responseData){ 
        emb.console.log("privacy notice success");
        promise.reportSuccess(responseData);
      },
      {
        dataType: 'text',
        isSerial: false
      }
    );
    
    return promise;
  }

  function loadCPCDisclosureContent(documentId) {
    var promise = emb.promise();
    serviceLayer.request(
     'CDC Disclosure Content',
      urls.privacyNotice,
      {
        type: 'rawjson',
        documentId: documentId
      },
      function errorHandler(errors) {
        promise.reportError(errors);
      },
      function successHandler(responseData){
        emb.console.log("CPC disclosure content success");
        promise.reportSuccess(responseData);
      },
      {
        dataType: 'text',
        isSerial: false
      }
    );
    
    return promise;
  }

  function loadHolidays() {
    var promise = emb.promise();
    serviceLayer.request(
     'Holidays',
      urls.holidays,
      {},
      function errorHandler(errors) {
        promise.reportError(errors); 
      },
      function successHandler(responseData){ 
        var holidayDates = _.map( responseData.holidays, Date.createFrom );
        promise.reportSuccess(holidayDates);
      },
      {displayScreenBlocker: false}
    );
    
    return promise;
  }

  function loadGetMoreContacts() {
    var promise = emb.promise();
    serviceLayer.request(
      'Get More Contacts',
      urls.contactUsGetMoreContacts,
      {
        type: 'rawjson',
        documentId: 'embcontactus.json'
      },
      function errorHandler( errorData ) {
        emb.console.log( 'loadGetMoreContacts error: ', errorData );
        promise.reportError( errorData );
      },
      function successHandler( responseData ) {
        emb.console.log( 'loadGetMoreContacts success: ', responseData );
        promise.reportSuccess( responseData.ContactList );
      },
      {isSerial: false}
    );

    return promise;
  }

  function loadDisclosures() {
    var promise = emb.promise();
    serviceLayer.request(
      'Disclosures',
      urls.disclosures,
      {version: 'v20120715'},//this version is required to unfilter prepaid cards in accounts list
      function errorHandler(errors) {
        promise.reportError(errors);
      },
      function successHandler(responseData){ 
        emb.console.log("disclosures success");
        promise.reportSuccess( responseData.disclosures );
      }
    ); 
    return promise;
  }

  function requestPaymentStatusText( ) {
    var promise = emb.promise();
    serviceLayer.request(
     'Picklist',
      urls.picklist,
      {
        listKey:"content-list"
      },
      function errorHandler(errors) {
        promise.reportError(errors); 
      },
      function successHandler(responseData){ 
        emb.console.log("warning code details retrieved");
        promise.reportSuccess(responseData);
      }
    ); 
    
    return promise;
  }

  function getPaymentStatusText(warningCode){
    var promise=emb.promise();
    requestPaymentStatusText()
    .success(
      function(responseData){
        _.find(responseData.contentList,
          function(item){
            if(item.code===warningCode){
              promise.reportSuccess(item.content);
              return true;
            }
            return false;
          }
        );
      }
    )
    .error(
      function(e){
        promise.reportError(e);
      }
    );
    return promise;
  }

  function loadHtmlContent(url) {
    var promise = emb.promise();
    serviceLayer.request(
      'HTML Content',
      url,
      {},
      function errorHandler(errors) {
        promise.reportError(errors);
      },
      function successHandler(responseData){ 
        promise.reportSuccess( responseData );
      },
      {dataType: 'html'}
    ); 
    return promise;
  }

  return {
    loadPrivacyNotice: loadPrivacyNotice,
    loadCPCDisclosureContent:loadCPCDisclosureContent,
    loadHolidays: loadHolidays,
    loadGetMoreContacts: loadGetMoreContacts,
    loadDisclosures: loadDisclosures,
    requestPaymentStatusText: requestPaymentStatusText,
    getPaymentStatusText: getPaymentStatusText,
    loadHtmlContent: loadHtmlContent
  };
};
