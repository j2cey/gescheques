<template>
    <div id="criterionlist">

        <Criterion v-for="(criterion, index) in criteria" :key="criterion.id" :criterion_prop="criterion" :reminder_prop="reminder" :index_prop="index"></Criterion>

    </div>
</template>

<script>
    import CriterionBus from "../remindercriteria/remindercriteriaBus";

    export default {
        name: "remindercritera-list",
        props: {
            reminder_prop: {},
            criteria_prop: {}
        },
        components: {
            Criterion: () => import('../remindercriteria/item'),
        },
        mounted() {
            CriterionBus.$on('criterion_created', (add_data) => {
                console.log('criterion_created received from criterionlist', add_data)
                if (this.reminder.id === add_data.reminder.id) {
                    this.createCriterion(add_data.criterion)
                }
            })

            CriterionBus.$on('criterion_deleted', (add_data) => {
                this.criteria.splice(add_data.key, 1)
            })
        },
        data() {
            return {
                reminder: this.reminder_prop,
                criteria: this.criteria_prop,
            };
        },
        methods: {
            createCriterion(criterion) {
                let criterionIndex = this.criteria.findIndex(c => {
                    return criterion.id === c.id
                })

                // if this criterion doesn't exist yet, we add it to the list
                if (criterionIndex === -1) {
                    this.criteria.push(criterion)
                }
            }
        }
    }
</script>

<style scoped>

</style>
