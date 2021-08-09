<template>
    <div class="card collapsed-card">
        <div class="card-header">
            <h5 class="card-title">{{ list_title ? list_title : 'Statuses' }}</h5>

            <div class="card-tools">

                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-plus"></i>
                </button>
                <div class="btn-group">
                    <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                        <i class="fas fa-wrench"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                        <a href="#" class="dropdown-item">Action</a>
                        <a href="#" class="dropdown-item">Another action</a>
                        <a href="#" class="dropdown-item">Something else here</a>
                        <a class="dropdown-divider"></a>
                        <a href="#" class="dropdown-item">Separated link</a>
                    </div>
                </div>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
            <table class="table table-head-fixed text-nowrap">
                <thead>
                <tr>
                    <th>
                        <div class="row">
                            <div class="col-sm-3 col-6"></div>
                            <div class="col-sm-3 col-6"></div>
                            <div class="col-sm-3 col-6"></div>
                            <div class="col-sm-3 col-6">
                                <div class="btn-group">
                                    <div class="btn-group">
                                        <div class="input-group input-group-sm">
                                            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search" v-model="searchStatuses">
                                            <div class="input-group-append">
                                                <button class="btn btn-navbar" type="submit">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 col-6">
                                <span class="text text-sm">Name</span>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-2 col-6">
                                <span class="text text-sm">Code</span>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-2 col-6">
                                <span class="text text-sm">Description</span>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3 col-6">
                                <span class="text text-sm text-center">Is Default</span>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-2 col-6">
                                <span class="text text-sm text-center"></span>
                            </div>

                        </div>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(status, index) in filteredStatuses" v-if="statuses" :key="status.id" class="text text-xs">
                    <td v-if="index < 10">
                        <StatusItem :status_prop="status"></StatusItem>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <!-- ./card-body -->
        <div class="card-footer">

        </div>
        <!-- /.card-footer -->
        <StatusAddUpdate></StatusAddUpdate>
    </div>
    <!-- /.card -->
</template>

<script>

    export default {
        name: "status-item-list",
        props: {
            list_title_prop: null,
            statuses_prop: {},
        },
        components: {
            StatusItem: () => import('./item'),
            StatusAddUpdate: () => import('./addupdate')
        },
        data() {
            return {
                list_title: this.list_title_prop,
                statuses: this.statuses_prop,
                searchStatuses: null,
            };
        },
        methods: {
        },
        computed: {
            filteredStatuses() {

                let tempStatuses = this.statuses

                if (this.searchStatuses !== '' && this.searchStatuses) {
                    tempStatuses = tempStatuses.filter((item) => {
                        return item.name
                            .toUpperCase()
                            .includes(this.searchStatuses.toUpperCase())
                    })
                }

                // Sorting
                tempStatuses = tempStatuses.sort((a, b) => {
                    let fa = a.name.toLowerCase(), fb = b.name.toLowerCase()

                    if (fa > fb) {
                        return -1
                    }
                    if (fa < fb) {
                        return 1
                    }
                    return 0
                })

                if (!this.ascending) {
                    tempStatuses.reverse()
                }
                // end Sorting

                return tempStatuses
            }
        }
    }
</script>

<style scoped>

</style>
