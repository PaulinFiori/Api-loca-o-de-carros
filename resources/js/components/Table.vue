<template>
    {{ $store.state.count }}
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col" v-for="titulo, key in titulos" :key="key">
                    {{ titulo.titulo }}
                </th>
                <th v-if="canSeeOpcoes"></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="dado, chave in dadosFiltrados" :key="chave">
                <td v-for="(valor, chave) in dado" :key="chave">
                    <span v-if="chave == 'imagem'">
                        <img class="rounded-circle" :src="'storage/' + valor" style="width: 40px; heigth: 40px;">
                    </span>
                    <span v-else>{{ valor }}</span>
                </td>
                <td v-if="canSeeOpcoes">
                    <button class="btn btn-primary btn-sm" @click="setStore(dado), abrirModal('vizualizacaoMarcaModal')">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                    <button class="btn btn-success btn-sm mx-2" @click="setStore(dado), abrirModal('editarMarcaModal')">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                    <button class="btn btn-danger btn-sm" @click="remover(dado)">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </td>
            </tr>
            <!-- <tr v-for="dado in dados" :key="dado.id">
                <template v-for="(valor, chave) in dado" :key="chave">
                    <td v-if="titulos.includes(chave)">
                        <span v-if="chave == 'imagem'">
                            <img class="rounded-circle" :src="'storage/' + valor" style="width: 40px; heigth: 40px;">
                        </span>
                        <span v-else>{{ valor }}</span>
                    </td>
                </template>
            </tr> -->
        </tbody>
    </table>
</template>

<script>
    export default {
        props: [
            'dados',
            'titulos',
            'canSeeOpcoes',
            'url'
        ],
        methods: {
            abrirModal(id) {
                let modal = "#" + id;
                $(modal).modal('show');
            },
            fecharModal(id) {
                let modal = "#" + id;
                $(modal).modal('hide');
            },
            setStore(dado) {
                this.$store.state.item = dado;
            },
            remover(dado) {
                let confirmacao = confirm("Tem certeza que deseja remover " + dado.nome + "?");

                if(!confirmacao) return false;

                let urlRemocao = this.url + '/' + dado.id;

                let formData = new FormData();
                formData.append("_method", "delete");

                axios.post(urlRemocao, formData)
                    .then(response => {
                        window.location.reload();
                    })
                    .catch(errors => {
                        console.log(errors);
                    })
            }
        },
        computed: {
            dadosFiltrados() {
                let campos = Object.keys(this.titulos);
                let dadosFiltrados = [];

                this.dados.map((key, chave) => {
                    let itemFiltrado = {};

                    campos.forEach(campo => {
                        itemFiltrado[campo] = key[campo];
                    });

                    dadosFiltrados.push(itemFiltrado);
                });

                return dadosFiltrados;
            }
        },
        mounted() {
            console.log('Tabela Montado.')
        }
    }
</script>
