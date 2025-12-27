import './styles/contact.css';


document.getElementById('ContactType').addEventListener('submit', function (event) {
    const inputUtilisateur = document.getElementById('nomUtilisateur').value;
    // Vérifie si le champ du nom d'utilisateur est vide
    if (inputUtilisateur.trim() === '') {
        event.preventDefault(); // Empêche la soumission du formulaire
        document.getElementById('messageErreur').textContent = 'Le nom d\'utilisateur ne peut pas être vide.';
    }
}); 