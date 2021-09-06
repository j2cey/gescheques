(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[22],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/workflowactions/addupdate.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/workflowactions/addupdate.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue_multiselect__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-multiselect */ "./node_modules/vue-multiselect/dist/vue-multiselect.min.js");
/* harmony import */ var vue_multiselect__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue_multiselect__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _actionBus__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./actionBus */ "./resources/js/views/workflowactions/actionBus.js");
/* harmony import */ var _workflowsteps_stepBus__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../workflowsteps/stepBus */ "./resources/js/views/workflowsteps/stepBus.js");
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//




var Workflowaction = function Workflowaction(workflowaction) {
  _classCallCheck(this, Workflowaction);

  this.titre = workflowaction.titre || '';
  this.description = workflowaction.description || '';
  this.workflow_step_id = workflowaction.workflow_step_id || '';
  this.actiontype = workflowaction.actiontype || '';
  this.treatmenttype = workflowaction.treatmenttype || '';
  this.mimetypes = workflowaction.mimetypes || '';
  this.field_required = workflowaction.field_required || false;
  this.field_required_msg = workflowaction.field_required_msg || '';
  this.field_required_without = workflowaction.field_required_without || false;
  this.actionsrequiredwithout = workflowaction.actionsrequiredwithout || '';
  this.field_required_without_msg = workflowaction.field_required_without_msg || '';
  this.field_required_with = workflowaction.field_required_with || false;
  this.actionsrequiredwith = workflowaction.actionsrequiredwith || '';
  this.field_required_with_msg = workflowaction.field_required_with_msg || '';
};

