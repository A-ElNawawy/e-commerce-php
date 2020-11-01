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
      // Select All Users Except Admin
      $stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1");
      // Execute The Statement
      $stmt ->execute();
      // Assign To Variable
      $rows = $stmt->fetchAll(); ?>
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
              <td>Control</td>
            </tr>
            <?php
              foreach($rows as $row){
                echo '<tr>';
                echo '<td>' . $row['UserID'] . '</td>';
                echo '<td>' . $row['Username'] . '</td>';
                echo '<td>' . $row['Email'] . '</td>';
                echo '<td>' . $row['FullName'] . '</td>';
                echo '<td></td>';
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
                      class="delete btn btn-danger"
                    >
                    <i class="fa fa-close"></i> Delete
                    </a>
                  </td>
                ';
                echo '</tr>';
              }
            ?>
          </table>
        </div>
        <a href="members.php?do=Add" class="btn btn-primary">+ New Member</a>
      </div>
    <?php
    }elseif($do == 'Add'){    //Add Members Page ?>
      <h1 class="text-center">Add New Member</h1>
      <div class="container">
        <form action="?do=Insert" method="POST">
          <div class="form-group row form-group-lg">
            <label for="username" class="col-sm-2 col-form-label">Username</label>
            <div class="col-sm-10">
              <input
                type="text"
                name="username"
                id="username"
                class="form-control"
                autocomplete="off"
                required="required"
                placeholder="User Name To Login Shop"
                onfocus="onInputFocus(this)"
                onblur="onInputBlur()"
              />
            </div>
          </div>
          <div class="form-group row">
            <label for="newpassword" class="col-sm-2 col-form-label">Password</label>
            <div class="col-sm-10">
              <input
                type="password"
                name="password"
                id="newpassword"
                class="form-control"
                required="required"
                placeholder="Password Must Be Strong & Complex"
                onfocus="onInputFocus(this)"
                onblur="onInputBlur()"
                autocomplete="new-password"
              />
              <i class="show-pass fa fa-eye fa-2x"></i>
            </div>
          </div>
          <div class="form-group row">
            <label for="email" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
              <input 
                type="email"
                name="email"
                id="email"
                class="form-control"
                required="required"
                placeholder="Email Must Be Valid"
                onfocus="onInputFocus(this)"
                onblur="onInputBlur()"
              />
            </div>
          </div>
          <div class="form-group row">
            <label for="full" class="col-sm-2 col-form-label">Full Name</label>
            <div class="col-sm-10">
              <input 
                type="text"
                name="full"
                id="full"
                class="form-control"
                required="required"
                placeholder="Full Name Appear In Your Profile Page"
                onfocus="onInputFocus(this)"
                onblur="onInputBlur()"
              />
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-12">
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
            $user   = $_POST['username'];
            $pass   = $_POST['password'];
            $hashedpass   = sha1($_POST['password']);
            $email  = $_POST['email'];
            $name   = $_POST['full'];
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
                echo "Sorry This Username is Exist";
              }else{
                // Insert User Info In Database
                $stmt = $con->prepare("INSERT INTO
                                          users(Username, Password, Email, FullName)
                                        VALUES(:user, :pass, :email, :name)
                                      ");
                // Execute Query
                $stmt->execute(array(
                  'user' => $user,
                  'pass' => $hashedpass,
                  'email' => $email,
                  'name' => $name
                ));
                // Echo Success Message
                echo '<div class="alert alert-success">' . $stmt->rowCount() . ' Record(s) Inserted</div>';
              }
            }
        }else{
          $theMsg = '<div class="alert alert-danger">You Can NOT Access This Page Directly</div>';
          redirectToHome($theMsg, 'back');
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
              <label for="username" class="col-sm-2 col-form-label">Username</label>
              <div class="col-sm-10">
                <input
                  type="text"
                  name="username"
                  id="username"
                  class="form-control"
                  required="required"
                  value="<?php echo $row['Username'] ?>"
                  autocomplete="off"
                />
              </div>
            </div>
            <div class="form-group row">
              <label for="newpassword" class="col-sm-2 col-form-label">Password</label>
              <div class="col-sm-10">
                <input 
                type="hidden" 
                name="oldpassword" 
                value="<?php echo $row['Password'] ?>" 
                />
                <input
                  type="password"
                  name="newpassword"
                  id="newpassword"
                  class="form-control"
                  onfocus="onInputFocus(this)"
                  onblur="onInputBlur()"
                  placeholder="If You Want, Change Your Password"
                  autocomplete="new-password"
                />
              </div>
            </div>
            <div class="form-group row">
              <label for="email" class="col-sm-2 col-form-label">Email</label>
              <div class="col-sm-10">
                <input
                  type="email"
                  name="email"
                  id="email"
                  class="form-control"
                  required="required"
                  value="<?php echo $row['Email'] ?>"
                />
              </div>
            </div>
            <div class="form-group row">
              <label for="full" class="col-sm-2 col-form-label">Full Name</label>
              <div class="col-sm-10">
                <input
                  type="text"
                  name="full"
                  id="full"
                  class="form-control"
                  required="required"
                  value="<?php echo $row['FullName'] ?>"
                />
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-12">
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
        echo 'Error There Is No Such ID';
      }
    }elseif($do == 'Update'){ // Update Page
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        echo '<h1 class="text-center">Update Member</h1>';
        echo '<div class="container">';
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
            // Update The Database With This Info
            $stmt = $con->prepare("UPDATE
                                      users
                                    SET
                                      Username = ?,
                                      Password = ?,
                                      Email = ?,
                                      FullName = ?
                                    WHERE
                                      UserID = ?
                                  ");
            // Execute Query
            $stmt->execute(array($user, $pass, $email, $name, $id));
            // Echo Success Message
            $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Record(s) Updated</div>';
            redirectToHome($theMsg, 'back');
          }
          
        }else{
          echo 'You Can NOT Access This Page Directly';
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
        // The Row Count
        $count = $stmt->rowCount();
        // If There Is Such ID, Show The Form
        if($count > 0){
          $stmt = $con->prepare("DELETE FROM users WHERE UserID = :user");
          $stmt->bindParam(":user", $userid);
          $stmt->execute();
          // Echo Success Message
          echo '<div class="alert alert-success">' . $stmt->rowCount() . ' Record(s) Deleted</div>';
        }else{
          echo 'ID You Entered NOT Exist';
        }
      echo '</div>';
    }

    //=======================================================
    include $templates . 'footer.php';
  }else{
    header('location: index.php');
    exit();
  }