class Usuario {
    constructor(obj) {
        obj = obj || {};
        this.id = obj.id;
        this.nome = obj.nome;
        this.email = obj.email;
        this.senha = obj.senha;
        this.nivel = obj.nivel;
    }

    modeloValido() {
        return !!(this.id && this.nome && this.email && this.senha && this.nivel);
    }
}