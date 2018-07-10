emb.page = emb.page || {};

emb.page.agreementDialog = function($page) {  
  
  var _ = underscore,
      okButtonCallback = _.identity;
  
  function removeOverlay() {
    $page.addClass('ui-dialog');
    $page.find('.agreement-flow-overlay').remove();
  }
	
  function setInfoText(text) {
    $page.find('#agreementDialogText').text(text);
    removeOverlay();
  }
  
  function setOkButtonCallback(fn) {
    okButtonCallback = fn;
  }
  
  $page.find('.agreement-dialog-ok-button').on('click', function() {
    okButtonCallback();
  });
  
  return {
    $page: $page,
    setInfoText: setInfoText,
    setOkButtonCallback: setOkButtonCallback
  };
};