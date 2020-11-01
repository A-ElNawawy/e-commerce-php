<?php
/*
** Title Function That Echo The Page Title In Case The Page
** Has The Variable $pageTitle And Echo Default Title For 
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
** Home Redirect Function [ This Function Accepts Parameters ]
** $errorMsg = Echo The Message
** $seconds = Seconds Before Redirecting
*/
function redirectToHome($errorMsg, $seconds = 3){
  echo "<div class ='alert alert-danger'>$errorMsg</div>";
  echo "<div class='alert alert-info'>You Will Be Redirected to Homepage In $seconds Seconds.</div>";
  header("refresh:$seconds;url=index.php");
  exit();
}