<?php
  /* start or resume session */
  session_start();
  /* start or resume session */

  $pageTitle = 'Show Item Details';

  /* start includes */
  include './init.php';
  /* end includes */
  //=======================================================

  // Check If Item ID In Get Request Is Integer & Get Its Integer Value
  $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
  // Select All Data Depend On This ID
  $stmt = $con->prepare("SELECT
                            *
                          FROM
                            items
                          WHERE
                            ItemID = ?
                          LIMIT
                            1
                        ");
  // Execute Query
  $stmt->execute(array($itemid));
  // The Row Count
  $count = $stmt->rowCount();
  // If There Is Such ID:
  if($count > 0){
    // Fetch The Data
    $item = $stmt->fetch(); // To get all data in this record
    ?>
    <div class="item-details">
      <div class="container">
        <h1 class="text-center">
          <?php echo $item['Name'] ?>'s Details
        </h1>
      </div>
    </div>
  <?php
  // If There IS No Such ID, Show Error Message
  }else{
    echo '<div class="container">';
      echo '<h1 class="text-center">Item Details</h1>';
      echo '<div class="alert alert-danger">There Is No Item With Such ID</div>';
    echo '</div>';
  }
  if(isset($_SESSION['username'])){
  }else{
    header('Location: login.php');
  }

  //=======================================================
  include $templates . 'footer.php';