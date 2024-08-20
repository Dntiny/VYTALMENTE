var inactivityTimeout;

function resetTimer() {
    clearTimeout(inactivityTimeout);
    inactivityTimeout = setTimeout(logout, 600000); // 10 minutos en milisegundos
}

document.addEventListener("mousemove", resetTimer);
document.addEventListener("keydown", resetTimer);
document.addEventListener("click", resetTimer);

function logout() {
    // Redirige a una página de cierre de sesión o ejecuta el código para cerrar la sesión en el servidor
    window.location.href = "cerrar_sesion.php";
}
