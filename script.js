
const formulario =document.querySelector('.formulario'),
inputs = document.querySelectorAll('.formulario input'),

sign_in_container = document.querySelector('.sign-in-container'),
sign_up_container = document.querySelector('.sign-up-container');

console.log(inputs)

const $btnSignIn= document.querySelector('.sign-in-btn'),
  $btnSignUp = document.querySelector('.sign-up-btn'),  
  $signUp = document.querySelector('.sign-up'),
  $signIn  = document.querySelector('.sign-in');

document.addEventListener('click', e => {
if (e.target === $btnSignIn || e.target === $btnSignUp) {
    $signIn.classList.toggle('active'),
    $signUp.classList.toggle('active'),
    $btnSignIn.classList.toggle('active'),
    $btnSignUp.classList.toggle('active');
}
});

const expresiones_regulares ={
nombre: /^[a-zA-ZÀ-ÿ\s]{1,40}$/,
password: /^.{4,12}$/,
email: /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
};

const campos = {
nombre: false,
password: false,
email: false,
}

const validarFormulario = (e) => {
switch (e.target.name) {
    case "nombre":
        validarCampo(expresiones_regulares.nombre, e);
        break;

    case "email":
        validarCampo(expresiones_regulares.email, e);
        break;

    case "password":
        validarCampo(expresiones_regulares.password, e);
        break;

    default:
        break;
}
}

/**
* @param {RegExp} expresion 
* @param {Event} e 
*/
const validarCampo = (expresion, e) => {

const v = e.target.getAttribute('name');
campos[v] = expresion.test(e.target.input);

console.log(campos[v] ? 'Es admitido.' : 'No es admitido.');
}

inputs.forEach((input) =>{
input.addEventListener('keyup', validarFormulario);
input.addEventListener('blur', validarFormulario);
});

formulario.addEventListener('submit', e => {
//e.preventDefault();
if (campos.nombre && campos.password && campos.email) {
    console.log('Bienvenido')
} else {
    console.log('Hubo un error')
}
})