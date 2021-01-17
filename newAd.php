<?php
  /* start or resume session */
  session_start();
  /* start or resume session */

  $pageTitle = 'Create New Ad';

  /* start includes */
  include './init.php';
  /* end includes */
  //=======================================================

  if(isset($_SESSION['username'])){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      // Start Backend Validation
      $formErrors = array();
      $name         = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
      $description  = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
      $price        = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
      $country      = filter_var($_POST['country'], FILTER_SANITIZE_STRING);
      $status       = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
      $category     = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);

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
      if($category == 0){
        $formErrors[] = 'You Have To Choose The <strong>Category</strong>';
      }
      // End Backend Validation
      if(empty($formErrors)){
        // Insert Item Info In Database
        /*$stmt = $con->prepare("INSERT INTO
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
        ));*/
        // Echo Success Message
        $successMsg = '<div class="alert alert-success success-message">Item Added Successfully</div>';
      }
    }
  ?>
    <div class="new-ad">
      <div class="container">
        <h1 class="text-center"><?php echo $pageTitle?></h1>
        <?php
          if (!empty($formErrors)) {
            foreach($formErrors as $error){
              echo '<div class="alert alert-danger danger-message">'. $error .'</div>';
            }
          }
          if (isset($successMsg)){
            echo $successMsg;
          }
        ?>
        <div class="col-sm-12">
          <div class="card">
            <div class="card-header">
              <i class="fab fa-buysellads"></i> <?php echo $pageTitle ?>
            </div>
            <div class="card-body">
              <form action="?do=Insert" method="POST">
                <div class="form-group row">
                  <label class="col-sm-12 col-form-label my-label field-holder">
                    <p class="col-sm-2">Name</p>
                    <input
                      type="text"
                      name="name"
                      class="col-sm-10 form-control live-name"
                      placeholder="Item Name"
                      onfocus="onInputFocus(this)"
                      onblur="onInputBlur()"
                      autofocus
                      />
                      <!--required="required"-->
                  </label>
                </div>
                <div class="form-group row">
                  <label class="col-sm-12 col-form-label my-label field-holder">
                    <p class="col-sm-2">Description</p>
                    <textarea
                      type="text"
                      name="description"
                      class="col-sm-10 form-control live-description"
                      placeholder="Describe Your Item"
                      onfocus="onInputFocus(this)"
                      onblur="onInputBlur()"
                    ></textarea>
                  </label>
                </div>
                <div class="form-group row">
                  <label class="col-sm-12 col-form-label my-label field-holder">
                    <p class="col-sm-2">Price</p>
                    <input
                      type="text"
                      name="price"
                      class="col-sm-10 form-control live-price"
                      placeholder="Item Price"
                      onfocus="onInputFocus(this)"
                      onblur="onInputBlur()"
                      />
                      <!--required="required"-->
                  </label>
                </div>
                <div class="form-group row">
                  <label class="col-sm-12 col-form-label my-label field-holder">
                    <p class="col-sm-2">Country</p>
                    <input
                      type="text"
                      name="country"
                      class="col-sm-10 form-control"
                      placeholder="Item Country"
                      onfocus="onInputFocus(this)"
                      onblur="onInputBlur()"
                      />
                      <!--required="required"-->
                  </label>
                </div>
                <div class="form-group row">
                  <label class="col-sm-12 col-form-label my-label field-holder">
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
                  <label class="col-sm-12 col-form-label my-label field-holder">
                    <p class="col-sm-2">Category</p>
                    <select
                      name="category"
                      class="col-sm-10 form-control">
                      <option value="0">...</option>
                      <?php
                        $stmt = $con->prepare("SELECT CategoryID, Name FROM `categories`");
                        $stmt->execute();
                        $rows = $stmt->fetchAll();
                        foreach($rows as $row){
                          echo '<option value="'.$row['CategoryID'].'">'.$row['Name'].'</option>';
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
              <div class="ProductCard">
                <span class="price">$100</span>
                <div class="image">
                  <img
                    src="./data/images/productsImages/download.jfif"
                    alt="Product"
                  />
                </div>
                <div class="content">
                  <h5><a href="#">Product Name</a></h5>
                  <p class="description">Product Description</p>
                  <div class="read-more">
                    <button>
                      <a href="#">Read more</a>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php
  }else{
    header('Location: login.php');
  }

  //=======================================================
  include $templates . 'footer.php';