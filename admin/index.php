<?php
  /* start or resume session */
  session_start();

  if(isset($_SESSION['username'])){
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
      $_SESSION['username'] = $username;
      $_SESSION['ID'] = $row['UserID'];
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
    <h4 class="text-center">Admin Login</h4>
    <input onfocus="onInputFocus(this)" onblur="onInputBlur()" class="form-control" type="text" name="user" placeholder="Username" autocomplete="off" />
    <input onfocus="onInputFocus(this)" onblur="onInputBlur()" class="form-control" type="password" name="pass" placeholder="Password" autocomplete="new-password" />
    <input class="btn btn-primary btn-block" type="submit" value="login" />
  </form>
<!-- end HTML -->

<?php include $templates . 'footer.php'; ?>