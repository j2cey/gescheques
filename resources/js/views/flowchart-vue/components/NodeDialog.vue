<template>
    <div>
        <div id="nodeDialogModal" class="flwch-modal" v-if="visible" style="width: 320px">
            <div class="flwch-header">
                <span>Modification Etape</span>
            </div>
            <div class="flwch-body">
                <label for="name">Titre</label>
                <input class="form-control" id="name" v-model="nodeForm.name"/>
                <label for="name">Description</label>
                <input class="form-control" id="description" v-model="nodeForm.description"/>
                <label for="type">Type</label>
                <select class="flwch-form-control" id="type" v-model="nodeForm.type">
                    <option :key="'node-type-' + item.id" :value="item.id"
                            v-for="item in [ { name: 'Start', id: 'start' }, { name: 'End', id: 'end' }, { name: 'Operation', id: 'operation' } ]"
                    >
                        {{item.name}}
                    </option>
                </select>
                <label for="approver">Profile Acteur</label>
                <multiselect
                    class="flwch-form-control"
                    id="approver"
                    v-model="nodeForm.approver"
                    selected.sync="nodeForm.approver"
                    value=""
                    :options="approvers"
                    :searchable="true"
                    :multiple="false"
                    @change="handleChangeApprover($event)"
                    label="name"
                    track-by="id"
                    key="id"
                    placeholder="Acteurs"
                >
                </multiselect>
            </div>
            <div class="flwch-footer">
                <button @click="handleClickCancelSaveNode">Annuler</button>
                <button @click="handleClickSaveNode">Ok</button>
            </div>
        </div>
    </div>
</template>

<script>
    import '../assets/modal.css';
    import Multiselect from 'vue-multiselect'
    import FlowchartBus from "../flowchartBus";

    export default {
        name: "NodeDialog",
        props: {
            visible: {
                type: Boolean,
                default: false,
            },
            node: {
                type: Object,
                default: null,
            },
            approvers_prop: {
                type: Array,
                default: null,
            },
        },
        components: { Multiselect },
        mounted() {
            FlowchartBus.$on('flowchart_node_edit', (node) => {
                console.log('flowchart_node_edit: ', node)
                this.my_visible = true
                //$('#nodeDialogModal').modal()
            })
        },
        data: function() {
            return {
                nodeForm: {name: null, description: null, code: null, id: null, type: null, approver: []},
                approvers: this.approvers_prop,
                my_visible: false
            };
        },
        methods: {
            handleClickSaveNode() {
                this.$emit('update:node', Object.assign(this.node, {
                    name: this.nodeForm.name,
                    description: this.nodeForm.description,
                    code: this.nodeForm.code ? this.nodeForm.code : "xxx",
                    type: this.nodeForm.type,
                    approvers: [Object.assign({}, this.nodeForm.approver)],
                }));
                this.$emit('update:visible', false);
            },
            handleClickCancelSaveNode() {
                this.$emit('update:visible', false);
            },
            handleChangeApprover(e) {
                if (e.target.value) {
                    this.nodeForm.approver = this.approvers.filter(i => i.id === parseInt(e.target.value))[0];
                } else {
                    this.nodeForm.approver = []
                }
            },
        },
        watch: {
            node: {
                immediate: true,
                handler(val) {
                    if (!val) { return; }
                    this.nodeForm.id = val.id;
                    this.nodeForm.name = val.name;
                    this.nodeForm.description = val.description;
                    this.nodeForm.code = val.code;
                    this.nodeForm.type = val.type;
                    if (val.approvers && val.approvers.length > 0) {
                        this.nodeForm.approver = val.approvers[0];
                    }
                },
            },
        },
    };
</script>

<style scoped>

</style>
