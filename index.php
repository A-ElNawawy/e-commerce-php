<?php
  $pageTitle = 'Main';

  /* start includes */
  include './init.php';
  /* end includes */
      $stmt = $con->prepare("SELECT * FROM categories");
      // Execute The Statement
      $stmt ->execute();
      // Assign To Variable
      $rows = $stmt->fetchAll();
      //$rows = [];
      if(empty($rows)) {
    ?>
      <div class="container">
        <div class="alert alert-info no-item-message">There Is No Categories</div>
      </div>
    <?php
      }else{
    ?>
      <div class="container">
        <h1>Categories</h1>
        <?php
          foreach($rows as $row){
            echo '<div>';
              echo $row['Name'];
            echo '</div>';
          }
        ?>
      </div>
    <?php
      }
  include $templates . 'footer.php';