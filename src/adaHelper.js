emb.adaHelper = function(){
  /*
  Nag 
  Utility helper claas for all ADA utility functions
  */
  var _ = underscore;

  //AMS - This function will add html-aria roles and properties to the elements that jquery mobile creates dynamically when creating slider controls
  //It is intended to be used for the on/off sliders used in EMB (albiet it could be extended later to additional sliders).
  function makeSliderADACompliant($slider, ariaLabel){
    if(!$slider){return;}
    var $sliderDiv;
    $slider.each(function () {
      $sliderDiv = $slider.siblings('div.ui-slider');

      $sliderDiv.attr('role', 'checkbox').attr('aria-checked', $slider.val() === "on").attr('aria-label', ariaLabel);
      $sliderDiv.find('[role="img"]').attr('aria-hidden', 'true');

      $slider.bind('slidestop', function (event, ui) {
          $sliderDiv.attr('aria-checked', $(this).val() === "on");
      });
    });
  }

  //AMS - This function will add html-aria roles and properties to the elements that jquery mobile creates dynamically when creating the datebox popup control
  function makeDateboxContainerADACompliant(){
    //I wasn't able to find a sensible way to pass in div.ui-datebox-container as a parameter to this method.
    //The div.ui-datebox-container is dynamically generated. The function caller just has to assume that it exists when calling this method.
    //Only 1 should exist at any given time (as it's a popup).
    var $dateboxContainer = $('div.ui-datebox-container'),
        currMonthYear, headerText;
    if(!$dateboxContainer || $dateboxContainer.length === 0){return;}

    currMonthYear = $dateboxContainer.find('.ui-datebox-gridlabel').text().split(' ');
    //make the popup an aria-dialog
    $dateboxContainer.attr('role','dialog');
    $dateboxContainer.attr('aria-label','Calendar Widget');
    //loop through the calendar days section - make them buttons, disable some, hide some.
    $dateboxContainer.find('.ui-datebox-grid div').each(function(){   
      if ($(this).hasClass('ui-btn'))
      {
        var day=$(this).text(),
            month = currMonthYear[0],
            year = currMonthYear[1],
            dt = new Date(month + ' ' + day + ' ' + year),
            dayOfWeekString = emb.utils.weekdayStringFromInteger(dt.getDay()),
            formattedDateForADA = dayOfWeekString + ' ' + day +  ', ' + month;
        $(this).attr('role', 'button');
        $(this).attr('aria-label', formattedDateForADA);
      }
      //find the actively selected date and make it's label indicate that it's selected
      if ($(this).hasClass('ui-btn-up-b'))
      {
        $(this).attr('aria-label', $(this).attr('aria-label') + ", Selected Date");
      }
      //find the disabled dates
      if ($(this).hasClass('ui-datebox-griddate-disable'))
      {
        $(this).attr('aria-disabled', 'true');
      }
      //find the prior months and next months trailing dates and hide them (too difficult for AT tools to communicate proper meaning)
      if ($(this).hasClass('ui-datebox-griddate-empty'))
      {
        $(this).attr('aria-hidden', 'true');
      }
    });

    headerText = $dateboxContainer.find('h1.ui-title').text();
    if (headerText){
      $dateboxContainer.find('div.ui-header,ui-bar-a').prepend('<p id="aria-cal-header" class="accessible-only">' + headerText +'</p>').focus();
      $dateboxContainer.find('#aria-cal-header').focus();
    }
  }

  return {
    makeSliderADACompliant: makeSliderADACompliant,
    makeDateboxContainerADACompliant: makeDateboxContainerADACompliant
  };

};
