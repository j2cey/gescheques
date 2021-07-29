<template>
    <div>
        <div class="row">
            <div class="col-sm-4 border-right">
                <span v-if="execaction.workflowprocessstatus.code === 'pending'" class="info-box-icon"><i class="fa fa-question-circle-o text-info"></i></span>
                <span v-else-if="execaction.workflowprocessstatus.code === 'processing'" class="info-box-icon"><i class="fa fa-gears text-warning"></i></span>
                <span v-else-if="execaction.workflowprocessstatus.code === 'processed'" class="info-box-icon"><i class="fa fa-check-circle-o text-success"></i></span>
                <span v-else-if="execaction.workflowprocessstatus.code === 'failed'" class="info-box-icon"><i class="fa fa-exclamation-circle text-danger"></i></span>
                <span class="text text-xs text-bold">{{ execaction.field_name }}</span>
            </div>
            <div class="col-sm-8 border-right">
                <span v-if="execaction.BIGINT_value" class="text text-xs">{{ execaction.BIGINT_value }}</span>
                <span v-else-if="execaction.BLOB_value" class="text text-xs">{{ execaction.BLOB_value }}</span>
                <span v-else-if="execaction.BOOLEAN_value" class="text text-xs">{{ execaction.BOOLEAN_value }}</span>
                <span v-else-if="execaction.CHAR_value" class="text text-xs">{{ execaction.CHAR_value }}</span>
                <span v-else-if="execaction.DATETIME_value" class="text text-xs">{{ execaction.DATETIME_value | formatDate }}</span>
                <span v-else-if="execaction.DATE_value" class="text text-xs">{{ execaction.DATE_value | formatDate }}</span>
                <span v-else-if="execaction.DECIMAL_value" class="text text-xs">{{ execaction.DECIMAL_value }}</span>
                <span v-else-if="execaction.DOUBLE_value" class="text text-xs">{{ execaction.DOUBLE_value }}</span>
                <span v-else-if="execaction.FLOAT_value" class="text text-xs">{{ execaction.FLOAT_value }}</span>
                <span v-else-if="execaction.INTEGER_value" class="text text-xs">{{ execaction.INTEGER_value }}</span>
                <span v-else-if="execaction.IPADDRESS_value" class="text text-xs">{{ execaction.IPADDRESS_value }}</span>
                <span v-else-if="execaction.STRING_value" class="text text-xs">{{ execaction.STRING_value }}</span>
                <span v-else-if="execaction.TEXT_value" class="text text-xs">{{ execaction.TEXT_value }}</span>
                <span v-else-if="execaction.FILE_ref" class="text text-xs">
                    <ImgPreview v-if="execaction.file.mimetype && (execaction.file.mimetype.extension === 'jpg' || execaction.file.mimetype.extension === 'png' || execaction.file.mimetype.extension === 'bmp')" :file_prop="execaction.file"></ImgPreview>
                    <PdfPreview v-else-if="execaction.file.mimetype && execaction.file.mimetype.extension === 'pdf'" :file_prop="execaction.file"></PdfPreview>
                </span>
            </div>
        </div>
    </div>
</template>

<script>
    import ImgScanBus from "../workflowexecs/imgscanBus";

    export default {
        name: "execActionItem",
        props: {
            execaction_prop: {},
        },
        components: {
            ImgPreview: () => import('../files/imgpreview'),
            PdfPreview: () => import('../files/pdfpreview')
        },
        data() {
            return {
                execaction: this.execaction_prop,
            };
        },
        methods: {
            showImage(scanUrl) {
                ImgScanBus.$emit('show_image', scanUrl)
            },
        },
        computed: {

        }
    }
</script>

<style scoped>

</style>
