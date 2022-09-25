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
/******/ 	return __webpack_require__(__webpack_require__.s = 3);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/EntradaTanqueItemsComponent.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/EntradaTanqueItemsComponent.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************************/
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
//
//
//
//
//
//
//
//
//
//
//
//
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
  name: 'entrada_tanque',
  components: {
    modal: _modal_vue__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  data: function data() {
    return {
      editing: false,
      editingIndex: false,
      items: [],
      tanque_id: false,
      quantidade: 1,
      valorUnitario: 0,
      isModalVisible: false,
      deleteIndex: false,
      tanquesDisponiveis: [],
      tanquesSelecionados: [],
      errors: {
        inputTanques: false,
        inputTanquesMsg: '',
        inputQuantidade: false,
        inputQuantidadeMsg: '',
        inputValorUnitario: false,
        inputValorUnitariodeMsg: ''
      }
    };
  },
  props: ['tanquesData', 'oldData'],
  watch: {
    oldData: function oldData() {
      this.$refs.confirmDelete;
    }
  },
  computed: {
    tanquesDisponiveisOrdenados: function tanquesDisponiveisOrdenados() {
      function compare(a, b) {
        if (a.tanque < b.tanque) return -1;
        if (a.tanque > b.tanque) return 1;
        return 0;
      }

      return this.tanquesDisponiveis.sort(compare);
    },
    valor_total: {
      get: function get() {
        var total = 0;

        for (var i = 0; i < this.items.length; i++) {
          total += this.items[i].quantidade * this.items[i].valor_unitario;
        }

        return total;
      }
    }
  },
  mounted: function mounted() {
    this.tanquesDisponiveis = this.tanquesData;

    if (this.oldData !== null) {
      for (var i = 0; i < this.oldData.length; i++) {
        this.items.push({
          'id': this.oldData[i].tanque_id,
          'tanque': this.getTanqueById(this.oldData[i].tanque_id).tanque,
          'quantidade': Number(this.oldData[i].quantidade),
          'valor_unitario': Number(this.oldData[i].valor_unitario)
        });
        this.incluirEntrada(this.oldData[i].tanque_id);
      }
    }
  },
  updated: function updated() {
    $(this.$refs.inputTanques).selectpicker('refresh');
  },
  methods: {
    validarItem: function validarItem() {
      if (this.tanque_id == '' || this.tanque_id <= 0) {
        this.errors.inputTanques = true;
        this.errors.inputTanquesMsg = 'Nenhum Tanque selecionado.';
        return false;
      } else {
        this.errors.inputTanques = false;
        this.errors.inputTanquesMsg = '';
      }

      if (this.quantidade == '' || this.quantidade <= 0) {
        this.errors.inputQuantidade = true;
        this.errors.inputQuantidadeMsg = 'Informe a quantidade.';
        return false;
      } else {
        this.errors.inputQuantidade = false;
        this.errors.inputQuantidadeMsg = '';
      }

      if (this.valorUnitario == '' || this.valorUnitario <= 0) {
        this.errors.inputValorUnitario = true;
        this.errors.inputValorUnitarioMsg = 'Informe o Valor Unitário.';
        return false;
      } else {
        this.errors.inputValorUnitario = false;
        this.errors.inputValorUnitarioMsg = '';
      }

      return true;
    },
    confirmDelete: function confirmDelete(index) {
      this.deleteIndex = index;
    },
    cancelDelete: function cancelDelete(index) {
      this.deleteIndex = false;
    },
    addEntrada: function addEntrada() {
      if (this.validarItem()) {
        this.items.push({
          'id': this.tanque_id,
          'tanque': this.getTanqueById(this.tanque_id).tanque,
          'quantidade': this.quantidade,
          'valor_unitario': this.valorUnitario,
          'valor_desconto': this.desconto,
          'valor_acrescimo': this.acrescimo
        });
        this.incluirEntrada(this.tanque_id);
        this.limparFormulario();
      }
    },
    editItem: function editItem(index) {
      var item = this.items[index];
      this.quantidade = item.quantidade;
      this.valorUnitario = item.valor_unitario;
      this.tanque_id = item.id;
      this.editing = true;
      this.editingIndex = index;
      this.tanquesDisponiveis.push(item);
    },
    updateEntrada: function updateEntrada() {
      this.items[this.editingIndex] = {
        'id': this.tanque_id,
        'tanque': this.getTanqueById(this.tanque_id).tanque,
        'quantidade': this.quantidade,
        'valor_unitario': this.valorUnitario
      };
      this.editing = false;
      this.editingIndex = false;
      this.limparFormulario();
      this.$delete(this.tanquesDisponiveis, this.getTanqueIndexById(this.tanque_id));
    },
    deleteItem: function deleteItem() {
      this.removerEntrada(this.items[this.deleteIndex].id);
      this.$delete(this.items, this.deleteIndex);
    },
    limparFormulario: function limparFormulario() {
      this.produtoSelecionado = false;
      this.quantidade = 1;
      this.valorUnitario = 0;
      this.desconto = 0;
      this.acrescimo = 0;
      this.$refs.inputTanques.focus();
    },
    totalQuantidade: function totalQuantidade() {
      var result = 0;

      for (var i = 0; i < this.items.length; i++) {
        result += this.items[i].quantidade;
      }

      return result;
    },
    totalValor: function totalValor() {
      var result = 0;

      for (var i = 0; i < this.items.length; i++) {
        result += this.items[i].valor_unitario;
      }

      return result;
    },
    totalDesconto: function totalDesconto() {
      var result = 0;

      for (var i = 0; i < this.items.length; i++) {
        result += this.items[i].valor_desconto;
      }

      return result;
    },
    totalAcrescimo: function totalAcrescimo() {
      var result = 0;

      for (var i = 0; i < this.items.length; i++) {
        result += this.items[i].valor_acrescimo;
      }

      return result;
    },
    getTanqueById: function getTanqueById(id) {
      var result = 0;

      for (var i = 0; i < this.tanquesData.length; i++) {
        if (this.tanquesData[i].id == id) {
          result = this.tanquesData[i];
          break;
        }
      }

      return result;
    },
    getTanqueIndexById: function getTanqueIndexById(id) {
      var result = 0;

      for (var i = 0; i < this.tanquesData.length; i++) {
        if (this.tanquesData[i].id == id) {
          result = i;
          break;
        }
      }

      return result;
    },
    getTanqueSelecionadoById: function getTanqueSelecionadoById(id) {
      var result = 0;

      for (var i = 0; i < this.tanquesSelecionados.length; i++) {
        if (this.tanquesSelecionados[i].id == id) {
          result = this.tanquesSelecionados[i];
          break;
        }
      }

      return result;
    },
    getTanqueSelecionadoIndexById: function getTanqueSelecionadoIndexById(id) {
      var result = 0;

      for (var i = 0; i < this.tanquesSelecionados.length; i++) {
        if (this.tanquesSelecionados[i].id == id) {
          result = i;
          break;
        }
      }

      return result;
    },
    incluirEntrada: function incluirEntrada(id) {
      this.tanquesSelecionados.push(this.getTanqueById(id));
      this.$delete(this.tanquesDisponiveis, this.getTanqueIndexById(id));
    },
    removerEntrada: function removerEntrada(id) {
      this.tanquesDisponiveis.push(this.getTanqueSelecionadoById(id));
      this.$delete(this.tanquesSelecionados, this.getTanqueSelecionadoIndexById(id));
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/EntradaTanqueItemsComponent.vue?vue&type=template&id=35575099&":
/*!******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/EntradaTanqueItemsComponent.vue?vue&type=template&id=35575099& ***!
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
  return _c(
    "div",
    { staticClass: "card" },
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
                _vm._l(_vm.items, function(item, index) {
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
                          name: "items[" + index + "][tanque_id]"
                        },
                        domProps: { value: item.id }
                      })
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "col-md-5" }, [
                      _vm._v(
                        "\n                        " +
                          _vm._s(item.tanque) +
                          "\n                    "
                      )
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "col-md-2 text-right" }, [
                      _vm._v(
                        "\n                        " +
                          _vm._s(item.quantidade) +
                          "\n                        "
                      ),
                      _c("input", {
                        attrs: {
                          type: "hidden",
                          name: "items[" + index + "][quantidade]"
                        },
                        domProps: { value: item.quantidade }
                      })
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "col-md-2 text-right" }, [
                      _vm._v(
                        "\n                        " +
                          _vm._s(item.valor_unitario) +
                          "\n                        "
                      ),
                      _c("input", {
                        attrs: {
                          type: "hidden",
                          name: "items[" + index + "][valor_unitario]"
                        },
                        domProps: { value: item.valor_unitario }
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
              ),
              _vm._v(" "),
              this.items.length > 0
                ? _c("tfoot", [
                    _c("tr", { staticClass: "row m-0" }, [
                      _c("td", { staticClass: "col-md-1" }, [
                        _c("strong", [_vm._v(_vm._s(this.items.length))])
                      ]),
                      _vm._v(" "),
                      _c("td", { staticClass: "col-md-5" }),
                      _vm._v(" "),
                      _c("td", { staticClass: "col-md-2 text-right" }, [
                        _c("strong", [_vm._v(_vm._s(this.totalQuantidade()))])
                      ]),
                      _vm._v(" "),
                      _c("td", { staticClass: "col-md-2 text-right" }, [
                        _c("strong", [_vm._v(_vm._s(this.totalValor()))])
                      ]),
                      _vm._v(" "),
                      _c("td", { staticClass: "col-md-2" })
                    ])
                  ])
                : _vm._e()
            ],
            1
          )
        ]
      ),
      _vm._v(" "),
      _c("div", { staticClass: "panel-footer" }, [
        _c("div", { staticClass: "row m-0" }, [
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.valor_total,
                expression: "valor_total"
              }
            ],
            attrs: { type: "hidden", name: "valor_total" },
            domProps: { value: _vm.valor_total },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.valor_total = $event.target.value
              }
            }
          }),
          _vm._v(" "),
          _c(
            "div",
            {
              class: {
                "col-md-6": true,
                " has-error": this.errors.inputTanques
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
                      value: _vm.tanque_id,
                      expression: "tanque_id"
                    }
                  ],
                  ref: "inputTanques",
                  staticClass: "form-control selectpicker",
                  attrs: {
                    "data-style": "btn-secondary",
                    "data-live-search": "true",
                    name: "inputTanques",
                    id: "inputTanques"
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
                      _vm.tanque_id = $event.target.multiple
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
                  _vm._l(_vm.tanquesDisponiveisOrdenados, function(
                    tanque,
                    index
                  ) {
                    return _c(
                      "option",
                      { key: index, domProps: { value: tanque.id } },
                      [_vm._v(_vm._s(tanque.id + " - " + tanque.tanque))]
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
                  attrs: { "v-if": this.errors.inputTanques }
                },
                [_c("strong", [_vm._v(_vm._s(this.errors.inputTanquesMsg))])]
              )
            ]
          ),
          _vm._v(" "),
          _c(
            "div",
            {
              class: {
                "col-md-2": true,
                " has-error": this.errors.inputQuantidade
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
                    value: _vm.quantidade,
                    expression: "quantidade",
                    modifiers: { number: true }
                  }
                ],
                ref: "inputQuantidade",
                staticClass: "form-control",
                attrs: {
                  type: "number",
                  min: "0,000",
                  max: "9999999999,999",
                  step: "any",
                  name: "inputQuantidade",
                  id: "inputQuantidade"
                },
                domProps: { value: _vm.quantidade },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.quantidade = _vm._n($event.target.value)
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
                  attrs: { "v-if": this.errors.inputQuantidade }
                },
                [_c("strong", [_vm._v(_vm._s(this.errors.inputQuantidadeMsg))])]
              )
            ]
          ),
          _vm._v(" "),
          _c(
            "div",
            {
              class: {
                "col-md-2": true,
                " has-error": this.errors.inputValorUnitario
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
                    value: _vm.valorUnitario,
                    expression: "valorUnitario",
                    modifiers: { number: true }
                  }
                ],
                ref: "inputValorUnitario",
                staticClass: "form-control",
                attrs: {
                  type: "number",
                  min: "0,000",
                  max: "9999999999,999",
                  step: "any",
                  name: "inputValorUnitario",
                  id: "inputValorUnitario"
                },
                domProps: { value: _vm.valorUnitario },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.valorUnitario = _vm._n($event.target.value)
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
                  attrs: { "v-if": this.errors.inputValorUnitario }
                },
                [
                  _c("strong", [
                    _vm._v(_vm._s(this.errors.inputValorUnitarioMsg))
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
                on: { click: _vm.addEntrada }
              },
              [_c("i", { staticClass: "fas fa-plus" })]
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
                on: { click: _vm.updateEntrada }
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
      _c("strong", [_vm._v("Combustíveis")])
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
        _c("th", { staticClass: "col-md-5" }, [_vm._v("Tanque")]),
        _vm._v(" "),
        _c("th", { staticClass: "col-md-2" }, [_vm._v("Qtd")]),
        _vm._v(" "),
        _c("th", { staticClass: "col-md-2" }, [_vm._v("Vlr. Un.")]),
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

/***/ "./resources/js/components/EntradaTanqueItemsComponent.vue":
/*!*****************************************************************!*\
  !*** ./resources/js/components/EntradaTanqueItemsComponent.vue ***!
  \*****************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _EntradaTanqueItemsComponent_vue_vue_type_template_id_35575099___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./EntradaTanqueItemsComponent.vue?vue&type=template&id=35575099& */ "./resources/js/components/EntradaTanqueItemsComponent.vue?vue&type=template&id=35575099&");
/* harmony import */ var _EntradaTanqueItemsComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./EntradaTanqueItemsComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/EntradaTanqueItemsComponent.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _EntradaTanqueItemsComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _EntradaTanqueItemsComponent_vue_vue_type_template_id_35575099___WEBPACK_IMPORTED_MODULE_0__["render"],
  _EntradaTanqueItemsComponent_vue_vue_type_template_id_35575099___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/EntradaTanqueItemsComponent.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/EntradaTanqueItemsComponent.vue?vue&type=script&lang=js&":
/*!******************************************************************************************!*\
  !*** ./resources/js/components/EntradaTanqueItemsComponent.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_EntradaTanqueItemsComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./EntradaTanqueItemsComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/EntradaTanqueItemsComponent.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_EntradaTanqueItemsComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/EntradaTanqueItemsComponent.vue?vue&type=template&id=35575099&":
/*!************************************************************************************************!*\
  !*** ./resources/js/components/EntradaTanqueItemsComponent.vue?vue&type=template&id=35575099& ***!
  \************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EntradaTanqueItemsComponent_vue_vue_type_template_id_35575099___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./EntradaTanqueItemsComponent.vue?vue&type=template&id=35575099& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/EntradaTanqueItemsComponent.vue?vue&type=template&id=35575099&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EntradaTanqueItemsComponent_vue_vue_type_template_id_35575099___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EntradaTanqueItemsComponent_vue_vue_type_template_id_35575099___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



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

/***/ "./resources/js/entradatanque.js":
/*!***************************************!*\
  !*** ./resources/js/entradatanque.js ***!
  \***************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _components_EntradaTanqueItemsComponent_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./components/EntradaTanqueItemsComponent.vue */ "./resources/js/components/EntradaTanqueItemsComponent.vue");

var leads = new Vue({
  el: '#entrada_tanque_combustiveis',
  components: {
    entrada_tanque: _components_EntradaTanqueItemsComponent_vue__WEBPACK_IMPORTED_MODULE_0__["default"]
  }
});

/***/ }),

/***/ 3:
/*!*********************************************!*\
  !*** multi ./resources/js/entradatanque.js ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\wamp\www\goldenfrota\resources\js\entradatanque.js */"./resources/js/entradatanque.js");


/***/ })

/******/ });