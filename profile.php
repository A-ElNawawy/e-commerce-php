<?php
  /* start or resume session */
  session_start();
  /* start or resume session */

  $pageTitle = 'Profile';

  /* start includes */
  include './init.php';
  /* end includes */
  //=======================================================

  if(isset($_SESSION['username'])){
    $userInfo = getUserInfo($sessionUser);
    $userid = $userInfo['UserID'];
    $userItems = getUserItems($userid);
    $userComments = getUserComments($userid);
  ?>
    <div class="profile">
      <div class="container">
        <h1 class="text-center"><?php echo $sessionUser ?>'s Profile</h1>
        <div class="col-sm-12 info">
          <div class="card">
            <div class="card-header">
              <i class="fas fa-info-circle"></i> My Info
            </div>
            <div class="card-body">
              Name: <?php echo $userInfo['Username'] ?> </br>
              Email: <?php echo $userInfo['Email'] ?> </br>
              Full Name: <?php echo $userInfo['FullName'] ?> </br>
              Registration Date: <?php echo $userInfo['Date'] ?> </br>
              Favorite Categories: 
            </div>
          </div>
        </div>
        <div class="col-sm-12 my-items">
          <div class="card">
            <div class="card-header">
              <i class="fab fa-buysellads"></i> My Ads
            </div>
            <div class="card-body">
              <div class="items-holder">
                <?php
                  if(!empty($userItems)){
                    foreach($userItems as $userItem){
                      echo '
                        <div border class="ProductCard">
                          <span class="price">'. $userItem['Price'] .'</span>
                          <div class="image">
                            <img
                              src="./data/images/productsImages/download.jfif"
                              alt="Product"
                            />
                          </div>
                          <div class="content">
                            <h5><a href="#">'. $userItem['Name'] .'</a></h5>
                            <p class="description">'. $userItem['Description'] .'</p>
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
                    echo '<div class="alert alert-info no-item-message">There Is No Ads</div>';
                  }
                ?>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-12 comments">
          <div class="card">
            <div class="card-header">
              <i class="fa fa-comments"></i> My Comments
            </div>
            <div class="card-body">
              <ul class="list-unstyled">
                <?php
                  if(empty($userComments)){
                    echo '<div class="alert alert-info no-item-message">There Is No Users</div>';
                  }else{
                    foreach ($userComments as $userComment){
                      echo '<p>'. $userComment['Comment'] .'</p>';
                    }
                  }
                ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php
  }else{
    header('Location: login.php');
  }

  //=======================================================
  include $templates . 'footer.php';