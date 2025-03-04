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