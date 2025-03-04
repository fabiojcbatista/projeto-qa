class Produto {
    constructor(obj){
        obj = obj || {};
        this.id = obj.id
        this.codProduto = obj.codProduto;
        this.nmProduto = obj.nmProduto;
        this.qtProduto = obj.qtProduto;
        this.vlProduto = obj.vlProduto;
        this.dtProduto = obj.dtProduto;
    }

    modeloValido(){
        return !!(this.codProduto && this.nmProduto && this.qtProduto && this.vlProduto && this.dtProduto);
    }
}