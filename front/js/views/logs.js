export const Logs = {
  data() {
    return {
      logs: [],
      apiURL: 'http://localhost:8080', 
    };
  },
  inject: ['baseURL'],
  methods: {
    async listarLogs(){
      const responseLogs = await fetch(`${this.apiURL}/logs`);
      const data = await responseLogs.json();

      this.logs = data;
    },
  },
  mounted() {
    this.listarLogs().then();
  },
  template: `
    <ul>
      <li v-for="log in logs" :key="log.id">
        <strong>{{ log.acao }}</strong>
        data_hora: {{ log.data_hora }}
        produto_id: {{ log.produto_id }}
        user_insert: {{log.user_insert}}
      </li>
    </ul>
  `
};