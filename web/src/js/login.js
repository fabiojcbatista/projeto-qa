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
            if (!response) {
                showError(response.message);     
            } else {
                efetuarLogin();
            }
        } catch (error) {
            showError('Erro ao tentar fazer login. Tente novamente mais tarde.');
        }
    });
}

function efetuarLogin() {
    window.open(`produtos.html?teste=123`, '_self');
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