emb.page = emb.page || {};

emb.page.agreementConfirm = function($page) {  
  
  var _ = underscore,
      continueButtonCallback = _.identity;
  
  function removeOverlay() {
    $page.addClass('ui-dialog');
    $page.find('.agreement-flow-overlay').remove();
  }
	
  function setInfoText(text) {
    $page.find('#agreementConfirmText').text(text);
    removeOverlay();
  }
  
  function setContinueButtonCallback(fn) {
    continueButtonCallback = fn;
  }
  
  $page.find('.agreement-confirm-continue-button').on('click', function() {
    continueButtonCallback();
  });
  
  return {
    $page: $page,
    setInfoText: setInfoText,
    setContinueButtonCallback: setContinueButtonCallback
  };
};