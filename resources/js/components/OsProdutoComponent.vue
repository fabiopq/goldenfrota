<template>
    <div class="form-group">
        <div class="row">
            <input type="hidden" name="estoque_id" v-model="estoque_id">
            <input type="hidden" name="valor_total" v-model="valor_total">
            <div v-bind:class="{'col-md-7': true, ' has-error': this.errors.estoqueId}">
                <label for="estoqueId" class="control-label">Estoque</label>
                <select data-style="btn-secondary" data-title="Nada Selecionado" ref="estoqueId" v-model="estoqueId" data-live-search="true" class="form-control selectpicker" name="estoqueId" id="estoqueId" :disabled="produtosSelecionados.length > 0">
                    <!-- <option selected value=""> Nada Selecionado </option> -->
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
                            <th class="col-md-5">Produto</th>
                            <th class="col-md-1">Qtd</th>
                            <th class="col-md-1">R$ Uni.</th>
                            <th class="col-md-1">R$ Acrés.</th>
                            <th class="col-md-1">R$ Desc.</th>
                            <th class="col-md-1">R$ Final</th>
                            <th class="col-md-1">Ações</th>
                        </tr>
                    </thead>
                    <tbody name="fade" is="transition-group">
                        <tr class="row m-0" v-for="(item, index) in produtos" :key="index">
                            <td class="col-md-1 pool-right">
                                {{ item.id }}
                                <input type="hidden" :name="'produtos['+index+'][produto_id]'" :value="item.id">
                                <input type="hidden" :name="'produtos['+index+'][produto_vencimento_id]'" :value="item.produto_vencimento_id">
                            </td>
                            <td class="col-md-5">
                                {{ item.produto_descricao }}
                            </td>
                            <td class="col-md-1 text-right">
                                {{ item.quantidade | toDecimal3 }} 
                                <input type="hidden" :name="'produtos['+index+'][quantidade]'" :value="item.quantidade">    
                            </td>
                            <td class="col-md-1 text-right">
                                {{ item.valor_produto | toDecimal3 }}
                                <input type="hidden" :name="'produtos['+index+'][valor_produto]'" :value="item.valor_produto">    
                            </td>
                            <td class="col-md-1 text-right">
                                {{ item.valor_desconto | toDecimal3 }}
                                <input type="hidden" :name="'produtos['+index+'][valor_desconto]'" :value="item.valor_desconto">    
                            </td>
                            <td class="col-md-1 text-right">
                                {{ item.valor_acrescimo | toDecimal3 }}
                                <input type="hidden" :name="'produtos['+index+'][valor_acrescimo]'" :value="item.valor_acrescimo">    
                            </td>
                            <td class="col-md-1 text-right">
                                {{ item.valor_cobrado | toDecimal3 }}
                                <input type="hidden" :name="'produtos['+index+'][valor_cobrado]'" :value="item.valor_cobrado">    
                            </td>    
                            <td class="col-md-1">
                                <button type="button" class="btn btn-sm btn-warning" @click="editItem(index)" v-show="!editing">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" @click="confirmDeleteProduto(index)" data-toggle="modal" data-target="#confirmDelete2" v-show="!editing">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot v-if="this.produtos.length > 0">
                        <tr class="row m-0">
                            <td class="col-md-1"><strong>{{ this.produtos.length }}</strong></td>
                            <td class="col-md-5"></td>
                            <td class="col-md-1 text-right"><strong>{{ this.totalQuantidade() | toDecimal3 }}</strong></td>
                            <td class="col-md-1 text-right"><strong>{{ this.totalValor() | toDecimal3 }}</strong></td>
                            <td class="col-md-1 text-right"><strong>{{ this.totalDesconto() | toDecimal3 }}</strong></td>
                            <td class="col-md-1 text-right"><strong>{{ this.totalAcrescimo() | toDecimal3 }}</strong></td>
                            <td class="col-md-1 text-right"><strong>{{ this.totalCobrado() | toDecimal3 }}</strong></td>
                            <td class="col-md-2"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div>
                <div class="row m-0">
                    <div v-bind:class="{'col-md-6': true, ' has-error': this.errors.inputProdutos}" style="padding-right: 0 !important; padding-left: 0 !important;">
                        <select data-style="btn-secondary" :disabled="((estoqueId == 'false') || (estoqueId == null))" ref="inputProdutos" v-model="produto_id" data-live-search="true" class="form-control selectpicker" name="inputProdutos" id="inputProdutos">
                            <option selected value="false">Produto</option>
                            <option v-for="(produto, index) in produtosDisponiveisOrdenados" :value="produto.id" :key="index">{{ produto.id + ' - ' + produto.produto_descricao }}</option>
                        </select>
                        <span class="help-block" :v-if="this.errors.inputProdutos">
                            <strong>{{ this.errors.inputProdutosMsg }}</strong>
                        </span>
                    </div>
                    <!-- <div class="col-md-3 pr-0 pl-0">
                        <select data-style="btn-secondary" data-title="Produto Substituto" :disabled="(produtosVencimento.length == 0)" ref="inputProdutosVencimento" v-model="produto_vencimento_id" data-live-search="true" class="form-control selectpicker" name="inputProdutosVencimento" id="inputProdutosVencimento">
                            <option selected value="false"> Produto Substituído </option>
                            <option v-for="(produtoVencimento, index) in produtosVencimento" :value="produtoVencimento.id" :key="index">{{ produtoVencimento.produto.produto_desc_red }}</option>
                        </select>   
                    </div> -->
                    <div v-bind:class="{'col-md-1': true, ' has-error': this.errors.inputQuantidade}" style="padding-right: 0 !important; padding-left: 0 !important;">
                        <input :disabled="((estoqueId == 'false') || (estoqueId == null))" type="number" min="0,000" max="9999999999,999" step="any" ref="inputQuantidade" v-model.number="quantidade" class="form-control" name="inputQuantidade" id="inputQuantidade">
                        <span class="help-block" :v-if="this.errors.inputQuantidade">
                            <strong>{{ this.errors.inputQuantidadeMsg }}</strong>
                        </span>
                    </div>
                    <div v-bind:class="{'col-md-1': true, ' has-error': this.errors.inputValorUnitario}" style="padding-right: 0 !important; padding-left: 0 !important;">
                        <input :disabled="((estoqueId == 'false') || (estoqueId == null))" type="number" min="0,000" max="9999999999,999" step="any" ref="inputValorUnitario" v-model.number="valor_unitario" class="form-control" name="inputValorUnitario" id="inputValorUnitario" readonly>
                        <span class="help-block" :v-if="this.errors.inputValorUnitario">
                            <strong>{{ this.errors.inputValorUnitarioMsg }}</strong>
                        </span>
                    </div>
                    <div v-bind:class="{'col-md-1': true, ' has-error': this.errors.inputAcrescimo}" style="padding-right: 0 !important; padding-left: 0 !important;">
                        <input :disabled="((estoqueId == 'false') || (estoqueId == null))" type="number" min="0,000" max="9999999999,999" step="any" ref="inputAcrescimo" v-model.number="valor_acrescimo" class="form-control" name="inputAcrescimo" id="inputAcrescimo">
                        <span class="help-block" :v-if="this.errors.inputAcrescimo">
                            <strong>{{ this.errors.inputAcrescimoMsg }}</strong>
                        </span>
                    </div>
                    <div v-bind:class="{'col-md-1': true, ' has-error': this.errors.inputDesconto}" style="padding-right: 0 !important; padding-left: 0 !important;">
                        <input :disabled="((estoqueId == 'false') || (estoqueId == null))" type="number" min="0,000" max="9999999999,999" step="any" ref="inputDesconto" v-model.number="valor_desconto" class="form-control" name="inputDesconto" id="inputDesconto">
                        <span class="help-block" :v-if="this.errors.inputDesconto">
                            <strong>{{ this.errors.inputDescontoMsg }}</strong>
                        </span>
                    </div>
                    <div v-bind:class="{'col-md-1': true, ' has-error': this.errors.inputValorCobrado}" style="padding-right: 0 !important; padding-left: 0 !important;">
                        <input :disabled="((estoqueId == 'false') || (estoqueId == null))" type="number" min="0,000" max="9999999999,999" step="any" ref="inputValorCobrado" v-model.number="valor_cobrado" class="form-control" name="inputValorCobrado" id="inputValorCobrado" readonly>
                        <span class="help-block" :v-if="this.errors.inputValorCobrado">
                            <strong>{{ this.errors.inputValorCobradoMsg }}</strong>
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
            <modal2 @cancel2="cancelDelete" @confirm2="deleteProduto" :modal-title="'Corfirmação'" :modal-text="'Confirma a remoção deste Item?'" />
        </div>
    </div>
