<template>
    <div>
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-md-6">
                    <div class="row mb-3">
                       
                        <div class="col col-md-6">
                            <transition name="fade" mode="in-out" appear>
                                <card-info :card-type="'primary'">
                                    <template slot="card-icon">
                                        <i class="fas fa-gas-pump fa-4x"></i>
                                    </template>
                                    <template slot="card-title">Abastecimentos</template>
                                    <template slot="card-body">{{ numAbastecimentosDia }}</template>
                                    <template slot="card-footer">
                                        <a href="/abastecimento" class="text-info">
                                            <i class="fas fa-link"></i> Acessar
                                        </a>
                                    </template>
                                </card-info>
                            </transition>
                        </div>
                       
                        <div class="col col-md-6">
                            <transition name="fade" mode="in-out" appear>
                                <card-info :card-type="'success'">
                                    <template slot="card-icon">
                                        <i class="fas fa-car fa-4x"></i>
                                    </template>
                                    <template slot="card-title">Veículos na Frota</template>
                                    <template slot="card-body">{{ numVeiculosFrota }}</template>
                                    <template slot="card-footer">
                                        <a href="/veiculo" class="text-info">
                                            <i class="fas fa-link"></i> Acessar
                                        </a>
                                    </template>
                                </card-info>

                            </transition>
                        </div>

                        <div class="col col-md-6">
                            <transition name="fade" mode="in-out" appear>
                                <card-info :card-type="'warning'">
                                    <template slot="card-icon">
                                        <i class="fas fa-user-friends fa-4x"></i>
                                    </template>
                                    <template slot="card-title">Clientes</template>
                                    <template slot="card-body">{{ numClientes }}</template>
                                    <template slot="card-footer">
                                        <a href="/cliente" class="text-info">
                                            <i class="fas fa-link"></i> Acessar
                                        </a>
                                    </template>
                                </card-info>

                            </transition>
                        </div>
                        <div class="col col-md-6">
                            <transition name="fade" mode="in-out" appear>
                                <card-info :card-type="'danger'">
                                    <template slot="card-icon">
                                        <i class="fas fa-user-shield fa-4x"></i>
                                    </template>
                                    <template slot="card-title">Motoristas</template>
                                    <template slot="card-body">{{ numClientes }}</template>
                                    <template slot="card-footer">
                                        <a href="/cliente" class="text-info">
                                            <i class="fas fa-link"></i> Acessar
                                        </a>
                                    </template>
                                </card-info>

                            </transition>
                        </div>
                    </div>
                    <div class="card bg-light text-dark">
                        <div class="card-header">Saldo dos Tanques
                            <div class="float-right text-info">
                                <a href="/entrada_tanque">
                                    <i class="fas fa-link"></i>
                                    Acessar
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <transition name="fade" mode="in-out" appear>
                                <saldo-tanque></saldo-tanque>
                            </transition>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-light text-dark">
                        <div class="card-header">Movimentação de Combustíveis (Últimos 15 dias)</div>
                        <div class="card-body">
                            <mov-tanque></mov-tanque>
                        </div>
                    </div>
                    
                    <div class="card bg-light text-dark mt-3">
                        <div class="card-header">Últimas entradas de Combustíveis
                            <div class="float-right text-info">
                                <a href="/entrada_tanque">
                                    <i class="fas fa-link"></i>
                                    Acessar
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <transition name="fade" mode="in-out" appear>
                                <ultimas-entradas-comb></ultimas-entradas-comb>
                            </transition>
                        </div>
                    </div>
                    <div class="card bg-light text-dark mt-3">
                        <div class="card-header">Ordens de Serviço em Aberto
                            <div class="float-right text-info">
                                <a href="/ordem_servico">
                                    <i class="fas fa-link"></i>
                                    Acessar
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <transition name="fade" mode="in-out" appear>
                                <os-em-aberto></os-em-aberto>
                            </transition>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>

</style>


<style>
.card-body {
    padding: 0 !important;
}

.fade-leave-active,
.fade-enter-active {
    transition: 0.4s ease;
    opacity: 1;
}

.fade-enter,
.fade-leave-to {
    opacity: 0;
}

.card-stats {
    .card-body {
        padding: 15px 15px 0px;

        .numbers {
            font-size: 1.8rem;
            text-align: right;

            p {
                margin-bottom: 0;
            }
        }
    }

    .card-footer {
        padding: 0px 15px 10px 15px;
    }

    .icon-big {
        font-size: 3em;
        min-height: 64px;

        i {
            line-height: 59px;
        }
    }
}
</style>


<script>
import Axios from "axios";
import MovTanque from "./dashboard/MovTanque";
import UltimasEntradasComb from "./dashboard/UltimasEntradasComb";
import SaldoTanques from "./dashboard/SaldoTanques";
import CardInfo from "./dashboard/CardInfo";
import OsEmAberto from './dashboard/OsEmAberto';

export default {
    components: {
        "saldo-tanque": SaldoTanques,
        "mov-tanque": MovTanque,
        "ultimas-entradas-comb": UltimasEntradasComb,
        "card-info": CardInfo,
        "os-em-aberto": OsEmAberto
    },
    data() {
        return {
            numVeiculosFrota: 0,
            numAbastecimentosDia: 0,
            numClientes: 0
        };
    },
    async mounted() {
        this.getNumVeiculosFrota();
        this.getAbastecimentosDia();
        this.getNumClientes();
    },
    methods: {
        getNumVeiculosFrota() {
            Axios.get("/dashboard/total_veiculos_frota")
                .then(async r => {
                    this.numVeiculosFrota = r.data.total_veiculos_frota;
                })
                .catch(e => {
                    console.log(e);
                });
        },
        getAbastecimentosDia() {
            Axios.get('/dashboard/abastecimentos_hoje')
                .then(r => {
                    this.numAbastecimentosDia = r.data.abastecimentos_hoje;
                })
                .catch(e => {
                    console.log(e);
                });
        },
        getNumClientes() {
            Axios.get('/dashboard/clientes_cadastrados')
                .then(r => {
                    this.numClientes = r.data.clientes_cadastrados;
                })
                .catch(e => {
                    console.log(e);
                });
        }
    }
};
</script>
