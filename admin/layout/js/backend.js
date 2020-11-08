/*
$(function () {
  'use strict';
  // Hide placeholder On Form Focus
  $('[placeholder]').focus(function () {

    $(this).attr('data-text', $(this).attr('placeholder'));

    $(this).attr('placeholder', '');

  }).blur(function() {
    
    $(this).attr('placeholder', $(this).attr('data-text'));

  });

  // We Want To Assign An * To Every Required Input Field ( Dynamically )
  $('input').each(function () {
    if($(this).attr('required') === 'required'){
      $(this).after('<span class="asterisk">*</span>');
    }
  });

  // Convert Password Field To Text Field On Hover
  var passField = $('.password');
  $('.show-pass').hover(function () {
    passField.att('type', 'text');
  }, function(){
    passField.attr('type', 'password');
  });
});
*/

/*=================================================================
== we want to make focus/blur effect in the input fields
== first code with jquery ( but it doesn't work -I don't know why-)
== second code vanilla JS
=================================================================*/

let placeholder ="";
let field = "";
function onInputFocus(focusedInput){
  field = focusedInput;
  placeholder = field.placeholder;
  field.placeholder = "";
}
function onInputBlur(){
  field.placeholder = placeholder;
  placeholder ="";
}
/* ========================================================================== */
    /* =============================================================== */
              /* ===================================== */

/*=====================================================================
== We Want To Assign An * To Every Required Input Field ( Dynamically )
======================================================================*/
let inputs = document.getElementsByTagName('input');
for(const input of inputs) {
  if (input.required === true){
    let span = document.createElement("span");
    span.className = "asterisk";
    span.innerHTML = "*";
    input.after(span);
  }
};
/* ========================================================================== */
    /* =============================================================== */
              /* ===================================== */

/*=====================================================================
== Convert Password Field To Text Field On Hover On eye Icon
======================================================================*/
let eye = document.getElementsByClassName('show-pass')[0];
// If There Is No eye Element Escape all the next code
if(eye !== undefined){
  let passField = eye.previousElementSibling.previousElementSibling;
  eye.addEventListener("mouseover", function(){
    passField.type = "text";
  });
  eye.addEventListener("mouseout", function(){
    passField.type = "password";
  });
}
/* ========================================================================== */
    /* =============================================================== */
              /* ===================================== */
let deleteButtons = document.getElementsByClassName('delete');
for (const button of deleteButtons){
  button.addEventListener('click', function(){
    alert(`Are You Sure You Want To Delete:[ ${button.id} ]`);
  })
}