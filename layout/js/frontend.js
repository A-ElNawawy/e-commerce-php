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
== Prompt a Confirmation Message Before Delete
======================================================================*/
let deleteButtons = document.getElementsByClassName('delete');
for (const button of deleteButtons){
  button.addEventListener('click', function(){
    return confirm("Are You Sure?");
    // Note It Isn't Working Correctly
    // If You Choose Cancel It Will proceed
  })
}
/* ========================================================================== */
    /* =============================================================== */
              /* ===================================== */

/*=====================================================================
== Make Live content in Create New Ad Page
======================================================================*/
//let prodName = document.getElementsByClassName("live-name")[0];