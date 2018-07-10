emb.alert = function( message ){
  if ( emb.features.SUPPRESS_ALERTS ) {
    emb.alert.lastMessage = message;
  } else {
    emb.console.debug("Alert: '" + JSON.stringify(message) + "'");
    if (window.document) {
      $(document).trigger("alertEvent", message);
    }
    window.alert( message );
  }
};

emb.nonBlockingAlert = function( title, message, button1Text, button2Text, button1ClickHandler, button2ClickHandler ) {
  $('#alertPage').remove();
  var header = '';
  if(title !== '') {
      header = '<div data-role=\'header\' class=\'header\'>' +
                '<h2>' + title + '</h2>' +
                '</div>';
  }
 
  $( '<div data-theme="chase" data-url="themeswitcher" data-role=\'dialog\' id="alertPage">' +
        header +
        '<div data-role=\'content\' class=\'content\'>' +
          '<p>' + message + '</p>' +
          '<a data-role="button" href="javascript:void(0);" data-theme="chase" id="button2">' + button2Text + '</a>'+
          '<a data-role="button" href="javascript:void(0);" data-theme="c" id="button1">' + button1Text + '</a>' +
        '</div>'+
      '</div>' )
    .appendTo( $.mobile.pageContainer );
  $.mobile.changePage('#themeswitcher');
  
  // Hide the little x button
  $('#alertPage').find('a[data-icon="delete"]').hide();
  
  $('#alertPage').find('#button1').click(button1ClickHandler);
  $('#alertPage').find('#button2').click(button2ClickHandler);
};
