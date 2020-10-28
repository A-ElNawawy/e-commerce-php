<?php
  function lang($phrase) {
    static $lang = array(
      //Dashboard page:
      
      //Navbar Links
      'ADMIN_HOME'    => 'Home',
      'CATEGORIES'    => 'Categories',
      'ITEMS' => 'Items',
      'MEMBERS' => 'Members',
      'STATISTICS' => 'Statistics',
      'LOGS' => 'Logs',
      'ADMIN_NAME'    => 'Ahmed',
      'EDIT_PROFILE'  => 'Edit Profile',
      'SETTINGS'      => 'Setting',
      'LOGOUT'        => 'Logout',
    );
    return $lang[$phrase];
  }