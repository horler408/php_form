//alert("Hello");
//DOM Element
const form = document.getElementsByClassName('form');
const fName = document.getElementById('first-name');
const fNameError = document.getElementById('first-name-error');
const lName = document.getElementById('last-name');
const lNameError = document.getElementById('last-name-error');
const email = document.getElementById('email');
const emailError = document.getElementById('email-error');
const password = document.getElementById('password');
const pError = document.getElementById('password-error');
const cPassword = document.getElementById('confirm-password');
const cPasswordError = document.getElementById('confirm-password-error');


validate(fName, fNameError);
validate(lName, lNameError);
validate(email, emailError);
validate(password, pError);


function validate(input, errorMsg) {
    let valid = true;
    input.addEventListener('blur', () => {
        if(!input.value){
            valid = false
            errorMsg.textContent = "This field is neccesary!"
        }else errorMsg.textContent = ""
   })

   cPassword.addEventListener('blur', () => {
       const pass = password.value;
       const confirmPass = cPassword.value
       if(pass != confirmPass) {
           cPasswordError.textContent = "Passwords do not match"
           valid = false
       } else {
           cPasswordError.textContent = ""
           valid = true
       }
   })
   return valid; 
}


// form.addEventListener('submit', () => {
//     if(validate()){
        
//     }
// })