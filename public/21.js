(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[21],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/reminders/addupdate.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/reminders/addupdate.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue_multiselect__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-multiselect */ "./node_modules/vue-multiselect/dist/vue-multiselect.min.js");
/* harmony import */ var vue_multiselect__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue_multiselect__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _reminders_reminderBus__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../reminders/reminderBus */ "./resources/js/views/reminders/reminderBus.js");
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
//
//
//
//
//
//
//
//
//
//
//



var Reminder = function Reminder(reminder) {
  _classCallCheck(this, Reminder);

  this.title = reminder.title || '';
  this.modeltype = reminder.modeltype || '';
  this.description = reminder.description || '';
  this.status = reminder.status || '';
  this.criteria = reminder.criteria || '';
};

/* harmony default export */ __webpack_exports__["default"] = ({
  name: "reminder-addupdate",
  components: {
    Multiselect: vue_multiselect__WEBPACK_IMPORTED_MODULE_0___default.a
  },
  mounted: function mounted() {
    var _this = this;

    _reminders_reminderBus__WEBPACK_IMPORTED_MODULE_1__["default"].$on('reminder_create', function () {
      _this.editing = false;
      _this.reminder = new Reminder({});
      _this.criteria = [];
      _this.reminderForm = new Form(_this.reminder);
      $('#addUpdateReminder').modal();
    });
    _reminders_reminderBus__WEBPACK_IMPORTED_MODULE_1__["default"].$on('reminder_edit', function (reminder) {
      _this.editing = true;
      _this.reminder = new Reminder(reminder);
      _this.reminderForm = new Form(_this.reminder);
      _this.reminderId = reminder.uuid;
      _this.criteria = reminder.criteria;
      $('#addUpdateReminder').modal();
    });
  },
  created: function created() {
    var _this2 = this;

    axios.get('/statuses.fetch').then(function (_ref) {
      var data = _ref.data;
      return _this2.statuses = data;
    });
    axios.get('/modeltypes.fetch').then(function (_ref2) {
      var data = _ref2.data;
      return _this2.models = data;
    });
  },
  data: function data() {
    return {
      reminder: {},
      criteria: [],
      reminderForm: new Form(new Reminder({})),
      reminderId: null,
      editing: false,
      loading: false,
      statuses: [],
      models: [],
      radioButton: ''
    };
  },
  methods: {
    createReminder: function createReminder() {
      var _this3 = this;

      this.loading = true;
      this.reminderForm.post('/reminders').then(function (reminder) {
        _this3.loading = false;

        _this3.closeModal();

        _this3.$swal({
          html: '<small>Reminder successfully created !</small>',
          icon: 'success',
          timer: 3000
        }).then(function () {
          _reminders_reminderBus__WEBPACK_IMPORTED_MODULE_1__["default"].$emit('reminder_created', {
            reminder: reminder
          });
        });
      })["catch"](function (error) {
        _this3.loading = false;
      });
    },
    updateReminder: function updateReminder() {
      var _this4 = this;

      this.loading = true;
      this.reminderForm.put("/reminders/".concat(this.reminderId)).then(function (reminder) {
        _this4.loading = false;

        _this4.resetForm();

        _this4.closeModal();

        _this4.$swal({
          html: '<small>Reminder successfully updated !</small>',
          icon: 'success',
          timer: 3000
        }).then(function () {
          _reminders_reminderBus__WEBPACK_IMPORTED_MODULE_1__["default"].$emit('reminder_updated', {
            reminder: reminder
          });
        });
      })["catch"](function (error) {
        _this4.loading = false;
      });
    },
    closeModal: function closeModal() {
      this.resetForm();
      $('#addUpdateReminder').modal('hide');
    },
    resetForm: function resetForm() {
      this.reminderForm.reset();
    }
  },
  computed: {
    isValidCreateForm: function isValidCreateForm() {
      return !this.loading;
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/reminders/addupdate.vue?vue&type=template&id=12e57b2d&scoped=true&":
/*!*****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/reminders/addupdate.vue?vue&type=template&id=12e57b2d&scoped=true& ***!
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
        id: "addUpdateReminder",
        tabindex: "-1",
        role: "dialog",
        "aria-labelledby": "reminderModalLabel",
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
                    attrs: { id: "reminderModalLabel" }
                  },
                  [_vm._v("Edit Reminder")]
                )
              : _c(
                  "h5",
                  {
                    staticClass: "modal-title text-sm",
                    attrs: { id: "reminderModalLabel" }
                  },
                  [_vm._v("Create New Reminder")]
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
                    return _vm.reminderForm.errors.clear()
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
                        attrs: { for: "reminder_title" }
                      },
                      [_vm._v("Title")]
                    ),
                    _vm._v(" "),
                    _c("div", { staticClass: "col-sm-8" }, [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.reminderForm.title,
                            expression: "reminderForm.title"
                          }
                        ],
                        staticClass: "form-control form-control-sm",
                        attrs: {
                          type: "text",
                          id: "reminder_title",
                          name: "title",
                          autocomplete: "title",
                          autofocus: "",
                          placeholder: "Titre"
                        },
                        domProps: { value: _vm.reminderForm.title },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.$set(
                              _vm.reminderForm,
                              "title",
                              $event.target.value
                            )
                          }
                        }
                      }),
                      _vm._v(" "),
                      _vm.reminderForm.errors.has("title")
                        ? _c("span", {
                            staticClass: " invalid-feedback d-block text-xs",
                            attrs: { role: "alert" },
                            domProps: {
                              textContent: _vm._s(
                                _vm.reminderForm.errors.get("title")
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
                        attrs: { for: "reminder_model_type" }
                      },
                      [_vm._v("Model Type")]
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "col-sm-8" },
                      [
                        _c("multiselect", {
                          key: "code",
                          staticClass: "text text-xs",
                          attrs: {
                            id: "reminder_model_type",
                            "selected.sync": "reminderForm.modeltype",
                            value: "",
                            options: _vm.models,
                            searchable: true,
                            multiple: false,
                            label: "label",
                            "track-by": "code",
                            placeholder: "Model Type"
                          },
                          model: {
                            value: _vm.reminderForm.modeltype,
                            callback: function($$v) {
                              _vm.$set(_vm.reminderForm, "modeltype", $$v)
                            },
                            expression: "reminderForm.modeltype"
                          }
                        }),
                        _vm._v(" "),
                        _vm.reminderForm.errors.has("modeltype")
                          ? _c("span", {
                              staticClass: " invalid-feedback d-block text-xs",
                              attrs: { role: "alert" },
                              domProps: {
                                textContent: _vm._s(
                                  _vm.reminderForm.errors.get("modeltype")
                                )
                              }
                            })
                          : _vm._e()
                      ],
                      1
                    )
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "form-group row" }, [
                    _c(
                      "label",
                      {
                        staticClass: "col-sm-4 col-form-label text-xs",
                        attrs: { for: "reminder_description" }
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
                            value: _vm.reminderForm.description,
                            expression: "reminderForm.description"
                          }
                        ],
                        staticClass: "form-control form-control-sm",
                        attrs: {
                          type: "text",
                          id: "reminder_description",
                          name: "description",
                          required: "",
                          autocomplete: "description",
                          autofocus: "",
                          placeholder: "Description"
                        },
                        domProps: { value: _vm.reminderForm.description },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.$set(
                              _vm.reminderForm,
                              "description",
                              $event.target.value
                            )
                          }
                        }
                      }),
                      _vm._v(" "),
                      _vm.reminderForm.errors.has("description")
                        ? _c("span", {
                            staticClass: " invalid-feedback d-block text-xs",
                            attrs: { role: "alert" },
                            domProps: {
                              textContent: _vm._s(
                                _vm.reminderForm.errors.get("description")
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
                      [_vm._v("Status")]
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
                            "selected.sync": "reminderForm.status",
                            value: "",
                            options: _vm.statuses,
                            searchable: true,
                            multiple: false,
                            label: "name",
                            "track-by": "id",
                            placeholder: "Status"
                          },
                          model: {
                            value: _vm.reminderForm.status,
                            callback: function($$v) {
                              _vm.$set(_vm.reminderForm, "status", $$v)
                            },
                            expression: "reminderForm.status"
                          }
                        }),
                        _vm._v(" "),
                        _vm.reminderForm.errors.has("status")
                          ? _c("span", {
                              staticClass: " invalid-feedback d-block text-xs",
                              attrs: { role: "alert" },
                              domProps: {
                                textContent: _vm._s(
                                  _vm.reminderForm.errors.get("status")
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
                            label: "Criteria",
                            type: _vm.reminderForm.errors.has("criteria")
                              ? "is-danger"
                              : "",
                            message: _vm.reminderForm.errors.get("criteria")
                          }
                        },
                        [
                          _c(
                            "b-taglist",
                            _vm._l(_vm.criteria, function(criterion) {
                              return _c(
                                "b-tag",
                                {
                                  key: criterion.id,
                                  attrs: { type: "is-info" }
                                },
                                [_vm._v(_vm._s(criterion.title))]
                              )
                            }),
                            1
                          )
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
                          return _vm.updateReminder()
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
                          return _vm.createReminder()
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

/***/ "./resources/js/views/reminders/addupdate.vue":
/*!****************************************************!*\
  !*** ./resources/js/views/reminders/addupdate.vue ***!
  \****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _addupdate_vue_vue_type_template_id_12e57b2d_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./addupdate.vue?vue&type=template&id=12e57b2d&scoped=true& */ "./resources/js/views/reminders/addupdate.vue?vue&type=template&id=12e57b2d&scoped=true&");
/* harmony import */ var _addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./addupdate.vue?vue&type=script&lang=js& */ "./resources/js/views/reminders/addupdate.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _addupdate_vue_vue_type_template_id_12e57b2d_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _addupdate_vue_vue_type_template_id_12e57b2d_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "12e57b2d",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/reminders/addupdate.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/reminders/addupdate.vue?vue&type=script&lang=js&":
/*!*****************************************************************************!*\
  !*** ./resources/js/views/reminders/addupdate.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./addupdate.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/reminders/addupdate.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/reminders/addupdate.vue?vue&type=template&id=12e57b2d&scoped=true&":
/*!***********************************************************************************************!*\
  !*** ./resources/js/views/reminders/addupdate.vue?vue&type=template&id=12e57b2d&scoped=true& ***!
  \***********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_template_id_12e57b2d_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./addupdate.vue?vue&type=template&id=12e57b2d&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/reminders/addupdate.vue?vue&type=template&id=12e57b2d&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_template_id_12e57b2d_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_template_id_12e57b2d_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);