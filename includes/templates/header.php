<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/e5627610fe.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?php echo $css; ?>frontend.css">
    <title><?php getTitle() ?></title>
  </head>
  <body>
    <?php
      $categories = getCats();
    ?>
    <nav class="upper-nav">
      <div class="container nav-holder">
        <?php
          if(isset($_SESSION['username'])){
          $userRegStatus = checkRegStatus($sessionUser);
        ?>
          <a href="profile.php"><?php echo $sessionUser ?></a> - 
          <a href="logout.php">Logout</a>
          <?php if($userRegStatus == 0){echo '<p class="not-active-member">Please Activate Your Membership</p>';} ?>
        <?php
          }else{
        ?>
          <a href="login.php">login / signup</a>
        <?php
          }
        ?>
      </div>
    </nav>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container navbar-container">
        <div class="navbar-left">
          <a class="navbar-brand" href="index.php">
            <?php echo lang('HOME') ?><!-- Home -->
          </a>
          <button
            class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>
        </div>

        <div class="collapse navbar-collapse navbar-right" id="navbarSupportedContent">
          <ul class="navbar-nav">
            <li><a class="nav-link" href="categories.php">All</a></li>
            <?php
              foreach($categories as $category){
                echo '
                  <li class="nav-item">
                    <a class="nav-link" href="categories.php?catid='. $category['CategoryID'] .'&catname='. $category['Name'] .'">
                      ' . $category['Name'] . '
                    </a>
                  </li>
                ';
              }
            ?>
          </ul>
        </div>
      </div>
    </nav>