<?php
  /*
    ================================================
    == Categories Page
    ================================================
  */

  session_start();
  
  if(isset($_SESSION['adminName'])){
    $pageTitle = 'Categories';
    include 'init.php';
    //=======================================================

    $do = isset($_GET['do']) ? $do = $_GET['do'] : $do = 'Manage';
    if($do == 'Manage'){      // Manage Categories Page
      // Select All Categories With ASC Default Ordering
      $sort = isset($_GET["sort"]) && $_GET["sort"] == "DESC"? "DESC" : "ASC"; // Check If User choose DESC or Not
      $stmt = $con->prepare("SELECT * FROM categories ORDER BY Ordering $sort");
      // Execute The Statement
      $stmt ->execute();
      // Assign To Variable
      $rows = $stmt->fetchAll();
      //$rows = [];
      if(empty($rows)) {
    ?>
      <div class="container">
        <div class="alert alert-info no-item-message">There Is No Categories</div>
        <div class="form-group row">
          <div class="col-sm-10">
            <a href="?do=Add" class="btn btn-primary">Add Category</a>
          </div>
        </div>
      </div>
    <?php
      }else{
    ?>
      <h1 class="text-center">Manage Categories</h1>
      <div class="container categories">
        <div class="card">
          <div class="card-header">
            <div>
              <i class="fa fa-edit"></i> Manage Categories
            </div>
            <div class="sorting">
              <i class="fa fa-sort"></i> Ordering
              <a href="?sort=ASC">Asc</a> |
              <a href="?sort=DESC">Desc</a>
            </div>
          </div>
          <div class="card-body">
            <?php
              foreach($rows as $row){
                echo '<div class="cat">';
                  echo '
                    <div class="hidden">
                      <a
                        href="?do=Edit&catid='.$row['CategoryID'].'"
                        class="btn btn-sm btn-primary"
                      >
                        <i class="fa fa-edit"></i> Edit
                      </a>
                      <a
                        href="?do=Delete&catid='.$row['CategoryID'].'"
                        class="btn btn-sm btn-danger"
                      >
                        <i class="fa fa-close"></i> Delete
                      </a>
                    </div>
                  ';
                  echo '<h3>' . $row['Name'] . '</h3>';
                  echo $row['Description'] == ""? '<p class="no-description">NO DESCRIPTION</p>' : '<p>' . $row['Description'] . '</p>';
                  echo $row['Visibility'] == 1? '<span class="cat-settings visibility"><i class="fa fa-eye"></i> Hidden</span>' : '';
                  echo $row['Allow_Comments'] == 1? '<span class="cat-settings comments"><i class="fa fa-close"></i> Comments Disabled</span>' : '';
                  echo $row['Allow_Ads'] == 1? '<span class="cat-settings ads"><i class="fa fa-close"></i> Ads Blocked</span>' : '';
                echo '</div>';
                echo '<hr/>';
              }
            ?>
          </div>
        </div>
        <a href="?do=Add" class="btn btn-primary">+ New Category</a>
      </div>
    <?php
      }
    ?>
    <?php
    }elseif($do == 'Add'){    // Add Category Page ?>
      <h1 class="text-center">Add New Category</h1>
      <div class="container">
        <form action="?do=Insert" method="POST">
          <div class="form-group row form-group-lg">
            <label class="col-sm-12 col-form-label my-label field-holder">
              <p class="col-sm-2">Name</p>
              <input
                type="text"
                name="name"
                class="col-sm-10 form-control"
                required="required"
                placeholder="Category Name"
                onfocus="onInputFocus(this)"
                onblur="onInputBlur()"
                autofocus
              />
            </label>
          </div>
          <div class="form-group row">
          <label class="col-sm-12 col-form-label my-label field-holder">
            <p class="col-sm-2">Description</p>
            <textarea
              type="text"
              name="description"
              class="col-sm-10 form-control"
              placeholder="Describe Your Category"
              onfocus="onInputFocus(this)"
              onblur="onInputBlur()"
            ></textarea>
            </label>
          </div>
          <div class="form-group row">
            <label class="col-sm-12 col-form-label my-label field-holder">
              <p class="col-sm-2">Ordering</p>
              <input 
                type="text"
                name="ordering"
                class="col-sm-10 form-control"
                placeholder="Type a Number Which Indicates the Category Order"
                onfocus="onInputFocus(this)"
                onblur="onInputBlur()"
              />
            </label>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Visible</label>
            <div class="col-sm-10 radio-group">
              <div>
                <label>
                  <input type="radio" name="visibility" value="0" checked />
                  Yes
                </label>
              </div>
              <div>
                <label>
                  <input type="radio" name="visibility" value="1" />
                  No
                </label>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Allow Comments</label>
            <div class="col-sm-10 radio-group">
              <div>
                <label>
                  <input type="radio" name="commenting" value="0" checked />
                  Yes
                </label>
              </div>
              <div>
                <label>
                  <input type="radio" name="commenting" value="1" />
                  No
                </label>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Allow Ads</label>
            <div class="col-sm-10 radio-group">
              <div>
                <label>
                  <input type="radio" name="ads" value="0" checked />
                  Yes
                </label>
              </div>
              <div>
                <label>
                  <input type="radio" name="ads" value="1" />
                  No
                </label>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-2"></div>
            <div class="col-sm-10">
              <button
                type="submit"
                value="Add Category"
                class="btn btn-primary"
              >
                Add Category
              </button>
            </div>
          </div>
        </form>
      </div>
    <?php
    }elseif($do == 'Insert'){ // Insert Page
      echo '<h1 class="text-center">Insert Category</h1>';
      echo '<div class="container">';
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Get Variables From Form
            $name        = $_POST['name'];
            $description = $_POST['description'];
            $ordering    = $_POST['ordering'];
            $visibility  = $_POST['visibility'];
            $commenting  = $_POST['commenting'];
            $ads         = $_POST['ads'];
            // Validation Of The Form
            $formErrors = array();

            if(empty($name)){
              $formErrors[] = 'Category name Can\'t Be <strong>Empty</strong>';
            }
            foreach($formErrors as $error){
              echo '<div class="alert alert-danger">' . $error . '</div>';
            }
            // Check If There Is No Errors Proceed The Insert Process
            if(empty($formErrors)){
              // Check If Category Exists in Database
              $check = checkItem("Name"/* $column */, "categories"/* $table */, $name/* $value */);
              if($check == 1){
                $theMsg = '<div class="alert alert-danger">Sorry This Category name is Exist</div>';
                redirectToHome($theMsg, 'back', 1.5);
              }else{
                // Insert Category Info In Database
                $stmt = $con->prepare("INSERT INTO
                                          categories(Name, Description, Ordering, Visibility, Allow_Comments, Allow_Ads)
                                        VALUES(:name, :description, :ordering, :visibility, :commenting, :ads)
                                      ");
                // Execute Query
                $stmt->execute(array(
                  'name'        => $name,
                  'description' => $description,
                  'ordering'    => $ordering,
                  'visibility'  => $visibility,
                  'commenting'  => $commenting,
                  'ads'         => $ads
                ));
                // Echo Success Message
                $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Category(s) Inserted</div>';
                redirectToHome($theMsg, 'back', .5);
              }
            }
        }else{
          $theMsg = '<div class="alert alert-danger">You Can NOT Access This Page Directly</div>';
          redirectToHome($theMsg);
        }
      echo '</div>';
    }elseif($do == 'Edit'){   //Edit Members Page
      // Check If Category ID In Get Request Is Integer & Get Its Integer Value
      $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;
      // Select All Data Depend On This ID
      $stmt = $con->prepare("SELECT
                                *
                              FROM
                                categories
                              WHERE
                                CategoryID = ?
                              LIMIT
                                1
                            ");
      // Execute Query
      $stmt->execute(array($catid));
      // Fetch The Data
      $row = $stmt->fetch(); // To get all data in this record
      // The Row Count
      $count = $stmt->rowCount();
      // If There Is Such ID, Show The Form
      if($count > 0){?>
        <h1 class="text-center">Edit Category</h1>
        <div class="container">
          <form action="?do=Update" method="POST">
            <input
              type="hidden"
              name="catid"
              value="<?php echo $catid ?>"
            />
            <div class="form-group row form-group-lg">
              <label class="col-sm-12 col-form-label my-label field-holder">
                <p class="col-sm-2">Name</p>
                <input
                  type="text"
                  name="name"
                  class="col-sm-10 form-control"
                  required="required"
                  placeholder="Category Name"
                  onfocus="onInputFocus(this)"
                  onblur="onInputBlur()"
                  value="<?php echo $row['Name'] ?>"
                  autofocus
                />
              </label>
            </div>
            <div class="form-group row">
              <label class="col-sm-12 col-form-label my-label field-holder">
                <p class="col-sm-2">Description</p>
                <textarea
                  type="text"
                  name="description"
                  class="col-sm-10 form-control"
                  placeholder="Describe Your Category"
                  onfocus="onInputFocus(this)"
                  onblur="onInputBlur()"
                ><?php echo $row['Description'] ?></textarea>
              </label>
            </div>
            <div class="form-group row">
              <label class="col-sm-12 col-form-label my-label field-holder">
                <p class="col-sm-2">Ordering</p>
                <input 
                  type="text"
                  name="ordering"
                  class="col-sm-10 form-control"
                  placeholder="Type a Number Which Indicates the Category Order"
                  onfocus="onInputFocus(this)"
                  onblur="onInputBlur()"
                  value="<?php echo $row['Ordering'] ?>"
                />
              </label>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Visible</label>
              <div class="col-sm-10 radio-group">
                <div>
                  <label>
                    <input type="radio" name="visibility" value="0" <?php if($row['Visibility'] == 0){echo "checked";} ?> />
                    Yes
                  </label>
                </div>
                <div>
                  <label>
                    <input type="radio" name="visibility" value="1" <?php if($row['Visibility'] == 1){echo "checked";} ?> />
                    No
                  </label>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Allow Comments</label>
              <div class="col-sm-10 radio-group">
                <div>
                  <label>
                    <input type="radio" name="commenting" value="0" <?php if($row['Allow_Comments'] == 0){echo "checked";} ?> />
                    Yes
                  </label>
                </div>
                <div>
                  <label>
                    <input type="radio" name="commenting" value="1" <?php if($row['Allow_Comments'] == 1){echo "checked";} ?> />
                    No
                  </label>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Allow Ads</label>
              <div class="col-sm-10 radio-group">
                <div>
                  <label>
                    <input type="radio" name="ads" value="0" <?php if($row['Allow_Ads'] == 0){echo "checked";} ?> />
                    Yes
                  </label>
                </div>
                <div>
                  <label>
                    <input type="radio" name="ads" value="1" <?php if($row['Allow_Ads'] == 1){echo "checked";} ?> />
                    No
                  </label>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-2"></div>
              <div class="col-sm-10">
                <button
                  type="submit"
                  value="Edit Category"
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
    }elseif($do == 'Update'){ // Update Page
      echo '<h1 class="text-center">Update Category</h1>';
      echo '<div class="container">';
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
          // Get Variables From Form
          $id          = $_POST['catid'];
          $name        = $_POST['name'];
          $description = $_POST['description'];
          $ordering    = $_POST['ordering'];
          $visibility  = $_POST['visibility'];
          $commenting  = $_POST['commenting'];
          $ads         = $_POST['ads'];
          // Validation Of The Form
          $formErrors = array();

          if(empty($name)){
            $formErrors[] = 'Category name Can\'t Be <strong>Empty</strong>';
          }
          foreach($formErrors as $error){
            echo '<div class="alert alert-danger">' . $error . '</div>';
          }
          // Check If There Is No Errors Proceed The Update Process
          if(empty($formErrors)){
              // Update The Database With This Info
              $stmt = $con->prepare("UPDATE
                                        categories
                                      SET
                                        Name = ?,
                                        Description = ?,
                                        Ordering = ?,
                                        Visibility = ?,
                                        Allow_Comments = ?,
                                        Allow_Ads = ?
                                      WHERE
                                        CategoryID = ?
                                    ");
              // Execute Query
              $stmt->execute(array($name, $description, $ordering, $visibility, $commenting, $ads, $id));
              // Echo Success Message
              $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Category(s) Updated</div>';
              redirectToHome($theMsg, 'back', .5);
          }
      }else{
        $theMsg = '<div class="alert alert-danger">You Can NOT Access This Page Directly</div>';
        redirectToHome($theMsg);
      }
      echo '</div>';
    }elseif($do == 'Delete'){ // Delete Member Page
      echo '<h1 class="text-center">Delete Member</h1>';
      echo '<div class="container">';
        /*
        Note That:
        If We Type the userid=1 In The HTTP Request
        We Will Delete The Admin Which Has Not To Happen
        */
        // Check If Category ID In Get Request Is Integer & Get Its Integer Value
        $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;
        // Select All Data Depend On This ID
        $check = checkItem('CategoryID'/* $column */, 'categories'/* $table */, $catid/* $value */);
        // If There Is Such ID, Show The Form
        if($check > 0){
          $stmt = $con->prepare("DELETE FROM categories WHERE CategoryID = :id");
          $stmt->bindParam(":id", $catid);
          $stmt->execute();
          // Echo Success Message
          $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Record(s) Deleted</div>';
          redirectToHome($theMsg, 'back');
        }else{
          $theMsg = '<div class="alert alert-danger">ID You Entered NOT Exist</div>';
          redirectToHome($theMsg);
        }
      echo '</div>';
    }

    //=======================================================
    include $templates . 'footer.php';
  }else{
    header('location: index.php');
    exit();
  }