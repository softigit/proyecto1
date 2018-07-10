if( typeof emb.page === 'undefined' ) { emb.page = {}; }

emb.page.mfaEnter = function($page) {
  var _ = underscore,
    $form = $page.find('form'),
    pageHelper = emb.pageHelper($page),
    $token = $page.find('.mfa-token-row');
  
  function getIdCode() {
    return $page.find( "[name='idcode']" ).val();
  }
  
  function setIdCode(value) {
    $page.find("[name='idcode']").val(value);
  }
  
  function getPassword() {
    return $page.find( "[name='mfa-password']" ).val();
  }
  
  function setPassword(value) {
    $page.find("[name='mfa-password']").val(value);
  }
  
  function getToken(){
    return $page.find('#mfa-token').val();
  }
  
  function setToken(value){
    $page.find('#mfa-token').val(value);
  }
  
  function toggleToken(show){
    if(show){
      $token.removeClass( 'hide' );// show if token cookie saved
    }
    else{
      $token.addClass( 'hide' );// hide if no cookie
    }
  }

  function onMfaSubmit( callback ){   
    $form.unbind('submit')
      .submit(function( e ) {
        //this is for analytics
        $(document).trigger("mfa");
        // Only submit the form if the callback actually returns true
        // (not false or nothing/undefined).
        return callback() ? true : false;
      });
  }

  function showError(errorMsg) {
    emb.alert(errorMsg);
  }
  
  function onPageShow( initMfaEnterCallback ) {
    $page.on('pageshow', function() {
      initMfaEnterCallback();
    });
  }
  
  $('#mfaentercode > a.home').on('click', function(evt) {
    evt.preventDefault(); //instead of redirecting to home, go through change page fn to clean url first -- avoid 2002/refresh error on login
    $.mobile.changePage( "index.html", {dataUrl:"/index.html#home"}); 
    return false;
  });
  
  return {
    $page : $page,
    getIdCode : getIdCode,
    setIdCode : setIdCode,
    getPassword : getPassword,
    setPassword : setPassword,
    getToken: getToken,
    setToken: setToken,
    toggleToken: toggleToken,
    onPageShow: onPageShow,
    onMfaSubmit : onMfaSubmit,
    showError : showError,
    pageHelper: pageHelper
  };
};
