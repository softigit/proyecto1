emb.page = emb.page || {};

emb.page.disclosureDetails = function( $page ) {
  var _ = underscore,
      $detailsContainer = $page.find( '#disclosures-item' ),
      $disclosureTemplate = $page.find( '.TMPL_disclosureDetails' );

  function updateDisclosureInDom( disclosureElement ) {
    $detailsContainer.empty();
    $(disclosureElement).appendTo( $detailsContainer );
    try{
      $detailsContainer.listview('refresh');
    }catch( harmlessExceptionWhichCanBeIgnored ){ }
    
  }

  function updateDisclosureDetails( disclosureVO ) {
    updateDisclosureInDom( $disclosureTemplate.tmpl( disclosureVO ) );
  }

  return {
    $page: $page,
    updateDisclosureDetails: updateDisclosureDetails
  };
};
