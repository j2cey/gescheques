(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[5],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/workflowexecs/imgscan.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/workflowexecs/imgscan.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _workflowexecs_imgscanBus__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../workflowexecs/imgscanBus */ "./resources/js/views/workflowexecs/imgscanBus.js");
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
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
  name: "imgscan",
  props: {},
  data: function data() {
    return {
      img_url: null
    };
  },
  mounted: function mounted() {
    var _this = this;

    _workflowexecs_imgscanBus__WEBPACK_IMPORTED_MODULE_0__["default"].$on('show_image', function (img_url) {
      _this.img_url = img_url;
      console.log('show_image', img_url, _this.img_url);
      $('#imgDetail').modal();
    });
  },
  computed: {
    imgurl: function imgurl() {
      return this.img_url;
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/workflowexecs/imgscan.vue?vue&type=template&id=64efdae5&scoped=true&":
/*!*******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/workflowexecs/imgscan.vue?vue&type=template&id=64efdae5&scoped=true& ***!
  \*******************************************************************************************************************************************************************************************************************************/
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
        id: "imgDetail",
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
          _c("div", { staticClass: "modal-body" }, [
            _vm.img_url
              ? _c("div", { attrs: { "max-width": "85vw" } }, [
                  _c("img", {
                    attrs: { src: _vm.img_url, alt: "", width: "100%" },
                    on: {
                      click: function($event) {
                        $event.stopPropagation()
                        _vm.img_url = null
                      }
                    }
                  }),
                  _vm._v(" "),
                  _c("hr")
                ])
              : _vm._e()
          ])
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

/***/ "./resources/js/views/workflowexecs/imgscan.vue":
/*!******************************************************!*\
  !*** ./resources/js/views/workflowexecs/imgscan.vue ***!
  \******************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _imgscan_vue_vue_type_template_id_64efdae5_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./imgscan.vue?vue&type=template&id=64efdae5&scoped=true& */ "./resources/js/views/workflowexecs/imgscan.vue?vue&type=template&id=64efdae5&scoped=true&");
/* harmony import */ var _imgscan_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./imgscan.vue?vue&type=script&lang=js& */ "./resources/js/views/workflowexecs/imgscan.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _imgscan_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _imgscan_vue_vue_type_template_id_64efdae5_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _imgscan_vue_vue_type_template_id_64efdae5_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "64efdae5",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/workflowexecs/imgscan.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/workflowexecs/imgscan.vue?vue&type=script&lang=js&":
/*!*******************************************************************************!*\
  !*** ./resources/js/views/workflowexecs/imgscan.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_imgscan_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./imgscan.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/workflowexecs/imgscan.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_imgscan_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/workflowexecs/imgscan.vue?vue&type=template&id=64efdae5&scoped=true&":
/*!*************************************************************************************************!*\
  !*** ./resources/js/views/workflowexecs/imgscan.vue?vue&type=template&id=64efdae5&scoped=true& ***!
  \*************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_imgscan_vue_vue_type_template_id_64efdae5_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./imgscan.vue?vue&type=template&id=64efdae5&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/workflowexecs/imgscan.vue?vue&type=template&id=64efdae5&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_imgscan_vue_vue_type_template_id_64efdae5_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_imgscan_vue_vue_type_template_id_64efdae5_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);