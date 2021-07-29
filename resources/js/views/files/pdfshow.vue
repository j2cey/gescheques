<template>
    <div class="modal fade" id="pdfmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <object type="application/pdf" :data="pdf_url" width="100%" height="500" style="height: 85vh;">No Support</object>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->

    </div>
</template>

<script>
    import pdfvuer from 'pdfvuer'
    import 'pdfjs-dist/build/pdf.worker.entry'

    export default {
        name: "pdfshow",
        props: {
            file_prop: {},
            pdf_url_prop: {}
        },
        components: {
            pdf: pdfvuer
        },
        data () {
            return {
                pdf_url: this.pdf_url_prop,
                file: this.file_prop,
                page: 1,
                numPages: 0,
                pdfdata: undefined,
                errors: [],
                scale: 'page-width'
            }
        },
        computed: {
            formattedZoom () {
                return Number.parseInt(this.scale * 100);
            },
        },
        mounted () {
            //this.getPdf()

            this.$parent.$on('show_pdf', () => {
                console.log('show_pdf')
                $('#pdfmodal').modal()
            })
        },
        watch: {
            show: function (s) {
                if(s) {
                    this.getPdf();
                }
            },
            page: function (p) {
                if( window.pageYOffset <= this.findPos(document.getElementById(p)) || ( document.getElementById(p+1) && window.pageYOffset >= this.findPos(document.getElementById(p+1)) )) {
                    // window.scrollTo(0,this.findPos(document.getElementById(p)));
                    document.getElementById(p).scrollIntoView();
                }
            }
        },
        methods: {
            handle_pdf_link: function (params) {
                // Scroll to the appropriate place on our page - the Y component of
                // params.destArray * (div height / ???), from the bottom of the page div
                var page = document.getElementById(String(params.pageNumber));
                page.scrollIntoView();
            },
            getPdf () {
                var self = this;
                self.pdfdata = pdfvuer.createLoadingTask(this.pdf_url);
                self.pdfdata.then(pdf => {
                    self.numPages = pdf.numPages;
                    window.onscroll = function() {
                        changePage()
                        stickyNav()
                    }

                    // Get the offset position of the navbar
                    var sticky = $('#buttons')[0].offsetTop

                    // Add the sticky class to the self.$refs.nav when you reach its scroll position. Remove "sticky" when you leave the scroll position
                    function stickyNav() {
                        if (window.pageYOffset >= sticky) {
                            $('#buttons')[0].classList.remove("hidden")
                        } else {
                            $('#buttons')[0].classList.add("hidden")
                        }
                    }

                    function changePage () {
                        var i = 1, count = Number(pdf.numPages);
                        do {
                            if(window.pageYOffset >= self.findPos(document.getElementById(i)) &&
                                window.pageYOffset <= self.findPos(document.getElementById(i+1))) {
                                self.page = i
                            }
                            i++
                        } while ( i < count)
                        if (window.pageYOffset >= self.findPos(document.getElementById(i))) {
                            self.page = i
                        }
                    }
                });
            },
            findPos(obj) {
                return obj.offsetTop;
            }
        }
    }
</script>

<style src="pdfvuer/dist/pdfvuer.css"></style>
<style lang="css" scoped>
    #buttons {
        margin-left: 0 !important;
        margin-right: 0 !important;
    }
    /* Page content */
    .content {
        padding: 16px;
    }
</style>
