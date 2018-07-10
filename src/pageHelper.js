emb.pageHelper = function($page){
  var _ = underscore,
  hashList = ['agreementDialog', 'agreementContent'];

  function whenReady(method) {
    if (!$page.is(':visible')) {
      $page.one('pageshow', method);
    } else {
      method();
    }
  }
  
  function ifReady(method) {
    if ($page.is(':visible')) {
      method();
    }
  }
  
  function shutterWith( message ){
    $page.find('div.shuttered .shuttered-text').text(message);
    $page.find('div.shuttered').removeClass('hide');
    $page.find('div.unshuttered').addClass('hide');
  }

  function unshutter(){
    $page.find('div.shuttered').addClass('hide');
    $page.find('div.unshuttered').removeClass('hide');
  }

  function refreshContainer( container ) {
    container.wrapAll('<div id="temp-page-refresh-container" />');
    $('#temp-page-refresh-container').page();
    container.unwrap();
  }

  function refreshPageStyles() {
    whenReady(function() {
      refreshContainer( $page );
    });
  }

  /*
	Updates an HTML select list with data items.  If only one item is passed in,
	there will be no placeholder text.
		selectElement: the HTML <select> element
		items: array of data items
		itemDisplayPropertyKey: name of property to display for each data item
		placeholderText: displays if more than one item in the array. i.e. "Select an account"
  */
  
  function selectFromList(items, optionElements, selectElement, placeholderText){
    if( items.length > 1 && placeholderText) {
	    optionElements.unshift( $("<option value='' disabled='disabled data-placeholder='true'>" + placeholderText + "</option>") );
	  }

	  // clear out existing menu options 
	  selectElement.find( 'option' ).remove();
	  // add new menu items
	  $(optionElements).appendTo( selectElement );
	  // refresh the page with the jquery method
	  try {
	    selectElement.selectmenu('refresh');
    } catch(e) {}
    
	  return selectElement;  
  }
  
  function displaySelectMenu(displayValues, item, isPaymentOptions){
    var attr;
    //GWO sends this flag for paymentOpions in BP. if false then disable that field in drop-down
    if(isPaymentOptions && !item.isEnabled){
      attr = "disabled='disabled'";
    }
    if(item.selected){
      attr = (attr === undefined) ? "selected='true'" : attr + "selected='true'";
    }

    if(attr){
       return $("<option "+ attr +" value='"+ item.id +"'>"+ displayValues + "</option>")
        .data( 'item', item );
    }

    return $("<option value='"+ item.id +"'>"+ displayValues + "</option>")
      .data( 'item', item );

  }
  
	function refreshSelectList( selectElement, items, placeholderText, firstItemDisplay){
	  //var optionEls = mapAccountsToOptionElements( accounts );
    var optionElements = _.map( items, function(item, i){ 
      return displaySelectMenu(item[firstItemDisplay], item, null, i);
    });

	  return selectFromList(items, optionElements, selectElement, placeholderText);
	}

	function refreshSelectListForAmount( selectElement, items, placeholderText, firstItemDisplay, secondItemDisplay, isPaymentOptions){
	  //var optionEls = mapAccountsToOptionElements( accounts );
    var optionElements = _.map( items, function(item,i){ 
      var secondItemToDisplay = item[secondItemDisplay];
      if(secondItemToDisplay !== null && secondItemToDisplay !== undefined){
        return displaySelectMenu(item[firstItemDisplay] + ' ' + emb.moneyView(secondItemToDisplay).formattedValue, item, isPaymentOptions, i);
      } else{
        return displaySelectMenu(item[firstItemDisplay], item, isPaymentOptions, i);
      }
    });
	  return selectFromList(items, optionElements, selectElement, placeholderText);
	}
	

  function refreshListView( listView ) {  
    var listViewsPageHasBeenStyled = listView.closest( ".ui-page" ).size() !== 0,
        listViewHasBeenStyled = listView.hasClass('ui-listview');
        
    if( listViewsPageHasBeenStyled )
    {
      if( listViewHasBeenStyled )
      {
        listView.listview('refresh');
      }else{
        listView.listview();
      }
    }
  }

  function refresh( listView ) {  
    try{
      listView.listview('refresh');
    }catch (listNotInitializedIsOk){
      //this guy's ok
    }
  }

  function forceRefresh( listView ) {
    var listViewsPageHasBeenStyled = listView.closest( ".ui-page" ).size() !== 0,
        listViewHasBeenStyled = listView.hasClass('ui-listview');
    //We only manage cases where everything was setup and we need to update
    //if not, then we may get double styling and it will look bad    
    if( listViewsPageHasBeenStyled )
    {
      if( listViewHasBeenStyled )
      {
        //It happens that jQuery will choose not to refresh the whole list
        //so, we the second param set to true forces refresh
        //we do this only it the page is already visible
        listView.listview('refresh',true);
      }
    }
  }

  function updateSelectedItemReadout( $select ) {
    var $element, $option, $readout;

    if ($page.is(":visible")) {
      $element = $select.closest(".ui-select");
      $option = $select.find("option");
      $readout = $element.next(".selected-item-readout");
      
      if ($element.length < 1) {
        $readout = $select.next(".selected-item-readout");
      }
      
      if ($readout.length < 1) {
        return;
      }

      if ($option.length > 1) {
        $option = $option.filter(":selected");
      }
      
      if (!$select.is(":visible") || $select.css('display') === 'none' || $option.attr("data-placeholder") ) {
        $readout.hide();
      } else {
        $readout.show();
        $readout.text( $option.text() );
      }

    } else {
      $page.one("pageshow", function() {
        updateSelectedItemReadout( $select );
      });
    }
  }
  
  function replaceSelectOptions( select, newOptions, defaultOption){
    var options = select.prop('options');
    
    $('option', select).remove();
    
    _.each(newOptions, function(text, val) {
        options[options.length] = new Option(text, val);
    });
    
    if (defaultOption !== undefined ) {
      select.val(defaultOption);
    }
  }

  function refreshSelectMenu( selectMenu ) {
    try {
      var parent = selectMenu.parent();
      if (parent.prev().is('label.locked-select')) {
        parent.prev().remove();
      }
      updateSelectedItemReadout( selectMenu );
      selectMenu.selectmenu('refresh');
    } catch (selectNotInitializedIsOk) {
      //this guy's ok
    }
  }

  function refreshCheckBox( checkBox ) {
    try {
      checkBox.checkboxradio('refresh');
    } catch (checkBoxNotInitializedIsOk) {
      //no biggie!
    }
  }

  function refreshSlider( slider ) {
    try {
      slider.slider("refresh");
    } catch (x) {
      // this guy's ok
    }
  }

  function lockSelectMenu( selectMenu ) {
    whenReady( function() {
      var parent = selectMenu.parent(),
        label = $('<label>')
          .addClass('locked-select')
          .css('font-weight', 'bold')
          .text( selectMenu.find('option:selected').text() );
      
      if (!parent.prev().is('label.locked-select')) {
        label.insertBefore( parent );
      }
      selectMenu.hide();
      parent.hide();
      updateSelectedItemReadout( selectMenu );
    });
  }

  function unlockSelectMenu( selectMenu ) {
    whenReady( function() {
      var parent = selectMenu.parent(),
        label = parent.prev();

      if ( label.is('label.locked-select') ) {
        label.remove();
      }
      selectMenu.show();
      parent.show();
      updateSelectedItemReadout( selectMenu );
    });
  }

  function setNodeText( node, text ) {
    while (node.children().length > 0) {
      node = node.children(':first');
    }

    node.text( text );
  }

  function selectedItemReadout( $select ) {
    var $readout = $select.next();
    if ($readout.is(".selected-item-readout")) {
      return $readout;
    }

    $readout = $( "<p>" )
      .addClass( "ui-li-desc selected-item-readout no-truncation" )
      .attr('aria-hidden', 'true') // this is to skip ADA voice over to skip redundant element
      .insertAfter( $select );

    $select.change(function() {
      var dateOfEvent = new Date();
      updateSelectedItemReadout( $select );
      $(document).trigger({type: "specialselect", timeStamp: Date.UTC(dateOfEvent.getUTCFullYear(), dateOfEvent.getUTCMonth(), dateOfEvent.getUTCDate(), dateOfEvent.getUTCHours(), dateOfEvent.getUTCMinutes(), dateOfEvent.getUTCSeconds(), dateOfEvent.getUTCMilliseconds()), target: $select[0]});
    });

    return $readout;
  }

  function populateFormWithHiddenInputs(inputs, url) {
    var $form = $page.find('form');

    $form.find("input[type='hidden']").remove();
    _.each( inputs, function(value,name){
      $('<input/>').attr({ type: 'hidden', name: name, value: value }).appendTo($form);
    });

    if (url) {
      $form.attr('action', url);
    }
  }

  function isRequired( element ) {
    return $(element).is(":visible");
  }

  function appendErrorMessage(error, element) {
    if(error.text()==="Please enter $ amount in at least one of the fields before scheduling a payment") {
      $('.amountRequired').show();
      error.appendTo($('#billpay-where-to-put-error'));
    } else {
      var parentElement = element.parents( '.form-element' ),
          errorLabel = parentElement.children('label.error');

      if (errorLabel.length === 0) {
        error.appendTo( parentElement );
      }
      else {
        // Remove the 'for' attr, so the validator plugin will ignore it
        // and not refill this (duplicate) message
        error.text('').removeAttr('for').appendTo( parentElement );
      }
    }
  }

  function toggleFieldRow(fieldRow, label, text) {
    if(text && text !== '') {
      $page.find(label).text(text);
      $page.find(fieldRow).show();
    } 
    else {
      $page.find(fieldRow).hide();
    }
  }
  
  // use this to update a label, especially on a button.
  //  if you try to just set the text, it will undo JQM's magic.
  function updateElementLabel( elementClass, label ) {
    var $element = $page.find( elementClass + ' > span > span' );

    if ($element.length === 0) {
      $element = $page.find( elementClass );
    }

    $element.text( label );
  }

  function toggleElement($element, show){
    if(show){
      $element.removeClass('hide');
    }else{
      $element.addClass('hide');
    }
  }

  //fix for a defect that when user on legal agreement dialog and clicks browser back button then its rereicting to black blue screen
  //in this case should be re-directed to logon page. here there is no direct way, so have to look for hash and back button then redirect him to logon page
  function backButtonClicked(options){
    var hashId = options.fromPage &&  options.fromPage[0] && options.fromPage[0].id;
    _.find(hashList, function(hashName){
      if(hashName === hashId){
        window.location = 'index.html#logon';
        return;
      }
    });
  }
	
  return {
    refreshContainer: refreshContainer,
    refreshPageStyles: refreshPageStyles,
		refreshSelectList: refreshSelectList,
		refreshSelectListForAmount: refreshSelectListForAmount,
    refreshListView: refreshListView,
    refresh: refresh,
    forceRefresh: forceRefresh,
    refreshSelectMenu: refreshSelectMenu,
    replaceSelectOptions: replaceSelectOptions,
    refreshCheckBox: refreshCheckBox,
    lockSelectMenu: lockSelectMenu,
    unlockSelectMenu: unlockSelectMenu,
    setNodeText: setNodeText,
    selectedItemReadout: selectedItemReadout,
    updateSelectedItemReadout: updateSelectedItemReadout,
    refreshSlider: refreshSlider,
    shutterWith: shutterWith,
    unshutter: unshutter,
    populateFormWithHiddenInputs: populateFormWithHiddenInputs,
    whenReady: whenReady,
    isRequired: isRequired,
    appendErrorMessage: appendErrorMessage,
    toggleFieldRow: toggleFieldRow,
    updateElementLabel: updateElementLabel,
    toggleElement: toggleElement,
    backButtonClicked: backButtonClicked
  };
};
