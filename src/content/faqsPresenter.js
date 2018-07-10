(function() {
  var _ = underscore;
  emb.faqsPresenter = function( topics ) {
    return {
      FAQS_TOPIC: _.keys(topics)[0],
      FAQS_QUESTIONS: _.map((_.values(topics)[0]),function(topic) {
        return {
          QUESTION: _.keys(topic)[0],
          ANSWERS: _.values(topic)[0].split("\n"),
          TOPIC: _.keys(topics)[0]
        };
      })
    };
  };
}());