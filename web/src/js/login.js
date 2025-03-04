// Definição da classe Usuario
class Usuario {
    constructor(obj) {
        obj = obj || {};
        this.id = obj.data.id;
        this.nome = obj.data.nome;
        this.email = obj.data.email;
        this.senha = obj.data.senha;
        this.nivel = obj.data.nivel;
    }

    modeloValido() {
        return !!(this.id && this.nome && this.email && this.senha && this.nivel);
    }
}

// Definição da função mostrarAlerta
function mostrarAlerta(mensagem) {
    alert(mensagem); // Simples implementação para exibir alertas
}

var form = {
    email: document.querySelector("#email"),
    senha: document.querySelector("#senha"),
    btnEntrar: document.querySelector("#btn-entrar")
};

form.btnEntrar.addEventListener('click', async (e) => {  
    e.preventDefault();

    var email = form.email.value;
    var senha = form.senha.value;

    if (!email || !senha) {
        mostrarAlerta("Informe usuário e senha, os campos não podem ser brancos.");
        return;
    }

    try {
        const usuario = await buscarUsuarioPorEmail(email); 
        
        if (!usuario) {
            mostrarAlerta("Usuário não encontrado.");
            return;
        }
        
        console.log('Usuário encontrado:', usuario);
       
        if (email.toLowerCase() !== usuario.email.toLowerCase() ||     
            senha !== usuario.senha) {
            mostrarAlerta("E-mail ou senha inválidos");
            return;
        }
        

        efetuarLogin();
    } catch (error) {
        console.error('Erro ao buscar usuário:', error);
        mostrarAlerta("Erro ao buscar usuário: " + error.message);
    }
});

function efetuarLogin() {
    window.open(`produtos.html?teste=123`, '_self');
}

function buscarUsuarioPorEmail(email) {
    return fetch('http://fabiojcb.atwebpages.com/api/rotas.php/usuarios', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ email: email }) 
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erro na requisição à API');
        }
        return response.json();
    })
    .then(data => {
        if (!data) {
            throw new Error('Dados do usuário não encontrados');
        }

        const usuario = new Usuario(data);
        return usuario;
        if (usuario.modeloValido()) {
            return usuario;
        } else {
            throw new Error('Modelo de usuário inválido');
        }
    })
    .catch(error => {
        console.error('Erro ao buscar usuário:', error);
        throw error;
    });
}
