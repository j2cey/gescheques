(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[30],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/workflowactions/item.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/workflowactions/item.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _actionBus__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./actionBus */ "./resources/js/views/workflowactions/actionBus.js");
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
  name: "action-item",
  props: {
    workflowaction_prop: {},
    index_prop: {}
  },
  components: {},
  mounted: function mounted() {
    var _this = this;

    _actionBus__WEBPACK_IMPORTED_MODULE_0__["default"].$on('workflowaction_updated', function (upd_data) {
      if (_this.workflowaction.id === upd_data.action.id) {
        _this.updateAction(upd_data.action);
      }
    });
  },
  data: function data() {
    return {
      workflowaction: this.workflowaction_prop,
      index: this.index_prop,
      collapse_icon: 'fas fa-chevron-down',
      isOpen: true
    };
  },
  methods: {
    editAction: function editAction(workflowaction) {
      axios.get("/workflowactions.fetchbystep/".concat(workflowaction.workflow_step_id)).then(function (resp) {
        _actionBus__WEBPACK_IMPORTED_MODULE_0__["default"].$emit('workflowaction_edit', workflowaction, resp.data);
      });
    },
    updateAction: function updateAction(workflowaction) {
      this.workflowaction = workflowaction;
    },
    deleteAction: function deleteAction(id, key) {
      var _this2 = this;

      this.$swal({
        html: '<small>Voulez-vous vraiment supprimer cette Action ?</small>',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Oui',
        cancelButtonText: 'Non'
      }).then(function (result) {
        if (result.value) {
          axios["delete"]("/workflowactions/".concat(id)).then(function (resp) {
            var action = resp.data.action;
            var step = resp.data.step;
            console.log('workflowactions delete resp: ', resp);

            _this2.$swal({
              html: '<small>Action supprimée avec succès !</small>',
              icon: 'success',
              timer: 3000
            }).then(function () {
              _actionBus__WEBPACK_IMPORTED_MODULE_0__["default"].$emit('workflowaction_deleted', {
                key: key,
                action: action,
                step: step
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/workflowactions/item.vue?vue&type=template&id=72be34ba&scoped=true&":
/*!******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/workflowactions/item.vue?vue&type=template&id=72be34ba&scoped=true& ***!
  \******************************************************************************************************************************************************************************************************************************/
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
                "data-parent": "#actionlist",
                href: "#collapse-actions-" + _vm.index
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
                  _vm._s(_vm.workflowaction.titre) +
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
                    return _vm.editAction(_vm.workflowaction)
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
                  "data-parent": "#actionlist",
                  href: "#collapse-actions-" + _vm.index
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
                    return _vm.deleteAction(_vm.workflowaction.uuid, _vm.index)
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
        attrs: { id: "collapse-actions-" + _vm.index }
      },
      [
        _c("dl", { staticClass: "row" }, [
          _vm.workflowaction.actiontype
            ? _c("dt", { staticClass: "col-sm-4 text-xs" }, [
                _vm._v("Type Champs")
              ])
            : _vm._e(),
          _vm._v(" "),
          _c("dd", { staticClass: "col-sm-8 text-xs" }, [
            _vm._v(_vm._s(_vm.workflowaction.actiontype.name))
          ]),
          _vm._v(" "),
          _vm.workflowaction.actiontype.code === "EnumType"
            ? _c("dd", { staticClass: "col-sm-8 offset-sm-4" }, [
                _c("small", [
                  _c(
                    "span",
                    {
                      staticClass:
                        "text-lighter text-xs text-warning hidden-sm-down"
                    },
                    [
                      _vm._v(
                        "\n                        " +
                          _vm._s(_vm.workflowaction.enumtype.name) +
                          "\n                    "
                      )
                    ]
                  )
                ])
              ])
            : _vm._e(),
          _vm._v(" "),
          _vm.workflowaction.treatmenttype
            ? _c("dt", { staticClass: "col-sm-4 text-xs" }, [
                _vm._v("Type Traitement")
              ])
            : _vm._e(),
          _vm._v(" "),
          _c(
            "dd",
            { staticClass: "col-sm-8 text-xs" },
            [
              _vm.workflowaction.treatmenttype.code === "pass"
                ? _c("b-tag", { attrs: { type: "is-primary is-light" } }, [
                    _vm._v(_vm._s(_vm.workflowaction.treatmenttype.name))
                  ])
                : _vm.workflowaction.treatmenttype.code === "reject"
                ? _c("b-tag", { attrs: { type: "is-danger is-light" } }, [
                    _vm._v(_vm._s(_vm.workflowaction.treatmenttype.name))
                  ])
                : _vm.workflowaction.treatmenttype.code === "allways"
                ? _c("b-tag", { attrs: { type: "is-warning is-light" } }, [
                    _vm._v(_vm._s(_vm.workflowaction.treatmenttype.name))
                  ])
                : _vm.workflowaction.treatmenttype.code === "expire"
                ? _c("b-tag", { attrs: { type: "is-info is-light" } }, [
                    _vm._v(_vm._s(_vm.workflowaction.treatmenttype.name))
                  ])
                : _c("b-tag", { attrs: { type: "is-dark is-light" } }, [
                    _vm._v(_vm._s(_vm.workflowaction.treatmenttype.name))
                  ])
            ],
            1
          ),
          _vm._v(" "),
          _vm.workflowaction.actiontype &&
          _vm.workflowaction.actiontype.code === "FILE_ref"
            ? _c("dd", { staticClass: "col-sm-8 offset-sm-4" }, [
                _c("small", [
                  _c(
                    "span",
                    { staticClass: "text-lighter text-xs hidden-sm-down" },
                    _vm._l(_vm.workflowaction.mimetypes, function(
                      mimetype,
                      index
                    ) {
                      return _vm.workflowaction.mimetypes
                        ? _c(
                            "span",
                            { staticClass: "badge badge-pill badge-default" },
                            [
                              _vm._v(
                                "\n                            " +
                                  _vm._s(mimetype.name) +
                                  "\n                        "
                              )
                            ]
                          )
                        : _vm._e()
                    }),
                    0
                  )
                ])
              ])
            : _vm._e(),
          _vm._v(" "),
          _c("dt", { staticClass: "col-sm-4 text-xs" }, [
            _vm._v("Description")
          ]),
          _vm._v(" "),
          _c("dd", { staticClass: "col-sm-8 text-xs" }, [
            _vm._v(_vm._s(_vm.workflowaction.description))
          ]),
          _vm._v(" "),
          _vm.workflowaction.field_required_without
            ? _c("dt", { staticClass: "col-sm-4 text-xs" }, [
                _c("span", { staticClass: "text-sm" }, [
                  _vm._v("Champs Facultatif si:")
                ])
              ])
            : _vm._e(),
          _vm._v(" "),
          _vm.workflowaction.field_required_without
            ? _c("dd", { staticClass: "col-sm-8 text-xs" }, [
                _c("small", [
                  _c(
                    "span",
                    { staticClass: "text-lighter hidden-sm-down" },
                    _vm._l(_vm.workflowaction.actionsrequiredwithout, function(
                      actionwithout,
                      index
                    ) {
                      return _vm.workflowaction.actionsrequiredwithout
                        ? _c("span", { staticClass: "badge badge-info" }, [
                            _vm._v(
                              "\n                            " +
                                _vm._s(actionwithout.titre) +
                                "\n                        "
                            )
                          ])
                        : _vm._e()
                    }),
                    0
                  )
                ])
              ])
            : _vm._e(),
          _vm._v(" "),
          _vm.workflowaction.field_required_without
            ? _c("dd", { staticClass: "col-sm-8 offset-sm-4" }, [
                _c("small", [
                  _c(
                    "span",
                    { staticClass: "text-lighter text-red hidden-sm-down" },
                    [
                      _vm._v(
                        "\n                        " +
                          _vm._s(
                            _vm.workflowaction.field_required_without_msg
                          ) +
                          "\n                    "
                      )
                    ]
                  )
                ])
              ])
            : _vm._e(),
          _vm._v(" "),
          _vm.workflowaction.field_required_with
            ? _c("dt", { staticClass: "col-sm-4 text-xs" }, [
                _c("span", { staticClass: "text-sm" }, [
                  _vm._v("Champs Obligatoire si:")
                ])
              ])
            : _vm._e(),
          _vm._v(" "),
          _vm.workflowaction.field_required_with
            ? _c("dd", { staticClass: "col-sm-8 text-xs" }, [
                _c("small", [
                  _c(
                    "span",
                    { staticClass: "text-lighter hidden-sm-down" },
                    _vm._l(_vm.workflowaction.actionsrequiredwith, function(
                      actionwith,
                      index
                    ) {
                      return _vm.workflowaction.actionsrequiredwith
                        ? _c("span", { staticClass: "badge badge-warning" }, [
                            _vm._v(
                              "\n                            " +
                                _vm._s(actionwith.titre) +
                                "\n                        "
                            )
                          ])
                        : _vm._e()
                    }),
                    0
                  )
                ])
              ])
            : _vm._e(),
          _vm._v(" "),
          _vm.workflowaction.field_required_with
            ? _c("dd", { staticClass: "col-sm-8 offset-sm-4" }, [
                _c("small", [
                  _c(
                    "span",
                    { staticClass: "text-lighter text-red hidden-sm-down" },
                    [
                      _vm._v(
                        "\n                        " +
                          _vm._s(_vm.workflowaction.field_required_with_msg) +
                          "\n                    "
                      )
                    ]
                  )
                ])
              ])
            : _vm._e(),
          _vm._v(" "),
          !_vm.workflowaction.field_required_without &&
          !_vm.workflowaction.field_required_with
            ? _c("dt", { staticClass: "col-sm-4 text-xs" }, [
                _vm._v("Facultatif ?")
              ])
            : _vm._e(),
          _vm._v(" "),
          !_vm.workflowaction.field_required_without &&
          !_vm.workflowaction.field_required_with
            ? _c("dd", { staticClass: "col-sm-8 text-xs" }, [
                _c("small", [
                  _c("span", { staticClass: "text-lighter hidden-sm-down" }, [
                    _vm.workflowaction.field_required
                      ? _c(
                          "span",
                          { staticClass: "badge badge-pill badge-danger" },
                          [_vm._v("non")]
                        )
                      : _c(
                          "span",
                          { staticClass: "badge badge-pill badge-success" },
                          [_vm._v("oui")]
                        )
                  ])
                ])
              ])
            : _vm._e(),
          _vm._v(" "),
          !_vm.workflowaction.field_required_without &&
          !_vm.workflowaction.field_required_with &&
          _vm.workflowaction.field_required
            ? _c("dd", { staticClass: "col-sm-8 offset-sm-4 text-xs" }, [
                _c("small", [
                  _c(
                    "span",
                    { staticClass: "text-lighter text-red hidden-sm-down" },
                    [
                      _vm._v(
                        "\n                        " +
                          _vm._s(_vm.workflowaction.field_required_msg) +
                          "\n                    "
                      )
                    ]
                  )
                ])
              ])
            : _vm._e()
        ]),
        _vm._v(" "),
        _c(
          "b-collapse",
          {
            staticClass: "card",
            attrs: { open: _vm.isOpen },
            on: {
              "update:open": function($event) {
                _vm.isOpen = $event
              }
            }
          },
          [
            _c(
              "div",
              {
                staticClass: "card-header",
                attrs: { slot: "trigger" },
                slot: "trigger"
              },
              [
                _c("p", { staticClass: "card-header-title" }, [
                  _vm._v(" Component ")
                ]),
                _vm._v(" "),
                _c(
                  "a",
                  { staticClass: "card-header-icon" },
                  [
                    _c("b-icon", {
                      attrs: {
                        icon: _vm.isOpen ? "arrow_drop_down" : "arrow_drop_up"
                      }
                    })
                  ],
                  1
                )
              ]
            ),
            _vm._v(" "),
            _c("div", { staticClass: "card-content" }, [
              _c("div", { staticClass: "content" }, [
                _vm._v(
                  "\n                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec iaculis mauris.\n                    "
                ),
                _c("a", [_vm._v("#buefy")]),
                _vm._v(".\n                ")
              ])
            ]),
            _vm._v(" "),
            _c("footer", { staticClass: "card-footer" }, [
              _c("a", { staticClass: "card-footer-item" }, [_vm._v("Save")]),
              _vm._v(" "),
              _c("a", { staticClass: "card-footer-item" }, [_vm._v("Edit")]),
              _vm._v(" "),
              _c("a", { staticClass: "card-footer-item" }, [_vm._v("Delete")])
            ])
          ]
        )
      ],
      1
    )
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/views/workflowactions/item.vue":
/*!*****************************************************!*\
  !*** ./resources/js/views/workflowactions/item.vue ***!
  \*****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _item_vue_vue_type_template_id_72be34ba_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./item.vue?vue&type=template&id=72be34ba&scoped=true& */ "./resources/js/views/workflowactions/item.vue?vue&type=template&id=72be34ba&scoped=true&");
/* harmony import */ var _item_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./item.vue?vue&type=script&lang=js& */ "./resources/js/views/workflowactions/item.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _item_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _item_vue_vue_type_template_id_72be34ba_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _item_vue_vue_type_template_id_72be34ba_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "72be34ba",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/workflowactions/item.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/workflowactions/item.vue?vue&type=script&lang=js&":
/*!******************************************************************************!*\
  !*** ./resources/js/views/workflowactions/item.vue?vue&type=script&lang=js& ***!
  \******************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./item.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/workflowactions/item.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/workflowactions/item.vue?vue&type=template&id=72be34ba&scoped=true&":
/*!************************************************************************************************!*\
  !*** ./resources/js/views/workflowactions/item.vue?vue&type=template&id=72be34ba&scoped=true& ***!
  \************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_template_id_72be34ba_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./item.vue?vue&type=template&id=72be34ba&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/workflowactions/item.vue?vue&type=template&id=72be34ba&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_template_id_72be34ba_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_template_id_72be34ba_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);