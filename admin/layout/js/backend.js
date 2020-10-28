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


  $('input').each(function () {
    if($(this).attr('required') === 'required'){
      $(this).after('<span class="asterisk">*</span>');
    }
  })
});
*/

/*=================================================================
== we want to make focus - blur effect in the input fields
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