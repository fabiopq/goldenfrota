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
/******/ 	return __webpack_require__(__webpack_require__.s = 7);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./node_modules/@babel/runtime/regenerator/index.js":
/*!**********************************************************!*\
  !*** ./node_modules/@babel/runtime/regenerator/index.js ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! regenerator-runtime */ "./node_modules/regenerator-runtime/runtime.js");


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/OsProdutoComponent.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/OsProdutoComponent.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _modal2_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./modal2.vue */ "./resources/js/components/modal2.vue");


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  name: 'ordem-servico-produto',
  components: {
    modal2: _modal2_vue__WEBPACK_IMPORTED_MODULE_1__["default"]
  },
  props: ['oldData', 'estoques', 'oldEstoqueId', 'estoqueError'],
  data: function data() {
    return {
      editing: false,
      editingIndex: false,
      produtos: [],
      produtosVencimento: [],
      produto_vencimento_id: null,
      veiculo_element: null,
      quantidade: 1,
      valor_desconto: 0,
      valor_acrescimo: 0,
      valor_cobrado: 0,
      valor_unitario: 0,
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
    oldData: function oldData() {//this.$refs.confirmDelete
    },
    estoqueId: function estoqueId() {
      this.getProdutos();
    },
    valor_produto: function valor_produto() {
      this.calcTotalProdutoItem();
    },
    valor_desconto: function valor_desconto() {
      this.calcTotalProdutoItem();
    },
    valor_acrescimo: function valor_acrescimo() {
      this.calcTotalProdutoItem();
    },
    quantidade: function quantidade() {
      this.calcTotalProdutoItem();
    },
    produto_id: function produto_id() {
      if (!this.editing) {
        this.valor_unitario = this.getProdutoById(this.produto_id).valor_venda;
      }

      this.calcTotalProdutoItem();
    }
  },
  computed: {
    veiculo_id: function veiculo_id() {
      if (this.veiculo_element !== null) {
        return this.veiculo_element.value;
      } else {
        return null;
      }
    },
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

        for (var i = 0; i < this.produtos.length; i++) {
          total += (parseFloat(this.produtos[i].valor_produto) + parseFloat(this.produtos[i].valor_acrescimo) - parseFloat(this.produtos[i].valor_desconto)) * this.produtos[i].quantidade;
        }

        return parseFloat(total);
      }
    },
    produtosDisponiveisOrdenados: function produtosDisponiveisOrdenados() {
      return this.produtosDisponiveis.sort(function (a, b) {
        return a.produto_descricao > b.produto_descricao ? 1 : a.produto_descricao == b.produto_descricao ? 0 : -1;
      });
    }
  },
  mounted: function mounted() {
    if (this.oldEstoqueId !== null) {
      this.estoqueId = this.oldEstoqueId; //this.getProdutos();
    }

    this.veiculo_element = this.$parent.$parent.$refs.ref_veiculo_id;
  },
  updated: function updated() {
    $(this.$refs.inputProdutosVencimento).selectpicker('refresh');
    $(this.$refs.inputProdutos).selectpicker('refresh');
    $(this.$refs.estoqueId).selectpicker('refresh');
  },
  methods: {
    getValorTotal: function getValorTotal() {
      var total = 0;

      for (var i = 0; i < this.produtos.length; i++) {
        total += (parseFloat(this.produtos[i].valor_produto) + parseFloat(this.produtos[i].valor_acrescimo) - parseFloat(this.produtos[i].valor_desconto)) * this.produtos[i].quantidade;
      }

      return parseFloat(total);
    },
    getProdutos: function getProdutos() {
      var self = this; //if ((this.estoqueId !== null) && (this.estoqueId !== 'false')) {

      if (this.estoqueId > 0) {
        axios.get('/produtos_estoque/' + this.estoqueId + '/json').then(function (response) {
          self.produtosDisponiveis = response.data;
          self.produtosData = response.data;
          self.loadOldData();
          self.obterListagemProdutosVencimento();
        });
      }
    },
    loadOldData: function loadOldData() {
      if (this.oldData !== null && this.loadOldDataFlag == true) {
        this.loadOldDataFlag = false;

        for (var i = 0; i < this.oldData.length; i++) {
          this.produtos.push({
            'id': this.oldData[i].produto_id,
            'produto_descricao': this.getProdutoById(this.oldData[i].produto_id).produto_descricao,
            'quantidade': Number(this.oldData[i].quantidade),
            'valor_produto': Number(this.oldData[i].valor_produto),
            'valor_desconto': Number(this.oldData[i].valor_desconto),
            'valor_acrescimo': Number(this.oldData[i].valor_acrescimo),
            'valor_cobrado': Number(this.oldData[i].valor_cobrado)
          });
          this.incluirProduto(this.oldData[i].produto_id);
        }
      }
    },
    truncDecimal: function truncDecimal(value, n) {
      if (value === 0) {
        return value;
      }

      x = (value.toString() + ".0").split(".");

      if (!x) {
        x = 0;
      }

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
          console.log('posicao_estoque_produto: ' + posicao_estoque_produto);

          if (this.quantidade > posicao_estoque_produto) {
            this.errors.inputQuantidade = true;
            this.errors.inputQuantidadeMsg = 'Quantidade informada execede saldo em estoque (' + this.truncDecimal(posicao_estoque_produto, 3) + ').';
            return false;
          }
        } else {
          this.errors.inputQuantidade = false;
          this.errors.inputQuantidadeMsg = '';
        }
      }

      if (this.valor_unitario == '' || this.valor_unitario <= 0) {
        this.errors.inputValorUnitario = true;
        this.errors.inputValorUnitarioMsg = 'Informe o Valor Unitário do produto.';
        return false;
      } else {
        this.errors.inputValorUnitario = false;
        this.errors.inputValorUnitarioMsg = '';
      }

      return true;
    },
    confirmDeleteProduto: function confirmDeleteProduto(index) {
      this.deleteIndex = index;
    },
    cancelDelete: function cancelDelete(index) {
      this.deleteIndex = false;
    },
    cancelProtuto: function cancelProtuto() {//console.log('cancel produto');
    },
    confirmProtuto: function confirmProtuto() {//console.log('confirm produto');
    },
    addProduto: function addProduto() {
      if (this.validarItem()) {
        this.produtos.push({
          'id': this.produto_id,
          'produto_vencimento_id': this.produto_vencimento_id,
          'produto_descricao': this.getProdutoById(this.produto_id).produto_descricao + this.getProdutoVencimentoDesc(this.produto_vencimento_id),
          'quantidade': Number(this.quantidade),
          'valor_produto': Number(this.getProdutoById(this.produto_id).valor_venda),
          'valor_desconto': Number(this.valor_desconto),
          'valor_acrescimo': Number(this.valor_acrescimo),
          'valor_cobrado': Number(this.valor_cobrado)
        });
        this.incluirProduto(this.produto_id);
        this.limparFormulario();
      }
    },
    editItem: function editItem(index) {
      this.editing = true;
      this.editingIndex = index;
      var item = this.produtos[index];
      this.produto_id = item.id;
      this.quantidade = Number(item.quantidade);
      this.valor_unitario = Number(item.valor_produto);
      this.valor_desconto = Number(item.valor_desconto);
      this.valor_acrescimo = Number(item.valor_acrescimo);
      this.produtosDisponiveis.push(item);
    },
    updateProduto: function updateProduto() {
      this.produtos[this.editingIndex] = {
        'id': this.produto_id,
        'produto_vencimento_id': this.produto_vencimento_id,
        'produto_descricao': this.getProdutoById(this.produto_id).produto_descricao + this.getProdutoVencimentoDesc(this.produto_vencimento_id),
        'quantidade': Number(this.quantidade),
        'valor_produto': Number(this.valor_unitario),
        'valor_desconto': Number(this.valor_desconto),
        'valor_acrescimo': Number(this.valor_acrescimo),
        'valor_cobrado': Number(this.valor_cobrado)
      };
      this.editing = false;
      this.editingIndex = false;
      this.limparFormulario();
      this.$delete(this.produtosDisponiveis, this.getProdutoIndexById(this.produto_id));
      var VLTotal = this.getValorTotal();
      this.$emit('updateTotalProd', VLTotal);
    },
    getProdutoVencimentoDesc: function getProdutoVencimentoDesc(id) {
      var prod = this.produtosVencimento.find(function (a) {
        return a.id == id;
      });

      if (prod != undefined) {
        return ' (' + prod.produto.produto_desc_red + ')';
      } else {
        return '';
      }
    },
    deleteProduto: function deleteProduto() {
      this.removerProduto(this.produtos[this.deleteIndex].id);
      this.$delete(this.produtos, this.deleteIndex);
    },
    limparFormulario: function limparFormulario() {
      this.produto_id = false;
      this.produtoSelecionado = false;
      this.quantidade = 1;
      this.valor_unitario = 0.000;
      this.valor_desconto = 0.000;
      this.valor_acrescimo = 0.000;
      this.valor_cobrado = 0.000;
      this.$refs.inputProdutos.focus();
    },
    totalQuantidade: function totalQuantidade() {
      var result = 0;

      for (var i = 0; i < this.produtos.length; i++) {
        result += this.produtos[i].quantidade;
      }

      return result;
    },
    totalValor: function totalValor() {
      var result = 0;

      for (var i = 0; i < this.produtos.length; i++) {
        result += this.produtos[i].valor_produto;
      }

      return result;
    },
    totalDesconto: function totalDesconto() {
      var result = 0;

      for (var i = 0; i < this.produtos.length; i++) {
        result += this.produtos[i].valor_desconto;
      }

      return result;
    },
    totalAcrescimo: function totalAcrescimo() {
      var result = 0;

      for (var i = 0; i < this.produtos.length; i++) {
        result += this.produtos[i].valor_acrescimo;
      }

      return result;
    },
    totalCobrado: function totalCobrado() {
      var result = 0;

      for (var i = 0; i < this.produtos.length; i++) {
        result += this.produtos[i].valor_cobrado;
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
      } //console.log('index: '+result);


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
      this.$emit('updateTotalProd', this.valor_total);
    },
    removerProduto: function removerProduto(id) {
      this.produtosDisponiveis.push(this.getProdutoSelecionadoById(id));
      this.$delete(this.produtosSelecionados, this.getProdutoSelecionadoIndexById(id));
      this.$emit('updateTotalProd', this.valor_total);
    },
    calcTotalProdutoItem: function calcTotalProdutoItem() {
      //console.log('entrou no valor cobrado');
      this.valor_cobrado = (parseFloat(isNaN(this.valor_unitario) || this.valor_unitario == '' ? 0 : this.valor_unitario) + parseFloat(isNaN(this.valor_acrescimo) || this.valor_acrescimo == '' ? 0 : this.valor_acrescimo) - parseFloat(isNaN(this.valor_desconto) || this.valor_desconto == '' ? 0 : this.valor_desconto)) * parseFloat(isNaN(this.quantidade) || this.quantidade == '' ? 1 : this.quantidade);
    },
    obterListagemProdutosVencimento: function obterListagemProdutosVencimento() {
      var _this = this;

      console.log(this.veiculo_id);

      if (this.veiculo_id !== null) {
        axios.get('/produtos_vencendo_vencidos/' + this.veiculo_id).then(
        /*#__PURE__*/
        function () {
          var _ref = _asyncToGenerator(
          /*#__PURE__*/
          _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee(r) {
            return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
              while (1) {
                switch (_context.prev = _context.next) {
                  case 0:
                    _this.produtosVencimento = r.data;
                    console.log(r.data);

                  case 2:
                  case "end":
                    return _context.stop();
                }
              }
            }, _callee);
          }));

          return function (_x) {
            return _ref.apply(this, arguments);
          };
        }())["catch"](function (e) {
          console.log(e);
        });
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/OsServicoComponent.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/OsServicoComponent.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************/
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

