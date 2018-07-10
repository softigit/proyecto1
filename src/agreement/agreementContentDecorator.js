emb.decorateAndDisplayAgreement = function($page, $container, $html, options) {

  /*
    Because the agreement HTML documents are shared between mobile and desktop, we need to enhance the HTML to make it compatible
    with jQM and some specific mobile features such as the mail button.
  */
  
  var _ = underscore,
      pageHelper = emb.pageHelper($page),
      $closeLink;
  
  options = $.extend({
      hideAcceptanceText: true
    }, options);
    
  // Email button
   $html.find('.email-button')
     .attr('data-role', 'button');
  
  // Content body - accordion
  $html.find('.content-body')
    .attr('data-role', 'collapsible-set')
    .attr('data-inset', 'false')
    .attr('data-iconpos', 'right')
    .attr('data-collapsed-icon', 'arrow-d')
    .attr('data-expanded-icon', 'arrow-u');
  
  // Content sections - accordion
  $html.find('.content-section')
    .attr('data-role', 'collapsible');
  
  // Close link
  $closeLink = $('<div class="center-block"><a href="javascript:void(0);" class="close-link">Close</a></div>');
  $closeLink.appendTo($html.find('[data-role="collapsible"] > div'));
  
  // Acceptance text
  if (options.hideAcceptanceText) {
    $html.find('.content-acceptance-text').remove();
  }
  
  $container.empty();
  $html.appendTo($container);
  pageHelper.refreshContainer($container);
  
  $page.find('.agreement-flow-overlay').remove();

  if($page.find('#currentVersionButton').length < 1){
    $html.find('.email-button').after("<hr class='content-email-seperator-hr'>");
  }

  $page.find('.ui-collapsible-heading a').addClass('content-ui-collapsible');
  $page.find('.content-ui-collapsible span .ui-icon').addClass('content-ui-arrow');
  
  // Collapse the section on the close link click event
  $page.find('.close-link').off('click').on('click', function() {
    $(this).parents('[data-role="collapsible"]').trigger('collapse');
  });
  
  $page.on('expand', '.ui-collapsible-set', function(e) {
    var top = $(e.target).offset().top;
    $(window).scrollTop(top);
  });

};
