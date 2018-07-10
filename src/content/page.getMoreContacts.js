emb.page = emb.page || {};

emb.page.getMoreContacts = function( $page ) {
  var _ = underscore,
      $listContainer = $page.find( '.get-more-contacts-list' ),
      $contactTemplate = $page.find( '.TMPL_getMoreContactsList' ),
      onContactClickedHandler = _.identity,
      onPageShowHandler = _.identity,
      pageHelper = emb.pageHelper( $page );

  function updateContactsListInDom( contactsElements ) {
    $listContainer.empty();
    $(contactsElements).appendTo( $listContainer );
    pageHelper.refresh($listContainer);
  }

  function renderContactsToElements( contactsVO ) {
    return _.map( contactsVO, function(contactVO){
      var result = $contactTemplate.tmpl( contactVO );
      return result;
    });
  }

  function updateContactsList( contactsVO ) {
    updateContactsListInDom( renderContactsToElements( contactsVO ) );
  }

  function onContactClicked( handler ) {
    onContactClickedHandler = handler;
  }

  $page.delegate( '.contact-details', 'click', function( e ) {
    var contactVO = $(e.target).tmplItem().data;
    onContactClickedHandler( contactVO );
  });

  return {
    $page: $page,
    pageHelper: pageHelper,
    onContactClicked: onContactClicked,
    updateContactsList: updateContactsList
  };
};
