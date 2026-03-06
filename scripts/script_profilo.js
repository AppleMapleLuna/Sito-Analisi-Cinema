document.addEventListener('DOMContentLoaded', function() {
    loadProfileData();

    // Anteprima avatar quando si seleziona un file
    document.getElementById('avatar-upload').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('avatar-preview').src = event.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    // Gestione submit del form
    document.getElementById('profile-form').addEventListener('submit', function(e) {
        e.preventDefault();
        saveProfileData();
    });
});

function loadProfileData() {
    fetch('get_profilo.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('username').value = data.user.Username;
                document.getElementById('email').value = data.user.Email;
                // Imposta l'avatar (se presente, altrimenti default)
                if (data.user.Avatar) {
                    document.getElementById('avatar-preview').src = data.user.Avatar;
                } else {
                    document.getElementById('avatar-preview').src = 'default-avatar.png';
                }
            } else {
                showMessage('Errore nel caricamento del profilo', 'error');
            }
        })
        .catch(error => {
            console.error('Errore:', error);
            showMessage('Errore di connessione', 'error');
        });
}

function saveProfileData() {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm-password').value;

    if (password !== confirmPassword) {
        showMessage('Le password non coincidono', 'error');
        return;
    }

    const formData = new FormData(document.getElementById('profile-form'));

    fetch('update_profilo.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showMessage('Profilo aggiornato con successo!', 'success');
            // Ricarica i dati per mostrare il nuovo avatar (se cambiato)
            loadProfileData();
            // Pulisci i campi password
            document.getElementById('password').value = '';
            document.getElementById('confirm-password').value = '';
        } else {
            showMessage(data.message || 'Errore durante l\'aggiornamento', 'error');
        }
    })
    .catch(error => {
        console.error('Errore:', error);
        showMessage('Errore di connessione', 'error');
    });
}

function showMessage(text, type) {
    const messageDiv = document.getElementById('message');
    messageDiv.textContent = text;
    messageDiv.className = 'message ' + type;

    setTimeout(() => {
        messageDiv.textContent = '';
        messageDiv.className = 'message';
    }, 5000);
}