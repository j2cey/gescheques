<template>
    <div class="modal fade" id="pdfvuer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <iframe style="width:800px; height:550px;position: relative;overflow: scroll;" :src="`${getFilePath}`" ></iframe>
    </div>
</template>

<script>
    export default {
        name: "PDFJSViewer",
        props: {
            fileName: String,
            path:String
        },
        mounted () {
            this.$parent.$on('show_pdf', () => {
                console.log('show_pdf')
                $('#imgDetail').modal()
            })
        },
        data () {
            return {
                pdf_url: this.fileName,
            }
        },
        computed:{
            getFilePath() {
                if(this && this.pdf_url !== ''){
                    return this.path + '?file=' + this.pdf_url
                }
                return this.path
            }
        }
    }
</script>

<style scoped>
    div {
        width: 50%;
        height: 79vh;
        min-width: 400px;
    }
    .hide-it-off-screen {
        position: absolute;
        left: -10000px;
        top: -10000px;
    }
</style>
