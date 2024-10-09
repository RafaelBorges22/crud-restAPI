const app = Vue.createApp({
  data() {
    return {
      produtos: [],
      busca: '',
      produto: {
        id_produto: null,
        nome: '',
        preco: '',
        estoque: '',
        descricao:'',
      },
      editando: false,
      url: 'http://localhost:8080/users',
    };
  },

  computed: {
    ProdutosFiltrados() {
      if (!this.produtos || this.produtos.length === 0) {
        return [];
      }

      return this.produtos.filter(produto => {
        return produto.nome && produto.nome.toLowerCase().includes(this.busca.toLowerCase());
      });
    }
  },

  methods: {
    listarProdutos(){
      fetch(this.url)
      .then(response=>response.json())
      .then(data=>{
        this.produto = data;
      })
      .catch(error=>console.error('Erro ao listar Produto: '),error)
    },
    cadastrarProduto(){
      if (this.editando) {
        this.atualizarProduto();
      }else{
        this.criarProduto();
      }
    },

    criarProduto(){
      fetch(this.url,{
        method: 'POST',
        headers:{
          'Content-Type': 'aplication/json',
        },
        body: JSON.stringify(this.produto),
      })
        .then(response=>response.json())
        .then(data=>{
          this.produtos.push(data);
        })
        .catch(error=>console.error('Erro ao criar produto ', error));

    },

    editarProduto(Produto){
      this.produto = {...Produto};
      this.update = true;
    },
    atualizarProduto(){
      fetch(`${this.url}/${this.usuario.usuario_id}`,{
        method: 'PUT',
        headers: {
          'Content-Type': 'aplication/json',
        },
        body: JSON.stringify(this.produto),
      })

      .then(response=>response.json());
      .then(data=>{
        const index = this.produto.findIndex(u=>u.id_produto)
      })
  },
  }

})