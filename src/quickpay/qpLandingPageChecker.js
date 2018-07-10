/*jslint regexp: true */
emb.qpLandingPageChecker = function( url, profile, changePageFn, pageLoader, alertFn, splashChecker, sessionManager, qpMediator ) {
  function urlContainsFlowID() {
    return (/\\?.*flowID=quickpay/).test( url );
  }

  function isEnrolledInQuickPay() {
    return profile.privileges().quickPay.state === 'allowed';
  }

  function isEligibleForQuickPay() {
    return profile.privileges().quickPay.state === 'blocked';
  }
  
  function showAccountPage() {
    pageLoader.unblockOverlay();
    changePageFn( '#accounts',true);
  }

  function executeQPRedirect() {
    var logonPage = ( urlContainsFlowID() ) ? "index.html#qp" : "index.html#logon",
        numberOfBusinessAccounts,
        numberOfPersonalAccounts,
        path;
     
    if (profile.isNonChaseUser() || urlContainsFlowID()) {
    // we need to check feature splash from auth profile featureSplashForFeatureType
      splashChecker.featureSplashForFeatureType(profile, 'quickpay', function(splashMessage) {
        if (splashMessage) {
          alertFn(splashMessage); 
          //check if user is only QP user , if yes then redirect ot logon page. because nothing to show for him    
          if (profile.isNonChaseUser()) {
            sessionManager.doRedirect(function() { window.location = logonPage; });
          } else {//if not QP user then redirect to my accounts page
            showAccountPage();
          }

        } else { //QP is not splashed
          //check if non chase user is enrolled in quickpay?
          //if not there is nothing for him to do anything
          //show QP enroll message and kick him back to logon page
          if(profile.isNonChaseUser() && !isEnrolledInQuickPay())
          {
            alertFn( emb.messages.errors.quickPayEnrollmentError );
            sessionManager.doRedirect(function() { window.location = logonPage; });
            return;
          }
          else if ( urlContainsFlowID() ) {
            //if no splash then check for eligibility criteria, 
            //if only eligible for QP then show QP enrollment message and sends back to my account page
            if (isEligibleForQuickPay()) {
              alertFn( emb.messages.errors.quickPayEnrollmentError );
              showAccountPage();
              return;
            }
            if ( isEnrolledInQuickPay() || profile.isNonChaseUser()) {
              qpMediator.loadQuickPayTodoReference(function() {
                emb.console.log("*** QP login. use redirect to todo list or qp options depends on todo count");
                qpMediator.displayQuickpayLandingPage(function(){
                  pageLoader.unblockOverlay();
                });
              });
            } else {
              showAccountPage();
            }
          } else {
            //call new todo count reference call. if todo count>0 then call todo list service call
            qpMediator.loadQuickPayTodoReference(function(todoCount) {
              pageLoader.unblockOverlay();
              emb.console.log("*** found that QP is not splashed.  changing to a QP page.");
              qpMediator.displayQuickpayLandingPage();
            });
          } 
        }
      });
    } else {
      showAccountPage();
    }
  }

  return {
    urlContainsFlowID: urlContainsFlowID,
    executeQPRedirect: executeQPRedirect
  };
};
