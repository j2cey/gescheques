<template>

</template>

<script>
    class Workflow {
        constructor(workflow) {
            this.titre = workflow.titre || ''
            this.description = workflow.description || ''
        }
    }
    export default {
        name: "fields",
        props: {
            workflow: {}
        },
        data() {
            return {
                campaign: {},
                campaignForm: new Form(new Campaign({})),
                campaignId: null,
                filename: 'Télécharger un fichier',
                editing: false,
                loading: false
            }
        },
    }
</script>

<style scoped>

</style>
