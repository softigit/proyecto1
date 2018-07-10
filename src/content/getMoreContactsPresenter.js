(function() {
  var _ = underscore;

  function extractValues( detailsString ) {
    return detailsString.split( '\n' );
  }

  emb.getMoreContactsPresenter = function( contact ) {
    return {
      CONTACT_NAME: _.keys( contact )[0],
      CONTACT_DETAILS: extractValues( _.values( contact )[0] )
    };
  };
}());