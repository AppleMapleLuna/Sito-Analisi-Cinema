document.getElementById('cambia-password-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const old = document.getElementById('old-password').value;
    const nw = document.getElementById('new-password').value;
    const cf = document.getElementById('confirm-password').value;
    if (nw !== cf) {
        showMessage('Le password non coincidono', 'error');
        return;
    }
    if (nw.length < 6) {
        showMessage('Minimo 6 caratteri', 'error');
        return;
    }
    const fd = new FormData();
    fd.append('action', 'cambia_password');
    fd.append('old_password', old);
    fd.append('new_password', nw);
    fetch('api.php', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(d => {
            if (d.success) {
                showMessage('Password aggiornata', 'success');
                setTimeout(() => window.location.href = 'profilo.php', 1500);
            } else showMessage(d.message || 'Errore', 'error');
        })
        .catch(() => showMessage('Errore', 'error'));
});

function showMessage(txt, type) {
    const msg = document.getElementById('message');
    msg.textContent = txt;
    msg.className = 'message ' + type;
    setTimeout(() => { msg.textContent = ''; msg.className = 'message'; }, 3000);
}