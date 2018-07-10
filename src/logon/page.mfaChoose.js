if( typeof emb.page === 'undefined' ) { emb.page = {}; }

emb.page.mfaChoose = function($page) {

  var phoneTemplate = $page.find('#TMPL_mfaPhoneList'),
  emailTemplate = $page.find('#TMPL_mfaEmailList'),
  phoneContainer = $page.find('#mfacontactsphone'),
  emailContainer = $page.find('#mfacontactsemail'),
  pageHelper = emb.pageHelper($page),
  contactMethodTouchHandler,
  _ = underscore;

  function onContactMethodTouched(handler) {
    contactMethodTouchHandler = handler;
  }


  function renderPhoneContactsToElements( phoneContacts ) {
     return _.map( phoneContacts, function( phone ){
       return phoneTemplate.tmpl( phone );
     });
   }

   function renderEmailContactsToElements( emailContacts ) {
      return _.map( emailContacts, function( email ){
        return emailTemplate.tmpl( email );
      });
    }

   function updateContactsInDom( phoneContacts, emailContacts ) {
     phoneContainer.empty();
     emailContainer.empty();
     $(phoneContacts).appendTo( phoneContainer );
     $(emailContacts).appendTo( emailContainer );
     pageHelper.refreshPageStyles();
   }

  function updateContactList(phoneContacts, emailContacts) {
    updateContactsInDom( renderPhoneContactsToElements(phoneContacts), renderEmailContactsToElements(emailContacts) );    
  }

  $page.delegate( 'a.textme', 'click', function(e){
    var contact = $(e.target).parents('li').tmplItem().data;
    contactMethodTouchHandler(contact.id, 'text');
  });

  $page.delegate( 'a.callme', 'click', function(e){
    var contact = $(e.target).parents('li').tmplItem().data;
    contactMethodTouchHandler(contact.id, 'call');
  });

  $page.delegate( 'a.emailme', 'click', function(e){
    var contact = $(e.target).parents('li').tmplItem().data;
    contactMethodTouchHandler(contact.id, 'email');
  });

  function showError(message) {
    emb.alert(message);
  }

  function clear() {
    phoneContainer.empty();
    emailContainer.empty();
  }

  return {
    $page: $page,
    updateContactList : updateContactList,
    onContactMethodTouched : onContactMethodTouched,
    showError : showError,
    clear: clear
  };
};
