(function() {
  var originalNavBarCreate = $.mobile.navbar.prototype._create,
      deviceAgent = navigator.userAgent.toLowerCase(),
      isIphone = deviceAgent.match(/(iphone)/),
      isIpad = deviceAgent.match(/(ipad)/);

  // We actually don't want our navbar to add/remove the ui-btn-active class
  // based on vclicks. We just add that class to the appropriate tabs ONCE,
  // on initialization, and wash our hands of the matter.
  $.mobile.navbar.prototype._create = function() {
    var $navbar = this.element;

    originalNavBarCreate.apply(this, arguments);

    // Scrap the original handler.
    $navbar.undelegate( "a", "vclick" );
  };
  
  function getIOSScreenHeight(){
    var orientation = $.event.special.orientationchange.orientation(),
    port			= orientation === "portrait",
	winMin			= port ? 422 : 320,
	screenHeight	= port ? screen.availHeight : screen.availWidth,
	winHeight		= Math.max( winMin, $( window ).height() ),
	pageMin			= Math.min( screenHeight, winHeight );
	return pageMin;
  } 
  
  function resetIOSActivePageHeight(){
    // Don't apply this height in touch overflow enabled mode
		if( $.support.touchOverflow && $.mobile.touchOverflowEnabled ){
			return;
		}
		$( "." + $.mobile.activePageClass ).css( "min-height", getIOSScreenHeight() );
  }
  
  if ( isIphone || isIpad) {
    // Fix the minimum height for IOS where the page seems to extend below the safari footer nav.
      $( document ).unbind( "pageshow", $.mobile.resetActivePageHeight);
      $( window ).unbind( "throttledresize", $.mobile.resetActivePageHeight );
      $( document ).bind( "pageshow", resetIOSActivePageHeight );
      $( window ).bind( "orientationchange", resetIOSActivePageHeight );
      $( window ).bind( "throttledresize", resetIOSActivePageHeight );
  }

  // All this mess is here to make the tabs & buttons react more quickly to user's touch.
  //in the new JQM, $.mobile.activePage becomes available after the pagebeforeshow is fired
  $(document).on('pagebeforeshow', function(){
    function wireElements($elements, highlightClass) {
      $elements.on('touchstart', function() {
        var $self = $(this);

        // Only highlight the button for ~1 second.
        $self.addClass(highlightClass);
        setTimeout(function() {
          $self.removeClass(highlightClass);
        }, 1000);
      });

      // Also un-highlight the button the event of navigating away.
      $elements.closest(':jqmData(role="page")').bind('pagehide', function() {
        $elements.removeClass(highlightClass);
      });
    }
    function initHighlighting($page) {
      var $tabs = $page.find('.navbar a'),
          $buttons = $page.find(':jqmData(role="button")');
      
      wireElements($tabs, 'ui-btn-down-c');
      wireElements($buttons, 'ui-btn-down-chase');
    }

    initHighlighting( $.mobile.activePage );
    
    // For each page, when we show it, we add event handlers to highlight the appropriate tabs
    // according to our own custom rules (we want a long-lasting highlight that last until the
    // active page changes).
    $(':jqmData(role="page")').not('.ui-page-active').one('pageshow', function() {
      initHighlighting( $(this) );
    });
  });
  
  //Remove the ui-shadow class from Android devices, to improve scrolling performance.
  (function tweakCssForAndroid() {
    if ( navigator.userAgent.toLowerCase().match(/android (2\.[1-9]|[3-9])/) ) {
    $("<style type='text/css'> .ui-shadow { -moz-box-shadow: 0px 0px 0px !important; -webkit-box-shadow: 0px 0px 0px !important ; box-shadow: 0px 0px 0px !important;</style>").appendTo("head");      
    }
  }());
}());
