if(typeof emb.page === 'undefined' ) { emb.page = {}; }

emb.page.logonError = function($page) {
  var _ = underscore,
      $title = $page.find('.error-title'),
      $message = $page.find('.message'),
      $number = $page.find('.callSupportButton'),
      $numberText = $number.find('.ui-btn-text'),
      $option3 = $page.find('.callCardServices'),
      $option3Text = $option3.find('.ui-btn-text'),
      $cancel = $page.find('.cancel .ui-btn-text');
    
    function setTitle(title) {
      $title.text(title);
      $title.removeClass("hide");
    }
    
    function setMessage(message) {
      $message.text(message);
    }
    
    function setNumber(text, number) {
      $number.attr("href", "tel:"+number);
      $numberText.text(text);
      $number.removeClass("hide");
    }
    
    function setSecondCallOption(option2, number) {
      $option3.attr("href", "tel:"+number);
      $option3Text.text(option2);
      $option3.removeClass("hide");
    }
    
    function setCancel(cancel) {
      $cancel.text(cancel);
    }
    
    return {
      setTitle: setTitle,
      setMessage: setMessage,
      setNumber: setNumber,
      setSecondCallOption: setSecondCallOption,
      setCancel: setCancel
    };
};