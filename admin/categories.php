<?php
  /*
    ================================================
    == Categories Page
    ================================================
  */

  session_start();
  
  if(isset($_SESSION['username'])){
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
      $rows = $stmt->fetchAll(); ?>
      <h1 class="text-center">Manage Categories</h1>
      <div class="container categories">
        <div class="card">
          <div class="card-header">
            Manage Categories
            <div class="sorting">
              Choose Categories Order
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
                      <a href="#" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Edit</a>
                      <a href="#" class="btn btn-sm btn-danger"><i class="fa fa-close"></i> Delete</a>
                    </div>
                  ';
                  echo '<h3>' . $row['Name'] . '</h3>';
                  echo $row['Description'] == ""? '<p>This Category Has No Description</p>' : '<p>' . $row['Description'] . '</p>';
                  echo $row['Visibility'] == 1? '<span class="cat-settings visibility">Hidden</span>' : '';
                  echo $row['Allow_Comments'] == 1? '<span class="cat-settings comments">Comments Disabled</span>' : '';
                  echo $row['Allow_Ads'] == 1? '<span class="cat-settings ads">Ads Blocked</span>' : '';
                echo '</div>';
                echo '<hr/>';
              }
            ?>
          </div>
        </div>
        <a href="?do=Add" class="btn btn-primary">+ New Category</a>
      </div>
    <?php
    }elseif($do == 'Add'){    // Add Category Page ?>
      <h1 class="text-center">Add New Category</h1>
      <div class="container">
        <form action="?do=Insert" method="POST">
          <div class="form-group row form-group-lg">
            <label for="name" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
              <input
                type="text"
                name="name"
                id="name"
                class="form-control"
                required="required"
                placeholder="Category Name"
                onfocus="onInputFocus(this)"
                onblur="onInputBlur()"
              />
            </div>
          </div>
          <div class="form-group row">
            <label for="description" class="col-sm-2 col-form-label">Description</label>
            <div class="col-sm-10">
              <input
                type="text"
                name="description"
                id="description"
                class="form-control"
                placeholder="Describe Your Category"
                onfocus="onInputFocus(this)"
                onblur="onInputBlur()"
              />
            </div>
          </div>
          <div class="form-group row">
            <label for="ordering" class="col-sm-2 col-form-label">Ordering</label>
            <div class="col-sm-10">
              <input 
                type="text"
                name="ordering"
                id="ordering"
                class="form-control"
                placeholder="Type a Number Which Indicates the Category Order"
                onfocus="onInputFocus(this)"
                onblur="onInputBlur()"
              />
            </div>
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
            <div class="col-sm-12">
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
    }elseif($do == 'Edit'){

    }elseif($do == 'Update'){

    }elseif($do == 'Delete'){

    }

    //=======================================================
    include $templates . 'footer.php';
  }else{
    header('location: index.php');
    exit();
  }