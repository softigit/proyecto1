emb.page = emb.page || {};

emb.page.moreAgreementContent = function($page, decorateAndDisplayAgreementFn) {  
  
  var _ = underscore,
      pageHelper = emb.pageHelper($page),
      pageBeforeShowHandler = _.identity,
      currentVersionButtonClickHandler = _.identity,
      previousVersionButtonClickHandler = _.identity;
  
  
  function updateContent(content, options) {
    var $container = $page.find('.content'),
        $template = $('#TMPL_moreAgreementContent'),
        $html = $($template.tmpl(content));


    decorateAndDisplayAgreementFn($page, $container, $html, options);
  
    $page.find('#currentVersionButton').off('click').on('click', function() {
      currentVersionButtonClickHandler();
    });
  
    $page.find('#previousVersionButton').off('click').on('click', function() {
      previousVersionButtonClickHandler();
    });
    
  }
  
  function hideHeaderAndFooter() {
    $page.find('.header').hide();
    $page.find('.footer').hide();
  }
  
  function setPageBeforeShowHandler(fn) {
    pageBeforeShowHandler = fn;
  }
  
  $page.on('pagebeforeshow', function() {
    pageBeforeShowHandler();
  });
  
  function setCurrentVersionButtonClickHandler(fn) {
    currentVersionButtonClickHandler = fn;
  }
  
  function setPreviousVersionButtonClickHandler(fn) {
    previousVersionButtonClickHandler = fn;
  }
  
  return {
    $page: $page,
    setPageBeforeShowHandler: setPageBeforeShowHandler,
    updateContent: updateContent,
    hideHeaderAndFooter: hideHeaderAndFooter,
    setCurrentVersionButtonClickHandler: setCurrentVersionButtonClickHandler,
    setPreviousVersionButtonClickHandler: setPreviousVersionButtonClickHandler
  };
};