</template>

<script>
    import modal2 from './modal2.vue';

    export default {
        name: 'ordem-servico-produto',
        components: {
            modal2
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
                produtos: [],
                produtosVencimento: [],
                produto_vencimento_id: null,
                veiculo_element: null,
                quantidade: 1,
                valor_desconto: 0,
                valor_acrescimo: 0,
                valor_cobrado: 0,
                valor_unitario: 0,
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
                },
            }
        },
        watch: {
            oldData: function() {
               //this.$refs.confirmDelete
            },
            estoqueId: function() {
                this.getProdutos();
            },
            valor_produto: function() {
                this.calcTotalProdutoItem();
            },
            valor_desconto: function() {
                this.calcTotalProdutoItem();
            },
            valor_acrescimo: function() {
                this.calcTotalProdutoItem();
            },
            quantidade: function() {
                this.calcTotalProdutoItem();
            },
            produto_id: function() {
                if (!this.editing) {
                    this.valor_unitario = this.getProdutoById(this.produto_id).valor_venda;
                }
                this.calcTotalProdutoItem();
            }
        },
        computed: {
            veiculo_id: function() {
                if (this.veiculo_element !== null) {
                    return this.veiculo_element.value;
                } else {
                    return null;
                }
            },
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
                    for (var i = 0; i < this.produtos.length; i++) {
                        total += ((parseFloat(this.produtos[i].valor_produto) + parseFloat(this.produtos[i].valor_acrescimo))-parseFloat(this.produtos[i].valor_desconto))*this.produtos[i].quantidade;
                    }
                    return parseFloat(total);
                }
            },
            produtosDisponiveisOrdenados: function() {
                return this.produtosDisponiveis.sort((a, b) => {
                    return (a.produto_descricao > b.produto_descricao) ? 1 : (a.produto_descricao == b.produto_descricao) ? 0 : -1;
                });
            }
        },
        mounted() {
            if (this.oldEstoqueId !== null) {
                this.estoqueId = this.oldEstoqueId;
                //this.getProdutos();
            }
            this.veiculo_element = this.$parent.$parent.$refs.ref_veiculo_id;
        },
        updated() {
            $(this.$refs.inputProdutosVencimento).selectpicker('refresh');
            $(this.$refs.inputProdutos).selectpicker('refresh');
            $(this.$refs.estoqueId).selectpicker('refresh');    
        },
        methods: {
            getValorTotal() {
                let total = 0;
                for (var i = 0; i < this.produtos.length; i++) {
                    total += ((parseFloat(this.produtos[i].valor_produto) + parseFloat(this.produtos[i].valor_acrescimo))-parseFloat(this.produtos[i].valor_desconto))*this.produtos[i].quantidade;
                }
                return parseFloat(total);
            },
            getProdutos() {
                var self = this;
                //if ((this.estoqueId !== null) && (this.estoqueId !== 'false')) {
                if (this.estoqueId > 0) {
                    axios.get('/produtos_estoque/'+this.estoqueId+'/json')
                        .then(function(response) {
                            self.produtosDisponiveis = response.data;
                            self.produtosData = response.data;
                            self.loadOldData();
                            self.obterListagemProdutosVencimento();
                        });
                }
            },
            loadOldData() {
                if ((this.oldData !== null) && (this.loadOldDataFlag == true)) {
                    this.loadOldDataFlag = false;
                    for (var i=0; i<this.oldData.length; i++) {  
                        this.produtos.push({
                            'id': this.oldData[i].produto_id,
                            'produto_descricao': this.getProdutoById(this.oldData[i].produto_id).produto_descricao,
                            'quantidade': Number(this.oldData[i].quantidade),
                            'valor_produto': Number(this.oldData[i].valor_produto),
                            'valor_desconto': Number(this.oldData[i].valor_desconto),
                            'valor_acrescimo': Number(this.oldData[i].valor_acrescimo),
                            'valor_cobrado': Number(this.oldData[i].valor_cobrado)
                        });
                        this.incluirProduto(this.oldData[i].produto_id);
                    }
                }
            },
            truncDecimal(value, n) {
                if(value === 0) {
                    return value;
                }
                x=(value.toString()+".0").split(".");
                if(!x) {
                    x = 0;
                }
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
                        console.log('posicao_estoque_produto: '+posicao_estoque_produto);
                        if (this.quantidade > posicao_estoque_produto) {
                            this.errors.inputQuantidade = true;
                            this.errors.inputQuantidadeMsg = 'Quantidade informada execede saldo em estoque ('+this.truncDecimal(posicao_estoque_produto, 3)+').';
                            return false;
                        }
                    } else {
                        this.errors.inputQuantidade = false;
                        this.errors.inputQuantidadeMsg = '';
                    }
                }

                if ((this.valor_unitario == '') || (this.valor_unitario <= 0)) {
                    this.errors.inputValorUnitario = true;
                    this.errors.inputValorUnitarioMsg = 'Informe o Valor Unitário do produto.';
                    return false;
                } else {
                    this.errors.inputValorUnitario = false;
                    this.errors.inputValorUnitarioMsg = '';
                }
                return true;
            },
            confirmDeleteProduto(index) {
                this.deleteIndex = index;
            },
            cancelDelete(index) {
                this.deleteIndex = false;
            },
            cancelProtuto() {
                //console.log('cancel produto');
            },
            confirmProtuto() {
                //console.log('confirm produto');
            },
            addProduto() {
                if (this.validarItem()) {
                    this.produtos.push({
                        'id': this.produto_id,
                        'produto_vencimento_id': this.produto_vencimento_id,
                        'produto_descricao': this.getProdutoById(this.produto_id).produto_descricao+this.getProdutoVencimentoDesc(this.produto_vencimento_id),
                        'quantidade': Number(this.quantidade),
                        'valor_produto': Number(this.getProdutoById(this.produto_id).valor_venda),
                        'valor_desconto': Number(this.valor_desconto),
                        'valor_acrescimo': Number(this.valor_acrescimo),
                        'valor_cobrado': Number(this.valor_cobrado)
                    });
                    this.incluirProduto(this.produto_id);
                    this.limparFormulario();
                }
            },
            editItem(index) {
                this.editing = true;
                this.editingIndex = index;
                let item = this.produtos[index];
                this.produto_id = item.id;
                this.quantidade = Number(item.quantidade);
                this.valor_unitario = Number(item.valor_produto);
                this.valor_desconto = Number(item.valor_desconto);
                this.valor_acrescimo = Number(item.valor_acrescimo);
                this.produtosDisponiveis.push(item);
            },
            updateProduto() {
                this.produtos[this.editingIndex] = {
                    'id': this.produto_id,
                    'produto_vencimento_id': this.produto_vencimento_id,
                    'produto_descricao': this.getProdutoById(this.produto_id).produto_descricao+this.getProdutoVencimentoDesc(this.produto_vencimento_id),
                    'quantidade': Number(this.quantidade),
                    'valor_produto': Number(this.valor_unitario),
                    'valor_desconto': Number(this.valor_desconto),
                    'valor_acrescimo': Number(this.valor_acrescimo),
                    'valor_cobrado': Number(this.valor_cobrado)
                };

                this.editing = false;
                this.editingIndex = false;
                this.limparFormulario();
                this.$delete(this.produtosDisponiveis, this.getProdutoIndexById(this.produto_id));
                let VLTotal = this.getValorTotal();
                this.$emit('updateTotalProd', VLTotal);
            },
            getProdutoVencimentoDesc(id) {
                let prod = this.produtosVencimento.find(a => a.id == id);
                if (prod != undefined) {
                    return ' ('+prod.produto.produto_desc_red+')';
                } else {
                    return '';
                }
            },
            deleteProduto() {
                this.removerProduto(this.produtos[this.deleteIndex].id);
                this.$delete(this.produtos, this.deleteIndex);
            },
            limparFormulario() {
                this.produto_id = false;
                this.produtoSelecionado = false;
                this.quantidade = 1;
                this.valor_unitario = 0.000;
                this.valor_desconto = 0.000;
                this.valor_acrescimo = 0.000;
                this.valor_cobrado = 0.000;
                this.$refs.inputProdutos.focus();
            },
            totalQuantidade() {
                let result = 0;
                for (var i=0; i<this.produtos.length; i++) {  
                    result += this.produtos[i].quantidade;
                }
                return result;
            },
            totalValor() {
                let result = 0;
                for (var i=0; i<this.produtos.length; i++) {  
                    result += this.produtos[i].valor_produto;
                }
                return result;
            },
            totalDesconto() {
                let result = 0;
                for (var i=0; i<this.produtos.length; i++) {  
                    result += this.produtos[i].valor_desconto;
                }
                return result;
            },
            totalAcrescimo() {
                let result = 0;
                for (var i=0; i<this.produtos.length; i++) {  
                    result += this.produtos[i].valor_acrescimo;
                }
                return result;
            },
            totalCobrado() {
                let result = 0;
                for (var i=0; i<this.produtos.length; i++) {  
                    result += this.produtos[i].valor_cobrado;
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
                //console.log('index: '+result);
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
                this.$emit('updateTotalProd', this.valor_total);
            },
            removerProduto(id) {
                this.produtosDisponiveis.push(this.getProdutoSelecionadoById(id));
                this.$delete(this.produtosSelecionados, this.getProdutoSelecionadoIndexById(id));
                this.$emit('updateTotalProd', this.valor_total);
            },
            calcTotalProdutoItem() {
                //console.log('entrou no valor cobrado');
                this.valor_cobrado = ((parseFloat((isNaN(this.valor_unitario) || (this.valor_unitario == '')) ? 0 : this.valor_unitario) +
                                      parseFloat((isNaN(this.valor_acrescimo) || (this.valor_acrescimo == '')) ? 0 : this.valor_acrescimo)) - 
                                      parseFloat((isNaN(this.valor_desconto) || (this.valor_desconto == '')) ? 0 : this.valor_desconto)) *
                                      parseFloat((isNaN(this.quantidade) || (this.quantidade == '')) ? 1 : this.quantidade);
            },
            obterListagemProdutosVencimento() {
                console.log(this.veiculo_id);
                if (this.veiculo_id !== null) {
                    axios.get('/produtos_vencendo_vencidos/'+this.veiculo_id)
                        .then(async r => {
                            this.produtosVencimento = r.data;
                            console.log(r.data);
                        })
                        .catch(e => {
                            console.log(e);
                        });
                }
            }
        }
    }
</script>