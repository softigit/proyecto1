// From Crockford: http://javascript.crockford.com/remedial.html
if (!String.prototype.trim) {
    String.prototype.trim = function () {
        return this.replace(/^\s*(\S*(?:\s+\S+)*)\s*$/, "$1");
    };
}

if (!String.prototype.toSentenceCase) {
  String.prototype.toSentenceCase = function() {
    return this.charAt(0).toUpperCase() + this.substr(1).toLowerCase();
  };
}

String.toSentenceCase = function(string) {
  return typeof string === 'string' ? string.toSentenceCase() : '';
};

if (!String.prototype.contains) {
  String.prototype.contains = function(substr) {
    return this.indexOf(substr) !== -1;
  };
}

function addDateFormatter(functionName,formatString){
  if (!Date.prototype[functionName]){
    Date.prototype[functionName]= function(){
                                    var _ = underscore;
                                    return _.date(this).format(formatString);
                                  };
  }
}

addDateFormatter("format","MMM D, YYYY");
addDateFormatter("iso8601","YYYYMMDD");
addDateFormatter("longIso8601","YYYYMMDDTHH:mm:ssz");
addDateFormatter("fullDate","MMMM D, YYYY");
addDateFormatter("shortDate","YYYY-MM-DD");
addDateFormatter("asOfDateFormatEDT","\\A\\s of h:mm A E\\DT M/DD/YYYY");
addDateFormatter("asOfDateFormatEST","\\A\\s of h:mm A EST M/DD/YYYY");
addDateFormatter("headlineFormatEDT", "MM/DD/YYYY \\at h:mm A E\\DT");
addDateFormatter("headlineFormatEST", "MM/DD/YYYY \\at h:mm A EST");
addDateFormatter("asOfDateFormatET","\\A\\s of h:mm A ET M/DD/YYYY");
addDateFormatter("headlineFormatET", "MM/DD/YYYY \\at h:mm A ET");

function isValidDate(dateComponents) {
  
  var isValid = true,
      year = parseInt(dateComponents[1], 10),
      month = parseInt(dateComponents[2], 10),
      day = parseInt(dateComponents[3], 10);

  //month validation
  if((month < 1) || (month > 12)) {isValid = false;}
  //normal day validation
  else if((day < 1) || (day > 31)) {isValid = false;}
  //day validation for months April, June, Sep and Nov
  else if(((month === 4) || (month === 6) || (month === 9) || (month === 11)) && (day > 30)) {isValid = false;}
  //day validation for leap year
  //leap year - should be divide by 400(2000 is a leap yr) OR 
  //should be divide by 4 but not with 100(1900 not a leap year but 2012 is a leap yr)
  else if((month === 2) && (((year % 400) === 0) || (((year % 4) === 0) && ((year % 100) !== 0)))){
    if(day > 29) {isValid = false;}
  } 
  else if((month === 2) && (day > 28)) {isValid = false;}

  return isValid;
}

Date.createFrom = function (stringDate) {
  var dateFormat = /^(\d{4})(\d{2})(\d{2})$/,
      dateComponents,
      MONTH_OFFSET_JAVASCRIPT_DATE = 1;
  
  if( stringDate === "N/A" ){
    return "N/A";
  }

  if( !stringDate || stringDate.trim() === "") {
    return undefined;
  }
  dateComponents = stringDate.match( dateFormat );

  if( dateComponents && dateComponents.length === 4 && isValidDate(dateComponents)) {
    return new Date( dateComponents[1], dateComponents[2] - MONTH_OFFSET_JAVASCRIPT_DATE, dateComponents[3] );
  } else {
    return undefined;
  }
};

Date.parseAmericanStyle = function (stringDate) {
  var dateFormat = /^(\d{1,2})\/(\d{2})\/(\d{4})$/,
      dateComponents,
      MONTH_OFFSET_JAVASCRIPT_DATE = 1;
  
  if( stringDate === "N/A" ){
    return "N/A";
  }

  if( !stringDate || stringDate.trim() === "") {
    return undefined;
  }
  dateComponents = stringDate.match( dateFormat );

  if( dateComponents && dateComponents.length === 4 ) {
    return new Date( dateComponents[3], dateComponents[1] - MONTH_OFFSET_JAVASCRIPT_DATE, dateComponents[2] );
  } else {
    return undefined;
  }
};

Date.isDate = function(x) { 
  return (null !== x) && !isNaN(x) && ("undefined" !== typeof x.getDate); 
};

Date.utcDateFromStringOrDate = function(dateIn) {
  var workingDate, foo;
  if (typeof dateIn === 'string') {
    workingDate = new Date(dateIn);
  } else if (typeof dateIn === 'object') {
    workingDate = dateIn;
  } else {
    return undefined;
  }
  
  if (Date.isDate(workingDate)) {
    return Date.UTC(workingDate.getFullYear(), workingDate.getMonth(), workingDate.getDate(), 0, 0, 0);
  } else {
    return undefined;
  }
};
