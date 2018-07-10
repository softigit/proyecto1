emb.page = emb.page || {};

emb.page.htmlContent = function($page) {  
  
  var _ = underscore,
      reloadCallback = _.identity;
      
  function updateContent(content) {
    var $container = $page.find('.content'),
        $template = $('#TMPL_htmlcontent'),
        html;
        
    html = $template.tmpl(content);
    
    $container.empty();
    $(html).appendTo($container);
    $page.trigger('create');
  
    $('#reloadContent').on('click', function() {
      reloadCallback();
    });
  }
  
  function setReloadCallback(fn) {
    reloadCallback = fn;
  }
  
  return {
    $page: $page,
    updateContent: updateContent,
    setReloadCallback: setReloadCallback
  };
};
