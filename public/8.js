(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[8],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/files/pdfpreview.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/files/pdfpreview.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
//
//
//
//
//
//
//
//
//
/* harmony default export */ __webpack_exports__["default"] = ({
  name: "pdfpreview",
  props: {
    file_prop: {}
  },
  components: {
    PdfShow: function PdfShow() {
      return Promise.all(/*! import() */[__webpack_require__.e(5), __webpack_require__.e(0)]).then(__webpack_require__.bind(null, /*! ../files/pdfshow */ "./resources/js/views/files/pdfshow.vue"));
    }
  },
  data: function data() {
    return {
      file: this.file_prop,
      name_old: '/' + this.file_prop.relativepath,
      name: 'demo.pdf',
      //change which pdf file loads
      path: '/lib/web/viewer.html' //path of the PDF.js viewer.html

    };
  },
  methods: {
    showPdf: function showPdf(scanUrl) {
      this.$emit('show_pdf');
    }
  },
  computed: {}
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/files/pdfpreview.vue?vue&type=template&id=516531a6&scoped=true&":
/*!**************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/files/pdfpreview.vue?vue&type=template&id=516531a6&scoped=true& ***!
  \**************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _vm.file
    ? _c(
        "div",
        { staticClass: "attachment-block clearfix" },
        [
          _vm.file.mimetype && _vm.file.mimetype.extension === "pdf"
            ? _c(
                "a",
                {
                  staticClass: "link-black text-sm",
                  attrs: { href: "#" },
                  on: {
                    click: function($event) {
                      $event.preventDefault()
                      return _vm.showPdf("/" + _vm.file.relativepath)
                    }
                  }
                },
                [_c("i", { staticClass: "fa fa-file-pdf" })]
              )
            : _vm._e(),
          _vm._v(" "),
          _c("PdfShow", {
            attrs: {
              file_prop: _vm.file,
              pdf_url_prop: "/" + _vm.file.relativepath
            }
          })
        ],
        1
      )
    : _vm._e()
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/views/files/pdfpreview.vue":
/*!*************************************************!*\
  !*** ./resources/js/views/files/pdfpreview.vue ***!
  \*************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _pdfpreview_vue_vue_type_template_id_516531a6_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./pdfpreview.vue?vue&type=template&id=516531a6&scoped=true& */ "./resources/js/views/files/pdfpreview.vue?vue&type=template&id=516531a6&scoped=true&");
/* harmony import */ var _pdfpreview_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./pdfpreview.vue?vue&type=script&lang=js& */ "./resources/js/views/files/pdfpreview.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _pdfpreview_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _pdfpreview_vue_vue_type_template_id_516531a6_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _pdfpreview_vue_vue_type_template_id_516531a6_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "516531a6",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/files/pdfpreview.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/files/pdfpreview.vue?vue&type=script&lang=js&":
/*!**************************************************************************!*\
  !*** ./resources/js/views/files/pdfpreview.vue?vue&type=script&lang=js& ***!
  \**************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_pdfpreview_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./pdfpreview.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/files/pdfpreview.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_pdfpreview_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/files/pdfpreview.vue?vue&type=template&id=516531a6&scoped=true&":
/*!********************************************************************************************!*\
  !*** ./resources/js/views/files/pdfpreview.vue?vue&type=template&id=516531a6&scoped=true& ***!
  \********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_pdfpreview_vue_vue_type_template_id_516531a6_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./pdfpreview.vue?vue&type=template&id=516531a6&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/files/pdfpreview.vue?vue&type=template&id=516531a6&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_pdfpreview_vue_vue_type_template_id_516531a6_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_pdfpreview_vue_vue_type_template_id_516531a6_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);