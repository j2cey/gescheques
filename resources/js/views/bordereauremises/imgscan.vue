<template>

    <div class="modal fade" id="imgDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div v-if="img_url" max-width="85vw">
                        <img :src="img_url" alt="" width="100%" @click.stop="img_url = null">
                        <hr>
                    </div>

                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>
    export default {
        name: "imgscan",
        props: {
        },
        data() {
            return {
                img_url: null,
            };
        },
        mounted() {
            this.$parent.$on('show_image', (img_url) => {

                this.img_url = '/uploads/bordereauremises/scans/' + img_url

                $('#imgDetail').modal()
            })
        },
    }
</script>

<style scoped>

</style>
