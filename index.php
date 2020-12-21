<?php
  /* start or resume session */
  session_start();
  /* start or resume session */

  $pageTitle = 'Home';

  /* start includes */
  include './init.php';
  /* end includes */
  //=======================================================

  ?>
    <div class="container">
      <h1>Welcome <?php echo $sessionUser ?> in Home Page</h1>
    </div>
  <?php

  //=======================================================
  include $templates . 'footer.php';