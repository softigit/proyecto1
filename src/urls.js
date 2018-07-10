emb.urls = (function(){
  var _ = underscore,
      urlBase = window.location.protocol+"//"+window.location.host,
      baseUrls = {
        siteminder: urlBase + '/siteminder',
        gws: urlBase + "/gws",
        psr: urlBase + "/PSRWeb"
      },
      urlMap;

  function gwsUrl( path ) {
    return baseUrls.gws + path;
  }

  function siteminderUrl( path ) {
    return baseUrls.siteminder + path;
  }

  function psrUrl( path ) {
    return baseUrls.psr + path;
  }
  
  //generates the PSR web - content url from documentid
  function createPsrHtmlUlrFromDocumentId(documentid){
    return baseUrls.psr + "/resource/list.action?documentId=" + documentid + "&cache=true&applId=GATEWAY&channelId=MOE&type=raw";
  }

  urlMap = {
    login: siteminderUrl( '/auth/fcc/login' ),
    logout: gwsUrl('/gws/online/secure/logoff/v20110918/logoff.action'),
    keepAlive: gwsUrl('/gws/online/secure/profile/v20110515/keep-alive.action'),
    otpContactList: gwsUrl( '/gws/online/otp/contact/list.action' ),
    otpSend: gwsUrl('/gws/online/otp/v20110515/send.action'),
    miniProfile: gwsUrl('/gws/online/secure/profile/authorized/v20131117/list.action'),
    locationsList: psrUrl('/location/list.action'),
    splash: psrUrl('/device/splash.action'),
    agreementAccept: gwsUrl('/gws/online/secure/profile/agreement/v20131117/accept.action'),
    agreementList: gwsUrl('/gws/online/secure/profile/agreement/v20131117/list.action'),
    
    wirePayeeList: gwsUrl('/gws/online/secure/wire/payee/v20110515/list.action'),
    wireAdd: gwsUrl('/gws/online/secure/wire/payment/v20110515/add.action'),
    wireModify: gwsUrl('/gws/online/secure/wire/payment/v20110515/modify.action'),
    wireCancel: gwsUrl('/gws/online/secure/wire/payment/v20110515/cancel.action'),
    wireAgreement: psrUrl('/resource/list.action'),
    wirePaymentActivities: gwsUrl( '/gws/online/secure/wire/payment/v20110515/list.action' ),

    quote: gwsUrl('/gws/online/secure/markets/quotes/v20120715/list.action'),
    article: gwsUrl('/gws/online/secure/markets/news/v20120715/list.action'),
    accountActivityList: gwsUrl('/gws/online/secure/account/activity/v20110717/list.action'),
    accountSummaryPositions: gwsUrl('/gws/online/secure/investments/positions/v20131117/list.action'),
    accountDetail: gwsUrl('/gws/online/secure/account/detail/v20110515/list.action'),
    cardRewards: gwsUrl('/gws/online/secure/reward/v20110918/details.action'),
    redeemReward: gwsUrl('/gws/online/secure/reward/v20130721/redeem.action'),

    accountsRelated: gwsUrl('/gws/online/secure/account/related/v20120715/list.action'),
    pingA: gwsUrl('/gws/online/secure/stats/collect.action'),
    pingN: psrUrl('/ping'),

    alertsAccountList: gwsUrl( '/gws/online/secure/alert/account/v20110717/list.action' ),
    alertsHistoryList: gwsUrl( '/gws/online/secure/alert/transaction/v20110515/list.action' ),
    alertsSubscriptionList: gwsUrl( '/gws/online/secure/alert/subscription/v20110515/list.action' ),
    alertsSubscriptionMod: gwsUrl( '/gws/online/secure/alert/subscription/v20110515/modify.action' ),

    offersList: gwsUrl( '/gws/online/secure/offers/v20120318/list.action' ),

    detailsIndicator: psrUrl('/resource/list.action'),
    privacyPolicy: urlBase + '/content/online-privacy-policy.html',
    privacyNotice: psrUrl('/resource/list.action?&cache=true&applId=GATEWAY&channelId=MOE' ),
    disclosures: gwsUrl('/gws/online/secure/account/disclosure/v20110515/list.action'),
    holidays: gwsUrl('/gws/online/secure/holidays/v20110918/list.action'),
    picklist: gwsUrl('/gws/online/secure/picklist/v20120318/list.action'),

    contactUsGetMoreContacts: psrUrl( '/resource/list.action?applId=GATEWAY&channelId=MOE' ),
    faqs: psrUrl( '/resource/list.action?applId=GATEWAY&channelId=MOE' ),

    googleMapsApi: 'https://maps.google.com/maps/api/js?sensor=false',

    iPhoneApp: 'http://itunes.apple.com/us/app/chase-mobile-sm/id298867247',
    iPadApp: 'http://itunes.apple.com/us/app/chase-mobile/id370697773',
    androidApp: 'market://details?id=com.chase.sig.android',

    //R2 GWO Service urls 
    //Start-->
    //BillPay

    //this service is for both list and details. if id passed it gives details otherwise list
    billpayPayeeList: gwsUrl( '/gws/online/secure/billpay/payee/v20121111/list.action' ),
    billpayAdd: gwsUrl( '/gws/online/secure/billpay/payee/v20121111/add.action' ),
    billpayModify: gwsUrl( '/gws/online/secure/billpay/payment/v20121111/modify.action' ),
    billpayCancel: gwsUrl( '/gws/online/secure/billpay/payment/v20121111/cancel.action' ),
    billpayPaymentAdd: gwsUrl( '/gws/online/secure/billpay/payment/v20121111/add.action' ),
    billpayPaymentActivities: gwsUrl( '/gws/online/secure/billpay/payment/activity/v20121111/list.action' ),
    billpayPaymentDetails: gwsUrl( '/gws/online/secure/billpay/payment/v20131117/detail.action' ),
    billpayReference: gwsUrl( '/gws/online/secure/billpay/payment/edit/v20131117/reference.action' ),
    billpayPayeeSearchDirectory: gwsUrl( '/gws/online/secure/billpay/payee/v20121111/search.action' ),
    billpayPayeeSearchAdd: gwsUrl( '/gws/online/secure/billpay/payee/v20121111/search.action' ),
    billpayPayeeDelete: gwsUrl( '/gws/online/secure/billpay/payee/v20121111/delete.action' ),
    billpayPayeeModify: gwsUrl( '/gws/online/secure/billpay/payee/v20121111/modify.action' ),
    billpayAvailableDates: gwsUrl( '/gws/online/secure/billpay/payment/dates/v20131117/list.action' ),

    // Transfers
    transferOptions: gwsUrl( '/gws/online/secure/xfer/payment/option/v20140720/list.action' ),
    transferPaymentActivities: gwsUrl( '/gws/online/secure/xfer/payment/v20121111/list.action' ),
    transfersAdd: gwsUrl('/gws/online/secure/xfer/payment/v20121111/add.action'),
    transfersModify: gwsUrl('/gws/online/secure/xfer/payment/v20121111/modify.action'),
    transfersCancel: gwsUrl('/gws/online/secure/xfer/payment/v20121111/cancel.action'),
    transferReference: gwsUrl('/gws/online/secure/xfer/payment/editReference/v20140720/list.action'),
    transferAvailableDates: gwsUrl( '/gws/online/secure/xfer/payment/dates/v20131117/list.action' ),
    transferPaymentDetails: gwsUrl( '/gws/online/secure/xfer/payment/v20140720/detail.action' ),

    //<--End

    //R2 QuickPay
    quickpayAddRecipient: gwsUrl('/gws/online/secure/quickpay/recipient/v20121111/add.action'),
    quickpayEditRecipient: gwsUrl('/gws/online/secure/quickpay/recipient/v20121111/modify.action'),
    quickpayRecipientList: gwsUrl('/gws/online/secure/quickpay/recipient/v20121111/list.action'),
    quickpayDeleteRecipient: gwsUrl('/gws/online/secure/quickpay/recipient/v20121111/cancel.action'),
    quickpayTodoList: gwsUrl('/gws/online/secure/quickpay/todo/v20121111/list.action'),
    quickpayAddReference: gwsUrl('/gws/online/secure/quickpay/payment/addReference/v20131117/list.action'),
    quickpayTransactionVerify: gwsUrl('/gws/online/secure/quickpay/payment/v20121111/verify.action'),
    quickpayTransactionSubmit: gwsUrl('/gws/online/secure/quickpay/payment/v20121111/add.action'),
    quickpayTransactionModify: gwsUrl('/gws/online/secure/quickpay/payment/v20121111/modify.action'),
    quickpayViewActivity: gwsUrl('/gws/online/secure/quickpay/payment/v20121111/list.action'),
    quickpayCancelTransaction: gwsUrl('/gws/online/secure/quickpay/payment/v20121111/cancel.action'),
  
    quickpayRequestSentDetails: gwsUrl('/gws/online/secure/quickpay/payment/v20131117/requestsent/details.action'),
    quickpayRequestReceivedDetails: gwsUrl('/gws/online/secure/quickpay/payment/v20131117/requestreceived/details.action'),
    quickpayInvoiceRequestReceivedDetails: gwsUrl('/gws/online/secure/quickpay/payment/v20131117/invoicerequestreceived/details.action'),
    quickpayMoneySentDetails: gwsUrl('/gws/online/secure/quickpay/payment/v20131117/moneysent/details.action'),
    quickpayMoneyReceivedDetails: gwsUrl('/gws/online/secure/quickpay/payment/v20131117/moneyreceived/details.action'),
    quickpayInvoiceRequestSentDetails: gwsUrl('/gws/online/secure/quickpay/payment/v20131117/invoicerequestsent/details.action'),

    quickpayDeclineMoney: gwsUrl('/gws/online/secure/quickpay/payment/v20121111/decline.action'),
    quickpayPendingTransactionsList: gwsUrl('/gws/online/secure/quickpay/payment/v20121111/list.action'),
    quickpayAcceptMoney: gwsUrl('/gws/online/secure/quickpay/payment/v20121111/accept.action'),
    quickpayListAvailableDates: gwsUrl('/gws/online/secure/quickpay/dates/v20131117/list.action'),
    quickpayEditReference: gwsUrl('/gws/online/secure/quickpay/payment/editReference/v20131117/list.action'),
    quickpayTodoReference: gwsUrl('/gws/online/secure/quickpay/payment/reference/v20131117/list.action'),
    
    smcUnreadCount: gwsUrl('/gws/online/secure/smc/messages/v20140323/count.action')
  };

  _.extend( urlMap, {gwsUrl: gwsUrl, createPsrHtmlUlrFromDocumentId: createPsrHtmlUlrFromDocumentId});

  return urlMap;
}());

