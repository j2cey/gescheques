<template>
    <VueMermaid
        :nodes="data"
        type="graph LR"
        @nodeClick="editNode"
    ></VueMermaid>
</template>

<script>
    import VueMermaid from "vue-mermaid/src/vue-mermaid";

    export default {
        name: "mermaid-test",
        components: {
            VueMermaid
        },
        data: function() {
            return {
                data: [
                    {
                        id: "1",
                        text: "A",
                        link: "---",
                        next: ["2"],
                        group: "one"
                    },
                    { id: "2", text: "B", edgeType: "circle", next: ["3"], group: "one" },
                    { id: "3", text: "C", next: ["4", "6"], group: "two" },
                    {
                        id: "4",
                        text: "D",
                        link: "-- This is the text ---",
                        next: ["5"],
                        group: "two"
                    },
                    { id: "5", text: "E", group: "three" },
                    { id: "6", text: "F", group: "three", url: "http://www.github.com" }
                    ]
            };
        },
        methods: {
            editNode(nodeId) {
                alert(nodeId);
            }
        }
    }
</script>

<style scoped>

</style>
