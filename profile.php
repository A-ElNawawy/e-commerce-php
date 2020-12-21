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
        <div class="col-sm-12 my-ads">
          <div class="card">
            <div class="card-header">
              <i class="fab fa-buysellads"></i> My Ads
            </div>
            <div class="card-body">
              <ul class="list-unstyled latest-users">
                <?php
                  if(empty($latestUsers)){
                    echo '<div class="alert alert-info no-item-message">There Is No Users</div>';
                  }else{
                    foreach ($latestUsers as $user){
                      echo '<li>';
                        echo $user['Username'];
                        echo '<div>';
                          if($user['RegStatus'] == 0){
                            echo '
                              <a
                                href="members.php?do=Activate&userid='.$user['UserID'].'"
                                class="btn btn-info pull-right"
                              >
                              <i class="fa fa-check"></i> Activate
                              </a>
                            ';
                          }
                          echo '
                            <a
                              href="members.php?do=Edit&userid=' . $user['UserID'] . '"
                              class="btn btn-success pull-right"
                            >
                              <i class="fa fa-edit"></i> Edit
                            </a>
                          ';
                        echo '</div>';
                      echo '</li>';
                    }
                  }
                ?>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-sm-12 comments">
          <div class="card">
            <div class="card-header">
              <i class="fa fa-comments"></i> My Comments
            </div>
            <div class="card-body">
              <ul class="list-unstyled latest-users">
                <?php
                  if(empty($latestUsers)){
                    echo '<div class="alert alert-info no-item-message">There Is No Users</div>';
                  }else{
                    foreach ($latestUsers as $user){
                      echo '<li>';
                        echo $user['Username'];
                        echo '<div>';
                          if($user['RegStatus'] == 0){
                            echo '
                              <a
                                href="members.php?do=Activate&userid='.$user['UserID'].'"
                                class="btn btn-info pull-right"
                              >
                              <i class="fa fa-check"></i> Activate
                              </a>
                            ';
                          }
                          echo '
                            <a
                              href="members.php?do=Edit&userid=' . $user['UserID'] . '"
                              class="btn btn-success pull-right"
                            >
                              <i class="fa fa-edit"></i> Edit
                            </a>
                          ';
                        echo '</div>';
                      echo '</li>';
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