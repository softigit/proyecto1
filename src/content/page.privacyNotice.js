emb.page = emb.page || {};

emb.page.privacyNotice = function($page) {
  
  var _ = underscore,
      $errorContainer = $page.find('.error'),
      pageHelper = emb.pageHelper($page);
  
  function displayError(error) {
    $errorContainer.removeClass('hide');
    $errorContainer.find('h2').text( error );
  }

  function hideError() {
    $errorContainer.addClass('hide');
  }
      
  function updateContent(newContent) {
    $page.find('.privacy-content-div').html(newContent);
    $page.find('.privacy-content-div').removeClass('hide');
  }

  function setTopLeftLink(text, href) {
    var $topLeftLink = $page.find('a.top-left-link');
    pageHelper.setNodeText( $topLeftLink, text );
    $topLeftLink.attr( 'href', href );
  }

  function onPageRefresh( handler ) {
    $page.undelegate( '', 'pageshow')
      .delegate( '', 'pageshow', handler);
  }

  return {
    $page: $page,
    pageHelper: pageHelper,
    displayError: displayError,
    hideError: hideError,
    updateContent: updateContent,
    setTopLeftLink: setTopLeftLink,
    onPageRefresh: onPageRefresh
  };
};
