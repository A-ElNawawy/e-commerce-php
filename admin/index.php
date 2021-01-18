<?php
  /* start or resume session */
  session_start();

  if(isset($_SESSION['adminName'])){
    header('location: dashboard.php');
  }
  /* start or resume session */
  
  $hide_navbar = '';
  $pageTitle = 'Login';

  /* start includes */
  include './init.php';
  /* end includes */
  
  /* start code */
  // check if user is coming from HTTP request
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['user'];
    $password = $_POST['pass'];
    $hashedpass = sha1($password);

    // check if user exist in database
    $stmt = $con->prepare("SELECT
                              UserID, Username, Password
                            FROM
                              users
                            WHERE
                              Username = ?
                            AND
                              Password = ?
                            AND
                              GroupID = 1
                            LIMIT
                              1
                          ");
    $stmt->execute(array($username, $hashedpass));
    $row = $stmt->fetch(); // To get all data in this record
    $count = $stmt->rowCount();
    if ($count > 0) {
      $_SESSION['adminName'] = $username;
      $_SESSION['adminID'] = $row['UserID'];
      header('location: dashboard.php');
      exit();
    }else{
      echo 'You are not admin';
    }
  }
  /* end code */
?>

<!-- start HTML -->
  <form class="login" action="<?php echo($_SERVER)['PHP_SELF']; ?>" method="POST">
    <h4 class="text-center">Login</h4>
    <input
      type="text"
      name="user"
      class="form-control"
      onfocus="onInputFocus(this)"
      onblur="onInputBlur()"
      placeholder="Username"
      autocomplete="off"
      autofocus
      />
    <input 
      type="password"
      name="pass"
      class="form-control"
      onfocus="onInputFocus(this)"
      onblur="onInputBlur()"
      placeholder="Password"
      autocomplete="new-password"
    />
    <input 
      type="submit"
      class="btn btn-primary btn-block"
      value="login"
    />
  </form>
<!-- end HTML -->

<?php include $templates . 'footer.php'; ?>