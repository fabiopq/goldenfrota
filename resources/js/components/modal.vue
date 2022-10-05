<template>
    <transition name="modal-fade">
        <div class="modal fade" id="confirmDelete" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title"><strong>{{this.modalTitle}}</strong></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p>
                  {{ this.modalText }}                  
                </p>
                <slot></slot>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" id="confirm" @click="confirm">Remover</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" @click="cancel">Cancelar</button>        
              </div>
            </div>
          </div>
        </div>
    </transition>
</template>

<script>
import SaldoTanques from './dashboard/SaldoTanques.vue';
  export default {
    name: "modal",
    methods: {
        cancel() {
            this.$emit(this._eventCancel);
        },
        confirm() {
            this.$emit(this._eventConfirm);
        }
    },
    props: [
        "modalTitle",
        "modalText",
        "eventCancel",
        "eventConfirm"
    ],
    computed: {
        _eventCancel: {
            get() {
                if (this.eventCancel == undefined) {
                    return "cancel";
                }
                else {
                    return this.eventCancel;
                }
            }
        },
        _eventConfirm: {
            get() {
                if (this.eventConfirm == undefined) {
                    return "confirm";
                }
                else {
                    return this.eventConfirm;
                }
            }
        }
    },
    mounted() {
        //
    },
    components: { SaldoTanques }
};
</script>