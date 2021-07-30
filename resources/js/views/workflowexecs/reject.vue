<template>
    <div class="modal fade" id="rejectStep" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg card card-outline card-danger">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <span class="username text-sm text-orange">Rejéter cette étape</span>
                    </h5>
                    <button type="button" class="close" @click="closeForm()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" @submit.prevent>
                        <div class="card-body">

                            <div class="form-group row">
                                <label for="motif" class="col-sm-2 col-form-label">Motif Réjet</label>
                                <div class="col-sm-10" v-if="rejectaction && enumvalues">
                                    <multiselect
                                        :id="execId"
                                        v-model="motif"
                                        selected.sync="motif"
                                        value=""
                                        :options="enumvalues[rejectaction.code]"
                                        :searchable="true"
                                        :multiple="false"
                                        label="val"
                                        track-by="val"
                                        key="val"
                                        :placeholder="rejectaction.titre"
                                    >
                                    </multiselect>
                                </div>
                                <div class="col-sm-10" v-else>
                                    <input type="text" class="form-control" id="motif" name="motif" required autocomplete="titre" autofocus placeholder="Motif" v-model="motif">
                                    <span class="invalid-feedback d-block" role="alert" v-if="!isValidForm" text="Veuillez Renseigner le Motif"></span>
                                </div>
                            </div>

                        </div>
                    </form>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary btn-sm" @click="closeForm()">Fermer</button>
                    <button type="button" class="btn btn-danger btn-sm" @click="validateForm(execId, motif)" :disabled="!isValidForm">Valider</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'

    export default {
        name: "reject",
        props: {
        },
        components: { Multiselect },
        mounted() {
            this.$parent.$on('validate_reject', (data) => {
                console.log("validate_reject received", data) //, rejectaction, enumvalues
                this.execId = data.execId
                this.motif = null;
                this.enumvalues = data.enumvalues;
                this.rejectaction = data.rejectaction;
                $('#rejectStep').modal()
            })
        },
        created() {
        },
        data() {
            return {
                execId: null,
                motif: null,
                enumvalues: null,
                rejectaction: null
            }
        },
        methods: {
            validateForm(execId, raw_motif) {
                let motif = raw_motif
                if (this.rejectaction && this.enumvalues) {
                    motif = raw_motif.val
                }
                console.log('final_motif',motif,raw_motif)
                this.$parent.$emit('reject_validated', {execId, motif})
                $('#rejectStep').modal('hide')
            },
            closeForm() {
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
