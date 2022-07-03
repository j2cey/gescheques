(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[16],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/reminderbroadlists/item.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/reminderbroadlists/item.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _reminderbroadlists_broadlistsBus__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../reminderbroadlists/broadlistsBus */ "./resources/js/views/reminderbroadlists/broadlistsBus.js");
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
  name: "broadlist-item",
  props: {
    broadlist_prop: {},
    object_prop: {},
    // object (reminder or reminderObject)
    objecttype_prop: {},
    index_prop: {}
  },
  components: {},
  mounted: function mounted() {
    var _this = this;

    _reminderbroadlists_broadlistsBus__WEBPACK_IMPORTED_MODULE_0__["default"].$on('broadlist_updated', function (upd_data) {
      if (_this.broadlist.id === upd_data.broadlist.id) {
        _this.updateEnumValue(upd_data.broadlist);
      }
    });
  },
  data: function data() {
    return {
      broadlist: this.broadlist_prop,
      object: this.object_prop,
      objecttype: this.objecttype_prop,
      index: this.index_prop,
      collapse_icon: 'fas fa-chevron-down',
      isOpen: true
    };
  },
  methods: {
    editBroadlist: function editBroadlist(broadlist) {
      var object = this.object;
      var objecttype = this.objecttype;
      _reminderbroadlists_broadlistsBus__WEBPACK_IMPORTED_MODULE_0__["default"].$emit('broadlist_edit', {
        object: object,
        objecttype: objecttype,
        broadlist: broadlist
      });
    },
    updateEnumValue: function updateEnumValue(broadlist) {
      this.broadlist = broadlist;
    },
    deleteBroadlist: function deleteBroadlist(id, key) {
      var _this2 = this;

      this.$swal({
        html: '<small>Are sure you want to delete ?</small>',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Oui',
        cancelButtonText: 'Non'
      }).then(function (result) {
        if (result.value) {
          axios["delete"]("/reminderbroadlists/".concat(id)).then(function (resp) {
            var broadlist = resp.data.broadlist;
            var object = resp.data.object;
            console.log('broadlists delete resp: ', resp);

            _this2.$swal({
              html: '<small>Broadcast List successfully deleted !</small>',
              icon: 'success',
              timer: 3000
            }).then(function () {
              _reminderbroadlists_broadlistsBus__WEBPACK_IMPORTED_MODULE_0__["default"].$emit('broadlist_deleted', {
                key: key,
                broadlist: broadlist,
                object: object
              });
            });
          })["catch"](function (error) {
            window.handleErrors(error);
          });
        } else {// stay here
        }
      });
    },
    collapseClicked: function collapseClicked() {
      if (this.collapse_icon === 'fas fa-chevron-down') {
        this.collapse_icon = 'fas fa-chevron-up';
      } else {
        this.collapse_icon = 'fas fa-chevron-down';
      }
    }
  },
  computed: {
    currentCollapseIcon: function currentCollapseIcon() {
      return this.collapse_icon;
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/reminderbroadlists/item.vue?vue&type=template&id=ab921b24&scoped=true&":
/*!*********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/reminderbroadlists/item.vue?vue&type=template&id=ab921b24&scoped=true& ***!
  \*********************************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "card" }, [
    _c("header", [
      _c("div", { staticClass: "card-header-title row" }, [
        _c("div", { staticClass: "col-md-6 col-sm-9 col-12" }, [
          _c(
            "span",
            {
              staticClass: "text-indigo text-xs",
              attrs: {
                "data-toggle": "collapse",
                "data-parent": "#broadlistlist",
                href: "#collapse-broadlists-" + _vm.index
              },
              on: {
                click: function($event) {
                  return _vm.collapseClicked()
                }
              }
            },
            [
              _vm._v(
                "\n                    " +
                  _vm._s(_vm.broadlist.title) +
                  "\n                "
              )
            ]
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "col-md-6 col-sm-3 col-12 text-right" }, [
          _c("span", { staticClass: "text text-xs" }, [
            _c(
              "a",
              {
                staticClass: "btn btn-tool text-warning",
                attrs: { type: "button", "data-toggle": "tooltip" },
                on: {
                  click: function($event) {
                    return _vm.editBroadlist(_vm.broadlist)
                  }
                }
              },
              [_c("i", { staticClass: "fa fa-pencil-square-o" })]
            ),
            _vm._v(" "),
            _c(
              "a",
              {
                staticClass: "btn btn-tool",
                attrs: {
                  type: "button",
                  "data-toggle": "collapse",
                  "data-parent": "#broadlistlist",
                  href: "#collapse-broadlists-" + _vm.index
                },
                on: {
                  click: function($event) {
                    return _vm.collapseClicked()
                  }
                }
              },
              [_c("i", { class: _vm.currentCollapseIcon })]
            ),
            _vm._v(" "),
            _c(
              "a",
              {
                staticClass: "btn btn-tool text-danger",
                attrs: { type: "button" },
                on: {
                  click: function($event) {
                    return _vm.deleteBroadlist(_vm.broadlist.uuid, _vm.index)
                  }
                }
              },
              [_c("i", { staticClass: "fa fa-trash" })]
            )
          ])
        ])
      ])
    ]),
    _vm._v(" "),
    _c(
      "div",
      {
        staticClass: "card-content panel-collapse collapse in",
        attrs: { id: "collapse-broadlists-" + _vm.index }
      },
      [
        _c("dl", { staticClass: "row" }, [
          _c("dt", { staticClass: "col-sm-4 text-xs" }, [
            _vm._v("Description")
          ]),
          _vm._v(" "),
          _c("dd", { staticClass: "col-sm-8 text-xs" }, [
            _vm._v(_vm._s(_vm.broadlist.description))
          ]),
          _vm._v(" "),
          _vm.broadlist.status
            ? _c("dt", { staticClass: "col-sm-4 text-xs" }, [_vm._v("Statut")])
            : _vm._e(),
          _vm._v(" "),
          _vm.broadlist.status
            ? _c(
                "dd",
                { staticClass: "col-sm-8 text-xs" },
                [
                  _vm.broadlist.status.code === "active"
                    ? _c("b-tag", { attrs: { type: "is-success is-light" } }, [
                        _vm._v(_vm._s(_vm.broadlist.status.name))
                      ])
                    : _c("b-tag", { attrs: { type: "is-danger is-light" } }, [
                        _vm._v(_vm._s(_vm.broadlist.status.name))
                      ])
                ],
                1
              )
            : _vm._e()
        ])
      ]
    )
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/views/reminderbroadlists/item.vue":
/*!********************************************************!*\
  !*** ./resources/js/views/reminderbroadlists/item.vue ***!
  \********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _item_vue_vue_type_template_id_ab921b24_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./item.vue?vue&type=template&id=ab921b24&scoped=true& */ "./resources/js/views/reminderbroadlists/item.vue?vue&type=template&id=ab921b24&scoped=true&");
/* harmony import */ var _item_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./item.vue?vue&type=script&lang=js& */ "./resources/js/views/reminderbroadlists/item.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _item_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _item_vue_vue_type_template_id_ab921b24_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _item_vue_vue_type_template_id_ab921b24_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "ab921b24",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/reminderbroadlists/item.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/reminderbroadlists/item.vue?vue&type=script&lang=js&":
/*!*********************************************************************************!*\
  !*** ./resources/js/views/reminderbroadlists/item.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./item.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/reminderbroadlists/item.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/reminderbroadlists/item.vue?vue&type=template&id=ab921b24&scoped=true&":
/*!***************************************************************************************************!*\
  !*** ./resources/js/views/reminderbroadlists/item.vue?vue&type=template&id=ab921b24&scoped=true& ***!
  \***************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_template_id_ab921b24_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./item.vue?vue&type=template&id=ab921b24&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/reminderbroadlists/item.vue?vue&type=template&id=ab921b24&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_template_id_ab921b24_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_template_id_ab921b24_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);