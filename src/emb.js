/*jslint regexp:true*/

// our root namespace
var emb = {
      globaltons: {},
      CHANNEL_ID: 'MOE'
    }; 

// if we're in node (i.e. we're running our unit tests) then we need to explicitly expose our root namespace
if( typeof global !== 'undefined' ) { 
  global.emb = emb;
}

(function setFeatureFlags(){
  emb.features = {};
  emb.features.REDEEM_REWARDS = true; // turn off/on Ultimate Rewards feature.
  if( typeof window !== 'undefined' ){
    
    // from: http://stackoverflow.com/questions/901115/how-can-i-get-query-string-values-in-javascript
    var parameterName = 'channelId',
        regex = new RegExp("[\\?&]" + parameterName + "=([^&#]*)"),
        results = regex.exec(location.search),
        overrideChannelId = results === null ? undefined : decodeURIComponent(results[1].replace(/\+/g, " "));
    
    if (!!overrideChannelId) {
      emb.CHANNEL_ID = overrideChannelId;
    }
    emb.features.IS_EMBEDDED = !!overrideChannelId;
    
    emb.features.STUB_OUT_GOOGLE_MAPS = /\\?.*stubbedgm/.test(window.location.href);
    emb.features.DEBUG = window.location.port === "4443" || /\\?.*debug/.test(window.location.href);
    emb.features.SUPPRESS_ALERTS = /\?.*suppress_alerts/.test(window.location.href);
    emb.features.HIDE_HEADER_BUTTONS = /\\?.*hideheaderbuttons/.test(window.location.href);
  }else{
    emb.features.IS_EMBEDDED = false;
    emb.features.STUB_OUT_GOOGLE_MAPS = false;
    emb.features.DEBUG = true;
    emb.features.SUPPRESS_ALERTS = false;
    emb.features.HIDE_HEADER_BUTTONS = false;
  }
}());


