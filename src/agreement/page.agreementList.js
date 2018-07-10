emb.page = emb.page || {};

emb.page.agreementList = function($page) {
  var _ = underscore,
      pageHelper = emb.pageHelper( $page ),
      agreementItemClickHandler = _.identity;

  function updateContent(content) {
    var $template = $page.find('.TMPL_agreementList'),
        templateHtml = $template.tmpl(content),
        $container = $page.find('#agreementListContainer');
    
    $container.empty();
    $(templateHtml).appendTo($container);
    pageHelper.refreshListView($container);

    $page.find('.agreement-item').on('click', function(e) {
      var url = $(e.target).parents('li').tmplItem().data;
      agreementItemClickHandler(url);
    });
  }
  
  function setAgreementItemClickHandler(fn) {
    agreementItemClickHandler = fn;
  }
  
  return {
    $page: $page,
    updateContent: updateContent,
    setAgreementItemClickHandler: setAgreementItemClickHandler
  };
};
