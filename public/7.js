(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[7],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/statuses/addupdate.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/statuses/addupdate.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue_multiselect__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-multiselect */ "./node_modules/vue-multiselect/dist/vue-multiselect.min.js");
/* harmony import */ var vue_multiselect__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue_multiselect__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _statusBus__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./statusBus */ "./resources/js/views/statuses/statusBus.js");
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



var Status = function Status(status) {
  _classCallCheck(this, Status);

  this.name = status.name || '';
  this.code = status.code || '';
  this.is_default = status.is_default || false;
  this.description = status.description || '';
};

/* harmony default export */ __webpack_exports__["default"] = ({
  name: "status-addupdate",
  components: {
    Multiselect: vue_multiselect__WEBPACK_IMPORTED_MODULE_0___default.a
  },
  mounted: function mounted() {
    var _this = this;

    _statusBus__WEBPACK_IMPORTED_MODULE_1__["default"].$on('status_edit', function (status) {
      _this.editing = true;
      _this.status = new Status(status);
      _this.statusForm = new Form(_this.status);
      _this.statusId = status.id;
      $('#addUpdateStatus').modal();
    });
  },
  created: function created() {
    var _this2 = this;

    axios.get('/statuses.fetch').then(function (_ref) {
      var data = _ref.data;
      return _this2.groups = data;
    });
  },
  data: function data() {
    return {
      status: {},
      statusForm: new Form(new Status({})),
      statusId: null,
      editing: false,
      loading: false,
      groups: []
    };
  },
  methods: {
    updateStatus: function updateStatus() {
      var _this3 = this;

      this.loading = true;
      this.statusForm.put("/statuses/".concat(this.statusId)).then(function (status) {
        _this3.loading = false;

        _this3.resetForm();

        $('#addUpdateStatus').modal('hide');

        _this3.$swal({
          html: '<small>Status successfully updated !</small>',
          icon: 'success',
          timer: 3000
        }).then(function () {
          _statusBus__WEBPACK_IMPORTED_MODULE_1__["default"].$emit('status_updated', status);
        });
      })["catch"](function (error) {
        _this3.loading = false;
      });
    },
    closeModal: function closeModal() {
      this.resetForm();
      $('#addUpdateStatus').modal('hide');
    },
    resetForm: function resetForm() {
      this.statusForm.reset();
    }
  },
  computed: {
    isValidForm: function isValidForm() {
      return !this.loading;
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/statuses/addupdate.vue?vue&type=template&id=562ddf3a&scoped=true&":
/*!****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/statuses/addupdate.vue?vue&type=template&id=562ddf3a&scoped=true& ***!
  \****************************************************************************************************************************************************************************************************************************/
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
        id: "addUpdateStatus",
        tabindex: "-1",
        role: "dialog",
        "aria-labelledby": "statusModalLabel",
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
                    attrs: { id: "statusModalLabel" }
                  },
                  [_vm._v("Edit Status")]
                )
              : _c(
                  "h5",
                  {
                    staticClass: "modal-title text-sm",
                    attrs: { id: "statusModalLabel" }
                  },
                  [_vm._v("Create New Status")]
                ),
            _vm._v(" "),
            _c(
              "button",
              {
                staticClass: "close",
                attrs: { type: "button", "aria-label": "Close" },
                on: { click: _vm.closeModal }
              },
              [_c("span", { attrs: { "aria-hidden": "true" } }, [_vm._v("×")])]
            )
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
                    return _vm.statusForm.errors.clear()
                  }
                }
              },
              [
                _c("div", { staticClass: "card-body" }, [
                  _c("div", { staticClass: "form-group row" }, [
                    _c(
                      "label",
                      {
                        staticClass: "col-sm-4 col-form-label text-xs text-xs",
                        attrs: { for: "name" }
                      },
                      [_vm._v("Name")]
                    ),
                    _vm._v(" "),
                    _c("div", { staticClass: "col-sm-8" }, [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.statusForm.name,
                            expression: "statusForm.name"
                          }
                        ],
                        staticClass: "form-control form-control-sm",
                        attrs: {
                          type: "text",
                          id: "name",
                          name: "name",
                          placeholder: "Name",
                          readonly: ""
                        },
                        domProps: { value: _vm.statusForm.name },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.$set(
                              _vm.statusForm,
                              "name",
                              $event.target.value
                            )
                          }
                        }
                      }),
                      _vm._v(" "),
                      _vm.statusForm.errors.has("name")
                        ? _c("span", {
                            staticClass: "invalid-feedback d-block text-xs",
                            attrs: { role: "alert" },
                            domProps: {
                              textContent: _vm._s(
                                _vm.statusForm.errors.get("name")
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
                        staticClass: "col-sm-4 col-form-label text-xs text-xs",
                        attrs: { for: "code" }
                      },
                      [_vm._v("Code")]
                    ),
                    _vm._v(" "),
                    _c("div", { staticClass: "col-sm-8" }, [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.statusForm.code,
                            expression: "statusForm.code"
                          }
                        ],
                        staticClass: "form-control form-control-sm",
                        attrs: {
                          type: "text",
                          id: "code",
                          name: "code",
                          placeholder: "Code"
                        },
                        domProps: { value: _vm.statusForm.code },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.$set(
                              _vm.statusForm,
                              "code",
                              $event.target.value
                            )
                          }
                        }
                      }),
                      _vm._v(" "),
                      _vm.statusForm.errors.has("code")
                        ? _c("span", {
                            staticClass: "invalid-feedback d-block text-xs",
                            attrs: { role: "alert" },
                            domProps: {
                              textContent: _vm._s(
                                _vm.statusForm.errors.get("code")
                              )
                            }
                          })
                        : _vm._e()
                    ])
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "form-group row" }, [
                    _c("div", { staticClass: "col-sm-4" }),
                    _vm._v(" "),
                    _c(
                      "div",
                      {
                        staticClass:
                          "col-sm-8 custom-control custom-switch custom-switch-off-danger custom-switch-on-success"
                      },
                      [
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.statusForm.is_default,
                              expression: "statusForm.is_default"
                            }
                          ],
                          staticClass: "custom-control-input",
                          attrs: {
                            type: "checkbox",
                            id: "is_default",
                            name: "is_default",
                            autocomplete: "is_default",
                            autofocus: "",
                            placeholder: "Is default ?"
                          },
                          domProps: {
                            checked: Array.isArray(_vm.statusForm.is_default)
                              ? _vm._i(_vm.statusForm.is_default, null) > -1
                              : _vm.statusForm.is_default
                          },
                          on: {
                            change: function($event) {
                              var $$a = _vm.statusForm.is_default,
                                $$el = $event.target,
                                $$c = $$el.checked ? true : false
                              if (Array.isArray($$a)) {
                                var $$v = null,
                                  $$i = _vm._i($$a, $$v)
                                if ($$el.checked) {
                                  $$i < 0 &&
                                    _vm.$set(
                                      _vm.statusForm,
                                      "is_default",
                                      $$a.concat([$$v])
                                    )
                                } else {
                                  $$i > -1 &&
                                    _vm.$set(
                                      _vm.statusForm,
                                      "is_default",
                                      $$a
                                        .slice(0, $$i)
                                        .concat($$a.slice($$i + 1))
                                    )
                                }
                              } else {
                                _vm.$set(_vm.statusForm, "is_default", $$c)
                              }
                            }
                          }
                        }),
                        _vm._v(" "),
                        _vm._m(0),
                        _vm._v(" "),
                        _vm.statusForm.errors.has("is_default")
                          ? _c("span", {
                              staticClass: "invalid-feedback d-block text-xs",
                              attrs: { role: "alert" },
                              domProps: {
                                textContent: _vm._s(
                                  _vm.statusForm.errors.get("is_default")
                                )
                              }
                            })
                          : _vm._e()
                      ]
                    )
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "form-group row" }, [
                    _c(
                      "label",
                      {
                        staticClass: "col-sm-4 col-form-label text-xs text-xs",
                        attrs: { for: "description" }
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
                            value: _vm.statusForm.description,
                            expression: "statusForm.description"
                          }
                        ],
                        staticClass: "form-control form-control-sm",
                        attrs: {
                          type: "text",
                          id: "description",
                          name: "description",
                          placeholder: "Description"
                        },
                        domProps: { value: _vm.statusForm.description },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.$set(
                              _vm.statusForm,
                              "description",
                              $event.target.value
                            )
                          }
                        }
                      }),
                      _vm._v(" "),
                      _vm.statusForm.errors.has("description")
                        ? _c("span", {
                            staticClass: "invalid-feedback d-block text-xs",
                            attrs: { role: "alert" },
                            domProps: {
                              textContent: _vm._s(
                                _vm.statusForm.errors.get("description")
                              )
                            }
                          })
                        : _vm._e()
                    ])
                  ])
                ])
              ]
            )
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "modal-footer justify-content-between" }, [
            _c(
              "button",
              {
                staticClass: "btn btn-secondary btn-sm",
                attrs: { type: "button" },
                on: { click: _vm.closeModal }
              },
              [_vm._v("Close")]
            ),
            _vm._v(" "),
            _vm.editing
              ? _c(
                  "button",
                  {
                    staticClass: "btn btn-primary btn-sm",
                    attrs: { type: "button", disabled: !_vm.isValidForm },
                    on: {
                      click: function($event) {
                        return _vm.updateStatus()
                      }
                    }
                  },
                  [_vm._v("Save")]
                )
              : _c(
                  "button",
                  {
                    staticClass: "btn btn-primary btn-sm",
                    attrs: { type: "button", disabled: !_vm.isValidForm },
                    on: {
                      click: function($event) {
                        return _vm.createStatus()
                      }
                    }
                  },
                  [_vm._v("Create New Status")]
                )
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
    return _c(
      "label",
      { staticClass: "custom-control-label", attrs: { for: "is_default" } },
      [_c("span", { staticClass: "text text-xs" }, [_vm._v("Is default ?")])]
    )
  }
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/views/statuses/addupdate.vue":
/*!***************************************************!*\
  !*** ./resources/js/views/statuses/addupdate.vue ***!
  \***************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _addupdate_vue_vue_type_template_id_562ddf3a_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./addupdate.vue?vue&type=template&id=562ddf3a&scoped=true& */ "./resources/js/views/statuses/addupdate.vue?vue&type=template&id=562ddf3a&scoped=true&");
