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
** $errorMsg = Echo The Message
** $seconds = Seconds Before Redirecting
*/
function redirectToHome($errorMsg, $seconds = 3){
  echo "<div class ='alert alert-danger'>$errorMsg</div>";
  echo "<div class='alert alert-info'>You Will Be Redirected to Homepage In $seconds Seconds.</div>";
  header("refresh:$seconds;url=index.php");
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