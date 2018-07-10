if( typeof emb.page === 'undefined' ) { emb.page = {}; }

emb.page.home = function($page) {
  var $linkToApp = $page.find('.link-to-app');

  function removeAppLogo() {
    $linkToApp.empty();
  }
  
  function makeSureCopyRightDateIsAccurate (year) {
    $("#copy", "div#home_footer").html ("&copy; " + year + " JPMorgan Chase &amp; Co.");
  }

  function displayAppLogo( url, imageClass, imageName ) {
    var $a = $("<a>").attr("href", url),
        $img = $a.append($("<img>").addClass("app-logo " + imageClass).attr("src", "images/" + imageName).attr("data-send", "yes").attr("alt", "Download App from Store"));
    
    $linkToApp.append($a);
  }

  function isActive() {
    // Not using is(':visible') as this might actually be called before
    // page has been rendered.
    return window.location.hash === '' || window.location.hash === '#home';
  }

  return {
    removeAppLogo: removeAppLogo,
    makeSureCopyRightDateIsAccurate:makeSureCopyRightDateIsAccurate,
    displayAppLogo: displayAppLogo,
    isActive: isActive,
    $page: $page
  };
};