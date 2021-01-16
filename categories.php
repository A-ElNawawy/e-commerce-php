<?php
  /* start or resume session */
  session_start();
  /* start or resume session */

  $pageTitle = 'Categories';

  /* start includes */
  include './init.php';
  /* end includes */
  //=======================================================

  $catid = isset($_GET['catid'])? $_GET['catid'] : 0;
  $catname = isset($_GET['catname'])? $_GET['catname'] : "All";
  $items = getItems($catid);
  ?>
    <div class="container categories">
      <h1 class="text-center"><?php echo $catname ?></h1>
      <div class="items-holder">
        <?php
          if(!empty($items)){
            foreach($items as $item){
              echo '
                <div border class="ProductCard">
                  <span class="price">'. $item['Price'] .'</span>
                  <div class="image">
                    <img
                      src="./data/images/productsImages/download.jfif"
                      alt="Product"
                    />
                  </div>
                  <div class="content">
                    <h5><a href="#">'. $item['Name'] .'</a></h5>
                    <p class="description">'. $item['Description'] .'</p>
                    <div class="read-more">
                      <button>
                        <a href="#">Read more</a>
                      </button>
                    </div>
                  </div>
                </div>
              ';
            }
          }else{
            echo '<div class="alert alert-info no-item-message">There Is No Members</div>';
          }
        ?>
      </div>
    </div>
  <?php

  //=======================================================
  include $templates . 'footer.php';