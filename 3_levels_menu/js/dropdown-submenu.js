;jQuery(document).ready(function() {
  jQuery('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
    event.preventDefault();
    event.stopPropagation();
    jQuery(this).parent().siblings().removeClass('open');
    jQuery(this).parent().toggleClass('open');
  });
});