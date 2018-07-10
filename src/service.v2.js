emb.service = function(channel_id, ajaxFn, pageLoader, paramFn, domObj){
  var _ = underscore,
    sessionManager,
    isRunning = false,
    ajaxQueue = [],
    currentRequests = 0; 

  function callNextAjaxRequest() {
    if (ajaxQueue.length > 0) {
      ajaxQueue.shift()();
      emb.console.log('ajaxQueue: pending = ' + ajaxQueue.length);
    } else {
      isRunning = false;
    }
  }

  function ajaxRequest(requestNameForLog, url, requestData, errorCallback, successCallback, settings) {
    var headers = {},
      jqXHR,
      errorHandled,
      handleError = function (text, data) {
        if (domObj) {
          domObj.trigger("serviceError", data);
        }
        errorHandled = true;
        errorCallback(text, data);
      },
      qs = paramFn(requestData);

    if (!settings.sendJSON && settings.sendCommonParams){

      requestData = _.extend({
          'type': 'json',
          'version': '1',
          'cache': true,
          'applId': 'GATEWAY',
          'channelId': channel_id
        }, requestData);

    } else if (settings.sendJSON) {

      headers = {
        'Cache-Control': "no-cache",
        'Content-Type': "application/json",
        'Channel-Id': channel_id
      };
    }

    emb.console.debug(requestNameForLog + ': sending request', {url: url, requestData:requestData, headers: headers});
    emb.console.debug(requestNameForLog + ': Request Details for GWO', {dateTimeUTC: new Date().toUTCString(), cacheId: $.cookie("jisi.web.cacheId"), jsonString: JSON.stringify(requestData), url: url + '?' + qs});

    //this is to bypass when the service call is for analytics as we should not reset timer for analytics
    if (sessionManager && emb.urls.pingA !== url) {
      sessionManager.reset();
    }

    jqXHR = ajaxFn( url, {
      type: settings.httpVerb,
      dataType: settings.dataType,
      data: settings.sendJSON ? JSON.stringify(requestData) : requestData,
      processData: !settings.sendJSON,
      headers: headers,
      success: function(data) {


        emb.console.debug(requestNameForLog + ': Response Details for GWO', {url: url, dateTimeUTC: new Date().toUTCString(), rawResponse: JSON.stringify(data)});

        if(data && data.errors && data.errors.length > 0 ) {
          // Get around the really irritating cache id error
          if (data.errors[0] && data.errors[0].code && data.errors[0].code === 2888) {
            $.cookie('jisi.web.cacheId', null);
          }

          emb.console.error(requestNameForLog + ': response contained non-empty errors array', data);
          emb.console.debug(requestNameForLog + ': first error: ' + data.errors[0].message);
          handleError(data.errors[0].message, data);
          return;
        }
        
        if (settings.dataType !== 'html') {
          emb.console.debug(requestNameForLog + ': request succeeded', data);
        }
        
        successCallback(data);
      },
      error: function( obj, statusText, errorThrown ) {

        emb.console.error(requestNameForLog + ": failure calling this service:", url);

        handleError(emb.messages.errors.signalServiceError, obj);
      },
      complete: function(obj, textStatus) {
        currentRequests -= 1;
        if (!errorHandled && (textStatus === 'abort' || textStatus === 'timeout')) {
          handleError(textStatus);
        }

        if (settings.displayScreenBlocker) {
          pageLoader.stopLoading();
        }

        if (settings.isSerial) {
          callNextAjaxRequest();
        }
      }
    });

    return jqXHR;
  }

  function request(requestNameForLog, url, requestData, errorCallback, successCallback, optionalParams) {
    var defaults = {
          displayScreenBlocker: true,
          dataType: 'json',
          sendJSON: false,
          isSerial: true,
          sendCommonParams: true,
          httpVerb: 'POST'
        },
        settings = emb.utils.inspectOptionalParameters(optionalParams, defaults);
    currentRequests += 1;
    emb.utils.inspectRequiredParameters({requestNameForLog: requestNameForLog, url: url, requestData: requestData, errorCallback: errorCallback, successCallback: successCallback});
    
    // if a blocking request was made, we want to show the spinner, and block immediately.  
    //  Not wait for the queue to empty out.
    if (settings.displayScreenBlocker) {
      pageLoader.startLoading();
    }

    requestData.csrfToken = emb.cookieStore.getCookie("csrfTokenCookie");

    if ((ajaxQueue.length === 0 && !isRunning) || !settings.isSerial) {

      emb.console.log('ajaxQueue empty: calling ' + requestNameForLog);

      isRunning = settings.isSerial || isRunning;

      ajaxRequest(requestNameForLog, url, requestData, errorCallback, successCallback, settings);

    } else {

      emb.console.log('ajaxQueue busy: pushing ' + requestNameForLog);

      ajaxQueue.push(function() {ajaxRequest(requestNameForLog, url, requestData, errorCallback, successCallback, settings);});

      emb.console.log('ajaxQueue: pending = ' + ajaxQueue.length);
    }
  }

  function setSessionManager(mgr) {
    sessionManager = mgr;
  }

  emb.serviceRequestsInProgress = function() {
    return currentRequests > 0;
  };
  
  return {
    request: request,
    setSessionManager: setSessionManager
  };
};