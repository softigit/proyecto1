emb.controller = emb.controller || {};

emb.controller.agreement = function(pages, changePageFn, service, embAlert, redirectToRootFn, redirectToLogonFn, goBackFn, cookieStore, dateCalculator, queryParameters) {
  var _ = underscore,
      moreAgreementContentLoaded = false;
  
  function parseAgreementUrl(url) {

    /*
      This will parse this:
      https://m.chase.com/content.html?contentUrl={encoded URL}&previousContentUrl={other encoded URL}&anotherParam=anotherValue

      Into this:
      {
        contentUrl: {decoded URL},
        previousContentUrl: {other decoded URL},
        anotherParam: anotherValue
      }
    */

    var questionMarkSplit = url.split('?'),
        ampersandSplit = questionMarkSplit[1].split('&'),
        parameters = {};

    _.each(ampersandSplit, function(parameterNameAndValue) {
      var equalSignSplit = parameterNameAndValue.split('='),
          value;

      if (equalSignSplit[0] === 'contentUrl' || equalSignSplit[0] === 'previousContentUrl') {
        value = decodeURIComponent(equalSignSplit[1]);
      } else if (equalSignSplit[0] === 'showAcceptanceText') {
        value = true;
      } else {
        value = equalSignSplit[1];
      }
      parameters[equalSignSplit[0]] = value;
    });

    return parameters;
  }

  function startAgreementAcceptFlow(profileAgreement) {
  
    function loadAgreementContentAccept() {
      var parsedUrl = parseAgreementUrl(profileAgreement.contentURL);
      service.loadAgreementContent(parsedUrl.contentUrl)
        .success(function(content) {
          var parsedContent = {
                TITLE: profileAgreement.name,
                BODY: content
              },
              contentOptions = {
                hideAcceptanceText: !(queryParameters.showAcceptanceText || parsedUrl.showAcceptanceText)
              };

          pages.agreementContent.updateContent(parsedContent, contentOptions);
          
          if (emb.features.IS_EMBEDDED) {
            pages.agreementContent.hideHeaderAndFooter();
          }
        })
        .error(function(error) {
          embAlert(error);
          redirectToLogonFn();
        });    
    }
    
    function presentAgreement() {
      changePageFn('#agreementContent');
    }
    
    function acceptAgreement() {
      service.acceptAgreement(profileAgreement.code)
        .success(function(content) {
          redirectToRootFn();
        })
        .error(function(error) {
          embAlert(error);
          goBackFn();
        });
    }
    
    loadAgreementContentAccept(profileAgreement);
    
    // Setup the initial dialog
    pages.agreementDialog.setInfoText(profileAgreement.infoText);
    pages.agreementDialog.setOkButtonCallback(presentAgreement);
    
    // Show the initial dialog
    // Setting a cookie to track if the dialog has already been presented to make sure we don't show it more than once during a session.
    if (cookieStore.getCookie('emb.agreementdialog')) {
      presentAgreement();
    } else {
      cookieStore.saveCookie('emb.agreementdialog', true, {expires: dateCalculator.minutesFromNow(10)});
      changePageFn('#agreementDialog');
    }
    
    pages.agreementContent.setCancelButtonCallback(function() {
      redirectToLogonFn();
    });
    
    pages.agreementContent.setOkButtonCallback(function() {
    
      // Setup the confirm dialog
      pages.agreementConfirm.setInfoText(profileAgreement.confirmationText);
      pages.agreementConfirm.setContinueButtonCallback(acceptAgreement);
      
      changePageFn('#agreementConfirm');
    });
  }
  
  function loadAgreementList() {
    service.loadAgreementList()
      .success(function(content) {
        var parsedContent = _.map(content.agreements, function(item) {
          var parsedUrl = parseAgreementUrl(item.contentURL);
          return {
            URL: parsedUrl.contentUrl,
            NAME: item.name,
            PREVIOUS_URL: parsedUrl.previousContentUrl
          };
        });
        
        pages.agreementList.updateContent(parsedContent);
      })
      .error(function(error) {
        embAlert(error);
        goBackFn();
      });    
  }
  
  function loadAgreementContentMore(agreement, loadPreviousVersion) {
    
    var url = loadPreviousVersion ? agreement.PREVIOUS_URL : agreement.URL;
    
    service.loadAgreementContent(url)
      .success(function(content) {
        var data = {
              TITLE: agreement.NAME,
              BODY: content,
              PREVIOUS_URL: agreement.PREVIOUS_URL,
              CURRENT_BUTTON_STYLE: loadPreviousVersion ? 'content-ui-btn-inactive' : '',
              PREVIOUS_BUTTON_STYLE: loadPreviousVersion ? '' : 'content-ui-btn-inactive'
            },
            updateOptions = {
              hideAcceptanceText: !queryParameters.showAcceptanceText
            };
        pages.moreAgreementContent.updateContent(data, updateOptions);
        
        if (emb.features.IS_EMBEDDED) {
          pages.moreAgreementContent.hideHeaderAndFooter();
        }
        
        changePageFn('#moreAgreementContent');
        moreAgreementContentLoaded = false;
        
        pages.moreAgreementContent.setCurrentVersionButtonClickHandler(function() {
          if (loadPreviousVersion) {
            loadAgreementContentMore(agreement, false);
          }
        });
        
        pages.moreAgreementContent.setPreviousVersionButtonClickHandler(function() {
          if (!loadPreviousVersion) {
            loadAgreementContentMore(agreement, true);
          }
        });

      })
      .error(function(error) {
        embAlert(error);
      });
  }
  
  pages.agreementList.setAgreementItemClickHandler(function(agreement) {
    moreAgreementContentLoaded = true;
    loadAgreementContentMore(agreement);
  });

  pages.privacyMenu.setChasePrivacyPolicyClickHandler(function(agreement) {
    moreAgreementContentLoaded = true;
    loadAgreementContentMore({URL:emb.utils.getCQ5Url()});
  });
  
  pages.moreAgreementContent.setPageBeforeShowHandler(function() {
    var agreement = {
          URL: queryParameters.contentUrl,
          NAME: undefined,
          PREVIOUS_URL: queryParameters.previousContentUrl
        };
        
    if (!moreAgreementContentLoaded) {
      if (!queryParameters.contentUrl) {
        goBackFn();
      }
      loadAgreementContentMore(agreement);
    }
  });
  
  return {
    startAgreementAcceptFlow: startAgreementAcceptFlow,
    loadAgreementList: loadAgreementList
  };
};
  