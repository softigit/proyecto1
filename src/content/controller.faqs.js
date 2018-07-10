emb.controller = emb.controller || {};

emb.controller.faqs = function(pages, service, embAlert , presenters, history, changePageFn) {
  var _ = underscore;

  function generateFaqsVO(faqs) {
    return _.map(faqs, function(topic){
      return presenters.faqs(topic);
    });
  }

  pages.faqsPage.onPageShow(function() {
    if ( !pages.faqsPage.hasData() ) {
    service.loadFaqs()
      .success(function(faqs){
        pages.faqsPage.updateFaqs( generateFaqsVO(faqs));      
      })
      .error(function(errorData) {
        embAlert( emb.messages.errors.signalServiceError );
        history.back();
      });
    }
  });  

  pages.faqsPage.onTopicClicked( function( topicVO ) {
    changePageFn( pages.faqsQuestions.$page );
    pages.faqsQuestions.updateQuestions( topicVO );
  });

  pages.faqsQuestions.onQuestionClicked( function( questionVO ) {
    changePageFn( pages.faqsQuestionDetail.$page );
    pages.faqsQuestionDetail.updateQuestionDetail( questionVO );
  });

  return {};
};
  