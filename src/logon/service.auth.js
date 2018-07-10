emb.service = emb.service || {};

emb.service.auth = function(serviceLayer, urls, channel_id, deviceSignatureStore, deviceId){
  var _ = underscore;

  function requestOTPContactsAndPrefix(spid) {
		var promise = {
			successHandler: function(){},
			errorHandler: function(){},
      failureHandler: function(){},

			
			onSuccess: function(handler){this.successHandler = handler;},
			onError: function(handler){this.errorHandler = handler;},
			onFailure: function(handler){this.failureHandler = handler;}
		};
		serviceLayer.request(
			'Auth OTP Contacts',
			urls.otpContactList,
			{"spid": spid},
			function errorHandler(message, data) {
				promise.errorHandler(message, data); 
			},
			function successHandler(responseData){ 
				emb.console.log("OTP response: ", responseData);
				promise.successHandler(responseData.prefix, responseData.contacts);
			}
		);
		
		return promise;
  }
  
  function requestOTP(userId, contactId, method) {
		var contactMethodMap = {"email": "T", "text": "S", "call": "V"},
			promise = emb.promise();
		
		serviceLayer.request(
			'OTP Send',
			urls.otpSend,
			{
				"reason": "2",
				"method": contactMethodMap[method],
				"contactId": contactId,
				"userId": userId.toLowerCase()
			},
			function errorHandler(errors) {
				promise.reportError(errors); 
			},
			function successHandler(responseData){ 
				emb.console.log("request OTP response: ", responseData);
				promise.reportSuccess(responseData);
			}
		);
		
		return promise;
  }

  function authenticate( credentials ) {   //userId, password, otp_passcode, otp_prefix) {
    var otp_reason,
    authenticate_params,
    otp_passcode,
    otp_prefix,
    promise = {
      successHandler: function(){},
      failureHandler: function(){},
      errorHandler: function(){},
      mfaHandler: function(){},

      onSuccess: function(handler){this.successHandler = handler;},
      onFailure: function(handler){this.failureHandler = handler;},
      onError: function(handler){this.errorHandler = handler;},
      onMFA: function(handler){this.mfaHandler = handler;}
    };

    otp_reason = credentials.prefix ? '2' : '';
      otp_prefix = credentials.prefix || '';
      otp_passcode = credentials.idCode || '';
      
      authenticate_params = {
        "auth_contextId": "login",
        "auth_deviceCookie": "adtoken",
        "auth_externalData": "LOB=RGBLogon",
        "Referer": "https://www.chase.com",

        "auth_otp": otp_passcode,
        "auth_otpprefix": otp_prefix,
        "auth_otpreason": otp_reason,

        "auth_passwd": credentials.password.toLowerCase(),
        "auth_passwd_org": credentials.password.toLowerCase(),

        "auth_siteId": channel_id,

        "auth_deviceSignature": deviceSignatureStore.getSignature(),
        "auth_deviceId": deviceId
      };

    if (credentials.userId) {
      authenticate_params.auth_userId = credentials.userId.toLowerCase();
    }

    serviceLayer.request(
      'Login',
      urls.login, 
      authenticate_params,
      function errorHandler(errorText, errorData) {
        promise.errorHandler(errorText, errorData); 
      },
      function successHandler(responseData){ 
        switch( responseData.response ) {
          case 'success':
            promise.successHandler();
            break;
          case 'failure':
            promise.failureHandler();
            break;
          case 'secauth':
            promise.mfaHandler(responseData.spid);
            break;
          case 'invalid':
            promise.errorHandler( responseData.response + ' username/password problem.', responseData );
            break;
          default:
            promise.errorHandler( 'unrecognized response code: ' + responseData.response, responseData );
        }
      }
    );

    return promise;
  }
  
  function logoff() {
    var promise = emb.promise();
    
    serviceLayer.request(
      'Logoff',
      urls.logout,
      {
        type: "json",
        cache: true,
        applId: "GATEWAY",
        channelid: channel_id
      },
      function errorHandler(errorText, errorData) {
        promise.reportError(errorText, errorData);
      },
      function successHandler(responseData) {
        promise.reportSuccess();
      }
    );
    
    return promise;
  }

  function keepAlive() {
    var promise = emb.promise();
    
    serviceLayer.request(
      'Keep Alive',
      urls.keepAlive,
      {},
      function errorHandler(errors) {
        promise.reportError(errors); 
      },
      function successHandler(responseData){ 
        promise.reportSuccess(responseData);
      }
    );
    
    return promise;
  }
  
  function vendorLogoff(url) {
    serviceLayer.request(
      'Vendor Logoff',
      url,
      {},
      function() { /* eat it */ },
      function() { /* just eat it */ }
    );
  }
  
  return {
    authenticate: authenticate,
    requestOTPContactsAndPrefix: requestOTPContactsAndPrefix,
    requestOTP: requestOTP,
    logoff: logoff,
    keepAlive: keepAlive,
    vendorLogoff: vendorLogoff    
  };
};
