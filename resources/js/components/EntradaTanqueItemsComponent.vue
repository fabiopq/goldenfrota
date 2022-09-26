<template>
    <div class="card">
        <div class="card-header">
            <strong>Combustíveis</strong>
        </div>
        <div class="card-body" style="padding: 0 !important;">
            <table class="table table-sm table-striped table-bordered table-hover" style="margin-bottom:0 !important;">
                <thead class="thead-light">
                    <tr class="row m-0">

                        <th class="col-md-6">Tanque</th>
                        <th class="col-md-2">Qtd</th>
                        <th class="col-md-2">Vlr. Un.</th>
                        <th class="col-md-2">Ações</th>
                    </tr>
                </thead>
                <tbody name="fade" is="transition-group">
                    <tr class="row m-0" v-for="(item, index) in items" :key="index">
                        <td class="col-md-1 pool-right">
                            {{ item.id }}
                            <input type="hidden" :name="'items['+index+'][tanque_id]'" :value="item.id">
                        </td>
                        <td class="col-md-5">
                            {{ item.tanque }}
                        </td>
                        <td class="col-md-2 text-right">
                            {{ item.quantidade }}
                            <input type="hidden" :name="'items['+index+'][quantidade]'" :value="item.quantidade">
                        </td>
                        <td class="col-md-2 text-right">
                            {{ item.valor_unitario }}
                            <input type="hidden" :name="'items['+index+'][valor_unitario]'"
                                :value="item.valor_unitario">
                        </td>
                        <td class="col-md-2">
                            <button type="button" class="btn btn-sm btn-warning" @click="editItem(index)"
                                v-show="!editing">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" @click="confirmDelete(index)"
                                data-toggle="modal" data-target="#confirmDelete" v-show="!editing">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
                <tfoot v-if="this.items.length > 0">
                    <tr class="row m-0">
                        <td class="col-md-1"><strong>{{ this.items.length }}</strong></td>
                        <td class="col-md-5"></td>
                        <td class="col-md-2 text-right"><strong>{{ this.totalQuantidade() }}</strong></td>
                        <td class="col-md-2 text-right"><strong>{{ this.totalValor() }}</strong></td>
                        <td class="col-md-2"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="panel-footer">
            <div class="row m-0">
                <input type="hidden" name="valor_total" v-model="valor_total">
                <div v-bind:class="{'col-md-6': true, ' has-error': this.errors.inputTanques}"
                    style="padding-right: 0 !important; padding-left: 0 !important;">
                    <select data-style="btn-secondary" ref="inputTanques" v-model="tanque_id" data-live-search="true"
                        class="form-control selectpicker" name="inputTanques" id="inputTanques">
                        <option selected value="false"> Nada Selecionado </option>
                        <option v-for="(tanque, index) in tanquesDisponiveisOrdenados" :value="tanque.id" :key="index">
                            {{ tanque.id + ' - ' + tanque.tanque }}</option>
                    </select>
                    <span class="help-block" :v-if="this.errors.inputTanques">
                        <strong>{{ this.errors.inputTanquesMsg }}</strong>
                    </span>
                </div>
                <div v-bind:class="{'col-md-2': true, ' has-error': this.errors.inputQuantidade}"
                    style="padding-right: 0 !important; padding-left: 0 !important;">
                    <input type="number" min="0,000" max="9999999999,999" step="any" ref="inputQuantidade"
                        v-model.number="quantidade" class="form-control" name="inputQuantidade" id="inputQuantidade">
                    <span class="help-block" :v-if="this.errors.inputQuantidade">
                        <strong>{{ this.errors.inputQuantidadeMsg }}</strong>
                    </span>
                </div>
                <div v-bind:class="{'col-md-2': true, ' has-error': this.errors.inputValorUnitario}"
                    style="padding-right: 0 !important; padding-left: 0 !important;">
                    <input type="number" min="0,000" max="9999999999,999" step="any" ref="inputValorUnitario"
                        v-model.number="valorUnitario" class="form-control" name="inputValorUnitario"
                        id="inputValorUnitario">
                    <span class="help-block" :v-if="this.errors.inputValorUnitario">
                        <strong>{{ this.errors.inputValorUnitarioMsg }}</strong>
                    </span>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-success" @click="addEntrada" v-show="!editing">
                        <i class="fas fa-plus"></i>
                    </button>
                    <button type="button" class="btn btn-success" @click="updateEntrada" v-show="editing">
                        <i class="fas fa-check"></i>
                    </button>
                </div>
            </div>
        </div>
        <modal @cancel="cancelDelete" @confirm="deleteItem" :modal-title="'Corfirmação'"
            :modal-text="'Confirma a remoção deste Item?'" />
    </div>
</template>

<script>
import modal from './modal.vue';

