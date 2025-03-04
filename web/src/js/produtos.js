var btnAdicionar = document.getElementById("btn-adicionar");
var tabela = document.querySelector('table>tbody');

var modal = {
    codigo: document.getElementById('codigo'),
    nome: document.getElementById('nome'),
    quantidade: document.getElementById('quantidade'),
    valor: document.getElementById('valor'),
    dataCadastro: document.getElementById('data'),
    btnSalvar: document.getElementById('btn-salvar'),
    btnSair: document.getElementById('btn-sair')
};

btnAdicionar.addEventListener('click', (e) =>{
    e.preventDefault();
    abrirModalProdutos();
});

modal.btnSalvar.addEventListener('click', (e) =>{
    e.preventDefault();
    cadastro();
    limparCampos();
    fecharModalProdutos();
    buscarProdutos();  
});

modal.btnSair.addEventListener('click', (e) =>{
    e.preventDefault();
    limparCampos();
    fecharModalProdutos();
});

function abrirModalProdutos(){
    $("#btn-adicionar").click(function(){
        $("#cadastro-produto").modal({backdrop: "static"});
    });
}

function fecharModalProdutos(){
    $("#btn-sair").click(function(){
        $("#cadastro-produto").modal("hide");
    });
}

function limparCampos(){
    modal.codigo.value = "";
    modal.nome.value = "";
    modal.quantidade.value = "";
    modal.valor.value = "";
    modal.dataCadastro.value = "";

   // esconderAlerta();
}

document.addEventListener('DOMContentLoaded', function() {
    const tabelaProdutos = document.querySelector('table tbody');
    const mensagemErro = document.querySelector('.alert-danger');

    // Função para buscar todos os produtos
    async function buscarProdutos() {
        try {
            const response = await fetch('http://fabiojcb.atwebpages.com/projeto-qa/api/v1/products', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error('Erro ao buscar produtos');
            }

            const produtos = await response.json();
            exibirProdutos(produtos.data);
        } catch (error) {
            mostrarErro('Erro ao tentar buscar produtos. Tente novamente mais tarde.');
        }
    }

    // Função para exibir os produtos na tabela
    function exibirProdutos(produtos) {
        tabelaProdutos.innerHTML = '';
        produtos.forEach(produto => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${produto.codProduto}</td>
                <td>${produto.nmProduto}</td>
                <td>${produto.qtProduto}</td>
                <td>${produto.vlProduto}</td>
                <td>${produto.dtProduto}</td>
                <td>
                    <button class="btn btn-sm btn-primary btn-editar" data-id="${produto.codProduto}">Editar</button>
                    <button class="btn btn-sm btn-danger btn-excluir" data-id="${produto.codProduto}">Excluir</button>
                </td>
            `;
            tabelaProdutos.appendChild(row);
        });
    }

    // Função para mostrar mensagens de erro
    function mostrarErro(mensagem) {
        mensagemErro.classList.remove('esconder');
        document.getElementById('mensagem').textContent = mensagem;
    }

    // Buscar produtos ao carregar a página
    buscarProdutos();
});

async function cadastro(){
    try {
        const data = {
            codProduto: modal.codigo.value,
            nmProduto: modal.nome.value,
            qtProduto: modal.quantidade.value,
            vlProduto: modal.valor.value,
            dtProduto: modal.dataCadastro.value
        };
        const response = await cadastroProduto(data);
        if (!response) {
            showError(response.message);     
        } 
    } catch (error) {
        showError('Erro ao tentar fazer login. Tente novamente mais tarde.');
    }
}

async function cadastroProduto(data) {
    const response = await fetch('http://fabiojcb.atwebpages.com/projeto-qa/api/v1/products', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    });

    if (!response.ok) {
        throw new Error('Network response was not ok');
    }

    return response.json();
}