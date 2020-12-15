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
  }
  // To Switch Between Login & Signup Forms
  $form = isset($_GET["form"]) ? $_GET["form"] : "login";
?>
  <div class="container">
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
          <input
            type="submit"
            class="btn btn-block"
            value="login"
          />
        </form>
        <!-- End Login Form -->
      <?php
        }else{
      ?>
        <!-- Start Signup Form -->
        <form class="signup">
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
            />
          </div>
          <input
            type="submit"
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