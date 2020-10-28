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
    if($do == 'Manage'){
      echo '<h1>Manage Members Page</h1>';
      echo '<a href="members.php?do=Add">+ Add</a>';
    }elseif($do == 'Add'){ //Add Page ?>
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
      echo 'Insert Page' . '<br/>';
      echo $_POST['username'] . '<br/>';
      echo $_POST['password'] . '<br/>';
      echo $_POST['email'] . '<br/>';
      echo $_POST['full'] . '<br/>';
    }elseif($do == 'Edit'){ //Edit Page
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
          $formErrors[] = '<div class="alert alert-danger">Username Can\'t Be Less Than <strong>4 Chars</strong></div>';
        }
        if(strlen($user) > 20){
          $formErrors[] = '<div class="alert alert-danger">Username Can\'t Be More Than <strong>20 Chars</strong></div>';
        }
        if(empty($user)){
          $formErrors[] = '<div class="alert alert-danger">Username Can\'t Be <strong>Empty</strong></div>';
        }
        if(empty($email)){
          $formErrors[] = '<div class="alert alert-danger">Email Can\'t Be <strong>Empty</strong></div>';
        }
        if(empty($name)){
          $formErrors[] = '<div class="alert alert-danger">Full Name Can\'t Be <strong>Empty</strong></div>';
        }

        foreach($formErrors as $error){
          echo $error;
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
          echo '<div class="alert alert-success">' . $stmt->rowCount() . ' Record(s) Updated</div>';
        }
        
      }else{
        echo 'You Can NOT Access This Page Directly';
      }
      echo '</div>';
    }

    //=======================================================
    include $templates . 'footer.php';
  }else{
    header('location: index.php');
    exit();
  }