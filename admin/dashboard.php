<?php
  session_start();
  
  if(isset($_SESSION['username'])){
    $pageTitle = 'Dashboard';
    include 'init.php';
    //=======================================================
    $usersNum = 5; // Number of Latest Users
    $latestUsers = getLatest( // Latest Users Array
                  '*',      /* $column */
                  'users',  /* $table */
                  'UserID', /* $order */
                  $usersNum /* $limit */
                );
    $itemsNum = 5;
    $latestItems = getLatest( // Latest Items Array
                  '*',      /* $column */
                  'items',  /* $table */
                  'ItemID', /* $order */
                  $usersNum /* $limit */
    )
?>
    <!--  -->
    <div class="container home-stats text-center">
      <h1>Dashboard</h1>
      <div class="row">
        <div class="col-md-3">
          <div class="stat st-total-members">
            <div><i class="fa fa-users"></i></div>
            <div>
              Total Members
              <span>
                <a href="members.php">
                  <?php echo countItems('UserID', 'users') ?>
                </a>
              </span>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="stat st-pending-members">
            <div><i class="fa fa-user-plus"></i></div>
            <div>
              Pending Members
              <span>
                <a href="members.php?do=Manage&page=Pending">
                  <?php echo checkItem('RegStatus', 'users', 0) ?>
                </a>
              </span>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="stat st-total-items">
            <div><i class="fa fa-tag"></i></div>
            <div>
              Total Items
              <span>
                <a href="items.php?do=Manage">
                  <?php echo countItems('ItemID', 'items') ?>
                </a>
              </span>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="stat st-total-comments">
            <div><i class="fa fa-comments"></i></div>
            <div>
              Total Comments
              <span>0</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container latest">
      <div class="row">
        <div class="col-sm-6">
          <div class="card">
            <div class="card-header">
              <i class="fa fa-users"></i> Latest <?php echo $usersNum ?> Registered Users
            </div>
            <div class="card-body">
              <ul class="list-unstyled latest-users">
                <?php
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
                ?>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="card">
            <div class="card-header">
              <i class="fas fa-tags"></i> Latest Items
            </div>
            <div class="card-body">
              <ul class="list-unstyled latest-users">
                <?php
                  foreach ($latestItems as $item){
                    echo '<li>';
                      echo $item['Name'];
                      echo '<div>';
                        if($item['Approved'] == 0){
                          echo '
                            <a
                              href="items.php?do=Approve&itemid='.$item['ItemID'].'"
                              class="btn btn-info pull-right"
                            >
                            <i class="fa fa-check"></i> Approve
                            </a>
                          ';
                        }
                        echo '
                          <a
                            href="items.php?do=Edit&itemid=' . $item['ItemID'] . '"
                            class="btn btn-success pull-right"
                          >
                            <i class="fa fa-edit"></i> Edit
                          </a>
                        ';
                      echo '</div>';
                    echo '</li>';
                  }
                ?>
              </ul>
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