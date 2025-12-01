document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.querySelector('.form-login');
    const errorMessage = document.querySelector('.alert-danger');

    if (loginForm) {
        loginForm.addEventListener('submit', async function (event) {
            event.preventDefault();
            const email = document.getElementById('email').value;
            const senha = document.getElementById('senha').value;

            try {
                const result = await loginUser(email, senha);
                if (result.success) {
                    efetuarLogin();
                } else {
                    showError(result.message || 'Usuário ou senha inválida.');
                }
            } catch (error) {
                showError('Erro ao tentar realizar login.');
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
        try {
            const response = await fetch('../../api/v1/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ email, senha })
            });

            const data = await response.json();

            if (!response.ok) {
                return { success: false, message: data.message || 'Usuário ou senha inválida.' };
            }

            return { success: true, data: data };
        } catch (error) {
            return { success: false, message: 'Erro de conexão com o servidor.' };
        }
    }
});