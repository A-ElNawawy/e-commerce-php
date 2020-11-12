<?php
  session_start();
  
  if(isset($_SESSION['username'])){
    $pageTitle = 'Dashboard';
    include 'init.php';
    //=======================================================
    $latestUsers = 5; // Number of Latest Users
    $theLatest = getLatest( // Latest Users Array
                  "*"/* $column */,
                  "users"/* $table */,
                  "UserID"/* $order */,
                  $latestUsers/* $limit */
                );
?>
    <!--  -->
    <div class="container home-stats text-center">
      <h1>Dashboard</h1>
      <div class="row">
        <div class="col-md-3">
          <div class="stat st-total-members">
            Total Members
            <span>
              <a href="members.php">
                <?php echo countItems('UserID', 'users') ?>
              </a>
            </span>
          </div>
        </div>
        <div class="col-md-3">
          <div class="stat st-pending-members">
            Pending Members
            <span>
              <a href="members.php?do=Manage&page=Pending">
                <?php echo checkItem('RegStatus', 'users', 0) ?>
              </a>
            </span>
          </div>
        </div>
        <div class="col-md-3">
          <div class="stat st-total-items">
            Total Items
            <span>
              <a href="items.php?do=Manage">
                <?php echo countItems('item_ID', 'items') ?>
              </a>
            </span>
          </div>
        </div>
        <div class="col-md-3">
          <div class="stat st-total-comments">
            Total Comments
            <span>12000</span>
          </div>
        </div>
      </div>
    </div>
    <div class="container latest">
      <div class="row">
        <div class="col-sm-6">
          <div class="card">
            <div class="card-header">
              <i class="fa fa-users"></i> Latest <?php echo $latestUsers ?> Registered Users
            </div>
            <div class="card-body">
              <ul class="list-unstyled latest-users">
                <?php
                  foreach ($theLatest as $user){
                    echo '<li>';
                      echo $user['Username'];
                      echo '
                        <a
                          href="members.php?do=Edit&userid=' . $user['UserID'] . '"
                          class="btn btn-success pull-right"
                        >
                          <i class="fa fa-edit"></i> Edit
                        </a>
                      ';
                      if($user['RegStatus'] == 0){
                        echo '
                          <a
                            href="members.php?do=Activate&userid='.$user['UserID'].'"
                            class="btn btn-info pull-right"
                          >
                          <i class="fa fa-close"></i> Activate
                          </a>
                        ';
                      }
                    echo '</li>';
                  }
                ?>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="card">
            <div class="card-header">
              <i class="fa fa-users"></i> Latest Items
            </div>
            <div class="card-body">
              Test
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--  -->
<?php
    //=======================================================
    include $templates . 'footer.php';
  }else{
    header('location: index.php');
    exit();
  }