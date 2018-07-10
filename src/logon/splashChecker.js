emb.splashChecker = function(splashService){
  var _ = underscore,
      mainSplashLookup = emb.createAsyncLookup(),
      featureLookups = {
        'QuickPay': emb.createAsyncLookup(),
        'Wires': emb.createAsyncLookup(),
        'BillPay': emb.createAsyncLookup(),
        'Transfers': emb.createAsyncLookup()
        //'EPay': emb.createAsyncLookup()
      },
      get = emb.utils.getValueForKeyAnyCase;

  function splashUrlFromResponse(response){
    return (response && get(response, 'isSplashEnabled')) ? get(response, 'splashUrl') : null;
  }
  
  //check feature splash object
  //if there then return correspnding feature
  function getBlockedFeature(profile, feature){
    if(profile.ecdStandin && profile.ecdStandin.featuresBlocked){
      if(feature === 'quickpay'){ 
        return profile.ecdStandin.featuresBlocked.quickPay;
      }else if(feature === 'billpay'){
        return profile.ecdStandin.featuresBlocked.billPay;
      }else if(feature === 'transfer'){
        return profile.ecdStandin.featuresBlocked.transfers;
      }else if(feature === 'wires'){
        return profile.ecdStandin.featuresBlocked.wires;
      }else if(feature === 'alerts'){
        return profile.ecdStandin.featuresBlocked.alerts;
      }  else if(feature === 'wire_activity'){
        return profile.ecdStandin.featuresBlocked.wiresActivity;
      }else if(feature === 'transfers_activity'){
        return profile.ecdStandin.featuresBlocked.transfersActivity;
      }else if(feature === 'billpay_activity'){
         return profile.ecdStandin.featuresBlocked.billPayHistory;
      }  
    }  
  }

  function featureSplashForFeatureType(profile, feature, callback){
   
   //check if feature is blocked, if blocked then call callback function with message
   var featureBlocked = getBlockedFeature(profile, feature);
    if(featureBlocked){
      return callback(featureBlocked.message);
    }else {
      return callback();
    }
  }

  // prelogon is for the prelogon splash. This callback will look for two parameters lookUpResult and hadToWait. hadToWait
  // lets us know if we had to wait for splash before submitting the form. To prevent having to send a second parameter to
  // all other  callbacks (including the splash callback on secure.html) I'm making a special callback for prelogon splash.
  function lookupMainOutageSplash(callback, prelogon){
    if (prelogon) {
      return mainSplashLookup.callbackForPrelogonSplash( callback );
    } else {
      return mainSplashLookup.lookupThen( callback );
    }
  }

  function requestSplashInfo(){
    splashService.requestSplashInfo()
      .error( function(){
        //assume the best
        mainSplashLookup.lookupReturnedWith( null );
      })
      .success( function(response){
        mainSplashLookup.lookupReturnedWith( splashUrlFromResponse(response) );
      });
  }
  
  return {
    requestSplashInfo: requestSplashInfo,
    lookupMainOutageSplash: lookupMainOutageSplash,
    featureSplashForFeatureType: featureSplashForFeatureType
  };
};
