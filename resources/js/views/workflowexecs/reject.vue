<template>
    <div class="modal fade" id="rejectStep" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Rejéter cette étape</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" @submit.prevent>
                        <div class="card-body">

                            <div class="form-group row">
                                <label for="motif" class="col-sm-2 col-form-label">Motif Réjet</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="motif" name="motif" required autocomplete="titre" autofocus placeholder="Motif" v-model="motif">
                                    <span class="invalid-feedback d-block" role="alert" v-if="!isValidForm" text="Veuillez Renseigner le Motif"></span>
                                </div>
                            </div>

                        </div>
                    </form>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-danger" @click="validateForm()" :disabled="!isValidForm">Valider</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>
    export default {
        name: "reject",
        props: {
        },
        components: {},
        mounted() {
            this.$parent.$on('validate_reject', () => {
                this.motif = null;
                $('#rejectStep').modal()
            })
        },
        created() {
        },
        data() {
            return {
                motif: null
            }
        },
        methods: {
            validateForm() {
                this.$parent.$emit('reject_validated', this.motif)
                $('#rejectStep').modal('hide')
            }
        },
        computed: {
            isValidForm() {
                return this.motif && this.motif !== "null"
            }
        }
    }
</script>
