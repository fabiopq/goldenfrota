<template>
    <div class="table-responsive m-0 p-0">
        <table class="table table-sm table-bordered table-hover m-0">
            <thead class="thead-light">
                <tr class="row m-0">
                    <th class="col-1">ID</th>
                    <th class="col-3">Tanque</th>
                    <th class="col-2">Capacidade</th>
                    <th class="col-2">Estoque Inicial</th>
                    <th class="col-2">Estoque Atual</th>
                    <th class="col-2"></th>

                </tr>
            </thead>
            <tbody name="fade" is="transition-group">
                <tr class="row m-0" v-for="(tanque, index) in tanques" :key="index">
                    <td class="col-1 pool-right">{{ tanque.id}}</td>
                    <td class="col-3 pool-right">{{ tanque.descricao_tanque}}</td>
                    <td class="col-2 text-right">{{ tanque.capacidade }}</td>
                    <td class="col-2 text-right">{{ tanque.posicao }}</td>
                    <td class="col-2 text-right">{{ tanque.posicao }}</td>
                    <td class="col-2 text-right"></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>


<script>
import Axios from "axios";

export default {
    data() {
        return {
            tanques: []
        };
    },
    mounted() {
        Axios.get("dashboard/saldo_tanques")
            .then(r => {
                this.tanques = r.data;
            })
            .catch(e => {
                console.log(e);
            });
    }
};
</script>
