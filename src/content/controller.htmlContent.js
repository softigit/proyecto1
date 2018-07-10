/*jslint regexp:true*/

emb.controller = emb.controller || {};

emb.controller.htmlContent = function(pages, service, embAlert , changePageFn, contentUrl) {
  var _ = underscore,
      url = contentUrl;
  
  function loadHtmlContent(contentUrl) {
    url = (contentUrl || url);
    
    function errorHandler(errors) {
      emb.console.debug("html content call failed with error " + errors);
      var parsedContent = {
        TITLE: "Let's try that again.",
        BODY: '<p class="information-text-light">Something happened - a lost connection or other temporary issue - that kept us from loading the content.  Please <a id="reloadContent" href="javascript:void(0);">reload</a> or try again later.</p>'
      };
      pages.htmlContentPage.updateContent(parsedContent);
    }
    
    function successHandler(responseContent) {
      var parsedContent = emb.htmlParser.parseTitleAndBodyFromHtml(responseContent);
      pages.htmlContentPage.updateContent(parsedContent);
    }

    emb.console.debug('loading html content');
    service.loadHtmlContent(url)
      .error(errorHandler)
      .success(successHandler);
  }
  
  pages.htmlContentPage.setReloadCallback(function() {loadHtmlContent.call(this);});
  
  return {
      loadHtmlContent: loadHtmlContent
  };
  
};