/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'ordem-servico-servico',
  components: {
    modal: _modal_vue__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  data: function data() {
    return {
      editing: false,
      editingIndex: false,
      servico_id: false,
      valor_servico: 0,
      valor_acrescimo: 0,
      valor_desconto: 0,
      valor_cobrado: 0,
      servicos: [],
      isModalVisible: false,
      deleteIndex: false,
      servicosDisponiveis: [],
      servicosSelecionados: [],
      errors: {
        inputServicos: false,
        inputServicosMsg: '',
        inputValorServico: false,
        inputValorServicoMsg: '',
        inputValorAcrescimo: false,
        inputValorAcrescimoMsg: '',
        inputValorDesconto: false,
        inputValorDescontoMsg: '',
        inputValorCobrado: false,
        inputValorCobradoMsg: ''
      }
    };
  },
  props: ['servicosData', 'oldData'],
  updated: function updated() {
    $(this.$refs.inputServicos).selectpicker('refresh');
  },
  watch: {
    oldData: function oldData() {
      this.$refs.confirmDelete;
    },
    servico_id: function servico_id() {
      var servicoSelecionado = this.getServicoById(this.servico_id);

      if (servicoSelecionado == 0) {
        this.valor_servico = 0;
      } else {
        this.valor_servico = servicoSelecionado.valor_servico;
      }
    },
    valor_servico: function valor_servico() {
      this.calTotalServicoItem();
    },
    valor_acrescimo: function valor_acrescimo() {
      this.calTotalServicoItem();
    },
    valor_desconto: function valor_desconto() {
      this.calTotalServicoItem();
    }
  },
  computed: {
    servicosDisponiveisOrdenados: function servicosDisponiveisOrdenados() {
      function compare(a, b) {
        if (a.servico < b.servico) return -1;
        if (a.servico > b.servico) return 1;
        return 0;
      }

      return this.servicosDisponiveis.sort(compare);
    },
    valor_total_servicos: {
      get: function get() {
        var total = 0;

        for (var i = 0; i < this.servicosSelecionados.length; i++) {
          total += parseFloat(this.servicosSelecionados[i].valor_cobrado);
        }

        return total;
      }
    }
  },
  mounted: function mounted() {
    this.createFields();
    this.servicosDisponiveis = this.servicosData;

    if (this.oldData !== null) {
      for (var i = 0; i < this.oldData.length; i++) {
        console.log(this.oldData[i]);
        this.valor_servico = parseFloat(this.oldData[i].valor_servico);
        this.valor_acrescimo = parseFloat(this.oldData[i].valor_acrescimo);
        this.valor_desconto = parseFloat(this.oldData[i].valor_desconto);
        this.valor_cobrado = parseFloat(this.oldData[i].valor_cobrado);
        this.incluirServico(this.oldData[i].servico_id);
        this.limparFormulario();
      }
    }
  },
  methods: {
    editItem: function editItem(index) {
      var item = this.servicosSelecionados[index];
      this.valor_servico = item.valor_servico;
      this.valor_acrescimo = item.valor_acrescimo;
      this.valor_desconto = item.valor_desconto;
      this.valor_cobrado = item.valor_cobrado;
      this.servico_id = item.id;
      this.editing = true;
      this.editingIndex = index;
      this.servicosDisponiveis.push(item);
    },
    confirmDelete: function confirmDelete(index) {
      this.deleteIndex = index;
    },
    cancelDelete: function cancelDelete(index) {
      this.deleteIndex = false;
    },
    deleteItem: function deleteItem() {
      this.removerServico(this.servicosSelecionados[this.deleteIndex].id);
      this.$delete(this.servicosSelecionados, this.deleteIndex);
    },
    removerServico: function removerServico(id) {
      this.servicosDisponiveis.push(this.getServicoSelecionadoById(id));
      this.$delete(this.servicosSelecionados, this.getServicoSelecionadoIndexById(id));
      this.$emit('updateTotalServ', this.valor_total_servicos);
    },
    addServico: function addServico() {
      if (this.validarItem()) {
        this.incluirServico(this.servico_id);
        this.limparFormulario();
      }
    },
    limparFormulario: function limparFormulario() {
      this.servico_id = false;
      this.valor_servico = 0;
      this.valor_acrescimo = 0;
      this.valor_desconto = 0;
      this.valor_cobrado = 0;
      this.$refs.inputServicos.focus();
    },
    getServicoById: function getServicoById(id) {
      var result = 0;

      for (var i = 0; i < this.servicosDisponiveis.length; i++) {
        if (this.servicosDisponiveis[i].id == id) {
          result = this.servicosDisponiveis[i];
          break;
        }
      }

      return result;
    },
    getServicoIndexById: function getServicoIndexById(id) {
      var result = 0;

      for (var i = 0; i < this.servicosDisponiveis.length; i++) {
        if (this.servicosDisponiveis[i].id == id) {
          result = i;
          break;
        }
      }

      return result;
    },
    getServicoSelecionadoById: function getServicoSelecionadoById(id) {
      var result = 0;

      for (var i = 0; i < this.servicosSelecionados.length; i++) {
        if (this.servicosSelecionados[i].id == id) {
          result = this.servicosSelecionados[i];
          break;
        }
      }

      return result;
    },
    getServicoSelecionadoIndexById: function getServicoSelecionadoIndexById(id) {
      var result = 0;

      for (var i = 0; i < this.servicosSelecionados.length; i++) {
        if (this.servicosSelecionados[i].id == id) {
          result = i;
          break;
        }
      }

      return result;
    },
    incluirServico: function incluirServico(id) {
      var servicoInserido = this.getServicoById(id);
      servicoInserido.valor_acrescimo = this.valor_acrescimo;
      servicoInserido.valor_desconto = this.valor_desconto;
      servicoInserido.valor_cobrado = this.valor_cobrado;
      this.servicosSelecionados.push(servicoInserido);
      this.$delete(this.servicosDisponiveis, this.getServicoIndexById(id));
      this.$emit('updateTotalServ', this.valor_total_servicos);
    },
    updateServico: function updateServico() {
      this.servicosSelecionados[this.editingIndex] = {
        'id': this.servico_id,
        'servico': this.getServicoById(this.servico_id).servico,
        'valor_servico': this.valor_servico,
        'valor_acrescimo': this.valor_acrescimo,
        'valor_desconto': this.valor_desconto,
        'valor_cobrado': this.valor_cobrado
      };
      this.editing = false;
      this.editingIndex = false;
      this.limparFormulario();
      this.$delete(this.servicosDisponiveis, this.getServicoIndexById(this.servico_id));
      this.$emit('updateTotalServ', this.valor_total_servicos);
    },
    calTotalServicoItem: function calTotalServicoItem() {
      this.valor_cobrado = parseFloat(isNaN(this.valor_servico) || this.valor_servico == '' ? 0 : this.valor_servico) + parseFloat(isNaN(this.valor_acrescimo) || this.valor_acrescimo == '' ? 0 : this.valor_acrescimo) - parseFloat(isNaN(this.valor_desconto) || this.valor_desconto == '' ? 0 : this.valor_desconto);
    },
    validarItem: function validarItem() {
      return true;
    },
    createFields: function createFields() {
      for (var i = 0; i < this.servicosData.length; i++) {
        this.servicosData[i]['valor_acrescimo'] = 0;
        this.servicosData[i]['valor_desconto'] = 0;
        this.servicosData[i]['valor_cobrado'] = 0;
      }
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

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/modal2.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/modal2.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************/
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
//
/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'modal2',
  methods: {
    cancel2: function cancel2() {
      this.$emit('cancel2');
    },
    confirm2: function confirm2() {
      this.$emit('confirm2');
    }
  },
  props: ['modalTitle', 'modalText']
});

/***/ }),

