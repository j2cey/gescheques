<template>
    <div class="container">
        <h1 class="text text-sm"><strong>{{ workflow.titre }}</strong></h1>
        <h5 class="text text-xs">
            Design & Organisation des Principales Articulations.
        </h5>
        <div id="toolbar">
            <b-button size="is-small" type="is-primary is-light"
                @click="
                $refs.chart.add({
                    id: +new Date(),
                    x: 10,
                    y: 10,
                    name: 'New',
                    type: 'operation',
                    description: '',
                    code: '',
                    staticapprovers: [],
                    })"
            >
                Ajouter(double-click canevas)
            </b-button>
            <b-button size="is-small" type="is-danger is-light" @click="$refs.chart.remove()">Supprimer(suppr.)</b-button>
            <b-button size="is-small" type="is-warning is-light" @click="$refs.chart.editCurrent()">
                Modifier(double-click noeud)
            </b-button>
            <b-button size="is-small" type="is-success is-light" @click="$refs.chart.save()">Enregistrer</b-button>
        </div>
        <flowchart
            :nodes="nodes"
            :connections="connections"
            @editnode="handleEditNode"
            :width="'100%'"
            :height="600"
            :readonly="false"
            @dblclick="handleDblClick"
            @editconnection="handleEditConnection"
            @save="handleChartSave"
            @select="handleSelect"
            ref="chart"
            :render="render"
        >
        </flowchart>
        <node-dialog
            :visible.sync="nodeDialogVisible"
            :node.sync="nodeForm.target"
            :approverslist_prop="approverslist"
        ></node-dialog>
        <connection-dialog
            :visible.sync="connectionDialogVisible"
            :connection.sync="connectionForm.target"
            :operation="connectionForm.operation"
        >
        </connection-dialog>
    </div>
</template>

