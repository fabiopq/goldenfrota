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
/******/ 	return __webpack_require__(__webpack_require__.s = 4);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/SaidaEstoqueItemsComponent.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/SaidaEstoqueItemsComponent.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************/
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  components: {
    'vue-modal': _modal_vue__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  props: ['oldData', 'estoques', 'oldEstoqueId', 'estoqueError'],
  data: function data() {
    return {
      editing: false,
      editingIndex: false,
      items: [],
      quantidade: 1,
      desconto: 0,
      acrescimo: 0,
      valorUnitario: 0,
      isModalVisible: false,
      deleteIndex: false,
      produtosDisponiveis: [],
      produtosSelecionados: [],
      produtosData: [],
      loadOldDataFlag: true,
      errors: {
        inputProdutos: false,
        inputProdutosMsg: '',
        inputQuantidade: false,
        inputQuantidadeMsg: '',
        inputValorUnitario: false,
        inputValorUnitariodeMsg: '',
        inputDesconto: false,
        inputDescontoMsg: '',
        inputAcrescimo: false,
        inputAcrescimoMsg: '',
        estoqueId: false,
        estoqueIdMsg: ''
      },
      _produto_id: false,

      get produto_id() {
        return this._produto_id;
      },

      set produto_id(value) {
        this._produto_id = value;
      },

      _estoqueId: null,

      get estoqueId() {
        return this._estoqueId;
      },

      set estoqueId(value) {
        this._estoqueId = value;
      }

    };
  },
  watch: {
    oldData: function oldData() {
      this.$refs.confirmDelete;
    },
    estoqueId: function estoqueId() {
      this.getProdutos();
    },
    produto_id: function produto_id() {
      var _this = this;

      if (!this.editing) {
        //this.valor_unitario = this.getProdutoById(this.produto_id).valor_venda;
        var prod = this.produtosData.find(function (p) {
          return p.id === _this.produto_id;
        });

        if (prod != undefined) {
          this.valorUnitario = prod.valor_venda;
        }
      } //this.calcTotalProdutoItem();

    }
    /* ,
    produto_id: function() {
       let prod = this.produtosData.find(p => p.id === this.produto_id);
       if (prod != undefined) {
           this.valorUnitario = prod.valor_venda;
       }
    } */

  },
  computed: {
    estoque_id: {
      get: function get() {
        return this.estoqueId;
      },
      set: function set(value) {
        this.estoqueId = value;
      }
    },
    valor_total: {
      get: function get() {
        var total = 0;

        for (var i = 0; i < this.items.length; i++) {
          total += this.items[i].quantidade * this.items[i].valor_unitario;
        }

        return total;
      }
    },

    /* valorUnitario: {
        get() {
            return this.getProdutoById(this.produto_id).valor_venda;
        }
    }, */
    produtosDisponiveisOrdenados: function produtosDisponiveisOrdenados() {
      function compare(a, b) {
        if (a.produto_descricao < b.produto_descricao) return -1;
        if (a.produto_descricao > b.produto_descricao) return 1;
        return 0;
      }

      return this.produtosDisponiveis.sort(compare);
    }
  },
  mounted: function mounted() {
    if (this.oldEstoqueId !== null) {
      this.estoqueId = this.oldEstoqueId.estoque_id;
      this.getProdutos();
    }

    if (this.estoqueError !== null) {
      this.errors.estoqueId = true;
      this.errors.estoqueIdMsg = this.estoqueError.msg;
    } else {
      this.errors.estoqueId = false;
      this.errors.estoqueIdMsg = '';
    }
  },
  updated: function updated() {
    $(this.$refs.inputProdutos).selectpicker('refresh');
    $(this.$refs.estoqueId).selectpicker('refresh');
  },
  methods: {
    getProdutos: function getProdutos() {
      var self = this;

      if (this.estoqueId !== null && this.estoqueId !== 'false') {
        axios.get('/produtos_estoque/' + this.estoqueId + '/json').then(function (response) {
          self.produtosDisponiveis = response.data;
          self.produtosData = response.data;
          self.loadOldData();
        });
      }
    },
    loadOldData: function loadOldData() {
      if (this.oldData !== null && this.loadOldDataFlag == true) {
        this.loadOldDataFlag = false;

        for (var i = 0; i < this.oldData.length; i++) {
          this.items.push({
            'id': this.oldData[i].produto_id,
            'produto_descricao': this.getProdutoById(this.oldData[i].produto_id).produto_descricao,
            'quantidade': Number(this.oldData[i].quantidade),
            'valor_unitario': Number(this.oldData[i].valor_unitario),
            'valor_desconto': Number(this.oldData[i].valor_desconto),
            'valor_acrescimo': Number(this.oldData[i].valor_acrescimo)
          });
          this.incluirProduto(this.oldData[i].produto_id);
        }
      }
    },
    truncDecimal: function truncDecimal(value, n) {
      x = (value.toString() + ".0").split(".");
      return parseFloat(x[0] + "," + x[1].substr(0, n));
    },
    validarItem: function validarItem() {
      if (this.produto_id == '' || this.produto_id <= 0) {
        this.errors.inputProdutos = true;
        this.errors.inputProdutosMsg = 'Nenhum Produto selecionado.';
        return false;
      } else {
        this.errors.inputProdutos = false;
        this.errors.inputProdutosMsg = '';
      }

      if (this.quantidade == '' || this.quantidade <= 0) {
        this.errors.inputQuantidade = true;
        this.errors.inputQuantidadeMsg = 'Informe a quantidade do produto.';
        return false;
      } else {
        if (!this.getEstoqueById(this.estoqueId).permite_estoque_negativo) {
          var posicao_estoque_produto = this.getProdutoById(this.produto_id).posicao_estoque;

          if (this.quantidade > posicao_estoque_produto) {
            this.errors.inputQuantidade = true;
            this.errors.inputQuantidadeMsg = 'Quantidade informada execede saldo em estoque (' + this.truncDecimal(posicao_estoque_produto, 3) + ').';
            return false;
          }
        }

        this.errors.inputQuantidade = false;
        this.errors.inputQuantidadeMsg = '';
      }

      if (this.valorUnitario == '' || this.valorUnitario <= 0) {
        this.errors.inputValorUnitario = true;
        this.errors.inputValorUnitarioMsg = 'Informe o Valor Unitário do produto.';
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
    addProduto: function addProduto() {
      if (this.validarItem()) {
        this.items.push({
          'id': this.produto_id,
          'produto_descricao': this.getProdutoById(this.produto_id).produto_descricao,
          'quantidade': this.quantidade,
          'valor_unitario': this.valorUnitario,
          'valor_desconto': this.desconto,
          'valor_acrescimo': this.acrescimo
        });
        this.incluirProduto(this.produto_id);
        this.limparFormulario();
      }
    },
    editItem: function editItem(index) {
      var item = this.items[index];
      this.quantidade = item.quantidade;
      this.valorUnitario = item.valor_unitario;
      this.desconto = item.valor_desconto;
      this.acrescimo = item.valor_acrescimo;
      this.produto_id = item.id;
      this.editing = true;
      this.editingIndex = index;
      this.produtosDisponiveis.push(item);
    },
    updateProduto: function updateProduto() {
      this.items[this.editingIndex] = {
        'id': this.produto_id,
        'produto_descricao': this.getProdutoById(this.produto_id).produto_descricao,
        'quantidade': this.quantidade,
        'valor_unitario': this.valorUnitario,
        'valor_desconto': this.desconto,
        'valor_acrescimo': this.acrescimo
      };
      this.editing = false;
      this.editingIndex = false;
      this.limparFormulario();
      this.$delete(this.produtosDisponiveis, this.getProdutoIndexById(this.produto_id));
    },
    deleteItem: function deleteItem() {
      this.removerProduto(this.items[this.deleteIndex].id);
      this.$delete(this.items, this.deleteIndex);
    },
    limparFormulario: function limparFormulario() {
      this.produto_id = false;
      this.produtoSelecionado = false;
      this.quantidade = 1;
      this.valorUnitario = 0;
      this.desconto = 0;
      this.acrescimo = 0;
      this.$refs.inputProdutos.focus();
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
    getProdutoById: function getProdutoById(id) {
      var result = 0;

      for (var i = 0; i < this.produtosData.length; i++) {
        if (this.produtosData[i].id == id) {
          result = this.produtosData[i];
          break;
        }
      }

      return result;
    },
    getEstoqueById: function getEstoqueById(id) {
      var result = 0;

      for (var i = 0; i < this.estoques.length; i++) {
        if (this.estoques[i].id == id) {
          result = this.estoques[i];
          break;
        }
      }

      return result;
    },
    getProdutoIndexById: function getProdutoIndexById(id) {
      var result = 0;

      for (var i = 0; i < this.produtosData.length; i++) {
        if (this.produtosData[i].id == id) {
          result = i;
          break;
        }
      }

      return result;
    },
    getProdutoSelecionadoById: function getProdutoSelecionadoById(id) {
      var result = 0;

      for (var i = 0; i < this.produtosSelecionados.length; i++) {
        if (this.produtosSelecionados[i].id == id) {
          result = this.produtosSelecionados[i];
          break;
        }
      }

      return result;
    },
    getProdutoSelecionadoIndexById: function getProdutoSelecionadoIndexById(id) {
      var result = 0;

      for (var i = 0; i < this.produtosSelecionados.length; i++) {
        if (this.produtosSelecionados[i].id == id) {
          result = i;
          break;
        }
      }

      return result;
    },
    incluirProduto: function incluirProduto(id) {
      this.produtosSelecionados.push(this.getProdutoById(id));
      this.$delete(this.produtosDisponiveis, this.getProdutoIndexById(id));
    },
    removerProduto: function removerProduto(id) {
      this.produtosDisponiveis.push(this.getProdutoSelecionadoById(id));
      this.$delete(this.produtosSelecionados, this.getProdutoSelecionadoIndexById(id));
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/SaidaEstoqueItemsComponent.vue?vue&type=template&id=4dfbe9b0&":
/*!*****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/SaidaEstoqueItemsComponent.vue?vue&type=template&id=4dfbe9b0& ***!
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
  return _c("div", { staticClass: "form-group" }, [
    _c("div", { staticClass: "row" }, [
      _c("input", {
        directives: [
          {
            name: "model",
            rawName: "v-model",
            value: _vm.estoque_id,
            expression: "estoque_id"
          }
        ],
        attrs: { type: "hidden", name: "estoque_id" },
        domProps: { value: _vm.estoque_id },
        on: {
          input: function($event) {
            if ($event.target.composing) {
              return
            }
            _vm.estoque_id = $event.target.value
          }
        }
      }),
      _vm._v(" "),
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
        { class: { "col-md-7": true, " has-error": this.errors.estoqueId } },
        [
          _c(
            "label",
            { staticClass: "control-label", attrs: { for: "estoqueId" } },
            [_vm._v("Estoque")]
          ),
          _vm._v(" "),
          _c(
            "select",
            {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.estoqueId,
                  expression: "estoqueId"
                }
              ],
              ref: "estoqueId",
              staticClass: "form-control selectpicker mb-3",
              attrs: {
                "data-live-search": "true",
                "data-title": "Nada Selecionado",
                "data-style": "btn-secondary",
                name: "estoqueId",
                id: "estoqueId",
                disabled: _vm.produtosSelecionados.length > 0
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
                  _vm.estoqueId = $event.target.multiple
                    ? $$selectedVal
                    : $$selectedVal[0]
                }
              }
            },
            _vm._l(this.estoques, function(estoque, index) {
              return _c(
                "option",
                { key: index, domProps: { value: estoque.id } },
                [_vm._v(_vm._s(estoque.id + " - " + estoque.estoque))]
              )
            }),
            0
          ),
          _vm._v(" "),
          _c(
            "span",
            {
              staticClass: "help-block",
              attrs: { "v-if": this.errors.estoqueId }
            },
            [_c("strong", [_vm._v(_vm._s(this.errors.estoqueIdMsg))])]
          )
        ]
      )
    ]),
    _vm._v(" "),
    _c(
      "div",
      { staticClass: "card" },
      [
        _vm._m(0),
        _vm._v(" "),
        _c(
          "div",
          {
            staticClass: "card-body",
            staticStyle: { padding: "0 !important" }
          },
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
                          "\n                            " +
                            _vm._s(item.id) +
                            "\n                            "
                        ),
                        _c("input", {
                          attrs: {
                            type: "hidden",
                            name: "items[" + index + "][produto_id]"
                          },
                          domProps: { value: item.id }
                        })
                      ]),
                      _vm._v(" "),
                      _c("td", { staticClass: "col-md-6" }, [
                        _vm._v(
                          "\n                            " +
                            _vm._s(item.produto_descricao) +
                            "\n                        "
                        )
                      ]),
                      _vm._v(" "),
                      _c("td", { staticClass: "col-md-1 text-right" }, [
                        _vm._v(
                          "\n                            " +
                            _vm._s(item.quantidade) +
                            "\n                            "
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
                      _c("td", { staticClass: "col-md-1 text-right" }, [
                        _vm._v(
                          "\n                            " +
                            _vm._s(item.valor_unitario) +
                            "\n                            "
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
                      _c("td", { staticClass: "col-md-1 text-right" }, [
                        _vm._v(
                          "\n                            " +
                            _vm._s(item.valor_desconto) +
                            "\n                            "
                        ),
                        _c("input", {
                          attrs: {
                            type: "hidden",
                            name: "items[" + index + "][valor_desconto]"
                          },
                          domProps: { value: item.valor_desconto }
                        })
                      ]),
                      _vm._v(" "),
                      _c("td", { staticClass: "col-md-1 text-right" }, [
                        _vm._v(
                          "\n                            " +
                            _vm._s(item.valor_acrescimo) +
                            "\n                            "
                        ),
                        _c("input", {
                          attrs: {
                            type: "hidden",
                            name: "items[" + index + "][valor_acrescimo]"
                          },
                          domProps: { value: item.valor_acrescimo }
                        })
                      ]),
                      _vm._v(" "),
                      _c("td", { staticClass: "col-md-1" }, [
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
                            staticClass: "btn-xs btn-warning",
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
                            staticClass: "btn-xs btn-danger",
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
                        _c("td", { staticClass: "col-md-6" }),
                        _vm._v(" "),
                        _c("td", { staticClass: "col-md-1 text-right" }, [
                          _c("strong", [_vm._v(_vm._s(this.totalQuantidade()))])
                        ]),
                        _vm._v(" "),
                        _c("td", { staticClass: "col-md-1 text-right" }, [
                          _c("strong", [_vm._v(_vm._s(this.totalValor()))])
                        ]),
                        _vm._v(" "),
                        _c("td", { staticClass: "col-md-1 text-right" }, [
                          _c("strong", [_vm._v(_vm._s(this.totalDesconto()))])
                        ]),
                        _vm._v(" "),
                        _c("td", { staticClass: "col-md-1 text-right" }, [
                          _c("strong", [_vm._v(_vm._s(this.totalAcrescimo()))])
                        ]),
                        _vm._v(" "),
                        _c("td", { staticClass: "col-md-1" })
                      ])
                    ])
                  : _vm._e()
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
                  "col-md-7": true,
                  " has-error": this.errors.inputProdutos
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
                        value: _vm.produto_id,
                        expression: "produto_id"
                      }
                    ],
                    ref: "inputProdutos",
                    staticClass: "form-control selectpicker",
                    attrs: {
                      disabled:
                        _vm.estoqueId == "false" || _vm.estoqueId == null,
                      "data-style": "btn-secondary",
                      "data-live-search": "true",
                      name: "inputProdutos",
                      id: "inputProdutos"
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
                        _vm.produto_id = $event.target.multiple
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
                    _vm._l(_vm.produtosDisponiveisOrdenados, function(
                      produto,
                      index
                    ) {
                      return _c(
                        "option",
                        { key: index, domProps: { value: produto.id } },
                        [
                          _vm._v(
                            _vm._s(
                              produto.id + " - " + produto.produto_descricao
                            )
                          )
                        ]
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
                    attrs: { "v-if": this.errors.inputProdutos }
                  },
                  [_c("strong", [_vm._v(_vm._s(this.errors.inputProdutosMsg))])]
                )
              ]
            ),
            _vm._v(" "),
            _c(
              "div",
              {
                class: {
                  "col-md-1": true,
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
                    disabled: _vm.estoqueId == "false" || _vm.estoqueId == null,
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
                  [
                    _c("strong", [
                      _vm._v(_vm._s(this.errors.inputQuantidadeMsg))
                    ])
                  ]
                )
              ]
            ),
            _vm._v(" "),
            _c(
              "div",
              {
                class: {
                  "col-md-1": true,
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
                    disabled: _vm.estoqueId == "false" || _vm.estoqueId == null,
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
            _c(
              "div",
              {
                class: {
                  "col-md-1": true,
                  " has-error": this.errors.inputDesconto
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
                      value: _vm.desconto,
                      expression: "desconto",
                      modifiers: { number: true }
                    }
                  ],
                  ref: "inputDesconto",
                  staticClass: "form-control",
                  attrs: {
                    disabled: _vm.estoqueId == "false" || _vm.estoqueId == null,
                    type: "number",
                    min: "0,000",
                    max: "9999999999,999",
                    step: "any",
                    name: "inputDesconto",
                    id: "inputDesconto"
                  },
                  domProps: { value: _vm.desconto },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.desconto = _vm._n($event.target.value)
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
                    attrs: { "v-if": this.errors.inputDesconto }
                  },
                  [_c("strong", [_vm._v(_vm._s(this.errors.inputDescontoMsg))])]
                )
              ]
            ),
            _vm._v(" "),
            _c(
              "div",
              {
                class: {
                  "col-md-1": true,
                  " has-error": this.errors.inputAcrescimo
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
                      value: _vm.acrescimo,
                      expression: "acrescimo",
                      modifiers: { number: true }
                    }
                  ],
                  ref: "inputAcrescimo",
                  staticClass: "form-control",
                  attrs: {
                    disabled: _vm.estoqueId == "false" || _vm.estoqueId == null,
                    type: "number",
                    min: "0,000",
                    max: "9999999999,999",
                    step: "any",
                    name: "inputAcrescimo",
                    id: "inputAcrescimo"
                  },
                  domProps: { value: _vm.acrescimo },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.acrescimo = _vm._n($event.target.value)
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
                    attrs: { "v-if": this.errors.inputAcrescimo }
                  },
                  [
                    _c("strong", [
                      _vm._v(_vm._s(this.errors.inputAcrescimoMsg))
                    ])
                  ]
                )
              ]
            ),
            _vm._v(" "),
            _c("div", { staticClass: "col-md-1" }, [
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
                  attrs: {
                    disabled: _vm.estoqueId == "false" || _vm.estoqueId == null,
                    type: "button"
                  },
                  on: { click: _vm.addProduto }
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
                  attrs: {
                    disabled: _vm.estoqueId == "false" || _vm.estoqueId == null,
                    type: "button"
                  },
                  on: { click: _vm.updateProduto }
                },
                [_c("i", { staticClass: "fas fa-check" })]
              )
            ])
          ])
        ]),
        _vm._v(" "),
        _c("vue-modal", {
          attrs: {
            "modal-title": "Corfirmação",
            "modal-text": "Confirma a remoção deste Item?"
          },
          on: { cancel: _vm.cancelDelete, confirm: _vm.deleteItem }
        })
      ],
      1
    )
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "card-header" }, [
      _c("strong", [_vm._v("Produtos")])
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
        _c("th", { staticClass: "col-md-6" }, [_vm._v("Produto")]),
        _vm._v(" "),
        _c("th", { staticClass: "col-md-1" }, [_vm._v("Quantidade")]),
        _vm._v(" "),
        _c("th", { staticClass: "col-md-1" }, [_vm._v("Vlr. Un.")]),
        _vm._v(" "),
        _c("th", { staticClass: "col-md-1" }, [_vm._v("Vlr. Desc.")]),
        _vm._v(" "),
        _c("th", { staticClass: "col-md-1" }, [_vm._v("Vlr. Acres.")]),
        _vm._v(" "),
        _c("th", { staticClass: "col-md-1" }, [_vm._v("Ações")])
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

/***/ "./resources/js/components/SaidaEstoqueItemsComponent.vue":
/*!****************************************************************!*\
  !*** ./resources/js/components/SaidaEstoqueItemsComponent.vue ***!
  \****************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _SaidaEstoqueItemsComponent_vue_vue_type_template_id_4dfbe9b0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SaidaEstoqueItemsComponent.vue?vue&type=template&id=4dfbe9b0& */ "./resources/js/components/SaidaEstoqueItemsComponent.vue?vue&type=template&id=4dfbe9b0&");
/* harmony import */ var _SaidaEstoqueItemsComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SaidaEstoqueItemsComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/SaidaEstoqueItemsComponent.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _SaidaEstoqueItemsComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _SaidaEstoqueItemsComponent_vue_vue_type_template_id_4dfbe9b0___WEBPACK_IMPORTED_MODULE_0__["render"],
  _SaidaEstoqueItemsComponent_vue_vue_type_template_id_4dfbe9b0___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/SaidaEstoqueItemsComponent.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/SaidaEstoqueItemsComponent.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************!*\
  !*** ./resources/js/components/SaidaEstoqueItemsComponent.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SaidaEstoqueItemsComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./SaidaEstoqueItemsComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/SaidaEstoqueItemsComponent.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SaidaEstoqueItemsComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/SaidaEstoqueItemsComponent.vue?vue&type=template&id=4dfbe9b0&":
/*!***********************************************************************************************!*\
  !*** ./resources/js/components/SaidaEstoqueItemsComponent.vue?vue&type=template&id=4dfbe9b0& ***!
  \***********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SaidaEstoqueItemsComponent_vue_vue_type_template_id_4dfbe9b0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./SaidaEstoqueItemsComponent.vue?vue&type=template&id=4dfbe9b0& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/SaidaEstoqueItemsComponent.vue?vue&type=template&id=4dfbe9b0&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SaidaEstoqueItemsComponent_vue_vue_type_template_id_4dfbe9b0___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SaidaEstoqueItemsComponent_vue_vue_type_template_id_4dfbe9b0___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



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

/***/ "./resources/js/saidaestoque.js":
/*!**************************************!*\
  !*** ./resources/js/saidaestoque.js ***!
  \**************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _components_SaidaEstoqueItemsComponent_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./components/SaidaEstoqueItemsComponent.vue */ "./resources/js/components/SaidaEstoqueItemsComponent.vue");

var leads = new Vue({
  el: '#saida_estoque_produtos',
  components: {
    SaidaEstoqueItemsComponent: _components_SaidaEstoqueItemsComponent_vue__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  data: function data() {
    return {
      _estoqueId: null,

      get estoqueId() {
        return this._estoqueId;
      },

      set estoqueId(value) {
        this._estoqueId = value;
      }

    };
  }
});

/***/ }),

/***/ 4:
/*!********************************************!*\
  !*** multi ./resources/js/saidaestoque.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\wamp\www\goldenfrota\resources\js\saidaestoque.js */"./resources/js/saidaestoque.js");


/***/ })

/******/ });