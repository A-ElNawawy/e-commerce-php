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
    //$latestUsers = [];
    $itemsNum = 3; // Number of Latest Items
    $latestItems = getLatest( // Latest Items Array
                    '*',      /* $column */
                    'items',  /* $table */
                    'ItemID', /* $order */
                    $itemsNum /* $limit */
                  );
    //$latestItems = [];
    $commentsNum = 10; // Number of Latest Comments
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
              <span>
                <a href="comments.php?do=Manage">
                  <?php echo countItems('CommentID', 'comments') ?>
                </a>
              </span>
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
        <div class="col-sm-6">
          <div class="card">
            <div class="card-header">
              <i class="fas fa-tags"></i> Latest <?php echo $itemsNum ?> Items
            </div>
            <div class="card-body">
              <ul class="list-unstyled latest-users">
                <?php
                  if(empty($latestItems)){
                    echo '<div class="alert alert-info no-item-message">There Is No Items</div>';
                  }else{
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
                  }
                ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-6">
          <div class="card">
            <div class="card-header">
              <i class="fa fa-comments-o"></i> Latest <?php echo $commentsNum ?> Comments
            </div>
            <div class="card-body">
              <?php
                // Select All Comments
                $stmt = $con->prepare(" SELECT
                                          comments.*,
                                          users.Username As User_Name
                                        FROM
                                          comments
                                        INNER JOIN
                                          users
                                        ON
                                          users.UserID = comments.User_ID
                                        ORDER BY
                                          CommentDate
                                        DESC
                                        LIMIT
                                          $commentsNum
                                      ");
                // Execute The Statement
                $stmt ->execute();
                // Assign To Variable
                $rows = $stmt->fetchAll();
                //$rows = [];
                if(empty($rows)){
                  echo '<div class="alert alert-info no-item-message">There Is No Comments</div>';
                }else{
                  foreach($rows as $row){
                    echo '<div class="latest-comments">';
                      echo '<div class="content">';
                        echo '
                          <span class="user-n">
                            <a href="members.php?do=Edit&userid='.$row['User_ID'].'">'. $row['User_Name'] . '</a>
                          </span>';
                        echo '<p class="user-c">'. $row['Comment'] .'</p>';
                      echo '</div>';
                      echo '<div class="controls">';
                        echo '
                          <a
                            href="comments.php?do=Edit&commentid='.$row['CommentID'].'"
                            class="btn btn-success"
                          >
                            <i class="fa fa-edit"></i> Edit
                          </a>
                          <a
                            id="'.$row['CommentID'].'"
                            href="comments.php?do=Delete&commentid='.$row['CommentID'].'"
                            class="btn btn-danger delete"
                          >
                          <i class="fa fa-close"></i> Delete
                          </a>
                        ';
                        if($row['Status'] == 0){
                          echo '
                            <a
                              href="comments.php?do=Approve&commentid='.$row['CommentID'].'"
                              class="btn btn-info"
                            >
                            <i class="fa fa-check"></i> Approve
                            </a>
                          ';
                        }
                      echo '</div>';
                    echo '</div>';
                  }
                }
              ?>
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