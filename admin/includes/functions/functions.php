<?php
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


** redirectToHome() v2.0
** Home Redirect Function [ Accepts Parameters ]
** $theMsg  = Echo The Message [ Error | Success | Warning ]
** $url     = The Link Will be Redirect to
** $seconds = Seconds Before Redirecting
*/
function redirectToHome($theMsg, $url = null, $seconds = 3){
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
** $column = The Item to Select
** $table = The Table to Select From
** $value = The Value of $column
*/
function checkItem($column, $table, $value){
  global $con;
  $statement = $con->prepare("SELECT $column FROM $table WHERE $column = ?");
  $statement->execute(array($value));
  $count = $statement->rowCount();
  return $count;
}