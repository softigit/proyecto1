emb.sessionManager = function(startTimerFn,
                              stopTimerFn,
                              nonBlockingAlertFn,
                              service,
                              redirectPageManualLogoff,
                              redirectPageSessionTimeout,
                              limits,
                              changePageFn,
                              $) { // This is so's I can mock jQuery. [Dan]
  
  var _ = underscore,
      timeoutTimer, warningTimer, redirecting, $previousPage;
  
  function doRedirect( redirectAction ) {
    // Yes, this is redundant. Originally the goal was to ensure certain code is executed
    // possibly before and/or after redirecting; that goal has since been lost. But I'm
    // leaving it this way since I think it kind of makes sense to still retain this option.
    // If you find it objectionable on the grounds of YAGNI or whatever, that's cool too.
    redirectAction();
  }
  
  function cleanupAndRedirectAfterLogoff(page) {
    emb.cookieStore.deleteSessionCookies();
    emb.globaltons.sharedProfile = undefined;
    doRedirect(function() { window.location = page; });
  }
  
  function logoff(redirectPage, leavingSite) {
    var promise,
        vendorLogoffUrl;

    $(document).trigger("logoff");

    if (!redirectPage) {
      redirectPage = redirectPageManualLogoff;
    }
    
    // Check to see if we also need to loggoff a vendor session
    vendorLogoffUrl = emb.cookieStore.getCookie('emb.vendorLogoffUrl');
    if (vendorLogoffUrl) {
      service.vendorLogoff(vendorLogoffUrl);
      emb.cookieStore.removeCookie('emb.vendorLogoffUrl');
    }
    
    emb.console.debug('calling logoff service');
    promise = service.logoff();

    if (!leavingSite) {
      promise.error(function() {
        cleanupAndRedirectAfterLogoff(redirectPage);
      })
      .success(function() {
        cleanupAndRedirectAfterLogoff(redirectPage);
      });
    }
  }
  
  function continueSession() {
    service.keepAlive()
      .error(function(errorText, errorData) {
        emb.alert(errorText);
      })
      .success(function() {
        doRedirect( function () {
          var $destination = $previousPage || $('#accounts');

          if ($destination) {
            changePageFn( $destination );
            $previousPage = null;
          }
        });
      });
  }

  function displayWarning() {
    $previousPage = $.mobile.activePage;
    nonBlockingAlertFn('Idle timeout', emb.messages.warnings.systemTimeout, 'Log Off', 'Continue', function() {logoff(redirectPageManualLogoff);}, continueSession);
  }
  
  function start() {
    // The iPhone stops the timer when the phone is locked, therefore
    // leaving the phone locked won't sign-out of the session. So, run
    // the timer much quicker, and then compare the current time
    var check = 100, startTime = _.now();
    timeoutTimer = startTimerFn(function(triggerTime) {
      var nowTime = triggerTime || _.now();
      //emb.console.debug("checking warning limit: " + limits.timeout);
      if (nowTime.date - startTime.date >= limits.timeout) {
        emb.console.debug('Session timeout.');
        $.cookie("emb.timeout", true);
        logoff(redirectPageSessionTimeout);
        stopTimerFn(timeoutTimer);
      }
    }, check);

    warningTimer = startTimerFn(function(triggerTime) {
      var nowTime = triggerTime || _.now();
      if (nowTime.date - startTime.date >= limits.warning) {
        emb.console.debug('Warning customer of session timeout.');
        displayWarning();
        stopTimerFn(warningTimer);
      }
    }, check);
  }

  function stop() {
    stopTimerFn( timeoutTimer );
    stopTimerFn( warningTimer );
  }

  function reset(msg) {
    emb.console.debug( 'sesion timeout reset.' );
    stop();
    start();
  }

  function wasTimedout() {
    var timedout = $.cookie( "emb.timeout" );
    $.cookie( "emb.timeout", null );
    return !!timedout;
  }
  
  return {
    start: start,
    stop: stop,
    reset: reset,
    doRedirect: doRedirect,
    wasTimedout: wasTimedout,
    logoff: logoff
  };
};
