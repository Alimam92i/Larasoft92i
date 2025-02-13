// You can add any Javascript functionality here
// For example, form validation or interactive elements

// Gestion du formulaire de contact
document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formMessage = document.getElementById('formMessage');
    const formData = new FormData(this);
    
    // Effet de chargement
    formMessage.textContent = 'Envoi en cours...';
    formMessage.className = 'form-message loading';
    
    fetch('process_contact.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        formMessage.textContent = data.message;
        formMessage.className = 'form-message ' + (data.success ? 'success' : 'error');
        
        if (data.success) {
            // Réinitialiser le formulaire si l'envoi est réussi
            this.reset();
        }
    })
    .catch(error => {
        formMessage.textContent = 'Une erreur est survenue lors de l\'envoi du message.';
        formMessage.className = 'form-message error';
        console.error('Erreur:', error);
    });
});