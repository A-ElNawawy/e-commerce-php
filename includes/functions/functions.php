<?php
/*
** getCats Function v1.0
** Function to Get All Categories From Database
*/
function getCats(){
  global $con;
  $cat = $con->prepare("SELECT * FROM categories ORDER BY CategoryID ASC");
  $cat->execute();
  $cats = $cat->fetchAll();
  return $cats;
}

/*
** getItems Function v1.0
** Function to Get All Items By Default or Items of a Certain Category From Database [ Accepts Parameters ]
** $catid = The ID of Category Which We Want to Get Its Items [ Default = 0 ]
*/
function getItems($catid = 0){
  $filter = "";
  if($catid != 0){
    $filter = "WHERE Cat_ID = ?";
  }
  global $con;
  $item = $con->prepare("SELECT
                            *
                          FROM
                            items
                          $filter
                          ORDER BY
                            ItemID
                          ASC
  ");
  $item->execute(array($catid));
  $items = $item->fetchAll();
  return $items;
}


/*
** getUserItems Function v1.0
** Function to Get Items of a Certain Member From Database [ Accepts Parameters ]
** $userid = The ID of Member Which We Want to Get His Items
We don't have to Set a Default value,
Because We Will Use It after $_SESSION['username'] check
*/
function getUserItems($userid){
  global $con;
  $item = $con->prepare("SELECT
                            *
                          FROM
                            items
                          WHERE
                            Member_ID = ?
                          ORDER BY
                            ItemID
                          ASC
  ");
  $item->execute(array($userid));
  $items = $item->fetchAll();
  return $items;
}

/*
** checkRegStatus Function v1.0
** Function to check if user is activated by Admin or Not [ Accepts Parameters ]
** $username = username to be checked,
We don't have to Set a Default value,
Because We Will Use It after $_SESSION['username'] check
*/
function checkRegStatus($username){
  global $con;
  $stmt = $con->prepare("SELECT
                            `Username`, `RegStatus`
                          FROM
                            users
                          WHERE
                            Username = ?
                          AND
                            RegStatus = 1
  ");
  $stmt->execute(array($username));
  $registeredCount = $stmt->rowCount();
  return $registeredCount;
}

/*
** getUserInfo Function v1.0
** Function to Get All User's Info [ Accepts Parameters ]
** $username = username to Get,
We don't have to Set a Default value,
Because We Will Use It after $_SESSION['username'] check
*/
function getUserInfo($username){
  global $con;
  $stmt = $con->prepare("SELECT
                            *
                          FROM
                            users
                          WHERE
                            Username = ?
  ");
  $stmt->execute(array($username));
  $userInfo = $stmt->fetch();
  return $userInfo;
}





/* ======================================== */
/* ======================================== */
/* ======================================== */
/* ======================================== */
/* ======================================== */
/* ======================================== */
/* ======================================== */
/* ======================================== */
/* ======================================== */
/* ======================================== */






/*
** getTitle() Function v1.0
** This Function That Echo The Page Title In Case The Page
** Has The Variable $pageTitle And Echo [ Default ] Title For Other Pages
*/
function getTitle(){
  global $pageTitle;
  if(isset($pageTitle)){
    echo $pageTitle;
  }else{
    echo 'Default';
  }
}

/*
** redirectToHome() v1.0
** Home Redirect Function [ Accepts Parameters ]
** $errorMsg = Echo The Error Message
** $seconds  = Seconds Before Redirecting
*******************************************
** redirectToHome() v2.0
** Home Redirect Function [ Accepts Parameters ]
** $theMsg  = Echo The Message [ Error | Success | Warning ]
** $url     = The Link Will be Redirect to
** $seconds = Seconds Before Redirecting
*/
function redirectToHome($theMsg, $url = null, $seconds = 1){
  if($url === null){
    $url = 'index.php';
    $link = 'Homepage';
  }else{
    if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== ''){
      $url = $_SERVER['HTTP_REFERER'];
      $link = 'Previous Page';
    }else{
      $url = 'index.php';
      $link = 'Homepage';
    }
  }
  echo $theMsg;
  echo "<div class='alert alert-info'>You Will Be Redirected to $link In $seconds Seconds.</div>";
  header("refresh:$seconds;url=$url");
  exit();
}

/*
** checkItem Function v1.0
** Function to Check Item in Database [ Accepts Parameters ]
** $column  = The Item to Select
** $table   = The Table to Select From
** $value   = The Value of $column
*/
function checkItem($column, $table, $value){
  global $con;
  $statement = $con->prepare("SELECT $column FROM $table WHERE $column = ?");
  $statement->execute(array($value));
  $count = $statement->rowCount();
  return $count;
}

/*
** countItems Function v1.0
** Function to get Number of Given Items in Given Table [ Accepts Parameters ]
** $column  = The Item to Count
** $table   = The Table to Select From
*/
function countItems($column, $table){
  global $con;
  $statement = $con->prepare("SELECT COUNT($column) FROM $table");
  $statement->execute();
  $count = $statement->fetchColumn();
  return $count;
}

/*
** getLatest Function v1.0
** Function to Get Latest number of Items From Database [ Accepts Parameters ]
** $column  = The Item to Select
** $table   = The Table to Select From
** $order   = The Column That We Want To Order Results According to It Descending
** $limit   = Number of Records We Want to Get
*/
function getLatest($column, $table, $order, $limit = 5){
  global $con;
  $statement = $con->prepare("SELECT $column FROM $table ORDER BY $order DESC LIMIT $limit");
  $statement->execute();
  $rows = $statement->fetchAll();
  return $rows;
}