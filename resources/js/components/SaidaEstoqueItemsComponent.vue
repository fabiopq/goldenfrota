<template>
    <div class="form-group">
        <div class="row">
            <input type="hidden" name="estoque_id" v-model="estoque_id">
            <input type="hidden" name="valor_total" v-model="valor_total">
            <div v-bind:class="{'col-md-7': true, ' has-error': this.errors.estoqueId}">
                <label for="estoqueId" class="control-label">Estoque</label>
                <select ref="estoqueId" v-model="estoqueId" data-live-search="true" data-title="Nada Selecionado" data-style="btn-secondary" class="form-control selectpicker mb-3" name="estoqueId" id="estoqueId" :disabled="produtosSelecionados.length > 0">
                    <!-- <option value="" disabled> Nada Selecionado </option> -->
                    <option v-for="(estoque, index) in this.estoques" :value="estoque.id" :key="index">{{ estoque.id + ' - ' + estoque.estoque }}</option>
                </select>
                <span class="help-block" :v-if="this.errors.estoqueId">
                    <strong>{{ this.errors.estoqueIdMsg }}</strong>
                </span>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <strong>Produtos</strong>
            </div>
            <div class="card-body" style="padding: 0 !important;">
                <table class="table table-sm table-striped table-bordered table-hover" style="margin-bottom:0 !important;">
                    <thead class="thead-light">
                        <tr class="row m-0">
                            <th class="col-md-1">Id</th>
                            <th class="col-md-6">Produto</th>
                            <th class="col-md-1">Quantidade</th>
                            <th class="col-md-1">Vlr. Un.</th>
                            <th class="col-md-1">Vlr. Desc.</th>
                            <th class="col-md-1">Vlr. Acres.</th>
                            <th class="col-md-1">Ações</th>
                        </tr>
                    </thead>
                    <tbody name="fade" is="transition-group">
                        <tr class="row m-0" v-for="(item, index) in items" :key="index">
                            <td class="col-md-1 pool-right">
                                {{ item.id }}
                                <input type="hidden" :name="'items['+index+'][produto_id]'" :value="item.id">
                            </td>
                            <td class="col-md-6">
                                {{ item.produto_descricao }}
                            </td>
                            <td class="col-md-1 text-right">
                                {{ item.quantidade }}
                                <input type="hidden" :name="'items['+index+'][quantidade]'" :value="item.quantidade">    
                            </td>
                            <td class="col-md-1 text-right">
                                {{ item.valor_unitario }}
                                <input type="hidden" :name="'items['+index+'][valor_unitario]'" :value="item.valor_unitario">    
                            </td>
                            <td class="col-md-1 text-right">
                                {{ item.valor_desconto }}
                                <input type="hidden" :name="'items['+index+'][valor_desconto]'" :value="item.valor_desconto">    
                            </td>
                            <td class="col-md-1 text-right">
                                {{ item.valor_acrescimo }}
                                <input type="hidden" :name="'items['+index+'][valor_acrescimo]'" :value="item.valor_acrescimo">    
                            </td>
                            <td class="col-md-1">
                                <button type="button" class="btn-xs btn-warning" @click="editItem(index)" v-show="!editing">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn-xs btn-danger" @click="confirmDelete(index)" data-toggle="modal" data-target="#confirmDelete" v-show="!editing">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot v-if="this.items.length > 0">
                        <tr class="row m-0">
                            <td class="col-md-1"><strong>{{ this.items.length }}</strong></td>
                            <td class="col-md-6"></td>
                            <td class="col-md-1 text-right"><strong>{{ this.totalQuantidade() }}</strong></td>
                            <td class="col-md-1 text-right"><strong>{{ this.totalValor() }}</strong></td>
                            <td class="col-md-1 text-right"><strong>{{ this.totalDesconto() }}</strong></td>
                            <td class="col-md-1 text-right"><strong>{{ this.totalAcrescimo() }}</strong></td>
                            <td class="col-md-1"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div>
                <div class="row m-0">
                    <div v-bind:class="{'col-md-7': true, ' has-error': this.errors.inputProdutos}" style="padding-right: 0 !important; padding-left: 0 !important;">
                        <!-- <select ref="estoqueId" v-model="estoqueId" data-live-search="true" data-title="Nada Selecionado" data-style="btn-secondary" class="form-control selectpicker mb-3" name="estoqueId" id="estoqueId" :disabled="produtosSelecionados.length > 0"> -->
                        <!-- <select :disabled="((estoqueId == 'false') || (estoqueId == null))" ref="inputProdutos" data-title="Nada selecionado" v-model="produto_id" data-live-search="true" data-style="btn-secondary" class="form-control selectpicker" name="inputProdutos" id="inputProdutos"> -->
                            <!-- <option selected value=""> Nada Selecionado </option> -->
                            <!-- <option v-for="(produto, index) in produtosDisponiveisOrdenados" :value="produto.id" :key="index">{{ produto.id + ' - ' +produto.produto_descricao }}</option>
                        </select>
                        <span class="help-block" :v-if="this.errors.inputProdutos">
                            <strong>{{ this.errors.inputProdutosMsg }}</strong>
                        </span> -->

                        <!-- <select :disabled="((estoqueId == 'false') || (estoqueId == null))" data-title="Nada selecionado" ref="inputProdutos" data-style="btn-secondary" v-model="produto_id" data-live-search="true" class="form-control selectpicker" name="inputProdutos" id="inputProdutos">
                            <option v-for="(produto, index) in produtosDisponiveisOrdenados" :value="produto.id" :key="index">{{ produto.id + ' - ' +produto.produto_descricao }}</option>
                        </select>
                        <span class="help-block" :v-if="this.errors.inputProdutos">
                            <strong>{{ this.errors.inputProdutosMsg }}</strong>
                        </span> -->

                        <select :disabled="((estoqueId == 'false') || (estoqueId == null))" ref="inputProdutos" data-style="btn-secondary" v-model="produto_id" data-live-search="true" class="form-control selectpicker" name="inputProdutos" id="inputProdutos">
                            <option selected value="false"> Nada Selecionado </option>
                            <option v-for="(produto, index) in produtosDisponiveisOrdenados" :value="produto.id" :key="index">{{ produto.id + ' - ' + produto.produto_descricao }}</option>
                        </select>
                        <span class="help-block" :v-if="this.errors.inputProdutos">
                            <strong>{{ this.errors.inputProdutosMsg }}</strong>
                        </span>
                    </div>
                    <div v-bind:class="{'col-md-1': true, ' has-error': this.errors.inputQuantidade}" style="padding-right: 0 !important; padding-left: 0 !important;">
                        <input :disabled="((estoqueId == 'false') || (estoqueId == null))" type="number" min="0,000" max="9999999999,999" step="any" ref="inputQuantidade" v-model.number="quantidade" class="form-control" name="inputQuantidade" id="inputQuantidade">
                        <span class="help-block" :v-if="this.errors.inputQuantidade">
                            <strong>{{ this.errors.inputQuantidadeMsg }}</strong>
                        </span>
                    </div>
                    <div v-bind:class="{'col-md-1': true, ' has-error': this.errors.inputValorUnitario}" style="padding-right: 0 !important; padding-left: 0 !important;">
                        <input :disabled="((estoqueId == 'false') || (estoqueId == null))" type="number" min="0,000" max="9999999999,999" step="any" ref="inputValorUnitario" v-model.number="valorUnitario" class="form-control" name="inputValorUnitario" id="inputValorUnitario">
                        <span class="help-block" :v-if="this.errors.inputValorUnitario">
                            <strong>{{ this.errors.inputValorUnitarioMsg }}</strong>
                        </span>
                    </div>
                    <div v-bind:class="{'col-md-1': true, ' has-error': this.errors.inputDesconto}" style="padding-right: 0 !important; padding-left: 0 !important;">
                        <input :disabled="((estoqueId == 'false') || (estoqueId == null))" type="number" min="0,000" max="9999999999,999" step="any" ref="inputDesconto" v-model.number="desconto" class="form-control" name="inputDesconto" id="inputDesconto">
                        <span class="help-block" :v-if="this.errors.inputDesconto">
                            <strong>{{ this.errors.inputDescontoMsg }}</strong>
                        </span>
                    </div>
                    <div v-bind:class="{'col-md-1': true, ' has-error': this.errors.inputAcrescimo}" style="padding-right: 0 !important; padding-left: 0 !important;">
                        <input :disabled="((estoqueId == 'false') || (estoqueId == null))" type="number" min="0,000" max="9999999999,999" step="any" ref="inputAcrescimo" v-model.number="acrescimo" class="form-control" name="inputAcrescimo" id="inputAcrescimo">
                        <span class="help-block" :v-if="this.errors.inputAcrescimo">
                            <strong>{{ this.errors.inputAcrescimoMsg }}</strong>
                        </span>
                    </div>
                    <div class="col-md-1">
                        <button :disabled="((estoqueId == 'false') || (estoqueId == null))" type="button" class="btn btn-success" @click="addProduto" v-show="!editing">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button :disabled="((estoqueId == 'false') || (estoqueId == null))" type="button" class="btn btn-success" @click="updateProduto" v-show="editing">
                            <i class="fas fa-check"></i>
                        </button>
                    </div>
                </div>
            </div>
            <vue-modal @cancel="cancelDelete" @confirm="deleteItem" :modal-title="'Corfirmação'" :modal-text="'Confirma a remoção deste Item?'" />
        </div>
    </div>