/* harmony import */ var _addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./addupdate.vue?vue&type=script&lang=js& */ "./resources/js/views/statuses/addupdate.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _addupdate_vue_vue_type_template_id_562ddf3a_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _addupdate_vue_vue_type_template_id_562ddf3a_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "562ddf3a",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/statuses/addupdate.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/statuses/addupdate.vue?vue&type=script&lang=js&":
/*!****************************************************************************!*\
  !*** ./resources/js/views/statuses/addupdate.vue?vue&type=script&lang=js& ***!
  \****************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./addupdate.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/statuses/addupdate.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/statuses/addupdate.vue?vue&type=template&id=562ddf3a&scoped=true&":
/*!**********************************************************************************************!*\
  !*** ./resources/js/views/statuses/addupdate.vue?vue&type=template&id=562ddf3a&scoped=true& ***!
  \**********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_template_id_562ddf3a_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./addupdate.vue?vue&type=template&id=562ddf3a&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/statuses/addupdate.vue?vue&type=template&id=562ddf3a&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_template_id_562ddf3a_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_template_id_562ddf3a_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/views/statuses/statusBus.js":
/*!**************************************************!*\
  !*** ./resources/js/views/statuses/statusBus.js ***!
  \**************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.common.js");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);

/* harmony default export */ __webpack_exports__["default"] = (new vue__WEBPACK_IMPORTED_MODULE_0___default.a());

/***/ })

}]);