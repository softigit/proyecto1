emb.page = emb.page || {};

emb.page.disclosuresList = function( $page ) {
  var _ = underscore,
      $listContainer = $page.find( '.disclosures-list' ),
      $disclosureTemplate = $page.find( '.TMPL_disclosuresList' ),
      $noDisclosuresMessage = $page.find('.no-disclosures'),
      onDisclosureClickHandler = _.identity,
      pageHelper = emb.pageHelper( $page );

  function updateDisclosuresListInDom( disclosureElements ) {
    $listContainer.empty();
    $(disclosureElements).appendTo( $listContainer );
    pageHelper.refreshListView( $listContainer );
  }

  function renderDisclosuresToElements( disclosuresVO ) {
    return _.map( disclosuresVO, function(disclosureVO){
      var result = $disclosureTemplate.tmpl( disclosureVO );
      return result;
    });
  }

  function updateDisclosuresList( disclosuresVO ) {
    updateDisclosuresListInDom( renderDisclosuresToElements( disclosuresVO ) );
  }

  function showNoDisclosuresMessage() {
    $noDisclosuresMessage.show();
  }

  function hideNoDisclosuresMessage() {
    $noDisclosuresMessage.hide();
  }

  function onDisclosureClicked( handler ) {
    onDisclosureClickHandler = handler;
  }

  $page.delegate( '.disclosure-details', 'click', function( e ) {
      var disclosureVO = $(e.target).tmplItem().data;
      onDisclosureClickHandler( disclosureVO );
  });

  return {
    $page: $page,
    onDisclosureClicked: onDisclosureClicked,
    updateDisclosuresList: updateDisclosuresList,
    showNoDisclosuresMessage: showNoDisclosuresMessage,
    hideNoDisclosuresMessage: hideNoDisclosuresMessage
  };
};
