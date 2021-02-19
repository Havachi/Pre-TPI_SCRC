$(document).ready(function () {
	$(".sidebar-btnCollapse" ).click(function() {
    $('.sidebar').toggleClass('width-toggle');
    $(this).toggleClass('change');
    $('.inner-page').toggleClass('fade');
  });

  $(".sidebar a" ).click(function() {
    $('.sidebar').toggleClass('width-toggle');
    $('.menu-icon').toggleClass('change');
    $('.inner-page').toggleClass('fade');
  });
  $(".sidebar-quit" ).click(function() {
    $('.sidebar').toggleClass('width-toggle');
    $('.menu-icon').toggleClass('change');
    $('.inner-page').toggleClass('fade');
  });
});
