document.addEventListener('DOMContentLoaded', function() {
    loadProfile();
    document.getElementById('avatar-upload').addEventListener('change', handleAvatar);
    document.getElementById('edit-username').addEventListener('click', showEditUsername);
    document.getElementById('cancel-username').addEventListener('click', hideEditUsername);
    document.getElementById('save-username').addEventListener('click', saveUsername);
    document.getElementById('edit-email').addEventListener('click', showEditEmail);
    document.getElementById('cancel-email').addEventListener('click', hideEditEmail);
    document.getElementById('save-email').addEventListener('click', saveEmail);
    document.getElementById('lingua-select').addEventListener('change', changeLanguage);
});

function loadProfile() {
    fetch('api.php?action=get_profilo')
        .then(r => r.json())
        .then(d => {
            if (d.success) {
                document.getElementById('username-display').textContent = d.user.Username;
                document.getElementById('email-display').textContent = d.user.Email;
                document.getElementById('avatar-preview').src = d.user.Avatar || 'default-avatar.png';
            } else showMessage('Errore', 'error');
        })
        .catch(() => showMessage('Errore', 'error'));
}

function handleAvatar(e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = ev => document.getElementById('avatar-preview').src = ev.target.result;
    reader.readAsDataURL(file);
    const fd = new FormData();
    fd.append('action', 'update_avatar');
    fd.append('avatar', file);
    fetch('api.php', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(d => d.success ? showMessage('OK', 'success') : showMessage('Errore', 'error'))
        .catch(() => showMessage('Errore', 'error'));
}

function showEditUsername() {
    document.getElementById('username-display').style.display = 'none';
    document.getElementById('edit-username').style.display = 'none';
    document.getElementById('edit-username-form').style.display = 'flex';
    document.getElementById('username-input').value = document.getElementById('username-display').textContent;
}
function hideEditUsername() {
    document.getElementById('username-display').style.display = 'inline';
    document.getElementById('edit-username').style.display = 'inline';
    document.getElementById('edit-username-form').style.display = 'none';
}
function saveUsername() {
    const val = document.getElementById('username-input').value.trim();
    if (!val) return;
    const fd = new FormData();
    fd.append('action', 'update_username');
    fd.append('username', val);
    fetch('api.php', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(d => {
            if (d.success) {
                document.getElementById('username-display').textContent = val;
                hideEditUsername();
                showMessage('OK', 'success');
            } else showMessage('Errore', 'error');
        })
        .catch(() => showMessage('Errore', 'error'));
}

function showEditEmail() {
    document.getElementById('email-display').style.display = 'none';
    document.getElementById('edit-email').style.display = 'none';
    document.getElementById('edit-email-form').style.display = 'flex';
    document.getElementById('email-input').value = document.getElementById('email-display').textContent;
}
function hideEditEmail() {
    document.getElementById('email-display').style.display = 'inline';
    document.getElementById('edit-email').style.display = 'inline';
    document.getElementById('edit-email-form').style.display = 'none';
}
function saveEmail() {
    const val = document.getElementById('email-input').value.trim();
    if (!val) return;
    const fd = new FormData();
    fd.append('action', 'update_email');
    fd.append('email', val);
    fetch('api.php', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(d => {
            if (d.success) {
                document.getElementById('email-display').textContent = val;
                hideEditEmail();
                showMessage('OK', 'success');
            } else showMessage('Errore', 'error');
        })
        .catch(() => showMessage('Errore', 'error'));
}

function changeLanguage() {
    const lang = document.getElementById('lingua-select').value;
    window.location.href = 'profilo.html?lang=' + lang;
}

function showMessage(txt, type) {
    const msg = document.getElementById('message');
    msg.textContent = txt;
    msg.className = 'message ' + type;
    setTimeout(() => { msg.textContent = ''; msg.className = 'message'; }, 3000);
}