<?php
  /*
    ================================================
    == Manage Comments Page
    == You can Edit | Delete | Approve Comments From Here
    ================================================
  */

  session_start();
  
  if(isset($_SESSION['username'])){
    $pageTitle = 'Comments';
    include 'init.php';
    //=======================================================

    $do = isset($_GET['do']) ? $do = $_GET['do'] : $do = 'Manage';
    if($do == 'Manage'){      // Manage Comments Page
      // Select All Comments
      $stmt = $con->prepare(" SELECT
                                comments.*,
                                items.Name AS Item_Name,
                                users.Username As User_Name
                              FROM
                                comments
                              INNER JOIN
                                items
                              ON
                                items.ItemID = comments.Item_ID
                              INNER JOIN
                                users
                              ON
                                users.UserID = comments.User_ID
                              ORDER BY
                                CommentDate
                              DESC
                            ");
      // Execute The Statement
      $stmt ->execute();
      // Assign To Variable
      $rows = $stmt->fetchAll();
      //$rows = [];
      if(empty($rows)) {
    ?>
      <div class="container">
        <div class="alert alert-info no-item-message">There Is No Comments</div>
      </div>
    <?php
      }else{
    ?>
      <h1 class="text-center">Manage Comments</h1>
      <div class="container">
        <div class="table-responsive">
          <table class="main-table table table-bordered text-center">
            <tr>
              <td>#ID</td>
              <td>Comment</td>
              <td>Item Name</td>
              <td>User Name</td>
              <td>Added Date</td>
              <td>Action</td>
            </tr>
            <?php
              foreach($rows as $row){
                echo '<tr>';
                echo '<td>' . $row['CommentID'] . '</td>';
                echo '<td>' . $row['Comment'] . '</td>';
                echo '<td>' . $row['Item_Name'] . '</td>';
                echo '<td>' . $row['User_Name'] . '</td>';
                echo '<td>' . $row['CommentDate'] . '</td>';
                echo '
                  <td>
                    <a
                      href="?do=Edit&commentid='.$row['CommentID'].'"
                      class="btn btn-success"
                    >
                      <i class="fa fa-edit"></i> Edit
                    </a>
                    <a
                      id="'.$row['CommentID'].'"
                      href="?do=Delete&commentid='.$row['CommentID'].'"
                      class="btn btn-danger delete"
                    >
                    <i class="fa fa-close"></i> Delete
                    </a>
                ';
                if($row['Status'] == 0){
                  echo '
                    <a
                      href="?do=Approve&commentid='.$row['CommentID'].'"
                      class="btn btn-info"
                    >
                    <i class="fa fa-check"></i> Approve
                    </a>
                  ';
                }
                echo '</td>';
                echo '</tr>';
              }
            ?>
          </table>
        </div>
      </div>
    <?php
      }
    ?>
    <?php
    }elseif($do == 'Edit'){   //Edit Comments Page
      // Check If Comment ID In Get Request Is Integer & Get Its Integer Value
      $commentid = isset($_GET['commentid']) && is_numeric($_GET['commentid']) ? intval($_GET['commentid']) : 0;
      // Select All Data Depend On This ID
      $stmt = $con->prepare("SELECT
                                *
                              FROM
                                comments
                              WHERE
                                CommentID = ?
                            ");
      // Execute Query
      $stmt->execute(array($commentid));
      // Fetch The Data
      $row = $stmt->fetch(); // To get all data in this record
      // The Row Count
      $count = $stmt->rowCount();
      // If There Is Such ID, Show The Form
      if($count > 0){?>
        <h1 class="text-center">Edit Comment</h1>
        <div class="container">
          <form action="?do=Update" method="POST">
            <input
              type="hidden"
              name="commentid"
              value="<?php echo $commentid ?>"
            />
            <div class="form-group row form-group-lg">
              <label class="col-sm-12 col-form-label my-label field-holder">
                <p class="col-sm-2">Comment</p>
                <textarea
                  name="comment"
                  class="col-sm-10 form-control"
                  placeholder="Please type your comment"
                  onfocus="onInputFocus(this)"
                  onblur="onInputBlur()"
                  autofocus
                >
                  <?php echo $row['Comment'] ?>
                </textarea>
              </label>
            </div>
            <div class="form-group row">
              <div class="col-sm-2"></div>
              <div class="col-sm-10">
                <button
                  type="submit"
                  value="Save"
                  class="btn btn-primary"
                >
                  Edit
                </button>
              </div>
            </div>
          </form>
        </div>
      <?php
      // If There IS No Such ID, Show Error Message
      }else{
        echo '<div class="container">';
          echo '<h1 class="text-center">Edit Member</h1>';
          $theMsg = '<div class="alert alert-danger">There Is No Such ID</div>';
          redirectToHome($theMsg);
        echo '</div>';
      }
    }elseif($do == 'Update'){ // Update Page
      echo '<h1 class="text-center">Update Comment</h1>';
      echo '<div class="container">';
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Get Variables From Form
        $commentid = $_POST['commentid'];
        $comment   = $_POST['comment'];
        // Check If There Is No Errors Proceed The Update Process
        if(empty($formErrors)){
          // Update The Database With This Info
          $stmt = $con->prepare("UPDATE
                                    comments
                                  SET
                                    Comment = ?
                                  WHERE
                                    CommentID = ?
                                ");
          // Execute Query
          $stmt->execute(array($comment, $commentid));
          // Echo Success Message
          $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Record(s) Updated</div>';
          redirectToHome($theMsg, 'back');
        }
      }else{
        $theMsg = '<div class="alert alert-danger">You Can NOT Access This Page Directly</div>';
        redirectToHome($theMsg);
      }
      echo '</div>';
    }elseif($do == 'Delete'){ // Delete Member Page
      echo '<h1 class="text-center">Delete Comment</h1>';
      echo '<div class="container">';
        // Check If Comment ID In Get Request Is Integer & Get Its Integer Value
        $commentid = isset($_GET['commentid']) && is_numeric($_GET['commentid']) ? intval($_GET['commentid']) : 0;
        // Select All Data Depend On This ID
        $check = checkItem('CommentID'/* $column */, 'comments'/* $table */, $commentid/* $value */);
        // If There Is Such ID, Show The Form
        if($check > 0){
          $stmt = $con->prepare("DELETE FROM comments WHERE CommentID = :comment");
          $stmt->bindParam(":comment", $commentid);
          $stmt->execute();
          // Echo Success Message
          $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Record(s) Deleted</div>';
          redirectToHome($theMsg, 'back');
        }else{
          $theMsg = '<div class="alert alert-danger">ID You Entered NOT Exist</div>';
          redirectToHome($theMsg);
        }
      echo '</div>';
    }elseif($do == 'Approve'){ // Approve Comment Page
      echo '<h1 class="text-center">Approve Comment</h1>';
      echo '<div class="container">';
        // Check If Comment ID In Get Request Is Integer & Get Its Integer Value
        $commentid = isset($_GET['commentid']) && is_numeric($_GET['commentid']) ? intval($_GET['commentid']) : 0;
        // Select All Data Depend On This ID
        $check = checkItem('CommentID'/* $column */, 'comments'/* $table */, $commentid/* $value */);
        // If There Is Such ID, Show The Form
        if($check > 0){
          $stmt = $con->prepare("UPDATE comments SET Status = 1 WHERE CommentID = :comment;");
          $stmt->bindParam(":comment", $commentid);
          $stmt->execute();
          // Echo Success Message
          $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Record(s) Approved</div>';
          redirectToHome($theMsg, 'back');
        }else{
          $theMsg = '<div class="alert alert-danger">ID You Entered NOT Exist</div>';
          redirectToHome($theMsg);
        }
      echo '</div>';
    }

    //=======================================================
    include $templates . 'footer.php';
  }else{
    header('location: index.php');
    exit();
  }