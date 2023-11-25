// const form = document.getElementById("form");
//const userName = document.getElementById("name");
//const apellidos = document.getElementById("apellidos");
//const DNI = document.getElementById("DNI");
//const phoneNumber = document.getElementById("phone_number");
//const email = document.getElementById("email");
//const password = document.getElementById("password");

function formValidationEdit() {
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

  if (!DNI.value.match( /^[0-9]{8}[A-Z]{1}$/) ){
    alert("DNI must be 8 numbers and one letter long!");
    DNI.focus();
    return false;
  }

  var numero = DNI.value.substring(0, 8);
  var letra = DNI.value.charAt(8).toUpperCase();
  var letrasValidas = 'TRWAGMYFPDXBNJZSQVHLCKE';
  var digitoControlEsperado = letrasValidas[numero % 23];

  if (letra !== digitoControlEsperado) {
    alert("Introduce un DNI válido")
    DNI.focus();
    return false;  
  }

  if (!phoneNumber.value.match(/^[1-9][0-9]{8}$/)) {
    alert("Phone number must be 9 characters long number and first digit can't be 0!");
    phoneNumber.focus();
    return false;
  }

  // checking email format
  if (!email.value.match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,})+$/)) {
    alert("Please enter a valid email!");
    email.focus();
      return false;
    }
  // checking password character pattern
  var updatePasswordCheckbox = document.getElementById("update_password");
  if(updatePasswordCheckbox.checked){
    if (!password.value.match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{12,25}$/)) {
        alert("Password must contain at least one lowercase letter, one uppercase letter, one numeric digit, and one special character, and must be between 12 and 25 characters long.");
        password.focus();
        return false;
    }
    if (password.value.indexOf('@') !== -1 || password.value.indexOf('#') !== -1 || password.value.indexOf('"') !== -1 || password.value.indexOf("'") !== -1 || password.value.indexOf(';') !== -1 || password.value.indexOf('&') !== -1 || password.value.indexOf('\\') !== -1) {
        alert("La contraseña no puede contener los caracteres @, #, \", ', \\, ;, &")
        password.focus();
        return false;
    }
  }     
  return true;
}
