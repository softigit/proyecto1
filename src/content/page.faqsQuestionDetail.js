emb.page = emb.page || {};

emb.page.faqsQuestionDetail = function( $page ) {
  var _ = underscore,
	pageHelper = emb.pageHelper($page),
  $questionsItemContainer = $page.find( '.faqs-question-item' ),
  $questionsDetailTemplate = $page.find( '.TMPL_faqsQuestionDetail' );

  
  function updateQuestionDetail(questionVO) {
    $questionsItemContainer.empty();    
    
    $page.find('.faqs-questions-topic').text(questionVO.TOPIC);
    
    $questionsDetailTemplate.tmpl( questionVO ).appendTo($questionsItemContainer);
    pageHelper.refreshListView( $questionsItemContainer );
  }

  return {
    $page: $page,
    updateQuestionDetail: updateQuestionDetail
  };
};