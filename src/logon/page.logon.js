if( typeof emb.page === 'undefined' ) { emb.page = {}; }

emb.page.logon = function($page) {
  var _ = underscore,
      $title = $page.find('.log-on-title'),
      pageHelper = emb.pageHelper($page),
      $tokenRow = $page.find('.token-row'),
      $nextTokenRow = $page.find('.next-token-row'),
      $infoLabelRow = $page.find('.token-info-lable-row'),
      $tokenSliderRow = $page.find("[name='token-slider-row']"),
      $tokenSlider = $page.find("[name='token-slider']"),
      $token = $page.find("[name='token']"),
      $nextToken = $page.find("[name='next-token']"),
      $logonSlider = $page.find("[name='logon-slider']"),
      $userid = $page.find("[name='userid']"),
      $password = $page.find("[name='logon-password']");
	  $a = $page.find("[name='a']");
  
  function getUserId() {
    return $page.find($userid).val();
  }
  
  function setUserId(value) {
		$page.find($userid).val(value);
  }
	
  function getPassword() {
    return $page.find( $password).val();
  }
  
  function setPassword(value) {
    $page.find($password).val(value);
  }

  //gets the token selection "ON" or "OFF"
  function getTokenSelection() {
    return $page.find($tokenSlider).val();
  }

  //sets the token selection "ON" or "OFF"
  function setTokenSelection(value) {
    $page.find($tokenSlider).val(value);
  }
  
  function getToken(){
    return $page.find($token).val();
  }
  
  function setToken(value){
    $page.find($token).val(value);
  }
  
  //gets the secondary rsa token
  function getNextToken(){
    return $page.find($nextToken).val();
  }
  
  //sets the secondary token
  function setNextToken(value){
    return $page.find($nextToken).val(value);
  }
  
  //sets the controls hide or show depends on condition
  function showOrHideToken(token, show, isSecondToken){
    if(show){
      //show first/second token
      token.removeClass( 'hide' );// show if slider "ON" 
      //if second token to show then show info label
      if(isSecondToken){
        $tokenSliderRow.addClass( 'hide' );
        $infoLabelRow.removeClass( 'hide' ); 
      }
    }else{
      //hide token and info label
      token.addClass( 'hide' );// hide if slider "OFF"
    }
  }

  //hide or show token input depends on token slider selection
  function toggleSecondToken(show) {
    showOrHideToken($nextTokenRow, show, true);
  }
  
  function toggleFirstToken(show) {
    showOrHideToken($tokenRow, show);
  }

  function onLogonSubmit( callback ){   
    $page.find('form').unbind('submit')
      .submit(function( e ) {
        $(document).trigger("logon");
        if (!callback()) {
          e.preventDefault();
          return false;
        }
      });
  }
  
  function setUserIdSelection(value) {
		var logonSlider = $page.find( $logonSlider);
    logonSlider.val(value);
  }
  
  function setURUserIdSelection(value) {
    $page.find($logonSlider).prop('checked',value);
  }

  function getUserIdSelection() {
		return $page.find($logonSlider).val();
  }
	
	function showError(errorMsg) {
		emb.alert(errorMsg);
	}

  function onTokenSliderTouched(handler) {
    $page.undelegate($tokenSlider, 'change')
      .delegate($tokenSlider, 'change', handler);
  }
  
  function setTitle(title) {
    $title.text(title);
  }

  function makeSlidersADACompliant() {
    $page.find('[data-role="slider"]').each(function () {
      var sliderAriaLabel = $(this).parent().siblings('.ui-block-a').text();
         emb.adaHelper().makeSliderADACompliant($(this), sliderAriaLabel);
      });
  }

  return {
    $page: $page,
    getUserId : getUserId,
    setUserId : setUserId,
    getPassword : getPassword,
    setPassword : setPassword,
    onLogonSubmit : onLogonSubmit,
    getUserIdSelection : getUserIdSelection,
    setUserIdSelection : setUserIdSelection,
    setURUserIdSelection: setURUserIdSelection,
    getTokenSelection: getTokenSelection,
    setTokenSelection: setTokenSelection,
    getToken: getToken,
    setToken: setToken,
    getNextToken: getNextToken,
    setNextToken: setNextToken,
    showError : showError,
    setTitle: setTitle,
    makeSlidersADACompliant: makeSlidersADACompliant,
    toggleFirstToken: toggleFirstToken,
    toggleSecondToken: toggleSecondToken,
    onTokenSliderTouched: onTokenSliderTouched,
    pageHelper: pageHelper
  };
};
