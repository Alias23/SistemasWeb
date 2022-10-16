// const form = document.getElementById("form");
const userName = document.getElementById("name");
const apellidos = document.getElementById("apellidos");
const DNI = document.getElementById("DNI");
const phoneNumber = document.getElementById("phone_number");
const email = document.getElementById("email");
const password = document.getElementById("password");

// form.addEventListener('submit', e => {
//   e.preventDefault();

//   // validateInputs();
// });

// const setError = (element, message) => {
//   print(message);

// }

// const setSuccess = element => {
//   const inputControl = element.parentElement;
//   const errorDisplay = inputControl.querySelector('.error');

//   errorDisplay.innerText = '';
//   inputControl.classList.add('success');
//   inputControl.classList.remove('error');
// };

// const isValidName = name => {
//   const re = userName.value.length < 2 || userName.value.length > 20;
//   return re.test(String(name).toLowerCase());
// }

// const validateInputs = () => {
//   const userNameValue = userName.value.trim();
//   const emailValue = email.value.trim();
//   const passwordValue = password.value.trim();
//   const password2Value = password2.value.trim();

//   if(userNameValue === '') {
//       setError(userNameValue, 'Username is required');
//   } else {
//       setSuccess(userName);
//   }

// };
function formValidation() {
  // checking length of name
  if (userName.value.length < 2 || userName.value.length > 20) {
    alert("Name length should be more than 2 and less than 21 charaters");
    userName.focus();
    return false;
  }

  if (apellidos.value.length < 2 || apellidos.value.length > 40) {
    alert("Subname length should be more than 2 and less than 41 charaters");
    userName.focus();
    return false;
  }

  if (!DNI.value.match( /^[0-9]{8}$/) ){
    alert("DNI must be 8 numbers and one letter long!");
    DNI.focus();
    return false;
  }

  if (!phoneNumber.value.match(/^[1-9][0-9]{8}$/) && !phoneNumber.value.length >=9) {
    alert("Phone number must be 9 characters long number and first digit can't be 0!");
    phoneNumber.focus();
    return false;
  }

  // checking email format
  if (email.value.match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/)) {
    alert("Please enter a valid email!");
    email.focus();
    return false;
  }
  // checking password character pattern
  if (password.value.match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/)) {
    alert("Password must contain at least one lowercase letter, one uppercase letter, one numeric digit, and one special character, and must be between 8 and 15 characters long.");
    password.focus();
    return false;
  }
  return true;
}
