<template>
    <div class="card">
        <header>
            <div class="card-header-title row">
                <div class="col-md-6 col-sm-9 col-12">
                    <span class="text-indigo text-xs" @click="collapseClicked()" data-toggle="collapse" data-parent="#broadlistlist" :href="'#collapse-broadlists-'+index">
                        {{ broadlist.title }}
                    </span>
                </div>
                <div class="col-md-6 col-sm-3 col-12 text-right">
                    <span class="text text-xs">
                        <a type="button" class="btn btn-tool text-warning" data-toggle="tooltip" @click="editBroadlist(broadlist)">
                            <i class="fa fa-pencil-square-o"></i>
                        </a>
                        <a type="button" class="btn btn-tool" @click="collapseClicked()" data-toggle="collapse" data-parent="#broadlistlist" :href="'#collapse-broadlists-'+index">
                            <i :class="currentCollapseIcon"></i>
                        </a>
                        <a type="button" class="btn btn-tool text-danger" @click="deleteBroadlist(broadlist.uuid, index)">
                            <i class="fa fa-trash"></i>
                        </a>
                    </span>
                </div>
            </div>
            <!-- /.user-block -->
        </header>
        <!-- /.card-header -->
        <div :id="'collapse-broadlists-'+index" class="card-content panel-collapse collapse in">
            <dl class="row">
                <dt class="col-sm-4 text-xs">Description</dt>
                <dd class="col-sm-8 text-xs">{{ broadlist.description }}</dd>
                <dt class="col-sm-4 text-xs" v-if="broadlist.status">Statut</dt>
                <dd class="col-sm-8 text-xs" v-if="broadlist.status">
                    <b-tag type="is-success is-light" v-if="broadlist.status.code === 'active'">{{ broadlist.status.name }}</b-tag>
                    <b-tag type="is-danger is-light" v-else>{{ broadlist.status.name }}</b-tag>
                </dd>
            </dl>
        </div>
        <!-- /.card-body -->
    </div>
</template>

<script>
    import BroadlistBus from "../reminderbroadlists/broadlistsBus";

    export default {
        name: "broadlist-item",
        props: {
            broadlist_prop: {},
            object_prop: {}, // object (reminder or reminderObject)
            objecttype_prop: {},
            index_prop: {}
        },
        components: {
        },
        mounted() {
            BroadlistBus.$on('broadlist_updated', (upd_data) => {
                if (this.broadlist.id === upd_data.broadlist.id) {
                    this.updateEnumValue(upd_data.broadlist)
                }
            })
        },
        data() {
            return {
                broadlist: this.broadlist_prop,
                object: this.object_prop,
                objecttype: this.objecttype_prop,
                index: this.index_prop,
                collapse_icon: 'fas fa-chevron-down',
                isOpen: true
            }
        },
        methods: {
            editBroadlist(broadlist) {
                let object = this.object
                let objecttype = this.objecttype
                BroadlistBus.$emit('broadlist_edit', {object, objecttype, broadlist});
            },
            updateEnumValue(broadlist) {
                this.broadlist = broadlist
            },
            deleteBroadlist(id, key) {
                this.$swal({
                    html: '<small>Are sure you want to delete ?</small>',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oui',
                    cancelButtonText: 'Non'
                }).then((result) => {
                    if(result.value) {

                        axios.delete(`/reminderbroadlists/${id}`)
                            .then(resp => {

                                let broadlist = resp.data.broadlist
                                let object = resp.data.object

                                console.log('broadlists delete resp: ', resp)

                                this.$swal({
                                    html: '<small>Broadcast List successfully deleted !</small>',
                                    icon: 'success',
                                    timer: 3000
                                }).then(() => {
                                    BroadlistBus.$emit('broadlist_deleted', {key, broadlist, object})
                                })
                            }).catch(error => {
                            window.handleErrors(error)
                        })

                    } else {
                        // stay here
                    }
                })
            },
            collapseClicked() {
                if (this.collapse_icon === 'fas fa-chevron-down') {
                    this.collapse_icon = 'fas fa-chevron-up';
                } else {
                    this.collapse_icon = 'fas fa-chevron-down';
                }
            }
        },
        computed: {
            currentCollapseIcon() {
                return this.collapse_icon;
            }
        }
    }
</script>

<style scoped>

</style>
