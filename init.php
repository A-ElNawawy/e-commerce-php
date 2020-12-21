<?php
  // Error Reporting
  ini_set('display_errors', 'on');
  error_reporting(E_ALL);


  include './admin/connect.php';

  $sessionUser = "";
  if(isset($_SESSION['username'])){
    $sessionUser = $_SESSION['username'];
  }
  
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
  /*end Include an Important files*/