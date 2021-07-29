<template>
    <div class="attachment-block clearfix" v-if="file">
        <a v-if="file.mimetype && (file.mimetype.extension === 'jpg' || file.mimetype.extension === 'png' || file.mimetype.extension === 'bmp')" href="#" @click.prevent="showImage('/' + file.relativepath)" class="link-black text-sm">
            <img class="attachment-img" :src="'/' + file.relativepath" alt="Attachment Image">
        </a>
        <ImgShow :img_url_prop="'/' + file.relativepath"></ImgShow>
    </div>
</template>

<script>
    export default {
        name: "imgpreview",
        props: {
            file_prop: {},
        },
        components: {
            ImgShow: () => import('../files/imgshow')
        },
        data() {
            return {
                file: this.file_prop,
            };
        },
        methods: {
            showImage(scanUrl) {
                this.$emit('show_image')
            },
        },
        computed: {

        }
    }
</script>

<style scoped>

</style>
