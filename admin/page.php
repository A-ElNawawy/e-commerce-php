<?php
  /*
  Categories => [ Manage | Edit | Update | Add | Insert | Delete | Stats ]
  */

  $do = isset($_GET['do']) ? $do = $_GET['do'] : $do = 'Manage';

  // If The Page Is Main Page
  if($do == 'Manage'){
    echo 'Welcome You  Are In Manage Category Page<br/>';
    echo '<a href="page.php?do=Add">Add New Category</a>';
  }elseif($do == 'Edit'){
    echo 'Welcome You Are In Edit Category Page';
  }elseif($do == 'Update'){
    echo 'Welcome You Are In Update Category Page';
  }elseif($do == 'Add'){
    echo 'Welcome You Are In Add Category Page';
  }else{
    echo 'Error: There\'s No Such Page Name';
  }