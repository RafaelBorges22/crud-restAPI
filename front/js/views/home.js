export const Home = {
  data() {
    return {
      produtos: [],
      produto: {
        id: null,
        nome: '',
        preco: '',
        estoque: '',
        descricao: '',
        user_insert:'',
      },
      editando: false,
      apiURL: 'http://localhost:8080', 
    };
  },
  inject: ['baseURL'],
  methods: {
    async listarProdutos() {
      const response = await fetch(this.apiURL.concat('/produtos'));
      const data = await response.json();

      this.produtos = data;
    },

    async cadastrarProduto() {
      if (this.editando) {
        this.atualizarProduto();
      } else {
        await this.criarProduto();
      }
    },

    async criarProduto() {
      const responseGet = await fetch(this.apiURL.concat('/produtos'), {
        method: 'POST',
        headers: {
          "Content-Type": 'application/json',
        },
        body: JSON.stringify({ ...this.produto })
      });

      if (responseGet.status === 201) {
        this.resetForm();
        alert("Produto criado com sucesso!");
        await this.listarProdutos();
      }

    },

    editarProduto(produto) {
      this.produto = { ...produto };
      this.editando = true;
    },

    async atualizarProduto() {
      // const index = this.produtos.findIndex(p => p.id === this.produto.id);
      // this.produtos.splice(index, 1, { ...this.produto });

      const responsePut = await fetch(`${this.apiURL}/produtos/${this.produto.id}`,{
        method: 'PUT',
        headers:{
          "Content-Type": "aplication/json",
        },
        body: JSON.stringify({...this.produto}),
      });

      if (responsePut.status === 201) {
        this.resetForm();
        alert("Produto editado com sucesso")
        await this.listarProdutos()
      }
    },

    async deletarProduto(produto) {
      const isOperationConfirmed = confirm("Deseja excluir este produto?");

      if (isOperationConfirmed) {
          const responseDel = await fetch(`${this.apiURL}/produtos/${produto.id}`, {
            method: 'DELETE',
            headers: {
              "Content-Type": "aplication/json",
            },
          });
    
          if (responseDel.status === 200) {
            this.resetForm();
            await this.listarProdutos();
          }

      }
    },

    resetForm() {
      this.produto = { id: null, nome: '', preco: '', estoque: '', descricao: '' };
      this.editando = false;
    }
  },

  mounted() {
    this.listarProdutos().then();
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
        <label for="estoque">Usuário:</label>
        <input type="text" id="user_insert" v-model="produto.user_insert" required>
      </div>

      <div>
        <label for="descricao">Descrição:</label>
        <textarea id="descricao" v-model="produto.descricao" required></textarea>
      </div>

      <button type="submit">{{ editando ? 'Atualizar Produto' : 'Adicionar Produto' }}</button>
      <button type="reset">Limpar</button>
    </form>

    <br />
    
    <ul>
      <li v-for="produto in produtos" :key="produto.produtoId">
        <strong>{{ produto.nome }}</strong>
        Preço: {{ produto.preco }}R$
        Estoque: {{ produto.estoque }}
        Descrição: {{produto.descricao}}

        <button @click="editarProduto(produto)">Editar</button>
        <button @click="deletarProduto(produto)">Excluir</button>
      </li>
    </ul>
  `
};