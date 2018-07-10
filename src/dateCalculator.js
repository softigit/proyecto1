emb.dateCalculator = function(holidays, cut_off) {
  var _ = underscore,
      ONE_MINUTE_IN_MILLISECONDS = (1000 * 60),
      ONE_DAY_IN_MILLISECONDS = (1000 * 60 * 60 * 24),
      SATURDAY = 6,
      SUNDAY = 0,
      //We need to revert it when required
      CUT_OFF_HOUR = cut_off || 23;   // prod
      //CUT_OFF_HOUR = cut_off || 13;     // qa

  function isLeapYear(year) {
	  return ((year%400===0)||((year%4===0) && (year%100!==0)));
  }

  function isBeforeFiveAMUTC(date) {
    return (date.getUTCHours()<5);
  }
  
  function isBeforeFourAMUTC(date) {
    return (date.getUTCHours()<4);
  }
  
  function isBeforeFiveAMOnFirstOfMonthUTC(date) {
    return ((date.getUTCDate()===1) && isBeforeFiveAMUTC (date));
  }
  
  function isBeforeFourAMOnFirstOfMonthUTC(date) {
    return ((date.getUTCDate()===1) && isBeforeFourAMUTC (date));
  }
  
  function isBeforeFiveAMJanFirstUTC(date) {
    return ((date.getUTCMonth()===0) && isBeforeFiveAMOnFirstOfMonthUTC(date));
  }
  
  function yearInEasternTimeZone(date) {
    return isBeforeFiveAMJanFirstUTC(date) ? date.getUTCFullYear()-1:date.getUTCFullYear();
  }
  
  function monthInEasternTimeZone(date) {
    switch (date.getUTCMonth())
    {
      case 0:
      case 1:
      case 2:
      case 11:
        return (isBeforeFiveAMOnFirstOfMonthUTC (date) ? (date.getUTCMonth()===0? 11 : (date.getUTCMonth()-1)) : date.getUTCMonth());
      default:
        return (isBeforeFourAMOnFirstOfMonthUTC (date) ? date.getUTCMonth()-1 : date.getUTCMonth());
    }
  }
  
  function dateOfNthSundayOfMonthInDate (date, n) {
    return (n-1)*7+((new Date (yearInEasternTimeZone(date), monthInEasternTimeZone (date), 1)).getDay());
  }
  
  function isThreeAM_DSTOnTheSecondSundayInMarchOrAfter (now) {
    if (now.getUTCMonth() > 2) {
      return true;
    } else if (now.getUTCMonth() === 2) {
      var dateOfSecondSunday = dateOfNthSundayOfMonthInDate (now, 2);
      return ((now.getUTCDate() > dateOfSecondSunday) ? true : ((now.getUTCDate() === dateOfSecondSunday) && (now.getUTCHours() > 6)));
    } else {
      return ((now.getUTCMonth() === 0) && (now.getUTCDate() === 1) && (now.getUTCHours() < 5));
    }
  }
  
  function isBeforeOneAM_ESTOnTheFirstSundayInNovember(now) {
    if (now.getUTCMonth() < 10) {
      return !((now.getUTCMonth()===0) && (now.getUTCDate() === 1) && (now.getUTCHours() < 5));
    } else if (now.getUTCMonth() === 10) {
      var dateOfFirstSunday = dateOfNthSundayOfMonthInDate (now, 1);
      return ((now.getUTCDate() < dateOfFirstSunday) ? true: ((now.getUTCDate() === dateOfFirstSunday) && (now.getUTCHours() < 6)));
    } else {
      return false;
    }
  }
  
  function isDayLightSavingsTime(now) {
    return isThreeAM_DSTOnTheSecondSundayInMarchOrAfter (now) && isBeforeOneAM_ESTOnTheFirstSundayInNovember (now);
  }
  
  function isLastDayOfMonth(date) {
    return (isDayLightSavingsTime (date) ? isBeforeFourAMOnFirstOfMonthUTC (date) : isBeforeFiveAMOnFirstOfMonthUTC (date));
  }

  /*
    given the current hour in the UTC timezone and midnight for business timezone converted to the hour in the utc timezone.
    isPastCutOff returns true if the current hour in the business timezone is past the cutoff time in business timezone.
    
    business timezone: The timezone for determining when business is done for the day. Currently this is the eastern timezone.
    
    cutoff time: The hour in the business timezone at which business for the day ends. So if CUT_OFF_HOUR is 23 and the
    business timezone is EST then business for the current day goes from 12:00:00 a.m EST to 10:59:59 p.m EST. At
    11:00:00 p.m. EST business  starts for the next day.
  */
  function isPastCutOff(hourInUTC, midnightInUTCHour) {
    var hoursFromMidnight = 24-CUT_OFF_HOUR, cutOffInUTCHour;
    if (hoursFromMidnight > midnightInUTCHour) {
      if (hourInUTC < midnightInUTCHour) {
        return true;
      }
      cutOffInUTCHour=midnightInUTCHour+CUT_OFF_HOUR;
    } else {
      if (hourInUTC >= midnightInUTCHour) {
        return false;
      }
      cutOffInUTCHour = midnightInUTCHour-hoursFromMidnight;      
    }
    return cutOffInUTCHour <= hourInUTC;
  }

  function dayInEasternTimeZone(date) {
    if (isDayLightSavingsTime (date)) {
      return (date.getUTCHours()>=4 ? date.getUTCDay():(date.getUTCDay()===0 ? 6:date.getUTCDay()-1));
    }
    return (date.getUTCHours()>=5 ? date.getUTCDay():(date.getUTCDay()===0 ? 6:date.getUTCDay()-1));
  }
  

  function dayOfMonthInEasternTimeZone(date) {
   if (isLastDayOfMonth (date)) {
     switch (monthInEasternTimeZone (date)) {
       case 0:
       case 2:
       case 4:
       case 7:
       case 9:
       case 11:
        return 31;
      case 1:
        return (isLeapYear(date.getUTCFullYear()) ? 29 : 28);
      default:
        return 30;
     }
   }
   return (((isDayLightSavingsTime (date) && date.getUTCHours()<4) || ((!isDayLightSavingsTime(date)) && date.getUTCHours()<5)) ? date.getUTCDate()-1:date.getUTCDate());
  }

  function onSameDate(dateOne, dateTwo) {
    return ((yearInEasternTimeZone(dateOne) === yearInEasternTimeZone(dateTwo)) && (monthInEasternTimeZone(dateOne) === monthInEasternTimeZone(dateTwo)) && (dayOfMonthInEasternTimeZone(dateOne) === dayOfMonthInEasternTimeZone(dateTwo)));
  }

  function isHoliday(holidays, date) {
    var i = 0;
    for (i = 0; i < holidays.length; i+=1) {
      if (onSameDate(holidays[i], date)) {
        return true;
      }
    }
    return false;
  }

  function nextNonBankHolidayWeekday(date) {
    switch(dayInEasternTimeZone(date)) {
      case SATURDAY:
        return nextNonBankHolidayWeekday (new Date(+(date) + 2*ONE_DAY_IN_MILLISECONDS));
      case SUNDAY:
        return nextNonBankHolidayWeekday (new Date(+(date) + ONE_DAY_IN_MILLISECONDS));
      default:
        if (isHoliday (holidays, date)) {
          return nextNonBankHolidayWeekday (new Date(+(date) + ONE_DAY_IN_MILLISECONDS));
        }
        return date;
    }
  }
  
  function previousNonBankHolidayWeekday(date) {
    switch(dayInEasternTimeZone(date)) {
      case SATURDAY:
        return previousNonBankHolidayWeekday (new Date(+(date) - ONE_DAY_IN_MILLISECONDS));
      case SUNDAY:
        return previousNonBankHolidayWeekday (new Date(+(date) -2*ONE_DAY_IN_MILLISECONDS));
      default:
        if(isHoliday(holidays, date)) {
          return previousNonBankHolidayWeekday (new Date(+(date) - ONE_DAY_IN_MILLISECONDS));
        }
        return date;
    }
  }
  
  // optional now param is for unit testing
  function earliestTransferDate(now) {
    now = now || new Date();
    var nextDayBeforeCutoff;
    if (isPastCutOff (now.getUTCHours(), (isDayLightSavingsTime (now) ? 4:5))) {
      nextDayBeforeCutoff = new Date(+(now) + ONE_DAY_IN_MILLISECONDS);
    } else {
      nextDayBeforeCutoff = now;
    }
    return nextNonBankHolidayWeekday(nextDayBeforeCutoff);
  }

  function dateFromUTCDateTime(date) {
    return new Date(Date.UTC(date.getUTCFullYear(), date.getUTCMonth(), date.getUTCDate()));
  }
  
  function getYearsFromNowInMilliseconds(now, years) {
    var futureDate;
    if (dayOfMonthInEasternTimeZone(now)===29 && monthInEasternTimeZone(now)===1) {
      if (isLeapYear(now.getUTCFullYear() + years)) {
        futureDate = new Date (Date.UTC(now.getUTCFullYear() + years, 1, 29));
        return futureDate - dateFromUTCDateTime (now);
      }
      futureDate = new Date (Date.UTC(now.getUTCFullYear() + years, 1, 28));
      return futureDate - dateFromUTCDateTime (now);
    }
    futureDate = new Date (Date.UTC(now.getUTCFullYear() + years, now.getUTCMonth(), now.getUTCDate()));
    return futureDate - dateFromUTCDateTime (now);
  }

  function addDays(date,days){
    return new Date(+ (date) + days * ONE_DAY_IN_MILLISECONDS);
  }

  function getOneYearInMilliseconds(date) {
    return getYearsFromNowInMilliseconds (date, 1);
  }
  
  function latestTransferDate(fromDate) {
    fromDate = fromDate || new Date();
    //this is to makes sure only 365 days added 
    //e.g. fromDate = Oct 3 2013 then endDate should be Oct 2 2014 not Oct 3 2014
    fromDate = addDays(fromDate, -1);
    return previousNonBankHolidayWeekday(new Date(+(fromDate) + getOneYearInMilliseconds(fromDate)));
  }

  // optional now param is for unit testing
  function minutesFromNow(minutes, now) {
    now = now || new Date();
    return new Date( +(now) + (minutes * ONE_MINUTE_IN_MILLISECONDS) );
  }
  
  // optional now param is for unit testing
  function yearsFromNow(years, now) {
    now = now || new Date();
    return new Date( +(now) + (getYearsFromNowInMilliseconds (now, years)) );
  }

  return {
    isLeapYear: isLeapYear,
    dateFromUTCDateTime:dateFromUTCDateTime,
    isBeforeFiveAMUTC:isBeforeFiveAMUTC,
    isBeforeFourAMUTC:isBeforeFourAMUTC,
    isBeforeFiveAMOnFirstOfMonthUTC: isBeforeFiveAMOnFirstOfMonthUTC,
    isBeforeFourAMOnFirstOfMonthUTC: isBeforeFourAMOnFirstOfMonthUTC,
    isBeforeFiveAMJanFirstUTC: isBeforeFiveAMJanFirstUTC,
    yearInEasternTimeZone: yearInEasternTimeZone,
    monthInEasternTimeZone: monthInEasternTimeZone,
    dateOfNthSundayOfMonthInDate: dateOfNthSundayOfMonthInDate,
    isThreeAM_DSTOnTheSecondSundayInMarchOrAfter: isThreeAM_DSTOnTheSecondSundayInMarchOrAfter,
    isBeforeOneAM_ESTOnTheFirstSundayInNovember: isBeforeOneAM_ESTOnTheFirstSundayInNovember,
    isDayLightSavingsTime: isDayLightSavingsTime,
    isLastDayOfMonth: isLastDayOfMonth,
    isPastCutOff:isPastCutOff,
    dayInEasternTimeZone: dayInEasternTimeZone,
    dayOfMonthInEasternTimeZone: dayOfMonthInEasternTimeZone,
    onSameDate: onSameDate,
    isHoliday: isHoliday,
    nextNonBankHolidayWeekday: nextNonBankHolidayWeekday,
    previousNonBankHolidayWeekday: previousNonBankHolidayWeekday,
    earliestTransferDate: earliestTransferDate,
    getYearsFromNowInMilliseconds: getYearsFromNowInMilliseconds,
    getOneYearInMilliseconds: getOneYearInMilliseconds,
    latestTransferDate: latestTransferDate,
    minutesFromNow: minutesFromNow,
    yearsFromNow: yearsFromNow,
    addDays: addDays
  };
};
