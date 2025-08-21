const campo = document.getElementById('nome_prod');

campo.addEventListener('keypress', function(e) {
    // e.key é a tecla que o usuário digitou
    if (/\d/.test(e.key)) { // verifica se é número
        e.preventDefault(); // impede que o número seja digitado
        alert('Não é permitido números!');
    }
});