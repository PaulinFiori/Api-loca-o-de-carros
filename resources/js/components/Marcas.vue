<template>
    <div class="container">
        <div class="row justify-content-center">
            <card-component titulo="Marcas">
                <template v-slot:conteudo>
                    <input-container-component>
                        <label for="inputId">ID</label>
                        <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="Entre com o id" v-model="busca.id">
                    </input-container-component>

                    <input-container-component>
                        <label for="inputNome">Nome</label>
                        <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp" placeholder="Entre com o nome" v-model="busca.nome">
                    </input-container-component>
                </template>
                <template v-slot:rodape>
                    <button type="submit" class="btn btn-primary btn-sm float-right" @click="pesquisar()">Pesquisar</button>
                </template>
            </card-component>
            

            <card-component titulo="Relação de marcas">
                <template v-slot:conteudo>
                    <table-component :titulos="{
                        id : {titulo: 'ID', tipo: 'text'}, 
                        imagem: {titulo: '', tipo: 'imagem'}, 
                        nome: {titulo: 'Nome', tipo: 'text'}
                    }" :dados="marcas.data" :canSeeOpcoes="true" :url="urlMarca"></table-component>

                </template>
                <template v-slot:rodape>
                    <div class="row">
                        <div class="col-10">
                            <paginate-component>
                                <li class="page-item" v-for="dado, chave in marcas.links" :key="chave" @click="paginacao(dado)">
                                    <a :class="dado.active ? 'page-link active' : 'page-link' " v-html="dado.label"></a>
                                </li>
                            </paginate-component>
                        </div>
                        <div class="col-2">
                            <button type="button" class="btn btn-success btn-sm float-right ml-3" @click="abrirModal('adicionarMarcaModal')">Adicionar</button>
                        </div>
                    </div>
                </template>
            </card-component>
        </div>

        <!-- Adicionar Marca -->
        <modal-component id="adicionarMarcaModal">
            <template v-slot:cabecalho>
                <h5 class="modal-title" id="exampleModalLabel">Adicionar Marca</h5>
                    <button type="button" class="close" aria-label="Close" @click="fecharModal('vizualizacaoMarcaModal')">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </template>
            <template v-slot:conteudo>
                <alert-component tipo="alert alert-success" :mensagem="mensagemAlert" v-if="marcaAdicionada == 'success'"></alert-component>
                <alert-component tipo="alert alert-danger" :mensagem="mensagemAlert" v-if="marcaAdicionada == 'error' "></alert-component>
                <label for="nomeInput">Nome</label>
                <input type="text" class="form-control" id="nomeInput" aria-describedby="nomeHelp" placeholder="Entre com o nome" v-model="nomeMarca">

                <label for="fileInput mt-3">Foto</label>
                <input type="file" class="form-control-file mt-3" id="fileInput" aria-describedby="fileHelp" placeholder="Selecione uma imagem" @change="carregarImagem($event)">
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" @click="fecharModal('adicionarMarcaModal')">Fechar</button>
                <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
            </template>
        </modal-component>

        <!-- Vizualizar Marca -->
        <modal-component id="vizualizacaoMarcaModal">
            <template v-slot:cabecalho>
                <h5 class="modal-title" id="exampleModalLabel">Marca</h5>
                    <button type="button" class="close" aria-label="Close" @click="fecharModal('vizualizacaoMarcaModal')">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </template>
            <template v-slot:conteudo>
                <p>ID</p>
                <p>{{ $store.state.item.id }}</p>
                <p>Nome</p>
                <p>{{ $store.state.item.nome }}</p>
                <p>Imagem</p>
                <img class="rounded-circle" :src="'storage/' + $store.state.item.imagem" style="width: 40px; heigth: 40px;" v-if="$store.state.item.imagem">
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" @click="fecharModal('vizualizacaoMarcaModal')">Fechar</button>
            </template>
        </modal-component>

        <!-- Editar Marca -->
        <modal-component id="editarMarcaModal">
            <template v-slot:cabecalho>
                <h5 class="modal-title" id="exampleModalLabel">Atualizar Marca</h5>
                    <button type="button" class="close" aria-label="Close" @click="fecharModal('vizualizacaoMarcaModal')">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </template>
            <template v-slot:conteudo>
                <input-container-component>
                    <input type="hidden" class="form-control" id="inputIdAtualizacao" aria-describedby="idHelp" placeholder="Entre com o id" v-model="$store.state.item.id" disabled>
                </input-container-component>
                <input-container-component>
                    <label for="inputNome">Nome</label>
                    <input type="text" class="form-control" id="inputNomeAtualizacao" aria-describedby="nomeHelp" placeholder="Entre com o nome" v-model="$store.state.item.nome">
                </input-container-component>

                <input-container-component>
                    <label for="fileInput mt-3">Foto</label>
                    <input type="file" class="form-control form-control-file mt-3" id="fileInput" aria-describedby="fileHelp" placeholder="Selecione uma imagem" @change="carregarImagem($event)">
                </input-container-component>
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-success" @click="atualizar()">Atualizar</button>
                <button type="button" class="btn btn-secondary" @click="fecharModal('editarMarcaModal')">Fechar</button>
            </template>
        </modal-component>
    </div>
