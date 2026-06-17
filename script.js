// Login demo lato client
document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault(); // evita il refresh della pagina

    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const error = document.getElementById('error');

    // Esempio credenziali fittizie
    const validUser = "utente";
    const validPass = "1234";

    if(username === validUser && password === validPass) {
        error.textContent = "";
        alert("Login effettuato con successo!");
        // Qui puoi fare redirect: window.location.href = "dashboard.html";
    } else {
        error.textContent = "Username o password errati";
    }
});