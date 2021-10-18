(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[2],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/workflows/item.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/workflows/item.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _workflowsteps_list__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../workflowsteps/list */ "./resources/js/views/workflowsteps/list.vue");
/* harmony import */ var _workflowsteps_addupdate__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../workflowsteps/addupdate */ "./resources/js/views/workflowsteps/addupdate.vue");
/* harmony import */ var _workflowBus__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./workflowBus */ "./resources/js/views/workflows/workflowBus.js");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  name: "workflow-item",
  props: {
    workflow_prop: {},
    index_prop: {}
  },
  components: {
    WorkflowSteps: _workflowsteps_list__WEBPACK_IMPORTED_MODULE_0__["default"],
    AddUpdateStep: _workflowsteps_addupdate__WEBPACK_IMPORTED_MODULE_1__["default"]
  },
  mounted: function mounted() {
    var _this = this;

    _workflowBus__WEBPACK_IMPORTED_MODULE_2__["default"].$on('workflow_updated', function (updworkflow) {
      if (_this.workflow.id === updworkflow.id) {
        _this.workflow = updworkflow;
        window.noty({
          message: 'Workflow modifié avec succès',
          type: 'success'
        });
      }
    });
  },
  created: function created() {},
  data: function data() {
    return {
      workflow: this.workflow_prop,
      index: this.index_prop,
      collapse_icon: 'fas fa-chevron-down'
    };
  },
  methods: {
    editWorkflow: function editWorkflow(workflow) {
      _workflowBus__WEBPACK_IMPORTED_MODULE_2__["default"].$emit('edit_workflow', {
        workflow: workflow
      });
    },
    showFlowchart: function showFlowchart(workflow) {
      /*WorkflowBus.$emit('show_flowchart', workflow)*/
      window.location = '/workflows.flowchart/' + workflow.uuid;
    },
    deleteWorkflow: function deleteWorkflow(id, key) {
      var _this2 = this;

      this.$swal({
        html: '<small>Voulez-vous vraiment supprimer ce Workflow ?</small>',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Oui',
        cancelButtonText: 'Non'
      }).then(function (result) {
        if (result.value) {
          axios["delete"]("/workflows/".concat(id)).then(function (resp) {
            console.log('workflow delete resp: ', resp);

            _this2.$swal({
              html: '<small>Workflow supprimé avec succès !</small>',
              icon: 'success',
              timer: 3000
            }).then(function () {
              _workflowBus__WEBPACK_IMPORTED_MODULE_2__["default"].$emit('workflowaction_deleted', {
                key: key,
                resp: resp
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

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/workflowsteps/addupdate.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/workflowsteps/addupdate.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue_multiselect__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-multiselect */ "./node_modules/vue-multiselect/dist/vue-multiselect.min.js");
/* harmony import */ var vue_multiselect__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue_multiselect__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _stepBus__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./stepBus */ "./resources/js/views/workflowsteps/stepBus.js");
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

 //import ActionBus from "../workflowactions/actionBus";

var Workflowstep = function Workflowstep(workflowstep) {
  _classCallCheck(this, Workflowstep);

  this.titre = workflowstep.titre || '';
  this.description = workflowstep.description || '';
  this.workflow_id = workflowstep.workflow_id || '';
  this.staticapprovers = workflowstep.staticapprovers || '';
  this.role_static = workflowstep.role_static || 0;
  this.role_dynamic = workflowstep.role_dynamic || 0;
  this.role_dynamic_label = workflowstep.role_dynamic_label || '';
  this.role_dynamic_previous_label = workflowstep.role_dynamic_previous_label || '';
  this.role_previous = workflowstep.role_previous || 0;
  this.role_type = (workflowstep.role_static ? 'role_static' : workflowstep.role_dynamic ? 'role_dynamic' : workflowstep.role_previous ? 'role_previous' : 'role_static') || 'undefied';
  this.transitionpassstep = workflowstep.transitionpassstep || '';
  this.transitionrejectstep = workflowstep.transitionrejectstep || '';
  this.transitionexpirestep = workflowstep.transitionexpirestep || '';
  this.can_expire = workflowstep.can_expire || false;
  this.expire_hours = workflowstep.expire_hours || 0;
  this.expire_days = workflowstep.expire_days || 0;
  this.transitionexpirestep = workflowstep.transitionexpirestep || '';
  this.notify_to_approvers = workflowstep.notify_to_approvers || false;
  this.notify_to_others = workflowstep.notify_to_others || false;
  this.otherstonotify = workflowstep.otherstonotify || '';
  this.stepparent = workflowstep.stepparent || '';
  this.status = workflowstep.status || '';
  this.stylingClass = workflowstep.stylingClass || '';
  this.flowchart_position_x = workflowstep.flowchart_position_x || '';
  this.flowchart_position_y = workflowstep.flowchart_position_y || '';
  this.flowchart_size_width = workflowstep.flowchart_size_width || '';
  this.flowchart_size_height = workflowstep.flowchart_size_height || '';
  this.reminder = workflowstep.reminder || '';
};

var Reminder = function Reminder(workflowstep) {
  _classCallCheck(this, Reminder);

  this.reminder = workflowstep.reminder || '';
  this.modeltype = workflowstep.reminder_modeltype || '';
  this.title = workflowstep.reminder_title || '';
  this.description = workflowstep.reminder_description || '';
  this.duration = workflowstep.reminder_duration || '';
  this.msg = workflowstep.reminder_msg || '';
  this.notification_interval = workflowstep.reminder_notification_interval || '';
  this.status = workflowstep.reminder_status || '';
};

/* harmony default export */ __webpack_exports__["default"] = ({
  name: "step-addupdate",
  props: {
    workflow_prop: {}
  },
  components: {
    Multiselect: vue_multiselect__WEBPACK_IMPORTED_MODULE_0___default.a
  },
  mounted: function mounted() {
    var _this = this;

    this.$parent.$on('workflowstep_create', function (workflow, workflowsteps) {
      console.log('workflowstep_create received', workflowsteps);
      _this.editing = false;
      _this.workflow = workflow;
      _this.workflowsteps = workflowsteps;
      _this.workflowstep = new Workflowstep({});
      _this.workflowstepForm = new Form(_this.workflowstep);
      _this.reminder = new Reminder({});
      _this.reminderForm = new Form(_this.reminder);
      _this.workflowstep.workflow_id = workflow.id;
      $('#addUpdateWorkflowstep').modal();
    });
    _stepBus__WEBPACK_IMPORTED_MODULE_1__["default"].$on('workflowstep_edit', function (workflowstep, workflow, workflowsteps) {
      console.log('workflowstep_edit received', workflowsteps);
      _this.editing = true;
      _this.workflow = workflow;
      _this.workflowsteps = workflowsteps;
      _this.workflowstep = new Workflowstep(workflowstep);
      _this.workflowstepForm = new Form(_this.workflowstep);
      _this.reminder = new Reminder(workflowstep);
      _this.reminderForm = new Form(_this.reminder);
      _this.workflowstepId = workflowstep.uuid;
      $('#addUpdateWorkflowstep').modal();
    });
  },
  created: function created() {
    var _this2 = this;

    axios.get('/roles').then(function (_ref) {
      var data = _ref.data;
      return _this2.roles = data;
    });
    axios.get('/users.fetchall').then(function (_ref2) {
      var data = _ref2.data;
      return _this2.users = data;
    });
    axios.get('/workflowsteps.fetchbyworkflow/0').then(function (_ref3) {
      var data = _ref3.data;
      return _this2.workflowsteps = data;
    });
  },
  data: function data() {
    return {
      workflowstep: {},
      workflowsteps: [],
      workflow: {},
      workflowstepForm: new Form(new Workflowstep({})),
      reminder: {},
      reminderForm: new Form(new Reminder({})),
      workflowstepId: null,
      editing: false,
      loading: false,
      roles: [],
      users: [],
      flowchart_collapse_icon: 'fas fa-chevron-down',
      reminder_collapse_icon: 'fas fa-chevron-down'
    };
  },
  methods: {
    initForm: function initForm(editing, workflowstep) {
      this.editing = editing;

      if (editing) {
        this.workflowstep = new Workflowstep(workflowstep);
        this.workflowstepForm = new Form(this.workflowstep);
        this.reminder = new Reminder(workflowstep);
        this.reminderForm = new Form(this.reminder);
      } else {
        this.workflowstep = new Workflowstep({});
        this.workflowstepForm = new Form(this.workflowstep);
        this.reminder = new Reminder({});
        this.reminderForm = new Form(this.reminder);
      }
    },
    createWorkflowstep: function createWorkflowstep(workflowId) {
      var _this3 = this;

      this.loading = true;
      this.updateRoleType();
      this.workflowstepForm.post('/workflowsteps').then(function (workflowstep) {
        _this3.loading = false;
        $('#addUpdateWorkflowstep').modal('hide');

        _this3.$swal({
          html: '<small>Etape créée avec succès !</small>',
          icon: 'success',
          timer: 3000
        }).then(function () {
          _stepBus__WEBPACK_IMPORTED_MODULE_1__["default"].$emit('workflowaction_created', {
            workflowstep: workflowstep,
            workflowId: workflowId
          });
        });
      })["catch"](function (error) {
        _this3.loading = false;
      });
    },
    updateWorkflowstep: function updateWorkflowstep(workflowId) {
      var _this4 = this;

      this.loading = true;
      this.updateRoleType();
      var fd = this.addFileToForm();
      this.workflowstepForm.put("/workflowsteps/".concat(this.workflowstepId), fd).then(function (workflowstep) {
        _this4.loading = false;
        $('#addUpdateWorkflowstep').modal('hide');

        _this4.$swal({
          html: '<small>Etape modifiée avec succès !</small>',
          icon: 'success',
          timer: 3000
        }).then(function () {
          _stepBus__WEBPACK_IMPORTED_MODULE_1__["default"].$emit('workflowstep_updated', {
            workflowstep: workflowstep,
            workflowId: workflowId
          });
        });
      })["catch"](function (error) {
        _this4.loading = false;
      });
    },
    updateFlowchartNode: function updateFlowchartNode(workflowId) {
      var _this5 = this;

      this.loading = true;
      this.updateRoleType();
      var fd = this.addFileToForm();
      this.workflowstepForm.put("/workflowsteps.updateflowchartnode/".concat(this.workflowstepId), fd).then(function (workflowstep) {
        _this5.loading = false; //$('#addUpdateWorkflowstep').modal('hide')

        _this5.$swal({
          html: '<small>Infos Diagramme modifiées avec succès !</small>',
          icon: 'success',
          timer: 3000
        }).then(function () {
          _this5.initForm(true, workflowstep);

          _stepBus__WEBPACK_IMPORTED_MODULE_1__["default"].$emit('workflowstep_updated', {
            workflowstep: workflowstep,
            workflowId: workflowId
          });
        });
      })["catch"](function (error) {
        _this5.loading = false;
      });
    },
    saveReminder: function saveReminder(workflowId) {
      var _this6 = this;

      this.loading = true; //const fd = this.addFileToForm()

      if (this.workflowstepForm.reminder) {
        this.reminderForm.put("/workflowsteps.updatereminder/".concat(this.workflowstepId), undefined).then(function (workflowstep) {
          _this6.loading = false;

          _this6.$swal({
            html: '<small>Rappel modifié avec succès !</small>',
            icon: 'success',
            timer: 3000
          }).then(function () {
            _this6.initForm(true, workflowstep);

            _stepBus__WEBPACK_IMPORTED_MODULE_1__["default"].$emit('workflowstep_updated', {
              workflowstep: workflowstep,
              workflowId: workflowId
            });
          });
        })["catch"](function (error) {
          _this6.loading = false;
        });
      } else {
        this.reminderForm.put("/workflowsteps.createreminder/".concat(this.workflowstepId), fd).then(function (workflowstep) {
          _this6.loading = false;

          _this6.$swal({
            html: '<small>Rappel créé avec succès !</small>',
            icon: 'success',
            timer: 3000
          }).then(function () {
            _this6.initForm(true, workflowstep);

            _stepBus__WEBPACK_IMPORTED_MODULE_1__["default"].$emit('workflowstep_updated', {
              workflowstep: workflowstep,
              workflowId: workflowId
            });
          });
        })["catch"](function (error) {
          _this6.loading = false;
        });
      }
    },
    addFileToForm: function addFileToForm() {
      if (typeof this.selectedFile !== 'undefined') {
        var _fd = new FormData();

        _fd.append('step_files', this.selectedFile); //console.log("image added", fd);


        return _fd;
      } else {
        var _fd2 = undefined; //console.log("image not added", fd);

        return _fd2;
      }
    },
    roleTypeChange: function roleTypeChange(event) {
      this.workflowstepForm.role_type = event.target.value;
      console.log('roleTypeChange: ', this.workflowstepForm.role_type);
      this.updateRoleType();
    },
    updateRoleType: function updateRoleType() {
      if (this.workflowstepForm.role_type === 'role_static') {
        this.workflowstepForm.role_static = 1;
        this.workflowstepForm.role_dynamic = 0;
        this.workflowstepForm.role_previous = 0;
      } else if (this.workflowstepForm.role_type === 'role_dynamic') {
        this.workflowstepForm.role_static = 0;
        this.workflowstepForm.role_dynamic = 1;
        this.workflowstepForm.role_previous = 0;
      } else if (this.workflowstepForm.role_type === 'role_previous') {
        this.workflowstepForm.role_static = 0;
        this.workflowstepForm.role_dynamic = 0;
        this.workflowstepForm.role_previous = 1;
      }
    },
    canExpireCheck: function canExpireCheck() {
      this.workflowstepForm.can_expire = this.workflowstepForm.can_expire === 1 ? 0 : 1;
    },
    notifyToProfileCheck: function notifyToProfileCheck() {
      this.workflowstepForm.notify_to_approvers = this.workflowstepForm.notify_to_approvers === 1 ? 0 : 1;
    },
    notifyToOthersCheck: function notifyToOthersCheck() {
      this.workflowstepForm.notify_to_others = this.workflowstepForm.notify_to_others === 1 ? 0 : 1;
    },
    collapseFlowchartClicked: function collapseFlowchartClicked() {
      if (this.flowchart_collapse_icon === 'fas fa-chevron-down') {
        this.flowchart_collapse_icon = 'fas fa-chevron-up';
      } else {
        this.flowchart_collapse_icon = 'fas fa-chevron-down';
      }
    },
    collapseReminderClicked: function collapseReminderClicked() {
      if (this.reminder_collapse_icon === 'fas fa-chevron-down') {
        this.reminder_collapse_icon = 'fas fa-chevron-up';
      } else {
        this.reminder_collapse_icon = 'fas fa-chevron-down';
      }
    }
  },
  computed: {
    can_role_static: function can_role_static() {
      return this.workflowstepForm.role_static ? true : this.workflowstepForm.role_dynamic ? false : this.workflowstepForm.role_previous ? false : true;
    },
    isValidCreateForm: function isValidCreateForm() {
      return !this.loading;
    },
    currentFlowchartCollapseIcon: function currentFlowchartCollapseIcon() {
      return this.flowchart_collapse_icon;
    },
    currentReminderCollapseIcon: function currentReminderCollapseIcon() {
      return this.reminder_collapse_icon;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/workflowsteps/list.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/workflowsteps/list.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _stepBus__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./stepBus */ "./resources/js/views/workflowsteps/stepBus.js");
/* harmony import */ var _workflowactions_actionBus__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../workflowactions/actionBus */ "./resources/js/views/workflowactions/actionBus.js");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: {
    workflow: {},
    workflowsteps_prop: {}
  },
  name: "steps-list",
  components: {
    WorkflowActions: function WorkflowActions() {
      return __webpack_require__.e(/*! import() */ 31).then(__webpack_require__.bind(null, /*! ../workflowactions/list */ "./resources/js/views/workflowactions/list.vue"));
    },
    AddUpdateAction: function AddUpdateAction() {
      return __webpack_require__.e(/*! import() */ 29).then(__webpack_require__.bind(null, /*! ../workflowactions/addupdate */ "./resources/js/views/workflowactions/addupdate.vue"));
    }
  },
  mounted: function mounted() {
    var _this = this;

    _stepBus__WEBPACK_IMPORTED_MODULE_0__["default"].$on('workflowstep_created', function (add_data) {
      if (_this.workflow.id === add_data.workflowId) {
        _this.createStep(add_data.workflowstep);
      }
    });
    _stepBus__WEBPACK_IMPORTED_MODULE_0__["default"].$on('workflowstep_updated', function (upd_data) {
      // Step modifiée à mettre à jour sur la liste
      console.log('workflowstep_to_update received at steps.list', upd_data);

      if (_this.workflow.id === upd_data.workflowId) {
        _this.updateStep(upd_data.workflowstep);
      }
    });
    _workflowactions_actionBus__WEBPACK_IMPORTED_MODULE_1__["default"].$on('workflowaction_created', function (add_data) {
      console.log('workflowaction_created received from steplist', add_data);

      _this.updateStep(add_data.step);
    });
    _workflowactions_actionBus__WEBPACK_IMPORTED_MODULE_1__["default"].$on('workflowaction_updated', function (upd_data) {
      console.log('workflowaction_updated received from steplist', upd_data);

      _this.updateStep(upd_data.step);
    });
    _workflowactions_actionBus__WEBPACK_IMPORTED_MODULE_1__["default"].$on('workflowaction_deleted', function (del_data) {
      console.log('workflowaction_deleted received from steplist', del_data);

      _this.updateStep(del_data.step);
    });
  },
  data: function data() {
    return {
      workflowsteps: this.workflowsteps_prop,
      //data: this.workflowsteps_prop,
      isPaginated: true,
      isPaginationSimple: false,
      isPaginationRounded: true,
      paginationPosition: 'bottom',
      defaultSortDirection: 'asc',
      sortIcon: 'arrow-up',
      sortIconSize: 'is-small',
      currentPage: 1,
      perPage: 5,
      defaultOpenedDetails: [-1],
      showDetailIcon: true,
      useTransition: false,
      stickyHeaders: false,
      columns: [{
        field: 'id',
        key: 'id',
        label: 'ID',
        numeric: true,
        searchable: false,
        sortable: true
      }, {
        field: 'titre',
        key: 'titre',
        label: 'Titre',
        searchable: true,
        sortable: true
      }, {
        field: 'description',
        key: 'description',
        label: 'Description',
        searchable: true,
        sortable: true
      }, {
        field: 'actions',
        key: 'actions',
        label: 'Action(s)',
        width: '100',
        centered: true,
        sortable: false
      }]
    };
  },
  methods: {
    searchTitre: function searchTitre(row, input) {
      console.log('Searching Titre ...', row, input);
      return input && row.titre && row.titre.includes(input);
    },
    searchDescription: function searchDescription(row, input) {
      console.log('Searching Description ...', row, input);
      return input && row.description && row.description.includes(input);
    },
    searchDefault: function searchDefault(row, input) {
      console.log('Searching Default ...', row, input);
      return true;
    },
    createNewAction: function createNewAction(workflowstep) {
      axios.get("/workflowactions.fetchbystep/".concat(workflowstep.id)).then(function (resp) {
        _workflowactions_actionBus__WEBPACK_IMPORTED_MODULE_1__["default"].$emit('workflowaction_create', workflowstep, resp.data);
      });
    },
    editWorkflowstep: function editWorkflowstep(workflowstep) {
      var _this2 = this;

      axios.get("/workflowsteps.fetchbyworkflow/".concat(workflowstep.workflow_id)).then(function (resp) {
        _stepBus__WEBPACK_IMPORTED_MODULE_0__["default"].$emit('workflowstep_edit', workflowstep, _this2.workflow, resp.data);
      });
    },
    removeAt: function removeAt(idx) {
      this.list.splice(idx, 1);
    },
    add: function add() {
      id++;
      this.list.push({
        name: "Juan " + id,
        id: id,
        text: ""
      });
    },
    orderChanged: function orderChanged(evt) {
      var _this3 = this;

      //console.log('gonna change order',evt, evt.moved.element, evt.moved.oldIndex, evt.moved.newIndex,this.workflowsteps);
      //console.log('lets change order:', this.workflowsteps);
      var fd = undefined;
      var changeForm = new Form({
        'titre': evt.moved.element.titre,
        'description': evt.moved.element.description,
        'workflow_id': evt.moved.element.workflow_id,
        'profile': evt.moved.element.profile,
        'posi': evt.moved.newIndex,
        'oldIndex': evt.moved.oldIndex,
        'newIndex': evt.moved.newIndex
      });
      changeForm.put("/workflowsteps/".concat(evt.moved.element.uuid), fd).then(function (workflowsteps) {
        //console.log('orderChanged', workflowsteps);
        _this3.workflowsteps = workflowsteps;
      })["catch"](function (error) {
        _this3.loading = false;
      });
    },
    createStep: function createStep(workflowstep) {
      var workflowstepIndex = this.workflowsteps.findIndex(function (c) {
        return workflowstep.id === c.id;
      }); // si cette étape n'existe pas déjà, on l'insère dans la liste

      if (workflowstepIndex === -1) {
        this.workflowsteps.push(workflowstep);
      }
    },
    updateStep: function updateStep(workflowstep) {
      // on récupère l'index de session modifiée
      var stepIndex = this.workflowsteps.findIndex(function (s) {
        return workflowstep.id === s.id;
      });

      if (stepIndex > -1) {
        this.workflowsteps.splice(stepIndex, 1, workflowstep);
      }
    },
    columnTdAttrs: function columnTdAttrs(row, column) {
      if (row.id === 'Total') {
        if (column.label === 'ID') {
          return {
            colspan: 4,
            "class": 'has-text-weight-bold',
            style: {
              'text-align': 'left !important'
            }
          };
        } else if (column.label === 'Gender') {
          return {
            "class": 'has-text-weight-semibold'
          };
        } else {
          return {
            style: {
              display: 'none'
            }
          };
        }
      }

      return null;
    }
  },
  computed: {
    transitionName: function transitionName() {
      if (this.useTransition) {
        return 'fade';
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/workflows/item.vue?vue&type=template&id=ccd1b126&scoped=true&":
/*!************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/workflows/item.vue?vue&type=template&id=ccd1b126&scoped=true& ***!
  \************************************************************************************************************************************************************************************************************************/
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
    { staticClass: "card" },
    [
      _c("header", [
        _c("div", { staticClass: "card-header-title row" }, [
          _c("div", { staticClass: "col-md-3 col-sm-8 col-12" }, [
            _c(
              "span",
              {
                staticClass: "text-purple text-sm",
                attrs: {
                  "data-toggle": "collapse",
                  "data-parent": "#workflowlist",
                  href: "#collapse-workflows-" + _vm.index
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
                    _vm._s(_vm.workflow.titre) +
                    "\n                "
                )
              ]
            )
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "col-md-3 col-sm-4 col-12 text-right" }, [
            _c("span", { staticClass: "text text-sm" }, [
              _c(
                "a",
                {
                  staticClass: "btn btn-tool text-success",
                  attrs: { type: "button", "data-toggle": "tooltip" },
                  on: {
                    click: function($event) {
                      return _vm.showFlowchart(_vm.workflow)
                    }
                  }
                },
                [_c("i", { staticClass: "fa fa-eye" })]
              ),
              _vm._v(" "),
              _c(
                "a",
                {
                  staticClass: "btn btn-tool text-warning",
                  attrs: { type: "button", "data-toggle": "tooltip" },
                  on: {
                    click: function($event) {
                      return _vm.editWorkflow(_vm.workflow)
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
                    "data-parent": "#workflowlist",
                    href: "#collapse-workflows-" + _vm.index
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
                      return _vm.deleteWorkflow(_vm.workflow.uuid, _vm.index)
                    }
                  }
                },
                [_c("i", { staticClass: "fas fa-trash" })]
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
          attrs: { id: "collapse-workflows-" + _vm.index }
        },
        [
          _c("div", { staticClass: "row" }, [
            _c("div", { staticClass: "col-md-3 col-sm-6 col-12" }, [
              _c("div", { staticClass: "card card-default" }, [
                _c("div", { staticClass: "card-body" }, [
                  _c("dt", { staticClass: "text text-xs" }, [_vm._v("Objet")]),
                  _vm._v(" "),
                  _c("dd", { staticClass: "text text-xs" }, [
                    _vm._v(_vm._s(_vm.workflow.object.model_type))
                  ]),
                  _vm._v(" "),
                  _c("dt", { staticClass: "text text-xs" }, [
                    _vm._v("Description")
                  ]),
                  _vm._v(" "),
                  _c("dd", { staticClass: "text text-xs" }, [
                    _vm._v(_vm._s(_vm.workflow.description))
                  ]),
                  _vm._v(" "),
                  _c("dt", { staticClass: "text text-xs" }, [
                    _vm._v("Date Création")
                  ]),
                  _vm._v(" "),
                  _c("dd", { staticClass: "text text-xs" }, [
                    _vm._v(
                      _vm._s(_vm._f("formatDate")(_vm.workflow.created_at))
                    )
                  ]),
                  _vm._v(" "),
                  _c("dd", { staticClass: "col-sm-8 offset-sm-4 text-xs" })
                ])
              ])
            ]),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "col-md-9 col-sm-6 col-12" },
              [
                _c("WorkflowSteps", {
                  attrs: {
                    workflow: _vm.workflow,
                    workflowsteps_prop: _vm.workflow.steps
                  }
                })
              ],
              1
            )
          ])
        ]
      ),
      _vm._v(" "),
      _c("AddUpdateStep", { attrs: { workflow_prop: _vm.workflow } })
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/workflowsteps/addupdate.vue?vue&type=template&id=ff972a18&scoped=true&":
/*!*********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/workflowsteps/addupdate.vue?vue&type=template&id=ff972a18&scoped=true& ***!
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
  return _c(
    "div",
    {
      staticClass: "modal fade",
      attrs: {
        id: "addUpdateWorkflowstep",
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
                  [_vm._v("Modifier Etape")]
                )
              : _c(
                  "h5",
                  {
                    staticClass: "modal-title text-sm",
                    attrs: { id: "exampleModalLabel" }
                  },
                  [_vm._v("Créer Nouvelle Etape")]
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
                    return _vm.workflowstepForm.errors.clear()
                  }
                }
              },
              [
                _c("div", { staticClass: "card-body" }, [
                  _c("div", { staticClass: "form-group row" }, [
                    _c(
                      "label",
                      {
                        staticClass: "col-sm-2 col-form-label text-xs",
                        attrs: { for: "step_titre" }
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
                            value: _vm.workflowstepForm.titre,
                            expression: "workflowstepForm.titre"
                          }
                        ],
                        staticClass: "form-control form-control-sm",
                        attrs: {
                          type: "text",
                          id: "step_titre",
                          name: "titre",
                          autocomplete: "titre",
                          autofocus: "",
                          placeholder: "Titre"
                        },
                        domProps: { value: _vm.workflowstepForm.titre },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.$set(
                              _vm.workflowstepForm,
                              "titre",
                              $event.target.value
                            )
                          }
                        }
                      }),
                      _vm._v(" "),
                      _vm.workflowstepForm.errors.has("titre")
                        ? _c("span", {
                            staticClass: " invalid-feedback d-block text-xs",
                            attrs: { role: "alert" },
                            domProps: {
                              textContent: _vm._s(
                                _vm.workflowstepForm.errors.get("titre")
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
                        attrs: { for: "step_description" }
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
                            value: _vm.workflowstepForm.description,
                            expression: "workflowstepForm.description"
                          }
                        ],
                        staticClass: "form-control form-control-sm",
                        attrs: {
                          type: "text",
                          id: "step_description",
                          name: "description",
                          required: "",
                          autocomplete: "description",
                          autofocus: "",
                          placeholder: "Description"
                        },
                        domProps: { value: _vm.workflowstepForm.description },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.$set(
                              _vm.workflowstepForm,
                              "description",
                              $event.target.value
                            )
                          }
                        }
                      }),
                      _vm._v(" "),
                      _vm.workflowstepForm.errors.has("description")
                        ? _c("span", {
                            staticClass: " invalid-feedback d-block text-xs",
                            attrs: { role: "alert" },
                            domProps: {
                              textContent: _vm._s(
                                _vm.workflowstepForm.errors.get("description")
                              )
                            }
                          })
                        : _vm._e()
                    ])
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "form-group row" }, [
                    _c(
                      "div",
                      { staticClass: "custom-control custom-radio col-sm-4" },
                      [
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.workflowstepForm.role_type,
                              expression: "workflowstepForm.role_type"
                            }
                          ],
                          staticClass: "custom-control-input",
                          attrs: {
                            type: "radio",
                            id: "role_static",
                            name: "role_type",
                            autocomplete: "role_static",
                            autofocus: "",
                            placeholder: "Profile Fixe",
                            value: "role_static"
                          },
                          domProps: {
                            checked: _vm._q(
                              _vm.workflowstepForm.role_type,
                              "role_static"
                            )
                          },
                          on: {
                            change: [
                              function($event) {
                                return _vm.$set(
                                  _vm.workflowstepForm,
                                  "role_type",
                                  "role_static"
                                )
                              },
                              function($event) {
                                return _vm.roleTypeChange($event)
                              }
                            ]
                          }
                        }),
                        _vm._v(" "),
                        _vm._m(1),
                        _vm._v(" "),
                        _vm.workflowstepForm.errors.has("role_static")
                          ? _c("span", {
                              staticClass: " invalid-feedback d-block text-xs",
                              attrs: { role: "alert" },
                              domProps: {
                                textContent: _vm._s(
                                  _vm.workflowstepForm.errors.get("role_static")
                                )
                              }
                            })
                          : _vm._e()
                      ]
                    ),
                    _vm._v(" "),
                    _vm.can_role_static
                      ? _c(
                          "div",
                          { staticClass: "col-sm-8" },
                          [
                            _c("multiselect", {
                              key: "id",
                              staticClass: "text text-xs",
                              attrs: {
                                id: "m_select_step_actor",
                                "selected.sync": "workflowstep.staticapprovers",
                                value: "",
                                options: _vm.roles,
                                searchable: true,
                                multiple: true,
                                label: "name",
                                "track-by": "id",
                                placeholder: "Profile(s) Acteur"
                              },
                              model: {
                                value: _vm.workflowstepForm.staticapprovers,
                                callback: function($$v) {
                                  _vm.$set(
                                    _vm.workflowstepForm,
                                    "staticapprovers",
                                    $$v
                                  )
                                },
                                expression: "workflowstepForm.staticapprovers"
                              }
                            }),
                            _vm._v(" "),
                            _vm.workflowstepForm.errors.has("staticapprovers")
                              ? _c("span", {
                                  staticClass:
                                    " invalid-feedback d-block text-xs",
                                  attrs: { role: "alert" },
                                  domProps: {
                                    textContent: _vm._s(
                                      _vm.workflowstepForm.errors.get(
                                        "staticapprovers"
                                      )
                                    )
                                  }
                                })
                              : _vm._e()
                          ],
                          1
                        )
                      : _vm._e()
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "form-group row" }, [
                    _c(
                      "div",
                      { staticClass: "custom-control custom-radio col-sm-4" },
                      [
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.workflowstepForm.role_type,
                              expression: "workflowstepForm.role_type"
                            }
                          ],
                          staticClass: "custom-control-input",
                          attrs: {
                            type: "radio",
                            id: "role_dynamic",
                            name: "role_type",
                            autocomplete: "role_dynamic",
                            autofocus: "",
                            placeholder: "Profile Dynamique",
                            value: "role_dynamic"
                          },
                          domProps: {
                            checked: _vm._q(
                              _vm.workflowstepForm.role_type,
                              "role_dynamic"
                            )
                          },
                          on: {
                            change: [
                              function($event) {
                                return _vm.$set(
                                  _vm.workflowstepForm,
                                  "role_type",
                                  "role_dynamic"
                                )
                              },
                              function($event) {
                                return _vm.roleTypeChange($event)
                              }
                            ]
                          }
                        }),
                        _vm._v(" "),
                        _vm._m(2),
                        _vm._v(" "),
                        _vm.workflowstepForm.errors.has("role_dynamic")
                          ? _c("span", {
                              staticClass: " invalid-feedback d-block text-xs",
                              attrs: { role: "alert" },
                              domProps: {
                                textContent: _vm._s(
                                  _vm.workflowstepForm.errors.get(
                                    "role_dynamic"
                                  )
                                )
                              }
                            })
                          : _vm._e()
                      ]
                    ),
                    _vm._v(" "),
                    _vm.workflowstepForm.role_dynamic
                      ? _c("div", { staticClass: "col-sm-8" }, [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.workflowstepForm.role_dynamic_label,
                                expression:
                                  "workflowstepForm.role_dynamic_label"
                              }
                            ],
                            staticClass: "form-control form-control-sm",
                            attrs: {
                              type: "text",
                              id: "role_dynamic_label",
                              name: "role_dynamic_label",
                              autocomplete: "role_dynamic_label",
                              autofocus: "",
                              placeholder: "Libellé du Profile"
                            },
                            domProps: {
                              value: _vm.workflowstepForm.role_dynamic_label
                            },
                            on: {
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.$set(
                                  _vm.workflowstepForm,
                                  "role_dynamic_label",
                                  $event.target.value
                                )
                              }
                            }
                          }),
                          _vm._v(" "),
                          _vm.workflowstepForm.errors.has("role_dynamic_label")
                            ? _c("span", {
                                staticClass:
                                  " invalid-feedback d-block text-xs",
                                attrs: { role: "alert" },
                                domProps: {
                                  textContent: _vm._s(
                                    _vm.workflowstepForm.errors.get(
                                      "role_dynamic_label"
                                    )
                                  )
                                }
                              })
                            : _vm._e()
                        ])
                      : _vm._e()
                  ]),
                  _vm._v(" "),
                  _vm.workflowstepForm.role_dynamic
                    ? _c("div", { staticClass: "form-group row" }, [
                        _c("div", { staticClass: "col-sm-4" }),
                        _vm._v(" "),
                        _vm.workflowstepForm.role_dynamic
                          ? _c("div", { staticClass: "col-sm-8" }, [
                              _c("input", {
                                directives: [
                                  {
                                    name: "model",
                                    rawName: "v-model",
                                    value:
                                      _vm.workflowstepForm
                                        .role_dynamic_previous_label,
                                    expression:
                                      "workflowstepForm.role_dynamic_previous_label"
                                  }
                                ],
                                staticClass: "form-control form-control-sm",
                                attrs: {
                                  type: "text",
                                  id: "role_dynamic_previous_label",
                                  name: "role_dynamic_label",
                                  autocomplete: "role_dynamic_previous_label",
                                  autofocus: "",
                                  placeholder: "Libellé du profile Précédent"
                                },
                                domProps: {
                                  value:
                                    _vm.workflowstepForm
                                      .role_dynamic_previous_label
                                },
                                on: {
                                  input: function($event) {
                                    if ($event.target.composing) {
                                      return
                                    }
                                    _vm.$set(
                                      _vm.workflowstepForm,
                                      "role_dynamic_previous_label",
                                      $event.target.value
                                    )
                                  }
                                }
                              }),
                              _vm._v(" "),
                              _vm.workflowstepForm.errors.has(
                                "role_dynamic_previous_label"
                              )
                                ? _c("span", {
                                    staticClass:
                                      " invalid-feedback d-block text-xs",
                                    attrs: { role: "alert" },
                                    domProps: {
                                      textContent: _vm._s(
                                        _vm.workflowstepForm.errors.get(
                                          "role_dynamic_previous_label"
                                        )
                                      )
                                    }
                                  })
                                : _vm._e()
                            ])
                          : _vm._e()
                      ])
                    : _vm._e(),
                  _vm._v(" "),
                  _c("div", { staticClass: "form-group row" }, [
                    _c(
                      "div",
                      { staticClass: "custom-control custom-radio col-sm-6" },
                      [
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.workflowstepForm.role_type,
                              expression: "workflowstepForm.role_type"
                            }
                          ],
                          staticClass: "custom-control-input",
                          attrs: {
                            type: "radio",
                            id: "role_previous",
                            name: "role_type",
                            autocomplete: "role_previous",
                            autofocus: "",
                            placeholder:
                              "Profile Identique à l'Etape précédente",
                            value: "role_previous"
                          },
                          domProps: {
                            checked: _vm._q(
                              _vm.workflowstepForm.role_type,
                              "role_previous"
                            )
                          },
                          on: {
                            change: [
                              function($event) {
                                return _vm.$set(
                                  _vm.workflowstepForm,
                                  "role_type",
                                  "role_previous"
                                )
                              },
                              function($event) {
                                return _vm.roleTypeChange($event)
                              }
                            ]
                          }
                        }),
                        _vm._v(" "),
                        _vm._m(3),
                        _vm._v(" "),
                        _vm.workflowstepForm.errors.has("role_previous")
                          ? _c("span", {
                              staticClass: " invalid-feedback d-block text-xs",
                              attrs: { role: "alert" },
                              domProps: {
                                textContent: _vm._s(
                                  _vm.workflowstepForm.errors.get(
                                    "role_previous"
                                  )
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
                        staticClass: "col-sm-4 col-form-label text-xs",
                        attrs: { for: "m_select_validatednextstep" }
                      },
                      [_vm._v("Prochaine Etape après Validation")]
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "col-sm-8 text-xs" },
                      [
                        _c("multiselect", {
                          key: "id",
                          staticClass: "text text-xs",
                          attrs: {
                            disabled: true,
                            id: "m_select_validatednextstep",
                            "selected.sync": "workflowstep.transitionpassstep",
                            value: "",
                            deselectLabel: "Touche Entrer pour retirer",
                            options: _vm.workflowsteps,
                            searchable: true,
                            multiple: false,
                            label: "titre",
                            "track-by": "id",
                            placeholder: "Etape après validation"
                          },
                          model: {
                            value: _vm.workflowstepForm.transitionpassstep,
                            callback: function($$v) {
                              _vm.$set(
                                _vm.workflowstepForm,
                                "transitionpassstep",
                                $$v
                              )
                            },
                            expression: "workflowstepForm.transitionpassstep"
                          }
                        }),
                        _vm._v(" "),
                        _vm.workflowstepForm.errors.has("transitionpassstep")
                          ? _c("span", {
                              staticClass: " invalid-feedback d-block text-xs",
                              attrs: { role: "alert" },
                              domProps: {
                                textContent: _vm._s(
                                  _vm.workflowstepForm.errors.get(
                                    "transitionpassstep"
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
                        staticClass: "col-sm-4 col-form-label text-xs",
                        attrs: { for: "m_select_rejectednextstep" }
                      },
                      [_vm._v("Prochaine Etape après Réjet")]
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "col-sm-8" },
                      [
                        _c("multiselect", {
                          key: "id",
                          staticClass: "text-xs",
                          attrs: {
                            id: "m_select_rejectednextstep",
                            disabled: true,
                            "selected.sync":
                              "workflowstep.transitionrejectstep",
                            value: "",
                            options: _vm.workflowsteps,
                            searchable: true,
                            multiple: false,
                            label: "titre",
                            "track-by": "id",
                            placeholder: "Etape après réjet"
                          },
                          model: {
                            value: _vm.workflowstepForm.transitionrejectstep,
                            callback: function($$v) {
                              _vm.$set(
                                _vm.workflowstepForm,
                                "transitionrejectstep",
                                $$v
                              )
                            },
                            expression: "workflowstepForm.transitionrejectstep"
                          }
                        }),
                        _vm._v(" "),
                        _vm.workflowstepForm.errors.has("transitionrejectstep")
                          ? _c("span", {
                              staticClass: "invalid-feedback d-block text-xs",
                              attrs: { role: "alert" },
                              domProps: {
                                textContent: _vm._s(
                                  _vm.workflowstepForm.errors.get(
                                    "transitionrejectstep"
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
                      "div",
                      {
                        staticClass:
                          "custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-4"
                      },
                      [
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.workflowstepForm.can_expire,
                              expression: "workflowstepForm.can_expire"
                            }
                          ],
                          staticClass: "custom-control-input",
                          attrs: {
                            type: "checkbox",
                            id: "can_expire",
                            name: "can_expire",
                            autocomplete: "can_expire"
                          },
                          domProps: {
                            checked: Array.isArray(
                              _vm.workflowstepForm.can_expire
                            )
                              ? _vm._i(_vm.workflowstepForm.can_expire, null) >
                                -1
                              : _vm.workflowstepForm.can_expire
                          },
                          on: {
                            change: function($event) {
                              var $$a = _vm.workflowstepForm.can_expire,
                                $$el = $event.target,
                                $$c = $$el.checked ? true : false
                              if (Array.isArray($$a)) {
                                var $$v = null,
                                  $$i = _vm._i($$a, $$v)
                                if ($$el.checked) {
                                  $$i < 0 &&
                                    _vm.$set(
                                      _vm.workflowstepForm,
                                      "can_expire",
                                      $$a.concat([$$v])
                                    )
                                } else {
                                  $$i > -1 &&
                                    _vm.$set(
                                      _vm.workflowstepForm,
                                      "can_expire",
                                      $$a
                                        .slice(0, $$i)
                                        .concat($$a.slice($$i + 1))
                                    )
                                }
                              } else {
                                _vm.$set(
                                  _vm.workflowstepForm,
                                  "can_expire",
                                  $$c
                                )
                              }
                            }
                          }
                        }),
                        _vm._v(" "),
                        _vm._m(4),
                        _vm._v(" "),
                        _vm.workflowstepForm.errors.has("can_expire")
                          ? _c("span", {
                              staticClass: " invalid-feedback d-block text-xs",
                              attrs: { role: "alert" },
                              domProps: {
                                textContent: _vm._s(
                                  _vm.workflowstepForm.errors.get("can_expire")
                                )
                              }
                            })
                          : _vm._e()
                      ]
                    )
                  ]),
                  _vm._v(" "),
                  _vm.workflowstepForm.can_expire
                    ? _c("div", { staticClass: "form-group row" }, [
                        _c("div", { staticClass: "col col-sm-4" }),
                        _vm._v(" "),
                        _c(
                          "div",
                          {
                            staticClass:
                              "input-group input-group-sm mb-3 col-sm-4"
                          },
                          [
                            _c("input", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: _vm.workflowstepForm.expire_hours,
                                  expression: "workflowstepForm.expire_hours"
                                }
                              ],
                              staticClass:
                                "form-control form-control-sm text-left",
                              attrs: {
                                type: "text",
                                id: "expire_hours",
                                name: "expire_hours",
                                autocomplete: "expire_hours",
                                autofocus: "",
                                placeholder: "validité (hrs)"
                              },
                              domProps: {
                                value: _vm.workflowstepForm.expire_hours
                              },
                              on: {
                                input: function($event) {
                                  if ($event.target.composing) {
                                    return
                                  }
                                  _vm.$set(
                                    _vm.workflowstepForm,
                                    "expire_hours",
                                    $event.target.value
                                  )
                                }
                              }
                            }),
                            _vm._v(" "),
                            _vm._m(5),
                            _vm._v(" "),
                            _vm.workflowstepForm.errors.has("expire_hours")
                              ? _c("span", {
                                  staticClass:
                                    " invalid-feedback d-block text-xs",
                                  attrs: { role: "alert" },
                                  domProps: {
                                    textContent: _vm._s(
                                      _vm.workflowstepForm.errors.get(
                                        "expire_hours"
                                      )
                                    )
                                  }
                                })
                              : _vm._e()
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          {
                            staticClass:
                              "input-group input-group-sm mb-3 col-sm-4"
                          },
                          [
                            _c("input", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: _vm.workflowstepForm.expire_days,
                                  expression: "workflowstepForm.expire_days"
                                }
                              ],
                              staticClass: "form-control form-control-sm",
                              attrs: {
                                type: "text",
                                id: "expire_days",
                                name: "expire_days",
                                autocomplete: "expire_days",
                                autofocus: "",
                                placeholder: "validité (jrs)"
                              },
                              domProps: {
                                value: _vm.workflowstepForm.expire_days
                              },
                              on: {
                                input: function($event) {
                                  if ($event.target.composing) {
                                    return
                                  }
                                  _vm.$set(
                                    _vm.workflowstepForm,
                                    "expire_days",
                                    $event.target.value
                                  )
                                }
                              }
                            }),
                            _vm._v(" "),
                            _vm._m(6),
                            _vm._v(" "),
                            _vm.workflowstepForm.errors.has("expire_days")
                              ? _c("span", {
                                  staticClass:
                                    " invalid-feedback d-block text-xs",
                                  attrs: { role: "alert" },
                                  domProps: {
                                    textContent: _vm._s(
                                      _vm.workflowstepForm.errors.get(
                                        "expire_days"
                                      )
                                    )
                                  }
                                })
                              : _vm._e()
                          ]
                        )
                      ])
                    : _vm._e(),
                  _vm._v(" "),
                  _vm.workflowstepForm.can_expire
                    ? _c("div", { staticClass: "form-group row" }, [
                        _c("div", { staticClass: "col col-sm-4" }),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "col-sm-8" },
                          [
                            _c("multiselect", {
                              key: "id",
                              staticClass: "text-xs",
                              attrs: {
                                id: "m_select_expirednextstep",
                                "selected.sync":
                                  "workflowstep.transitionexpirestep",
                                disabled: true,
                                value: "",
                                options: _vm.workflowsteps,
                                searchable: true,
                                multiple: false,
                                label: "titre",
                                "track-by": "id",
                                placeholder: "Prochaine Etape après expiration"
                              },
                              model: {
                                value:
                                  _vm.workflowstepForm.transitionexpirestep,
                                callback: function($$v) {
                                  _vm.$set(
                                    _vm.workflowstepForm,
                                    "transitionexpirestep",
                                    $$v
                                  )
                                },
                                expression:
                                  "workflowstepForm.transitionexpirestep"
                              }
                            }),
                            _vm._v(" "),
                            _vm.workflowstepForm.errors.has(
                              "transitionexpirestep"
                            )
                              ? _c("span", {
                                  staticClass:
                                    " invalid-feedback d-block text-xs",
                                  attrs: { role: "alert" },
                                  domProps: {
                                    textContent: _vm._s(
                                      _vm.workflowstepForm.errors.get(
                                        "transitionexpirestep"
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
                      "div",
                      {
                        staticClass:
                          "custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-4"
                      },
                      [
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.workflowstepForm.notify_to_approvers,
                              expression: "workflowstepForm.notify_to_approvers"
                            }
                          ],
                          staticClass: "custom-control-input",
                          attrs: {
                            type: "checkbox",
                            id: "notify_to_approvers",
                            name: "notify_to_approvers",
                            autocomplete: "notify_to_approvers",
                            autofocus: "",
                            placeholder: "Notifier les Acteurs"
                          },
                          domProps: {
                            checked: Array.isArray(
                              _vm.workflowstepForm.notify_to_approvers
                            )
                              ? _vm._i(
                                  _vm.workflowstepForm.notify_to_approvers,
                                  null
                                ) > -1
                              : _vm.workflowstepForm.notify_to_approvers
                          },
                          on: {
                            change: function($event) {
                              var $$a =
                                  _vm.workflowstepForm.notify_to_approvers,
                                $$el = $event.target,
                                $$c = $$el.checked ? true : false
                              if (Array.isArray($$a)) {
                                var $$v = null,
                                  $$i = _vm._i($$a, $$v)
                                if ($$el.checked) {
                                  $$i < 0 &&
                                    _vm.$set(
                                      _vm.workflowstepForm,
                                      "notify_to_approvers",
                                      $$a.concat([$$v])
                                    )
                                } else {
                                  $$i > -1 &&
                                    _vm.$set(
                                      _vm.workflowstepForm,
                                      "notify_to_approvers",
                                      $$a
                                        .slice(0, $$i)
                                        .concat($$a.slice($$i + 1))
                                    )
                                }
                              } else {
                                _vm.$set(
                                  _vm.workflowstepForm,
                                  "notify_to_approvers",
                                  $$c
                                )
                              }
                            }
                          }
                        }),
                        _vm._v(" "),
                        _vm._m(7),
                        _vm._v(" "),
                        _vm.workflowstepForm.errors.has("notify_to_approvers")
                          ? _c("span", {
                              staticClass: " invalid-feedback d-block text-xs",
                              attrs: { role: "alert" },
                              domProps: {
                                textContent: _vm._s(
                                  _vm.workflowstepForm.errors.get(
                                    "notify_to_approvers"
                                  )
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
                      "div",
                      {
                        staticClass:
                          "custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-4"
                      },
                      [
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.workflowstepForm.notify_to_others,
                              expression: "workflowstepForm.notify_to_others"
                            }
                          ],
                          staticClass: "custom-control-input",
                          attrs: {
                            type: "checkbox",
                            id: "notify_to_others",
                            name: "notify_to_others",
                            autocomplete: "notify_to_others",
                            autofocus: "",
                            placeholder: "Notifier d'Autres Utilisateurs"
                          },
                          domProps: {
                            checked: Array.isArray(
                              _vm.workflowstepForm.notify_to_others
                            )
                              ? _vm._i(
                                  _vm.workflowstepForm.notify_to_others,
                                  null
                                ) > -1
                              : _vm.workflowstepForm.notify_to_others
                          },
                          on: {
                            change: function($event) {
                              var $$a = _vm.workflowstepForm.notify_to_others,
                                $$el = $event.target,
                                $$c = $$el.checked ? true : false
                              if (Array.isArray($$a)) {
                                var $$v = null,
                                  $$i = _vm._i($$a, $$v)
                                if ($$el.checked) {
                                  $$i < 0 &&
                                    _vm.$set(
                                      _vm.workflowstepForm,
                                      "notify_to_others",
                                      $$a.concat([$$v])
                                    )
                                } else {
                                  $$i > -1 &&
                                    _vm.$set(
                                      _vm.workflowstepForm,
                                      "notify_to_others",
                                      $$a
                                        .slice(0, $$i)
                                        .concat($$a.slice($$i + 1))
                                    )
                                }
                              } else {
                                _vm.$set(
                                  _vm.workflowstepForm,
                                  "notify_to_others",
                                  $$c
                                )
                              }
                            }
                          }
                        }),
                        _vm._v(" "),
                        _vm._m(8),
                        _vm._v(" "),
                        _vm.workflowstepForm.errors.has("notify_to_others")
                          ? _c("span", {
                              staticClass: " invalid-feedback d-block text-xs",
                              attrs: { role: "alert" },
                              domProps: {
                                textContent: _vm._s(
                                  _vm.workflowstepForm.errors.get(
                                    "notify_to_others"
                                  )
                                )
                              }
                            })
                          : _vm._e()
                      ]
                    ),
                    _vm._v(" "),
                    _vm.workflowstepForm.notify_to_others
                      ? _c(
                          "div",
                          { staticClass: "col-sm-8" },
                          [
                            _c("multiselect", {
                              key: "id",
                              staticClass: "text-xs",
                              attrs: {
                                id: "m_select_otherstonotify",
                                "selected.sync": "workflowstep.otherstonotify",
                                value: "",
                                options: _vm.users,
                                searchable: true,
                                multiple: true,
                                label: "name",
                                "track-by": "id",
                                placeholder: "Autres Utilisateurs à Notifier"
                              },
                              model: {
                                value: _vm.workflowstepForm.otherstonotify,
                                callback: function($$v) {
                                  _vm.$set(
                                    _vm.workflowstepForm,
                                    "otherstonotify",
                                    $$v
                                  )
                                },
                                expression: "workflowstepForm.otherstonotify"
                              }
                            }),
                            _vm._v(" "),
                            _vm.workflowstepForm.errors.has("otherstonotify")
                              ? _c("span", {
                                  staticClass:
                                    " invalid-feedback d-block text-xs",
                                  attrs: { role: "alert" },
                                  domProps: {
                                    textContent: _vm._s(
                                      _vm.workflowstepForm.errors.get(
                                        "otherstonotify"
                                      )
                                    )
                                  }
                                })
                              : _vm._e()
                          ],
                          1
                        )
                      : _vm._e()
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "form-group row" }, [
                    _c(
                      "label",
                      {
                        staticClass:
                          "col-sm-4 col-form-label text-xs text-orange",
                        attrs: { for: "m_select_stepparent" }
                      },
                      [_vm._v("Etape Parent")]
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "col-sm-8" },
                      [
                        _c("multiselect", {
                          key: "id",
                          staticClass: "text-xs",
                          attrs: {
                            id: "m_select_stepparent",
                            "selected.sync": "workflowstep.stepparent",
                            value: "",
                            options: _vm.workflowsteps,
                            searchable: true,
                            multiple: false,
                            label: "titre",
                            "track-by": "id",
                            placeholder: "Etape Parent"
                          },
                          model: {
                            value: _vm.workflowstepForm.stepparent,
                            callback: function($$v) {
                              _vm.$set(_vm.workflowstepForm, "stepparent", $$v)
                            },
                            expression: "workflowstepForm.stepparent"
                          }
                        }),
                        _vm._v(" "),
                        _vm.workflowstepForm.errors.has("stepparent")
                          ? _c("span", {
                              staticClass: " invalid-feedback d-block text-xs",
                              attrs: { role: "alert" },
                              domProps: {
                                textContent: _vm._s(
                                  _vm.workflowstepForm.errors.get("stepparent")
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
                    {
                      staticClass: "form-group row",
                      attrs: { id: "flowchartattributes" }
                    },
                    [
                      _c("div", { staticClass: "col" }, [
                        _c("div", { staticClass: "card" }, [
                          _c("header", [
                            _c(
                              "div",
                              { staticClass: "card-header-title row" },
                              [
                                _c(
                                  "div",
                                  { staticClass: "col-md-6 col-sm-8 col-12" },
                                  [
                                    _c(
                                      "span",
                                      {
                                        staticClass: "text-danger text-xs",
                                        attrs: {
                                          "data-toggle": "collapse",
                                          "data-parent": "#flowchartattributes",
                                          href:
                                            "#collapse-flowchart-" +
                                            _vm.workflowstep.id
                                        },
                                        on: {
                                          click: function($event) {
                                            return _vm.collapseFlowchartClicked()
                                          }
                                        }
                                      },
                                      [
                                        _vm._v(
                                          "\n                                                Design Diagramme\n                                            "
                                        )
                                      ]
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "div",
                                  {
                                    staticClass:
                                      "col-md-6 col-sm-4 col-12 text-right"
                                  },
                                  [
                                    _c(
                                      "span",
                                      { staticClass: "text text-sm" },
                                      [
                                        _c(
                                          "a",
                                          {
                                            staticClass: "btn btn-tool",
                                            attrs: {
                                              type: "button",
                                              "data-toggle": "collapse",
                                              "data-parent":
                                                "#flowchartattributes",
                                              href:
                                                "#collapse-flowchart-" +
                                                _vm.workflowstep.id
                                            },
                                            on: {
                                              click: function($event) {
                                                return _vm.collapseFlowchartClicked()
                                              }
                                            }
                                          },
                                          [
                                            _c("i", {
                                              class:
                                                _vm.currentFlowchartCollapseIcon
                                            })
                                          ]
                                        )
                                      ]
                                    )
                                  ]
                                )
                              ]
                            )
                          ]),
                          _vm._v(" "),
                          _c(
                            "div",
                            {
                              staticClass:
                                "card-content panel-collapse collapse in",
                              attrs: {
                                id: "collapse-flowchart-" + _vm.workflowstep.id
                              }
                            },
                            [
                              _c(
                                "b-field",
                                {
                                  attrs: { grouped: "", "group-multiline": "" }
                                },
                                [
                                  _c(
                                    "b-field",
                                    {
                                      attrs: {
                                        label: "Class de Style",
                                        "label-position": "on-border",
                                        "custom-class": "is-small"
                                      }
                                    },
                                    [
                                      _c("b-input", {
                                        attrs: { size: "is-small" },
                                        model: {
                                          value:
                                            _vm.workflowstepForm.stylingClass,
                                          callback: function($$v) {
                                            _vm.$set(
                                              _vm.workflowstepForm,
                                              "stylingClass",
                                              $$v
                                            )
                                          },
                                          expression:
                                            "workflowstepForm.stylingClass"
                                        }
                                      })
                                    ],
                                    1
                                  )
                                ],
                                1
                              ),
                              _vm._v(" "),
                              _c("br"),
                              _vm._v(" "),
                              _c(
                                "b-field",
                                {
                                  attrs: { grouped: "", "group-multiline": "" }
                                },
                                [
                                  _c(
                                    "b-field",
                                    {
                                      attrs: {
                                        label: "Position X",
                                        "label-position": "on-border",
                                        "custom-class": "is-small",
                                        type: _vm.workflowstepForm.errors.has(
                                          "flowchart_position_x"
                                        )
                                          ? "is-danger"
                                          : "",
                                        message: _vm.workflowstepForm.errors.get(
                                          "flowchart_position_x"
                                        )
                                      }
                                    },
                                    [
                                      _c("b-input", {
                                        attrs: {
                                          name: "flowchart_position_x",
                                          type: "number",
                                          size: "is-small"
                                        },
                                        model: {
                                          value:
                                            _vm.workflowstepForm
                                              .flowchart_position_x,
                                          callback: function($$v) {
                                            _vm.$set(
                                              _vm.workflowstepForm,
                                              "flowchart_position_x",
                                              $$v
                                            )
                                          },
                                          expression:
                                            "workflowstepForm.flowchart_position_x"
                                        }
                                      })
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "b-field",
                                    {
                                      attrs: {
                                        label: "Position Y",
                                        "label-position": "on-border",
                                        "custom-class": "is-small",
                                        type: _vm.workflowstepForm.errors.has(
                                          "flowchart_position_y"
                                        )
                                          ? "is-danger"
                                          : "",
                                        message: _vm.workflowstepForm.errors.get(
                                          "flowchart_position_y"
                                        )
                                      }
                                    },
                                    [
                                      _c("b-input", {
                                        attrs: {
                                          name: "flowchart_position_y",
                                          type: "number",
                                          size: "is-small"
                                        },
                                        model: {
                                          value:
                                            _vm.workflowstepForm
                                              .flowchart_position_y,
                                          callback: function($$v) {
                                            _vm.$set(
                                              _vm.workflowstepForm,
                                              "flowchart_position_y",
                                              $$v
                                            )
                                          },
                                          expression:
                                            "workflowstepForm.flowchart_position_y"
                                        }
                                      })
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "b-field",
                                    {
                                      attrs: {
                                        label: "Largeur du box",
                                        "label-position": "on-border",
                                        "custom-class": "is-small",
                                        type: _vm.workflowstepForm.errors.has(
                                          "flowchart_size_width"
                                        )
                                          ? "is-danger"
                                          : "",
                                        message: _vm.workflowstepForm.errors.get(
                                          "flowchart_size_width"
                                        )
                                      }
                                    },
                                    [
                                      _c("b-input", {
                                        attrs: {
                                          name: "flowchart_size_width",
                                          type: "number",
                                          size: "is-small"
                                        },
                                        model: {
                                          value:
                                            _vm.workflowstepForm
                                              .flowchart_size_width,
                                          callback: function($$v) {
                                            _vm.$set(
                                              _vm.workflowstepForm,
                                              "flowchart_size_width",
                                              $$v
                                            )
                                          },
                                          expression:
                                            "workflowstepForm.flowchart_size_width"
                                        }
                                      })
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "b-field",
                                    {
                                      attrs: {
                                        label: "Hauteur du box",
                                        "label-position": "on-border",
                                        "custom-class": "is-small",
                                        type: _vm.workflowstepForm.errors.has(
                                          "flowchart_size_height"
                                        )
                                          ? "is-danger"
                                          : "",
                                        message: _vm.workflowstepForm.errors.get(
                                          "flowchart_size_height"
                                        )
                                      }
                                    },
                                    [
                                      _c("b-input", {
                                        attrs: {
                                          name: "flowchart_size_height",
                                          type: "number",
                                          size: "is-small"
                                        },
                                        model: {
                                          value:
                                            _vm.workflowstepForm
                                              .flowchart_size_height,
                                          callback: function($$v) {
                                            _vm.$set(
                                              _vm.workflowstepForm,
                                              "flowchart_size_height",
                                              $$v
                                            )
                                          },
                                          expression:
                                            "workflowstepForm.flowchart_size_height"
                                        }
                                      })
                                    ],
                                    1
                                  )
                                ],
                                1
                              ),
                              _vm._v(" "),
                              _c("hr"),
                              _vm._v(" "),
                              _c(
                                "b-field",
                                {
                                  attrs: { grouped: "", "group-multiline": "" }
                                },
                                [
                                  _c("b-button", {
                                    attrs: {
                                      label: "Valider",
                                      type: "is-danger is-light",
                                      size: "is-small",
                                      loading: _vm.loading
                                    },
                                    on: {
                                      click: function($event) {
                                        return _vm.updateFlowchartNode(
                                          _vm.workflow.id
                                        )
                                      }
                                    }
                                  })
                                ],
                                1
                              )
                            ],
                            1
                          )
                        ])
                      ])
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    {
                      staticClass: "form-group row",
                      attrs: { id: "reminderattributes" }
                    },
                    [
                      _c("div", { staticClass: "col" }, [
                        _c("div", { staticClass: "card" }, [
                          _c("header", [
                            _c(
                              "div",
                              { staticClass: "card-header-title row" },
                              [
                                _c(
                                  "div",
                                  { staticClass: "col-md-6 col-sm-8 col-12" },
                                  [
                                    _c(
                                      "span",
                                      {
                                        staticClass: "text-danger text-xs",
                                        attrs: {
                                          "data-toggle": "collapse",
                                          "data-parent": "#reminderattributes",
                                          href:
                                            "#collapse-reminder-" +
                                            _vm.workflowstep.id
                                        },
                                        on: {
                                          click: function($event) {
                                            return _vm.collapseReminderClicked()
                                          }
                                        }
                                      },
                                      [
                                        _vm._v(
                                          "\n                                                Rappel\n                                            "
                                        )
                                      ]
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "div",
                                  {
                                    staticClass:
                                      "col-md-6 col-sm-4 col-12 text-right"
                                  },
                                  [
                                    _c(
                                      "span",
                                      { staticClass: "text text-sm" },
                                      [
                                        _c(
                                          "a",
                                          {
                                            staticClass: "btn btn-tool",
                                            attrs: {
                                              type: "button",
                                              "data-toggle": "collapse",
                                              "data-parent":
                                                "#reminderattributes",
                                              href:
                                                "#collapse-reminder-" +
                                                _vm.workflowstep.id
                                            },
                                            on: {
                                              click: function($event) {
                                                return _vm.collapseReminderClicked()
                                              }
                                            }
                                          },
                                          [
                                            _c("i", {
                                              class:
                                                _vm.currentReminderCollapseIcon
                                            })
                                          ]
                                        )
                                      ]
                                    )
                                  ]
                                )
                              ]
                            )
                          ]),
                          _vm._v(" "),
                          _c(
                            "div",
                            {
                              staticClass:
                                "card-content panel-collapse collapse in",
                              attrs: {
                                id: "collapse-reminder-" + _vm.workflowstep.id
                              }
                            },
                            [
                              _c(
                                "b-field",
                                {
                                  attrs: {
                                    label: "Titre",
                                    "label-position": "on-border",
                                    "custom-class": "is-small",
                                    type: _vm.reminderForm.errors.has("title")
                                      ? "is-danger"
                                      : "",
                                    message: _vm.reminderForm.errors.get(
                                      "title"
                                    )
                                  }
                                },
                                [
                                  _c("b-input", {
                                    attrs: { name: "title", size: "is-small" },
                                    model: {
                                      value: _vm.reminderForm.title,
                                      callback: function($$v) {
                                        _vm.$set(_vm.reminderForm, "title", $$v)
                                      },
                                      expression: "reminderForm.title"
                                    }
                                  })
                                ],
                                1
                              ),
                              _vm._v(" "),
                              _c("br"),
                              _vm._v(" "),
                              _c(
                                "b-field",
                                {
                                  attrs: { grouped: "", "group-multiline": "" }
                                },
                                [
                                  _c(
                                    "b-field",
                                    {
                                      attrs: {
                                        label: "Durée Expiration (H)",
                                        "label-position": "on-border",
                                        "custom-class": "is-small",
                                        type: _vm.reminderForm.errors.has(
                                          "duration"
                                        )
                                          ? "is-danger"
                                          : "",
                                        message: _vm.reminderForm.errors.get(
                                          "duration"
                                        )
                                      }
                                    },
                                    [
                                      _c("b-input", {
                                        attrs: {
                                          name: "duration",
                                          type: "number",
                                          min: "1",
                                          size: "is-small"
                                        },
                                        model: {
                                          value: _vm.reminderForm.duration,
                                          callback: function($$v) {
                                            _vm.$set(
                                              _vm.reminderForm,
                                              "duration",
                                              $$v
                                            )
                                          },
                                          expression: "reminderForm.duration"
                                        }
                                      })
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "b-field",
                                    {
                                      attrs: {
                                        label: "Interval notification (H)",
                                        "label-position": "on-border",
                                        "custom-class": "is-small",
                                        type: _vm.reminderForm.errors.has(
                                          "notification_interval"
                                        )
                                          ? "is-danger"
                                          : "",
                                        message: _vm.reminderForm.errors.get(
                                          "notification_interval"
                                        )
                                      }
                                    },
                                    [
                                      _c("b-input", {
                                        attrs: {
                                          name: "notification_interval",
                                          type: "number",
                                          min: "1",
                                          size: "is-small"
                                        },
                                        model: {
                                          value:
                                            _vm.reminderForm
                                              .notification_interval,
                                          callback: function($$v) {
                                            _vm.$set(
                                              _vm.reminderForm,
                                              "notification_interval",
                                              $$v
                                            )
                                          },
                                          expression:
                                            "reminderForm.notification_interval"
                                        }
                                      })
                                    ],
                                    1
                                  )
                                ],
                                1
                              ),
                              _vm._v(" "),
                              _c("br"),
                              _vm._v(" "),
                              _c(
                                "b-field",
                                {
                                  attrs: {
                                    label: "Message",
                                    "label-position": "on-border",
                                    "custom-class": "is-small",
                                    type: _vm.reminderForm.errors.has("msg")
                                      ? "is-danger"
                                      : "",
                                    message: _vm.reminderForm.errors.get("msg")
                                  }
                                },
                                [
                                  _c("b-input", {
                                    attrs: { name: "msg", size: "is-small" },
                                    model: {
                                      value: _vm.reminderForm.msg,
                                      callback: function($$v) {
                                        _vm.$set(_vm.reminderForm, "msg", $$v)
                                      },
                                      expression: "reminderForm.msg"
                                    }
                                  })
                                ],
                                1
                              ),
                              _vm._v(" "),
                              _c("br"),
                              _vm._v(" "),
                              _c(
                                "b-field",
                                {
                                  attrs: {
                                    label: "Description",
                                    "label-position": "on-border",
                                    "custom-class": "is-small",
                                    type: _vm.reminderForm.errors.has(
                                      "description"
                                    )
                                      ? "is-danger"
                                      : "",
                                    message: _vm.reminderForm.errors.get(
                                      "description"
                                    )
                                  }
                                },
                                [
                                  _c("b-input", {
                                    attrs: {
                                      name: "description",
                                      size: "is-small"
                                    },
                                    model: {
                                      value: _vm.reminderForm.description,
                                      callback: function($$v) {
                                        _vm.$set(
                                          _vm.reminderForm,
                                          "description",
                                          $$v
                                        )
                                      },
                                      expression: "reminderForm.description"
                                    }
                                  })
                                ],
                                1
                              ),
                              _vm._v(" "),
                              _c("br"),
                              _vm._v(" "),
                              _c(
                                "b-field",
                                {
                                  attrs: {
                                    label: "Statut",
                                    "label-position": "on-border",
                                    "custom-class": "is-small"
                                  }
                                },
                                [
                                  _c(
                                    "b-radio-button",
                                    {
                                      attrs: {
                                        size: "is-small",
                                        "native-value": "active",
                                        type: "is-success is-light is-outlined"
                                      },
                                      model: {
                                        value: _vm.reminderForm.status.code,
                                        callback: function($$v) {
                                          _vm.$set(
                                            _vm.reminderForm.status,
                                            "code",
                                            $$v
                                          )
                                        },
                                        expression: "reminderForm.status.code"
                                      }
                                    },
                                    [
                                      _c("b-icon", {
                                        attrs: { icon: "check" }
                                      }),
                                      _vm._v(" "),
                                      _c("span", [_vm._v("Actif")])
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "b-radio-button",
                                    {
                                      attrs: {
                                        size: "is-small",
                                        "native-value": "inactive",
                                        type: "is-danger is-light is-outlined"
                                      },
                                      model: {
                                        value: _vm.reminderForm.status.code,
                                        callback: function($$v) {
                                          _vm.$set(
                                            _vm.reminderForm.status,
                                            "code",
                                            $$v
                                          )
                                        },
                                        expression: "reminderForm.status.code"
                                      }
                                    },
                                    [
                                      _c("b-icon", {
                                        attrs: { icon: "close" }
                                      }),
                                      _vm._v(" "),
                                      _c("span", [_vm._v("Inactif")])
                                    ],
                                    1
                                  )
                                ],
                                1
                              ),
                              _vm._v(" "),
                              _c("hr"),
                              _vm._v(" "),
                              _c(
                                "b-field",
                                {
                                  attrs: { grouped: "", "group-multiline": "" }
                                },
                                [
                                  _c("b-button", {
                                    attrs: {
                                      label: "Valider",
                                      type: "is-danger is-light",
                                      size: "is-small",
                                      loading: _vm.loading
                                    },
                                    on: {
                                      click: function($event) {
                                        return _vm.saveReminder(_vm.workflow.id)
                                      }
                                    }
                                  })
                                ],
                                1
                              )
                            ],
                            1
                          )
                        ])
                      ])
                    ]
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
                          return _vm.updateWorkflowstep(_vm.workflow.id)
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
                          return _vm.createWorkflowstep(_vm.workflow.id)
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
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "label",
      { staticClass: "custom-control-label", attrs: { for: "role_static" } },
      [
        _c("span", { staticClass: "text text-xs" }, [
          _vm._v("Profile(s) fixe :")
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
      { staticClass: "custom-control-label", attrs: { for: "role_dynamic" } },
      [
        _c("span", { staticClass: "text text-xs" }, [
          _vm._v("Profile Dynamique")
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
      { staticClass: "custom-control-label", attrs: { for: "role_previous" } },
      [
        _c("span", { staticClass: "text text-xs" }, [
          _vm._v("Profile Identique à l'Etape précédente")
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
      { staticClass: "custom-control-label", attrs: { for: "can_expire" } },
      [_c("span", { staticClass: "text text-xs" }, [_vm._v("Peux Expirer")])]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "input-group-append" }, [
      _c("span", { staticClass: "input-group-text" }, [_vm._v("hrs")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "input-group-append" }, [
      _c("span", { staticClass: "input-group-text" }, [_vm._v("jrs")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "label",
      {
        staticClass: "custom-control-label",
        attrs: { for: "notify_to_approvers" }
      },
      [
        _c("span", { staticClass: "text text-xs" }, [
          _vm._v("Notifier les Acteurs "),
          _c("i", { staticClass: "far fa-bell" })
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
        attrs: { for: "notify_to_others" }
      },
      [
        _c("span", { staticClass: "text text-xs" }, [
          _vm._v("Notifier d'Autres Utilisateurs "),
          _c("i", { staticClass: "far fa-bell" })
        ])
      ]
    )
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/workflowsteps/list.vue?vue&type=template&id=3b26d778&scoped=true&":
/*!****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/workflowsteps/list.vue?vue&type=template&id=3b26d778&scoped=true& ***!
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
    "section",
    [
      _c("p", [_vm._v("Les Etapes.")]),
      _vm._v(" "),
      _c(
        "b-field",
        { attrs: { grouped: "", "group-multiline": "" } },
        [
          _c(
            "b-select",
            {
              attrs: { disabled: !_vm.isPaginated },
              model: {
                value: _vm.perPage,
                callback: function($$v) {
                  _vm.perPage = $$v
                },
                expression: "perPage"
              }
            },
            [
              _c("option", { attrs: { value: "5" } }, [_vm._v("5 par page")]),
              _vm._v(" "),
              _c("option", { attrs: { value: "10" } }, [_vm._v("10 par page")]),
              _vm._v(" "),
              _c("option", { attrs: { value: "15" } }, [_vm._v("15 par page")]),
              _vm._v(" "),
              _c("option", { attrs: { value: "20" } }, [_vm._v("20 par page")])
            ]
          )
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "b-table",
        {
          ref: "table",
          attrs: {
            data: _vm.workflowsteps,
            "debounce-search": 1000,
            paginated: _vm.isPaginated,
            "per-page": _vm.perPage,
            "opened-detailed": _vm.defaultOpenedDetails,
            detailed: "",
            "detail-key": "id",
            "detail-transition": _vm.transitionName,
            "show-detail-icon": _vm.showDetailIcon,
            "current-page": _vm.currentPage,
            "pagination-simple": _vm.isPaginationSimple,
            "pagination-position": _vm.paginationPosition,
            "default-sort-direction": _vm.defaultSortDirection,
            "pagination-rounded": _vm.isPaginationRounded,
            "sort-icon": _vm.sortIcon,
            "sort-icon-size": _vm.sortIconSize,
            "sticky-header": _vm.stickyHeaders,
            "default-sort": "row.titre",
            "aria-next-label": "Suivant",
            "aria-previous-label": "Precedent",
            "aria-page-label": "Page",
            "aria-current-label": "Current page",
            "before-destroy": false
          },
          on: {
            "update:currentPage": function($event) {
              _vm.currentPage = $event
            },
            "update:current-page": function($event) {
              _vm.currentPage = $event
            }
          },
          scopedSlots: _vm._u([
            {
              key: "detail",
              fn: function(props) {
                return [
                  _c(
                    "b-field",
                    { attrs: { grouped: "", "group-multiline": "" } },
                    [
                      _c(
                        "div",
                        { staticClass: "form-inline float-left" },
                        [
                          _c(
                            "span",
                            { staticClass: "help-inline pr-1 text-sm" },
                            [_vm._v(" Action(s) de l'Etape ")]
                          ),
                          _vm._v(" "),
                          _c(
                            "b-button",
                            {
                              attrs: {
                                size: "is-small",
                                type: "is-info is-light"
                              },
                              on: {
                                click: function($event) {
                                  return _vm.createNewAction(props.row)
                                }
                              }
                            },
                            [_c("i", { staticClass: "fas fa-plus" })]
                          )
                        ],
                        1
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c("hr"),
                  _vm._v(" "),
                  _c("WorkflowActions", {
                    attrs: {
                      workflowstepid_prop: props.row.id,
                      workflowactions_prop: props.row.actions
                    }
                  })
                ]
              }
            },
            {
              key: "empty",
              fn: function() {
                return [
                  _c("div", { staticClass: "has-text-centered" }, [
                    _vm._v("Aucune Données")
                  ])
                ]
              },
              proxy: true
            }
          ])
        },
        [
          _vm._l(_vm.columns, function(column) {
            return [
              _c(
                "b-table-column",
                _vm._b(
                  {
                    key: column.id,
                    attrs: { sortable: column.sortable },
                    scopedSlots: _vm._u(
                      [
                        column.searchable && !column.numeric
                          ? {
                              key: "searchable",
                              fn: function(props) {
                                return [
                                  _c("b-input", {
                                    attrs: {
                                      placeholder: "Rech...",
                                      icon: "magnify",
                                      size: "is-small",
                                      "icon-right": "close-circle",
                                      "icon-right-clickable": ""
                                    },
                                    on: {
                                      "icon-right-click": function($event) {
                                        props.filters[props.column.field] = ""
                                      }
                                    },
                                    model: {
                                      value: props.filters[props.column.field],
                                      callback: function($$v) {
                                        _vm.$set(
                                          props.filters,
                                          props.column.field,
                                          $$v
                                        )
                                      },
                                      expression:
                                        "props.filters[props.column.field]"
                                    }
                                  })
                                ]
                              }
                            }
                          : null,
                        {
                          key: "default",
                          fn: function(props) {
                            return [
                              column.field === "id"
                                ? _c("span", { staticClass: "text-xs" }, [
                                    _vm._v(
                                      "\n                        " +
                                        _vm._s(props.row[column.field]) +
                                        "\n                    "
                                    )
                                  ])
                                : column.field === "titre"
                                ? _c(
                                    "span",
                                    {
                                      staticClass:
                                        "has-text-primary is-italic text-xs"
                                    },
                                    [
                                      _c(
                                        "a",
                                        {
                                          on: {
                                            click: function($event) {
                                              return _vm.editWorkflowstep(
                                                props.row
                                              )
                                            }
                                          }
                                        },
                                        [
                                          _vm._v(
                                            "\n                            " +
                                              _vm._s(props.row[column.field]) +
                                              "\n                        "
                                          )
                                        ]
                                      )
                                    ]
                                  )
                                : column.field === "stepparent"
                                ? _c(
                                    "span",
                                    {
                                      staticClass:
                                        "has-text-info is-italic text-xs"
                                    },
                                    [
                                      props.row[column.field]
                                        ? _c("span", [
                                            _vm._v(
                                              "\n                            " +
                                                _vm._s(
                                                  props.row[column.field].titre
                                                ) +
                                                "\n                        "
                                            )
                                          ])
                                        : _c("span")
                                    ]
                                  )
                                : column.date
                                ? _c(
                                    "span",
                                    { staticClass: "tag is-success" },
                                    [
                                      _vm._v(
                                        "\n                        " +
                                          _vm._s(
                                            new Date(
                                              props.row[column.field]
                                            ).toLocaleDateString()
                                          ) +
                                          "\n                    "
                                      )
                                    ]
                                  )
                                : column.field === "actions"
                                ? _c(
                                    "span",
                                    [
                                      _c(
                                        "b-taglist",
                                        [
                                          _c(
                                            "b-tag",
                                            {
                                              attrs: {
                                                type: "is-primary is-light"
                                              }
                                            },
                                            [
                                              _vm._v(
                                                _vm._s(
                                                  props.row.actionspass.length
                                                )
                                              )
                                            ]
                                          ),
                                          _vm._v(" "),
                                          _c(
                                            "b-tag",
                                            {
                                              attrs: {
                                                type: "is-danger is-light"
                                              }
                                            },
                                            [
                                              _vm._v(
                                                _vm._s(
                                                  props.row.actionsreject.length
                                                )
                                              )
                                            ]
                                          )
                                        ],
                                        1
                                      )
                                    ],
                                    1
                                  )
                                : _c("span", { staticClass: "text-xs" }, [
                                    _vm._v(
                                      "\n                        " +
                                        _vm._s(props.row[column.field]) +
                                        "\n                    "
                                    )
                                  ])
                            ]
                          }
                        }
                      ],
                      null,
                      true
                    )
                  },
                  "b-table-column",
                  column,
                  false
                )
              )
            ]
          })
        ],
        2
      ),
      _vm._v(" "),
      _c("AddUpdateAction")
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/views/workflowactions/actionBus.js":
/*!*********************************************************!*\
  !*** ./resources/js/views/workflowactions/actionBus.js ***!
  \*********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.common.js");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);

/* harmony default export */ __webpack_exports__["default"] = (new vue__WEBPACK_IMPORTED_MODULE_0___default.a());

/***/ }),

/***/ "./resources/js/views/workflows/item.vue":
/*!***********************************************!*\
  !*** ./resources/js/views/workflows/item.vue ***!
  \***********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _item_vue_vue_type_template_id_ccd1b126_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./item.vue?vue&type=template&id=ccd1b126&scoped=true& */ "./resources/js/views/workflows/item.vue?vue&type=template&id=ccd1b126&scoped=true&");
/* harmony import */ var _item_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./item.vue?vue&type=script&lang=js& */ "./resources/js/views/workflows/item.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _item_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _item_vue_vue_type_template_id_ccd1b126_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _item_vue_vue_type_template_id_ccd1b126_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "ccd1b126",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/workflows/item.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/workflows/item.vue?vue&type=script&lang=js&":
/*!************************************************************************!*\
  !*** ./resources/js/views/workflows/item.vue?vue&type=script&lang=js& ***!
  \************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./item.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/workflows/item.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/workflows/item.vue?vue&type=template&id=ccd1b126&scoped=true&":
/*!******************************************************************************************!*\
  !*** ./resources/js/views/workflows/item.vue?vue&type=template&id=ccd1b126&scoped=true& ***!
  \******************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_template_id_ccd1b126_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./item.vue?vue&type=template&id=ccd1b126&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/workflows/item.vue?vue&type=template&id=ccd1b126&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_template_id_ccd1b126_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_item_vue_vue_type_template_id_ccd1b126_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/views/workflowsteps/addupdate.vue":
/*!********************************************************!*\
  !*** ./resources/js/views/workflowsteps/addupdate.vue ***!
  \********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _addupdate_vue_vue_type_template_id_ff972a18_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./addupdate.vue?vue&type=template&id=ff972a18&scoped=true& */ "./resources/js/views/workflowsteps/addupdate.vue?vue&type=template&id=ff972a18&scoped=true&");
/* harmony import */ var _addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./addupdate.vue?vue&type=script&lang=js& */ "./resources/js/views/workflowsteps/addupdate.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var vue_multiselect_dist_vue_multiselect_min_css_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vue-multiselect/dist/vue-multiselect.min.css?vue&type=style&index=0&lang=css& */ "./node_modules/vue-multiselect/dist/vue-multiselect.min.css?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _addupdate_vue_vue_type_template_id_ff972a18_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _addupdate_vue_vue_type_template_id_ff972a18_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "ff972a18",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/workflowsteps/addupdate.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/workflowsteps/addupdate.vue?vue&type=script&lang=js&":
/*!*********************************************************************************!*\
  !*** ./resources/js/views/workflowsteps/addupdate.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./addupdate.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/workflowsteps/addupdate.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/workflowsteps/addupdate.vue?vue&type=template&id=ff972a18&scoped=true&":
/*!***************************************************************************************************!*\
  !*** ./resources/js/views/workflowsteps/addupdate.vue?vue&type=template&id=ff972a18&scoped=true& ***!
  \***************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_template_id_ff972a18_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./addupdate.vue?vue&type=template&id=ff972a18&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/workflowsteps/addupdate.vue?vue&type=template&id=ff972a18&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_template_id_ff972a18_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_addupdate_vue_vue_type_template_id_ff972a18_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/views/workflowsteps/list.vue":
/*!***************************************************!*\
  !*** ./resources/js/views/workflowsteps/list.vue ***!
  \***************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _list_vue_vue_type_template_id_3b26d778_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./list.vue?vue&type=template&id=3b26d778&scoped=true& */ "./resources/js/views/workflowsteps/list.vue?vue&type=template&id=3b26d778&scoped=true&");
/* harmony import */ var _list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./list.vue?vue&type=script&lang=js& */ "./resources/js/views/workflowsteps/list.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _list_vue_vue_type_template_id_3b26d778_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _list_vue_vue_type_template_id_3b26d778_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "3b26d778",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/workflowsteps/list.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/workflowsteps/list.vue?vue&type=script&lang=js&":
/*!****************************************************************************!*\
  !*** ./resources/js/views/workflowsteps/list.vue?vue&type=script&lang=js& ***!
  \****************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./list.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/workflowsteps/list.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/workflowsteps/list.vue?vue&type=template&id=3b26d778&scoped=true&":
/*!**********************************************************************************************!*\
  !*** ./resources/js/views/workflowsteps/list.vue?vue&type=template&id=3b26d778&scoped=true& ***!
  \**********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_template_id_3b26d778_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./list.vue?vue&type=template&id=3b26d778&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/workflowsteps/list.vue?vue&type=template&id=3b26d778&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_template_id_3b26d778_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_list_vue_vue_type_template_id_3b26d778_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/views/workflowsteps/stepBus.js":
/*!*****************************************************!*\
  !*** ./resources/js/views/workflowsteps/stepBus.js ***!
  \*****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.common.js");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);

/* harmony default export */ __webpack_exports__["default"] = (new vue__WEBPACK_IMPORTED_MODULE_0___default.a());

/***/ })

}]);