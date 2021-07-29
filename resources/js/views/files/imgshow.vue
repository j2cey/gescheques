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
                        <img :src="img_url" alt="" width="100%">
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
        name: "imgshow",
        props: {
            img_url_prop: {}
        },
        data() {
            return {
                img_url: this.img_url_prop,
            };
        },
        mounted() {
            this.$parent.$on('show_image', () => {
                console.log('show_image')
                $('#imgDetail').modal()
            })
        },
        computed: {
            imgurl() {
                return this.img_url;
            }
        }
    }
</script>

<style scoped>

</style>
