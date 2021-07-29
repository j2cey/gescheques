<template>
    <div class="modal fade" id="pdfmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="pdfvuer" class="modal-body">

                    <vue-pdf-app :pdf="pdf_url" @open="openHandler"></vue-pdf-app>

                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->

    </div>
</template>

<script>
    import VuePdfApp from "vue-pdf-app";
    // import this to use default icons for buttons
    import "vue-pdf-app/dist/icons/main.css";
    export default {
        name: "vuePdfAppShow",
        props: {
            file_prop: {},
            pdf_url_prop: {}
        },
        components: {
            VuePdfApp
        },
        data () {
            return {
                pdf_url: this.pdf_url_prop,
                file: this.file_prop,
            }
        },
        methods: {
            openHandler(pdfApp) {
                window._pdfApp = pdfApp;
            },
        },
    }
</script>

<style scoped>

</style>
