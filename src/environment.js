/*jslint regexp:false*/
emb.environment = function(currentLocation) {
  var _ = underscore,
      envConfig = {
        deviceIdCookie: {
          m:          'adtoken.chase.com',
          "m-load":   'nocookie',
          localhost:  'nocookie',
          q:          'adtoken_qa<num>.chase.com',
          i:          'adtoken_ist0<num>.chase.com'
        }
      };

  function determineEnvironment() {
    /*
    EMB environment url's look like:
      m.chase.com       => Prod
      mq1.chase.com     => QA 1
      mi1.chase.com     => IST 1
      m-load.chase.com  => Perf

      Parse the hostname to figure out what environment we're in.
     */
    var currentHostname = currentLocation.hostname,
        hostArray = currentHostname.split( '.' ),
        env,
        envType,
        envNum = '';
    
    if (hostArray[0] === 'm' || hostArray[0] === 'm-load') {
      envType = hostArray[0];
    } else if (hostArray.length === 1) {                  // i.e. https://localhost:8888/secure.html...
      envType = 'localhost';
    } else {
      env = hostArray[0].split( /^m(q|i)(\d)$/ );         // split the q or the i from the environment #
      envType = (env.length > 1) ? env[1] : 'localhost';  // if we hit localhost here, we're not in a real environment anyway
      envNum = (env.length > 1) ? env[2] : '';
    }
    
    return {
      type: envType,
      number: envNum
    };
  }
  
  function buildConfig(environment) {
  
    function getValueFromConfig(configItem) {
      var item = envConfig[configItem],
          val = item ? item[environment.type] : '';
      return val ? val.replace('<num>', environment.number) : '';
    }
    
    return {
      deviceIdCookie: getValueFromConfig('deviceIdCookie')
    };
  }

  return {
    config: buildConfig(determineEnvironment())
  };
};
