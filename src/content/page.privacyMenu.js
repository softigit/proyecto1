emb.page = emb.page || {};

emb.page.privacyMenu = function($page) {
  var _ = underscore,
      pageHelper = emb.pageHelper( $page ),
      chasePrivacyPolicyClickHandler = _.identity;

  $page.on('pageshow', function( e ) {

    $page.find('#chasePrivacyPolicy').off('click').on('click', function() {
      chasePrivacyPolicyClickHandler();
    });
  });

  function setChasePrivacyPolicyClickHandler(fn) {
      chasePrivacyPolicyClickHandler = fn;
    }

  return {
    $page: $page,
    setChasePrivacyPolicyClickHandler: setChasePrivacyPolicyClickHandler
  };
};
