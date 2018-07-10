emb.page = emb.page || {};

emb.page.faqs = function($page) {
	var _ = underscore,
	pageHelper = emb.pageHelper($page),
  onPageShowHandler = _.identity,
  onTopicClickedHandler = _.identity,
  $listContainer = $page.find( '.faqs-list' ),
  $faqsTemplate = $page.find( '.TMPL_faqsList' );
	
  function renderFaqsToElements( faqsVO ) {
    return _.map( faqsVO, function(topicVO){
      var result = $faqsTemplate.tmpl( topicVO );
      return result;
    });
  }
  
  function updateFaqsInDom( faqsElements ) {
    $(faqsElements).appendTo( $listContainer );
    $listContainer.listview('refresh');
  }  
	
	function updateFaqs(faqsVO) {
    updateFaqsInDom( renderFaqsToElements( faqsVO ) );	  
	}
	
  function onPageShow( handler ) {
    onPageShowHandler = handler;
  }
  
  function hasData() {
    return $listContainer.find('li').length > 0;
  }
  
  function onTopicClicked( handler ) {
    onTopicClickedHandler = handler;
  }  
  
  $page.on( 'pageshow', function() {
    onPageShowHandler();
  }); 

  $page.delegate( '.faqs-topics', 'click', function( e ) {
    var topicVO = $(e.target).tmplItem().data;
    onTopicClickedHandler( topicVO );
  });

	return {
    $page: $page,
    onPageShow : onPageShow,
    onTopicClicked: onTopicClicked,
	  updateFaqs: updateFaqs,
	  hasData: hasData
	};
};
