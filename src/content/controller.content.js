emb.controller = emb.controller || {};

emb.controller.content = function( pages, changePageFn, service, embAlert, presenters, htmlHistory, deviceDetector) {
  var _ = underscore,
      privacyNoticeLoaded = false,
      currentHolidays = [
        new Date (Date.parse("2013-01-01T00:00:00.000-05:00")),
        new Date (Date.parse("2013-01-21T00:00:00.000-05:00")),
        new Date (Date.parse("2013-02-18T00:00:00.000-05:00")),
        new Date (Date.parse("2013-05-27T00:00:00.000-04:00")),
        new Date (Date.parse("2013-07-04T00:00:00.000-04:00")),
        new Date (Date.parse("2013-09-02T00:00:00.000-04:00")),
        new Date (Date.parse("2013-10-14T00:00:00.000-04:00")),
        new Date (Date.parse("2013-11-11T00:00:00.000-05:00")),
        new Date (Date.parse("2013-11-28T00:00:00.000-05:00")),
        new Date (Date.parse("2013-12-25T00:00:00.000-05:00"))
      ];

  function preventCallingIfNeeded($page){
    if(!deviceDetector.supportCall()){
      $page.preventPhoneCalls();
    }
  }
  
  preventCallingIfNeeded(pages.contactUsPage);
  function loadPrivacyNotice() {
    function errorHandler(errors) {
      emb.console.debug("privacy notice call failed with error " + errors);
      embAlert(emb.messages.errors.signalServiceError);
    }

    function successHandler(newContent) {
      privacyNoticeLoaded = true;
      pages.privacyNoticePage.updateContent(newContent);
    }

    if (!privacyNoticeLoaded) {
      emb.console.debug('loading privacy notice');
      service.loadPrivacyNotice()
        .error(errorHandler)
        .success(successHandler);
    }
  }

  function loadMoreContacts() {
    service.loadGetMoreContacts()
      .success( function( moreContacts ) {
        emb.console.log( 'service.content.loadGetMoreContacts succeeded: ', moreContacts );
        pages.getMoreContactsPage.updateContactsList(_.map( moreContacts, function(contact) {
            return presenters.getMoreContacts( contact ); }));
      })
      .error( function( errorData ) {
        emb.console.log( 'service.content.loadGetMoreContacts succeeded: ', errorData );
        embAlert( emb.messages.errors.signalServiceError );
        htmlHistory.back();
      });
  }
  
  function showDisclosuresList() {
    service.loadDisclosures()
      .success( function( disclosures ) {
        changePageFn( pages.disclosuresPage.$page );
        pages.disclosuresPage.updateDisclosuresList( presenters.disclosures( disclosures ) );
        if (disclosures.length) {
          pages.disclosuresPage.hideNoDisclosuresMessage();
        } else {
          pages.disclosuresPage.showNoDisclosuresMessage();
        }
      })
      .error( function( errorData ) {
        emb.console.log( 'service.content.loadDisclosures succeeded: ', errorData );
        embAlert( emb.messages.errors.signalServiceError );
      });
  }

  function loadHolidays() {
    emb.console.debug('loading holidays');
    service.loadHolidays()
      .error(function(errors){
        emb.console.debug("holiday loading failed with error: " + errors);
      })
      .success( function(holidayList) {
        currentHolidays = holidayList;
      });
  }

  function profileLoaded(parsedProfile) {
    loadHolidays();

    if(parsedProfile.isNonChaseUser() || parsedProfile.showLegalInfo){
      pages.morePage.removeDisclosuresMenuItem();
      pages.morePage.removePrivacyMenuItem();
    }
  }

  function holidays() {
    return currentHolidays;
  }

	function initializeContactUs() {
    loadMoreContacts();
	}
  
  pages.getMoreContactsPage.onContactClicked( function( contactVO ) {
    pages.getMoreContactsDetailsPage.clearDetails();
    changePageFn( pages.getMoreContactsDetailsPage.$page );
    pages.getMoreContactsDetailsPage.updateDetails( contactVO );
    preventCallingIfNeeded(pages.getMoreContactsDetailsPage);
  });

  pages.disclosuresPage.onDisclosureClicked( function( disclosureVO ) {
    disclosureVO.TITLE = "*" + disclosureVO.TITLE;
    changePageFn( pages.disclosureDetailsPage.$page );
    pages.disclosureDetailsPage.updateDisclosureDetails( disclosureVO );
  });

  return {
    loadPrivacyNotice: loadPrivacyNotice,
    profileLoaded: profileLoaded,
    loadHolidays: loadHolidays,
    holidays: holidays,
		initializeContactUs: initializeContactUs,
		showDisclosuresList: showDisclosuresList
  };
};
