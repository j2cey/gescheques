<template>
    <div id="enumvaluelist">

        <EnumValue v-for="(enumvalue, index) in enumvalues" :key="enumvalue.id" :enumvalue_prop="enumvalue" :index_prop="index"></EnumValue>

    </div>
</template>

<script>
    import EnumValueBus from "../enumvalues/enumvalueBus";

    export default {
        name: "enumvalue-list",
        props: {
            enumtypeid_prop: 0,
            enumvalues_prop: {}
        },
        components: {
            EnumValue: () => import('../enumvalues/item'),
        },
        mounted() {
            EnumValueBus.$on('enumvalue_created', (add_data) => {
                console.log('enumvalue_created received from enumvaluelist', add_data)
                if (this.enumtypeId === add_data.enumtype.id) {
                    this.createEnumValue(add_data.enumvalue)
                }
            })

            EnumValueBus.$on('enumvalue_deleted', (add_data) => {
                this.enumvalues.splice(add_data.key, 1)
            })
        },
        data() {
            return {
                enumtypeId: this.enumtypeid_prop,
                enumvalues: this.enumvalues_prop,
            };
        },
        methods: {
            createEnumValue(enumvalue) {
                let enumvalueIndex = this.enumvalues.findIndex(c => {
                    return enumvalue.id === c.id
                })

                // si cette valeur n'existe pas déjà, on l'insère dans la liste
                if (enumvalueIndex === -1) {
                    this.enumvalues.push(enumvalue)
                }
            }
        }
    }
</script>

<style scoped>

</style>
