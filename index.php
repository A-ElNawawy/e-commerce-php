<?php
  /* start or resume session */
  session_start();
  $username = "Guest";
  if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
  }
  /* start or resume session */

  $pageTitle = 'Home';

  /* start includes */
  include './init.php';
  /* end includes */
  //=======================================================

  ?>
    <div class="container">
      <h1>Welcome <?php echo $username ?></h1>
    </div>
  <?php

  //=======================================================
  include $templates . 'footer.php';