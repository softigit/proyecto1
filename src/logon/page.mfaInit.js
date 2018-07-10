emb.page = emb.page || {};

emb.page.mfaInit = function( $page ) {
  function onNextSubmit( callback ){
    $page.undelegate( 'a[href="#mfachoose"]', 'click' )
      .delegate( 'a[href="#mfachoose"]', 'click', function(){
        callback();
    });
  }

  function onPageShow( prepareForMfaHandler ) {
    $page.on('pageshow', function() {
      var spid = $.query.get('spid');
      prepareForMfaHandler( spid );
      
      //If we just change hash and the user refreshes the page after being moved to #home
      //the code executed in boot will detect the secauth request param and will move again to mfa-init
      //causing a 2002 issue
      //To avoid all that, we'll just refresh in this particular case.
      $page.find('a.home').attr('href','index.html');
    });
  }

  function showContent() {
    $page.find('.mfainit').removeClass('hide');
  }

  return {
    $page : $page,
    onNextSubmit : onNextSubmit,
    onPageShow: onPageShow,
    showContent: showContent
  };
};
