(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[17],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/workflowexecs/process-form.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/workflowexecs/process-form.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue_multiselect__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-multiselect */ "./node_modules/vue-multiselect/dist/vue-multiselect.min.js");
/* harmony import */ var vue_multiselect__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue_multiselect__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _ExecBus__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ExecBus */ "./resources/js/views/workflowexecs/ExecBus.js");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  name: "process-form",
  props: {
    treatment_type_prop: {}
  },
  watch: {
    $props: {
      handler: function handler() {
        this.parseProsData(); // anytime any props would change, I needed to parse my data again
      },
      deep: true,
      // so it not only watches $props but also it's nested values like e.g. props.myProp
      immediate: true
    }
  },
  components: {
    Multiselect: vue_multiselect__WEBPACK_IMPORTED_MODULE_0___default.a
  },
  mounted: function mounted() {
    var _this = this;

    _ExecBus__WEBPACK_IMPORTED_MODULE_1__["default"].$on('step_process', function (processdata) {
      console.log('step_process: ', processdata);

      _this.parseData(processdata.exec, processdata.currentstep, processdata.nextstep, processdata.actions, processdata.actionvalues, processdata.enumvalues);
    });
  },
  created: function created() {
    var _this2 = this;

    axios.get('/roles.fetch').then(function (_ref) {
      var data = _ref.data;
      return _this2.roles = data;
    });
  },
  data: function data() {
    return {
      treatment_type: this.treatment_type_prop,
      roles: null,
      wfexec: {},
      currentstep: {},
      nextstep: {},
      actions: [],
      actionvalues: {},
      enumvalues: {},
      wfexecForm: {},
      filename: 'Télécharger un fichier',
      filefieldname: null,
      selectedFile: null,
      loading: false
    };
  },
  methods: {
    parseProsData: function parseProsData() {
      this.treatment_type = this.treatment_type_prop;
    },
    parseData: function parseData(wfexec, currentstep, nextstep, actions, actionvalues, enumvalues) {
      this.wfexec = wfexec;
      this.currentstep = currentstep;
      this.nextstep = nextstep[this.treatment_type.code];
      this.actions = actions[this.treatment_type.code]; //let actionvalues_typed = actionvalues[this.treatment_type]

      this.actionvalues = actionvalues[this.treatment_type.code];
      this.enumvalues = enumvalues;
      this.wfexecForm = new Form(actionvalues[this.treatment_type.code]);
      this.wfexecForm.treatment_type = this.treatment_type;
      this.setDynamicRoleDefault();
    },
    setDynamicRoleDefault: function setDynamicRoleDefault() {
      if (this.isNextstepRoleDynamic) {
        this.wfexecForm.role_dynamic_selection = 'role_dynamic_selected';
      }
    },
    valider: function valider() {
      this.$emit('create_new_workflow');
    },
    handleFileUpload: function handleFileUpload(event) {
      this.selectedFile = event.target.files[0];
      this.filefieldname = event.target.name;
      this.filename = typeof this.selectedFile !== 'undefined' ? this.selectedFile.name : 'Télécharger un fichier';
    },
    validerEtape: function validerEtape(execId) {
      this.submitForm(execId);
    },
    rejeterEtape: function rejeterEtape(execId, rejectactions, enumvalues) {
      var rejectactionvalues = this.rejectactionvalues;
      this.$emit('validate_reject', {
        execId: execId,
        rejectactions: rejectactions,
        rejectactionvalues: rejectactionvalues,
        enumvalues: enumvalues
      });
    },
    processData: function processData(execId) {
      var _this3 = this;

      if (this.treatment_type === "rejection") {
        this.$swal({
          html: '<small>Voulez-vous vraiment rejéter cette étape ?</small>',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Oui',
          cancelButtonText: 'Non'
        }).then(function (result) {
          if (result.value) {
            _this3.submitForm(execId);
          } else {// stay here
          }
        });
      } else {
        this.submitForm(execId);
      }
    },
    submitForm: function submitForm(execId) {
      var _this4 = this;

      if (this.wfexecForm.role_dynamic_selection === 'role_dynamic_previous') {
        this.wfexecForm.current_step_role = this.wfexec.lastexecstep.effectiverole;
      }

      var fd = this.addFileToForm(this.filefieldname);
      console.log('submitForm: ', this.wfexecForm);
      this.wfexecForm.put("/workflowexecs/".concat(execId), fd).then(function (data) {
        $('#processExec').modal('hide');

        _this4.$swal({
          html: '<small>Traitement effectué avec succès !</small>',
          icon: 'success',
          timer: 3000
        }).then(function () {
          _ExecBus__WEBPACK_IMPORTED_MODULE_1__["default"].$emit('step_processed', data);
        });
      })["catch"](function (error) {
        _this4.loading = false;
      });
    },
    addFileToForm: function addFileToForm(fieldname) {
      if (typeof this.selectedFile !== 'undefined') {
        var fd = new FormData();
        fd.append(fieldname, this.selectedFile); //console.log("image added", fd);

        return fd;
      } else {
        var _fd = undefined; //console.log("image not added", fd);

        return _fd;
      }
    },
    updateData: function updateData(data) {
      window.noty({
        message: 'Traitement effectué avec succès',
        type: 'success'
      });
    },
    roleDynamicSelectionTypeChange: function roleDynamicSelectionTypeChange(event) {
      console.log('roleDynamicSelectionTypeChange: ', this.wfexecForm.role_dynamic_selection);
    },
    actionsFilled: function actionsFilled() {}
  },
  computed: {
    isValidCreateForm: function isValidCreateForm() {
      return !this.loading && (this.isNextstepRoleDynamic ? this.wfexecForm.role_dynamic_selection === 'role_dynamic_selected' ? this.wfexecForm.current_step_role && true : true : true);
    },
    isNextstepRoleDynamic: function isNextstepRoleDynamic() {
      if (this.nextstep) {
        return this.nextstep.role_dynamic;
      } else {
        return false;
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/workflowexecs/process-form.vue?vue&type=template&id=0c225b8d&scoped=true&":
/*!************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/workflowexecs/process-form.vue?vue&type=template&id=0c225b8d&scoped=true& ***!
  \************************************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "content" }, [
    _c(
      "form",
      {
        staticClass: "form-horizontal",
        on: {
          submit: function($event) {
            $event.preventDefault()
          },
          keydown: function($event) {
            return _vm.wfexecForm.errors.clear()
          }
        }
      },
      [
        _c(
          "div",
          { staticClass: "card-body" },
          [
            _vm._l(_vm.actions, function(action, index) {
              return _vm.actions
                ? _c("div", { staticClass: "form-group row" }, [
                    action.actiontype.code === "BIGINT_value" &&
                    action.dedicated_form === "validation"
                      ? _c("div", { staticClass: "col-sm-10" }, [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.wfexecForm[action.code],
                                expression: "wfexecForm[action.code]"
                              }
                            ],
                            staticClass: "form-control form-control-sm text-xs",
                            attrs: {
                              type: "text",
                              id: action.code,
                              name: action.code,
                              placeholder: action.titre
                            },
                            domProps: { value: _vm.wfexecForm[action.code] },
                            on: {
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.$set(
                                  _vm.wfexecForm,
                                  action.code,
                                  $event.target.value
                                )
                              }
                            }
                          }),
                          _vm._v(" "),
                          _vm.wfexecForm.errors.has("" + action.code)
                            ? _c("span", {
                                staticClass: "invalid-feedback d-block",
                                attrs: { role: "alert" },
                                domProps: {
                                  textContent: _vm._s(
                                    _vm.wfexecForm.errors.get("" + action.code)
                                  )
                                }
                              })
                            : _vm._e()
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    action.actiontype.code === "BLOB_value" &&
                    action.dedicated_form === "validation"
                      ? _c("div", { staticClass: "col-sm-10" }, [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.wfexecForm[action.code],
                                expression: "wfexecForm[action.code]"
                              }
                            ],
                            staticClass: "form-control form-control-sm",
                            attrs: {
                              type: "text",
                              id: action.code,
                              name: action.code,
                              placeholder: action.titre
                            },
                            domProps: { value: _vm.wfexecForm[action.code] },
                            on: {
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.$set(
                                  _vm.wfexecForm,
                                  action.code,
                                  $event.target.value
                                )
                              }
                            }
                          }),
                          _vm._v(" "),
                          _vm.wfexecForm.errors.has("" + action.code)
                            ? _c("span", {
                                staticClass: "invalid-feedback d-block",
                                attrs: { role: "alert" },
                                domProps: {
                                  textContent: _vm._s(
                                    _vm.wfexecForm.errors.get("" + action.code)
                                  )
                                }
                              })
                            : _vm._e()
                        ])
                      : action.actiontype.code === "BOOLEAN_value" &&
                        action.dedicated_form === "validation"
                      ? _c("div", { staticClass: "col-sm-10" }, [
                          _c("div", { staticClass: "form-check" }, [
                            _c("input", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: _vm.wfexecForm[action.code],
                                  expression: "wfexecForm[action.code]"
                                }
                              ],
                              staticClass: "form-check-input",
                              attrs: {
                                type: "checkbox",
                                id: action.code,
                                name: action.code,
                                placeholder: action.titre
                              },
                              domProps: {
                                checked: Array.isArray(
                                  _vm.wfexecForm[action.code]
                                )
                                  ? _vm._i(_vm.wfexecForm[action.code], null) >
                                    -1
                                  : _vm.wfexecForm[action.code]
                              },
                              on: {
                                change: function($event) {
                                  var $$a = _vm.wfexecForm[action.code],
                                    $$el = $event.target,
                                    $$c = $$el.checked ? true : false
                                  if (Array.isArray($$a)) {
                                    var $$v = null,
                                      $$i = _vm._i($$a, $$v)
                                    if ($$el.checked) {
                                      $$i < 0 &&
                                        _vm.$set(
                                          _vm.wfexecForm,
                                          action.code,
                                          $$a.concat([$$v])
                                        )
                                    } else {
                                      $$i > -1 &&
                                        _vm.$set(
                                          _vm.wfexecForm,
                                          action.code,
                                          $$a
                                            .slice(0, $$i)
                                            .concat($$a.slice($$i + 1))
                                        )
                                    }
                                  } else {
                                    _vm.$set(_vm.wfexecForm, action.code, $$c)
                                  }
                                }
                              }
                            }),
                            _vm._v(" "),
                            _c(
                              "label",
                              {
                                staticClass: "form-check-label",
                                attrs: { for: action.code }
                              },
                              [_vm._v(_vm._s(action.titre))]
                            ),
                            _vm._v(" "),
                            _vm.wfexecForm.errors.has("" + action.code)
                              ? _c("span", {
                                  staticClass: "invalid-feedback d-block",
                                  attrs: { role: "alert" },
                                  domProps: {
                                    textContent: _vm._s(
                                      _vm.wfexecForm.errors.get(
                                        "" + action.code
                                      )
                                    )
                                  }
                                })
                              : _vm._e()
                          ])
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    action.actiontype.code === "CHAR_value" &&
                    action.dedicated_form === "validation"
                      ? _c("div", { staticClass: "col-sm-10" }, [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.wfexecForm[action.code],
                                expression: "wfexecForm[action.code]"
                              }
                            ],
                            staticClass: "form-control form-control-sm text-xs",
                            attrs: {
                              type: "text",
                              id: action.code,
                              name: action.code,
                              placeholder: action.titre
                            },
                            domProps: { value: _vm.wfexecForm[action.code] },
                            on: {
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.$set(
                                  _vm.wfexecForm,
                                  action.code,
                                  $event.target.value
                                )
                              }
                            }
                          }),
                          _vm._v(" "),
                          _vm.wfexecForm.errors.has("" + action.code)
                            ? _c("span", {
                                staticClass: "invalid-feedback d-block",
                                attrs: { role: "alert" },
                                domProps: {
                                  textContent: _vm._s(
                                    _vm.wfexecForm.errors.get("" + action.code)
                                  )
                                }
                              })
                            : _vm._e()
                        ])
                      : action.actiontype.code === "DATETIME_value" &&
                        action.dedicated_form === "validation"
                      ? _c(
                          "div",
                          { staticClass: "col-sm-10" },
                          [
                            _c("VueCtkDateTimePicker", {
                              attrs: {
                                label: action.titre,
                                format: "YYYY-MM-DD hh:mm:ss"
                              },
                              model: {
                                value: _vm.wfexecForm[action.code],
                                callback: function($$v) {
                                  _vm.$set(_vm.wfexecForm, action.code, $$v)
                                },
                                expression: "wfexecForm[action.code]"
                              }
                            }),
                            _vm._v(" "),
                            _vm.wfexecForm.errors.has("" + action.code)
                              ? _c("span", {
                                  staticClass: "invalid-feedback d-block",
                                  attrs: { role: "alert" },
                                  domProps: {
                                    textContent: _vm._s(
                                      _vm.wfexecForm.errors.get(
                                        "" + action.code
                                      )
                                    )
                                  }
                                })
                              : _vm._e()
                          ],
                          1
                        )
                      : action.code === "DATE_value" &&
                        action.dedicated_form === "validation"
                      ? _c(
                          "div",
                          { staticClass: "col-sm-10" },
                          [
                            _c("VueCtkDateTimePicker", {
                              attrs: {
                                label: action.titre,
                                format: "YYYY-MM-DD"
                              },
                              model: {
                                value: _vm.wfexecForm[action.code],
                                callback: function($$v) {
                                  _vm.$set(_vm.wfexecForm, action.code, $$v)
                                },
                                expression: "wfexecForm[action.code]"
                              }
                            }),
                            _vm._v(" "),
                            _vm.wfexecForm.errors.has("" + action.code)
                              ? _c("span", {
                                  staticClass: "invalid-feedback d-block",
                                  attrs: { role: "alert" },
                                  domProps: {
                                    textContent: _vm._s(
                                      _vm.wfexecForm.errors.get(
                                        "" + action.code
                                      )
                                    )
                                  }
                                })
                              : _vm._e()
                          ],
                          1
                        )
                      : _vm._e(),
                    _vm._v(" "),
                    action.actiontype.code === "DECIMAL_value" &&
                    action.dedicated_form === "validation"
                      ? _c("div", { staticClass: "col-sm-10" }, [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.wfexecForm[action.code],
                                expression: "wfexecForm[action.code]"
                              }
                            ],
                            staticClass: "form-control form-control-sm text-xs",
                            attrs: {
                              type: "text",
                              id: action.code,
                              name: action.code,
                              placeholder: action.titre
                            },
                            domProps: { value: _vm.wfexecForm[action.code] },
                            on: {
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.$set(
                                  _vm.wfexecForm,
                                  action.code,
                                  $event.target.value
                                )
                              }
                            }
                          }),
                          _vm._v(" "),
                          _vm.wfexecForm.errors.has("" + action.code)
                            ? _c("span", {
                                staticClass: "invalid-feedback d-block",
                                attrs: { role: "alert" },
                                domProps: {
                                  textContent: _vm._s(
                                    _vm.wfexecForm.errors.get("" + action.code)
                                  )
                                }
                              })
                            : _vm._e()
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    action.actiontype.code === "DOUBLE_value" &&
                    action.dedicated_form === "validation"
                      ? _c("div", { staticClass: "col-sm-10" }, [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.wfexecForm[action.code],
                                expression: "wfexecForm[action.code]"
                              }
                            ],
                            staticClass: "form-control form-control-sm text-xs",
                            attrs: {
                              type: "text",
                              id: action.code,
                              name: action.code,
                              placeholder: action.titre
                            },
                            domProps: { value: _vm.wfexecForm[action.code] },
                            on: {
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.$set(
                                  _vm.wfexecForm,
                                  action.code,
                                  $event.target.value
                                )
                              }
                            }
                          }),
                          _vm._v(" "),
                          _vm.wfexecForm.errors.has("" + action.code)
                            ? _c("span", {
                                staticClass: "invalid-feedback d-block",
                                attrs: { role: "alert" },
                                domProps: {
                                  textContent: _vm._s(
                                    _vm.wfexecForm.errors.get("" + action.code)
                                  )
                                }
                              })
                            : _vm._e()
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    action.actiontype.code === "FLOAT_value" &&
                    action.dedicated_form === "validation"
                      ? _c("div", { staticClass: "col-sm-10" }, [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.wfexecForm[action.code],
                                expression: "wfexecForm[action.code]"
                              }
                            ],
                            staticClass: "form-control form-control-sm text-xs",
                            attrs: {
                              type: "text",
                              id: action.code,
                              name: action.code,
                              placeholder: action.titre
                            },
                            domProps: { value: _vm.wfexecForm[action.code] },
                            on: {
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.$set(
                                  _vm.wfexecForm,
                                  action.code,
                                  $event.target.value
                                )
                              }
                            }
                          }),
                          _vm._v(" "),
                          _vm.wfexecForm.errors.has("" + action.code)
                            ? _c("span", {
                                staticClass: "invalid-feedback d-block",
                                attrs: { role: "alert" },
                                domProps: {
                                  textContent: _vm._s(
                                    _vm.wfexecForm.errors.get("" + action.code)
                                  )
                                }
                              })
                            : _vm._e()
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    action.actiontype.code === "INTEGER_value" &&
                    action.dedicated_form === "validation"
                      ? _c("div", { staticClass: "col-sm-10" }, [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.wfexecForm[action.code],
                                expression: "wfexecForm[action.code]"
                              }
                            ],
                            staticClass: "form-control form-control-sm text-xs",
                            attrs: {
                              type: "text",
                              id: action.code,
                              name: action.code,
                              placeholder: action.titre
                            },
                            domProps: { value: _vm.wfexecForm[action.code] },
                            on: {
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.$set(
                                  _vm.wfexecForm,
                                  action.code,
                                  $event.target.value
                                )
                              }
                            }
                          }),
                          _vm._v(" "),
                          _vm.wfexecForm.errors.has("" + action.code)
                            ? _c("span", {
                                staticClass: "invalid-feedback d-block",
                                attrs: { role: "alert" },
                                domProps: {
                                  textContent: _vm._s(
                                    _vm.wfexecForm.errors.get("" + action.code)
                                  )
                                }
                              })
                            : _vm._e()
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    action.actiontype.code === "IPADDRESS_value" &&
                    action.dedicated_form === "validation"
                      ? _c("div", { staticClass: "col-sm-10" }, [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.wfexecForm[action.code],
                                expression: "wfexecForm[action.code]"
                              }
                            ],
                            staticClass: "form-control form-control-sm text-xs",
                            attrs: {
                              type: "text",
                              id: action.code,
                              name: action.code,
                              placeholder: action.titre
                            },
                            domProps: { value: _vm.wfexecForm[action.code] },
                            on: {
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.$set(
                                  _vm.wfexecForm,
                                  action.code,
                                  $event.target.value
                                )
                              }
                            }
                          }),
                          _vm._v(" "),
                          _vm.wfexecForm.errors.has("" + action.code)
                            ? _c("span", {
                                staticClass: "invalid-feedback d-block",
                                attrs: { role: "alert" },
                                domProps: {
                                  textContent: _vm._s(
                                    _vm.wfexecForm.errors.get("" + action.code)
                                  )
                                }
                              })
                            : _vm._e()
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    action.actiontype.code === "STRING_value" &&
                    action.dedicated_form === "validation"
                      ? _c("div", { staticClass: "col-sm-10" }, [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.wfexecForm[action.code],
                                expression: "wfexecForm[action.code]"
                              }
                            ],
                            staticClass: "form-control form-control-sm text-xs",
                            attrs: {
                              type: "text",
                              id: action.code,
                              name: action.code,
                              placeholder: action.titre
                            },
                            domProps: { value: _vm.wfexecForm[action.code] },
                            on: {
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.$set(
                                  _vm.wfexecForm,
                                  action.code,
                                  $event.target.value
                                )
                              }
                            }
                          }),
                          _vm._v(" "),
                          _vm.wfexecForm.errors.has("" + action.code)
                            ? _c("span", {
                                staticClass: "invalid-feedback d-block",
                                attrs: { role: "alert" },
                                domProps: {
                                  textContent: _vm._s(
                                    _vm.wfexecForm.errors.get("" + action.code)
                                  )
                                }
                              })
                            : _vm._e()
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    action.actiontype.code === "TEXT_value" &&
                    action.dedicated_form === "validation"
                      ? _c("div", { staticClass: "col-sm-10" }, [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.wfexecForm[action.code],
                                expression: "wfexecForm[action.code]"
                              }
                            ],
                            staticClass: "form-control form-control-sm text-xs",
                            attrs: {
                              type: "text",
                              id: action.code,
                              name: action.code,
                              placeholder: action.titre
                            },
                            domProps: { value: _vm.wfexecForm[action.code] },
                            on: {
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.$set(
                                  _vm.wfexecForm,
                                  action.code,
                                  $event.target.value
                                )
                              }
                            }
                          }),
                          _vm._v(" "),
                          _vm.wfexecForm.errors.has("" + action.code)
                            ? _c("span", {
                                staticClass: "invalid-feedback d-block",
                                attrs: { role: "alert" },
                                domProps: {
                                  textContent: _vm._s(
                                    _vm.wfexecForm.errors.get("" + action.code)
                                  )
                                }
                              })
                            : _vm._e()
                        ])
                      : action.actiontype.code === "FILE_ref" &&
                        action.dedicated_form === "validation"
                      ? _c("div", { staticClass: "col-sm-10" }, [
                          _c("input", {
                            ref: action.code,
                            refInFor: true,
                            staticClass: "custom-file-input",
                            attrs: {
                              type: "file",
                              id: action.code,
                              name: action.code
                            },
                            on: { change: _vm.handleFileUpload }
                          }),
                          _vm._v(" "),
                          _c(
                            "label",
                            {
                              staticClass: "custom-file-label",
                              attrs: { for: action.code }
                            },
                            [_vm._v(_vm._s(_vm.filename))]
                          ),
                          _vm._v(" "),
                          _vm.wfexecForm.errors.has("" + action.code)
                            ? _c("span", {
                                staticClass: "invalid-feedback d-block",
                                attrs: { role: "alert" },
                                domProps: {
                                  textContent: _vm._s(
                                    _vm.wfexecForm.errors.get("" + action.code)
                                  )
                                }
                              })
                            : _vm._e()
                        ])
                      : action.actiontype.code === "EnumType"
                      ? _c(
                          "div",
                          { staticClass: "col-sm-10" },
                          [
                            _c("multiselect", {
                              key: "val",
                              attrs: {
                                id: action.code,
                                "selected.sync": "wfexecForm[action.code]",
                                value: "",
                                options: _vm.enumvalues[action.code],
                                searchable: true,
                                multiple: false,
                                label: "val",
                                "track-by": "val",
                                placeholder: action.titre
                              },
                              model: {
                                value: _vm.wfexecForm[action.code],
                                callback: function($$v) {
                                  _vm.$set(_vm.wfexecForm, action.code, $$v)
                                },
                                expression: "wfexecForm[action.code]"
                              }
                            })
                          ],
                          1
                        )
                      : _c("div", { staticClass: "col-sm-10" })
                  ])
                : _vm._e()
            }),
            _vm._v(" "),
            _vm.isNextstepRoleDynamic
              ? _c("div", { staticClass: "form-group row" }, [
                  _c(
                    "div",
                    { staticClass: "custom-control custom-radio col-sm-4" },
                    [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.wfexecForm.role_dynamic_selection,
                            expression: "wfexecForm.role_dynamic_selection"
                          }
                        ],
                        staticClass: "custom-control-input",
                        attrs: {
                          type: "radio",
                          id: "role_dynamic_selected",
                          name: "role_dynamic_selection",
                          value: "role_dynamic_selected"
                        },
                        domProps: {
                          checked: _vm._q(
                            _vm.wfexecForm.role_dynamic_selection,
                            "role_dynamic_selected"
                          )
                        },
                        on: {
                          change: [
                            function($event) {
                              return _vm.$set(
                                _vm.wfexecForm,
                                "role_dynamic_selection",
                                "role_dynamic_selected"
                              )
                            },
                            function($event) {
                              return _vm.roleDynamicSelectionTypeChange($event)
                            }
                          ]
                        }
                      }),
                      _vm._v(" "),
                      _c(
                        "label",
                        {
                          staticClass: "custom-control-label",
                          attrs: { for: "role_dynamic_selected" }
                        },
                        [
                          _c("span", { staticClass: "text text-xs" }, [
                            _vm._v(_vm._s(_vm.nextstep.role_dynamic_label))
                          ])
                        ]
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-sm-6" },
                    [
                      _c("multiselect", {
                        key: "id",
                        attrs: {
                          id: "m_select_current_step_role",
                          "selected.sync": "wfexecForm.current_step_role",
                          value: "",
                          options: _vm.roles,
                          searchable: true,
                          multiple: false,
                          label: "name",
                          "track-by": "id",
                          placeholder: _vm.nextstep.role_dynamic_label
                        },
                        model: {
                          value: _vm.wfexecForm.current_step_role,
                          callback: function($$v) {
                            _vm.$set(_vm.wfexecForm, "current_step_role", $$v)
                          },
                          expression: "wfexecForm.current_step_role"
                        }
                      })
                    ],
                    1
                  )
                ])
              : _vm._e(),
            _vm._v(" "),
            _vm.isNextstepRoleDynamic &&
            _vm.wfexec.lastexecstep &&
            _vm.wfexec.lastexecstep.effectiverole
              ? _c("div", { staticClass: "form-group row" }, [
                  _c(
                    "div",
                    { staticClass: "custom-control custom-radio col-sm-4" },
                    [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.wfexecForm.role_dynamic_selection,
                            expression: "wfexecForm.role_dynamic_selection"
                          }
                        ],
                        staticClass: "custom-control-input",
                        attrs: {
                          type: "radio",
                          id: "role_dynamic_previous",
                          name: "role_dynamic_selection",
                          value: "role_dynamic_previous"
                        },
                        domProps: {
                          checked: _vm._q(
                            _vm.wfexecForm.role_dynamic_selection,
                            "role_dynamic_previous"
                          )
                        },
                        on: {
                          change: [
                            function($event) {
                              return _vm.$set(
                                _vm.wfexecForm,
                                "role_dynamic_selection",
                                "role_dynamic_previous"
                              )
                            },
                            function($event) {
                              return _vm.roleDynamicSelectionTypeChange($event)
                            }
                          ]
                        }
                      }),
                      _vm._v(" "),
                      _c(
                        "label",
                        {
                          staticClass: "custom-control-label",
                          attrs: { for: "role_dynamic_previous" }
                        },
                        [
                          _c("span", { staticClass: "text text-xs" }, [
                            _vm._v(
                              _vm._s(_vm.nextstep.role_dynamic_previous_label)
                            )
                          ])
                        ]
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-sm-6" }, [
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.wfexec.lastexecstep.effectiverole.name,
                          expression: "wfexec.lastexecstep.effectiverole.name"
                        }
                      ],
                      staticClass: "form-control form-control-sm text-xs",
                      attrs: {
                        type: "text",
                        readonly: "",
                        id: "role_dynamic_previous_chosen",
                        name: "role_dynamic_previous_chosen",
                        placeholder: _vm.nextstep.role_dynamic_previous_label
                      },
                      domProps: {
                        value: _vm.wfexec.lastexecstep.effectiverole.name
                      },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(
                            _vm.wfexec.lastexecstep.effectiverole,
                            "name",
                            $event.target.value
                          )
                        }
                      }
                    })
                  ])
                ])
              : _vm._e()
          ],
          2
        )
      ]
    ),
    _vm._v(" "),
    _c("div", { staticClass: "justify-content-between text-right" }, [
      _c(
        "button",
        {
          staticClass: "btn btn-warning btn-sm",
          attrs: { type: "button", disabled: !_vm.isValidCreateForm },
          on: {
            click: function($event) {
              return _vm.processData(_vm.wfexec.uuid)
            }
          }
        },
        [_vm._v("Valider")]
      )
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/views/workflowexecs/process-form.vue":
/*!***********************************************************!*\
  !*** ./resources/js/views/workflowexecs/process-form.vue ***!
  \***********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _process_form_vue_vue_type_template_id_0c225b8d_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./process-form.vue?vue&type=template&id=0c225b8d&scoped=true& */ "./resources/js/views/workflowexecs/process-form.vue?vue&type=template&id=0c225b8d&scoped=true&");
/* harmony import */ var _process_form_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./process-form.vue?vue&type=script&lang=js& */ "./resources/js/views/workflowexecs/process-form.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _process_form_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _process_form_vue_vue_type_template_id_0c225b8d_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _process_form_vue_vue_type_template_id_0c225b8d_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "0c225b8d",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/workflowexecs/process-form.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/workflowexecs/process-form.vue?vue&type=script&lang=js&":
/*!************************************************************************************!*\
  !*** ./resources/js/views/workflowexecs/process-form.vue?vue&type=script&lang=js& ***!
  \************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_process_form_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./process-form.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/workflowexecs/process-form.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_process_form_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/workflowexecs/process-form.vue?vue&type=template&id=0c225b8d&scoped=true&":
/*!******************************************************************************************************!*\
  !*** ./resources/js/views/workflowexecs/process-form.vue?vue&type=template&id=0c225b8d&scoped=true& ***!
  \******************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_process_form_vue_vue_type_template_id_0c225b8d_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./process-form.vue?vue&type=template&id=0c225b8d&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/workflowexecs/process-form.vue?vue&type=template&id=0c225b8d&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_process_form_vue_vue_type_template_id_0c225b8d_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_process_form_vue_vue_type_template_id_0c225b8d_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);