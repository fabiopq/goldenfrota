<template>
    <div>
        <ordem-servico-servico v-on:updateTotalServ="updateTotalServicos" :servicos-data="servicosData" :old-data="oldServicosData"></ordem-servico-servico>
        <ordem-servico-produto v-on:updateTotalProd="updateTotalProdutos" v-bind:estoques="estoques" :old-estoque-id="oldEstoqueId" :old-data="oldProdutosData"></ordem-servico-produto>
        <div class="col col-sm-4 pull-right" style="padding: 0px !important;">
            <label for="inputValorTotalOs" class="control-label">Valor Total</label>
            <div class="form-control">{{ valor_total_os | toDecimal3 }}</div>
            <input type="hidden" ref="inputValorTotalOs" v-model="valor_total_os" class="form-control" name="valor_total" id="valor_total" readonly>
        </div>
    </div>
</template> 


<script>
import ordemServicoServico from './OsServicoComponent.vue';
import ordemServicoProduto from './OsProdutoComponent.vue';
export default {
    name: 'ordem-servico',
    components: {
        ordemServicoServico,
        ordemServicoProduto
    },
    props: [
        'servicosData',
        'oldServicosData',
        'estoques',
        'oldEstoqueId',
        'oldProdutosData'
    ],
    data() {
        return {
            valor_total_produtos: 0,
            valor_total_servicos: 0 
        }
    },
    methods: {
       updateTotalServicos(value) {
           //console.log('updateTotalServicos: '+value);
           this.valor_total_servicos = value;
       },
       updateTotalProdutos(value) {
           //console.log('updateTotalProdutos: '+value);
           this.valor_total_produtos = value;
       } 
    },
    computed: {
        valor_total_os: {
            get() {
                /* var formatter = new Intl.NumberFormat('pt-BR', {
                    minimumFractionDigits: 3
                });
                return formatter.format(this.valor_total_produtos + this.valor_total_servicos); */
                return parseFloat(this.valor_total_produtos + this.valor_total_servicos);
            }
        }
    }
        
}
</script>
