(function() {
  var _ = underscore;
  
  emb.disclosuresPresenter = function( disclosures ) {
    return _.map( disclosures, function( disclosure ) {
      return {
        TITLE: disclosure.title,
        PARAGRAPHS: disclosure.text.split("\n")
      };
    });
  };
  
}());