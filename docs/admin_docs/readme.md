#Hide navbar:
============
- To hide navbar in any page, set ($hide_navbar = '';) before including [ init.php ] in this page.
        ------------------------------------------------------------------------

#Input Field Required Sign (*):
==============================
- We put the ( Required ) sign (*) To Each Required Input Field ( Dynamically ) using js in [ backend.js ] file.
- <span class="asterisk">*</span>
- Parameters: [ No Parameters ]
- Return: [ No Returns ]
        ------------------------------------------------------------------------

#getTitle Function:
==================
- We call This Function in The [ header.php ] file to make the page title dynamic.
- All you need is to set variable ==> ($pageTitle = 'name you want';) before including [ init.php ] in the page.
- [ Default = 'Default' ]
- Parameters: [ No Parameters ]
- Return: [ No Returns ]
        ------------------------------------------------------------------------

#redirectToHome Function:
========================
- We Use This Function to Echo Error Messages Then Redirect to Homepage after few seconds.
- Parameters:
    $errorMsg = Message to Be Display.          [ Default = ]
    $seconds = Seconds Before Redirecting.      [ Default = 3 seconds ]
- Return: [ No Returns ]
        ------------------------------------------------------------------------

#checkItem Function:
===================
- We Use This Function to Check If Item Exists in Database or Not.
- Also We Can Use It To Get Number Of Existing Data.
- Parameters:
    $column  = The Item to Select.               [ Default = ]
    $table   = The Table to Select From.         [ Default = ]
    $value   = The Value of $column.             [ Default = ]
- Return:
    $count   = Number of Items if Exist.
        ------------------------------------------------------------------------

#countItems Function:
====================
- We Use This Function to Get The Number of Item in Table
- Parameters:
    $column = The Item to Count.               [ Default = ]
    $table  = The Table to Select From.        [ Default = ]
- Return:
    $count  = Number of Items Found.
        ------------------------------------------------------------------------

#getLatest Function:
====================
- We Use This Function to Get Latest number of Items From Database
- Parameters:
    $column  = The Item to Select.                                                  [ Default = ]
    $table   = The Table to Select From.                                            [ Default = ]
    $order   = The Column That We Want To Order Results According to It Descending. [ Default = ]
    $limit   = Number of Records We Want to Get.                                    [ Default = 5 ]
- Return:
    $rows  = Array of The Latest -$limit- Rows.