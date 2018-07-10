if( typeof emb.page === 'undefined' ) { emb.page = {}; }

emb.page.loggingOn = function($page) {
  var _ = underscore;

  return {
    $page: $page
  };
};

