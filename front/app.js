const app = Vue.createApp({
  data() {
    return {
      produtos: [],
      produto: {
        id_produto: null,
        nome: '',
        preco: '',
        estoque: '',
        descricao: '',
      },
      editando: false,
      url: 'http://localhost:8080/users', // URL fictícia para exemplos
    };
  },

  methods: {
    listarProdutos() {
      this.produtos = [
      ];
    },

    cadastrarProduto() {
      if (this.editando) {
        this.atualizarProduto();
      } else {
        this.criarProduto();
      }
    },

    criarProduto() {
      const novoProduto = { ...this.produto, id_produto: Date.now() };
      this.produtos.push(novoProduto);
      this.resetForm();
    },

    editarProduto(produto) {
      this.produto = { ...produto };
      this.editando = true;
    },

    atualizarProduto() {
      const index = this.produtos.findIndex(p => p.id_produto === this.produto.id_produto);
      this.produtos.splice(index, 1, { ...this.produto });
      this.resetForm();
    },

    deletarProduto(produto) {
      this.produtos = this.produtos.filter(p => p.id_produto !== produto.id_produto);
    },

    resetForm() {
      this.produto = { id_produto: null, nome: '', preco: '', estoque: '', descricao: '' };
      this.editando = false;
    }
  },

  mounted() {
    this.listarProdutos();
  },


  template: `
   <form @submit.prevent="cadastrarProduto" @reset="resetForm">
      <div>
        <label for="nome">Nome:</label>
        <input type="text" id="nome" v-model="produto.nome" required>
      </div>

      <div>
        <label for="preco">Preço:</label>
        <input type="number" id="preco" v-model="produto.preco" required>
      </div>

      <div>
        <label for="estoque">Estoque:</label>
        <input type="number" id="estoque" v-model="produto.estoque" required>
      </div>

      <div>
        <label for="descricao">Descrição:</label>
        <textarea id="descricao" v-model="produto.descricao" required></textarea>
      </div>

      <button type="submit">{{ editando ? 'Atualizar Produto' : 'Adicionar Produto' }}</button>
      <button type="reset">Limpar</button>
    </form>
    
    <ul>
      <li v-for="produto in produtos" :key="produto.produtoId">
        <strong>{{ produto.nome }}</strong>
        Preço: {{ produto.preco }}R$
        Estoque: {{ produto.estoque }}
        Descrição: {{produto.descricao}}

        <button @click="editarProduto(produto)">Editar</button>
        <button @click="deletarProduto(produto)">Deletar</button>
      </li>
    </ul>
  `
});


app.mount('#app');
