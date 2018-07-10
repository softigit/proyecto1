emb.initializeRewards = function(url, rewardsService, changePageFn) {
  
  function urlContainsFlowID() {
    return (/\\?\.*flowID=ultimaterewards/).test( url );
  }

  function redeemReward ( accountId, accountName ) {
    var serviceParams = {},
      pages = {
        urLogonError: emb.page.rewardDetails($('#urlogonfailed')),
        urAccountError: emb.page.rewardDetails( $("#redeemrewardfailed") )
      },
      dest = emb.cookieStore.getCookie('emb.urDest');
    if(accountId){
      serviceParams.accountId = accountId;
    }
    if ( dest && dest !=="" ) {
      emb.cookieStore.saveCookie('emb.urDest', "");
      serviceParams.dest = dest;
    }

    function goToExternalPageFn(url) {
      if(url) {
        window.location.href = url;
      }
        return false;
    }

    function redeemRewardSuccesshandler(rewardData) {
      // If we get back a logoff url for the vendor, save that to a cookie to be called later when logging off.
      if (rewardData.rewardsLogOffURI) {
        emb.cookieStore.saveCookie('emb.vendorLogoffUrl', rewardData.rewardsLogOffURI, {expires: 1});
      }
      
      goToExternalPageFn( rewardData.returnURI );
    }

    function redeemRewardErrorHandler(errors, data) {
      emb.console.debug("Card Rewards call failed with error " + errors);
      if(data && data.errors && data.errors[0].code !== 4615) {
        pages.urAccountError.updateRewardError( {MESSAGE:errors, NICKNAME: accountName} );
        changePageFn(pages.urAccountError.$page, true);
      } else {
        emb.alert( errors );
        changePageFn(pages.urLogonError.$page, true);
      }
      emb.page.loader.unblockOverlay();
    }

    rewardsService.redeemReward( serviceParams )
      .error(redeemRewardErrorHandler)
      .success(redeemRewardSuccesshandler);
  }

  return {
    urlContainsFlowID: urlContainsFlowID,
    redeemReward: redeemReward
    };
};

