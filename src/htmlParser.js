/*jslint regexp:true*/

(function() {
  emb.htmlParser = {};
  
  emb.htmlParser.parseTitleAndBodyFromHtml = function(html) {
    var titleMatch = html.match(/<title[^>]*>((.|[\n\r])*)<\/title>/im),
        bodyMatch = html.match(/<body[^>]*>((.|[\n\r])*)<\/body>/im),
        title = titleMatch && titleMatch.length > 0 ? titleMatch[1] : '',
        body = bodyMatch && bodyMatch.length > 0 ? bodyMatch[1] : '';
        
    return {
      TITLE: title,
      BODY: body
    };
  };
}());