export default {
    name: 'entrada_tanque',
    components: {
        modal
    },
    data() {
        return {
            editing: false,
            editingIndex: false,
            items: [],
            tanque_id: false,
            quantidade: 1,
            valorUnitario: 0,
            isModalVisible: false,
            deleteIndex: false,
            tanquesDisponiveis: [],
            tanquesSelecionados: [],
            errors: {
                inputTanques: false,
                inputTanquesMsg: '',
                inputQuantidade: false,
                inputQuantidadeMsg: '',
                inputValorUnitario: false,
                inputValorUnitariodeMsg: '',
            }
        }
    },
    props: [
        'tanquesData',
        'oldData'
    ],
    watch: {
        oldData: function () {
            this.$refs.confirmDelete
        }
    },
    computed: {
        tanquesDisponiveisOrdenados: function () {
            function compare(a, b) {
                if (a.tanque < b.tanque)
                    return -1;
                if (a.tanque > b.tanque)
                    return 1;
                return 0;
            }

            return this.tanquesDisponiveis.sort(compare);
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
    },
    mounted() {
        this.tanquesDisponiveis = this.tanquesData;
        if (this.oldData !== null) {
            for (var i = 0; i < this.oldData.length; i++) {
                this.items.push({
                    'id': this.oldData[i].tanque_id,
                    'tanque': this.getTanqueById(this.oldData[i].tanque_id).tanque,
                    'quantidade': Number(this.oldData[i].quantidade),
                    'valor_unitario': Number(this.oldData[i].valor_unitario),
                });
                this.incluirEntrada(this.oldData[i].tanque_id);
            }
        }
    },
    updated() {
        $(this.$refs.inputTanques).selectpicker('refresh');
    },
    methods: {
        validarItem() {
            if ((this.tanque_id == '') || (this.tanque_id <= 0)) {
                this.errors.inputTanques = true;
                this.errors.inputTanquesMsg = 'Nenhum Tanque selecionado.';
                return false;
            } else {
                this.errors.inputTanques = false;
                this.errors.inputTanquesMsg = '';
            }

            if ((this.quantidade == '') || (this.quantidade <= 0)) {
                this.errors.inputQuantidade = true;
                this.errors.inputQuantidadeMsg = 'Informe a quantidade.';
                return false;
            } else {
                this.errors.inputQuantidade = false;
                this.errors.inputQuantidadeMsg = '';
            }

            if ((this.valorUnitario == '') || (this.valorUnitario <= 0)) {
                this.errors.inputValorUnitario = true;
                this.errors.inputValorUnitarioMsg = 'Informe o Valor Unitário.';
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
        addEntrada() {
            if (this.validarItem()) {
                this.items.push({
                    'id': this.tanque_id,
                    'tanque': this.getTanqueById(this.tanque_id).tanque,
                    'quantidade': this.quantidade,
                    'valor_unitario': this.valorUnitario,
                    'valor_desconto': this.desconto,
                    'valor_acrescimo': this.acrescimo
                });
                this.incluirEntrada(this.tanque_id);
                this.limparFormulario();
            }
        },
        editItem(index) {
            let item = this.items[index];
            this.quantidade = item.quantidade;
            this.valorUnitario = item.valor_unitario;
            this.tanque_id = item.id;
            this.editing = true;
            this.editingIndex = index;
            this.tanquesDisponiveis.push(item);
        },
        updateEntrada() {
            this.items[this.editingIndex] = {
                'id': this.tanque_id,
                'tanque': this.getTanqueById(this.tanque_id).tanque,
                'quantidade': this.quantidade,
                'valor_unitario': this.valorUnitario,
            };

            this.editing = false;
            this.editingIndex = false;
            this.limparFormulario();
            this.$delete(this.tanquesDisponiveis, this.getTanqueIndexById(this.tanque_id));
        },
        deleteItem() {
            this.removerEntrada(this.items[this.deleteIndex].id);
            this.$delete(this.items, this.deleteIndex);
        },
        limparFormulario() {
            this.produtoSelecionado = false;
            this.quantidade = 1;
            this.valorUnitario = 0;
            this.desconto = 0;
            this.acrescimo = 0;
            this.$refs.inputTanques.focus();
        },
        totalQuantidade() {
            let result = 0;
            for (var i = 0; i < this.items.length; i++) {
                result += this.items[i].quantidade;
            }
            return result;
        },
        totalValor() {
            let result = 0;
            for (var i = 0; i < this.items.length; i++) {
                result += this.items[i].valor_unitario;
            }
            return result;
        },
        totalDesconto() {
            let result = 0;
            for (var i = 0; i < this.items.length; i++) {
                result += this.items[i].valor_desconto;
            }
            return result;
        },
        totalAcrescimo() {
            let result = 0;
            for (var i = 0; i < this.items.length; i++) {
                result += this.items[i].valor_acrescimo;
            }
            return result;
        },
        getTanqueById(id) {
            let result = 0;
            for (var i = 0; i < this.tanquesData.length; i++) {
                if (this.tanquesData[i].id == id) {
                    result = this.tanquesData[i];
                    break;
                }
            }
            return result;
        },
        getTanqueIndexById(id) {
            let result = 0;
            for (var i = 0; i < this.tanquesData.length; i++) {
                if (this.tanquesData[i].id == id) {
                    result = i;
                    break;
                }
            }
            return result;
        },
        getTanqueSelecionadoById(id) {
            let result = 0;
            for (var i = 0; i < this.tanquesSelecionados.length; i++) {
                if (this.tanquesSelecionados[i].id == id) {
                    result = this.tanquesSelecionados[i];
                    break;
                }
            }
            return result;
        },
        getTanqueSelecionadoIndexById(id) {
            let result = 0;
            for (var i = 0; i < this.tanquesSelecionados.length; i++) {
                if (this.tanquesSelecionados[i].id == id) {
                    result = i;
                    break;
                }
            }
            return result;
        },
        incluirEntrada(id) {
            this.tanquesSelecionados.push(this.getTanqueById(id));
            this.$delete(this.tanquesDisponiveis, this.getTanqueIndexById(id));
        },
        removerEntrada(id) {
            this.tanquesDisponiveis.push(this.getTanqueSelecionadoById(id));
            this.$delete(this.tanquesSelecionados, this.getTanqueSelecionadoIndexById(id));
        }
    }
}
</script>