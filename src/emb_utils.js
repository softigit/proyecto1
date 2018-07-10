emb.utils = (function(){
  var _ = underscore,
      cq5DomainQA = 'wwwq1wcm.chase.com',
      cq5DomainProd = 'www.chase.com',
      localPrivacyPolicyPath = "/content/online_privacy_policy_cq5.html",
      cq5PrivacyPolicyPath = "/content/dam/mobile/en/legacy/documents/legal-docs/colprivacypolicy.htm";

  function extractDates( source, keys ) {
    var dates = {};
    _.each( keys, function(key){
      dates[key] = Date.createFrom( source[key] );
    });
    return dates;
  }

  function inTwentyTwoCharIsoFormat (string) {
    var patt=/^[0-9]{8}T[0-9]{2}:[0-9]{2}:[0-9]{2}-[0-9]{4}$/;
    return patt.test(string);
  }

  function inEightCharIsoFormat (string){
    var patt=/^[0-9]{8}$/;
    return patt.test(string);
  }

  function dateFrom8charsString(formattedDate){
    var dateObject=new Date(formattedDate);
    if(!Date.isDate(dateObject)){
      return null;
    }else{
      return dateObject;
    }
  }

  function weekdayStringFromInteger(dayInt){
    var weekday = new Array(7);
    weekday[0]="Sunday";
    weekday[1]="Monday";
    weekday[2]="Tuesday";
    weekday[3]="Wednesday";
    weekday[4]="Thursday";
    weekday[5]="Friday";
    weekday[6]="Saturday";

    return weekday[dayInt];
  }

  function createDateFrom22CharacterIsoString (string) {
    //20110311T12:20:04-0700
    var parts = string.split("T"),
        dateParts, timeParts,
        date,year,month,day,hour,minutes,seconds;

    dateParts = parts[0];
    year = dateParts.substr(0,4);
    month = parseInt( dateParts.substr(4,2) ,10 ) - 1;
    day = dateParts.substr(6,2);

    //If it's weekend, it's only return the date, so the array of parts will have only 1 item
    if(parts.length === 1) {
      hour = 0;
      minutes = 0;
      seconds = 0;
    } else {
      timeParts = parts[1].split("-")[0].split(":");
      hour = timeParts[0];
      minutes = timeParts[1];
      seconds = timeParts[2];
    }

    date = new Date(year, month, day, hour, minutes, seconds);
    return date;
  }

  function trimObject( source, keys ) {
    var trimmed = {};
    _.each( keys, function(key){
      if( source.hasOwnProperty(key) ){
        trimmed[key] = source[key];
      }
    });
    return trimmed;
  }

  function createEightCharIsoFormat(string){
    if(string) {
      return new Date( string.substr(0,4), Number( string.substr(4,2) ) - 1, string.substr(6,2) );
    }
  }
  
  function trimFunctions( source ){
		var trimmed = {};
			_.each( source, function(value,key){
				if( !_.isFunction(value) ){
					trimmed[key] = value;
				}
			});
			return trimmed;
  }

  function without(source, excludedKeys) {
    var trimmed = {};
    _.each(source, function(value, key) {
      if (!_.include(excludedKeys, key)) {
        trimmed[key] = value;
      }
    });
    return trimmed;
  }
  
  // Changes an Integer so that it has commas every 3 digits to the left of the period.
  // Ex: 1234567 => 1,234,567, 1234567.89 => 1,234,567.89
  function addThousandsSeparators (nStr) {
    nStr +='';
    var x = nStr.split('.'),
        x1 = x[0],
        x2 = x.length > 1 ? '.' + x[1] : '',
        rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
      x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
  }

  /*
  Will safely retrieve nested objects if they exist - or the default value if they do not.
  Example:
    { maybe: { this: value }
    maybe.this.value                                      <- returns the value object
    maybe.this.value.exists                               <- causes an error
    maybeGet( maybe, [ this, value ], 'foo' )             <- returns the value object
    maybeGet( maybe, [ this, value, exists ], 'or not' )  <- returns 'or not'
  */
  function maybeGet( rootNode, nodeArray, defaultValue ) {
    var currentNode = rootNode,
        goodToGo = true;
    _.each( nodeArray, function( node ) {
      if ( currentNode && currentNode.hasOwnProperty( node ) ) {
        currentNode = currentNode[ node ];
      } else {
        goodToGo = false;
      }
    });
    return goodToGo ? currentNode : defaultValue;
  }

  function repeatAsync(times, op) {
    var after, repeatPrime = function(i) {
      if (i < times) {
        op(i);
        setTimeout(repeatPrime, 0, i + 1);
      } else {
        if (_.isFunction(after)) {
          after();
        }
      }
    };

    setTimeout(repeatPrime, 0, 0);

    return {
      after: function(op) {
        after = op;
      }
    };
  }

  function eachAsync(collection, op) {
    return repeatAsync(collection.length, function(i) {
      op(collection[i]);
    });
  }

  function truncateString(string, maxLength) {
    if (string === undefined) {
      return string;
    }

    maxLength = ( typeof maxLength === 'number' ) ? maxLength : 100;

    if ( typeof string !== 'string' ) {
      return truncateString( string.toString(), maxLength );
    }

    if ( string.length <= maxLength ) {
      return string;
    } else {
      return string.substring(0, maxLength - 5) + '[...]';
    }
  }

  function currencyRound( unroundedNumber ) {
    // Applying toFixed here solves the rounding case of 1.005 to 1.01 instead of 1.00
    return Math.round((unroundedNumber * 100).toFixed(1)) / 100; 
  }

  function areEqual(x, y) {
    if (x === y) {
      return true;
    }

    if (_.isArray(x) && _.isArray(y)) {
      return (x.length === y.length) && _.all(x, function(value, i) {
        return areEqual(x[i], y[i]);
      });
    }

    // Let's just forgot about more complex objects for now.
    return false;
  }



  function objectIncludes( source, elements ) {

      var keys, keyIndex, keyToken;

      keys = _.keys(source);

      for(keyIndex=0; keyIndex < keys.length; keys++)
      {
          keyToken = keys[keyIndex];

          if(!_.isNull(elements[keyToken])  && areEqual(source[keyToken], elements[keyToken]))
          {
              return true;
          }

      }


      return false;
  }

  function mapKeysToLowerCase(item,recursively) {
    var mappedItem = {};
    _.each(item, function(value, key) {
      if( recursively && typeof value === 'object' && value !== null ){
        if( _.isArray(value) ){
          value = _.map( value, function(v){ return mapKeysToLowerCase(v,true); } );
        }else{
          value = mapKeysToLowerCase( value, true );
        }
      }
      mappedItem[key.toLowerCase()] = value;
    });
    return mappedItem;
  }

  function mapKeysToLowerCaseRecursively(item) {
    return mapKeysToLowerCase(item,true);
  }

  function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.substr(1);
  }

  function downcaseFirstLetter(string) {
    return string.charAt(0).toLowerCase() + string.substr(1);
  }

  function getValueForKeyAnyCase(object, key) {
    if (!object || typeof key !== 'string') {
      return undefined;
    }

    return object[key] || object[capitalizeFirstLetter(key)] || object[downcaseFirstLetter(key)] || object[key.toLowerCase()];
  }

  function inspectRequiredParameters(parametersObject) {
    var exceptionKeys = [];
    _.each(parametersObject, function(value, key) {
      if (!value) {
        exceptionKeys.push(key);
      }
    });
    if (exceptionKeys.length > 0) {
      throw 'Missing required parameter(s): ' + exceptionKeys.join(', ');
    }
  }

  function inspectOptionalParameters(parametersObject, defaultsObject) {
    var returnObject = {};
    _.each(defaultsObject, function(value, key) {
       returnObject[key] = (parametersObject && parametersObject.hasOwnProperty(key)) ? parametersObject[key] : value;
    });
    return returnObject;
  }

  function getParsedUrl(hostName){
    var hostArray = hostName.split('.');

    //except localhost this array length should be > 1
    if(hostArray.length > 1){
      //For all QA environments (Q1, Q2, Q3, ....) and localhost pointing to QA environments then document exists in CQ5 envirnaoment
      //so set domain to cq5 environment.
      if(hostArray[0].slice(0,2) === 'mq' || hostArray[0] === 'emb' || hostArray[0] === 'local'){
        return cq5DomainQA + cq5PrivacyPolicyPath;
      }else{
        //for prod document exists in same domain
        //this returns prod cq5 url
        return cq5DomainProd + cq5PrivacyPolicyPath;
      }
    }else{ //this is for local host url where document exists in local
      //here we need url with port number as well
      return window.location.host + localPrivacyPolicyPath;
    }
  }

  function getCQ5Url(){
    return window.location.protocol + "//" + getParsedUrl(window.location.hostname);
  }

  function checkScriptExists(scriptSrc){
    var scripts = document.getElementsByTagName("script");
    return(_.find(scripts, function(script) { return script.src === scriptSrc; }));
  }

  return {
    extractDates: extractDates,
    inTwentyTwoCharIsoFormat: inTwentyTwoCharIsoFormat,
    inEightCharIsoFormat: inEightCharIsoFormat,
    createDateFrom22CharacterIsoString: createDateFrom22CharacterIsoString,
    createEightCharIsoFormat: createEightCharIsoFormat,
    trimObject: trimObject,
    trimFunctions: trimFunctions,
    without: without,
    addThousandsSeparators: addThousandsSeparators,
    maybeGet: maybeGet,
    repeatAsync: repeatAsync,
    eachAsync: eachAsync,
    truncateString: truncateString,
    currencyRound: currencyRound,
    objectIncludes: objectIncludes,
    mapKeysToLowerCase: mapKeysToLowerCase,
    mapKeysToLowerCaseRecursively: mapKeysToLowerCaseRecursively,
    capitalizeFirstLetter: capitalizeFirstLetter,
    downcaseFirstLetter: downcaseFirstLetter,
    getValueForKeyAnyCase: getValueForKeyAnyCase,
    inspectRequiredParameters: inspectRequiredParameters,
    inspectOptionalParameters: inspectOptionalParameters,
    dateFrom8charsString: dateFrom8charsString,
    weekdayStringFromInteger: weekdayStringFromInteger,
    getCQ5Url: getCQ5Url,
    checkScriptExists: checkScriptExists
  };
}());