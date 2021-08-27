<template>
    <div>
        <div class="flwch-modal" v-if="visible" style="width: 320px">
            <div class="flwch-header">
                <span>Modification Transition</span>
            </div>
            <div class="flwch-body">
                <label for="name">Titre</label>
                <input id="name" class="flwch-form-control" v-model="connectionForm.name"/>
                <label for="type">Type</label>
                <select id="type" class="flwch-form-control" v-model="connectionForm.type">
                    <option :key="'connection-type-' + item.id"
                            v-for="item in [ { name: 'Pass', id: 'pass' }, { name: 'Reject', id: 'reject' }, { name: 'Allways', id: 'allways' }, { name: 'Expire', id: 'expire' } ]"
                            :value="item.id">
                        {{item.name}}
                    </option>
                </select>
            </div>
            <div class="flwch-footer">
                <button @click="handleClickCancelSaveConnection">Annuler</button>
                <button @click="handleClickSaveConnection">Ok</button>
            </div>
        </div>
    </div>
</template>

<script>
    import '../assets/modal.css';

    export default {
        name: "ConnectionDialog",
        props: {
            visible: {
                type: Boolean,
                default: false,
            },
            connection: {
                type: Object,
                default: null,
            },
        },
        data() {
            return {
                connectionForm: {
                    type: null,
                    sourceId: null,
                    sourcePosition: null,
                    destinationId: null,
                    destinationPosition: null,
                    name: null,
                    expression: null,
                    code: null,
                },
            };
        },
        methods: {
            async handleClickSaveConnection() {
                this.$emit('update:visible', false);
                this.$emit('update:connection', Object.assign(this.connection, {
                    name: this.connectionForm.name,
                    type: this.connectionForm.type,
                    code: this.connectionForm.code,
                    expression: this.connectionForm.expression,
                }));
            },
            async handleClickCancelSaveConnection() {
                this.$emit('update:visible', false);
            },
        },
        watch: {
            connection: {
                immediate: true,
                handler(val) {
                    if (!val) { return; }
                    this.connectionForm.id = val.id;
                    this.connectionForm.type = val.type;
                    this.connectionForm.name = val.name;
                    this.connectionForm.code = val.code;
                    this.connectionForm.expression = val.expression;
                },
            },
        },
    };
</script>

<style scoped>

</style>
