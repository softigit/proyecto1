emb.page = emb.page || {};

emb.page.contactUs = function($page) {
    var _ = underscore,
        pageHelper = emb.pageHelper($page),
        nonPhoneDevice=false;
    
    function preventPhoneCalls(){
      nonPhoneDevice=true;
    }
    
    $page.on('pagebeforeshow', function() {
      if (!nonPhoneDevice) {
        $page.find('.phone-link .ui-icon').addClass('tel-icon');
      }
      
      //headerLogoCookie - used to set cpc header if user = CPC 
      //this cookie will be null if chase user
      //using same cookie to set contactUs for CPC user
      if(emb.cookieStore.getCookie('headerLogoCookie') !== null){
          $('#cpcSupportTel').show();
          $('#supportTel').hide();
          //personal savings and checking
          $('#cpcPersonalTel').show();
          //prelogon telephone #
          $('#personalTelPreLogon').hide();
          //post logon tel #
          $('#personalTelPostLogon').hide();  
      }
      else {
          $('#cpcSupportTel').hide();
          $('#supportTel').show();
          //personal savings and checking
          $('#cpcPersonalTel').hide();
          //# WO #9263 - for chase user prelogon and post logon #s should be different for personal and checking
          if (emb.globaltons.sharedProfile) {
            //post logon tel #
            $('#personalTelPostLogon').show();
            //prelogon telephone #
            $('#personalTelPreLogon').hide();
          }else{
            //post logon tel #
            $('#personalTelPostLogon').hide();
            //prelogon telephone #
            $('#personalTelPreLogon').show();
          }
      }
    });

    return {
      $page: $page,
      preventPhoneCalls:preventPhoneCalls
    };
};
