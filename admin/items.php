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
    if($do == 'Manage'){
      echo '<a href="?do=Add">+ Add</a>';
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
            foreach($formErrors as $error){
              echo '<div class="alert alert-danger">' . $error . '</div>';
            }
            // Check If There Is No Errors Proceed The Insert Process
            if(empty($formErrors)){
              // Insert User Info In Database
              $stmt = $con->prepare("INSERT INTO
                                        items(Name, Description, Price, Country_Made, Status, Add_Date)
                                      VALUES(:name, :description, :price, :country, :status, now())
                                    ");
              // Execute Query
              $stmt->execute(array(
                'name'        => $name,
                'description' => $description,
                'price'       => $price,
                'country'     => $country,
                'status'      => $status
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
    }elseif($do == 'Edit'){
      
    }elseif($do == 'Update'){
      
    }elseif($do == 'Delete'){
      
    }elseif($do == 'Activate'){
      
    }

    //=======================================================
    include $templates . 'footer.php';
  }else{
    header('location: index.php');
    exit();
  }