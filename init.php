<?php
  include 'connect.php';
  
  /*start Routes*/
  $templates  = 'includes/templates/'; // templates Directory
  $lang       = 'includes/languages/'; // languages Directory
  $func       = 'includes/functions/'; // functions Directory
  $css        = 'layout/css/'; // css Directory
  $js         = 'layout/js/'; // js Directory
  /*end Routes*/

  /*start Include an Important files*/
  include $func . 'functions.php';
  include $lang . 'english.php';
  include $templates . 'header.php';
  
  //Check if we want to hide navbar in the current page or not
  //to hide the navbar in any page we have to set ($hide_navbar = '';) before including init.php
  if(!isset($hide_navbar)) { include $templates . 'navbar.php'; }
  /*end Include an Important files*/