<template>

    <div id="actionlist">

        <WorkflowAction v-for="(workflowaction, index) in workflowactions" :key="workflowaction.id" :workflowaction_prop="workflowaction" :index_prop="index"></WorkflowAction>

    </div>

</template>

<script>
    import ActionBus from "./actionBus";

    export default {
        name: "actions-list",
        props: {
            workflowstepid_prop: 0,
            workflowactions_prop: {}
        },
        components: {
            WorkflowAction: () => import('../workflowactions/item'),
        },
        mounted() {
            ActionBus.$on('workflowaction_created', (add_data) => {
                console.log('workflowaction_created received from actionlist', add_data)
                if (this.workflowstepId === add_data.step.id) {
                    this.createAction(add_data.action)
                }
            })

            ActionBus.$on('workflowaction_deleted', (add_data) => {
                this.workflowactions.splice(add_data.key, 1)
            })
        },
        data() {
            return {
                workflowstepId: this.workflowstepid_prop,
                workflowactions: this.workflowactions_prop,
            };
        },
        methods: {
            createAction(workflowaction) {
                let workflowactionIndex = this.workflowactions.findIndex(c => {
                    return workflowaction.id === c.id
                })

                // si cette action n'existe pas déjà, on l'insère dans la liste
                if (workflowactionIndex === -1) {
                    this.workflowactions.push(workflowaction)
                }
            }
        }
    }
</script>

<style scoped>

</style>
