<template>

    <div class="card">
        <div class="card-header">
            <strong>Combustíveis</strong>
        </div>
        <div class="card-body" style="padding: 0 !important;">
            <table class="table table-sm table-striped table-bordered table-hover" style="margin-bottom:0 !important;">
                <thead class="thead-light">
                    <tr class="row m-0">

                        <th class="col-md-3">Combustivel</th>
                        <th class="col-md-2">Vlr. Un.</th>
                        <th class="col-md-2">% Desc.</th>
                        <th class="col-md-2">% Acres.</th>
                        <th class="col-md-2">Ações</th>

                    </tr>
                </thead>
                <tbody name="fade" is="transition-group">
                    <tr class="row m-0" v-for="(item, index) in items" :key="index">
                        <td class="col-md-1 pool-right">
                            {{ item.id }}
                            <input type="hidden" :name="'items[' + index + '][combustivel_id]'" :value="item.id">
                        </td>
                        <td class="col-md-2">
                            {{ item.combustivel }}
                        </td>

                        <td class="col-md-2 text-right">
                            {{ item.valor_unitario }}
                            <input type="hidden" :name="'items[' + index + '][valor_unitario]'"
                                :value="item.valor_unitario">
                        </td>
                        <td class="col-md-2 text-right">
                            {{ item.perc_desconto }}
                            <input type="hidden" :name="'items[' + index + '][perc_desconto]'"
                                :value="item.perc_desconto">
                        </td>
                        <td class="col-md-2 text-right">
                            {{ item.perc_acrescimo }}
                            <input type="hidden" :name="'items[' + index + '][perc_acrescimo]'"
                                :value="item.perc_acrescimo">
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

            </table>
        </div>
        <div class="panel-footer">
            <div class="row m-0">

                <div v-bind:class="{ 'col-md-3': true, ' has-error': this.errors.inputCombustiveis }"
                    style="padding-right: 0 !important; padding-left: 0 !important;">
                    <select data-style="btn-secondary" ref="inputCombustiveis" v-model="combustivel_id"
                        data-live-search="true" class="form-control selectpicker" name="inputCombustiveis"
                        id="inputCombustiveis">
                        <option selected value="false"> Nada Selecionado </option>
                        <option v-for="(combustivel, index) in combustiveisDisponiveisOrdenados" :value="combustivel.id"
                            :key="index">
                            {{ combustivel.id + ' - ' + combustivel.combustivel }}</option>
                    </select>
                    <span class="help-block" :v-if="this.errors.inputCombustiveis">
                        <strong>{{ this.errors.inputCombustiveissMsg }}</strong>
                    </span>
                </div>

                <div v-bind:class="{ 'col-md-2': true, ' has-error': this.errors.inputValorUnitario }"
                    style="padding-right: 0 !important; padding-left: 0 !important;">
                    <input type="number" min="0,000" max="9999999999,999" step="any" ref="inputValorUnitario"
                        v-model.number="valorUnitario" class="form-control" name="inputValorUnitario"
                        id="inputValorUnitario">
                    <span class="help-block" :v-if="this.errors.inputValorUnitario">
                        <strong>{{ this.errors.inputValorUnitarioMsg }}</strong>
                    </span>
                </div>
                <div v-bind:class="{ 'col-md-2': true, ' has-error': this.errors.inputPercDesconto }"
                    style="padding-right: 0 !important; padding-left: 0 !important;">
                    <input type="number" min="0,000" max="9999999999,999" step="any" ref="inputPercDesconto"
                        v-model.number="percDesconto" class="form-control" name="inputPercDesconto"
                        id="inputPercDesconto">
                    <span class="help-block" :v-if="this.errors.inputPercDesconto">
                        <strong>{{ this.errors.inputPercDescontoMsg }}</strong>
                    </span>
                </div>
                <div v-bind:class="{ 'col-md-2': true, ' has-error': this.errors.inputPercAcrescimo }"
                    style="padding-right: 0 !important; padding-left: 0 !important;">
                    <input type="number" min="0,000" max="9999999999,999" step="any" ref="inputPercAcrescimo"
                        v-model.number="percAcrescimo" class="form-control" name="inputPercAcrescimo"
                        id="inputPercAcrescimo">
                    <span class="help-block" :v-if="this.errors.inputPercAcrescimo">
                        <strong>{{ this.errors.inputPercAcrescimoMsg }}</strong>
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
    name: 'entrada_combustivel',
    components: {
        modal
    },
    data() {
        return {
            editing: false,
            editingIndex: false,
            items: [],
            combustivel_id: false,
            valorUnitario: 0,
            percDesconto: 0,
            percAcrescimo: 0,
            isModalVisible: false,
            deleteIndex: false,
            combustiveisDisponiveis: [],
            combustiveisSelecionados: [],
            errors: {
                inputCombustiveis: false,
                inputCombustiveisMsg: '',
                inputValorUnitario: false,
                inputPercAcrescimo: false,
                inputPercDesconto: false,
                inputValorUnitariodeMsg: '',
            }
        }
    },
    props: [
        'combustiveisData',
        'oldData'
    ],
    watch: {
        oldData: function () {
            this.$refs.confirmDelete
        },
        valorUnitario(newVal) {
            if (newVal > 0) {
                this.percDesconto = 0;
                this.percAcrescimo = 0;
            }
        },
        percDesconto(newVal) {
            if (newVal > 0) {
                this.valorUnitario = 0;
                this.percAcrescimo = 0;
            }
        },
        percAcrescimo(newVal) {
            if (newVal > 0) {
                this.valorUnitario = 0;
                this.percDesconto = 0;
            }
        }

    },
    computed: {
        combustiveisDisponiveisOrdenados: function () {
            function compare(a, b) {
                if (a.combustivel < b.combustivel)
                    return -1;
                if (a.combustivel > b.combustivel)
                    return 1;
                return 0;
            }

            return this.combustiveisDisponiveis.sort(compare);
        },

    },
    mounted() {
        this.combustiveisDisponiveis = this.combustiveisData;
        if (this.oldData !== null) {
            for (var i = 0; i < this.oldData.length; i++) {
                this.items.push({
                    'id': this.oldData[i].combustivel_id,
                    'combustivel': this.getCombustivelById(this.oldData[i].combustivel_id).combustivel,
                    'valor_unitario': Number(this.oldData[i].valor_unitario),
                    'perc_desconto': Number(this.oldData[i].perc_desconto),
                    'perc_acrescimo': Number(this.oldData[i].perc_acrescimo),
                });
                this.incluirEntrada(this.oldData[i].combustivel_id);
            }
        }
    },
    updated() {
        $(this.$refs.inputCombustiveis).selectpicker('refresh');
    },
    methods: {

        validarItem() {
            if ((this.combustivel_id == '') || (this.combustivel_id <= 0)) {
                this.errors.inputCombustiveis = true;
                this.errors.inputCombustiveisMsg = 'Nenhum Combustivel selecionado.';
                return false;
            } else {
                this.errors.inputCombustiveis = false;
                this.errors.inputCombustiveisMsg = '';
            }



            if (
                (!this.valorUnitario || this.valorUnitario <= 0) &&
                (!this.percDesconto || this.percDesconto <= 0) &&
                (!this.percAcrescimo || this.percAcrescimo <= 0)
            ) {
                this.errors.inputValorUnitario = true;
                this.errors.inputValorUnitarioMsg = 'Preencha pelo menos um dos campos: Valor Unitário, % Desconto ou % Acréscimo.';
                this.errors.inputPercDesconto = true;
                this.errors.inputPercDescontoMsg = '';
                this.errors.inputPercAcrescimo = true;
                this.errors.inputPercAcrescimoMsg = '';
                return false;
            } else {
                this.errors.inputValorUnitario = false;
                this.errors.inputValorUnitarioMsg = '';
                this.errors.inputPercDesconto = false;
                this.errors.inputPercDescontoMsg = '';
                this.errors.inputPercAcrescimo = false;
                this.errors.inputPercAcrescimoMsg = '';
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
                    'id': this.combustivel_id,
                    'combustivel': this.getCombustivelById(this.combustivel_id).combustivel,
                    'valor_unitario': this.valorUnitario,
                    'perc_desconto': this.percDesconto,
                    'perc_acrescimo': this.percAcrescimo,
                });
                this.incluirEntrada(this.combustivel_id);
                this.limparFormulario();
            }
        },
        editItem(index) {
            let item = this.items[index];

            this.valorUnitario = item.valor_unitario;
            this.combustivel_id = item.id;
            this.percAcrescimo = item.perc_acrescimo;
            this.percDesconto = item.perc_desconto;
            this.editing = true;
            this.editingIndex = index;
            this.combustiveisDisponiveis.push(item);

        },
        updateEntrada() {
            this.items[this.editingIndex] = {
                'id': this.combustivel_id,
                'combustivel': this.getCombustivelById(this.combustivel_id).combustivel,
                'valor_unitario': this.valorUnitario,
                'perc_desconto': this.percDesconto,
                'perc_acrescimo': this.percAcrescimo,
            };

            this.editing = false;
            this.editingIndex = false;
            this.limparFormulario();
            this.$delete(this.combustiveisDisponiveis, this.getCombustivelIndexById(this.combustivel_id));
        },
        deleteItem() {
            this.removerEntrada(this.items[this.deleteIndex].id);
            this.$delete(this.items, this.deleteIndex);
        },
        limparFormulario() {
            this.produtoSelecionado = false;

            this.valorUnitario = 0;
            this.percDesconto = 0;
            this.percAcrescimo = 0;
            this.$refs.inputCombustiveis.focus();

        },

        getCombustivelById(id) {
            let result = 0;

            for (var i = 0; i < this.combustiveisData.length; i++) {
                if (this.combustiveisData[i].id == id) {
                    result = this.combustiveisData[i];
                    break;
                }
            }
            return result;

        },
        getCombustivelIndexById(id) {

            let result = 0;
            for (var i = 0; i < this.combustiveisData.length; i++) {
                if (this.combustiveisData[i].id == id) {
                    result = i;
                    break;
                }
            }

            return result;
        },
        getCombustivelSelecionadoById(id) {
            let result = 0;
            for (var i = 0; i < this.combustiveisSelecionados.length; i++) {
                if (this.combustiveisSelecionados[i].id == id) {
                    result = this.combustiveisSelecionados[i];
                    break;
                }
            }

            return result;

        },
        getCombustivelSelecionadoIndexById(id) {
            let result = 0;
            for (var i = 0; i < this.combustiveisSelecionados.length; i++) {
                if (this.combustiveisSelecionados[i].id == id) {
                    result = i;
                    break;
                }
            }

            return result;
        },
        incluirEntrada(id) {
            this.combustiveisSelecionados.push(this.getCombustivelById(id));
            this.$delete(this.combustiveisDisponiveis, this.getCombustivelIndexById(id));
        },
        removerEntrada(id) {
            this.combustiveisDisponiveis.push(this.getCombustivelSelecionadoById(id));
            this.$delete(this.combustiveisSelecionados, this.getCombustivelSelecionadoIndexById(id));

        },


    }
}
</script>