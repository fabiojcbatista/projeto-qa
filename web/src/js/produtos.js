var btnAdicionar = document.getElementById("btn-adicionar");
var tabela = document.querySelector('table>tbody');
const tabelaProdutos = document.querySelector('table tbody');
const mensagemErro = document.querySelector('.alert-danger');
const mensagemSucesso = document.querySelector('.alert-success');

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

        // Adicionar evento de clique aos botões de edição
        const botoesEditar = document.querySelectorAll('.btn-editar');
        botoesEditar.forEach(botao => {
            botao.addEventListener('click', async function() {
                const produtoId = this.getAttribute('data-id');
                const produto = await buscarProdutoPorId(produtoId);
                preencherModal(produto.data[0]);
                abrirModalProdutos();
            });
        });

 // Adicionar evento de clique aos botões de exclusão
 const botoesExcluir = document.querySelectorAll('.btn-excluir');
 botoesExcluir.forEach(botao => {
     botao.addEventListener('click', async function() {
         const produtoId = this.getAttribute('data-id');
         await excluirProduto(produtoId);
         await buscarProdutos();
         mostrarSucesso('Produto excluído com sucesso');
     });
 });
}

// Função para buscar um produto por ID
async function buscarProdutoPorId(produtoId) {
    try {
        const response = await fetch(`http://fabiojcb.atwebpages.com/projeto-qa/api/v1/products/${produtoId}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        });

        if (!response.ok) {
            throw new Error('Erro ao buscar produto');
        }

        return response.json();
    } catch (error) {
        mostrarErro('Erro ao tentar buscar o produto. Tente novamente mais tarde.');
    }
}

// Função para preencher o modal com os dados do produto
function preencherModal(produto) {
    modal.codigo.value = produto.codProduto;
    modal.nome.value = produto.nmProduto;
    modal.quantidade.value = produto.qtProduto;
    modal.valor.value = produto.vlProduto;
    modal.dataCadastro.value = produto.dtProduto;
}

// Função para mostrar mensagens de erro
function mostrarErro(mensagem) {
    mensagemErro.classList.remove('esconder');
    mensagemErro.textContent = mensagem;
}

// Função para mostrar mensagens de sucesso
function mostrarSucesso(mensagem) {
    mensagemSucesso.classList.remove('esconder');
    mensagemSucesso.textContent = mensagem;
}

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

modal.btnSalvar.addEventListener('click', async (e) =>{
    e.preventDefault();
    if (modal.codigo.value) {
        await atualizarProduto();
    } else {
        await cadastro();
    }
    limparCampos();
    fecharModalProdutos();
    await buscarProdutos();
    mostrarSucesso('Operação realizada com sucesso');
});

modal.btnSair.addEventListener('click', (e) =>{
    e.preventDefault();
    limparCampos();
    fecharModalProdutos();
});

function abrirModalProdutos(){
    $("#cadastro-produto").modal({backdrop: "static"});
}

function fecharModalProdutos(){
    $("#cadastro-produto").modal("hide");
}

function limparCampos(){
    modal.codigo.value = "";
    modal.nome.value = "";
    modal.quantidade.value = "";
    modal.valor.value = "";
    modal.dataCadastro.value = "";

   // esconderAlerta();
}

document.addEventListener('DOMContentLoaded', async function() {
    // Buscar produtos ao carregar a página
    await buscarProdutos();
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

// Função para excluir um produto
async function excluirProduto(produtoId) {
    try {
        const response = await fetch(`http://fabiojcb.atwebpages.com/projeto-qa/api/v1/products/${produtoId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            }
        });

        if (!response.ok) {
            throw new Error('Erro ao excluir produto');
        }

        return response.json();
    } catch (error) {
        mostrarErro('Erro ao tentar excluir o produto. Tente novamente mais tarde.');
    }
}

// Função para atualizar um produto
async function atualizarProduto() {
    try {
        const data = {
            codProduto: modal.codigo.value,
            nmProduto: modal.nome.value,
            qtProduto: modal.quantidade.value,
            vlProduto: modal.valor.value,
            dtProduto: modal.dataCadastro.value
        };
        const response = await atualizarProdutoAPI(data);
        if (!response) {
            mostrarErro(response.message);     
        } 
    } catch (error) {
        mostrarErro('Erro ao tentar atualizar o produto. Tente novamente mais tarde.');
    }
}

async function atualizarProdutoAPI(data) {
    const response = await fetch(`http://fabiojcb.atwebpages.com/projeto-qa/api/v1/products/${data.codProduto}`, {
        method: 'PUT',
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