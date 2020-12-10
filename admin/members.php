<?php
  /*
    ================================================
    == Manage Members Page
    == You can Add | Edit | Delete Members From Here
    ================================================
  */

  session_start();
  
  if(isset($_SESSION['username'])){
    $pageTitle = 'Members';
    include 'init.php';
    //=======================================================

    $do = isset($_GET['do']) ? $do = $_GET['do'] : $do = 'Manage';
    if($do == 'Manage'){      // Manage Members Page
      // Check If User Want To Display Pending Members Only
      $query = '';
      if(isset($_GET['page']) && $_GET['page'] == 'Pending'){
        /*
          I Don't Know Why We Make This Check
            isset($_GET['page'])
          While We Will Check It's Value
            $_GET['page'] == 'Pending'
          Which Means - Surely - That It is Existing
          I See That
            $_GET['page'] == 'Pending'
          Is Enough
        */
        $query = 'AND RegStatus = 0';
      }
      // Select All Users Except Admin
      $stmt = $con->prepare("SELECT
                              *
                            FROM
                              users
                            WHERE
                              GroupID != 1
                            $query
                            ORDER BY
                              UserID
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
        <div class="alert alert-info no-item-message">There Is No Members</div>
        <div class="form-group row">
          <div class="col-sm-10">
            <a href="?do=Add" class="btn btn-primary">Add Member</a>
          </div>
        </div>
      </div>
    <?php
      }else{
    ?>
      <h1 class="text-center">Manage Members</h1>
      <div class="container">
        <div class="table-responsive">
          <table class="main-table table table-bordered text-center">
            <tr>
              <td>#ID</td>
              <td>Username</td>
              <td>Email</td>
              <td>Full Name</td>
              <td>Registered Date</td>
              <td>Action</td>
            </tr>
            <?php
              foreach($rows as $row){
                echo '<tr>';
                echo '<td>' . $row['UserID'] . '</td>';
                echo '<td>' . $row['Username'] . '</td>';
                echo '<td>' . $row['Email'] . '</td>';
                echo '<td>' . $row['FullName'] . '</td>';
                echo '<td>' . $row['Date'] . '</td>';
                echo '
                  <td>
                    <a
                      href="?do=Edit&userid='.$row['UserID'].'"
                      class="btn btn-success"
                    >
                      <i class="fa fa-edit"></i> Edit
                    </a>
                    <a
                      id="'.$row['Username'].'"
                      href="?do=Delete&userid='.$row['UserID'].'"
                      class="btn btn-danger delete"
                    >
                    <i class="fa fa-close"></i> Delete
                    </a>
                ';
                if($row['RegStatus'] == 0){
                  echo '
                    <a
                      href="?do=Activate&userid='.$row['UserID'].'"
                      class="btn btn-info"
                    >
                    <i class="fa fa-check"></i> Activate
                    </a>
                  ';
                }
                echo '</td>';
                echo '</tr>';
              }
            ?>
          </table>
        </div>
        <a href="?do=Add" class="btn btn-primary">+ New Member</a>
      </div>
    <?php
      }
    ?>
    <?php
    }elseif($do == 'Add'){    //Add Members Page ?>
      <h1 class="text-center">Add New Member</h1>
      <div class="container">
        <form action="?do=Insert" method="POST">
          <div class="form-group row form-group-lg">
            <label class="col-sm-12 col-form-label my-label">
              <p class="col-sm-2">Username</p>
              <input
                type="text"
                name="username"
                class="col-sm-10 form-control"
                autocomplete="off"
                required="required"
                placeholder="Username To Login Shop"
                onfocus="onInputFocus(this)"
                onblur="onInputBlur()"
              />
            </label>
          </div>
          <div class="form-group row">
            <label class="col-sm-12 col-form-label my-label">
              <p class="col-sm-2">Password</p>
              <input
                type="password"
                name="password"
                class="col-sm-10 form-control"
                required="required"
                placeholder="Password Must Be Strong & Complex"
                onfocus="onInputFocus(this)"
                onblur="onInputBlur()"
                autocomplete="new-password"
              />
              <i class="show-pass fa fa-eye"></i>
            </label>
          </div>
          <div class="form-group row">
            <label class="col-sm-12 col-form-label my-label">
              <p class="col-sm-2">Email</p>
              <input 
                type="email"
                name="email"
                class="col-sm-10 form-control"
                required="required"
                placeholder="Email Must Be Valid"
                onfocus="onInputFocus(this)"
                onblur="onInputBlur()"
              />
            </label>
          </div>
          <div class="form-group row">
            <label class="col-sm-12 col-form-label my-label">
              <p class="col-sm-2">Full Name</p>
              <input 
                type="text"
                name="full"
                class="col-sm-10 form-control"
                required="required"
                placeholder="Full Name Appear In Your Profile Page"
                onfocus="onInputFocus(this)"
                onblur="onInputBlur()"
              />
            </label>
          </div>
          <div class="form-group row">
            <div class="col-sm-2"></div>
            <div class="col-sm-10">
              <button
                type="submit"
                value="Add Member"
                class="btn btn-primary"
              >
                Add Member
              </button>
            </div>
          </div>
        </form>
      </div>
    <?php
    }elseif($do == 'Insert'){ //Insert Page
      echo '<h1 class="text-center">Insert Member</h1>';
      echo '<div class="container">';
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Get Variables From Form
            $user       = $_POST['username'];
            $pass       = $_POST['password'];
            $hashedpass = sha1($_POST['password']);
            $email      = $_POST['email'];
            $name       = $_POST['full'];
            // Validation Of The Form
            $formErrors = array();

            if(strlen($user) < 4 && !empty($user)){
              $formErrors[] = 'Username Can\'t Be Less Than <strong>4 Chars</strong>';
            }
            if(strlen($user) > 20){
              $formErrors[] = 'Username Can\'t Be More Than <strong>20 Chars</strong>';
            }
            if(empty($user)){
              $formErrors[] = 'Username Can\'t Be <strong>Empty</strong>';
            }
            if(empty($pass)){
              $formErrors[] = 'Password Can\'t Be <strong>Empty</strong>';
            }
            if(empty($email)){
              $formErrors[] = 'Email Can\'t Be <strong>Empty</strong>';
            }
            if(empty($name)){
              $formErrors[] = 'Full Name Can\'t Be <strong>Empty</strong>';
            }
            foreach($formErrors as $error){
              echo '<div class="alert alert-danger">' . $error . '</div>';
            }
            // Check If There Is No Errors Proceed The Insert Process
            if(empty($formErrors)){
              // Check If User Exists in Database
              $check = checkItem("Username", "users", $user);
              if($check == 1){
                $theMsg = '<div class="alert alert-danger">Sorry This Username is Exist</div>';
                redirectToHome($theMsg, 'back', 1.5);
              }else{
                // Insert User Info In Database
                $stmt = $con->prepare("INSERT INTO
                                          users(`Username`, `Password`, `Email`, `FullName`, `RegStatus`, `Date`)
                                        VALUES(:user, :pass, :email, :name, 0, now())
                                      ");
                // Execute Query
                $stmt->execute(array(
                  'user'  => $user,
                  'pass'  => $hashedpass,
                  'email' => $email,
                  'name'  => $name
                ));
                // Echo Success Message
                $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Record(s) Inserted</div>';
                redirectToHome($theMsg, 'back');
              }
            }
        }else{
          $theMsg = '<div class="alert alert-danger">You Can NOT Access This Page Directly</div>';
          redirectToHome($theMsg);
        }
      echo '</div>';
    }elseif($do == 'Edit'){   //Edit Members Page
      // Check If User ID In Get Request Is Integer & Get Its Integer Value
      $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
      // Select All Data Depend On This ID
      $stmt = $con->prepare("SELECT
                                *
                              FROM
                                users
                              WHERE
                                UserID = ?
                              LIMIT
                                1
                            ");
      // Execute Query
      $stmt->execute(array($userid));
      // Fetch The Data
      $row = $stmt->fetch(); // To get all data in this record
      // The Row Count
      $count = $stmt->rowCount();
      // If There Is Such ID, Show The Form
      if($count > 0){?>
        <h1 class="text-center">Edit Member</h1>
        <div class="container">
          <form action="?do=Update" method="POST">
            <input
              type="hidden"
              name="userid"
              value="<?php echo $userid ?>"
            />
            <div class="form-group row form-group-lg">
              <label class="col-sm-12 col-form-label my-label">
                <p class="col-sm-2">Username</p>
                <input
                  type="text"
                  name="username"
                  class="col-sm-10 form-control"
                  autocomplete="off"
                  required="required"
                  placeholder="Username To Login Shop"
                  onfocus="onInputFocus(this)"
                  onblur="onInputBlur()"
                  value="<?php echo $row['Username'] ?>"
                />
              </label>
            </div>
            <div class="form-group row">
              <label class="col-sm-12 col-form-label my-label">
                <p class="col-sm-2">Password</p>
                <input 
                  type="hidden" 
                  name="oldpassword" 
                  value="<?php echo $row['Password'] ?>" 
                />
                <input
                  type="password"
                  name="newpassword"
                  class="col-sm-10 form-control"
                  placeholder="If You Want, Change Your Password"
                  onfocus="onInputFocus(this)"
                  onblur="onInputBlur()"
                  autocomplete="new-password"
                />
              </label>
            </div>
            <div class="form-group row">
              <label class="col-sm-12 col-form-label my-label">
                <p class="col-sm-2">Email</p>
                <input
                  type="email"
                  name="email"
                  class="col-sm-10 form-control"
                  required="required"
                  placeholder="Email Must Be Valid"
                  onfocus="onInputFocus(this)"
                  onblur="onInputBlur()"
                  value="<?php echo $row['Email'] ?>"
                />
              </label>
            </div>
            <div class="form-group row">
              <label class="col-sm-12 col-form-label my-label">
                <p class="col-sm-2">Full Name</p>
                <input
                  type="text"
                  name="full"
                  class="col-sm-10 form-control"
                  required="required"
                  placeholder="Full Name Appear In Your Profile Page"
                  onfocus="onInputFocus(this)"
                  onblur="onInputBlur()"
                  value="<?php echo $row['FullName'] ?>"
                />
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
      echo '<h1 class="text-center">Update Member</h1>';
      echo '<div class="container">';
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Get Variables From Form
        $id     = $_POST['userid'];
        $user   = $_POST['username'];
        $email  = $_POST['email'];
        $name   = $_POST['full'];
        // Password trick
        $pass = empty($_POST['newpassword']) ? // Check If newpassword Field Is Empty
                  $_POST['oldpassword']
                :
                  sha1($_POST['newpassword']);
        // Validation Of The Form
        $formErrors = array();

        if(strlen($user) < 4 && !empty($user)){
          $formErrors[] = 'Username Can\'t Be Less Than <strong>4 Chars</strong>';
        }
        if(strlen($user) > 20){
          $formErrors[] = 'Username Can\'t Be More Than <strong>20 Chars</strong>';
        }
        if(empty($user)){
          $formErrors[] = 'Username Can\'t Be <strong>Empty</strong>';
        }
        if(empty($email)){
          $formErrors[] = 'Email Can\'t Be <strong>Empty</strong>';
        }
        if(empty($name)){
          $formErrors[] = 'Full Name Can\'t Be <strong>Empty</strong>';
        }

        foreach($formErrors as $error){
          echo '<div class="alert alert-danger">' . $error . '</div>';
        }
        // Check If There Is No Errors Proceed The Update Process
        if(empty($formErrors)){
          // Check If User Exists in Database
          $stmt2 = $con->prepare(" SELECT
                                    *
                                  FROM
                                    users
                                  WHERE
                                    Username = ?
                                  AND
                                    UserID != ?
          ");
          $stmt2->execute(array($user, $id));
          $count = $stmt2->rowCount();
          if($count == 1){
            $theMsg = '<div class="alert alert-danger">Sorry This Username is Exist</div>';
            redirectToHome($theMsg, 'back', 1.5);
          }else{
            // Update The Database With This Info
            $stmt = $con->prepare("UPDATE
                                      users
                                    SET
                                      `Username` = ?,
                                      `Password` = ?,
                                      `Email` = ?,
                                      `FullName` = ?
                                    WHERE
                                      `UserID` = ?
                                  ");
            // Execute Query
            $stmt->execute(array($user, $pass, $email, $name, $id));
            // Echo Success Message
            $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Record(s) Updated</div>';
            redirectToHome($theMsg, 'back');
          }
        }
      }else{
        $theMsg = '<div class="alert alert-danger">You Can NOT Access This Page Directly</div>';
        redirectToHome($theMsg);
      }
      echo '</div>';
    }elseif($do == 'Delete'){ // Delete Member Page
      echo '<h1 class="text-center">Delete Member</h1>';
      echo '<div class="container">';
        /*
        Note That:
        If We Type the userid=1 In The HTTP Request
        We Will Delete The Admin Which Has Not To Happen
        */
        // Check If User ID In Get Request Is Integer & Get Its Integer Value
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
        // Select All Data Depend On This ID
        $check = checkItem('UserID'/* $column */, 'users'/* $table */, $userid/* $value */);
        // If There Is Such ID, Show The Form
        if($check > 0){
          $stmt = $con->prepare("DELETE FROM users WHERE UserID = :user");
          $stmt->bindParam(":user", $userid);
          $stmt->execute();
          // Echo Success Message
          $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Record(s) Deleted</div>';
          redirectToHome($theMsg, 'back');
        }else{
          $theMsg = '<div class="alert alert-danger">ID You Entered NOT Exist</div>';
          redirectToHome($theMsg);
        }
      echo '</div>';
    }elseif($do == 'Activate'){ // Activate Member Page
      echo '<h1 class="text-center">Activate Member</h1>';
      echo '<div class="container">';
        // Check If User ID In Get Request Is Integer & Get Its Integer Value
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
        // Select All Data Depend On This ID
        $check = checkItem('UserID', 'users', $userid);
        // If There Is Such ID, Show The Form
        if($check > 0){
          $stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE UserID = :user;");
          $stmt->bindParam(":user", $userid);
          $stmt->execute();
          // Echo Success Message
          $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Record(s) Activated</div>';
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