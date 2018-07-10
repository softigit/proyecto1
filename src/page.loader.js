emb.page = emb.page || {};

(function() {

  function block() {
    // console.log('function block()');
    $("<div class='screen-blocker'><div/>")
      .css({
        position: 'absolute',
        width: $(document).width(),
        height: $(document).height(),
        background: "#000",
        opacity: 0.13,
        top: 0,
        left: 0,
        'z-index': 2999 // everything you want on top, gets higher z-index
      })
      .appendTo("body");
  }

  function blockWithOverlay() {
    // console.log('blockWithOverlay');
    // Let's be honest, this whole thing is pretty hacky. We are taking a JQM page, shoving it *INSIDE*
    // another JQM page, forcing it to be visible, then messing with the CSS by hand to make sure it
    // fully overlays the rest of the content
    $('div#initial-load')
      .page()
      .css({ 'height': '100%', 'z-index': 1980 })
      .addClass('ui-page-active')
      .appendTo( $.mobile.activePage );
  }

  function unblockOverlay(){
    $('div#initial-load').removeClass('ui-page-active');
  }

  function unBlock() {
    $('.screen-blocker').remove();
  }
  
  function startLoading() {
    // console.log('startLoading');
    block();
    $.mobile.showPageLoadingMsg();
  }

  function stopLoading() {
    $.mobile.hidePageLoadingMsg();
    unBlock();
  }

  emb.page.loader = {
    startLoading: startLoading,
    stopLoading: stopLoading,
    block: block,
    blockWithOverlay: blockWithOverlay,
    unBlock: unBlock,
    unblockOverlay: unblockOverlay
  };
}());

