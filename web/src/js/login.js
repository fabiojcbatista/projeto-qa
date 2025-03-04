document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.querySelector('.form-login');
    const errorMessage = document.querySelector('.alert-danger');

    if (loginForm) {
    loginForm.addEventListener('submit', async function(event) {
        event.preventDefault();
        const email = document.getElementById('email').value;
        const senha = document.getElementById('senha').value;

        try {
            const response = await loginUser(email, senha);
            if (response.success) {
                // Redirecionar para a página principal ou dashboard
                window.location.href = '/produtos.html';
            } else {
                showError(response.message);
            }
        } catch (error) {
            showError('Erro ao tentar fazer login. Tente novamente mais tarde.');
        }
    });
}

    function showError(message) {
        errorMessage.classList.remove('esconder');
        document.getElementById('mensagem').textContent = message;
    }

    async function loginUser(email, senha) {
        const response = await fetch('http://fabiojcb.atwebpages.com/projeto-qa/api/v1/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ email, senha })
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        return response.json();
    }
});