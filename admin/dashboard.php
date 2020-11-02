<?php
  session_start();
  
  if(isset($_SESSION['username'])){
    $pageTitle = 'Dashboard';
    include 'init.php';
    //=======================================================
?>
    <!--  -->
    <div class="container home-stats text-center">
      <h1>Dashboard</h1>
      <div class="row">
        <div class="col-md-3">
          <div class="stat st-total-members">
            Total Members
            <span><a href="members.php"><?php echo countItems('UserID', 'users') ?></a></span>
          </div>
        </div>
        <div class="col-md-3">
          <div class="stat st-pending-members">
            Pending Members
            <span>25</span>
          </div>
        </div>
        <div class="col-md-3">
          <div class="stat st-total-items">
            Total Items
            <span>1500</span>
          </div>
        </div>
        <div class="col-md-3">
          <div class="stat st-total-comments">
            Total Comments
            <span>12000</span>
          </div>
        </div>
      </div>
    </div>
    <div class="container latest">
      <div class="row">
        <div class="col-sm-6">
          <div class="card">
            <div class="card-header">
              <i class="fa fa-users"></i> Latest Registered Users
            </div>
            <div class="card-body">
              Test
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="card">
            <div class="card-header">
              <i class="fa fa-users"></i> Latest Items
            </div>
            <div class="card-body">
              Test
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--  -->
<?php
    //=======================================================
    include $templates . 'footer.php';
  }else{
    header('location: index.php');
    exit();
  }