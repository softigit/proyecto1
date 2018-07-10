emb.initializeContent = function (changePageFn, service, onProfileChangedHandler) {
  delete emb.initializeContent;

  var _ = underscore,
      pages = {
        morePage: emb.page.more( $('div#more') ),
        privacyNoticePage: emb.page.privacyNotice( $("div#privacynotice") ),
        contactUsPage: emb.page.contactUs( $("div#contactus") ),
        getMoreContactsPage: emb.page.getMoreContacts( $('div#get-more-contacts-list') ),
        getMoreContactsDetailsPage: emb.page.getMoreContactsDetails( $('div#get-more-contacts-details') ),
			  disclosuresPage: emb.page.disclosuresList($('#disclosures')),
			  disclosureDetailsPage: emb.page.disclosureDetails($('#disclosure-details')),
			  faqsPage: emb.page.faqs($("div#faqs")),
			  faqsQuestions: emb.page.faqsQuestions($("#faqs-questions")),
			  faqsQuestionDetail: emb.page.faqsQuestionDetail($("#faqs-question-detail"))
      },
      presenters = {
        getMoreContacts: emb.getMoreContactsPresenter,
        disclosures: emb.disclosuresPresenter,
        faqs: emb.faqsPresenter
      },
      deviceDetector=emb.deviceDetector(window.redirectShared(),emb.device()),
      contentService = emb.service.content( service, emb.urls ),
      redirect = window.redirect(
        window.location,
        function(url) {window.open(url, '_blank');}
      ),
      contentController = emb.controller.content( 
        pages,
        changePageFn,
        contentService,
        emb.alert,
        presenters,
        history,
        deviceDetector
      ),
      
      faqsController = emb.controller.faqs(
        pages,
        emb.service.faqs( service, emb.urls ),
        emb.alert,
        presenters,
        history,
        changePageFn
      ),
      
      privacyPolicyController = emb.controller.htmlContent(
          {htmlContentPage: emb.page.htmlContent($('#onlineprivacypolicy'))},
          contentService,
          emb.alert,
          changePageFn,
          emb.urls.privacyPolicy
      ),
      
      indicatorDetailsController = emb.controller.htmlContent(
        {htmlContentPage: emb.page.htmlContent($('#indicatorDetails'))},
        contentService,
        emb.alert,
        changePageFn,
        emb.urls.detailsIndicator
      );
      
      
      
  
  $( '#get-more-contacts-list' ).on( 'pagebeforeshow', function() {
    contentController.initializeContactUs();
  });

  $( '#disclosuresLink' ).on( 'click', function( e ) {
     contentController.showDisclosuresList();
   });

  $('#onlineprivacypolicy').on('pagebeforeshow', function() {
    privacyPolicyController.loadHtmlContent();
  });

  $('#privacynotice').on('pagebeforeshow', function() {
    contentController.loadPrivacyNotice();
  });
  
  $('#indicatorDetails').on('pagebeforeshow', function() {
    indicatorDetailsController.loadHtmlContent(emb.urls.detailsIndicator);
  });
  
  if ( onProfileChangedHandler ) {
    onProfileChangedHandler( function(profile) {
      setTimeout(_.bind( contentController.profileLoaded, contentController), 1, profile);
    });
  }

  return {
    contentController: contentController,
    faqsController: faqsController
  };
};
