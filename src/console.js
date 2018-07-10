(function() {
  var consoles = {
    real: (function() {

      var $consoleDiv,
          fauxConsole,
          $hideAnchor,
          $clearAnchor,
          logItFn,
          hide,
          show,
          clear;

      if (!window.console) {    // IE

        hide = function () {
          $consoleDiv.hide();
        };
        show = function () {
          $consoleDiv.show();
        };
        clear = function () {
          $consoleDiv.children('p').remove();
        };

        // Create a "console" div to add to the page in IE
        $consoleDiv = $(document.createElement('div')).attr('id', 'fauxconsole').hide();
        $hideAnchor = $(document.createElement('a')).click(hide).text('close');
        $clearAnchor = $(document.createElement('a')).click(clear).text('clear');
        $consoleDiv.append($hideAnchor).append($clearAnchor);
        $('body').append($consoleDiv);

        logItFn = function(logData) {
          var $newLine = $(document.createElement('p')).text(logData);
          $consoleDiv.append($newLine);
          show();
        };

        fauxConsole = {
          debug: function(logData) {
            logItFn(logData);
          },

          log: function(logData) {
            logItFn(logData);
          },

          info: function(logData) {
            logItFn(logData);
          },

          warn: function(logData) {
            logItFn(logData);
          },

          error: function(logData) {
            logItFn(logData);
          }
        };
        return fauxConsole;

      } else {

        // IE *sometimes* has a window.console object, but it doesn't have a log function.  Yes, I know this is ugly.
        if (!window.console.debug) {
          window.console.debug = window.console.log;
        }

        // Non-IE
        return window.console;
      }
    }()),

    fake: {
      debug: function() {},
      log: function() {},
      info: function() {},
      warn: function() {},
      error: function() {}
    },

    remote: (function() {
      var urlBase = window.location.protocol+"//"+window.location.host +"/remotelogger",
          sessionStart = (new Date()).getTime(),
          log = function() { 
            var args = [ (new Date()).getTime() - sessionStart ].concat(Array.prototype.slice.call(arguments)),
              str = JSON.stringify( args ),
              img = document.createElement("img"),
              url = urlBase+"?console=" + encodeURIComponent(str); 
            img.src = url; 
          };
      
      return {
        error: log,
        info: log,
        warn: log,
        log: log,
        debug: log
      };
    }())
  };

  emb.enableLogging = function() {
    emb.console = consoles.real;
    window.console = consoles.real;
  };

  emb.disableLogging = function() {
    emb.console = consoles.fake;
    window.console = consoles.real;
  };

  emb.logRemotely = function() {
    emb.console = consoles.remote;
    window.console = consoles.remote;
  };

  if (emb.features.DEBUG) {
    emb.enableLogging();

    // Add ?remoteLog to the url to start sending console logging to the remote server, rather than the local console.
    // You'll also need to turn on the remote logging server, by running:
    // $> rake remote_log_server
    if (/\\?[a-zA-Z&=]*remotelog/.test(window.location.href)) {
      if (/\\?[a-zA-Z&=]*delaylog/.test(window.location.href)) {
        $('#accounts').one('pageshow', function waitForAccountsPageToDisplay() {
          if (!$('#startup-loader').is(':visible') && !$('#initial-load').is(':visible')) {
            emb.logRemotely();
            emb.console.log( 'switching to remote logging' );
            emb.console.debug( 'remote logging enabled' );
            $(document).undelegate( '.ui-page', 'pageshow.delaylog' );

          } else {
            setTimeout(function() {
              waitForAccountsPageToDisplay();
            }, 3000);
          }
        });
      } else {
        emb.logRemotely();
        emb.console.log( 'switching to remote logging' );
        emb.console.debug( 'remote logging enabled' );
      }
    }
  } else {
    emb.disableLogging();
  }
}());