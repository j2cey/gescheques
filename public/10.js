(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[10],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/enumtypes/addupdate.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/enumtypes/addupdate.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue_multiselect__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-multiselect */ "./node_modules/vue-multiselect/dist/vue-multiselect.min.js");
/* harmony import */ var vue_multiselect__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue_multiselect__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _enumtypeBus__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./enumtypeBus */ "./resources/js/views/enumtypes/enumtypeBus.js");
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

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



var Enumtype = function Enumtype(enumtype) {
  _classCallCheck(this, Enumtype);

  this.name = enumtype.name || '';
  this.description = enumtype.description || '';
  this.status = enumtype.status || '';
  this.enumvalues = enumtype.enumvalues || '';
};

/* harmony default export */ __webpack_exports__["default"] = ({
  name: "enumtype-addupdate",
  components: {
    Multiselect: vue_multiselect__WEBPACK_IMPORTED_MODULE_0___default.a
  },
  mounted: function mounted() {
    var _this = this;

    _enumtypeBus__WEBPACK_IMPORTED_MODULE_1__["default"].$on('enumtype_create', function () {
      _this.editing = false;
      _this.enumtype = new Enumtype({});
      _this.enumvalues = [];
      _this.enumtypeForm = new Form(_this.enumtype);
      $('#addUpdateEnumtype').modal();
    });
    _enumtypeBus__WEBPACK_IMPORTED_MODULE_1__["default"].$on('enumtype_edit', function (enumtype) {
      _this.editing = true;
      _this.enumtype = new Enumtype(enumtype);
      _this.enumtypeForm = new Form(_this.enumtype);
      _this.enumtypeId = enumtype.uuid;
      _this.enumvalues = enumtype.enumvalues;
      $('#addUpdateEnumtype').modal();
    });
  },
  created: function created() {
    var _this2 = this;

    axios.get('/statuses.fetch').then(function (_ref) {
      var data = _ref.data;
      return _this2.statuses = data;
    });
  },
  data: function data() {
    return {
      enumtype: {},
      enumvalues: [],
      enumtypeForm: new Form(new Enumtype({})),
      enumtypeId: null,
      editing: false,
      loading: false,
      statuses: [],
      radioButton: ''
    };
  },
  methods: {
    checkNewEnumValue: function checkNewEnumValue(tagToAdd) {
      var tagIndex = this.enumvalues.findIndex(function (e) {
        return tagToAdd.toUpperCase() === e.val.toUpperCase();
      });
      return tagIndex === -1;
    },
    createEnumvalue: function createEnumvalue(tagToAdd) {
      return {
        'is_default': 0,
        'val': tagToAdd,
        'description': ""
      };
    },
    createEnumType: function createEnumType() {
      var _this3 = this;

      this.loading = true;
      this.enumtypeForm.enumvalues = this.enumvalues;
      this.enumtypeForm.post('/enumtypes').then(function (enumtype) {
        _this3.loading = false;

        _this3.closeModal();

        _this3.$swal({
          html: '<small>Type créé avec succès !</small>',
          icon: 'success',
          timer: 3000
        }).then(function () {
          _enumtypeBus__WEBPACK_IMPORTED_MODULE_1__["default"].$emit('enumtype_created', {
            enumtype: enumtype
          });
        });
      })["catch"](function (error) {
        _this3.loading = false;
      });
    },
    updateEnumType: function updateEnumType() {
      var _this4 = this;

      this.loading = true;
      this.enumtypeForm.enumvalues = this.enumvalues;
      this.enumtypeForm.put("/enumtypes/".concat(this.enumtypeId)).then(function (enumtype) {
        _this4.loading = false;

        _this4.resetForm();

        _this4.closeModal();

        _this4.$swal({
          html: '<small>Type modifié avec succès !</small>',
          icon: 'success',
          timer: 3000
        }).then(function () {
          _enumtypeBus__WEBPACK_IMPORTED_MODULE_1__["default"].$emit('enumtype_updated', {
            enumtype: enumtype
          });
        });
      })["catch"](function (error) {
        _this4.loading = false;
      });
    },
    closeModal: function closeModal() {
      this.resetForm();
      $('#addUpdateEnumtype').modal('hide');
    },
    resetForm: function resetForm() {
      this.enumtypeForm.reset();
    }
  },
  computed: {
    isValidCreateForm: function isValidCreateForm() {
      return !this.loading;
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/enumtypes/addupdate.vue?vue&type=template&id=013d64c4&scoped=true&":
/*!*****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/enumtypes/addupdate.vue?vue&type=template&id=013d64c4&scoped=true& ***!
  \*****************************************************************************************************************************************************************************************************************************/
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
        id: "addUpdateEnumtype",
        tabindex: "-1",
        role: "dialog",
        "aria-labelledby": "exampleenumtypeModalLabel",
        "aria-hidden": "true"
      }
    },
    [
      _c("div", { staticClass: "modal-dialog modal-lg" }, [
        _c("div", { staticClass: "modal-content" }, [
          _c("div", { staticClass: "modal-header" }, [
            _vm.editing
              ? _c(
                  "h5",
                  {
                    staticClass: "modal-title text-sm",
                    attrs: { id: "exampleenumtypeModalLabel" }
                  },
                  [_vm._v("Modifier Type Composé")]
                )
              : _c(
                  "h5",
                  {
                    staticClass: "modal-title text-sm",
                    attrs: { id: "exampleenumtypeModalLabel" }
                  },
                  [_vm._v("Créer Nouveau Type Composé")]
                ),
            _vm._v(" "),
            _vm._m(0)
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "modal-body" }, [
            _c(
              "form",
              {
                staticClass: "form-horizontal",
                on: {
                  submit: function($event) {
                    $event.preventDefault()
                  },
                  keydown: function($event) {
                    return _vm.enumtypeForm.errors.clear()
                  }
                }
              },
              [
                _c("div", { staticClass: "card-body" }, [
                  _c("div", { staticClass: "form-group row" }, [
                    _c(
                      "label",
                      {
                        staticClass: "col-sm-4 col-form-label text-xs",
                        attrs: { for: "enumtype_name" }
                      },
                      [_vm._v("Nom")]
                    ),
                    _vm._v(" "),
                    _c("div", { staticClass: "col-sm-8" }, [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.enumtypeForm.name,
                            expression: "enumtypeForm.name"
                          }
                        ],
                        staticClass: "form-control form-control-sm",
                        attrs: {
                          type: "text",
                          id: "enumtype_name",
                          name: "name",
                          autocomplete: "name",
                          autofocus: "",
                          placeholder: "Titre"
                        },
                        domProps: { value: _vm.enumtypeForm.name },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.$set(
                              _vm.enumtypeForm,
                              "name",
                              $event.target.value
                            )
                          }
                        }
                      }),
                      _vm._v(" "),
                      _vm.enumtypeForm.errors.has("name")
                        ? _c("span", {
                            staticClass: " invalid-feedback d-block text-xs",
                            attrs: { role: "alert" },
                            domProps: {
                              textContent: _vm._s(
                                _vm.enumtypeForm.errors.get("name")
                              )
                            }
                          })
                        : _vm._e()
                    ])
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "form-group row" }, [
                    _c(
                      "label",
                      {
                        staticClass: "col-sm-4 col-form-label text-xs",
                        attrs: { for: "enumtype_description" }
                      },
                      [_vm._v("Description")]
                    ),
                    _vm._v(" "),
                    _c("div", { staticClass: "col-sm-8" }, [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.enumtypeForm.description,
                            expression: "enumtypeForm.description"
                          }
                        ],
                        staticClass: "form-control form-control-sm",
                        attrs: {
                          type: "text",
                          id: "enumtype_description",
                          name: "description",
                          required: "",
                          autocomplete: "description",
                          autofocus: "",
                          placeholder: "Description"
                        },
                        domProps: { value: _vm.enumtypeForm.description },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.$set(
                              _vm.enumtypeForm,
                              "description",
                              $event.target.value
                            )
                          }
                        }
                      }),
                      _vm._v(" "),
                      _vm.enumtypeForm.errors.has("description")
                        ? _c("span", {
                            staticClass: " invalid-feedback d-block text-xs",
                            attrs: { role: "alert" },
                            domProps: {
                              textContent: _vm._s(
                                _vm.enumtypeForm.errors.get("description")
                              )
                            }
                          })
                        : _vm._e()
                    ])
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "form-group row" }, [
                    _c(
                      "label",
                      {
                        staticClass: "col-sm-4 col-form-label text-xs",
                        attrs: { for: "m_select_status" }
                      },
                      [_vm._v("Statut")]
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "col-sm-8" },
                      [
                        _c("multiselect", {
                          key: "id",
                          staticClass: "text text-xs",
                          attrs: {
                            id: "m_select_status",
                            "selected.sync": "enumtypeForm.status",
                            value: "",
                            options: _vm.statuses,
                            searchable: true,
                            multiple: false,
                            label: "name",
                            "track-by": "id",
                            placeholder: "Statut"
                          },
                          model: {
                            value: _vm.enumtypeForm.status,
                            callback: function($$v) {
                              _vm.$set(_vm.enumtypeForm, "status", $$v)
                            },
                            expression: "enumtypeForm.status"
                          }
                        }),
                        _vm._v(" "),
                        _vm.enumtypeForm.errors.has("status")
                          ? _c("span", {
                              staticClass: " invalid-feedback d-block text-xs",
                              attrs: { role: "alert" },
                              domProps: {
                                textContent: _vm._s(
                                  _vm.enumtypeForm.errors.get("status")
                                )
                              }
                            })
                          : _vm._e()
                      ],
                      1
                    )
                  ]),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "form-group row" },
                    [
                      _c(
                        "b-field",
                        {
                          staticClass: "col",
                          attrs: {
                            label: "Valeur(s)",
                            "label-position": "on-border",
                            type: _vm.enumtypeForm.errors.has("enumvalues")
                              ? "is-danger"
                              : "",
                            message: _vm.enumtypeForm.errors.get("enumvalues")
                          }
                        },
                        [
                          _c("b-taginput", {
                            attrs: {
                              autocomplete: "",
                              "allow-new": true,
                              "open-on-focus": true,
                              field: "val",
                              icon: "label",
                              placeholder: "Ajouter valeur",
                              attached: "",
                              "before-adding": _vm.checkNewEnumValue,
                              "create-tag": _vm.createEnumvalue
                            },
                            model: {
                              value: _vm.enumvalues,
                              callback: function($$v) {
                                _vm.enumvalues = $$v
                              },
                              expression: "enumvalues"
                            }
                          })
                        ],
                        1
                      )
                    ],
                    1
                  )
                ])
              ]
            )
          ]),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "modal-footer justify-content-between" },
            [
              _c(
                "b-button",
                {
                  attrs: {
                    type: "is-dark",
                    size: "is-small",
                    "data-dismiss": "modal"
                  }
                },
                [_vm._v("Fermer")]
              ),
              _vm._v(" "),
              _vm.editing
                ? _c(
                    "b-button",
                    {
                      attrs: {
                        type: "is-primary",
                        size: "is-small",
                        loading: _vm.loading,
                        disabled: !_vm.isValidCreateForm
                      },
                      on: {
                        click: function($event) {
                          return _vm.updateEnumType()
                        }
                      }
                    },
                    [_vm._v("Enregistrer")]
                  )
                : _c(
                    "b-button",
                    {
                      attrs: {
                        type: "is-primary",
                        size: "is-small",
                        loading: _vm.loading,
                        disabled: !_vm.isValidCreateForm
                      },
                      on: {
                        click: function($event) {
                          return _vm.createEnumType()
                        }
                      }
                    },
                    [_vm._v("Créer Etape")]
                  )
            ],
            1
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
    return _c(
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
  }
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/views/enumtypes/addupdate.vue":
/*!****************************************************!*\
  !*** ./resources/js/views/enumtypes/addupdate.vue ***!
  \****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _addupdate_vue_vue_type_template_id_013d64c4_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./addupdate.vue?vue&type=template&id=013d64c4&scoped=true& */ "./resources/js/views/enumtypes/addupdate.vue?vue&type=template&id=013d64c4&scoped=true&");
/* harmony import */ var _addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./addupdate.vue?vue&type=script&lang=js& */ "./resources/js/views/enumtypes/addupdate.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _addupdate_vue_vue_type_template_id_013d64c4_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _addupdate_vue_vue_type_template_id_013d64c4_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "013d64c4",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/enumtypes/addupdate.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/enumtypes/addupdate.vue?vue&type=script&lang=js&":
/*!*****************************************************************************!*\
  !*** ./resources/js/views/enumtypes/addupdate.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./addupdate.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/enumtypes/addupdate.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/enumtypes/addupdate.vue?vue&type=template&id=013d64c4&scoped=true&":
/*!***********************************************************************************************!*\
  !*** ./resources/js/views/enumtypes/addupdate.vue?vue&type=template&id=013d64c4&scoped=true& ***!
  \***********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_template_id_013d64c4_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./addupdate.vue?vue&type=template&id=013d64c4&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/enumtypes/addupdate.vue?vue&type=template&id=013d64c4&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_template_id_013d64c4_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_template_id_013d64c4_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);