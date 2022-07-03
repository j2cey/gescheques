(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[4],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/files/pdfshow.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/files/pdfshow.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var pdfvuer__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! pdfvuer */ "./node_modules/pdfvuer/dist/pdfvuer.umd.js");
/* harmony import */ var pdfvuer__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(pdfvuer__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var pdfjs_dist_build_pdf_worker_entry__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! pdfjs-dist/build/pdf.worker.entry */ "./node_modules/pdfjs-dist/build/pdf.worker.entry.js");
/* harmony import */ var pdfjs_dist_build_pdf_worker_entry__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(pdfjs_dist_build_pdf_worker_entry__WEBPACK_IMPORTED_MODULE_1__);
//
//
//
//
//
//
//
//
//
//
//
//
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
  name: "pdfshow",
  props: {
    file_prop: {},
    pdf_url_prop: {}
  },
  components: {
    pdf: pdfvuer__WEBPACK_IMPORTED_MODULE_0___default.a
  },
  data: function data() {
    return {
      pdf_url: this.pdf_url_prop,
      file: this.file_prop,
      page: 1,
      numPages: 0,
      pdfdata: undefined,
      errors: [],
      scale: 'page-width'
    };
  },
  computed: {
    formattedZoom: function formattedZoom() {
      return Number.parseInt(this.scale * 100);
    }
  },
  mounted: function mounted() {
    //this.getPdf()
    this.$parent.$on('show_pdf', function () {
      console.log('show_pdf');
      $('#pdfmodal').modal();
    });
  },
  watch: {
    show: function show(s) {
      if (s) {
        this.getPdf();
      }
    },
    page: function page(p) {
      if (window.pageYOffset <= this.findPos(document.getElementById(p)) || document.getElementById(p + 1) && window.pageYOffset >= this.findPos(document.getElementById(p + 1))) {
        // window.scrollTo(0,this.findPos(document.getElementById(p)));
        document.getElementById(p).scrollIntoView();
      }
    }
  },
  methods: {
    handle_pdf_link: function handle_pdf_link(params) {
      // Scroll to the appropriate place on our page - the Y component of
      // params.destArray * (div height / ???), from the bottom of the page div
      var page = document.getElementById(String(params.pageNumber));
      page.scrollIntoView();
    },
    getPdf: function getPdf() {
      var self = this;
      self.pdfdata = pdfvuer__WEBPACK_IMPORTED_MODULE_0___default.a.createLoadingTask(this.pdf_url);
      self.pdfdata.then(function (pdf) {
        self.numPages = pdf.numPages;

        window.onscroll = function () {
          changePage();
          stickyNav();
        }; // Get the offset position of the navbar


        var sticky = $('#buttons')[0].offsetTop; // Add the sticky class to the self.$refs.nav when you reach its scroll position. Remove "sticky" when you leave the scroll position

        function stickyNav() {
          if (window.pageYOffset >= sticky) {
            $('#buttons')[0].classList.remove("hidden");
          } else {
            $('#buttons')[0].classList.add("hidden");
          }
        }

        function changePage() {
          var i = 1,
              count = Number(pdf.numPages);

          do {
            if (window.pageYOffset >= self.findPos(document.getElementById(i)) && window.pageYOffset <= self.findPos(document.getElementById(i + 1))) {
              self.page = i;
            }

            i++;
          } while (i < count);

          if (window.pageYOffset >= self.findPos(document.getElementById(i))) {
            self.page = i;
          }
        }
      });
    },
    findPos: function findPos(obj) {
      return obj.offsetTop;
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/files/pdfshow.vue?vue&type=style&index=1&id=4667cd68&lang=css&scoped=true&":
/*!**************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/files/pdfshow.vue?vue&type=style&index=1&id=4667cd68&lang=css&scoped=true& ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "#buttons[data-v-4667cd68] {\n  margin-left: 0 !important;\n  margin-right: 0 !important;\n}\n\n/* Page content */\n.content[data-v-4667cd68] {\n  padding: 16px;\n}\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/files/pdfshow.vue?vue&type=style&index=1&id=4667cd68&lang=css&scoped=true&":
/*!******************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/files/pdfshow.vue?vue&type=style&index=1&id=4667cd68&lang=css&scoped=true& ***!
  \******************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../node_modules/css-loader??ref--6-1!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--6-2!../../../../node_modules/vue-loader/lib??vue-loader-options!./pdfshow.vue?vue&type=style&index=1&id=4667cd68&lang=css&scoped=true& */ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/files/pdfshow.vue?vue&type=style&index=1&id=4667cd68&lang=css&scoped=true&");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/files/pdfshow.vue?vue&type=template&id=4667cd68&scoped=true&":
/*!***********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/files/pdfshow.vue?vue&type=template&id=4667cd68&scoped=true& ***!
  \***********************************************************************************************************************************************************************************************************************/
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
  return _c(
    "div",
    {
      staticClass: "modal fade",
      attrs: {
        id: "pdfmodal",
        tabindex: "-1",
        role: "dialog",
        "aria-labelledby": "exampleModalLabel",
        "aria-hidden": "true"
      }
    },
    [
      _c("div", { staticClass: "modal-dialog modal-lg" }, [
        _c("div", { staticClass: "modal-content" }, [
          _vm._m(0),
          _vm._v(" "),
          _c(
            "object",
            {
              staticStyle: { height: "85vh" },
              attrs: {
                type: "application/pdf",
                data: _vm.pdf_url,
                width: "100%",
                height: "500"
              }
            },
            [_vm._v("No Support")]
          )
        ])
      ])
    ]
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "modal-header" }, [
      _c(
        "button",
        {
          staticClass: "close",
          attrs: {
            type: "button",
            "data-dismiss": "modal",
            "aria-label": "Close"
          }
        },
        [_c("span", { attrs: { "aria-hidden": "true" } }, [_vm._v("×")])]
      )
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/views/files/pdfshow.vue":
/*!**********************************************!*\
  !*** ./resources/js/views/files/pdfshow.vue ***!
  \**********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _pdfshow_vue_vue_type_template_id_4667cd68_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./pdfshow.vue?vue&type=template&id=4667cd68&scoped=true& */ "./resources/js/views/files/pdfshow.vue?vue&type=template&id=4667cd68&scoped=true&");
/* harmony import */ var _pdfshow_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./pdfshow.vue?vue&type=script&lang=js& */ "./resources/js/views/files/pdfshow.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var pdfvuer_dist_pdfvuer_css_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! pdfvuer/dist/pdfvuer.css?vue&type=style&index=0&lang=css& */ "./node_modules/pdfvuer/dist/pdfvuer.css?vue&type=style&index=0&lang=css&");
/* harmony import */ var _pdfshow_vue_vue_type_style_index_1_id_4667cd68_lang_css_scoped_true___WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./pdfshow.vue?vue&type=style&index=1&id=4667cd68&lang=css&scoped=true& */ "./resources/js/views/files/pdfshow.vue?vue&type=style&index=1&id=4667cd68&lang=css&scoped=true&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");







/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_4__["default"])(
  _pdfshow_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _pdfshow_vue_vue_type_template_id_4667cd68_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _pdfshow_vue_vue_type_template_id_4667cd68_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "4667cd68",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/files/pdfshow.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/files/pdfshow.vue?vue&type=script&lang=js&":
/*!***********************************************************************!*\
  !*** ./resources/js/views/files/pdfshow.vue?vue&type=script&lang=js& ***!
  \***********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_pdfshow_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./pdfshow.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/files/pdfshow.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_pdfshow_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/files/pdfshow.vue?vue&type=style&index=1&id=4667cd68&lang=css&scoped=true&":
/*!*******************************************************************************************************!*\
  !*** ./resources/js/views/files/pdfshow.vue?vue&type=style&index=1&id=4667cd68&lang=css&scoped=true& ***!
  \*******************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_pdfshow_vue_vue_type_style_index_1_id_4667cd68_lang_css_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader!../../../../node_modules/css-loader??ref--6-1!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--6-2!../../../../node_modules/vue-loader/lib??vue-loader-options!./pdfshow.vue?vue&type=style&index=1&id=4667cd68&lang=css&scoped=true& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/files/pdfshow.vue?vue&type=style&index=1&id=4667cd68&lang=css&scoped=true&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_pdfshow_vue_vue_type_style_index_1_id_4667cd68_lang_css_scoped_true___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_pdfshow_vue_vue_type_style_index_1_id_4667cd68_lang_css_scoped_true___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_pdfshow_vue_vue_type_style_index_1_id_4667cd68_lang_css_scoped_true___WEBPACK_IMPORTED_MODULE_0__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_pdfshow_vue_vue_type_style_index_1_id_4667cd68_lang_css_scoped_true___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));


/***/ }),

/***/ "./resources/js/views/files/pdfshow.vue?vue&type=template&id=4667cd68&scoped=true&":
/*!*****************************************************************************************!*\
  !*** ./resources/js/views/files/pdfshow.vue?vue&type=template&id=4667cd68&scoped=true& ***!
  \*****************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_pdfshow_vue_vue_type_template_id_4667cd68_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./pdfshow.vue?vue&type=template&id=4667cd68&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/files/pdfshow.vue?vue&type=template&id=4667cd68&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_pdfshow_vue_vue_type_template_id_4667cd68_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_pdfshow_vue_vue_type_template_id_4667cd68_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);