$(function(){
  'use strict';
  var closemenuf = document.getElementById('close_menu_f');
  var menuf = document.getElementById('menu_f');
  closemenuf.addEventListener('click', function() {
    menuf.style.display= 'none';
  });
});