</template>

<script>
    export default {
        props: [
        ],
        data() {
            return {
                urlMarca: 'http://127.0.0.1:8000/api/marca',
                nomeMarca: '',
                arquivoImagemMarca: [],
                marcaAdicionada: '',
                mensagemAlert: '',
                marcas: { data: [] },
                busca: { id: '', nome: '' },
                urlFiltro: '',
                urlPaginacao: '?page=1'
            }
        },
        methods: {
            abrirModal(id) {
                let modal = "#" + id;
                $(modal).modal('show');
            },
            fecharModal(id) {
                let modal = "#" + id;
                $(modal).modal('hide');
            },
            carregarImagem(e) {
                this.arquivoImagemMarca = e.target.files;
            },
            salvar() {
                let formData = new FormData();

                formData.append('nome', this.nomeMarca);
                formData.append('imagem', this.arquivoImagemMarca[0]);

                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }

                axios.post(this.urlMarca, formData, config)
                .then(response => {
                    this.marcaAdicionada = "success";
                    this.mensagemAlert = 'Marca Adicionado com sucesso.';
                })
                .catch(errors => {
                    this.marcaAdicionada = "error";
                    this.mensagemAlert = 'Erro ' + errors.response.status + ' - ' + errors.response.data.message + '.';
                });
            },
            carregarLista() {
                let url = this.urlMarca + this.urlPaginacao + this.urlFiltro;
                axios.get(url)
                .then(response => {
                    this.marcas = response.data;

                    this.mensagemAlert = 'Marcas carregadas com sucesso.';
                    console.log(this.mensagemAlert);
                })
                .catch(errors => {
                    this.mensagemAlert = 'Erro ' + errors.response.status + ' - ' + errors.response.data.message + '.';
                    console.log(this.mensagemAlert);
                });
            },
            paginacao(dado) {
                if(dado.url) this.urlPaginacao = dado.url.substring(dado.url.indexOf("?"), dado.url.length);

                this.carregarLista();
            },
            pesquisar() {
                let filtro = '';

                for(let chave in this.busca) {
                    if(this.busca[chave]) {
                        if(chave == 'nome') {
                            filtro += chave + ':like:' + this.busca[chave];
                        } else {
                            filtro += chave + ":=:" + this.busca[chave] + ",";
                        }
                    }
                }

                if(filtro != '') this.urlFiltro = '&filtro=' + filtro;
                this.carregarLista();
            },
            atualizar() {
                let confirmacao = confirm("Tem certeza que deseja atualizar " + this.$store.state.item.nome + "?");

                if(!confirmacao) return false;

                let urlRemocao = this.urlMarca + '/' + this.$store.state.item.id;

                let formData = new FormData();
                formData.append("_method", "PATCH");
                formData.append("nome", $("#inputNomeAtualizacao").val());

                if(this.arquivoImagemMarca[0]) {
                    formData.append('imagem', this.arquivoImagemMarca[0]);
                }

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
        },
        mounted() {
            console.log('Tela marca Montado.');
            this.carregarLista();
        }
    }
</script>