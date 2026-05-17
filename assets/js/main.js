document.querySelectorAll('input[type="search"]').forEach(input => {
    input.addEventListener('keydown', event => {
        if (event.key === 'Escape') {
            input.value = '';
        }
    });
});
<<<<<<< HEAD

document.querySelectorAll('[data-auth-form]').forEach(form => {
    const password = form.querySelector('[data-password]');
    const confirm = form.querySelector('[data-password-confirm]');
    const hint = form.querySelector('[data-password-hint]');

    if (!password || !confirm || !hint) {
        return;
    }

    const validate = () => {
        const hasEnoughLength = password.value.length >= 6;
        const matches = password.value === confirm.value;

        if (!password.value && !confirm.value) {
            hint.textContent = 'Usa minimo 6 caracteres.';
            hint.className = 'password-hint';
            return;
        }

        if (!hasEnoughLength) {
            hint.textContent = 'La contrasena debe tener minimo 6 caracteres.';
            hint.className = 'password-hint error';
            return;
        }

        if (confirm.value && !matches) {
            hint.textContent = 'Las contrasenas no coinciden.';
            hint.className = 'password-hint error';
            return;
        }

        hint.textContent = matches ? 'Las contrasenas coinciden.' : 'Confirma tu contrasena.';
        hint.className = matches ? 'password-hint success' : 'password-hint';
    };

    password.addEventListener('input', validate);
    confirm.addEventListener('input', validate);
    form.addEventListener('submit', event => {
        validate();
        if (password.value.length < 6 || password.value !== confirm.value) {
            event.preventDefault();
            confirm.focus();
        }
    });
});

document.querySelectorAll('[data-password]').forEach(input => {
    const wrap = input.parentElement;
    if (!wrap || wrap.querySelector('.password-toggle')) {
        return;
    }

    const button = document.createElement('button');
    button.type = 'button';
    button.className = 'password-toggle';
    button.textContent = 'Mostrar';
    button.addEventListener('click', () => {
        const visible = input.type === 'text';
        input.type = visible ? 'password' : 'text';
        button.textContent = visible ? 'Mostrar' : 'Ocultar';
    });
    wrap.appendChild(button);
});
=======
>>>>>>> 38ddd9f37320cc1c5bbd520b648079b846e81dbf