/* harmony default export */ __webpack_exports__["default"] = ({
  name: "action-addupdate",
  props: {},
  components: {
    Multiselect: vue_multiselect__WEBPACK_IMPORTED_MODULE_0___default.a
  },
  mounted: function mounted() {
    var _this = this;

    _actionBus__WEBPACK_IMPORTED_MODULE_1__["default"].$on('workflowaction_create', function (workflowstep, actionsofstep) {
      _this.editing = false;
      _this.workflowstepId = workflowstep.id;
      _this.workflowaction = new Workflowaction({});
      _this.workflowaction.workflow_step_id = workflowstep.id;
      _this.workflowactionForm = new Form(_this.workflowaction);
      _this.actionsofstep = actionsofstep;
      $('#addUpdateWorkflowaction').modal();
    });
    _actionBus__WEBPACK_IMPORTED_MODULE_1__["default"].$on('workflowaction_edit', function (workflowaction, actionsofstep) {
      _this.editing = true;
      _this.workflowaction = new Workflowaction(workflowaction);
      _this.workflowactionForm = new Form(_this.workflowaction);
      _this.workflowactionId = workflowaction.uuid;
      _this.workflowstepId = workflowaction.workflow_step_id;
      _this.actionsofstep = actionsofstep;
      $('#addUpdateWorkflowaction').modal();
    });
    this.$parent.$on('create_new_workflowaction', function (workflowstepId) {
      console.log('create_new_workflowaction--received', workflowstepId);
      _this.editing = false;
      _this.workflowstepId = workflowstepId;
      _this.workflowaction = new Workflowaction({});
      _this.workflowaction.workflow_step_id = workflowstepId;
      _this.workflowactionForm = new Form(_this.workflowaction);
      $('#addUpdateWorkflowaction').modal();
    });
    this.$parent.$on('edit_workflowaction', function (_ref) {
      var workflowaction = _ref.workflowaction;
      _this.editing = true;
      _this.workflowaction = new Workflowaction(workflowaction);
      _this.workflowactionForm = new Form(_this.workflowaction);
      _this.workflowactionId = workflowaction.uuid;
      _this.workflowstepId = workflowaction.workflow_step_id;
      $('#addUpdateWorkflowaction').modal();
    });
  },
  created: function created() {
    var _this2 = this;

    axios.get('/workflowactiontypes.fetch').then(function (_ref2) {
      var data = _ref2.data;
      return _this2.workflowactiontypes = data;
    });
    axios.get('/workflowtreatmenttypes.fetch').then(function (_ref3) {
      var data = _ref3.data;
      return _this2.workflowtreatmenttypes = data;
    });
    axios.get('/mimetypes.fetch').then(function (_ref4) {
      var data = _ref4.data;
      return _this2.mimetypes = data;
    });
    axios.get('/workflowactions.fetchbystep/0').then(function (_ref5) {
      var data = _ref5.data;
      return _this2.actionsofstep = data;
    });
  },
  data: function data() {
    return {
      workflowaction: {},
      workflowstepId: '',
      workflowactionForm: new Form(new Workflowaction({})),
      workflowactionId: null,
      editing: false,
      loading: false,
      workflowactiontypes: [],
      workflowtreatmenttypes: [],
      mimetypes: [],
      actionsofstep: []
    };
  },
  methods: {
    createWorkflowaction: function createWorkflowaction(workflowstepId) {
      var _this3 = this;

      this.loading = true; //this.workflowactionForm.workflow_step_id = this.workflowactionId
      //console.log("createWorkflowaction", this.workflowactionId, this.workflowactionForm)

      this.workflowactionForm.post('/workflowactions').then(function (resp) {
        _this3.loading = false; // on émet l'action créé dans le bus Action

        console.log('workflowactions post resp: ', resp);
        var action = resp.action;
        var step = resp.step;
        $('#addUpdateWorkflowaction').modal('hide');

        _this3.$swal({
          html: '<small>Action créée avec succès !</small>',
          icon: 'success',
          timer: 3000
        }).then(function () {
          _actionBus__WEBPACK_IMPORTED_MODULE_1__["default"].$emit('workflowaction_created', {
            action: action,
            step: step
          });
        });
      })["catch"](function (error) {
        _this3.loading = false;
      });
    },
    updateWorkflowaction: function updateWorkflowaction(workflowstepId) {
      var _this4 = this;

      this.loading = true;
      this.workflowactionForm.put("/workflowactions/".concat(this.workflowactionId)).then(function (resp) {
        _this4.loading = false;
        var action = resp.action;
        var step = resp.step;
        $('#addUpdateWorkflowaction').modal('hide');

        _this4.$swal({
          html: '<small>Action modifiée avec succès !</small>',
          icon: 'success',
          timer: 3000
        }).then(function () {
          _actionBus__WEBPACK_IMPORTED_MODULE_1__["default"].$emit('workflowaction_updated', {
            action: action,
            step: step
          });
        });
      })["catch"](function (error) {
        _this4.loading = false;
      });
    }
  },
  computed: {
    isValidCreateForm: function isValidCreateForm() {
      return !this.loading;
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/workflowactions/addupdate.vue?vue&type=template&id=4091f3ca&":
/*!***********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/workflowactions/addupdate.vue?vue&type=template&id=4091f3ca& ***!
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
        id: "addUpdateWorkflowaction",
        tabindex: "-1",
        role: "dialog",
        "aria-labelledby": "exampleModalLabel",
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
                    attrs: { id: "exampleModalLabel" }
                  },
                  [_vm._v("Modifier Action")]
                )
              : _c(
                  "h5",
                  {
                    staticClass: "modal-title text-sm",
                    attrs: { id: "exampleModalLabel" }
                  },
                  [_vm._v("Créer Nouvelle Action")]
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
                    return _vm.workflowactionForm.errors.clear()
                  }
                }
              },
              [
                _c("div", { staticClass: "card-body" }, [
                  _c("div", { staticClass: "form-group row" }, [
                    _c(
                      "label",
                      {
                        staticClass: "col-sm-2 col-form-label text-xs text-xs",
                        attrs: { for: "action_titre" }
                      },
                      [_vm._v("Titre")]
                    ),
                    _vm._v(" "),
                    _c("div", { staticClass: "col-sm-10" }, [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.workflowactionForm.titre,
                            expression: "workflowactionForm.titre"
                          }
                        ],
                        staticClass: "form-control form-control-sm",
                        attrs: {
                          type: "text",
                          id: "action_titre",
                          name: "titre",
                          placeholder: "Titre"
                        },
                        domProps: { value: _vm.workflowactionForm.titre },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.$set(
                              _vm.workflowactionForm,
                              "titre",
                              $event.target.value
                            )
                          }
                        }
                      }),
                      _vm._v(" "),
                      _vm.workflowactionForm.errors.has("titre")
                        ? _c("span", {
                            staticClass: "invalid-feedback d-block text-xs",
                            attrs: { role: "alert" },
                            domProps: {
                              textContent: _vm._s(
                                _vm.workflowactionForm.errors.get("titre")
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
                        staticClass: "col-sm-2 col-form-label text-xs",
                        attrs: { for: "m_select_action_type" }
                      },
                      [_vm._v("Type Action")]
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "col-sm-10 text-xs" },
                      [
                        _c("multiselect", {
                          key: "id",
                          attrs: {
                            id: "m_select_action_type",
                            "selected.sync": "workflowaction.actiontype",
                            value: "",
                            options: _vm.workflowactiontypes,
                            searchable: true,
                            multiple: false,
                            label: "name",
                            "track-by": "id",
                            placeholder: "Type Action"
                          },
                          model: {
                            value: _vm.workflowactionForm.actiontype,
                            callback: function($$v) {
                              _vm.$set(
                                _vm.workflowactionForm,
                                "actiontype",
                                $$v
                              )
                            },
                            expression: "workflowactionForm.actiontype"
                          }
                        }),
                        _vm._v(" "),
                        _vm.workflowactionForm.errors.has("actiontype")
                          ? _c("span", {
                              staticClass: "invalid-feedback d-block text-xs",
                              attrs: { role: "alert" },
                              domProps: {
                                textContent: _vm._s(
                                  _vm.workflowactionForm.errors.get(
                                    "actiontype"
                                  )
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
                        staticClass: "col-sm-2 col-form-label text-xs",
                        attrs: { for: "m_select_treatment_type" }
                      },
                      [_vm._v("Type Traitement")]
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "col-sm-10 text-xs" },
                      [
                        _c("multiselect", {
                          key: "id",
                          attrs: {
                            id: "m_select_treatment_type",
                            "selected.sync": "workflowaction.treatmenttype",
                            value: "",
                            options: _vm.workflowtreatmenttypes,
                            searchable: true,
                            multiple: false,
                            label: "name",
                            "track-by": "id",
                            placeholder: "Type Traitement"
                          },
                          model: {
                            value: _vm.workflowactionForm.treatmenttype,
                            callback: function($$v) {
                              _vm.$set(
                                _vm.workflowactionForm,
                                "treatmenttype",
                                $$v
                              )
                            },
                            expression: "workflowactionForm.treatmenttype"
                          }
                        }),
                        _vm._v(" "),
                        _vm.workflowactionForm.errors.has("treatmenttype")
                          ? _c("span", {
                              staticClass: "invalid-feedback d-block text-xs",
                              attrs: { role: "alert" },
                              domProps: {
                                textContent: _vm._s(
                                  _vm.workflowactionForm.errors.get(
                                    "treatmenttype"
                                  )
                                )
                              }
                            })
                          : _vm._e()
                      ],
                      1
                    )
                  ]),
                  _vm._v(" "),
                  _vm.workflowactionForm.actiontype &&
                  _vm.workflowactionForm.actiontype.code === "FILE_ref"
                    ? _c("div", { staticClass: "form-group row" }, [
                        _c("div", { staticClass: "col-sm-2 text-xs" }),
                        _vm._v(" "),
                        _c(
                          "label",
                          {
                            staticClass: "col-sm-4 col-form-label text-xs",
                            attrs: { for: "m_select_action_type_mimetype" }
                          },
                          [_vm._v("Type(s) de fichier")]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "col-sm-6 text-xs" },
                          [
                            _c("multiselect", {
                              key: "id",
                              attrs: {
                                id: "m_select_action_type_mimetype",
                                "selected.sync": "workflowaction.mimetypes",
                                value: "",
                                options: _vm.mimetypes,
                                searchable: true,
                                multiple: true,
                                label: "name",
                                "track-by": "id",
                                placeholder: "Type(s) fichier"
                              },
                              model: {
                                value: _vm.workflowactionForm.mimetypes,
                                callback: function($$v) {
                                  _vm.$set(
                                    _vm.workflowactionForm,
                                    "mimetypes",
                                    $$v
                                  )
                                },
                                expression: "workflowactionForm.mimetypes"
                              }
                            }),
                            _vm._v(" "),
                            _vm.workflowactionForm.errors.has("mimetypes")
                              ? _c("span", {
                                  staticClass:
                                    "invalid-feedback d-block text-xs",
                                  attrs: { role: "alert" },
                                  domProps: {
                                    textContent: _vm._s(
                                      _vm.workflowactionForm.errors.get(
                                        "mimetypes"
                                      )
                                    )
                                  }
                                })
                              : _vm._e()
                          ],
                          1
                        )
                      ])
                    : _vm._e(),
                  _vm._v(" "),
                  _c("div", { staticClass: "form-group row" }, [
                    _c(
                      "label",
                      {
                        staticClass: "col-sm-2 col-form-label text-xs",
                        attrs: { for: "action_description" }
                      },
                      [_vm._v("Description")]
                    ),
                    _vm._v(" "),
                    _c("div", { staticClass: "col-sm-10" }, [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.workflowactionForm.description,
                            expression: "workflowactionForm.description"
                          }
                        ],
                        staticClass: "form-control form-control-sm",
                        attrs: {
                          type: "text",
                          id: "action_description",
                          name: "description",
                          required: "",
                          autocomplete: "description",
                          autofocus: "",
                          placeholder: "Description"
                        },
                        domProps: { value: _vm.workflowactionForm.description },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.$set(
                              _vm.workflowactionForm,
                              "description",
                              $event.target.value
                            )
                          }
                        }
                      }),
                      _vm._v(" "),
                      _vm.workflowactionForm.errors.has("description")
                        ? _c("span", {
                            staticClass: "invalid-feedback d-block text-xs",
                            attrs: { role: "alert" },
                            domProps: {
                              textContent: _vm._s(
                                _vm.workflowactionForm.errors.get("description")
                              )
                            }
                          })
                        : _vm._e()
                    ])
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "form-group" }, [
                    _c(
                      "div",
                      {
                        staticClass:
                          "custom-control custom-switch custom-switch-off-danger custom-switch-on-success"
                      },
                      [
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.workflowactionForm.field_required,
                              expression: "workflowactionForm.field_required"
                            }
                          ],
                          staticClass: "custom-control-input",
                          attrs: {
                            type: "checkbox",
                            id: "field_required",
                            name: "field_required",
                            autocomplete: "field_required",
                            autofocus: "",
                            placeholder: "Champs Requis ?"
                          },
                          domProps: {
                            checked: Array.isArray(
                              _vm.workflowactionForm.field_required
                            )
                              ? _vm._i(
                                  _vm.workflowactionForm.field_required,
                                  null
                                ) > -1
                              : _vm.workflowactionForm.field_required
                          },
                          on: {
                            change: function($event) {
                              var $$a = _vm.workflowactionForm.field_required,
                                $$el = $event.target,
                                $$c = $$el.checked ? true : false
                              if (Array.isArray($$a)) {
                                var $$v = null,
                                  $$i = _vm._i($$a, $$v)
                                if ($$el.checked) {
                                  $$i < 0 &&
                                    _vm.$set(
                                      _vm.workflowactionForm,
                                      "field_required",
                                      $$a.concat([$$v])
                                    )
                                } else {
                                  $$i > -1 &&
                                    _vm.$set(
                                      _vm.workflowactionForm,
                                      "field_required",
                                      $$a
                                        .slice(0, $$i)
                                        .concat($$a.slice($$i + 1))
                                    )
                                }
                              } else {
                                _vm.$set(
                                  _vm.workflowactionForm,
                                  "field_required",
                                  $$c
                                )
                              }
                            }
                          }
                        }),
                        _vm._v(" "),
                        _vm._m(1),
                        _vm._v(" "),
                        _vm.workflowactionForm.errors.has("field_required")
                          ? _c("span", {
                              staticClass: "invalid-feedback d-block text-xs",
                              attrs: { role: "alert" },
                              domProps: {
                                textContent: _vm._s(
                                  _vm.workflowactionForm.errors.get(
                                    "field_required"
                                  )
                                )
                              }
                            })
                          : _vm._e()
                      ]
                    )
                  ]),
                  _vm._v(" "),
                  _vm.workflowactionForm.field_required
                    ? _c("div", { staticClass: "form-group row" }, [
                        _c(
                          "label",
                          {
                            staticClass: "col-sm-4 col-form-label text-xs",
                            attrs: { for: "field_required_msg" }
                          },
                          [_vm._v("Message Erreur")]
                        ),
                        _vm._v(" "),
                        _c("div", { staticClass: "col-sm-8" }, [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value:
                                  _vm.workflowactionForm.field_required_msg,
                                expression:
                                  "workflowactionForm.field_required_msg"
                              }
                            ],
                            staticClass: "form-control form-control-sm",
                            attrs: {
                              type: "text",
                              id: "field_required_msg",
                              name: "field_required_msg",
                              autocomplete: "field_required_msg",
                              placeholder: "Message Erreur"
                            },
                            domProps: {
                              value: _vm.workflowactionForm.field_required_msg
                            },
                            on: {
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.$set(
                                  _vm.workflowactionForm,
                                  "field_required_msg",
                                  $event.target.value
                                )
                              }
                            }
                          }),
                          _vm._v(" "),
                          _vm.workflowactionForm.errors.has(
                            "field_required_msg"
                          )
                            ? _c("span", {
                                staticClass: "invalid-feedback d-block text-xs",
                                attrs: { role: "alert" },
                                domProps: {
                                  textContent: _vm._s(
                                    _vm.workflowactionForm.errors.get(
                                      "field_required_msg"
                                    )
                                  )
                                }
                              })
                            : _vm._e()
                        ])
                      ])
                    : _vm._e(),
                  _vm._v(" "),
                  _c("div", { staticClass: "form-group" }, [
                    _c(
                      "div",
                      {
                        staticClass:
                          "custom-control custom-switch custom-switch-off-danger custom-switch-on-success"
                      },
                      [
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value:
                                _vm.workflowactionForm.field_required_without,
                              expression:
                                "workflowactionForm.field_required_without"
                            }
                          ],
                          staticClass: "custom-control-input",
                          attrs: {
                            type: "checkbox",
                            id: "field_required_without",
                            name: "field_required_without",
                            autocomplete: "field_required_without",
                            autofocus: "",
                            placeholder:
                              "Champs Requis sans le(s) champs spécifié(s) ?"
                          },
                          domProps: {
                            checked: Array.isArray(
                              _vm.workflowactionForm.field_required_without
                            )
                              ? _vm._i(
                                  _vm.workflowactionForm.field_required_without,
                                  null
                                ) > -1
                              : _vm.workflowactionForm.field_required_without
                          },
                          on: {
                            change: function($event) {
                              var $$a =
                                  _vm.workflowactionForm.field_required_without,
                                $$el = $event.target,
                                $$c = $$el.checked ? true : false
                              if (Array.isArray($$a)) {
                                var $$v = null,
                                  $$i = _vm._i($$a, $$v)
                                if ($$el.checked) {
                                  $$i < 0 &&
                                    _vm.$set(
                                      _vm.workflowactionForm,
                                      "field_required_without",
                                      $$a.concat([$$v])
                                    )
                                } else {
                                  $$i > -1 &&
                                    _vm.$set(
                                      _vm.workflowactionForm,
                                      "field_required_without",
                                      $$a
                                        .slice(0, $$i)
                                        .concat($$a.slice($$i + 1))
                                    )
                                }
                              } else {
                                _vm.$set(
                                  _vm.workflowactionForm,
                                  "field_required_without",
                                  $$c
                                )
                              }
                            }
                          }
                        }),
                        _vm._v(" "),
                        _vm._m(2),
                        _vm._v(" "),
                        _vm.workflowactionForm.errors.has(
                          "field_required_without"
                        )
                          ? _c("span", {
                              staticClass: "invalid-feedback d-block text-xs",
                              attrs: { role: "alert" },
                              domProps: {
                                textContent: _vm._s(
                                  _vm.workflowactionForm.errors.get(
                                    "field_required_without"
                                  )
                                )
                              }
                            })
                          : _vm._e()
                      ]
                    )
                  ]),
                  _vm._v(" "),
                  _vm.workflowactionForm.field_required_without
                    ? _c("div", { staticClass: "form-group row" }, [
                        _c(
                          "label",
                          {
                            staticClass: "col-sm-4 col-form-label text-xs",
                            attrs: { for: "m_select_action_without" }
                          },
                          [_vm._v("Liste des champs")]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "col-sm-8 text-xs" },
                          [
                            _c("multiselect", {
                              key: "id",
                              attrs: {
                                id: "m_select_action_without",
                                "selected.sync":
                                  "workflowaction.actionsrequiredwithout",
                                value: "",
                                options: _vm.actionsofstep,
                                searchable: true,
                                multiple: true,
                                label: "titre",
                                "track-by": "id",
                                placeholder: "Liste d Actions"
                              },
                              model: {
                                value:
                                  _vm.workflowactionForm.actionsrequiredwithout,
                                callback: function($$v) {
                                  _vm.$set(
                                    _vm.workflowactionForm,
                                    "actionsrequiredwithout",
                                    $$v
                                  )
                                },
                                expression:
                                  "workflowactionForm.actionsrequiredwithout"
                              }
                            }),
                            _vm._v(" "),
                            _vm.workflowactionForm.errors.has(
                              "actionsrequiredwithout"
                            )
                              ? _c("span", {
                                  staticClass:
                                    "invalid-feedback d-block text-xs",
                                  attrs: { role: "alert" },
                                  domProps: {
                                    textContent: _vm._s(
                                      _vm.workflowactionForm.errors.get(
                                        "actionsrequiredwithout"
                                      )
                                    )
                                  }
                                })
                              : _vm._e()
                          ],
                          1
                        )
                      ])
                    : _vm._e(),
                  _vm._v(" "),
                  _vm.workflowactionForm.field_required_without
                    ? _c("div", { staticClass: "form-group row" }, [
                        _c(
                          "label",
                          {
                            staticClass: "col-sm-4 col-form-label text-xs",
                            attrs: { for: "field_required_without_msg" }
                          },
                          [_vm._v("Message Erreur")]
                        ),
                        _vm._v(" "),
                        _c("div", { staticClass: "col-sm-8" }, [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value:
                                  _vm.workflowactionForm
                                    .field_required_without_msg,
                                expression:
                                  "workflowactionForm.field_required_without_msg"
                              }
                            ],
                            staticClass: "form-control form-control-sm",
                            attrs: {
                              type: "text",
                              id: "field_required_without_msg",
                              name: "field_required_without_msg",
                              autocomplete: "field_required_without_msg",
                              placeholder: "Message Erreur"
                            },
                            domProps: {
                              value:
                                _vm.workflowactionForm
                                  .field_required_without_msg
                            },
                            on: {
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.$set(
                                  _vm.workflowactionForm,
                                  "field_required_without_msg",
                                  $event.target.value
                                )
                              }
                            }
                          }),
                          _vm._v(" "),
                          _vm.workflowactionForm.errors.has(
                            "field_required_without_msg"
                          )
                            ? _c("span", {
                                staticClass: "invalid-feedback d-block text-xs",
                                attrs: { role: "alert" },
                                domProps: {
                                  textContent: _vm._s(
                                    _vm.workflowactionForm.errors.get(
                                      "field_required_without_msg"
                                    )
                                  )
                                }
                              })
                            : _vm._e()
                        ])
                      ])
                    : _vm._e(),
                  _vm._v(" "),
                  _c("div", { staticClass: "form-group" }, [
                    _c(
                      "div",
                      {
                        staticClass:
                          "custom-control custom-switch custom-switch-off-danger custom-switch-on-success"
                      },
                      [
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.workflowactionForm.field_required_with,
                              expression:
                                "workflowactionForm.field_required_with"
                            }
                          ],
                          staticClass: "custom-control-input",
                          attrs: {
                            type: "checkbox",
                            id: "field_required_with",
                            name: "field_required_with",
                            autocomplete: "field_required_with",
                            autofocus: "",
                            placeholder:
                              "Champs Requis avec le(s) champs spécifié(s)"
                          },
                          domProps: {
                            checked: Array.isArray(
                              _vm.workflowactionForm.field_required_with
                            )
                              ? _vm._i(
                                  _vm.workflowactionForm.field_required_with,
                                  null
                                ) > -1
                              : _vm.workflowactionForm.field_required_with
                          },
                          on: {
                            change: function($event) {
                              var $$a =
                                  _vm.workflowactionForm.field_required_with,
                                $$el = $event.target,
                                $$c = $$el.checked ? true : false
                              if (Array.isArray($$a)) {
                                var $$v = null,
                                  $$i = _vm._i($$a, $$v)
                                if ($$el.checked) {
                                  $$i < 0 &&
                                    _vm.$set(
                                      _vm.workflowactionForm,
                                      "field_required_with",
                                      $$a.concat([$$v])
                                    )
                                } else {
                                  $$i > -1 &&
                                    _vm.$set(
                                      _vm.workflowactionForm,
                                      "field_required_with",
                                      $$a
                                        .slice(0, $$i)
                                        .concat($$a.slice($$i + 1))
                                    )
                                }
                              } else {
                                _vm.$set(
                                  _vm.workflowactionForm,
                                  "field_required_with",
                                  $$c
                                )
                              }
                            }
                          }
                        }),
                        _vm._v(" "),
                        _vm._m(3),
                        _vm._v(" "),
                        _vm.workflowactionForm.errors.has("field_required_with")
                          ? _c("span", {
                              staticClass: "invalid-feedback d-block text-xs",
                              attrs: { role: "alert" },
                              domProps: {
                                textContent: _vm._s(
                                  _vm.workflowactionForm.errors.get(
                                    "field_required_with"
                                  )
                                )
                              }
                            })
                          : _vm._e()
                      ]
                    )
                  ]),
                  _vm._v(" "),
                  _vm.workflowactionForm.field_required_with
                    ? _c("div", { staticClass: "form-group row" }, [
                        _c(
                          "label",
                          {
                            staticClass: "col-sm-4 col-form-label text-xs",
                            attrs: { for: "m_select_action_with" }
                          },
                          [_vm._v("Liste des champs")]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "col-sm-8 text-xs" },
                          [
                            _c("multiselect", {
                              key: "id",
                              attrs: {
                                id: "m_select_action_with",
                                "selected.sync":
                                  "workflowaction.actionsrequiredwith",
                                value: "",
                                options: _vm.actionsofstep,
                                searchable: true,
                                multiple: true,
                                label: "titre",
                                "track-by": "id",
                                placeholder: "Liste d Actions"
                              },
                              model: {
                                value:
                                  _vm.workflowactionForm.actionsrequiredwith,
                                callback: function($$v) {
                                  _vm.$set(
                                    _vm.workflowactionForm,
                                    "actionsrequiredwith",
                                    $$v
                                  )
                                },
                                expression:
                                  "workflowactionForm.actionsrequiredwith"
                              }
                            }),
                            _vm._v(" "),
                            _vm.workflowactionForm.errors.has(
                              "actionsrequiredwith"
                            )
                              ? _c("span", {
                                  staticClass:
                                    "invalid-feedback d-block text-xs",
                                  attrs: { role: "alert" },
                                  domProps: {
                                    textContent: _vm._s(
                                      _vm.workflowactionForm.errors.get(
                                        "actionsrequiredwith"
                                      )
                                    )
                                  }
                                })
                              : _vm._e()
                          ],
                          1
                        )
                      ])
                    : _vm._e(),
                  _vm._v(" "),
                  _vm.workflowactionForm.field_required_with
                    ? _c("div", { staticClass: "form-group row" }, [
                        _c(
                          "label",
                          {
                            staticClass: "col-sm-4 col-form-label text-xs",
                            attrs: { for: "field_required_with_msg" }
                          },
                          [_vm._v("Message Erreur")]
                        ),
                        _vm._v(" "),
                        _c("div", { staticClass: "col-sm-8" }, [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value:
                                  _vm.workflowactionForm
                                    .field_required_with_msg,
                                expression:
                                  "workflowactionForm.field_required_with_msg"
                              }
                            ],
                            staticClass: "form-control form-control-sm",
                            attrs: {
                              type: "text",
                              id: "field_required_with_msg",
                              name: "field_required_with_msg",
                              autocomplete: "field_required_with_msg",
                              placeholder: "Message Erreur"
                            },
                            domProps: {
                              value:
                                _vm.workflowactionForm.field_required_with_msg
                            },
                            on: {
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.$set(
                                  _vm.workflowactionForm,
                                  "field_required_with_msg",
                                  $event.target.value
                                )
                              }
                            }
                          }),
                          _vm._v(" "),
                          _vm.workflowactionForm.errors.has(
                            "field_required_with_msg"
                          )
                            ? _c("span", {
                                staticClass: "invalid-feedback d-block text-xs",
                                attrs: { role: "alert" },
                                domProps: {
                                  textContent: _vm._s(
                                    _vm.workflowactionForm.errors.get(
                                      "field_required_with_msg"
                                    )
                                  )
                                }
                              })
                            : _vm._e()
                        ])
                      ])
                    : _vm._e()
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
                          return _vm.updateWorkflowaction(_vm.workflowstepId)
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
                          return _vm.createWorkflowaction(_vm.workflowstepId)
                        }
                      }
                    },
                    [_vm._v("Créer Action")]
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
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "label",
      { staticClass: "custom-control-label", attrs: { for: "field_required" } },
      [_c("span", { staticClass: "text text-xs" }, [_vm._v("Champs Requis ?")])]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "label",
      {
        staticClass: "custom-control-label",
        attrs: { for: "field_required_without" }
      },
      [
        _c("span", { staticClass: "text text-xs" }, [
          _vm._v("Champs Requis sans le(s) champ(s) suivant(s) :")
        ])
      ]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "label",
      {
        staticClass: "custom-control-label",
        attrs: { for: "field_required_with" }
      },
      [
        _c("span", { staticClass: "text text-xs" }, [
          _vm._v("Champs Requis avec le(s) champs suivant(s) :")
        ])
      ]
    )
  }
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/views/workflowactions/addupdate.vue":
/*!**********************************************************!*\
  !*** ./resources/js/views/workflowactions/addupdate.vue ***!
  \**********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _addupdate_vue_vue_type_template_id_4091f3ca___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./addupdate.vue?vue&type=template&id=4091f3ca& */ "./resources/js/views/workflowactions/addupdate.vue?vue&type=template&id=4091f3ca&");
/* harmony import */ var _addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./addupdate.vue?vue&type=script&lang=js& */ "./resources/js/views/workflowactions/addupdate.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var vue_multiselect_dist_vue_multiselect_min_css_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vue-multiselect/dist/vue-multiselect.min.css?vue&type=style&index=0&lang=css& */ "./node_modules/vue-multiselect/dist/vue-multiselect.min.css?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _addupdate_vue_vue_type_template_id_4091f3ca___WEBPACK_IMPORTED_MODULE_0__["render"],
  _addupdate_vue_vue_type_template_id_4091f3ca___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/workflowactions/addupdate.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/workflowactions/addupdate.vue?vue&type=script&lang=js&":
/*!***********************************************************************************!*\
  !*** ./resources/js/views/workflowactions/addupdate.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./addupdate.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/workflowactions/addupdate.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/workflowactions/addupdate.vue?vue&type=template&id=4091f3ca&":
/*!*****************************************************************************************!*\
  !*** ./resources/js/views/workflowactions/addupdate.vue?vue&type=template&id=4091f3ca& ***!
  \*****************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_template_id_4091f3ca___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./addupdate.vue?vue&type=template&id=4091f3ca& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/workflowactions/addupdate.vue?vue&type=template&id=4091f3ca&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_template_id_4091f3ca___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_template_id_4091f3ca___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);