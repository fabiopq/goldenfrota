/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 6);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/EstoqueProdutoComponent.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/EstoqueProdutoComponent.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _modal_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./modal.vue */ "./resources/js/components/modal.vue");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  name: 'estoque_produto',
  components: {
    modal: _modal_vue__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  data: function data() {
    return {
      editing: false,
      editingIndex: false,
      estoque_id: false,
      estoque_minimo: 0,
      estoques: [],
      isModalVisible: false,
      deleteIndex: false,
      estoquesDisponiveis: [],
      estoquesSelecionados: [],
      errors: {
        inputEstoques: false,
        inputEstoquesMsg: '',
        inputEstoqueMinimo: false,
        inputEstoqueMinimoMsg: ''
      }
    };
  },
  props: ['estoquesData', 'oldData'],
  watch: {
    oldData: function oldData() {
      this.$refs.confirmDelete;
    }
  },
  computed: {
    estoquesDisponiveisOrdenados: function estoquesDisponiveisOrdenados() {
      function compare(a, b) {
        if (a.estoque < b.estoque) return -1;
        if (a.estoque > b.estoque) return 1;
        return 0;
      }

      return this.estoquesDisponiveis.sort(compare);
    }
  },
  mounted: function mounted() {
    this.estoquesDisponiveis = this.estoquesData;

    if (this.oldData !== null) {
      for (var i = 0; i < this.oldData.length; i++) {
        this.estoques.push({
          'id': this.oldData[i].estoque_id,
          'estoque': this.getEstoqueById(this.oldData[i].estoque_id).estoque,
          'estoque_minimo': Number(this.oldData[i].estoque_minimo)
        });
        this.incluirEstoque(this.oldData[i].estoque_id);
      }
    }
  },
  updated: function updated() {
    $(this.$refs.inputEstoques).selectpicker('refresh');
  },
  methods: {
    validarItem: function validarItem() {
      if (this.estoque_id == '' || this.estoque_id <= 0) {
        this.errors.inputEstoques = true;
        this.errors.inputEstoquesMsg = 'Nenhum Estoque selecionado.';
        return false;
      } else {
        this.errors.inputEstoques = false;
        this.errors.inputEstoquesMsg = '';
      }

      if (Number(this.estoque_minimo) < 0) {
        this.errors.inputEstoqueMinimo = true;
        this.errors.inputEstoqueMinimoMsg = 'Informe o estoque mínimo do produto.';
        return false;
      } else {
        this.errors.inputEstoqueMinimo = false;
        this.errors.inputEstoqueMinimoMsg = '';
      }

      return true;
    },
    confirmDelete: function confirmDelete(index) {
      this.deleteIndex = index;
    },
    cancelDelete: function cancelDelete(index) {
      this.deleteIndex = false;
    },
    addEstoque: function addEstoque() {
      if (this.validarItem()) {
        this.estoques.push({
          'id': this.estoque_id,
          'estoque': this.getEstoqueById(this.estoque_id).estoque,
          'estoque_minimo': this.estoque_minimo
        });
        this.incluirEstoque(this.estoque_id);
        this.limparFormulario();
      }
    },
    editItem: function editItem(index) {
      var item = this.estoques[index];
      this.estoquesDisponiveis.push(this.getEstoqueSelecionadoById(item.id));
      this.estoque_minimo = item.estoque_minimo;
      this.estoque_id = item.id;
      this.editing = true;
      this.editingIndex = index;
    },
    updateEstoque: function updateEstoque() {
      this.estoques[this.editingIndex] = {
        'id': this.estoque_id,
        'estoque': this.getEstoqueById(this.estoque_id).estoque,
        'estoque_minimo': this.estoque_minimo
      };
      this.editing = false;
      this.editingIndex = false;
      this.incluirEstoque(this.estoque_id);
      this.limparFormulario();
    },
    deleteItem: function deleteItem() {
      this.removerEstoque(this.estoques[this.deleteIndex].id);
      this.$delete(this.estoques, this.deleteIndex);
    },
    limparFormulario: function limparFormulario() {
      this.produtoSelecionado = false;
      this.estoque_minimo = '';
      this.$refs.inputEstoques.focus();
    },
    getEstoqueById: function getEstoqueById(id) {
      var result = 0;

      for (var i = 0; i < this.estoquesData.length; i++) {
        if (this.estoquesData[i].id == id) {
          result = this.estoquesData[i];
          break;
        }
      }

      return result;
    },
    getEstoqueIndexById: function getEstoqueIndexById(id) {
      var result = 0;

      for (var i = 0; i < this.estoquesData.length; i++) {
        if (this.estoquesData[i].id == id) {
          result = i;
          break;
        }
      }

      return result;
    },
    getEstoqueSelecionadoById: function getEstoqueSelecionadoById(id) {
      var result = 0;

      for (var i = 0; i < this.estoquesSelecionados.length; i++) {
        if (this.estoquesSelecionados[i].id == id) {
          result = this.estoquesSelecionados[i];
          break;
        }
      }

      return result;
    },
    getEstoqueSelecionadoIndexById: function getEstoqueSelecionadoIndexById(id) {
      var result = 0;

      for (var i = 0; i < this.estoquesSelecionados.length; i++) {
        if (this.estoquesSelecionados[i].id == id) {
          result = i;
          break;
        }
      }

      return result;
    },
    incluirEstoque: function incluirEstoque(id) {
      this.estoquesSelecionados.push(this.getEstoqueById(id));
      this.$delete(this.estoquesDisponiveis, this.getEstoqueIndexById(id));
    },
    removerEstoque: function removerEstoque(id) {
      this.estoquesDisponiveis.push(this.getEstoqueSelecionadoById(id));
      this.$delete(this.estoquesSelecionados, this.getEstoqueSelecionadoIndexById(id));
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/modal.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/modal.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  name: 'modal',
  methods: {
    cancel: function cancel() {
      this.$emit(this._eventCancel);
    },
    confirm: function confirm() {
      this.$emit(this._eventConfirm);
    }
  },
  props: ['modalTitle', 'modalText', 'eventCancel', 'eventConfirm'],
  computed: {
    _eventCancel: {
      get: function get() {
        if (this.eventCancel == undefined) {
          return 'cancel';
        } else {
          return this.eventCancel;
        }
      }
    },
    _eventConfirm: {
      get: function get() {
        if (this.eventConfirm == undefined) {
          return 'confirm';
        } else {
          return this.eventConfirm;
        }
      }
    }
  },
  mounted: function mounted() {//
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/EstoqueProdutoComponent.vue?vue&type=template&id=8df763fe&":
/*!**************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/EstoqueProdutoComponent.vue?vue&type=template&id=8df763fe& ***!
  \**************************************************************************************************************************************************************************************************************************/
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
    { staticClass: "card d-block" },
    [
      _vm._m(0),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "card-body", staticStyle: { padding: "0 !important" } },
        [
          _c(
            "table",
            {
              staticClass:
                "table table-sm table-striped table-bordered table-hover",
              staticStyle: { "margin-bottom": "0 !important" }
            },
            [
              _vm._m(1),
              _vm._v(" "),
              _c(
                "transition-group",
                { tag: "tbody", attrs: { name: "fade" } },
                _vm._l(_vm.estoques, function(item, index) {
                  return _c("tr", { key: index, staticClass: "row m-0" }, [
                    _c("td", { staticClass: "col-md-1 pool-right" }, [
                      _vm._v(
                        "\n                        " +
                          _vm._s(item.id) +
                          "\n                        "
                      ),
                      _c("input", {
                        attrs: {
                          type: "hidden",
                          name: "estoques[" + index + "][estoque_id]"
                        },
                        domProps: { value: item.id }
                      })
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "col-md-7" }, [
                      _vm._v(
                        "\n                        " +
                          _vm._s(item.estoque) +
                          "\n                    "
                      )
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "col-md-2 text-right" }, [
                      _vm._v(
                        "\n                        " +
                          _vm._s(item.estoque_minimo) +
                          "\n                        "
                      ),
                      _c("input", {
                        attrs: {
                          type: "hidden",
                          name: "estoques[" + index + "][estoque_minimo]"
                        },
                        domProps: { value: item.estoque_minimo }
                      })
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "col-md-2" }, [
                      _c(
                        "button",
                        {
                          directives: [
                            {
                              name: "show",
                              rawName: "v-show",
                              value: !_vm.editing,
                              expression: "!editing"
                            }
                          ],
                          staticClass: "btn btn-sm btn-warning",
                          attrs: { type: "button" },
                          on: {
                            click: function($event) {
                              return _vm.editItem(index)
                            }
                          }
                        },
                        [_c("i", { staticClass: "fas fa-edit" })]
                      ),
                      _vm._v(" "),
                      _c(
                        "button",
                        {
                          directives: [
                            {
                              name: "show",
                              rawName: "v-show",
                              value: !_vm.editing,
                              expression: "!editing"
                            }
                          ],
                          staticClass: "btn btn-sm btn-danger",
                          attrs: {
                            type: "button",
                            "data-toggle": "modal",
                            "data-target": "#confirmDelete"
                          },
                          on: {
                            click: function($event) {
                              return _vm.confirmDelete(index)
                            }
                          }
                        },
                        [_c("i", { staticClass: "fas fa-trash-alt" })]
                      )
                    ])
                  ])
                }),
                0
              )
            ],
            1
          )
        ]
      ),
      _vm._v(" "),
      _c("div", [
        _c("div", { staticClass: "row m-0" }, [
          _c(
            "div",
            {
              class: {
                "col-md-8": true,
                " has-error": this.errors.inputEstoques
              },
              staticStyle: {
                "padding-right": "0 !important",
                "padding-left": "0 !important"
              }
            },
            [
              _c(
                "select",
                {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.estoque_id,
                      expression: "estoque_id"
                    }
                  ],
                  ref: "inputEstoques",
                  staticClass: "form-control selectpicker",
                  attrs: {
                    "data-live-search": "true",
                    name: "inputEstoques",
                    id: "inputEstoques"
                  },
                  on: {
                    change: function($event) {
                      var $$selectedVal = Array.prototype.filter
                        .call($event.target.options, function(o) {
                          return o.selected
                        })
                        .map(function(o) {
                          var val = "_value" in o ? o._value : o.value
                          return val
                        })
                      _vm.estoque_id = $event.target.multiple
                        ? $$selectedVal
                        : $$selectedVal[0]
                    }
                  }
                },
                [
                  _c("option", { attrs: { selected: "", value: "false" } }, [
                    _vm._v(" Nada Selecionado ")
                  ]),
                  _vm._v(" "),
                  _vm._l(_vm.estoquesDisponiveisOrdenados, function(
                    estoque,
                    index
                  ) {
                    return _c(
                      "option",
                      { key: index, domProps: { value: estoque.id } },
                      [_vm._v(_vm._s(estoque.estoque))]
                    )
                  })
                ],
                2
              ),
              _vm._v(" "),
              _c(
                "span",
                {
                  staticClass: "help-block",
                  attrs: { "v-if": this.errors.inputEstoques }
                },
                [_c("strong", [_vm._v(_vm._s(this.errors.inputEstoquesMsg))])]
              )
            ]
          ),
          _vm._v(" "),
          _c(
            "div",
            {
              class: {
                "col-md-2": true,
                " has-error": this.errors.inputEstoqueMinimo
              },
              staticStyle: {
                "padding-right": "0 !important",
                "padding-left": "0 !important"
              }
            },
            [
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model.number",
                    value: _vm.estoque_minimo,
                    expression: "estoque_minimo",
                    modifiers: { number: true }
                  }
                ],
                ref: "inputEstoqueMinimo",
                staticClass: "form-control",
                attrs: {
                  type: "number",
                  min: "0,000",
                  max: "9999999999,999",
                  step: "any",
                  name: "inputEstoqueMinimo",
                  id: "inputEstoqueMinimo"
                },
                domProps: { value: _vm.estoque_minimo },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.estoque_minimo = _vm._n($event.target.value)
                  },
                  blur: function($event) {
                    return _vm.$forceUpdate()
                  }
                }
              }),
              _vm._v(" "),
              _c(
                "span",
                {
                  staticClass: "help-block",
                  attrs: { "v-if": this.errors.inputEstoqueMinimo }
                },
                [
                  _c("strong", [
                    _vm._v(_vm._s(this.errors.inputEstoqueMinimoMsg))
                  ])
                ]
              )
            ]
          ),
          _vm._v(" "),
          _c("div", { staticClass: "col-md-2" }, [
            _c(
              "button",
              {
                directives: [
                  {
                    name: "show",
                    rawName: "v-show",
                    value: !_vm.editing,
                    expression: "!editing"
                  }
                ],
                staticClass: "btn btn-success",
                attrs: { type: "button" },
                on: { click: _vm.addEstoque }
              },
              [_c("i", { staticClass: "fas fa-check" })]
            ),
            _vm._v(" "),
            _c(
              "button",
              {
                directives: [
                  {
                    name: "show",
                    rawName: "v-show",
                    value: _vm.editing,
                    expression: "editing"
                  }
                ],
                staticClass: "btn btn-success",
                attrs: { type: "button" },
                on: { click: _vm.updateEstoque }
              },
              [_c("i", { staticClass: "fas fa-check" })]
            )
          ])
        ])
      ]),
      _vm._v(" "),
      _c("modal", {
        attrs: {
          "modal-title": "Corfirmação",
          "modal-text": "Confirma a remoção deste Item?"
        },
        on: { cancel: _vm.cancelDelete, confirm: _vm.deleteItem }
      })
    ],
    1
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "card-header" }, [
      _c("strong", [_vm._v("Estoques")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", { staticClass: "thead-light" }, [
      _c("tr", { staticClass: "row m-0" }, [
        _c("th", { staticClass: "col-md-1" }, [_vm._v("Id")]),
        _vm._v(" "),
        _c("th", { staticClass: "col-md-7" }, [_vm._v("Estoque")]),
        _vm._v(" "),
        _c("th", { staticClass: "col-md-2" }, [_vm._v("Est. Mínimo")]),
        _vm._v(" "),
        _c("th", { staticClass: "col-md-2" }, [_vm._v("Ações")])
      ])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/modal.vue?vue&type=template&id=478d961c&":
/*!********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/modal.vue?vue&type=template&id=478d961c& ***!
  \********************************************************************************************************************************************************************************************************/
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
  return _c("transition", { attrs: { name: "modal-fade" } }, [
    _c(
      "div",
      {
        staticClass: "modal fade",
        attrs: {
          id: "confirmDelete",
          role: "dialog",
          "aria-labelledby": "confirmDeleteLabel",
          "aria-hidden": "true"
        }
      },
      [
        _c("div", { staticClass: "modal-dialog" }, [
          _c("div", { staticClass: "modal-content" }, [
            _c("div", { staticClass: "modal-header" }, [
              _c("h4", { staticClass: "modal-title" }, [
                _c("strong", [_vm._v(_vm._s(this.modalTitle))])
              ]),
              _vm._v(" "),
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
                [
                  _c("span", { attrs: { "aria-hidden": "true" } }, [
                    _vm._v("×")
                  ])
                ]
              )
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "modal-body" }, [
              _c("p", [
                _vm._v(
                  "\n              " +
                    _vm._s(this.modalText) +
                    "                  \n            "
                )
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "modal-footer" }, [
              _c(
                "button",
                {
                  staticClass: "btn btn-danger",
                  attrs: {
                    type: "button",
                    "data-dismiss": "modal",
                    id: "confirm"
                  },
                  on: { click: _vm.confirm }
                },
                [_vm._v("Remover")]
              ),
              _vm._v(" "),
              _c(
                "button",
                {
                  staticClass: "btn btn-primary",
                  attrs: { type: "button", "data-dismiss": "modal" },
                  on: { click: _vm.cancel }
                },
                [_vm._v("Cancelar")]
              )
            ])
          ])
        ])
      ]
    )
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js":
/*!********************************************************************!*\
  !*** ./node_modules/vue-loader/lib/runtime/componentNormalizer.js ***!
  \********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return normalizeComponent; });
/* globals __VUE_SSR_CONTEXT__ */

// IMPORTANT: Do NOT use ES2015 features in this file (except for modules).
// This module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle.

function normalizeComponent (
  scriptExports,
  render,
  staticRenderFns,
  functionalTemplate,
  injectStyles,
  scopeId,
  moduleIdentifier, /* server only */
  shadowMode /* vue-cli only */
) {
  // Vue.extend constructor export interop
  var options = typeof scriptExports === 'function'
    ? scriptExports.options
    : scriptExports

  // render functions
  if (render) {
    options.render = render
    options.staticRenderFns = staticRenderFns
    options._compiled = true
  }

  // functional template
  if (functionalTemplate) {
    options.functional = true
  }

  // scopedId
  if (scopeId) {
    options._scopeId = 'data-v-' + scopeId
  }

  var hook
  if (moduleIdentifier) { // server build
    hook = function (context) {
      // 2.3 injection
      context =
        context || // cached call
        (this.$vnode && this.$vnode.ssrContext) || // stateful
        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional
      // 2.2 with runInNewContext: true
      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
        context = __VUE_SSR_CONTEXT__
      }
      // inject component styles
      if (injectStyles) {
        injectStyles.call(this, context)
      }
      // register component module identifier for async chunk inferrence
      if (context && context._registeredComponents) {
        context._registeredComponents.add(moduleIdentifier)
      }
    }
    // used by ssr in case component is cached and beforeCreate
    // never gets called
    options._ssrRegister = hook
  } else if (injectStyles) {
    hook = shadowMode
      ? function () { injectStyles.call(this, this.$root.$options.shadowRoot) }
      : injectStyles
  }

  if (hook) {
    if (options.functional) {
      // for template-only hot-reload because in that case the render fn doesn't
      // go through the normalizer
      options._injectStyles = hook
      // register for functioal component in vue file
      var originalRender = options.render
      options.render = function renderWithStyleInjection (h, context) {
        hook.call(context)
        return originalRender(h, context)
      }
    } else {
      // inject component registration as beforeCreate hook
      var existing = options.beforeCreate
      options.beforeCreate = existing
        ? [].concat(existing, hook)
        : [hook]
    }
  }

  return {
    exports: scriptExports,
    options: options
  }
}


/***/ }),

/***/ "./resources/js/components/EstoqueProdutoComponent.vue":
/*!*************************************************************!*\
  !*** ./resources/js/components/EstoqueProdutoComponent.vue ***!
  \*************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _EstoqueProdutoComponent_vue_vue_type_template_id_8df763fe___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./EstoqueProdutoComponent.vue?vue&type=template&id=8df763fe& */ "./resources/js/components/EstoqueProdutoComponent.vue?vue&type=template&id=8df763fe&");
/* harmony import */ var _EstoqueProdutoComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./EstoqueProdutoComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/EstoqueProdutoComponent.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _EstoqueProdutoComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _EstoqueProdutoComponent_vue_vue_type_template_id_8df763fe___WEBPACK_IMPORTED_MODULE_0__["render"],
  _EstoqueProdutoComponent_vue_vue_type_template_id_8df763fe___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/EstoqueProdutoComponent.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/EstoqueProdutoComponent.vue?vue&type=script&lang=js&":
/*!**************************************************************************************!*\
  !*** ./resources/js/components/EstoqueProdutoComponent.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_EstoqueProdutoComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./EstoqueProdutoComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/EstoqueProdutoComponent.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_EstoqueProdutoComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/EstoqueProdutoComponent.vue?vue&type=template&id=8df763fe&":
/*!********************************************************************************************!*\
  !*** ./resources/js/components/EstoqueProdutoComponent.vue?vue&type=template&id=8df763fe& ***!
  \********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EstoqueProdutoComponent_vue_vue_type_template_id_8df763fe___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./EstoqueProdutoComponent.vue?vue&type=template&id=8df763fe& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/EstoqueProdutoComponent.vue?vue&type=template&id=8df763fe&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EstoqueProdutoComponent_vue_vue_type_template_id_8df763fe___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EstoqueProdutoComponent_vue_vue_type_template_id_8df763fe___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/modal.vue":
/*!*******************************************!*\
  !*** ./resources/js/components/modal.vue ***!
  \*******************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _modal_vue_vue_type_template_id_478d961c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./modal.vue?vue&type=template&id=478d961c& */ "./resources/js/components/modal.vue?vue&type=template&id=478d961c&");
/* harmony import */ var _modal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./modal.vue?vue&type=script&lang=js& */ "./resources/js/components/modal.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _modal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _modal_vue_vue_type_template_id_478d961c___WEBPACK_IMPORTED_MODULE_0__["render"],
  _modal_vue_vue_type_template_id_478d961c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/modal.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/modal.vue?vue&type=script&lang=js&":
/*!********************************************************************!*\
  !*** ./resources/js/components/modal.vue?vue&type=script&lang=js& ***!
  \********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_modal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./modal.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/modal.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_modal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/modal.vue?vue&type=template&id=478d961c&":
/*!**************************************************************************!*\
  !*** ./resources/js/components/modal.vue?vue&type=template&id=478d961c& ***!
  \**************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_modal_vue_vue_type_template_id_478d961c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./modal.vue?vue&type=template&id=478d961c& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/modal.vue?vue&type=template&id=478d961c&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_modal_vue_vue_type_template_id_478d961c___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_modal_vue_vue_type_template_id_478d961c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/estoqueproduto.js":
/*!****************************************!*\
  !*** ./resources/js/estoqueproduto.js ***!
  \****************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _components_EstoqueProdutoComponent_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./components/EstoqueProdutoComponent.vue */ "./resources/js/components/EstoqueProdutoComponent.vue");

new Vue({
  el: '#estoque-produto-component',
  components: {
    'estoque-produto': _components_EstoqueProdutoComponent_vue__WEBPACK_IMPORTED_MODULE_0__["default"]
  }
});

/***/ }),

/***/ 6:
/*!**********************************************!*\
  !*** multi ./resources/js/estoqueproduto.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\wamp\www\goldenfrota\resources\js\estoqueproduto.js */"./resources/js/estoqueproduto.js");


/***/ })

/******/ });