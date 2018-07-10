emb.page = emb.page || {};

emb.page.agreementContent = function($page, decorateAndDisplayAgreementFn) {  
  
  var _ = underscore,
      pageHelper = emb.pageHelper( $page ),
      cancelButtonCallback = _.identity,
      okButtonCallback = _.identity,
      onPageShowHandler = _.identity;
  
  
  function removeOverlay() {
    $page.find('.agreement-flow-overlay').remove();
  }
  
  function updateContent(content, options) {
    var $container = $page.find('.content'),
        $template = $('#TMPL_agreementContent'),
        $html = $($template.tmpl(content));

    decorateAndDisplayAgreementFn($page, $container, $html, options);
    
    $page.find('.agreement-footer-cancel-button').on('click', function() {
      cancelButtonCallback();
    });
    
    $page.find('.agreement-footer-ok-button').on('click', function() {
      okButtonCallback();
    });
  }
  
  function hideHeaderAndFooter() {
    $page.find('.header').hide();
    $page.find('.agreement-footer').hide();
  }
  
  function hideAcceptanceText() {
    $page.find('.content-acceptance-text').hide();
  }
  
  function setCancelButtonCallback(fn) {
    cancelButtonCallback = fn;
  }
  
  function setOkButtonCallback(fn) {
    okButtonCallback = fn;
  }
	
  function onPageShow(handler) {
    onPageShowHandler = handler;
  }
  
  $page.on('pageshow', function() {
    onPageShowHandler();
  }); 
  
  return {
    $page: $page,
    updateContent: updateContent,
    hideHeaderAndFooter: hideHeaderAndFooter,
    hideAcceptanceText: hideAcceptanceText,
    setCancelButtonCallback: setCancelButtonCallback,
    setOkButtonCallback: setOkButtonCallback,
    onPageShow: onPageShow
  };
};
