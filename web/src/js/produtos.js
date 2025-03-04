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

// Função para buscar produtos da API e adicionar à tabela
function buscarProdutos() {
    fetch('http://fabiojcb.atwebpages.com/api/rotas.php/produtos') // Substitua pela URL correta da sua API
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro na requisição à API');
            }
            return response.json(); // Converte a resposta em JSON
        })
        .then(data => {
            data.forEach(produto => adicionarProdutoNaTabela(produto));
        })
        .catch(error => console.error('Erro ao buscar produtos:', error));
}

btnAdicionar.addEventListener('click', (e) =>{
    e.preventDefault();
    abrirModalProdutos();
});

modal.btnSalvar.addEventListener('click', (e) =>{
    e.preventDefault();
    let produto = criarProduto();

    if(!produto.modeloValido()){
        mostrarAlerta("Todos os campos são obrigatórios para o cadastro!");
        return;
    }

    //adicionarProdutoNaTabela(produto);
    buscarProdutos();
    limparCampos();
    fecharModalProdutos();
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

function criarProduto(){
    return new Produto({
        codProduto: modal.codigo.value,
        nmProduto: modal.nome.value,
        qtProduto: modal.quantidade.value,
        vlProduto: modal.valor.value, 
        dtProduto: modal.dataCadastro.value,
    });
}

function limparCampos(){
    modal.codigo.value = "";
    modal.nome.value = "";
    modal.quantidade.value = "";
    modal.valor.value = "";
    modal.dataCadastro.value = "";

    esconderAlerta();
}

function adicionarProdutoNaTabela(produto){
    var tr = document.createElement('tr');
    var tdCodigo = document.createElement('td');
    var tdNome = document.createElement('td');
    var tdQuantidade = document.createElement('td');
    var tdValor = document.createElement('td');
    var tdDataCadastro = document.createElement('td');
    var tdAcoes = document.createElement('td');

    // Assumindo que a API retorna os dados com essas chaves
    tdCodigo.textContent = produto.codProduto;
    tdNome.textContent = produto.nmProduto;
    tdQuantidade.textContent = produto.qtProduto;
    tdValor.textContent = produto.vlProduto;
    tdDataCadastro.textContent = produto.dtProduto;
    tdAcoes.innerHTML = `<button type="button" class="btn btn-link">Editar</button> / <button type="button" class="btn btn-link">Excluir</button>`

    tr.appendChild(tdCodigo);
    tr.appendChild(tdNome);
    tr.appendChild(tdQuantidade);
    tr.appendChild(tdValor);
    tr.appendChild(tdDataCadastro);
    tr.appendChild(tdAcoes);

    tabela.appendChild(tr);
}

// Chama a função para buscar produtos ao carregar a página
document.addEventListener('DOMContentLoaded', buscarProdutos);
