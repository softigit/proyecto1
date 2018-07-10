emb.page = emb.page || {};

emb.page.more = function( $page ) {

  function removeDisclosuresMenuItem() {
    $page.find('li.disclosures').remove();
  }

  function removePrivacyMenuItem() {
    $page.find('li.privacy').remove();
  }

  return {
    $page: $page,
    removeDisclosuresMenuItem: removeDisclosuresMenuItem,
    removePrivacyMenuItem: removePrivacyMenuItem
  };
};
