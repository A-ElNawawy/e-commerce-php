<?php
  session_start();
  
  if(isset($_SESSION['username'])){
    $pageTitle = 'Dashboard';

    include 'init.php';
    echo '<h1 class="text-center">Welcome in Dashboard</h1>';
    include $templates . 'footer.php';
  }else{
    header('location: index.php');
    exit();
  }