/***/ "./node_modules/regenerator-runtime/runtime.js":
/*!*****************************************************!*\
  !*** ./node_modules/regenerator-runtime/runtime.js ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/**
 * Copyright (c) 2014-present, Facebook, Inc.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

var runtime = (function (exports) {
  "use strict";

  var Op = Object.prototype;
  var hasOwn = Op.hasOwnProperty;
  var undefined; // More compressible than void 0.
  var $Symbol = typeof Symbol === "function" ? Symbol : {};
  var iteratorSymbol = $Symbol.iterator || "@@iterator";
  var asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator";
  var toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag";

  function wrap(innerFn, outerFn, self, tryLocsList) {
    // If outerFn provided and outerFn.prototype is a Generator, then outerFn.prototype instanceof Generator.
    var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator;
    var generator = Object.create(protoGenerator.prototype);
    var context = new Context(tryLocsList || []);

    // The ._invoke method unifies the implementations of the .next,
    // .throw, and .return methods.
    generator._invoke = makeInvokeMethod(innerFn, self, context);

    return generator;
  }
  exports.wrap = wrap;

  // Try/catch helper to minimize deoptimizations. Returns a completion
  // record like context.tryEntries[i].completion. This interface could
  // have been (and was previously) designed to take a closure to be
  // invoked without arguments, but in all the cases we care about we
  // already have an existing method we want to call, so there's no need
  // to create a new function object. We can even get away with assuming
  // the method takes exactly one argument, since that happens to be true
  // in every case, so we don't have to touch the arguments object. The
  // only additional allocation required is the completion record, which
  // has a stable shape and so hopefully should be cheap to allocate.
  function tryCatch(fn, obj, arg) {
    try {
      return { type: "normal", arg: fn.call(obj, arg) };
    } catch (err) {
      return { type: "throw", arg: err };
    }
  }

  var GenStateSuspendedStart = "suspendedStart";
  var GenStateSuspendedYield = "suspendedYield";
  var GenStateExecuting = "executing";
  var GenStateCompleted = "completed";

  // Returning this object from the innerFn has the same effect as
  // breaking out of the dispatch switch statement.
  var ContinueSentinel = {};

  // Dummy constructor functions that we use as the .constructor and
  // .constructor.prototype properties for functions that return Generator
  // objects. For full spec compliance, you may wish to configure your
  // minifier not to mangle the names of these two functions.
  function Generator() {}
  function GeneratorFunction() {}
  function GeneratorFunctionPrototype() {}

  // This is a polyfill for %IteratorPrototype% for environments that
  // don't natively support it.
  var IteratorPrototype = {};
  IteratorPrototype[iteratorSymbol] = function () {
    return this;
  };

  var getProto = Object.getPrototypeOf;
  var NativeIteratorPrototype = getProto && getProto(getProto(values([])));
  if (NativeIteratorPrototype &&
      NativeIteratorPrototype !== Op &&
      hasOwn.call(NativeIteratorPrototype, iteratorSymbol)) {
    // This environment has a native %IteratorPrototype%; use it instead
    // of the polyfill.
    IteratorPrototype = NativeIteratorPrototype;
  }

  var Gp = GeneratorFunctionPrototype.prototype =
    Generator.prototype = Object.create(IteratorPrototype);
  GeneratorFunction.prototype = Gp.constructor = GeneratorFunctionPrototype;
  GeneratorFunctionPrototype.constructor = GeneratorFunction;
  GeneratorFunctionPrototype[toStringTagSymbol] =
    GeneratorFunction.displayName = "GeneratorFunction";

  // Helper for defining the .next, .throw, and .return methods of the
  // Iterator interface in terms of a single ._invoke method.
  function defineIteratorMethods(prototype) {
    ["next", "throw", "return"].forEach(function(method) {
      prototype[method] = function(arg) {
        return this._invoke(method, arg);
      };
    });
  }

  exports.isGeneratorFunction = function(genFun) {
    var ctor = typeof genFun === "function" && genFun.constructor;
    return ctor
      ? ctor === GeneratorFunction ||
        // For the native GeneratorFunction constructor, the best we can
        // do is to check its .name property.
        (ctor.displayName || ctor.name) === "GeneratorFunction"
      : false;
  };

  exports.mark = function(genFun) {
    if (Object.setPrototypeOf) {
      Object.setPrototypeOf(genFun, GeneratorFunctionPrototype);
    } else {
      genFun.__proto__ = GeneratorFunctionPrototype;
      if (!(toStringTagSymbol in genFun)) {
        genFun[toStringTagSymbol] = "GeneratorFunction";
      }
    }
    genFun.prototype = Object.create(Gp);
    return genFun;
  };

  // Within the body of any async function, `await x` is transformed to
  // `yield regeneratorRuntime.awrap(x)`, so that the runtime can test
  // `hasOwn.call(value, "__await")` to determine if the yielded value is
  // meant to be awaited.
  exports.awrap = function(arg) {
    return { __await: arg };
  };

  function AsyncIterator(generator) {
    function invoke(method, arg, resolve, reject) {
      var record = tryCatch(generator[method], generator, arg);
      if (record.type === "throw") {
        reject(record.arg);
      } else {
        var result = record.arg;
        var value = result.value;
        if (value &&
            typeof value === "object" &&
            hasOwn.call(value, "__await")) {
          return Promise.resolve(value.__await).then(function(value) {
            invoke("next", value, resolve, reject);
          }, function(err) {
            invoke("throw", err, resolve, reject);
          });
        }

        return Promise.resolve(value).then(function(unwrapped) {
          // When a yielded Promise is resolved, its final value becomes
          // the .value of the Promise<{value,done}> result for the
          // current iteration.
          result.value = unwrapped;
          resolve(result);
        }, function(error) {
          // If a rejected Promise was yielded, throw the rejection back
          // into the async generator function so it can be handled there.
          return invoke("throw", error, resolve, reject);
        });
      }
    }

    var previousPromise;

    function enqueue(method, arg) {
      function callInvokeWithMethodAndArg() {
        return new Promise(function(resolve, reject) {
          invoke(method, arg, resolve, reject);
        });
      }

      return previousPromise =
        // If enqueue has been called before, then we want to wait until
        // all previous Promises have been resolved before calling invoke,
        // so that results are always delivered in the correct order. If
        // enqueue has not been called before, then it is important to
        // call invoke immediately, without waiting on a callback to fire,
        // so that the async generator function has the opportunity to do
        // any necessary setup in a predictable way. This predictability
        // is why the Promise constructor synchronously invokes its
        // executor callback, and why async functions synchronously
        // execute code before the first await. Since we implement simple
        // async functions in terms of async generators, it is especially
        // important to get this right, even though it requires care.
        previousPromise ? previousPromise.then(
          callInvokeWithMethodAndArg,
          // Avoid propagating failures to Promises returned by later
          // invocations of the iterator.
          callInvokeWithMethodAndArg
        ) : callInvokeWithMethodAndArg();
    }

    // Define the unified helper method that is used to implement .next,
    // .throw, and .return (see defineIteratorMethods).
    this._invoke = enqueue;
  }

  defineIteratorMethods(AsyncIterator.prototype);
  AsyncIterator.prototype[asyncIteratorSymbol] = function () {
    return this;
  };
  exports.AsyncIterator = AsyncIterator;

  // Note that simple async functions are implemented on top of
  // AsyncIterator objects; they just return a Promise for the value of
  // the final result produced by the iterator.
  exports.async = function(innerFn, outerFn, self, tryLocsList) {
    var iter = new AsyncIterator(
      wrap(innerFn, outerFn, self, tryLocsList)
    );

    return exports.isGeneratorFunction(outerFn)
      ? iter // If outerFn is a generator, return the full iterator.
      : iter.next().then(function(result) {
          return result.done ? result.value : iter.next();
        });
  };

  function makeInvokeMethod(innerFn, self, context) {
    var state = GenStateSuspendedStart;

    return function invoke(method, arg) {
      if (state === GenStateExecuting) {
        throw new Error("Generator is already running");
      }

      if (state === GenStateCompleted) {
        if (method === "throw") {
          throw arg;
        }

        // Be forgiving, per 25.3.3.3.3 of the spec:
        // https://people.mozilla.org/~jorendorff/es6-draft.html#sec-generatorresume
        return doneResult();
      }

      context.method = method;
      context.arg = arg;

      while (true) {
        var delegate = context.delegate;
        if (delegate) {
          var delegateResult = maybeInvokeDelegate(delegate, context);
          if (delegateResult) {
            if (delegateResult === ContinueSentinel) continue;
            return delegateResult;
          }
        }

        if (context.method === "next") {
          // Setting context._sent for legacy support of Babel's
          // function.sent implementation.
          context.sent = context._sent = context.arg;

        } else if (context.method === "throw") {
          if (state === GenStateSuspendedStart) {
            state = GenStateCompleted;
            throw context.arg;
          }

          context.dispatchException(context.arg);

        } else if (context.method === "return") {
          context.abrupt("return", context.arg);
        }

        state = GenStateExecuting;

        var record = tryCatch(innerFn, self, context);
        if (record.type === "normal") {
          // If an exception is thrown from innerFn, we leave state ===
          // GenStateExecuting and loop back for another invocation.
          state = context.done
            ? GenStateCompleted
            : GenStateSuspendedYield;

          if (record.arg === ContinueSentinel) {
            continue;
          }

          return {
            value: record.arg,
            done: context.done
          };

        } else if (record.type === "throw") {
          state = GenStateCompleted;
          // Dispatch the exception by looping back around to the
          // context.dispatchException(context.arg) call above.
          context.method = "throw";
          context.arg = record.arg;
        }
      }
    };
  }

  // Call delegate.iterator[context.method](context.arg) and handle the
  // result, either by returning a { value, done } result from the
  // delegate iterator, or by modifying context.method and context.arg,
  // setting context.delegate to null, and returning the ContinueSentinel.
  function maybeInvokeDelegate(delegate, context) {
    var method = delegate.iterator[context.method];
    if (method === undefined) {
      // A .throw or .return when the delegate iterator has no .throw
      // method always terminates the yield* loop.
      context.delegate = null;

      if (context.method === "throw") {
        // Note: ["return"] must be used for ES3 parsing compatibility.
        if (delegate.iterator["return"]) {
          // If the delegate iterator has a return method, give it a
          // chance to clean up.
          context.method = "return";
          context.arg = undefined;
          maybeInvokeDelegate(delegate, context);

          if (context.method === "throw") {
            // If maybeInvokeDelegate(context) changed context.method from
            // "return" to "throw", let that override the TypeError below.
            return ContinueSentinel;
          }
        }

        context.method = "throw";
        context.arg = new TypeError(
          "The iterator does not provide a 'throw' method");
      }

      return ContinueSentinel;
    }

    var record = tryCatch(method, delegate.iterator, context.arg);

    if (record.type === "throw") {
      context.method = "throw";
      context.arg = record.arg;
      context.delegate = null;
      return ContinueSentinel;
    }

    var info = record.arg;

    if (! info) {
      context.method = "throw";
      context.arg = new TypeError("iterator result is not an object");
      context.delegate = null;
      return ContinueSentinel;
    }

    if (info.done) {
      // Assign the result of the finished delegate to the temporary
      // variable specified by delegate.resultName (see delegateYield).
      context[delegate.resultName] = info.value;

      // Resume execution at the desired location (see delegateYield).
      context.next = delegate.nextLoc;

      // If context.method was "throw" but the delegate handled the
      // exception, let the outer generator proceed normally. If
      // context.method was "next", forget context.arg since it has been
      // "consumed" by the delegate iterator. If context.method was
      // "return", allow the original .return call to continue in the
      // outer generator.
      if (context.method !== "return") {
        context.method = "next";
        context.arg = undefined;
      }

    } else {
      // Re-yield the result returned by the delegate method.
      return info;
    }

    // The delegate iterator is finished, so forget it and continue with
    // the outer generator.
    context.delegate = null;
    return ContinueSentinel;
  }

  // Define Generator.prototype.{next,throw,return} in terms of the
  // unified ._invoke helper method.
  defineIteratorMethods(Gp);

  Gp[toStringTagSymbol] = "Generator";

  // A Generator should always return itself as the iterator object when the
  // @@iterator function is called on it. Some browsers' implementations of the
  // iterator prototype chain incorrectly implement this, causing the Generator
  // object to not be returned from this call. This ensures that doesn't happen.
  // See https://github.com/facebook/regenerator/issues/274 for more details.
  Gp[iteratorSymbol] = function() {
    return this;
  };

  Gp.toString = function() {
    return "[object Generator]";
  };

  function pushTryEntry(locs) {
    var entry = { tryLoc: locs[0] };

    if (1 in locs) {
      entry.catchLoc = locs[1];
    }

    if (2 in locs) {
      entry.finallyLoc = locs[2];
      entry.afterLoc = locs[3];
    }

    this.tryEntries.push(entry);
  }

  function resetTryEntry(entry) {
    var record = entry.completion || {};
    record.type = "normal";
    delete record.arg;
    entry.completion = record;
  }

  function Context(tryLocsList) {
    // The root entry object (effectively a try statement without a catch
    // or a finally block) gives us a place to store values thrown from
    // locations where there is no enclosing try statement.
    this.tryEntries = [{ tryLoc: "root" }];
    tryLocsList.forEach(pushTryEntry, this);
    this.reset(true);
  }

  exports.keys = function(object) {
    var keys = [];
    for (var key in object) {
      keys.push(key);
    }
    keys.reverse();

    // Rather than returning an object with a next method, we keep
    // things simple and return the next function itself.
    return function next() {
      while (keys.length) {
        var key = keys.pop();
        if (key in object) {
          next.value = key;
          next.done = false;
          return next;
        }
      }

      // To avoid creating an additional object, we just hang the .value
      // and .done properties off the next function object itself. This
      // also ensures that the minifier will not anonymize the function.
      next.done = true;
      return next;
    };
  };

  function values(iterable) {
    if (iterable) {
      var iteratorMethod = iterable[iteratorSymbol];
      if (iteratorMethod) {
        return iteratorMethod.call(iterable);
      }

      if (typeof iterable.next === "function") {
        return iterable;
      }

      if (!isNaN(iterable.length)) {
        var i = -1, next = function next() {
          while (++i < iterable.length) {
            if (hasOwn.call(iterable, i)) {
              next.value = iterable[i];
              next.done = false;
              return next;
            }
          }

          next.value = undefined;
          next.done = true;

          return next;
        };

        return next.next = next;
      }
    }

    // Return an iterator with no values.
    return { next: doneResult };
  }
  exports.values = values;

  function doneResult() {
    return { value: undefined, done: true };
  }

  Context.prototype = {
    constructor: Context,

    reset: function(skipTempReset) {
      this.prev = 0;
      this.next = 0;
      // Resetting context._sent for legacy support of Babel's
      // function.sent implementation.
      this.sent = this._sent = undefined;
      this.done = false;
      this.delegate = null;

      this.method = "next";
      this.arg = undefined;

      this.tryEntries.forEach(resetTryEntry);

      if (!skipTempReset) {
        for (var name in this) {
          // Not sure about the optimal order of these conditions:
          if (name.charAt(0) === "t" &&
              hasOwn.call(this, name) &&
              !isNaN(+name.slice(1))) {
            this[name] = undefined;
          }
        }
      }
    },

    stop: function() {
      this.done = true;

      var rootEntry = this.tryEntries[0];
      var rootRecord = rootEntry.completion;
      if (rootRecord.type === "throw") {
        throw rootRecord.arg;
      }

      return this.rval;
    },

    dispatchException: function(exception) {
      if (this.done) {
        throw exception;
      }

      var context = this;
      function handle(loc, caught) {
        record.type = "throw";
        record.arg = exception;
        context.next = loc;

        if (caught) {
          // If the dispatched exception was caught by a catch block,
          // then let that catch block handle the exception normally.
          context.method = "next";
          context.arg = undefined;
        }

        return !! caught;
      }

      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        var record = entry.completion;

        if (entry.tryLoc === "root") {
          // Exception thrown outside of any try block that could handle
          // it, so set the completion value of the entire function to
          // throw the exception.
          return handle("end");
        }

        if (entry.tryLoc <= this.prev) {
          var hasCatch = hasOwn.call(entry, "catchLoc");
          var hasFinally = hasOwn.call(entry, "finallyLoc");

          if (hasCatch && hasFinally) {
            if (this.prev < entry.catchLoc) {
              return handle(entry.catchLoc, true);
            } else if (this.prev < entry.finallyLoc) {
              return handle(entry.finallyLoc);
            }

          } else if (hasCatch) {
            if (this.prev < entry.catchLoc) {
              return handle(entry.catchLoc, true);
            }

          } else if (hasFinally) {
            if (this.prev < entry.finallyLoc) {
              return handle(entry.finallyLoc);
            }

          } else {
            throw new Error("try statement without catch or finally");
          }
        }
      }
    },

    abrupt: function(type, arg) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        if (entry.tryLoc <= this.prev &&
            hasOwn.call(entry, "finallyLoc") &&
            this.prev < entry.finallyLoc) {
          var finallyEntry = entry;
          break;
        }
      }

      if (finallyEntry &&
          (type === "break" ||
           type === "continue") &&
          finallyEntry.tryLoc <= arg &&
          arg <= finallyEntry.finallyLoc) {
        // Ignore the finally entry if control is not jumping to a
        // location outside the try/catch block.
        finallyEntry = null;
      }

      var record = finallyEntry ? finallyEntry.completion : {};
      record.type = type;
      record.arg = arg;

      if (finallyEntry) {
        this.method = "next";
        this.next = finallyEntry.finallyLoc;
        return ContinueSentinel;
      }

      return this.complete(record);
    },

    complete: function(record, afterLoc) {
      if (record.type === "throw") {
        throw record.arg;
      }

      if (record.type === "break" ||
          record.type === "continue") {
        this.next = record.arg;
      } else if (record.type === "return") {
        this.rval = this.arg = record.arg;
        this.method = "return";
        this.next = "end";
      } else if (record.type === "normal" && afterLoc) {
        this.next = afterLoc;
      }

      return ContinueSentinel;
    },

    finish: function(finallyLoc) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        if (entry.finallyLoc === finallyLoc) {
          this.complete(entry.completion, entry.afterLoc);
          resetTryEntry(entry);
          return ContinueSentinel;
        }
      }
    },

    "catch": function(tryLoc) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        if (entry.tryLoc === tryLoc) {
          var record = entry.completion;
          if (record.type === "throw") {
            var thrown = record.arg;
            resetTryEntry(entry);
          }
          return thrown;
        }
      }

      // The context.catch method must only be called with a location
      // argument that corresponds to a known catch block.
      throw new Error("illegal catch attempt");
    },

    delegateYield: function(iterable, resultName, nextLoc) {
      this.delegate = {
        iterator: values(iterable),
        resultName: resultName,
        nextLoc: nextLoc
      };

      if (this.method === "next") {
        // Deliberately forget the last sent value so that we don't
        // accidentally pass it on to the delegate.
        this.arg = undefined;
      }

      return ContinueSentinel;
    }
  };

  // Regardless of whether this script is executing as a CommonJS module
  // or not, return the runtime object so that we can declare the variable
  // regeneratorRuntime in the outer scope, which allows this module to be
  // injected easily by `bin/regenerator --include-runtime script.js`.
  return exports;

}(
  // If this script is executing as a CommonJS module, use module.exports
  // as the regeneratorRuntime namespace. Otherwise create a new empty
  // object. Either way, the resulting object will be used to initialize
  // the regeneratorRuntime variable at the top of this file.
   true ? module.exports : undefined
));

try {
  regeneratorRuntime = runtime;
} catch (accidentalStrictMode) {
  // This module should not be running in strict mode, so the above
  // assignment should always work unless something is misconfigured. Just
  // in case runtime.js accidentally runs in strict mode, we can escape
  // strict mode using a global Function call. This could conceivably fail
  // if a Content Security Policy forbids using Function, but in that case
  // the proper solution is to fix the accidental strict mode problem. If
  // you've misconfigured your bundler to force strict mode and applied a
  // CSP to forbid Function, and you're not willing to fix either of those
  // problems, please detail your unique predicament in a GitHub issue.
  Function("r", "regeneratorRuntime = r")(runtime);
}


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/OsProdutoComponent.vue?vue&type=template&id=d51a349a&":
/*!*********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/OsProdutoComponent.vue?vue&type=template&id=d51a349a& ***!
  \*********************************************************************************************************************************************************************************************************************/
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
              staticClass: "form-control selectpicker",
              attrs: {
                "data-style": "btn-secondary",
                "data-title": "Nada Selecionado",
                "data-live-search": "true",
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
                  _vm._l(_vm.produtos, function(item, index) {
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
                            name: "produtos[" + index + "][produto_id]"
                          },
                          domProps: { value: item.id }
                        }),
                        _vm._v(" "),
                        _c("input", {
                          attrs: {
                            type: "hidden",
                            name:
                              "produtos[" + index + "][produto_vencimento_id]"
                          },
                          domProps: { value: item.produto_vencimento_id }
                        })
                      ]),
                      _vm._v(" "),
                      _c("td", { staticClass: "col-md-5" }, [
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
                            _vm._s(_vm._f("toDecimal3")(item.quantidade)) +
                            " \n                            "
                        ),
                        _c("input", {
                          attrs: {
                            type: "hidden",
                            name: "produtos[" + index + "][quantidade]"
                          },
                          domProps: { value: item.quantidade }
                        })
                      ]),
                      _vm._v(" "),
                      _c("td", { staticClass: "col-md-1 text-right" }, [
                        _vm._v(
                          "\n                            " +
                            _vm._s(_vm._f("toDecimal3")(item.valor_produto)) +
                            "\n                            "
                        ),
                        _c("input", {
                          attrs: {
                            type: "hidden",
                            name: "produtos[" + index + "][valor_produto]"
                          },
                          domProps: { value: item.valor_produto }
                        })
                      ]),
                      _vm._v(" "),
                      _c("td", { staticClass: "col-md-1 text-right" }, [
                        _vm._v(
                          "\n                            " +
                            _vm._s(_vm._f("toDecimal3")(item.valor_desconto)) +
                            "\n                            "
                        ),
                        _c("input", {
                          attrs: {
                            type: "hidden",
                            name: "produtos[" + index + "][valor_desconto]"
                          },
                          domProps: { value: item.valor_desconto }
                        })
                      ]),
                      _vm._v(" "),
                      _c("td", { staticClass: "col-md-1 text-right" }, [
                        _vm._v(
                          "\n                            " +
                            _vm._s(_vm._f("toDecimal3")(item.valor_acrescimo)) +
                            "\n                            "
                        ),
                        _c("input", {
                          attrs: {
                            type: "hidden",
                            name: "produtos[" + index + "][valor_acrescimo]"
                          },
                          domProps: { value: item.valor_acrescimo }
                        })
                      ]),
                      _vm._v(" "),
                      _c("td", { staticClass: "col-md-1 text-right" }, [
                        _vm._v(
                          "\n                            " +
                            _vm._s(_vm._f("toDecimal3")(item.valor_cobrado)) +
                            "\n                            "
                        ),
                        _c("input", {
                          attrs: {
                            type: "hidden",
                            name: "produtos[" + index + "][valor_cobrado]"
                          },
                          domProps: { value: item.valor_cobrado }
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
                              "data-target": "#confirmDelete2"
                            },
                            on: {
                              click: function($event) {
                                return _vm.confirmDeleteProduto(index)
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
                this.produtos.length > 0
                  ? _c("tfoot", [
                      _c("tr", { staticClass: "row m-0" }, [
                        _c("td", { staticClass: "col-md-1" }, [
                          _c("strong", [_vm._v(_vm._s(this.produtos.length))])
                        ]),
                        _vm._v(" "),
                        _c("td", { staticClass: "col-md-5" }),
                        _vm._v(" "),
                        _c("td", { staticClass: "col-md-1 text-right" }, [
                          _c("strong", [
                            _vm._v(
                              _vm._s(
                                _vm._f("toDecimal3")(this.totalQuantidade())
                              )
                            )
                          ])
                        ]),
                        _vm._v(" "),
                        _c("td", { staticClass: "col-md-1 text-right" }, [
                          _c("strong", [
                            _vm._v(
                              _vm._s(_vm._f("toDecimal3")(this.totalValor()))
                            )
                          ])
                        ]),
                        _vm._v(" "),
                        _c("td", { staticClass: "col-md-1 text-right" }, [
                          _c("strong", [
                            _vm._v(
                              _vm._s(_vm._f("toDecimal3")(this.totalDesconto()))
                            )
                          ])
                        ]),
                        _vm._v(" "),
                        _c("td", { staticClass: "col-md-1 text-right" }, [
                          _c("strong", [
                            _vm._v(
                              _vm._s(
                                _vm._f("toDecimal3")(this.totalAcrescimo())
                              )
                            )
                          ])
                        ]),
                        _vm._v(" "),
                        _c("td", { staticClass: "col-md-1 text-right" }, [
                          _c("strong", [
                            _vm._v(
                              _vm._s(_vm._f("toDecimal3")(this.totalCobrado()))
                            )
                          ])
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
        _c("div", [
          _c("div", { staticClass: "row m-0" }, [
            _c(
              "div",
              {
                class: {
                  "col-md-6": true,
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
                      "data-style": "btn-secondary",
                      disabled:
                        _vm.estoqueId == "false" || _vm.estoqueId == null,
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
                      _vm._v("Produto")
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
                      value: _vm.valor_unitario,
                      expression: "valor_unitario",
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
                    id: "inputValorUnitario",
                    readonly: ""
                  },
                  domProps: { value: _vm.valor_unitario },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.valor_unitario = _vm._n($event.target.value)
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
                      value: _vm.valor_acrescimo,
                      expression: "valor_acrescimo",
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
                  domProps: { value: _vm.valor_acrescimo },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.valor_acrescimo = _vm._n($event.target.value)
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
                      value: _vm.valor_desconto,
                      expression: "valor_desconto",
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
                  domProps: { value: _vm.valor_desconto },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.valor_desconto = _vm._n($event.target.value)
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
                  " has-error": this.errors.inputValorCobrado
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
                      value: _vm.valor_cobrado,
                      expression: "valor_cobrado",
                      modifiers: { number: true }
                    }
                  ],
                  ref: "inputValorCobrado",
                  staticClass: "form-control",
                  attrs: {
                    disabled: _vm.estoqueId == "false" || _vm.estoqueId == null,
                    type: "number",
                    min: "0,000",
                    max: "9999999999,999",
                    step: "any",
                    name: "inputValorCobrado",
                    id: "inputValorCobrado",
                    readonly: ""
                  },
                  domProps: { value: _vm.valor_cobrado },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.valor_cobrado = _vm._n($event.target.value)
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
                    attrs: { "v-if": this.errors.inputValorCobrado }
                  },
                  [
                    _c("strong", [
                      _vm._v(_vm._s(this.errors.inputValorCobradoMsg))
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
        _c("modal2", {
          attrs: {
            "modal-title": "Corfirmação",
            "modal-text": "Confirma a remoção deste Item?"
          },
          on: { cancel2: _vm.cancelDelete, confirm2: _vm.deleteProduto }
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
        _c("th", { staticClass: "col-md-5" }, [_vm._v("Produto")]),
        _vm._v(" "),
        _c("th", { staticClass: "col-md-1" }, [_vm._v("Qtd")]),
        _vm._v(" "),
        _c("th", { staticClass: "col-md-1" }, [_vm._v("R$ Un.")]),
        _vm._v(" "),
        _c("th", { staticClass: "col-md-1" }, [_vm._v("R$ Acrés.")]),
        _vm._v(" "),
        _c("th", { staticClass: "col-md-1" }, [_vm._v("R$ Desc.")]),
        _vm._v(" "),
        _c("th", { staticClass: "col-md-1" }, [_vm._v("R$ Final")]),
        _vm._v(" "),
        _c("th", { staticClass: "col-md-1" }, [_vm._v("Ações")])
      ])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/OsServicoComponent.vue?vue&type=template&id=49f03fad&":
/*!*********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/OsServicoComponent.vue?vue&type=template&id=49f03fad& ***!
  \*********************************************************************************************************************************************************************************************************************/
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
                _vm._l(_vm.servicosSelecionados, function(item, index) {
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
                          name: "servicos[" + index + "][servico_id]"
                        },
                        domProps: { value: item.id }
                      })
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "col-md-6" }, [
                      _vm._v(
                        "\n                        " +
                          _vm._s(item.servico) +
                          "\n                    "
                      )
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "col-md-1 pool-right" }, [
                      _vm._v(
                        "\n                        " +
                          _vm._s(_vm._f("toDecimal3")(item.valor_servico)) +
                          "\n                        "
                      ),
                      _c("input", {
                        attrs: {
                          type: "hidden",
                          name: "servicos[" + index + "][valor_servico]"
                        },
                        domProps: { value: item.valor_servico }
                      })
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "col-md-1 pool-right" }, [
                      _vm._v(
                        "\n                        " +
                          _vm._s(_vm._f("toDecimal3")(item.valor_acrescimo)) +
                          "\n                        "
                      ),
                      _c("input", {
                        attrs: {
                          type: "hidden",
                          name: "servicos[" + index + "][valor_acrescimo]"
                        },
                        domProps: { value: item.valor_acrescimo }
                      })
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "col-md-1 pool-right" }, [
                      _vm._v(
                        "\n                        " +
                          _vm._s(_vm._f("toDecimal3")(item.valor_desconto)) +
                          "\n                        "
                      ),
                      _c("input", {
                        attrs: {
                          type: "hidden",
                          name: "servicos[" + index + "][valor_desconto]"
                        },
                        domProps: { value: item.valor_desconto }
                      })
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "col-md-1 pool-right" }, [
                      _vm._v(
                        "\n                        " +
                          _vm._s(_vm._f("toDecimal3")(item.valor_cobrado)) +
                          "\n                        "
                      ),
                      _c("input", {
                        attrs: {
                          type: "hidden",
                          name: "servicos[" + index + "][valor_cobrado]"
                        },
                        domProps: { value: item.valor_cobrado }
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
      _c("div", { staticClass: "panel-footer" }, [
        _c("div", { staticClass: "row m-0" }, [
          _c(
            "div",
            {
              class: {
                "col-md-7": true,
                " has-error": this.errors.inputServicos
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
                      value: _vm.servico_id,
                      expression: "servico_id"
                    }
                  ],
                  ref: "inputServicos",
                  staticClass: "form-control selectpicker",
                  attrs: {
                    "data-style": "btn-secondary",
                    "data-live-search": "true",
                    name: "inputServicos",
                    id: "inputServicos"
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
                      _vm.servico_id = $event.target.multiple
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
                  _vm._l(_vm.servicosDisponiveisOrdenados, function(
                    servico,
                    index
                  ) {
                    return _c(
                      "option",
                      { key: index, domProps: { value: servico.id } },
                      [_vm._v(_vm._s(servico.id + " - " + servico.servico))]
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
                  attrs: { "v-if": this.errors.inputServicos }
                },
                [_c("strong", [_vm._v(_vm._s(this.errors.inputServicosMsg))])]
              )
            ]
          ),
          _vm._v(" "),
          _c(
            "div",
            {
              class: {
                "col-md-1": true,
                " has-error": this.errors.inputValorServico
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
                    value: _vm.valor_servico,
                    expression: "valor_servico",
                    modifiers: { number: true }
                  }
                ],
                ref: "inputValorServico",
                staticClass: "form-control",
                attrs: {
                  type: "number",
                  min: "0,000",
                  max: "9999999999,999",
                  step: "any",
                  name: "inputValorServico",
                  id: "inputValorServico",
                  readonly: ""
                },
                domProps: { value: _vm.valor_servico },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.valor_servico = _vm._n($event.target.value)
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
                  attrs: { "v-if": this.errors.inputValorServico }
                },
                [
                  _c("strong", [
                    _vm._v(_vm._s(this.errors.inputValorServicoMsg))
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
                " has-error": this.errors.inputValorAcrescimo
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
                    value: _vm.valor_acrescimo,
                    expression: "valor_acrescimo",
                    modifiers: { number: true }
                  }
                ],
                ref: "inputValorAcrescimo",
                staticClass: "form-control",
                attrs: {
                  type: "number",
                  min: "0,000",
                  max: "9999999999,999",
                  step: "any",
                  name: "inputValorAcrescimo",
                  id: "inputValorAcrescimo"
                },
                domProps: { value: _vm.valor_acrescimo },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.valor_acrescimo = _vm._n($event.target.value)
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
                  attrs: { "v-if": this.errors.inputValorAcrescimo }
                },
                [
                  _c("strong", [
                    _vm._v(_vm._s(this.errors.inputValorAcrescimoMsg))
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
                " has-error": this.errors.inputValorDesconto
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
                    value: _vm.valor_desconto,
                    expression: "valor_desconto",
                    modifiers: { number: true }
                  }
                ],
                ref: "inputValorDesconto",
                staticClass: "form-control",
                attrs: {
                  type: "number",
                  min: "0,000",
                  max: "9999999999,999",
                  step: "any",
                  name: "inputValorDesconto",
                  id: "inputValorDesconto"
                },
                domProps: { value: _vm.valor_desconto },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.valor_desconto = _vm._n($event.target.value)
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
                  attrs: { "v-if": this.errors.inputValorDesconto }
                },
                [
                  _c("strong", [
                    _vm._v(_vm._s(this.errors.inputValorDescontoMsg))
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
                " has-error": this.errors.inputValorValorCobrado
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
                    value: _vm.valor_cobrado,
                    expression: "valor_cobrado",
                    modifiers: { number: true }
                  }
                ],
                ref: "inputValorValorCobrado",
                staticClass: "form-control",
                attrs: {
                  type: "number",
                  min: "0,000",
                  max: "9999999999,999",
                  step: "any",
                  name: "inputValorValorCobrado",
                  id: "inputValorValorCobrado",
                  readonly: ""
                },
                domProps: { value: _vm.valor_cobrado },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.valor_cobrado = _vm._n($event.target.value)
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
                  attrs: { "v-if": this.errors.inputValorValorCobrado }
                },
                [
                  _c("strong", [
                    _vm._v(_vm._s(this.errors.inputValorValorCobradoMsg))
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
                attrs: { type: "button" },
                on: { click: _vm.addServico }
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
                on: { click: _vm.updateServico }
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
      _c("strong", [_vm._v("Servicos")])
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
        _c("th", { staticClass: "col-md-6" }, [_vm._v("Serviço")]),
        _vm._v(" "),
        _c("th", { staticClass: "col-md-1" }, [_vm._v("R$ Serv.")]),
        _vm._v(" "),
        _c("th", { staticClass: "col-md-1" }, [_vm._v("R$ Acrés.")]),
        _vm._v(" "),
        _c("th", { staticClass: "col-md-1" }, [_vm._v("R$ Desc.")]),
        _vm._v(" "),
        _c("th", { staticClass: "col-md-1" }, [_vm._v("R$ Final")]),
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/modal2.vue?vue&type=template&id=a9f5daa0&":
/*!*********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/modal2.vue?vue&type=template&id=a9f5daa0& ***!
  \*********************************************************************************************************************************************************************************************************/
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
          id: "confirmDelete2",
          role: "dialog",
          "aria-labelledby": "confirmDeleteLabel",
          "aria-hidden": "true"
        }
      },
      [
        _c("div", { staticClass: "modal-dialog" }, [
          _c("div", { staticClass: "modal-content modal-default" }, [
            _c("div", { staticClass: "modal-header" }, [
              _c(
                "button",
                {
                  staticClass: "close",
                  attrs: {
                    type: "button",
                    "data-dismiss": "modal2",
                    "aria-hidden": "true"
                  }
                },
                [_vm._v("×")]
              ),
              _vm._v(" "),
              _c("div", { staticClass: "row" }, [
                _c("div", { staticClass: "col-sm-1" }, [
                  _c("span", { staticClass: "glyphicon glyphicon-alert" })
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col" }, [
                  _c("h4", { staticClass: "modal-title" }, [
                    _c("strong", [_vm._v(_vm._s(this.modalTitle))])
                  ])
                ])
              ])
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
                    id: "confirm2"
                  },
                  on: { click: _vm.confirm2 }
                },
                [_vm._v("Remover")]
              ),
              _vm._v(" "),
              _c(
                "button",
                {
                  staticClass: "btn btn-primary",
                  attrs: { type: "button", "data-dismiss": "modal" },
                  on: { click: _vm.cancel2 }
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

/***/ "./resources/js/components/OsProdutoComponent.vue":
/*!********************************************************!*\
  !*** ./resources/js/components/OsProdutoComponent.vue ***!
  \********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _OsProdutoComponent_vue_vue_type_template_id_d51a349a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./OsProdutoComponent.vue?vue&type=template&id=d51a349a& */ "./resources/js/components/OsProdutoComponent.vue?vue&type=template&id=d51a349a&");
/* harmony import */ var _OsProdutoComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./OsProdutoComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/OsProdutoComponent.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _OsProdutoComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _OsProdutoComponent_vue_vue_type_template_id_d51a349a___WEBPACK_IMPORTED_MODULE_0__["render"],
  _OsProdutoComponent_vue_vue_type_template_id_d51a349a___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/OsProdutoComponent.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/OsProdutoComponent.vue?vue&type=script&lang=js&":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/OsProdutoComponent.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_OsProdutoComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./OsProdutoComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/OsProdutoComponent.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_OsProdutoComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/OsProdutoComponent.vue?vue&type=template&id=d51a349a&":
/*!***************************************************************************************!*\
  !*** ./resources/js/components/OsProdutoComponent.vue?vue&type=template&id=d51a349a& ***!
  \***************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_OsProdutoComponent_vue_vue_type_template_id_d51a349a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./OsProdutoComponent.vue?vue&type=template&id=d51a349a& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/OsProdutoComponent.vue?vue&type=template&id=d51a349a&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_OsProdutoComponent_vue_vue_type_template_id_d51a349a___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_OsProdutoComponent_vue_vue_type_template_id_d51a349a___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/OsServicoComponent.vue":
/*!********************************************************!*\
  !*** ./resources/js/components/OsServicoComponent.vue ***!
  \********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _OsServicoComponent_vue_vue_type_template_id_49f03fad___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./OsServicoComponent.vue?vue&type=template&id=49f03fad& */ "./resources/js/components/OsServicoComponent.vue?vue&type=template&id=49f03fad&");
/* harmony import */ var _OsServicoComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./OsServicoComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/OsServicoComponent.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _OsServicoComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _OsServicoComponent_vue_vue_type_template_id_49f03fad___WEBPACK_IMPORTED_MODULE_0__["render"],
  _OsServicoComponent_vue_vue_type_template_id_49f03fad___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/OsServicoComponent.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/OsServicoComponent.vue?vue&type=script&lang=js&":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/OsServicoComponent.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_OsServicoComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./OsServicoComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/OsServicoComponent.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_OsServicoComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/OsServicoComponent.vue?vue&type=template&id=49f03fad&":
/*!***************************************************************************************!*\
  !*** ./resources/js/components/OsServicoComponent.vue?vue&type=template&id=49f03fad& ***!
  \***************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_OsServicoComponent_vue_vue_type_template_id_49f03fad___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./OsServicoComponent.vue?vue&type=template&id=49f03fad& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/OsServicoComponent.vue?vue&type=template&id=49f03fad&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_OsServicoComponent_vue_vue_type_template_id_49f03fad___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_OsServicoComponent_vue_vue_type_template_id_49f03fad___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



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

/***/ "./resources/js/components/modal2.vue":
/*!********************************************!*\
  !*** ./resources/js/components/modal2.vue ***!
  \********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _modal2_vue_vue_type_template_id_a9f5daa0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./modal2.vue?vue&type=template&id=a9f5daa0& */ "./resources/js/components/modal2.vue?vue&type=template&id=a9f5daa0&");
/* harmony import */ var _modal2_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./modal2.vue?vue&type=script&lang=js& */ "./resources/js/components/modal2.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _modal2_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _modal2_vue_vue_type_template_id_a9f5daa0___WEBPACK_IMPORTED_MODULE_0__["render"],
  _modal2_vue_vue_type_template_id_a9f5daa0___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/modal2.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/modal2.vue?vue&type=script&lang=js&":
/*!*********************************************************************!*\
  !*** ./resources/js/components/modal2.vue?vue&type=script&lang=js& ***!
  \*********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_modal2_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./modal2.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/modal2.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_modal2_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/modal2.vue?vue&type=template&id=a9f5daa0&":
/*!***************************************************************************!*\
  !*** ./resources/js/components/modal2.vue?vue&type=template&id=a9f5daa0& ***!
  \***************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_modal2_vue_vue_type_template_id_a9f5daa0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./modal2.vue?vue&type=template&id=a9f5daa0& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/modal2.vue?vue&type=template&id=a9f5daa0&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_modal2_vue_vue_type_template_id_a9f5daa0___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_modal2_vue_vue_type_template_id_a9f5daa0___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/osservico.js":
/*!***********************************!*\
  !*** ./resources/js/osservico.js ***!
  \***********************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _components_OsServicoComponent_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./components/OsServicoComponent.vue */ "./resources/js/components/OsServicoComponent.vue");
/* harmony import */ var _components_OsProdutoComponent_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./components/OsProdutoComponent.vue */ "./resources/js/components/OsProdutoComponent.vue");


var os = new Vue({
  el: '#os_servicos',
  components: {
    ordem_servico_servico: _components_OsServicoComponent_vue__WEBPACK_IMPORTED_MODULE_0__["default"],
    ordem_servico_produto: _components_OsProdutoComponent_vue__WEBPACK_IMPORTED_MODULE_1__["default"]
  }
});

/***/ }),

/***/ 7:
/*!*****************************************!*\
  !*** multi ./resources/js/osservico.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\wamp\www\goldenfrota\resources\js\osservico.js */"./resources/js/osservico.js");


/***/ })

/******/ });