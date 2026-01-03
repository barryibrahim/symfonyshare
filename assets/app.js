/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

/*
 * Welcome to your app's main JavaScript file!
 */



console.log('JS OK – app.js est bien chargé');

document.addEventListener('DOMContentLoaded', function () {

    const form = document.querySelector('form[name="edit_password"]');

    if (!form) return;

    const newPassword = document.getElementById('edit_password_newPassword_first');
    const confirmPassword = document.getElementById('edit_password_newPassword_second');

    form.addEventListener('submit', function (event) {

        let errors = [];

        if (newPassword.value.length < 8) {
            errors.push("Le mot de passe doit contenir au moins 8 caractère .");
        }

        if (newPassword.value !== confirmPassword.value) {
            errors.push("Les mots de passe ne correspondent pas mec .");
        }

        if (errors.length > 0) {
            event.preventDefault();
            alert(errors.join("\n"));
        }

    });

});


