<template>
    <div class="attachment-block clearfix" v-if="file">
        <a v-if="file.mimetype && (file.mimetype.extension === 'pdf')" href="#" @click.prevent="showPdf('/' + file.relativepath)" class="link-black text-sm">
            <i class="fa fa-file-pdf"></i>
        </a>
        <PdfShow :file_prop="file" :pdf_url_prop="'/' + file.relativepath"/>
    </div>
</template>

<script>
    export default {
        name: "pdfpreview",
        props: {
            file_prop: {},
        },
        components: {
            PdfShow: () => import('../files/pdfshow')
        },
        data() {
            return {
                file: this.file_prop,
                name_old: '/' + this.file_prop.relativepath,
                name: 'demo.pdf', //change which pdf file loads
                path: '/lib/web/viewer.html' //path of the PDF.js viewer.html
            };
        },
        methods: {
            showPdf(scanUrl) {
                this.$emit('show_pdf')
            },
        },
        computed: {

        }
    }
</script>

<style scoped>

</style>
