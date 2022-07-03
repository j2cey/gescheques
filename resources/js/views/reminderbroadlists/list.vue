<template>
    <div id="broadlistlist">

        <Criterion v-for="(broadlist, index) in broadlists" :key="broadlist.id" :broadlist_prop="broadlist" :object_prop="object" :objecttype_prop="objecttype" :index_prop="index"></Criterion>

    </div>
</template>

<script>
    import CriterionBus from "../reminderbroadlists/broadlistsBus";

    export default {
        name: "broadlist-list",
        props: {
            object_prop: {},
            objecttype_prop: {},
            broadlists_prop: {}
        },
        components: {
            Criterion: () => import('../reminderbroadlists/item'),
        },
        mounted() {
            CriterionBus.$on('broadlist_created', (add_data) => {
                console.log('broadlist_created received from broadlistlist', add_data)
                if (this.object.uuid === add_data.object.uuid) {
                    this.createCriterion(add_data.broadlist)
                }
            })

            CriterionBus.$on('broadlist_deleted', (add_data) => {
                this.broadlists.splice(add_data.key, 1)
            })
        },
        data() {
            return {
                object: this.object_prop,
                objecttype: this.objecttype_prop,
                broadlists: this.broadlists_prop,
            };
        },
        methods: {
            createCriterion(broadlist) {
                let broadlistIndex = this.broadlists.findIndex(c => {
                    return broadlist.id === c.id
                })

                // if this broadlist doesn't exist yet, we add it to the list
                if (broadlistIndex === -1) {
                    this.broadlists.push(broadlist)
                }
            }
        }
    }
</script>

<style scoped>

</style>
