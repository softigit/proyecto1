emb.page = emb.page || {};

emb.page.getMoreContactsDetails = function( $page ) {

  var _ = underscore,
      $detailsContainer = $page.find( '.contact-details-container' ),
      $contactTemplate  = $page.find( '.TMPL_getMoreContactsDetails' ),
      pageHelper = emb.pageHelper( $page );

  function updateContactDetailsInDom( contactElement ) {
    $(contactElement).appendTo( $detailsContainer );
    pageHelper.refreshListView( $detailsContainer );
  }
  
  function preventPhoneCalls(){
    $page.find("a[href^=tel]").each(
      function(){
        var $link=$(this);
        $link.replaceWith($link.html());
      }
    );
  }

  function renderContactToElement( contactVO ) {
    return $contactTemplate.tmpl( contactVO );
  }

  function updateDetails( contactVO ) {
    updateContactDetailsInDom( renderContactToElement( contactVO ) );
  }

  function clearDetails() {
    $detailsContainer.empty();
  }

  return {
    $page: $page,
    pageHelper: pageHelper,
    updateDetails: updateDetails,
    clearDetails: clearDetails,
    preventPhoneCalls: preventPhoneCalls
  };
};
