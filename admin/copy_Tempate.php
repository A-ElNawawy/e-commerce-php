<?php
  /*
    ================================================
    == Template Page
    ================================================
  */

  session_start();
  
  if(isset($_SESSION['username'])){
    $pageTitle = '';
    include 'init.php';
    //=======================================================

    $do = isset($_GET['do']) ? $do = $_GET['do'] : $do = 'Manage';
    if($do == 'Manage'){
      
    }elseif($do == 'Add'){
      
    }elseif($do == 'Insert'){

    }elseif($do == 'Edit'){
      
    }elseif($do == 'Update'){
      
    }elseif($do == 'Delete'){
      
    }elseif($do == 'Activate'){
      
    }

    //=======================================================
    include $templates . 'footer.php';
  }else{
    header('location: index.php');
    exit();
  }