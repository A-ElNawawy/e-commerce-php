<?php
  include './admin/connect.php';
  
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