/*
* This file contain css from another project, from another dev that deserve credit
* Author : @muhammadawaisshaikh
* repo link : https://github.com/muhammadawaisshaikh/interactive-sidemenu
*
*/

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
