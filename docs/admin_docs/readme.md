#Hide navbar:
============
- if we want to hide navbar in any page we have to set ($hide_navbar = '';) before including init.php in this page.
------------------------------------------------------------------------------

#Page Title:
============
- We have a Function called (getTitle) we call it in the header.php file to make the page title dynamic
- All you need is to set variable ==> ($pageTitle = 'name you want';) before including init.php in this page.
- If it doesn't set, it will has a default value.

------------------------------------------------------------------------

#Input Field Required Sign *:
============================
- We put the ( Required ) sign (*) To Every Required Input Field ( Dynamically ) using js in ( backend.js ) file.
- <span class="asterisk">*</span>

------------------------------------------------------------------------

#Redirect Function:
==================
- We Use This Function to Echo Error Messages Then Redirect to Homepage after few seconds [ 3seconds is Default ].
- This Function Accepts Parameters:
$errorMsg = Message to Be Display.
$seconds = Seconds Before Redirecting.