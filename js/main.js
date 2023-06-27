const togglePassword = document.querySelector('#togglePassword');
    const passwordField = document.querySelector('#senha');

    togglePassword.addEventListener('click', function (e) {
        // alternar o tipo de atributo
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);

        // alternar a classe do ícone de olho / olho-riscado
        this.classList.toggle('fa-lock');
        this.classList.toggle('fa-lock-open');
    });