</template>

<script>
    import modal from './modal.vue';

    export default {
        components: {
            'vue-modal': modal
        },
        props: [
            'oldData',
            'estoques',
            'oldEstoqueId',
            'estoqueError'
        ],
        data() {
            return {
                editing: false,
                editingIndex: false,
                items: [],
                quantidade: 1,
                desconto: 0,
                acrescimo: 0,
                valorUnitario: 0,
                isModalVisible: false,
                deleteIndex: false,
                produtosDisponiveis: [],
                produtosSelecionados: [],
                produtosData: [],
                loadOldDataFlag: true,
                errors: {
                    inputProdutos: false,
                    inputProdutosMsg: '',
                    inputQuantidade: false,
                    inputQuantidadeMsg: '',
                    inputValorUnitario: false,
                    inputValorUnitariodeMsg: '',
                    inputDesconto: false,
                    inputDescontoMsg: '',
                    inputAcrescimo: false,
                    inputAcrescimoMsg: '',
                    estoqueId: false,
                    estoqueIdMsg: ''
                },
                _produto_id: false,
                get produto_id() {
                    return this._produto_id;
                },
                set produto_id(value) {
                    this._produto_id = value;
                },
                _estoqueId: null,
                get estoqueId() {
                    return this._estoqueId;
                },
                set estoqueId(value) {                    
                    this._estoqueId = value;
                }
            }
        },
        watch: {
            oldData: function() {
               this.$refs.confirmDelete
            },
            estoqueId: function() {
                this.getProdutos();
            },
            produto_id: function() {
                if (!this.editing) {
                    //this.valor_unitario = this.getProdutoById(this.produto_id).valor_venda;
                    let prod = this.produtosData.find(p => p.id === this.produto_id);
                    if (prod != undefined) {
                        this.valorUnitario = prod.valor_venda;
                    }
                }
                //this.calcTotalProdutoItem();
            }/* ,
            produto_id: function() {
                let prod = this.produtosData.find(p => p.id === this.produto_id);
                if (prod != undefined) {
                    this.valorUnitario = prod.valor_venda;
                }
            } */
        },
        computed: {
            estoque_id: {
                get() {
                    return this.estoqueId;
                },
                set(value) {
                    this.estoqueId = value;
                }
            },
            valor_total: {
                get() {
                    let total = 0;
                    for (var i = 0; i < this.items.length; i++) {
                        total += this.items[i].quantidade * this.items[i].valor_unitario;
                    }
                    return total;
                }
            },
            /* valorUnitario: {
                get() {
                    return this.getProdutoById(this.produto_id).valor_venda;
                }
            }, */
            produtosDisponiveisOrdenados: function() {
                function compare(a, b) {
                    if (a.produto_descricao < b.produto_descricao)
                    return -1;
                    if (a.produto_descricao > b.produto_descricao)
                    return 1;
                    return 0;
                }

                return this.produtosDisponiveis.sort(compare);
            }
        },
        mounted() {
            if (this.oldEstoqueId !== null) {
                this.estoqueId = this.oldEstoqueId.estoque_id;
                this.getProdutos();
            }
            if (this.estoqueError !== null) {
                this.errors.estoqueId = true;
                this.errors.estoqueIdMsg = this.estoqueError.msg;
            } else {
                this.errors.estoqueId = false;
                this.errors.estoqueIdMsg = '';
            }
        },
        updated() {
            $(this.$refs.inputProdutos).selectpicker('refresh');
            $(this.$refs.estoqueId).selectpicker('refresh');
        },
        methods: {
            getProdutos() {
                var self = this;
                if ((this.estoqueId !== null) && (this.estoqueId !== 'false')) {
                    axios.get('/produtos_estoque/'+this.estoqueId+'/json')
                        .then(function(response) {
                            self.produtosDisponiveis = response.data;
                            self.produtosData = response.data;
                            self.loadOldData();
                        });
                }
            },
            loadOldData() {
                if ((this.oldData !== null) && (this.loadOldDataFlag == true)) {
                    this.loadOldDataFlag = false;
                    for (var i=0; i<this.oldData.length; i++) {  
                        this.items.push({
                            'id': this.oldData[i].produto_id,
                            'produto_descricao': this.getProdutoById(this.oldData[i].produto_id).produto_descricao,
                            'quantidade': Number(this.oldData[i].quantidade),
                            'valor_unitario': Number(this.oldData[i].valor_unitario),
                            'valor_desconto': Number(this.oldData[i].valor_desconto),
                            'valor_acrescimo': Number(this.oldData[i].valor_acrescimo)
                        });
                        this.incluirProduto(this.oldData[i].produto_id);
                    }
                }
            },
            truncDecimal(value, n) {
                x=(value.toString()+".0").split(".");
                return parseFloat(x[0]+","+x[1].substr(0,n));
            },
            validarItem() {
                if ((this.produto_id == '') || (this.produto_id <= 0)) {
                    this.errors.inputProdutos = true;
                    this.errors.inputProdutosMsg = 'Nenhum Produto selecionado.';
                    return false;
                } else {
                    this.errors.inputProdutos = false;
                    this.errors.inputProdutosMsg = '';
                }
                
                if ((this.quantidade == '') || (this.quantidade <= 0)) {
                    this.errors.inputQuantidade = true;
                    this.errors.inputQuantidadeMsg = 'Informe a quantidade do produto.';
                    return false;
                } else {
                    if (!this.getEstoqueById(this.estoqueId).permite_estoque_negativo) {
                        let posicao_estoque_produto = this.getProdutoById(this.produto_id).posicao_estoque;
                        if (this.quantidade > posicao_estoque_produto) {
                            this.errors.inputQuantidade = true;
                            this.errors.inputQuantidadeMsg = 'Quantidade informada execede saldo em estoque ('+this.truncDecimal(posicao_estoque_produto, 3)+').';
                            return false;
                        }
                    }
                    this.errors.inputQuantidade = false;
                    this.errors.inputQuantidadeMsg = '';
                }

                if ((this.valorUnitario == '') || (this.valorUnitario <= 0)) {
                    this.errors.inputValorUnitario = true;
                    this.errors.inputValorUnitarioMsg = 'Informe o Valor Unitário do produto.';
                    return false;
                } else {
                    this.errors.inputValorUnitario = false;
                    this.errors.inputValorUnitarioMsg = '';
                }
                return true;
            },
            confirmDelete(index) {
                this.deleteIndex = index;
            },
            cancelDelete(index) {
                this.deleteIndex = false;
            },
            addProduto() {
                if (this.validarItem()) {
                    this.items.push({
                        'id': this.produto_id,
                        'produto_descricao': this.getProdutoById(this.produto_id).produto_descricao,
                        'quantidade': this.quantidade,
                        'valor_unitario': this.valorUnitario,
                        'valor_desconto': this.desconto,
                        'valor_acrescimo': this.acrescimo
                    });
                    this.incluirProduto(this.produto_id);
                    this.limparFormulario();
                }
            },
            editItem(index) {
                let item = this.items[index];
                this.quantidade = item.quantidade;
                this.valorUnitario = item.valor_unitario;
                this.desconto = item.valor_desconto;
                this.acrescimo = item.valor_acrescimo;
                this.produto_id = item.id;
                this.editing = true;
                this.editingIndex = index;
                this.produtosDisponiveis.push(item);
            },
            updateProduto() {
                this.items[this.editingIndex] = {
                    'id': this.produto_id,
                    'produto_descricao': this.getProdutoById(this.produto_id).produto_descricao,
                    'quantidade': this.quantidade,
                    'valor_unitario': this.valorUnitario,
                    'valor_desconto': this.desconto,
                    'valor_acrescimo': this.acrescimo
                };

                this.editing = false;
                this.editingIndex = false;
                this.limparFormulario();
                this.$delete(this.produtosDisponiveis, this.getProdutoIndexById(this.produto_id));
            },
            deleteItem() {
                this.removerProduto(this.items[this.deleteIndex].id);
                this.$delete(this.items, this.deleteIndex);
            },
            limparFormulario() {
                this.produto_id = false;
                this.produtoSelecionado = false;
                this.quantidade = 1;
                this.valorUnitario = 0;
                this.desconto = 0;
                this.acrescimo = 0;
                this.$refs.inputProdutos.focus();
            },
            totalQuantidade() {
                let result = 0;
                for (var i=0; i<this.items.length; i++) {  
                    result += this.items[i].quantidade;
                }
                return result;
            },
            totalValor() {
                let result = 0;
                for (var i=0; i<this.items.length; i++) {  
                    result += this.items[i].valor_unitario;
                }
                return result;
            },
            totalDesconto() {
                let result = 0;
                for (var i=0; i<this.items.length; i++) {  
                    result += this.items[i].valor_desconto;
                }
                return result;
            },
            totalAcrescimo() {
                let result = 0;
                for (var i=0; i<this.items.length; i++) {  
                    result += this.items[i].valor_acrescimo;
                }
                return result;
            },
            getProdutoById(id) {
                let result = 0;
                for (var i=0; i<this.produtosData.length; i++) {  
                    if (this.produtosData[i].id == id) {
                        result = this.produtosData[i];
                        break;
                    } 
                }
                return result;
            },
            getEstoqueById(id) {
                let result = 0;
                for (var i=0; i<this.estoques.length; i++) {  
                    if (this.estoques[i].id == id) {
                        result = this.estoques[i];
                        break;
                    } 
                }
                return result;
            },
            getProdutoIndexById(id) {
                let result = 0;
                for (var i=0; i<this.produtosData.length; i++) {  
                    if (this.produtosData[i].id == id) {
                        result = i;
                        break;
                    } 
                }
                return result;
            },
            getProdutoSelecionadoById(id) {
                let result = 0;
                for (var i=0; i<this.produtosSelecionados.length; i++) {  
                    if (this.produtosSelecionados[i].id == id) {
                        result = this.produtosSelecionados[i];
                        break;
                    } 
                }
                return result;
            },
            getProdutoSelecionadoIndexById(id) {
                let result = 0;
                for (var i=0; i<this.produtosSelecionados.length; i++) {  
                    if (this.produtosSelecionados[i].id == id) {
                        result = i;
                        break;
                    } 
                }
                return result;
            },
            incluirProduto(id) {
                this.produtosSelecionados.push(this.getProdutoById(id));
                this.$delete(this.produtosDisponiveis, this.getProdutoIndexById(id));
            },
            removerProduto(id) {
                this.produtosDisponiveis.push(this.getProdutoSelecionadoById(id));
                this.$delete(this.produtosSelecionados, this.getProdutoSelecionadoIndexById(id));
            }
        }
    }
</script>