<template>
    <div class="container-fluid" id="flowchartcard">
        <WorkflowChart
            :style="size"
            :transitions="transitions_prop"
            :states="states_prop"
            :stateSemantics="stateSemantics"
            :orientation="'vertical'"
            @state-click="onLabelClicked('state',$event)"
            @transition-click="onLabelClicked('transition', $event)"
            @size-change="sizeChanged" />
    </div>
</template>

<script>
    import WorkflowChart from 'vue-workflow-chart';

    import WorkflowBus from "./workflowBus";

    export default {
        name: "flowchart",
        props: {
            workflow_id_prop: {},
            states_prop: {},
            transitions_prop: {},
            statesemantics_prop: {}
        },
        components: {
            WorkflowChart
        },
        created() {

            /*axios.get(`/workflows.fetchflowchart/${this.workflow_id_prop}`)
                .then(resp => {
                    console.log('fetchflowchart flowchart: ', resp.data)
                    this.states = JSON.parse(resp.data.states)
                    this.transitions = JSON.parse(resp.data.transitions)

                });*/

            const approveLabel = state => state.label === 'Released';
            const semantic = item => ({ id: item.id, classname: 'approve' });
            const approvedState = this.states_prop.filter(approveLabel).map(semantic);
            this.stateSemantics = [ ...this.statesemantics_prop, ...approvedState ];
        },
        data: () => ({
            workflow_id: null,

            states: [{
                "id": "J4zloua",
                "label": "Auditing",
            }, {
                "id": "Jcxrmx",
                "label": "Released",
            }, {
                "id": "Tu2vqbl",
                "label": "Verification by responsible",
            }, {
                "id": "static_state_deleted",
                "label": "Deleted",
            }, {
                "id": "static_state_new",
                "label": "New",
            }],
            transitions: [{
                "id": "Dz2un1r",
                "label": "ask for auditing",
                "target": "J4zloua",
                "source": "Tu2vqbl",
            }, {
                "id": "Ev0huzn",
                "label": "restore",
                "target": "static_state_new",
                "source": "static_state_deleted",
            }, {
                "id": "Fst7op",
                "label": "release",
                "target": "Jcxrmx",
                "source": "Tu2vqbl",
            }, {
                "id": "Lwed6qb",
                "label": "discard draft",
                "target": "static_state_deleted",
                "source": "Tu2vqbl",
            }, {
                "id": "Mmpn8w",
                "label": "discard request",
                "target": "static_state_deleted",
                "source": "J4zloua",
            }, {
                "id": "Qw136br",
                "label": "delete",
                "target": "static_state_deleted",
                "source": "Jcxrmx",
            }, {
                "id": "Stf8g2b",
                "label": "revise request",
                "target": "J4zloua",
                "source": "static_state_new",
            }, {
                "id": "Tznk4f5",
                "label": "start new revision",
                "target": "J4zloua",
                "source": "Jcxrmx",
            }, {
                "id": "Usvtzqi",
                "label": "release revision",
                "target": "Tu2vqbl",
                "source": "J4zloua",
            }],
            stateSemantics: [],
            size: { width: '0px', height: '0px' },
        }),
        computed: {
        },
        mounted () {
            WorkflowBus.$on('show_flowchart', (workflow) => {
                if (this.workflow_id_prop === workflow.id) {
                    $('#flochartmodal').modal()
                }
            })
        },
        methods: {
            onLabelClicked(type, id) {
                /*alert(`Clicked on ${type} with id: ${id}`);*/
            },
            sizeChanged(size) {
                this.size = {
                    width: `${size.width}px`,
                    height: `${size.height}px`,
                };
            },
        }
    }
</script>

<style lang="scss" scoped>
    @import '~vue-workflow-chart/dist/vue-workflow-chart.css';
    $approve-color: #1eb2a4;
    $delete-color: #d64b61;
    .vue-workflow-chart-state {
        &-approve {
            color: white;
            background: $approve-color;
            font-family: Arial,sans-serif;
            font-size: x-small;
        }
        &-delete {
            color: white;
            background: $delete-color;
            font-family: Arial,sans-serif;
            font-size: x-small;
        }
    }
    .vue-workflow-chart-transition-arrow {
        &-approve {
            fill: $approve-color;
        }
        &-delete {
            fill: $delete-color;
        }
    }
    .vue-workflow-chart-transition-path {
        &-approve {
            stroke: $approve-color;
            font-family: Consolas,sans-serif;
            font-size: x-small;
        }
        &-delete {
            stroke: $delete-color;
            font-family: Consolas,sans-serif;
            font-size: x-small;
        }
    }

    #app {
        display: flex;
        justify-content: center;
        padding-top: 10px;
    }
</style>
<style lang="scss" scoped>
    #app {
        display: flex;
        justify-content: center;
        padding-top: 100px;
    }
</style>
