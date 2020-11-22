<?php
  /*
    ================================================
    == Items Page
    ================================================
  */

  session_start();
  
  if(isset($_SESSION['username'])){
    $pageTitle = '';
    include 'init.php';
    //=======================================================

    $do = isset($_GET['do']) ? $do = $_GET['do'] : $do = 'Manage';
    if($do == 'Manage'){      // Manage Members Page
      // Select All Items
      $stmt = $con->prepare(" SELECT
                                items.*,
                                categories.Name AS Cat_name,
                                users.Username
                              FROM
                                items
                              INNER JOIN
                                categories
                              ON
                                categories.ID = items.Cat_ID
                              INNER JOIN
                                users
                              ON
                                users.UserID = items.Member_ID
                            ");
      // Execute The Statement
      $stmt ->execute();
      // Assign To Variable
      $rows = $stmt->fetchAll(); ?>
      <h1 class="text-center">Manage Items</h1>
      <div class="container">
        <div class="table-responsive">
          <table class="main-table table table-bordered text-center">
            <tr>
              <td>#ID</td>
              <td>Name</td>
              <td>Description</td>
              <td>Price</td>
              <td>Adding Date</td>
              <td>Made In:</td>
              <td>Status</td>
              <td>Rating</td>
              <td>Category</td>
              <td>Owner</td>
              <td>Action</td>
            </tr>
            <?php
              foreach($rows as $row){
                echo '<tr>';
                echo '<td>' . $row['item_ID'] . '</td>';
                echo '<td>' . $row['Name'] . '</td>';
                echo '<td>' . $row['Description'] . '</td>';
                echo '<td>' . $row['Price'] . '</td>';
                echo '<td>' . $row['Add_Date'] . '</td>';
                echo '<td>' . $row['Country_Made'] . '</td>';
                echo '<td>' . $row['Status'] . '</td>';
                echo '<td>' . $row['Rating'] . '</td>';
                echo '<td><a href="#">' . $row['Cat_name'] . '</a></td>';
                echo '<td><a href="#">' . $row['Username'] . '</a></td>';
                echo '
                  <td>
                    <a
                      href="?do=Edit&itemid='.$row['item_ID'].'"
                      class="btn btn-success"
                    >
                      <i class="fa fa-edit"></i> Edit
                    </a>
                    <a
                      id="'.$row['Name'].'"
                      href="?do=Delete&itemid='.$row['item_ID'].'"
                      class="btn btn-danger delete"
                    >
                    <i class="fa fa-close"></i> Delete
                    </a>
                ';
                echo '</td>';
                echo '</tr>';
              }
            ?>
          </table>
        </div>
        <a href="?do=Add" class="btn btn-primary">+ New Item</a>
      </div>
    <?php
    }elseif($do == 'Add'){    // Add Item Page ?>
      <h1 class="text-center">Add New Item</h1>
      <div class="container">
        <form action="?do=Insert" method="POST">
          <div class="form-group row">
            <label class="col-sm-12 col-form-label my-label">
              <p class="col-sm-2">Name</p>
              <input
                type="text"
                name="name"
                class="col-sm-10 form-control"
                placeholder="Item Name"
                onfocus="onInputFocus(this)"
                onblur="onInputBlur()"
                required="required"
              />
            </label>
          </div>
          <div class="form-group row">
            <label class="col-sm-12 col-form-label my-label">
              <p class="col-sm-2">Description</p>
              <input
                type="text"
                name="description"
                class="col-sm-10 form-control"
                placeholder="Describe Your Item"
                onfocus="onInputFocus(this)"
                onblur="onInputBlur()"
              />
            </label>
          </div>
          <div class="form-group row">
            <label class="col-sm-12 col-form-label my-label">
              <p class="col-sm-2">Price</p>
              <input
                type="text"
                name="price"
                class="col-sm-10 form-control"
                placeholder="Item Price"
                onfocus="onInputFocus(this)"
                onblur="onInputBlur()"
                required="required"
              />
            </label>
          </div>
          <div class="form-group row">
            <label class="col-sm-12 col-form-label my-label">
              <p class="col-sm-2">Country</p>
              <input
                type="text"
                name="country"
                class="col-sm-10 form-control"
                placeholder="Item Country"
                onfocus="onInputFocus(this)"
                onblur="onInputBlur()"
                required="required"
              />
            </label>
          </div>
          <div class="form-group row">
            <label class="col-sm-12 col-form-label my-label">
              <p class="col-sm-2">Status</p>
              <select
                name="status"
                class="col-sm-10 form-control">
                <option value="0">...</option>
                <option value="1">New</option>
                <option value="2">As New</option>
                <option value="3">Used</option>
                <option value="4">Old</option>
                <option value="5">Very Old</option>
              </select>
            </label>
          </div>
          <div class="form-group row">
            <label class="col-sm-12 col-form-label my-label">
              <p class="col-sm-2">Member</p>
              <select
                name="member"
                class="col-sm-10 form-control">
                <option value="0">...</option>
                <?php
                  $stmt = $con->prepare("SELECT UserID, Username FROM `users`");
                  $stmt->execute();
                  $rows = $stmt->fetchAll();
                  foreach($rows as $row){
                    echo '<option value="'.$row['UserID'].'">'.$row['Username'].'</option>';
                  }
                ?>
              </select>
            </label>
          </div>
          <div class="form-group row">
            <label class="col-sm-12 col-form-label my-label">
              <p class="col-sm-2">Category</p>
              <select
                name="category"
                class="col-sm-10 form-control">
                <option value="0">...</option>
                <?php
                  $stmt = $con->prepare("SELECT ID, Name FROM `categories`");
                  $stmt->execute();
                  $rows = $stmt->fetchAll();
                  foreach($rows as $row){
                    echo '<option value="'.$row['ID'].'">'.$row['Name'].'</option>';
                  }
                ?>
              </select>
            </label>
          </div>
          <div class="form-group row">
            <div class="col-sm-2"></div>
            <div class="col-sm-10">
              <button
                type="submit"
                value="Add Category"
                class="btn btn-primary"
              >
                Add Item
              </button>
            </div>
          </div>
        </form>
      </div>
    <?php
    }elseif($do == 'Insert'){ //Insert Page
      echo '<h1 class="text-center">Insert Item</h1>';
      echo '<div class="container">';
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
          // Get Variables From Form
          $name        = $_POST['name'];
          $description = $_POST['description'];
          $price       = $_POST['price'];
          $country     = $_POST['country'];
          $status      = $_POST['status'];
          $member      = $_POST['member'];
          $category      = $_POST['category'];
          // Validation Of The Form
          $formErrors = array();

          if(strlen($name) > 30){
            $formErrors[] = 'Name Can\'t Be More Than <strong>30 Chars</strong>';
          }
          if(empty($name)){
            $formErrors[] = 'Name Can\'t Be <strong>Empty</strong>';
          }
          if(empty($description)){
            $formErrors[] = 'Description Can\'t Be <strong>Empty</strong>';
          }
          // Here I See that Price Validation Isn't Enough
          // price can't be Empty
          // price can't be negative
          // price Must be number only, For Currency Unit We Can Add Select Field
          if(empty($price)){
            $formErrors[] = 'price Can\'t Be <strong>Empty</strong>';
          }
          if(empty($country)){
            $formErrors[] = 'Country Can\'t Be <strong>Empty</strong>';
          }
          if($status == 0){
            $formErrors[] = 'You Have To Choose <strong>Status</strong>';
          }
          if($member == 0){
            $formErrors[] = 'You Have To Choose The <strong>Member</strong>';
          }
          if($category == 0){
            $formErrors[] = 'You Have To Choose The <strong>Category</strong>';
          }
          foreach($formErrors as $error){
            redirectToHome(
              '<div class="alert alert-danger">' . $error . '</div>', /*$theMsg*/
              'back',                                                 /*$url*/
              3                                                       /*$seconds*/
            );
          }
          // Check If There Is No Errors Proceed The Insert Process
          if(empty($formErrors)){
            // Insert Item Info In Database
            $stmt = $con->prepare("INSERT INTO
                                      items(
                                        `Name`,
                                        `Description`,
                                        `Price`,
                                        `Country_Made`,
                                        `Status`,
                                        `Member_ID`,
                                        `Cat_ID`,
                                        `Add_Date`
                                      )
                                      VALUES(
                                        :name,
                                        :description,
                                        :price,
                                        :country,
                                        :status,
                                        :member,
                                        :category,
                                        now()
                                      )
                                  ");
            // Execute Query
            $stmt->execute(array(
              'name'        => $name,
              'description' => $description,
              'price'       => $price,
              'country'     => $country,
              'status'      => $status,
              'member'      => $member,
              'category'    => $category
            ));
            // Echo Success Message
            $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Record(s) Inserted</div>';
            redirectToHome($theMsg, 'back');
          }
      }else{
        $theMsg = '<div class="alert alert-danger">You Can NOT Access This Page Directly</div>';
        redirectToHome($theMsg);
      }
      echo '</div>';
    }elseif($do == 'Edit'){   //Edit Item Page
      // Check If Item ID In Get Request Is Integer & Get Its Integer Value
      $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
      // Select All Data Depend On This ID
      $stmt = $con->prepare("SELECT
                                *
                              FROM
                                items
                              WHERE
                                item_ID = ?
                              LIMIT
                                1
                            ");
      // Execute Query
      $stmt->execute(array($itemid));
      // Fetch The Data
      $item = $stmt->fetch(); // To get all data in this record
      // The Row Count
      $count = $stmt->rowCount();
      // If There Is Such ID, Show The Form
      if($count > 0){?>
        <h1 class="text-center">Edit Item</h1>
        <div class="container">
          <form action="?do=Update" method="POST">
            <input
              type="hidden"
              name="itemid"
              value="<?php echo $itemid ?>"
            />
            <div class="form-group row">
              <label class="col-sm-12 col-form-label my-label">
                <p class="col-sm-2">Name</p>
                <input
                  type="text"
                  name="name"
                  class="col-sm-10 form-control"
                  placeholder="Item Name"
                  onfocus="onInputFocus(this)"
                  onblur="onInputBlur()"
                  required="required"
                  value="<?php echo $item['Name'] ?>"
                />
              </label>
            </div>
            <div class="form-group row">
              <label class="col-sm-12 col-form-label my-label">
                <p class="col-sm-2">Description</p>
                <input
                  type="text"
                  name="description"
                  class="col-sm-10 form-control"
                  placeholder="Describe Your Item"
                  onfocus="onInputFocus(this)"
                  onblur="onInputBlur()"
                  value="<?php echo $item['Description'] ?>"
                />
              </label>
            </div>
            <div class="form-group row">
              <label class="col-sm-12 col-form-label my-label">
                <p class="col-sm-2">Price</p>
                <input
                  type="text"
                  name="price"
                  class="col-sm-10 form-control"
                  placeholder="Item Price"
                  onfocus="onInputFocus(this)"
                  onblur="onInputBlur()"
                  required="required"
                  value="<?php echo $item['Price'] ?>"
                />
              </label>
            </div>
            <div class="form-group row">
              <label class="col-sm-12 col-form-label my-label">
                <p class="col-sm-2">Country</p>
                <input
                  type="text"
                  name="country"
                  class="col-sm-10 form-control"
                  placeholder="Item Country"
                  onfocus="onInputFocus(this)"
                  onblur="onInputBlur()"
                  required="required"
                  value="<?php echo $item['Country_Made'] ?>"
                />
              </label>
            </div>
            <div class="form-group row">
              <label class="col-sm-12 col-form-label my-label">
                <p class="col-sm-2">Status</p>
                <select
                  name="status"
                  class="col-sm-10 form-control">
                  <option value="1" <?php if($item['Status'] == "1"){echo "selected";} ?>>New</option>
                  <option value="2" <?php if($item['Status'] == "2"){echo "selected";} ?>>As New</option>
                  <option value="3" <?php if($item['Status'] == "3"){echo "selected";} ?>>Used</option>
                  <option value="4" <?php if($item['Status'] == "4"){echo "selected";} ?>>Old</option>
                  <option value="5" <?php if($item['Status'] == "5"){echo "selected";} ?>>Very Old</option>
                </select>
              </label>
            </div>
            <div class="form-group row">
              <label class="col-sm-12 col-form-label my-label">
                <p class="col-sm-2">Member</p>
                <select
                  name="member"
                  class="col-sm-10 form-control">
                  <?php
                    $stmt = $con->prepare("SELECT UserID, Username FROM `users`");
                    $stmt->execute();
                    $rows = $stmt->fetchAll();
                    foreach($rows as $row){
                      echo '<option value="'.$row['UserID'].'"';
                      if($item['Member_ID'] == $row['UserID']){echo "selected";}
                      echo '>'.$row['Username'].'</option>';
                    }
                  ?>
                </select>
              </label>
            </div>
            <div class="form-group row">
              <label class="col-sm-12 col-form-label my-label">
                <p class="col-sm-2">Category</p>
                <select
                  name="category"
                  class="col-sm-10 form-control">
                  <?php
                    $stmt = $con->prepare("SELECT ID, Name FROM `categories`");
                    $stmt->execute();
                    $rows = $stmt->fetchAll();
                    foreach($rows as $row){
                      echo '<option value="'.$row['ID'].'"';
                      if($item['Cat_ID'] == $row['ID']){echo "selected";}
                      echo '>'.$row['Name'].'</option>';
                    }
                  ?>
                </select>
              </label>
            </div>
            <div class="form-group row">
              <div class="col-sm-2"></div>
              <div class="col-sm-10">
                <button
                  type="submit"
                  value="Add Category"
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
        echo '<div class="container">';
          echo '<h1 class="text-center">Edit Member</h1>';
          $theMsg = '<div class="alert alert-danger">There Is No Such ID</div>';
          redirectToHome($theMsg);
        echo '</div>';
      }
    }elseif($do == 'Update'){ //Update Page
      echo '<h1 class="text-center">Update Item</h1>';
      echo '<div class="container">';
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
          // Get Variables From Form
          $id          = $_POST['itemid'];
          $name        = $_POST['name'];
          $description = $_POST['description'];
          $price       = $_POST['price'];
          $country     = $_POST['country'];
          $status      = $_POST['status'];
          $member      = $_POST['member'];
          $category      = $_POST['category'];
          // Validation Of The Form
          $formErrors = array();

          if(strlen($name) > 30){
            $formErrors[] = 'Name Can\'t Be More Than <strong>30 Chars</strong>';
          }
          if(empty($name)){
            $formErrors[] = 'Name Can\'t Be <strong>Empty</strong>';
          }
          if(empty($description)){
            $formErrors[] = 'Description Can\'t Be <strong>Empty</strong>';
          }
          // Here I See that Price Validation Isn't Enough
          // price can't be Empty
          // price can't be negative
          // price Must be number only, For Currency Unit We Can Add Select Field
          if(empty($price)){
            $formErrors[] = 'price Can\'t Be <strong>Empty</strong>';
          }
          if(empty($country)){
            $formErrors[] = 'Country Can\'t Be <strong>Empty</strong>';
          }
          foreach($formErrors as $error){
            redirectToHome(
              '<div class="alert alert-danger">' . $error . '</div>', /*$theMsg*/
              'back',                                                 /*$url*/
              3                                                       /*$seconds*/
            );
          }
          // Check If There Is No Errors Proceed The Insert Process
          if(empty($formErrors)){
            // Update Item Info In Database
            $stmt = $con->prepare("UPDATE
                                      items
                                    SET
                                      `Name` = ?,
                                      `Description` = ?,
                                      `Price` = ?,
                                      `Country_Made` = ?,
                                      `Status` = ?,
                                      `Member_ID` = ?,
                                      `Cat_ID` = ?
                                    WHERE
                                      item_ID = ?
                                  ");
            // Execute Query
            $stmt->execute(array($name, $description, $price, $country, $status, $member, $category, $id));
            // Echo Success Message
            $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Record(s) Inserted</div>';
            redirectToHome($theMsg, 'back');
          }
      }else{
        $theMsg = '<div class="alert alert-danger">You Can NOT Access This Page Directly</div>';
        redirectToHome($theMsg);
      }
      echo '</div>';
    }elseif($do == 'Delete'){ // Delete Item Page
      echo '<h1 class="text-center">Delete Item</h1>';
      echo '<div class="container">';
        // Check If User ID In Get Request Is Integer & Get Its Integer Value
        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
        // Select All Data Depend On This ID
        $check = checkItem('item_ID'/* $column */, 'items'/* $table */, $itemid/* $value */);
        // If There Is Such ID, Show The Form
        if($check > 0){
          $stmt = $con->prepare("DELETE FROM items WHERE item_ID = :item");
          $stmt->bindParam(":item", $itemid);
          $stmt->execute();
          // Echo Success Message
          $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Record(s) Deleted</div>';
          redirectToHome($theMsg, 'back');
        }else{
          $theMsg = '<div class="alert alert-danger">ID You Entered NOT Exist</div>';
          redirectToHome($theMsg);
        }
      echo '</div>';
    }elseif($do == 'Activate'){
      
    }

    //=======================================================
    include $templates . 'footer.php';
  }else{
    header('location: index.php');
    exit();
  }