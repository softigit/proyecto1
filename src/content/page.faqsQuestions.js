emb.page = emb.page || {};

emb.page.faqsQuestions = function( $page ) {
  var _ = underscore,
	pageHelper = emb.pageHelper($page),
  $questionsListContainer = $page.find( '.faqs-questions-list' ),
  $questionsTemplate = $page.find( '.TMPL_faqsQuestionsList' ),
  onQuestionClickedHandler = _.identity;
	
  function rendorQuestionsToElements( questions ) {
    return _.map( questions, function(questionVO){
      var result = $questionsTemplate.tmpl( questionVO );
      return result;
    });
  }
  
  function updateTopicHeader(topic) {
    $page.find('.faqs-questions-topic').text(topic);
  }
  
  function updateQuestionsInDom( questionsElements ) {
    $questionsListContainer.empty();    
    $(questionsElements).appendTo( $questionsListContainer );

    try{
      $questionsListContainer.listview('refresh');
    }catch( execptionBecauseTheListViewHasNotBeenInitializedYet ){
//      $questionsListContainer.listview();
    }

  }  
	
  function updateQuestions(topicVO) {
    updateTopicHeader(topicVO.FAQS_TOPIC);
    updateQuestionsInDom(rendorQuestionsToElements( topicVO.FAQS_QUESTIONS ) );
  }
  
  function onQuestionClicked(handler){
    onQuestionClickedHandler = handler;    
  }
  
  $page.delegate( '.faqs-questions', 'click', function( e ) {
    var questionVO = $(e.target).tmplItem().data;
    onQuestionClickedHandler( questionVO);
  });
    
  return {
    $page: $page,  
    updateQuestions: updateQuestions,
    onQuestionClicked: onQuestionClicked
  };
};