<script>
    /* eslint-disable no-unused-vars */
    import ConnectionDialog from "./components/ConnectionDialog";
    import NodeDialog from "./components/NodeDialog";
    import Flowchart from "./components/flowchart/Flowchart";
    import * as d3 from "d3";
    import { roundTo20 } from "./utils/math";

    export default {
        name: "index",
        props: {
            workflow_prop: {
                type: Object,
                default: null,
            },
            nodes_prop: [],
            connections_prop: [],
            approverslist_prop: [],
        },
        components: {
            ConnectionDialog,
            NodeDialog,
            Flowchart,
        },
        data: function () {
            return {
                workflow: this.workflow_prop,
                nodes: this.nodes_prop,
                connections: this.connections_prop,
                approverslist: this.approverslist_prop,
                nodeForm: { target: null },
                connectionForm: { target: null, operation: null },
                nodeDialogVisible: false,
                connectionDialogVisible: false,
            };
        },
        async mounted() {},
        methods: {
            handleDblClick(position) {
                this.$refs.chart.add({
                    id: +new Date(),
                    x: position.x,
                    y: position.y,
                    name: "New",
                    type: "operation",
                    staticapprovers: [],
                });
            },
            handleSelect(nodes) {
                // console.log(nodes);
            },
            async handleChartSave(nodes, connections) {
                axios.post('/workflows.storeflowchart/' + this.workflow.uuid, {nodes, connections}).then(resp => {
                  this.nodes = resp.data.nodes;
                  this.connections = resp.data.connections;
                  console.log(resp)
                  // Flowchart will refresh after this.nodes and this.connections changed
                });
            },
            handleEditNode(node) {
                console.log(node)
                node.role_type = (node.role_static ? 'role_static' : (node.role_dynamic ? 'role_dynamic' : (node.role_previous ? 'role_previous' : 'role_static' ) ) ) || 'undefied'
                this.nodeForm.target = node;
                this.nodeDialogVisible = true;
            },
            handleEditConnection(connection) {
                this.connectionForm.target = connection;
                this.connectionDialogVisible = true;
            },
            render: function (g, node, isSelected) {
                if (node.type === "start" && node.type === "end") {
                    node.width = node.width || 100;
                    node.height = node.height || 20;
                } else {
                    node.width = node.width || 180;
                    node.height = node.height || 60;
                }
                let borderColor = isSelected ? "#666666" : "#bbbbbb";
                if (node.type !== "start" && node.type !== "end") {
                    // title
                    g.append("rect")
                        .attr("x", node.x)
                        .attr("y", node.y)
                        .attr("stroke", borderColor)
                        .attr("class", "title")
                        .style("height", "20px")
                        .style("fill", "#f1f3f4")
                        .style("stroke-width", "1px")
                        .style("width", node.width + "px");
                    g.append("text")
                        .attr("x", node.x + 4)
                        .attr("y", node.y + 15)
                        .attr("class", "unselectable")
                        .text(() => node.name)
                        .each(function wrap() {
                            let self = d3.select(this),
                                textLength = self.node().getComputedTextLength(),
                                text = self.text();
                            while (textLength > node.width - 2 * 4 && text.length > 0) {
                                text = text.slice(0, -1);
                                self.text(text + "...");
                                textLength = self.node().getComputedTextLength();
                            }
                        });
                }
                // body
                if (node.id === -1) { // node ellipse
                    let body = g.append("ellipse").attr("class", "body");
                    body.attr("cx", node.x + node.width / 2);
                    body.attr("cy", node.y + node.height / 2);
                    body.attr("rx", node.width / 2);
                    body.attr("ry", node.height / 2);
                    body.style("fill", "white");
                    body.style("stroke-width", "1px");
                    body.classed(node.type, true);
                    body.attr("stroke", borderColor);
                } else {
                    let body = g.append("rect").attr("class", "body");
                    body
                        .style("width", node.width + "px")
                        .style("fill", "white")
                        .style("stroke-width", "1px");
                    if (node.type !== "start" && node.type !== "end") {
                        body.attr("x", node.x).attr("y", node.y + 20);
                        body.style("height", roundTo20(node.height - 20) + "px");
                    } else {
                        body
                            .attr("x", node.x)
                            .attr("y", node.y)
                            .classed(node.type, true)
                            .attr("rx", 30);
                        body.style("height", roundTo20(node.height) + "px");
                    }
                    body.attr("stroke", borderColor);
                }
                // body text
                let text =
                    node.type === "start"
                        ? "Début"
                        : node.type === "end"
                        ? "Fin"
                        : !node.staticapprovers || node.staticapprovers.length === 0
                            ? ""
                            : node.staticapprovers.length > 1
                                ? `${node.staticapprovers[0].name + "..."}`
                                : node.staticapprovers[0].name;
                let bodyTextY;
                if (node.type !== "start" && node.type !== "end") {
                    if (node.id === -1) { // node ellipse
                        bodyTextY = node.y + 25;
                    } else {
                        bodyTextY = node.y + 25 + roundTo20(node.height - 20) / 2;
                    }
                } else {
                    bodyTextY = node.y + 5 + roundTo20(node.height) / 2;
                }
                g.append("text")
                    .attr("x", node.x + node.width / 2)
                    .attr("y", bodyTextY)
                    .attr("class", "unselectable")
                    .attr("text-anchor", "middle")
                    .text(function () {
                        return text;
                    })
                    .each(function wrap() {
                        let self = d3.select(this),
                            textLength = self.node().getComputedTextLength(),
                            text = self.text();
                        while (textLength > node.width - 2 * 4 && text.length > 0) {
                            text = text.slice(0, -1);
                            self.text(text + "...");
                            textLength = self.node().getComputedTextLength();
                        }
                    });
            },
        },
    };
</script>
<style scoped>
    #toolbar {
        margin-bottom: 10px;
    }
    .title {
        margin-top: 10px;
        margin-bottom: 0;
        font-size: 20px;
    }
    .subtitle {
        margin-bottom: 10px;
        font-size: 15px;
    }
    #toolbar > button {
        margin-right: 4px;
    }
    .container {
        width: 1000px;
        margin: auto;
    }
</style>
