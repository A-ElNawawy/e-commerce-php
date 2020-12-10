<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">-->
    <script src="https://kit.fontawesome.com/e5627610fe.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?php echo $css; ?>backend.css">
    <title><?php getTitle() ?></title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <a class="navbar-brand" href="dashboard.php">
          <?php echo lang('ADMIN_HOME') ?><!-- Admin Home -->
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

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto navbar-right">
            <li class="nav-item">
              <a class="nav-link" href="categories.php">
                <?php echo lang('CATEGORIES') ?><!-- Categories -->
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="items.php">
                <?php echo lang('ITEMS') ?><!-- Items -->
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="members.php">
                <?php echo lang('MEMBERS') ?><!-- Members -->
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="comments.php">
                <?php echo lang('COMMENTS') ?><!-- Comments -->
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <?php echo lang('STATISTICS') ?><!-- Statistics -->
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <?php echo lang('LOGS') ?><!-- Logs -->
              </a>
            </li>
            <li class="nav-item dropdown">
              <a
                class="nav-link dropdown-toggle"
                href="#" id="navbarDropdown"
                role="button"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >
                <?php echo lang('ADMIN_NAME') ?><!-- Admin Name -->
              </a>
              <div class="dropdown-menu dropdown-dark" aria-labelledby="navbarDropdown">
                <a
                class="dropdown-item" 
                href="members.php?do=Edit&userid=<?php echo $_SESSION['ID'] ?>"
                >
                  <?php echo lang('EDIT_PROFILE') ?><!-- Edit Profile -->
                </a>
                <a class="dropdown-item" href="#">
                  <?php echo lang('SETTINGS') ?><!-- Settings -->
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout.php">
                  <?php echo lang('LOGOUT') ?><!-- Logout -->
                </a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>