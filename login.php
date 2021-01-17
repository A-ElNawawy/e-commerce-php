<?php
  /* start or resume session */
  session_start();

  if(isset($_SESSION['username'])){
    header('location: index.php');
  }
  /* start or resume session */

  $pageTitle = 'Login';

  /* start includes */
  include './init.php';
  /* end includes */
  //=======================================================


  // check if user is coming from HTTP request
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // check does user log in or sign up
    if(isset($_POST['login'])){
      $username = $_POST['username'];
      $password = $_POST['password'];
      $hashedpass = sha1($password);
  
      // check if user exist in database
      $stmt = $con->prepare("SELECT
                                `Username`, `Password`
                              FROM
                                users
                              WHERE
                                Username = ?
                              AND
                                Password = ?
      ");
      $stmt->execute(array($username, $hashedpass));
      $count = $stmt->rowCount();
      if ($count > 0) {
        $_SESSION['username'] = $username;
        header('location: index.php');
        exit();
      }else{
        echo 'Wrong User Name or Password';
      }
    }else{
      $formErrors = array();
      $username = $_POST['username'];
      $password = $_POST['password'];
      $password2 = $_POST['password2'];
      $email = $_POST['email'];
      /*
      I don't see any use to this check because of the parent check
      ($_SERVER['REQUEST_METHOD'] == 'POST')
      */

      // Validation Check In Backend:
      // Username Check:
      if(isset($username)) {
        // To Avoid Script Injection
        $filteredUser = filter_var($username, FILTER_SANITIZE_STRING);
        // check username length
        if(strlen($filteredUser) < 4) {
          $formErrors[] = 'Username must be more than 3 chars';
        }
      }
      // Password Check:
      if(isset($password) && isset($password2)){
        // check password length
        if(strlen($password) < 9){
          echo $password;
          $formErrors[] = 'Password must be more than 8 chars';
        }
        /*
          Here we don't have to make sanitization because sha1 converts any scripts to a password
        */
        // check passwords Matching
        if($password !== $password2){
          $formErrors[] = 'Passwords are NOT matching';
        }
      }
      // Email Check:
      if(isset($_POST['email'])){
        $filteredEmail = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
        if(filter_var($filteredEmail, FILTER_VALIDATE_EMAIL) != TRUE){
          $formErrors[] = 'Please Enter A Valid Email';
        }
      }
      // Check If There Is No Errors Proceed The User Add
     if(empty($formErrors)){
        // Check If User Exists in Database
        $check = checkItem("Username", "users", $username);
        if($check == 1){
          $formErrors[] = 'Sorry This Username is Exist';
        }else{
          // Insert User Info In Database
          $stmt = $con->prepare("INSERT INTO
                                    users(`Username`, `Password`, `Email`, `RegStatus`, `Date`)
                                  VALUES(:user, :pass, :email, 0, now())
                                ");
          // Execute Query
          $stmt->execute(array(
            'user'  => $username,
            'pass'  => sha1($password),
            'email' => $email
          ));
          // Echo Success Message
          $successMsg = '<div class="alert alert-success success-message">Congratulations, You Registered Successfully</div>';
          //header("location: login.php?form=login");
        }
      }
      
    }
  }
  // To Switch Between Login & Signup Forms
  $form = isset($_GET["form"]) ? $_GET["form"] : "login";
  // If User Click Signup Button With Invalid Inputs, Don't Switch to Login Form
  $form = isset($_POST['signup']) ? "signup" : $form;
?>
  <div class="container">
      <?php
        if (!empty($formErrors)) {
          foreach($formErrors as $error){
            echo '<div class="alert alert-danger danger-message">'. $error .'</div>';
          }
        }
        if (isset($successMsg)){
          echo $successMsg;
        }
      ?>
    <div id="loginHolder" class="login-holder">
      <h4 class="text-center">
        <span id="login" class="login <?php if($form == "login"){echo "active";} ?>" onclick="activate()">
          <a href="?form=login">Login</a>
        </span>
        &nbsp;|&nbsp;
        <span id="signup" class="signup <?php if($form == "signup"){echo "active";} ?>" onclick="activate()">
          <a href="?form=signup">Signup</a>
        </span>
      </h4>
      <?php
        if($form == "login"){
      ?>
        <!-- Start Login Form -->
        <form class="login" action="<?php echo($_SERVER)['PHP_SELF']; ?>" method="POST">
          <div class="field-holder">
            <label>Username:</label>
            <input
              type="text"
              name="username"
              class="form-control"
              onfocus="onInputFocus(this)"
              onblur="onInputBlur()"
              placeholder="Username"
              autocomplete="off"
              autofocus
            />
          </div>
          <div class="field-holder">
            <label>Password:</label>
            <input
              type="password"
              name="password"
              class="form-control"
              onfocus="onInputFocus(this)"
              onblur="onInputBlur()"
              placeholder="Password"
              autocomplete="new-password"
            />
          </div>
          <input
            type="submit"
            name="login"
            class="btn btn-block"
            value="login"
          />
        </form>
        <!-- End Login Form -->
      <?php
        }else{
      ?>
        <!-- Start Signup Form -->
        <form class="signup" action="<?php echo($_SERVER)['PHP_SELF']; ?>" method="POST">
          <div class="field-holder">
            <label>Username:</label>
            <input
              type="text"
              name="username"
              class="form-control"
              onfocus="onInputFocus(this)"
              onblur="onInputBlur()"
              placeholder="Username"
              autocomplete="off"
              autofocus
              required="required"
              pattern=".{4,}"
              title="Username must be more than 3 Chars"
            />

          </div>
          <div class="field-holder">
            <label>Email:</label>
            <input
              type="email"
              name="email"
              class="form-control"
              onfocus="onInputFocus(this)"
              onblur="onInputBlur()"
              placeholder="email"
              required="required"
            />
          </div>
          <div class="field-holder">
            <label>Password:</label>
            <input
              type="password"
              name="password"
              class="form-control"
              onfocus="onInputFocus(this)"
              onblur="onInputBlur()"
              placeholder="Password"
              autocomplete="new-password"
              required="required"
              minlength="4"
            />
          </div>
          <div class="field-holder">
            <label>Password again:</label>
            <input
              type="password"
              name="password2"
              class="form-control"
              onfocus="onInputFocus(this)"
              onblur="onInputBlur()"
              placeholder="Retype Your Password"
              autocomplete="new-password"
              required="required"
              minlength="4"
            />
          </div>
          <input
            type="submit"
            name="signup"
            class="btn btn-block"
            value="signup"
          />
        </form>
        <!-- End Signup Form -->
      <?php
        }
      ?>
    </div>
  </div>
<?php


  //=======================================================
    include $templates . 'footer.php';