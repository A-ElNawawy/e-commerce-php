<?php
  function lang($phrase) {
    static $lang = array(
      //Dashboard page:
      
      //Navbar Links
      'HOME'    => 'Home',
    );
    return $lang[$phrase];
  }