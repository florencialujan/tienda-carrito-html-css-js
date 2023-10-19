//Validaciones form Registro
const form = document.getElementById('form');
  const email = document.getElementById('email');
  const pass = document.getElementById('pass');

  function isValidEmail(email) {
    // expresión regular para validar el correo electrónico.
    const regex = /^\S+@\S+\.[a-z]{2,}$/i
    return regex.test(email);
  }

  function isValidPassword(password) {
    // Valida que la contraseña tenga al menos 8 caracteres.
    return password.length >= 8;
  }

  form.addEventListener('submit', function(event) {
    if (!isValidEmail(email.value)) {
      alert('Por favor, ingrese un correo electrónico válido.');
      event.preventDefault();
    }
    if (!isValidPassword(pass.value)) {
      alert('La contraseña debe tener al menos 8 caracteres.');
      event.preventDefault();
    }
  });
