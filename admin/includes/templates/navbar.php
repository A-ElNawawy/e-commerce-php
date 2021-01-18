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
            href="members.php?do=Edit&userid=<?php echo $_SESSION['adminID'] ?>"
            >
              <?php echo lang('EDIT_PROFILE') ?><!-- Edit Profile -->
            </a>
            <a
              class="dropdown-item"
              href="./../index.php"
            >
              <?php echo lang('VISIT_SHOP') ?><!-- Settings -->
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