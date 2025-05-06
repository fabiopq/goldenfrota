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

/***/ "./node_modules/axios/index.js":
/*!*************************************!*\
  !*** ./node_modules/axios/index.js ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! ./lib/axios */ "./node_modules/axios/lib/axios.js");

/***/ }),

/***/ "./node_modules/axios/lib/adapters/xhr.js":
/*!************************************************!*\
  !*** ./node_modules/axios/lib/adapters/xhr.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");
var settle = __webpack_require__(/*! ./../core/settle */ "./node_modules/axios/lib/core/settle.js");
var buildURL = __webpack_require__(/*! ./../helpers/buildURL */ "./node_modules/axios/lib/helpers/buildURL.js");
var parseHeaders = __webpack_require__(/*! ./../helpers/parseHeaders */ "./node_modules/axios/lib/helpers/parseHeaders.js");
var isURLSameOrigin = __webpack_require__(/*! ./../helpers/isURLSameOrigin */ "./node_modules/axios/lib/helpers/isURLSameOrigin.js");
var createError = __webpack_require__(/*! ../core/createError */ "./node_modules/axios/lib/core/createError.js");

module.exports = function xhrAdapter(config) {
  return new Promise(function dispatchXhrRequest(resolve, reject) {
    var requestData = config.data;
    var requestHeaders = config.headers;

    if (utils.isFormData(requestData)) {
      delete requestHeaders['Content-Type']; // Let the browser set it
    }

    var request = new XMLHttpRequest();

    // HTTP basic authentication
    if (config.auth) {
      var username = config.auth.username || '';
      var password = config.auth.password || '';
      requestHeaders.Authorization = 'Basic ' + btoa(username + ':' + password);
    }

    request.open(config.method.toUpperCase(), buildURL(config.url, config.params, config.paramsSerializer), true);

    // Set the request timeout in MS
    request.timeout = config.timeout;

    // Listen for ready state
    request.onreadystatechange = function handleLoad() {
      if (!request || request.readyState !== 4) {
        return;
      }

      // The request errored out and we didn't get a response, this will be
      // handled by onerror instead
      // With one exception: request that using file: protocol, most browsers
      // will return status as 0 even though it's a successful request
      if (request.status === 0 && !(request.responseURL && request.responseURL.indexOf('file:') === 0)) {
        return;
      }

      // Prepare the response
      var responseHeaders = 'getAllResponseHeaders' in request ? parseHeaders(request.getAllResponseHeaders()) : null;
      var responseData = !config.responseType || config.responseType === 'text' ? request.responseText : request.response;
      var response = {
        data: responseData,
        status: request.status,
        statusText: request.statusText,
        headers: responseHeaders,
        config: config,
        request: request
      };

      settle(resolve, reject, response);

      // Clean up request
      request = null;
    };

    // Handle low level network errors
    request.onerror = function handleError() {
      // Real errors are hidden from us by the browser
      // onerror should only fire if it's a network error
      reject(createError('Network Error', config, null, request));

      // Clean up request
      request = null;
    };

    // Handle timeout
    request.ontimeout = function handleTimeout() {
      reject(createError('timeout of ' + config.timeout + 'ms exceeded', config, 'ECONNABORTED',
        request));

      // Clean up request
      request = null;
    };

    // Add xsrf header
    // This is only done if running in a standard browser environment.
    // Specifically not if we're in a web worker, or react-native.
    if (utils.isStandardBrowserEnv()) {
      var cookies = __webpack_require__(/*! ./../helpers/cookies */ "./node_modules/axios/lib/helpers/cookies.js");

      // Add xsrf header
      var xsrfValue = (config.withCredentials || isURLSameOrigin(config.url)) && config.xsrfCookieName ?
          cookies.read(config.xsrfCookieName) :
          undefined;

      if (xsrfValue) {
        requestHeaders[config.xsrfHeaderName] = xsrfValue;
      }
    }

    // Add headers to the request
    if ('setRequestHeader' in request) {
      utils.forEach(requestHeaders, function setRequestHeader(val, key) {
        if (typeof requestData === 'undefined' && key.toLowerCase() === 'content-type') {
          // Remove Content-Type if data is undefined
          delete requestHeaders[key];
        } else {
          // Otherwise add header to the request
          request.setRequestHeader(key, val);
        }
      });
    }

    // Add withCredentials to request if needed
    if (config.withCredentials) {
      request.withCredentials = true;
    }

    // Add responseType to request if needed
    if (config.responseType) {
      try {
        request.responseType = config.responseType;
      } catch (e) {
        // Expected DOMException thrown by browsers not compatible XMLHttpRequest Level 2.
        // But, this can be suppressed for 'json' type as it can be parsed by default 'transformResponse' function.
        if (config.responseType !== 'json') {
          throw e;
        }
      }
    }

    // Handle progress if needed
    if (typeof config.onDownloadProgress === 'function') {
      request.addEventListener('progress', config.onDownloadProgress);
    }

    // Not all browsers support upload events
    if (typeof config.onUploadProgress === 'function' && request.upload) {
      request.upload.addEventListener('progress', config.onUploadProgress);
    }

    if (config.cancelToken) {
      // Handle cancellation
      config.cancelToken.promise.then(function onCanceled(cancel) {
        if (!request) {
          return;
        }

        request.abort();
        reject(cancel);
        // Clean up request
        request = null;
      });
    }

    if (requestData === undefined) {
      requestData = null;
    }

    // Send the request
    request.send(requestData);
  });
};


/***/ }),

/***/ "./node_modules/axios/lib/axios.js":
/*!*****************************************!*\
  !*** ./node_modules/axios/lib/axios.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ./utils */ "./node_modules/axios/lib/utils.js");
var bind = __webpack_require__(/*! ./helpers/bind */ "./node_modules/axios/lib/helpers/bind.js");
var Axios = __webpack_require__(/*! ./core/Axios */ "./node_modules/axios/lib/core/Axios.js");
var defaults = __webpack_require__(/*! ./defaults */ "./node_modules/axios/lib/defaults.js");

/**
 * Create an instance of Axios
 *
 * @param {Object} defaultConfig The default config for the instance
 * @return {Axios} A new instance of Axios
 */
function createInstance(defaultConfig) {
  var context = new Axios(defaultConfig);
  var instance = bind(Axios.prototype.request, context);

  // Copy axios.prototype to instance
  utils.extend(instance, Axios.prototype, context);

  // Copy context to instance
  utils.extend(instance, context);

  return instance;
}

// Create the default instance to be exported
var axios = createInstance(defaults);

// Expose Axios class to allow class inheritance
axios.Axios = Axios;

// Factory for creating new instances
axios.create = function create(instanceConfig) {
  return createInstance(utils.merge(defaults, instanceConfig));
};

// Expose Cancel & CancelToken
axios.Cancel = __webpack_require__(/*! ./cancel/Cancel */ "./node_modules/axios/lib/cancel/Cancel.js");
axios.CancelToken = __webpack_require__(/*! ./cancel/CancelToken */ "./node_modules/axios/lib/cancel/CancelToken.js");
axios.isCancel = __webpack_require__(/*! ./cancel/isCancel */ "./node_modules/axios/lib/cancel/isCancel.js");

// Expose all/spread
axios.all = function all(promises) {
  return Promise.all(promises);
};
axios.spread = __webpack_require__(/*! ./helpers/spread */ "./node_modules/axios/lib/helpers/spread.js");

module.exports = axios;

// Allow use of default import syntax in TypeScript
module.exports.default = axios;


/***/ }),

/***/ "./node_modules/axios/lib/cancel/Cancel.js":
/*!*************************************************!*\
  !*** ./node_modules/axios/lib/cancel/Cancel.js ***!
  \*************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * A `Cancel` is an object that is thrown when an operation is canceled.
 *
 * @class
 * @param {string=} message The message.
 */
function Cancel(message) {
  this.message = message;
}

Cancel.prototype.toString = function toString() {
  return 'Cancel' + (this.message ? ': ' + this.message : '');
};

Cancel.prototype.__CANCEL__ = true;

module.exports = Cancel;


/***/ }),

/***/ "./node_modules/axios/lib/cancel/CancelToken.js":
/*!******************************************************!*\
  !*** ./node_modules/axios/lib/cancel/CancelToken.js ***!
  \******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var Cancel = __webpack_require__(/*! ./Cancel */ "./node_modules/axios/lib/cancel/Cancel.js");

/**
 * A `CancelToken` is an object that can be used to request cancellation of an operation.
 *
 * @class
 * @param {Function} executor The executor function.
 */
function CancelToken(executor) {
  if (typeof executor !== 'function') {
    throw new TypeError('executor must be a function.');
  }

  var resolvePromise;
  this.promise = new Promise(function promiseExecutor(resolve) {
    resolvePromise = resolve;
  });

  var token = this;
  executor(function cancel(message) {
    if (token.reason) {
      // Cancellation has already been requested
      return;
    }

    token.reason = new Cancel(message);
    resolvePromise(token.reason);
  });
}

/**
 * Throws a `Cancel` if cancellation has been requested.
 */
CancelToken.prototype.throwIfRequested = function throwIfRequested() {
  if (this.reason) {
    throw this.reason;
  }
};

/**
 * Returns an object that contains a new `CancelToken` and a function that, when called,
 * cancels the `CancelToken`.
 */
CancelToken.source = function source() {
  var cancel;
  var token = new CancelToken(function executor(c) {
    cancel = c;
  });
  return {
    token: token,
    cancel: cancel
  };
};

module.exports = CancelToken;


/***/ }),

/***/ "./node_modules/axios/lib/cancel/isCancel.js":
/*!***************************************************!*\
  !*** ./node_modules/axios/lib/cancel/isCancel.js ***!
  \***************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = function isCancel(value) {
  return !!(value && value.__CANCEL__);
};


/***/ }),

/***/ "./node_modules/axios/lib/core/Axios.js":
/*!**********************************************!*\
  !*** ./node_modules/axios/lib/core/Axios.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var defaults = __webpack_require__(/*! ./../defaults */ "./node_modules/axios/lib/defaults.js");
var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");
var InterceptorManager = __webpack_require__(/*! ./InterceptorManager */ "./node_modules/axios/lib/core/InterceptorManager.js");
var dispatchRequest = __webpack_require__(/*! ./dispatchRequest */ "./node_modules/axios/lib/core/dispatchRequest.js");

/**
 * Create a new instance of Axios
 *
 * @param {Object} instanceConfig The default config for the instance
 */
function Axios(instanceConfig) {
  this.defaults = instanceConfig;
  this.interceptors = {
    request: new InterceptorManager(),
    response: new InterceptorManager()
  };
}

/**
 * Dispatch a request
 *
 * @param {Object} config The config specific for this request (merged with this.defaults)
 */
Axios.prototype.request = function request(config) {
  /*eslint no-param-reassign:0*/
  // Allow for axios('example/url'[, config]) a la fetch API
  if (typeof config === 'string') {
    config = utils.merge({
      url: arguments[0]
    }, arguments[1]);
  }

  config = utils.merge(defaults, {method: 'get'}, this.defaults, config);
  config.method = config.method.toLowerCase();

  // Hook up interceptors middleware
  var chain = [dispatchRequest, undefined];
  var promise = Promise.resolve(config);

  this.interceptors.request.forEach(function unshiftRequestInterceptors(interceptor) {
    chain.unshift(interceptor.fulfilled, interceptor.rejected);
  });

  this.interceptors.response.forEach(function pushResponseInterceptors(interceptor) {
    chain.push(interceptor.fulfilled, interceptor.rejected);
  });

  while (chain.length) {
    promise = promise.then(chain.shift(), chain.shift());
  }

  return promise;
};

// Provide aliases for supported request methods
utils.forEach(['delete', 'get', 'head', 'options'], function forEachMethodNoData(method) {
  /*eslint func-names:0*/
  Axios.prototype[method] = function(url, config) {
    return this.request(utils.merge(config || {}, {
      method: method,
      url: url
    }));
  };
});

utils.forEach(['post', 'put', 'patch'], function forEachMethodWithData(method) {
  /*eslint func-names:0*/
  Axios.prototype[method] = function(url, data, config) {
    return this.request(utils.merge(config || {}, {
      method: method,
      url: url,
      data: data
    }));
  };
});

module.exports = Axios;


/***/ }),

/***/ "./node_modules/axios/lib/core/InterceptorManager.js":
/*!***********************************************************!*\
  !*** ./node_modules/axios/lib/core/InterceptorManager.js ***!
  \***********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");

function InterceptorManager() {
  this.handlers = [];
}

/**
 * Add a new interceptor to the stack
 *
 * @param {Function} fulfilled The function to handle `then` for a `Promise`
 * @param {Function} rejected The function to handle `reject` for a `Promise`
 *
 * @return {Number} An ID used to remove interceptor later
 */
InterceptorManager.prototype.use = function use(fulfilled, rejected) {
  this.handlers.push({
    fulfilled: fulfilled,
    rejected: rejected
  });
  return this.handlers.length - 1;
};

/**
 * Remove an interceptor from the stack
 *
 * @param {Number} id The ID that was returned by `use`
 */
InterceptorManager.prototype.eject = function eject(id) {
  if (this.handlers[id]) {
    this.handlers[id] = null;
  }
};

/**
 * Iterate over all the registered interceptors
 *
 * This method is particularly useful for skipping over any
 * interceptors that may have become `null` calling `eject`.
 *
 * @param {Function} fn The function to call for each interceptor
 */
InterceptorManager.prototype.forEach = function forEach(fn) {
  utils.forEach(this.handlers, function forEachHandler(h) {
    if (h !== null) {
      fn(h);
    }
  });
};

module.exports = InterceptorManager;


/***/ }),

/***/ "./node_modules/axios/lib/core/createError.js":
/*!****************************************************!*\
  !*** ./node_modules/axios/lib/core/createError.js ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var enhanceError = __webpack_require__(/*! ./enhanceError */ "./node_modules/axios/lib/core/enhanceError.js");

/**
 * Create an Error with the specified message, config, error code, request and response.
 *
 * @param {string} message The error message.
 * @param {Object} config The config.
 * @param {string} [code] The error code (for example, 'ECONNABORTED').
 * @param {Object} [request] The request.
 * @param {Object} [response] The response.
 * @returns {Error} The created error.
 */
module.exports = function createError(message, config, code, request, response) {
  var error = new Error(message);
  return enhanceError(error, config, code, request, response);
};


/***/ }),

/***/ "./node_modules/axios/lib/core/dispatchRequest.js":
/*!********************************************************!*\
  !*** ./node_modules/axios/lib/core/dispatchRequest.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");
var transformData = __webpack_require__(/*! ./transformData */ "./node_modules/axios/lib/core/transformData.js");
var isCancel = __webpack_require__(/*! ../cancel/isCancel */ "./node_modules/axios/lib/cancel/isCancel.js");
var defaults = __webpack_require__(/*! ../defaults */ "./node_modules/axios/lib/defaults.js");
var isAbsoluteURL = __webpack_require__(/*! ./../helpers/isAbsoluteURL */ "./node_modules/axios/lib/helpers/isAbsoluteURL.js");
var combineURLs = __webpack_require__(/*! ./../helpers/combineURLs */ "./node_modules/axios/lib/helpers/combineURLs.js");

/**
 * Throws a `Cancel` if cancellation has been requested.
 */
function throwIfCancellationRequested(config) {
  if (config.cancelToken) {
    config.cancelToken.throwIfRequested();
  }
}

/**
 * Dispatch a request to the server using the configured adapter.
 *
 * @param {object} config The config that is to be used for the request
 * @returns {Promise} The Promise to be fulfilled
 */
module.exports = function dispatchRequest(config) {
  throwIfCancellationRequested(config);

  // Support baseURL config
  if (config.baseURL && !isAbsoluteURL(config.url)) {
    config.url = combineURLs(config.baseURL, config.url);
  }

  // Ensure headers exist
  config.headers = config.headers || {};

  // Transform request data
  config.data = transformData(
    config.data,
    config.headers,
    config.transformRequest
  );

  // Flatten headers
  config.headers = utils.merge(
    config.headers.common || {},
    config.headers[config.method] || {},
    config.headers || {}
  );

  utils.forEach(
    ['delete', 'get', 'head', 'post', 'put', 'patch', 'common'],
    function cleanHeaderConfig(method) {
      delete config.headers[method];
    }
  );

  var adapter = config.adapter || defaults.adapter;

  return adapter(config).then(function onAdapterResolution(response) {
    throwIfCancellationRequested(config);

    // Transform response data
    response.data = transformData(
      response.data,
      response.headers,
      config.transformResponse
    );

    return response;
  }, function onAdapterRejection(reason) {
    if (!isCancel(reason)) {
      throwIfCancellationRequested(config);

      // Transform response data
      if (reason && reason.response) {
        reason.response.data = transformData(
          reason.response.data,
          reason.response.headers,
          config.transformResponse
        );
      }
    }

    return Promise.reject(reason);
  });
};


/***/ }),

/***/ "./node_modules/axios/lib/core/enhanceError.js":
/*!*****************************************************!*\
  !*** ./node_modules/axios/lib/core/enhanceError.js ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * Update an Error with the specified config, error code, and response.
 *
 * @param {Error} error The error to update.
 * @param {Object} config The config.
 * @param {string} [code] The error code (for example, 'ECONNABORTED').
 * @param {Object} [request] The request.
 * @param {Object} [response] The response.
 * @returns {Error} The error.
 */
module.exports = function enhanceError(error, config, code, request, response) {
  error.config = config;
  if (code) {
    error.code = code;
  }
  error.request = request;
  error.response = response;
  return error;
};


/***/ }),

/***/ "./node_modules/axios/lib/core/settle.js":
/*!***********************************************!*\
  !*** ./node_modules/axios/lib/core/settle.js ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var createError = __webpack_require__(/*! ./createError */ "./node_modules/axios/lib/core/createError.js");

/**
 * Resolve or reject a Promise based on response status.
 *
 * @param {Function} resolve A function that resolves the promise.
 * @param {Function} reject A function that rejects the promise.
 * @param {object} response The response.
 */
module.exports = function settle(resolve, reject, response) {
  var validateStatus = response.config.validateStatus;
  // Note: status is not exposed by XDomainRequest
  if (!response.status || !validateStatus || validateStatus(response.status)) {
    resolve(response);
  } else {
    reject(createError(
      'Request failed with status code ' + response.status,
      response.config,
      null,
      response.request,
      response
    ));
  }
};


/***/ }),

/***/ "./node_modules/axios/lib/core/transformData.js":
/*!******************************************************!*\
  !*** ./node_modules/axios/lib/core/transformData.js ***!
  \******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");

/**
 * Transform the data for a request or a response
 *
 * @param {Object|String} data The data to be transformed
 * @param {Array} headers The headers for the request or response
 * @param {Array|Function} fns A single function or Array of functions
 * @returns {*} The resulting transformed data
 */
module.exports = function transformData(data, headers, fns) {
  /*eslint no-param-reassign:0*/
  utils.forEach(fns, function transform(fn) {
    data = fn(data, headers);
  });

  return data;
};


/***/ }),

/***/ "./node_modules/axios/lib/defaults.js":
/*!********************************************!*\
  !*** ./node_modules/axios/lib/defaults.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* WEBPACK VAR INJECTION */(function(process) {

var utils = __webpack_require__(/*! ./utils */ "./node_modules/axios/lib/utils.js");
var normalizeHeaderName = __webpack_require__(/*! ./helpers/normalizeHeaderName */ "./node_modules/axios/lib/helpers/normalizeHeaderName.js");

var DEFAULT_CONTENT_TYPE = {
  'Content-Type': 'application/x-www-form-urlencoded'
};

function setContentTypeIfUnset(headers, value) {
  if (!utils.isUndefined(headers) && utils.isUndefined(headers['Content-Type'])) {
    headers['Content-Type'] = value;
  }
}

function getDefaultAdapter() {
  var adapter;
  if (typeof XMLHttpRequest !== 'undefined') {
    // For browsers use XHR adapter
    adapter = __webpack_require__(/*! ./adapters/xhr */ "./node_modules/axios/lib/adapters/xhr.js");
  } else if (typeof process !== 'undefined') {
    // For node use HTTP adapter
    adapter = __webpack_require__(/*! ./adapters/http */ "./node_modules/axios/lib/adapters/xhr.js");
  }
  return adapter;
}

var defaults = {
  adapter: getDefaultAdapter(),

  transformRequest: [function transformRequest(data, headers) {
    normalizeHeaderName(headers, 'Content-Type');
    if (utils.isFormData(data) ||
      utils.isArrayBuffer(data) ||
      utils.isBuffer(data) ||
      utils.isStream(data) ||
      utils.isFile(data) ||
      utils.isBlob(data)
    ) {
      return data;
    }
    if (utils.isArrayBufferView(data)) {
      return data.buffer;
    }
    if (utils.isURLSearchParams(data)) {
      setContentTypeIfUnset(headers, 'application/x-www-form-urlencoded;charset=utf-8');
      return data.toString();
    }
    if (utils.isObject(data)) {
      setContentTypeIfUnset(headers, 'application/json;charset=utf-8');
      return JSON.stringify(data);
    }
    return data;
  }],

  transformResponse: [function transformResponse(data) {
    /*eslint no-param-reassign:0*/
    if (typeof data === 'string') {
      try {
        data = JSON.parse(data);
      } catch (e) { /* Ignore */ }
    }
    return data;
  }],

  /**
   * A timeout in milliseconds to abort a request. If set to 0 (default) a
   * timeout is not created.
   */
  timeout: 0,

  xsrfCookieName: 'XSRF-TOKEN',
  xsrfHeaderName: 'X-XSRF-TOKEN',

  maxContentLength: -1,

  validateStatus: function validateStatus(status) {
    return status >= 200 && status < 300;
  }
};

defaults.headers = {
  common: {
    'Accept': 'application/json, text/plain, */*'
  }
};

utils.forEach(['delete', 'get', 'head'], function forEachMethodNoData(method) {
  defaults.headers[method] = {};
});

utils.forEach(['post', 'put', 'patch'], function forEachMethodWithData(method) {
  defaults.headers[method] = utils.merge(DEFAULT_CONTENT_TYPE);
});

module.exports = defaults;

/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! ./../../process/browser.js */ "./node_modules/process/browser.js")))

/***/ }),

/***/ "./node_modules/axios/lib/helpers/bind.js":
/*!************************************************!*\
  !*** ./node_modules/axios/lib/helpers/bind.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = function bind(fn, thisArg) {
  return function wrap() {
    var args = new Array(arguments.length);
    for (var i = 0; i < args.length; i++) {
      args[i] = arguments[i];
    }
    return fn.apply(thisArg, args);
  };
};


/***/ }),

/***/ "./node_modules/axios/lib/helpers/buildURL.js":
/*!****************************************************!*\
  !*** ./node_modules/axios/lib/helpers/buildURL.js ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");

function encode(val) {
  return encodeURIComponent(val).
    replace(/%40/gi, '@').
    replace(/%3A/gi, ':').
    replace(/%24/g, '$').
    replace(/%2C/gi, ',').
    replace(/%20/g, '+').
    replace(/%5B/gi, '[').
    replace(/%5D/gi, ']');
}

/**
 * Build a URL by appending params to the end
 *
 * @param {string} url The base of the url (e.g., http://www.google.com)
 * @param {object} [params] The params to be appended
 * @returns {string} The formatted url
 */
module.exports = function buildURL(url, params, paramsSerializer) {
  /*eslint no-param-reassign:0*/
  if (!params) {
    return url;
  }

  var serializedParams;
  if (paramsSerializer) {
    serializedParams = paramsSerializer(params);
  } else if (utils.isURLSearchParams(params)) {
    serializedParams = params.toString();
  } else {
    var parts = [];

    utils.forEach(params, function serialize(val, key) {
      if (val === null || typeof val === 'undefined') {
        return;
      }

      if (utils.isArray(val)) {
        key = key + '[]';
      } else {
        val = [val];
      }

      utils.forEach(val, function parseValue(v) {
        if (utils.isDate(v)) {
          v = v.toISOString();
        } else if (utils.isObject(v)) {
          v = JSON.stringify(v);
        }
        parts.push(encode(key) + '=' + encode(v));
      });
    });

    serializedParams = parts.join('&');
  }

  if (serializedParams) {
    url += (url.indexOf('?') === -1 ? '?' : '&') + serializedParams;
  }

  return url;
};


/***/ }),

/***/ "./node_modules/axios/lib/helpers/combineURLs.js":
/*!*******************************************************!*\
  !*** ./node_modules/axios/lib/helpers/combineURLs.js ***!
  \*******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * Creates a new URL by combining the specified URLs
 *
 * @param {string} baseURL The base URL
 * @param {string} relativeURL The relative URL
 * @returns {string} The combined URL
 */
module.exports = function combineURLs(baseURL, relativeURL) {
  return relativeURL
    ? baseURL.replace(/\/+$/, '') + '/' + relativeURL.replace(/^\/+/, '')
    : baseURL;
};


/***/ }),

/***/ "./node_modules/axios/lib/helpers/cookies.js":
/*!***************************************************!*\
  !*** ./node_modules/axios/lib/helpers/cookies.js ***!
  \***************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");

module.exports = (
  utils.isStandardBrowserEnv() ?

  // Standard browser envs support document.cookie
  (function standardBrowserEnv() {
    return {
      write: function write(name, value, expires, path, domain, secure) {
        var cookie = [];
        cookie.push(name + '=' + encodeURIComponent(value));

        if (utils.isNumber(expires)) {
          cookie.push('expires=' + new Date(expires).toGMTString());
        }

        if (utils.isString(path)) {
          cookie.push('path=' + path);
        }

        if (utils.isString(domain)) {
          cookie.push('domain=' + domain);
        }

        if (secure === true) {
          cookie.push('secure');
        }

        document.cookie = cookie.join('; ');
      },

      read: function read(name) {
        var match = document.cookie.match(new RegExp('(^|;\\s*)(' + name + ')=([^;]*)'));
        return (match ? decodeURIComponent(match[3]) : null);
      },

      remove: function remove(name) {
        this.write(name, '', Date.now() - 86400000);
      }
    };
  })() :

  // Non standard browser env (web workers, react-native) lack needed support.
  (function nonStandardBrowserEnv() {
    return {
      write: function write() {},
      read: function read() { return null; },
      remove: function remove() {}
    };
  })()
);


/***/ }),

/***/ "./node_modules/axios/lib/helpers/isAbsoluteURL.js":
/*!*********************************************************!*\
  !*** ./node_modules/axios/lib/helpers/isAbsoluteURL.js ***!
  \*********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * Determines whether the specified URL is absolute
 *
 * @param {string} url The URL to test
 * @returns {boolean} True if the specified URL is absolute, otherwise false
 */
module.exports = function isAbsoluteURL(url) {
  // A URL is considered absolute if it begins with "<scheme>://" or "//" (protocol-relative URL).
  // RFC 3986 defines scheme name as a sequence of characters beginning with a letter and followed
  // by any combination of letters, digits, plus, period, or hyphen.
  return /^([a-z][a-z\d\+\-\.]*:)?\/\//i.test(url);
};


/***/ }),

/***/ "./node_modules/axios/lib/helpers/isURLSameOrigin.js":
/*!***********************************************************!*\
  !*** ./node_modules/axios/lib/helpers/isURLSameOrigin.js ***!
  \***********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");

module.exports = (
  utils.isStandardBrowserEnv() ?

  // Standard browser envs have full support of the APIs needed to test
  // whether the request URL is of the same origin as current location.
  (function standardBrowserEnv() {
    var msie = /(msie|trident)/i.test(navigator.userAgent);
    var urlParsingNode = document.createElement('a');
    var originURL;

    /**
    * Parse a URL to discover it's components
    *
    * @param {String} url The URL to be parsed
    * @returns {Object}
    */
    function resolveURL(url) {
      var href = url;

      if (msie) {
        // IE needs attribute set twice to normalize properties
        urlParsingNode.setAttribute('href', href);
        href = urlParsingNode.href;
      }

      urlParsingNode.setAttribute('href', href);

      // urlParsingNode provides the UrlUtils interface - http://url.spec.whatwg.org/#urlutils
      return {
        href: urlParsingNode.href,
        protocol: urlParsingNode.protocol ? urlParsingNode.protocol.replace(/:$/, '') : '',
        host: urlParsingNode.host,
        search: urlParsingNode.search ? urlParsingNode.search.replace(/^\?/, '') : '',
        hash: urlParsingNode.hash ? urlParsingNode.hash.replace(/^#/, '') : '',
        hostname: urlParsingNode.hostname,
        port: urlParsingNode.port,
        pathname: (urlParsingNode.pathname.charAt(0) === '/') ?
                  urlParsingNode.pathname :
                  '/' + urlParsingNode.pathname
      };
    }

    originURL = resolveURL(window.location.href);

    /**
    * Determine if a URL shares the same origin as the current location
    *
    * @param {String} requestURL The URL to test
    * @returns {boolean} True if URL shares the same origin, otherwise false
    */
    return function isURLSameOrigin(requestURL) {
      var parsed = (utils.isString(requestURL)) ? resolveURL(requestURL) : requestURL;
      return (parsed.protocol === originURL.protocol &&
            parsed.host === originURL.host);
    };
  })() :

  // Non standard browser envs (web workers, react-native) lack needed support.
  (function nonStandardBrowserEnv() {
    return function isURLSameOrigin() {
      return true;
    };
  })()
);


/***/ }),

/***/ "./node_modules/axios/lib/helpers/normalizeHeaderName.js":
/*!***************************************************************!*\
  !*** ./node_modules/axios/lib/helpers/normalizeHeaderName.js ***!
  \***************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ../utils */ "./node_modules/axios/lib/utils.js");

module.exports = function normalizeHeaderName(headers, normalizedName) {
  utils.forEach(headers, function processHeader(value, name) {
    if (name !== normalizedName && name.toUpperCase() === normalizedName.toUpperCase()) {
      headers[normalizedName] = value;
      delete headers[name];
    }
  });
};


/***/ }),

/***/ "./node_modules/axios/lib/helpers/parseHeaders.js":
/*!********************************************************!*\
  !*** ./node_modules/axios/lib/helpers/parseHeaders.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");

// Headers whose duplicates are ignored by node
// c.f. https://nodejs.org/api/http.html#http_message_headers
var ignoreDuplicateOf = [
  'age', 'authorization', 'content-length', 'content-type', 'etag',
  'expires', 'from', 'host', 'if-modified-since', 'if-unmodified-since',
  'last-modified', 'location', 'max-forwards', 'proxy-authorization',
  'referer', 'retry-after', 'user-agent'
];

/**
 * Parse headers into an object
 *
 * ```
 * Date: Wed, 27 Aug 2014 08:58:49 GMT
 * Content-Type: application/json
 * Connection: keep-alive
 * Transfer-Encoding: chunked
 * ```
 *
 * @param {String} headers Headers needing to be parsed
 * @returns {Object} Headers parsed into an object
 */
module.exports = function parseHeaders(headers) {
  var parsed = {};
  var key;
  var val;
  var i;

  if (!headers) { return parsed; }

  utils.forEach(headers.split('\n'), function parser(line) {
    i = line.indexOf(':');
    key = utils.trim(line.substr(0, i)).toLowerCase();
    val = utils.trim(line.substr(i + 1));

    if (key) {
      if (parsed[key] && ignoreDuplicateOf.indexOf(key) >= 0) {
        return;
      }
      if (key === 'set-cookie') {
        parsed[key] = (parsed[key] ? parsed[key] : []).concat([val]);
      } else {
        parsed[key] = parsed[key] ? parsed[key] + ', ' + val : val;
      }
    }
  });

  return parsed;
};


/***/ }),

/***/ "./node_modules/axios/lib/helpers/spread.js":
/*!**************************************************!*\
  !*** ./node_modules/axios/lib/helpers/spread.js ***!
  \**************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * Syntactic sugar for invoking a function and expanding an array for arguments.
 *
 * Common use case would be to use `Function.prototype.apply`.
 *
 *  ```js
 *  function f(x, y, z) {}
 *  var args = [1, 2, 3];
 *  f.apply(null, args);
 *  ```
 *
 * With `spread` this example can be re-written.
 *
 *  ```js
 *  spread(function(x, y, z) {})([1, 2, 3]);
 *  ```
 *
 * @param {Function} callback
 * @returns {Function}
 */
module.exports = function spread(callback) {
  return function wrap(arr) {
    return callback.apply(null, arr);
  };
};


/***/ }),

/***/ "./node_modules/axios/lib/utils.js":
/*!*****************************************!*\
  !*** ./node_modules/axios/lib/utils.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var bind = __webpack_require__(/*! ./helpers/bind */ "./node_modules/axios/lib/helpers/bind.js");
var isBuffer = __webpack_require__(/*! is-buffer */ "./node_modules/is-buffer/index.js");

/*global toString:true*/

// utils is a library of generic helper functions non-specific to axios

var toString = Object.prototype.toString;

/**
 * Determine if a value is an Array
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is an Array, otherwise false
 */
function isArray(val) {
  return toString.call(val) === '[object Array]';
}

/**
 * Determine if a value is an ArrayBuffer
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is an ArrayBuffer, otherwise false
 */
function isArrayBuffer(val) {
  return toString.call(val) === '[object ArrayBuffer]';
}

/**
 * Determine if a value is a FormData
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is an FormData, otherwise false
 */
function isFormData(val) {
  return (typeof FormData !== 'undefined') && (val instanceof FormData);
}

/**
 * Determine if a value is a view on an ArrayBuffer
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a view on an ArrayBuffer, otherwise false
 */
function isArrayBufferView(val) {
  var result;
  if ((typeof ArrayBuffer !== 'undefined') && (ArrayBuffer.isView)) {
    result = ArrayBuffer.isView(val);
  } else {
    result = (val) && (val.buffer) && (val.buffer instanceof ArrayBuffer);
  }
  return result;
}

/**
 * Determine if a value is a String
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a String, otherwise false
 */
function isString(val) {
  return typeof val === 'string';
}

/**
 * Determine if a value is a Number
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Number, otherwise false
 */
function isNumber(val) {
  return typeof val === 'number';
}

/**
 * Determine if a value is undefined
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if the value is undefined, otherwise false
 */
function isUndefined(val) {
  return typeof val === 'undefined';
}

/**
 * Determine if a value is an Object
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is an Object, otherwise false
 */
function isObject(val) {
  return val !== null && typeof val === 'object';
}

/**
 * Determine if a value is a Date
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Date, otherwise false
 */
function isDate(val) {
  return toString.call(val) === '[object Date]';
}

/**
 * Determine if a value is a File
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a File, otherwise false
 */
function isFile(val) {
  return toString.call(val) === '[object File]';
}

/**
 * Determine if a value is a Blob
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Blob, otherwise false
 */
function isBlob(val) {
  return toString.call(val) === '[object Blob]';
}

/**
 * Determine if a value is a Function
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Function, otherwise false
 */
function isFunction(val) {
  return toString.call(val) === '[object Function]';
}

/**
 * Determine if a value is a Stream
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Stream, otherwise false
 */
function isStream(val) {
  return isObject(val) && isFunction(val.pipe);
}

/**
 * Determine if a value is a URLSearchParams object
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a URLSearchParams object, otherwise false
 */
function isURLSearchParams(val) {
  return typeof URLSearchParams !== 'undefined' && val instanceof URLSearchParams;
}

/**
 * Trim excess whitespace off the beginning and end of a string
 *
 * @param {String} str The String to trim
 * @returns {String} The String freed of excess whitespace
 */
function trim(str) {
  return str.replace(/^\s*/, '').replace(/\s*$/, '');
}

/**
 * Determine if we're running in a standard browser environment
 *
 * This allows axios to run in a web worker, and react-native.
 * Both environments support XMLHttpRequest, but not fully standard globals.
 *
 * web workers:
 *  typeof window -> undefined
 *  typeof document -> undefined
 *
 * react-native:
 *  navigator.product -> 'ReactNative'
 */
function isStandardBrowserEnv() {
  if (typeof navigator !== 'undefined' && navigator.product === 'ReactNative') {
    return false;
  }
  return (
    typeof window !== 'undefined' &&
    typeof document !== 'undefined'
  );
}

/**
 * Iterate over an Array or an Object invoking a function for each item.
 *
 * If `obj` is an Array callback will be called passing
 * the value, index, and complete array for each item.
 *
 * If 'obj' is an Object callback will be called passing
 * the value, key, and complete object for each property.
 *
 * @param {Object|Array} obj The object to iterate
 * @param {Function} fn The callback to invoke for each item
 */
function forEach(obj, fn) {
  // Don't bother if no value provided
  if (obj === null || typeof obj === 'undefined') {
    return;
  }

  // Force an array if not already something iterable
  if (typeof obj !== 'object') {
    /*eslint no-param-reassign:0*/
    obj = [obj];
  }

  if (isArray(obj)) {
    // Iterate over array values
    for (var i = 0, l = obj.length; i < l; i++) {
      fn.call(null, obj[i], i, obj);
    }
  } else {
    // Iterate over object keys
    for (var key in obj) {
      if (Object.prototype.hasOwnProperty.call(obj, key)) {
        fn.call(null, obj[key], key, obj);
      }
    }
  }
}

/**
 * Accepts varargs expecting each argument to be an object, then
 * immutably merges the properties of each object and returns result.
 *
 * When multiple objects contain the same key the later object in
 * the arguments list will take precedence.
 *
 * Example:
 *
 * ```js
 * var result = merge({foo: 123}, {foo: 456});
 * console.log(result.foo); // outputs 456
 * ```
 *
 * @param {Object} obj1 Object to merge
 * @returns {Object} Result of all merge properties
 */
function merge(/* obj1, obj2, obj3, ... */) {
  var result = {};
  function assignValue(val, key) {
    if (typeof result[key] === 'object' && typeof val === 'object') {
      result[key] = merge(result[key], val);
    } else {
      result[key] = val;
    }
  }

  for (var i = 0, l = arguments.length; i < l; i++) {
    forEach(arguments[i], assignValue);
  }
  return result;
}

/**
 * Extends object a by mutably adding to it the properties of object b.
 *
 * @param {Object} a The object to be extended
 * @param {Object} b The object to copy properties from
 * @param {Object} thisArg The object to bind function to
 * @return {Object} The resulting value of object a
 */
function extend(a, b, thisArg) {
  forEach(b, function assignValue(val, key) {
    if (thisArg && typeof val === 'function') {
      a[key] = bind(val, thisArg);
    } else {
      a[key] = val;
    }
  });
  return a;
}

module.exports = {
  isArray: isArray,
  isArrayBuffer: isArrayBuffer,
  isBuffer: isBuffer,
  isFormData: isFormData,
  isArrayBufferView: isArrayBufferView,
  isString: isString,
  isNumber: isNumber,
  isObject: isObject,
  isUndefined: isUndefined,
  isDate: isDate,
  isFile: isFile,
  isBlob: isBlob,
  isFunction: isFunction,
  isStream: isStream,
  isURLSearchParams: isURLSearchParams,
  isStandardBrowserEnv: isStandardBrowserEnv,
  forEach: forEach,
  merge: merge,
  extend: extend,
  trim: trim
};


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/OsProdutoComponent.vue?vue&type=script&lang=js":
/*!****************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/OsProdutoComponent.vue?vue&type=script&lang=js ***!
  \****************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _modal2_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./modal2.vue */ "./resources/js/components/modal2.vue");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return e; }; var t, e = {}, r = Object.prototype, n = r.hasOwnProperty, o = Object.defineProperty || function (t, e, r) { t[e] = r.value; }, i = "function" == typeof Symbol ? Symbol : {}, a = i.iterator || "@@iterator", c = i.asyncIterator || "@@asyncIterator", u = i.toStringTag || "@@toStringTag"; function define(t, e, r) { return Object.defineProperty(t, e, { value: r, enumerable: !0, configurable: !0, writable: !0 }), t[e]; } try { define({}, ""); } catch (t) { define = function define(t, e, r) { return t[e] = r; }; } function wrap(t, e, r, n) { var i = e && e.prototype instanceof Generator ? e : Generator, a = Object.create(i.prototype), c = new Context(n || []); return o(a, "_invoke", { value: makeInvokeMethod(t, r, c) }), a; } function tryCatch(t, e, r) { try { return { type: "normal", arg: t.call(e, r) }; } catch (t) { return { type: "throw", arg: t }; } } e.wrap = wrap; var h = "suspendedStart", l = "suspendedYield", f = "executing", s = "completed", y = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var p = {}; define(p, a, function () { return this; }); var d = Object.getPrototypeOf, v = d && d(d(values([]))); v && v !== r && n.call(v, a) && (p = v); var g = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(p); function defineIteratorMethods(t) { ["next", "throw", "return"].forEach(function (e) { define(t, e, function (t) { return this._invoke(e, t); }); }); } function AsyncIterator(t, e) { function invoke(r, o, i, a) { var c = tryCatch(t[r], t, o); if ("throw" !== c.type) { var u = c.arg, h = u.value; return h && "object" == _typeof(h) && n.call(h, "__await") ? e.resolve(h.__await).then(function (t) { invoke("next", t, i, a); }, function (t) { invoke("throw", t, i, a); }) : e.resolve(h).then(function (t) { u.value = t, i(u); }, function (t) { return invoke("throw", t, i, a); }); } a(c.arg); } var r; o(this, "_invoke", { value: function value(t, n) { function callInvokeWithMethodAndArg() { return new e(function (e, r) { invoke(t, n, e, r); }); } return r = r ? r.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(e, r, n) { var o = h; return function (i, a) { if (o === f) throw Error("Generator is already running"); if (o === s) { if ("throw" === i) throw a; return { value: t, done: !0 }; } for (n.method = i, n.arg = a;;) { var c = n.delegate; if (c) { var u = maybeInvokeDelegate(c, n); if (u) { if (u === y) continue; return u; } } if ("next" === n.method) n.sent = n._sent = n.arg;else if ("throw" === n.method) { if (o === h) throw o = s, n.arg; n.dispatchException(n.arg); } else "return" === n.method && n.abrupt("return", n.arg); o = f; var p = tryCatch(e, r, n); if ("normal" === p.type) { if (o = n.done ? s : l, p.arg === y) continue; return { value: p.arg, done: n.done }; } "throw" === p.type && (o = s, n.method = "throw", n.arg = p.arg); } }; } function maybeInvokeDelegate(e, r) { var n = r.method, o = e.iterator[n]; if (o === t) return r.delegate = null, "throw" === n && e.iterator["return"] && (r.method = "return", r.arg = t, maybeInvokeDelegate(e, r), "throw" === r.method) || "return" !== n && (r.method = "throw", r.arg = new TypeError("The iterator does not provide a '" + n + "' method")), y; var i = tryCatch(o, e.iterator, r.arg); if ("throw" === i.type) return r.method = "throw", r.arg = i.arg, r.delegate = null, y; var a = i.arg; return a ? a.done ? (r[e.resultName] = a.value, r.next = e.nextLoc, "return" !== r.method && (r.method = "next", r.arg = t), r.delegate = null, y) : a : (r.method = "throw", r.arg = new TypeError("iterator result is not an object"), r.delegate = null, y); } function pushTryEntry(t) { var e = { tryLoc: t[0] }; 1 in t && (e.catchLoc = t[1]), 2 in t && (e.finallyLoc = t[2], e.afterLoc = t[3]), this.tryEntries.push(e); } function resetTryEntry(t) { var e = t.completion || {}; e.type = "normal", delete e.arg, t.completion = e; } function Context(t) { this.tryEntries = [{ tryLoc: "root" }], t.forEach(pushTryEntry, this), this.reset(!0); } function values(e) { if (e || "" === e) { var r = e[a]; if (r) return r.call(e); if ("function" == typeof e.next) return e; if (!isNaN(e.length)) { var o = -1, i = function next() { for (; ++o < e.length;) if (n.call(e, o)) return next.value = e[o], next.done = !1, next; return next.value = t, next.done = !0, next; }; return i.next = i; } } throw new TypeError(_typeof(e) + " is not iterable"); } return GeneratorFunction.prototype = GeneratorFunctionPrototype, o(g, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), o(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, u, "GeneratorFunction"), e.isGeneratorFunction = function (t) { var e = "function" == typeof t && t.constructor; return !!e && (e === GeneratorFunction || "GeneratorFunction" === (e.displayName || e.name)); }, e.mark = function (t) { return Object.setPrototypeOf ? Object.setPrototypeOf(t, GeneratorFunctionPrototype) : (t.__proto__ = GeneratorFunctionPrototype, define(t, u, "GeneratorFunction")), t.prototype = Object.create(g), t; }, e.awrap = function (t) { return { __await: t }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, c, function () { return this; }), e.AsyncIterator = AsyncIterator, e.async = function (t, r, n, o, i) { void 0 === i && (i = Promise); var a = new AsyncIterator(wrap(t, r, n, o), i); return e.isGeneratorFunction(r) ? a : a.next().then(function (t) { return t.done ? t.value : a.next(); }); }, defineIteratorMethods(g), define(g, u, "Generator"), define(g, a, function () { return this; }), define(g, "toString", function () { return "[object Generator]"; }), e.keys = function (t) { var e = Object(t), r = []; for (var n in e) r.push(n); return r.reverse(), function next() { for (; r.length;) { var t = r.pop(); if (t in e) return next.value = t, next.done = !1, next; } return next.done = !0, next; }; }, e.values = values, Context.prototype = { constructor: Context, reset: function reset(e) { if (this.prev = 0, this.next = 0, this.sent = this._sent = t, this.done = !1, this.delegate = null, this.method = "next", this.arg = t, this.tryEntries.forEach(resetTryEntry), !e) for (var r in this) "t" === r.charAt(0) && n.call(this, r) && !isNaN(+r.slice(1)) && (this[r] = t); }, stop: function stop() { this.done = !0; var t = this.tryEntries[0].completion; if ("throw" === t.type) throw t.arg; return this.rval; }, dispatchException: function dispatchException(e) { if (this.done) throw e; var r = this; function handle(n, o) { return a.type = "throw", a.arg = e, r.next = n, o && (r.method = "next", r.arg = t), !!o; } for (var o = this.tryEntries.length - 1; o >= 0; --o) { var i = this.tryEntries[o], a = i.completion; if ("root" === i.tryLoc) return handle("end"); if (i.tryLoc <= this.prev) { var c = n.call(i, "catchLoc"), u = n.call(i, "finallyLoc"); if (c && u) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } else if (c) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); } else { if (!u) throw Error("try statement without catch or finally"); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } } } }, abrupt: function abrupt(t, e) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var o = this.tryEntries[r]; if (o.tryLoc <= this.prev && n.call(o, "finallyLoc") && this.prev < o.finallyLoc) { var i = o; break; } } i && ("break" === t || "continue" === t) && i.tryLoc <= e && e <= i.finallyLoc && (i = null); var a = i ? i.completion : {}; return a.type = t, a.arg = e, i ? (this.method = "next", this.next = i.finallyLoc, y) : this.complete(a); }, complete: function complete(t, e) { if ("throw" === t.type) throw t.arg; return "break" === t.type || "continue" === t.type ? this.next = t.arg : "return" === t.type ? (this.rval = this.arg = t.arg, this.method = "return", this.next = "end") : "normal" === t.type && e && (this.next = e), y; }, finish: function finish(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.finallyLoc === t) return this.complete(r.completion, r.afterLoc), resetTryEntry(r), y; } }, "catch": function _catch(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.tryLoc === t) { var n = r.completion; if ("throw" === n.type) { var o = n.arg; resetTryEntry(r); } return o; } } throw Error("illegal catch attempt"); }, delegateYield: function delegateYield(e, r, n) { return this.delegate = { iterator: values(e), resultName: r, nextLoc: n }, "next" === this.method && (this.arg = t), y; } }, e; }
function asyncGeneratorStep(n, t, e, r, o, a, c) { try { var i = n[a](c), u = i.value; } catch (n) { return void e(n); } i.done ? t(u) : Promise.resolve(u).then(r, o); }
function _asyncToGenerator(n) { return function () { var t = this, e = arguments; return new Promise(function (r, o) { var a = n.apply(t, e); function _next(n) { asyncGeneratorStep(a, r, o, _next, _throw, "next", n); } function _throw(n) { asyncGeneratorStep(a, r, o, _next, _throw, "throw", n); } _next(void 0); }); }; }

/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'ordem-servico-produtos',
  components: {
    modal2: _modal2_vue__WEBPACK_IMPORTED_MODULE_0__["default"]
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
    oldData: function oldData() {
      //this.$refs.confirmDelete
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
      this.estoqueId = this.oldEstoqueId;
      //this.getProdutos();
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
      var self = this;
      //if ((this.estoqueId !== null) && (this.estoqueId !== 'false')) {
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
    cancelProtuto: function cancelProtuto() {
      //console.log('cancel produto');
    },
    confirmProtuto: function confirmProtuto() {
      //console.log('confirm produto');
    },
    addProduto: function addProduto() {
      if (this.validarItem()) {
        this.produtos.push({
          'id': this.produto_id,
          'produto_vencimento_id': this.produto_vencimento_id,
          'produto_descricao': this.getProdutoById(this.produto_id).produto_descricao + this.getProdutoVencimentoDesc(this.produto_vencimento_id),
          'quantidade': Number(this.quantidade),
          'valor_produto': Number(this.valor_unitario),
          // 'valor_produto': Number(this.getProdutoById(this.produto_id).valor_venda),
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
      }
      //console.log('index: '+result);
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
        axios.get('/produtos_vencendo_vencidos/' + this.veiculo_id).then(/*#__PURE__*/function () {
          var _ref = _asyncToGenerator(/*#__PURE__*/_regeneratorRuntime().mark(function _callee(r) {
            return _regeneratorRuntime().wrap(function _callee$(_context) {
              while (1) switch (_context.prev = _context.next) {
                case 0:
                  _this.produtosVencimento = r.data;
                  console.log(r.data);
                case 2:
                case "end":
                  return _context.stop();
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

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/OsServicoComponent.vue?vue&type=script&lang=js":
/*!****************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/OsServicoComponent.vue?vue&type=script&lang=js ***!
  \****************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _modal_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./modal.vue */ "./resources/js/components/modal.vue");

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

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/dashboard/SaldoTanques.vue?vue&type=script&lang=js":
/*!********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/dashboard/SaldoTanques.vue?vue&type=script&lang=js ***!
  \********************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_0__);

/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      tanques: []
    };
  },
  mounted: function mounted() {
    var _this = this;
    axios__WEBPACK_IMPORTED_MODULE_0___default.a.get("dashboard/saldo_tanques").then(function (r) {
      _this.tanques = r.data;
    })["catch"](function (e) {
      console.log(e);
    });
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/modal.vue?vue&type=script&lang=js":
/*!***************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/modal.vue?vue&type=script&lang=js ***!
  \***************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _dashboard_SaldoTanques_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./dashboard/SaldoTanques.vue */ "./resources/js/components/dashboard/SaldoTanques.vue");

/* harmony default export */ __webpack_exports__["default"] = ({
  name: "modal",
  methods: {
    cancel: function cancel() {
      this.$emit(this._eventCancel);
    },
    confirm: function confirm() {
      this.$emit(this._eventConfirm);
    }
  },
  props: ["modalTitle", "modalText", "eventCancel", "eventConfirm"],
  computed: {
    _eventCancel: {
      get: function get() {
        if (this.eventCancel == undefined) {
          return "cancel";
        } else {
          return this.eventCancel;
        }
      }
    },
    _eventConfirm: {
      get: function get() {
        if (this.eventConfirm == undefined) {
          return "confirm";
        } else {
          return this.eventConfirm;
        }
      }
    }
  },
  mounted: function mounted() {
    //
  },
  components: {
    SaldoTanques: _dashboard_SaldoTanques_vue__WEBPACK_IMPORTED_MODULE_0__["default"]
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/modal2.vue?vue&type=script&lang=js":
/*!****************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/modal2.vue?vue&type=script&lang=js ***!
  \****************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
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

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/OsProdutoComponent.vue?vue&type=template&id=d51a349a":
/*!**************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/OsProdutoComponent.vue?vue&type=template&id=d51a349a ***!
  \**************************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "form-group"
  }, [_c("div", {
    staticClass: "row"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.estoque_id,
      expression: "estoque_id"
    }],
    attrs: {
      type: "hidden",
      name: "estoque_id"
    },
    domProps: {
      value: _vm.estoque_id
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.estoque_id = $event.target.value;
      }
    }
  }), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.valor_total,
      expression: "valor_total"
    }],
    attrs: {
      type: "hidden",
      name: "valor_total"
    },
    domProps: {
      value: _vm.valor_total
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.valor_total = $event.target.value;
      }
    }
  }), _vm._v(" "), _c("div", {
    "class": {
      "col-md-7": true,
      " has-error": this.errors.estoqueId
    }
  }, [_c("label", {
    staticClass: "control-label",
    attrs: {
      "for": "estoqueId"
    }
  }, [_vm._v("Estoque")]), _vm._v(" "), _c("select", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.estoqueId,
      expression: "estoqueId"
    }],
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
      change: function change($event) {
        var $$selectedVal = Array.prototype.filter.call($event.target.options, function (o) {
          return o.selected;
        }).map(function (o) {
          var val = "_value" in o ? o._value : o.value;
          return val;
        });
        _vm.estoqueId = $event.target.multiple ? $$selectedVal : $$selectedVal[0];
      }
    }
  }, _vm._l(this.estoques, function (estoque, index) {
    return _c("option", {
      key: index,
      domProps: {
        value: estoque.id
      }
    }, [_vm._v(_vm._s(estoque.id + " - " + estoque.estoque))]);
  }), 0), _vm._v(" "), _c("span", {
    staticClass: "help-block",
    attrs: {
      "v-if": this.errors.estoqueId
    }
  }, [_c("strong", [_vm._v(_vm._s(this.errors.estoqueIdMsg))])])])]), _vm._v(" "), _c("div", {
    staticClass: "card"
  }, [_vm._m(0), _vm._v(" "), _c("div", {
    staticClass: "card-body",
    staticStyle: {
      padding: "0 !important"
    }
  }, [_c("table", {
    staticClass: "table table-sm table-striped table-bordered table-hover",
    staticStyle: {
      "margin-bottom": "0 !important"
    }
  }, [_vm._m(1), _vm._v(" "), _c("transition-group", {
    tag: "tbody",
    attrs: {
      name: "fade"
    }
  }, _vm._l(_vm.produtos, function (item, index) {
    return _c("tr", {
      key: index,
      staticClass: "row m-0"
    }, [_c("td", {
      staticClass: "col-md-1 pool-right"
    }, [_vm._v("\n                            " + _vm._s(item.id) + "\n                            "), _c("input", {
      attrs: {
        type: "hidden",
        name: "produtos[" + index + "][produto_id]"
      },
      domProps: {
        value: item.id
      }
    }), _vm._v(" "), _c("input", {
      attrs: {
        type: "hidden",
        name: "produtos[" + index + "][produto_vencimento_id]"
      },
      domProps: {
        value: item.produto_vencimento_id
      }
    })]), _vm._v(" "), _c("td", {
      staticClass: "col-md-5"
    }, [_vm._v("\n                            " + _vm._s(item.produto_descricao) + "\n                        ")]), _vm._v(" "), _c("td", {
      staticClass: "col-md-1 text-right"
    }, [_vm._v("\n                            " + _vm._s(_vm._f("toDecimal3")(item.quantidade)) + " \n                            "), _c("input", {
      attrs: {
        type: "hidden",
        name: "produtos[" + index + "][quantidade]"
      },
      domProps: {
        value: item.quantidade
      }
    })]), _vm._v(" "), _c("td", {
      staticClass: "col-md-1 text-right"
    }, [_vm._v("\n                            " + _vm._s(_vm._f("toDecimal3")(item.valor_produto)) + "\n                            "), _c("input", {
      attrs: {
        type: "hidden",
        name: "produtos[" + index + "][valor_produto]"
      },
      domProps: {
        value: item.valor_produto
      }
    })]), _vm._v(" "), _c("td", {
      staticClass: "col-md-1 text-right"
    }, [_vm._v("\n                            " + _vm._s(_vm._f("toDecimal3")(item.valor_desconto)) + "\n                            "), _c("input", {
      attrs: {
        type: "hidden",
        name: "produtos[" + index + "][valor_desconto]"
      },
      domProps: {
        value: item.valor_desconto
      }
    })]), _vm._v(" "), _c("td", {
      staticClass: "col-md-1 text-right"
    }, [_vm._v("\n                            " + _vm._s(_vm._f("toDecimal3")(item.valor_acrescimo)) + "\n                            "), _c("input", {
      attrs: {
        type: "hidden",
        name: "produtos[" + index + "][valor_acrescimo]"
      },
      domProps: {
        value: item.valor_acrescimo
      }
    })]), _vm._v(" "), _c("td", {
      staticClass: "col-md-1 text-right"
    }, [_vm._v("\n                            " + _vm._s(_vm._f("toDecimal3")(item.valor_cobrado)) + "\n                            "), _c("input", {
      attrs: {
        type: "hidden",
        name: "produtos[" + index + "][valor_cobrado]"
      },
      domProps: {
        value: item.valor_cobrado
      }
    })]), _vm._v(" "), _c("td", {
      staticClass: "col-md-1"
    }, [_c("button", {
      directives: [{
        name: "show",
        rawName: "v-show",
        value: !_vm.editing,
        expression: "!editing"
      }],
      staticClass: "btn btn-sm btn-warning",
      attrs: {
        type: "button"
      },
      on: {
        click: function click($event) {
          return _vm.editItem(index);
        }
      }
    }, [_c("i", {
      staticClass: "fas fa-edit"
    })]), _vm._v(" "), _c("button", {
      directives: [{
        name: "show",
        rawName: "v-show",
        value: !_vm.editing,
        expression: "!editing"
      }],
      staticClass: "btn btn-sm btn-danger",
      attrs: {
        type: "button",
        "data-toggle": "modal",
        "data-target": "#confirmDelete2"
      },
      on: {
        click: function click($event) {
          return _vm.confirmDeleteProduto(index);
        }
      }
    }, [_c("i", {
      staticClass: "fas fa-trash-alt"
    })])])]);
  }), 0), _vm._v(" "), this.produtos.length > 0 ? _c("tfoot", [_c("tr", {
    staticClass: "row m-0"
  }, [_c("td", {
    staticClass: "col-md-1"
  }, [_c("strong", [_vm._v(_vm._s(this.produtos.length))])]), _vm._v(" "), _c("td", {
    staticClass: "col-md-5"
  }), _vm._v(" "), _c("td", {
    staticClass: "col-md-1 text-right"
  }, [_c("strong", [_vm._v(_vm._s(_vm._f("toDecimal3")(this.totalQuantidade())))])]), _vm._v(" "), _c("td", {
    staticClass: "col-md-1 text-right"
  }, [_c("strong", [_vm._v(_vm._s(_vm._f("toDecimal3")(this.totalValor())))])]), _vm._v(" "), _c("td", {
    staticClass: "col-md-1 text-right"
  }, [_c("strong", [_vm._v(_vm._s(_vm._f("toDecimal3")(this.totalDesconto())))])]), _vm._v(" "), _c("td", {
    staticClass: "col-md-1 text-right"
  }, [_c("strong", [_vm._v(_vm._s(_vm._f("toDecimal3")(this.totalAcrescimo())))])]), _vm._v(" "), _c("td", {
    staticClass: "col-md-1 text-right"
  }, [_c("strong", [_vm._v(_vm._s(_vm._f("toDecimal3")(this.totalCobrado())))])]), _vm._v(" "), _c("td", {
    staticClass: "col-md-2"
  })])]) : _vm._e()], 1)]), _vm._v(" "), _c("div", [_c("div", {
    staticClass: "row m-0"
  }, [_c("div", {
    "class": {
      "col-md-6": true,
      " has-error": this.errors.inputProdutos
    },
    staticStyle: {
      "padding-right": "0 !important",
      "padding-left": "0 !important"
    }
  }, [_c("select", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.produto_id,
      expression: "produto_id"
    }],
    ref: "inputProdutos",
    staticClass: "form-control selectpicker",
    attrs: {
      "data-style": "btn-secondary",
      disabled: _vm.estoqueId == "false" || _vm.estoqueId == null,
      "data-live-search": "true",
      name: "inputProdutos",
      id: "inputProdutos"
    },
    on: {
      change: function change($event) {
        var $$selectedVal = Array.prototype.filter.call($event.target.options, function (o) {
          return o.selected;
        }).map(function (o) {
          var val = "_value" in o ? o._value : o.value;
          return val;
        });
        _vm.produto_id = $event.target.multiple ? $$selectedVal : $$selectedVal[0];
      }
    }
  }, [_c("option", {
    attrs: {
      selected: "",
      value: "false"
    }
  }, [_vm._v("Produto")]), _vm._v(" "), _vm._l(_vm.produtosDisponiveisOrdenados, function (produto, index) {
    return _c("option", {
      key: index,
      domProps: {
        value: produto.id
      }
    }, [_vm._v(_vm._s(produto.id + " - " + produto.produto_descricao))]);
  })], 2), _vm._v(" "), _c("span", {
    staticClass: "help-block",
    attrs: {
      "v-if": this.errors.inputProdutos
    }
  }, [_c("strong", [_vm._v(_vm._s(this.errors.inputProdutosMsg))])])]), _vm._v(" "), _c("div", {
    "class": {
      "col-md-1": true,
      " has-error": this.errors.inputQuantidade
    },
    staticStyle: {
      "padding-right": "0 !important",
      "padding-left": "0 !important"
    }
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model.number",
      value: _vm.quantidade,
      expression: "quantidade",
      modifiers: {
        number: true
      }
    }],
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
    domProps: {
      value: _vm.quantidade
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.quantidade = _vm._n($event.target.value);
      },
      blur: function blur($event) {
        return _vm.$forceUpdate();
      }
    }
  }), _vm._v(" "), _c("span", {
    staticClass: "help-block",
    attrs: {
      "v-if": this.errors.inputQuantidade
    }
  }, [_c("strong", [_vm._v(_vm._s(this.errors.inputQuantidadeMsg))])])]), _vm._v(" "), _c("div", {
    "class": {
      "col-md-1": true,
      " has-error": this.errors.inputValorUnitario
    },
    staticStyle: {
      "padding-right": "0 !important",
      "padding-left": "0 !important"
    }
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model.number",
      value: _vm.valor_unitario,
      expression: "valor_unitario",
      modifiers: {
        number: true
      }
    }],
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
    domProps: {
      value: _vm.valor_unitario
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.valor_unitario = _vm._n($event.target.value);
      },
      blur: function blur($event) {
        return _vm.$forceUpdate();
      }
    }
  }), _vm._v(" "), _c("span", {
    staticClass: "help-block",
    attrs: {
      "v-if": this.errors.inputValorUnitario
    }
  }, [_c("strong", [_vm._v(_vm._s(this.errors.inputValorUnitarioMsg))])])]), _vm._v(" "), _c("div", {
    "class": {
      "col-md-1": true,
      " has-error": this.errors.inputAcrescimo
    },
    staticStyle: {
      "padding-right": "0 !important",
      "padding-left": "0 !important"
    }
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model.number",
      value: _vm.valor_acrescimo,
      expression: "valor_acrescimo",
      modifiers: {
        number: true
      }
    }],
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
    domProps: {
      value: _vm.valor_acrescimo
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.valor_acrescimo = _vm._n($event.target.value);
      },
      blur: function blur($event) {
        return _vm.$forceUpdate();
      }
    }
  }), _vm._v(" "), _c("span", {
    staticClass: "help-block",
    attrs: {
      "v-if": this.errors.inputAcrescimo
    }
  }, [_c("strong", [_vm._v(_vm._s(this.errors.inputAcrescimoMsg))])])]), _vm._v(" "), _c("div", {
    "class": {
      "col-md-1": true,
      " has-error": this.errors.inputDesconto
    },
    staticStyle: {
      "padding-right": "0 !important",
      "padding-left": "0 !important"
    }
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model.number",
      value: _vm.valor_desconto,
      expression: "valor_desconto",
      modifiers: {
        number: true
      }
    }],
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
    domProps: {
      value: _vm.valor_desconto
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.valor_desconto = _vm._n($event.target.value);
      },
      blur: function blur($event) {
        return _vm.$forceUpdate();
      }
    }
  }), _vm._v(" "), _c("span", {
    staticClass: "help-block",
    attrs: {
      "v-if": this.errors.inputDesconto
    }
  }, [_c("strong", [_vm._v(_vm._s(this.errors.inputDescontoMsg))])])]), _vm._v(" "), _c("div", {
    "class": {
      "col-md-1": true,
      " has-error": this.errors.inputValorCobrado
    },
    staticStyle: {
      "padding-right": "0 !important",
      "padding-left": "0 !important"
    }
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model.number",
      value: _vm.valor_cobrado,
      expression: "valor_cobrado",
      modifiers: {
        number: true
      }
    }],
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
    domProps: {
      value: _vm.valor_cobrado
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.valor_cobrado = _vm._n($event.target.value);
      },
      blur: function blur($event) {
        return _vm.$forceUpdate();
      }
    }
  }), _vm._v(" "), _c("span", {
    staticClass: "help-block",
    attrs: {
      "v-if": this.errors.inputValorCobrado
    }
  }, [_c("strong", [_vm._v(_vm._s(this.errors.inputValorCobradoMsg))])])]), _vm._v(" "), _c("div", {
    staticClass: "col-md-1"
  }, [_c("button", {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: !_vm.editing,
      expression: "!editing"
    }],
    staticClass: "btn btn-success",
    attrs: {
      disabled: _vm.estoqueId == "false" || _vm.estoqueId == null,
      type: "button"
    },
    on: {
      click: _vm.addProduto
    }
  }, [_c("i", {
    staticClass: "fas fa-plus"
  })]), _vm._v(" "), _c("button", {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: _vm.editing,
      expression: "editing"
    }],
    staticClass: "btn btn-success",
    attrs: {
      disabled: _vm.estoqueId == "false" || _vm.estoqueId == null,
      type: "button"
    },
    on: {
      click: _vm.updateProduto
    }
  }, [_c("i", {
    staticClass: "fas fa-check"
  })])])])]), _vm._v(" "), _c("modal2", {
    attrs: {
      "modal-title": "Corfirmação",
      "modal-text": "Confirma a remoção deste Item?"
    },
    on: {
      cancel2: _vm.cancelDelete,
      confirm2: _vm.deleteProduto
    }
  })], 1)]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "card-header"
  }, [_c("strong", [_vm._v("Produtos")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("thead", {
    staticClass: "thead-light"
  }, [_c("tr", {
    staticClass: "row m-0"
  }, [_c("th", {
    staticClass: "col-md-1"
  }, [_vm._v("Id")]), _vm._v(" "), _c("th", {
    staticClass: "col-md-5"
  }, [_vm._v("Produto")]), _vm._v(" "), _c("th", {
    staticClass: "col-md-1"
  }, [_vm._v("Qtd")]), _vm._v(" "), _c("th", {
    staticClass: "col-md-1"
  }, [_vm._v("R$ Uni.")]), _vm._v(" "), _c("th", {
    staticClass: "col-md-1"
  }, [_vm._v("R$ Acrés.")]), _vm._v(" "), _c("th", {
    staticClass: "col-md-1"
  }, [_vm._v("R$ Desc.")]), _vm._v(" "), _c("th", {
    staticClass: "col-md-1"
  }, [_vm._v("R$ Final")]), _vm._v(" "), _c("th", {
    staticClass: "col-md-1"
  }, [_vm._v("Ações")])])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/OsServicoComponent.vue?vue&type=template&id=49f03fad":
/*!**************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/OsServicoComponent.vue?vue&type=template&id=49f03fad ***!
  \**************************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "card"
  }, [_vm._m(0), _vm._v(" "), _c("div", {
    staticClass: "card-body",
    staticStyle: {
      padding: "0 !important"
    }
  }, [_c("table", {
    staticClass: "table table-sm table-striped table-bordered table-hover",
    staticStyle: {
      "margin-bottom": "0 !important"
    }
  }, [_vm._m(1), _vm._v(" "), _c("transition-group", {
    tag: "tbody",
    attrs: {
      name: "fade"
    }
  }, _vm._l(_vm.servicosSelecionados, function (item, index) {
    return _c("tr", {
      key: index,
      staticClass: "row m-0"
    }, [_c("td", {
      staticClass: "col-md-1 pool-right"
    }, [_vm._v("\n                        " + _vm._s(item.id) + "\n                        "), _c("input", {
      attrs: {
        type: "hidden",
        name: "servicos[" + index + "][servico_id]"
      },
      domProps: {
        value: item.id
      }
    })]), _vm._v(" "), _c("td", {
      staticClass: "col-md-6"
    }, [_vm._v("\n                        " + _vm._s(item.servico) + "\n                    ")]), _vm._v(" "), _c("td", {
      staticClass: "col-md-1 pool-right"
    }, [_vm._v("\n                        " + _vm._s(_vm._f("toDecimal3")(item.valor_servico)) + "\n                        "), _c("input", {
      attrs: {
        type: "hidden",
        name: "servicos[" + index + "][valor_servico]"
      },
      domProps: {
        value: item.valor_servico
      }
    })]), _vm._v(" "), _c("td", {
      staticClass: "col-md-1 pool-right"
    }, [_vm._v("\n                        " + _vm._s(_vm._f("toDecimal3")(item.valor_acrescimo)) + "\n                        "), _c("input", {
      attrs: {
        type: "hidden",
        name: "servicos[" + index + "][valor_acrescimo]"
      },
      domProps: {
        value: item.valor_acrescimo
      }
    })]), _vm._v(" "), _c("td", {
      staticClass: "col-md-1 pool-right"
    }, [_vm._v("\n                        " + _vm._s(_vm._f("toDecimal3")(item.valor_desconto)) + "\n                        "), _c("input", {
      attrs: {
        type: "hidden",
        name: "servicos[" + index + "][valor_desconto]"
      },
      domProps: {
        value: item.valor_desconto
      }
    })]), _vm._v(" "), _c("td", {
      staticClass: "col-md-1 pool-right"
    }, [_vm._v("\n                        " + _vm._s(_vm._f("toDecimal3")(item.valor_cobrado)) + "\n                        "), _c("input", {
      attrs: {
        type: "hidden",
        name: "servicos[" + index + "][valor_cobrado]"
      },
      domProps: {
        value: item.valor_cobrado
      }
    })]), _vm._v(" "), _c("td", {
      staticClass: "col-md-1"
    }, [_c("button", {
      directives: [{
        name: "show",
        rawName: "v-show",
        value: !_vm.editing,
        expression: "!editing"
      }],
      staticClass: "btn btn-sm btn-warning",
      attrs: {
        type: "button"
      },
      on: {
        click: function click($event) {
          return _vm.editItem(index);
        }
      }
    }, [_c("i", {
      staticClass: "fas fa-edit"
    })]), _vm._v(" "), _c("button", {
      directives: [{
        name: "show",
        rawName: "v-show",
        value: !_vm.editing,
        expression: "!editing"
      }],
      staticClass: "btn btn-sm btn-danger",
      attrs: {
        type: "button",
        "data-toggle": "modal",
        "data-target": "#confirmDelete"
      },
      on: {
        click: function click($event) {
          return _vm.confirmDelete(index);
        }
      }
    }, [_c("i", {
      staticClass: "fas fa-trash-alt"
    })])])]);
  }), 0)], 1)]), _vm._v(" "), _c("div", {
    staticClass: "panel-footer"
  }, [_c("div", {
    staticClass: "row m-0"
  }, [_c("div", {
    "class": {
      "col-md-7": true,
      " has-error": this.errors.inputServicos
    },
    staticStyle: {
      "padding-right": "0 !important",
      "padding-left": "0 !important"
    }
  }, [_c("select", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.servico_id,
      expression: "servico_id"
    }],
    ref: "inputServicos",
    staticClass: "form-control selectpicker",
    attrs: {
      "data-style": "btn-secondary",
      "data-live-search": "true",
      name: "inputServicos",
      id: "inputServicos"
    },
    on: {
      change: function change($event) {
        var $$selectedVal = Array.prototype.filter.call($event.target.options, function (o) {
          return o.selected;
        }).map(function (o) {
          var val = "_value" in o ? o._value : o.value;
          return val;
        });
        _vm.servico_id = $event.target.multiple ? $$selectedVal : $$selectedVal[0];
      }
    }
  }, [_c("option", {
    attrs: {
      selected: "",
      value: "false"
    }
  }, [_vm._v(" Nada Selecionado ")]), _vm._v(" "), _vm._l(_vm.servicosDisponiveisOrdenados, function (servico, index) {
    return _c("option", {
      key: index,
      domProps: {
        value: servico.id
      }
    }, [_vm._v(_vm._s(servico.id + " - " + servico.servico))]);
  })], 2), _vm._v(" "), _c("span", {
    staticClass: "help-block",
    attrs: {
      "v-if": this.errors.inputServicos
    }
  }, [_c("strong", [_vm._v(_vm._s(this.errors.inputServicosMsg))])])]), _vm._v(" "), _c("div", {
    "class": {
      "col-md-1": true,
      " has-error": this.errors.inputValorServico
    },
    staticStyle: {
      "padding-right": "0 !important",
      "padding-left": "0 !important"
    }
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model.number",
      value: _vm.valor_servico,
      expression: "valor_servico",
      modifiers: {
        number: true
      }
    }],
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
    domProps: {
      value: _vm.valor_servico
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.valor_servico = _vm._n($event.target.value);
      },
      blur: function blur($event) {
        return _vm.$forceUpdate();
      }
    }
  }), _vm._v(" "), _c("span", {
    staticClass: "help-block",
    attrs: {
      "v-if": this.errors.inputValorServico
    }
  }, [_c("strong", [_vm._v(_vm._s(this.errors.inputValorServicoMsg))])])]), _vm._v(" "), _c("div", {
    "class": {
      "col-md-1": true,
      " has-error": this.errors.inputValorAcrescimo
    },
    staticStyle: {
      "padding-right": "0 !important",
      "padding-left": "0 !important"
    }
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model.number",
      value: _vm.valor_acrescimo,
      expression: "valor_acrescimo",
      modifiers: {
        number: true
      }
    }],
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
    domProps: {
      value: _vm.valor_acrescimo
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.valor_acrescimo = _vm._n($event.target.value);
      },
      blur: function blur($event) {
        return _vm.$forceUpdate();
      }
    }
  }), _vm._v(" "), _c("span", {
    staticClass: "help-block",
    attrs: {
      "v-if": this.errors.inputValorAcrescimo
    }
  }, [_c("strong", [_vm._v(_vm._s(this.errors.inputValorAcrescimoMsg))])])]), _vm._v(" "), _c("div", {
    "class": {
      "col-md-1": true,
      " has-error": this.errors.inputValorDesconto
    },
    staticStyle: {
      "padding-right": "0 !important",
      "padding-left": "0 !important"
    }
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model.number",
      value: _vm.valor_desconto,
      expression: "valor_desconto",
      modifiers: {
        number: true
      }
    }],
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
    domProps: {
      value: _vm.valor_desconto
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.valor_desconto = _vm._n($event.target.value);
      },
      blur: function blur($event) {
        return _vm.$forceUpdate();
      }
    }
  }), _vm._v(" "), _c("span", {
    staticClass: "help-block",
    attrs: {
      "v-if": this.errors.inputValorDesconto
    }
  }, [_c("strong", [_vm._v(_vm._s(this.errors.inputValorDescontoMsg))])])]), _vm._v(" "), _c("div", {
    "class": {
      "col-md-1": true,
      " has-error": this.errors.inputValorValorCobrado
    },
    staticStyle: {
      "padding-right": "0 !important",
      "padding-left": "0 !important"
    }
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model.number",
      value: _vm.valor_cobrado,
      expression: "valor_cobrado",
      modifiers: {
        number: true
      }
    }],
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
    domProps: {
      value: _vm.valor_cobrado
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.valor_cobrado = _vm._n($event.target.value);
      },
      blur: function blur($event) {
        return _vm.$forceUpdate();
      }
    }
  }), _vm._v(" "), _c("span", {
    staticClass: "help-block",
    attrs: {
      "v-if": this.errors.inputValorValorCobrado
    }
  }, [_c("strong", [_vm._v(_vm._s(this.errors.inputValorValorCobradoMsg))])])]), _vm._v(" "), _c("div", {
    staticClass: "col-md-1"
  }, [_c("button", {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: !_vm.editing,
      expression: "!editing"
    }],
    staticClass: "btn btn-success",
    attrs: {
      type: "button"
    },
    on: {
      click: _vm.addServico
    }
  }, [_c("i", {
    staticClass: "fas fa-plus"
  })]), _vm._v(" "), _c("button", {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: _vm.editing,
      expression: "editing"
    }],
    staticClass: "btn btn-success",
    attrs: {
      type: "button"
    },
    on: {
      click: _vm.updateServico
    }
  }, [_c("i", {
    staticClass: "fas fa-check"
  })])])])]), _vm._v(" "), _c("modal", {
    attrs: {
      "modal-title": "Corfirmação",
      "modal-text": "Confirma a remoção deste Item?"
    },
    on: {
      cancel: _vm.cancelDelete,
      confirm: _vm.deleteItem
    }
  })], 1);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "card-header"
  }, [_c("strong", [_vm._v("Servicos")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("thead", {
    staticClass: "thead-light"
  }, [_c("tr", {
    staticClass: "row m-0"
  }, [_c("th", {
    staticClass: "col-md-1"
  }, [_vm._v("Id")]), _vm._v(" "), _c("th", {
    staticClass: "col-md-6"
  }, [_vm._v("Serviço")]), _vm._v(" "), _c("th", {
    staticClass: "col-md-1"
  }, [_vm._v("R$ Serv.")]), _vm._v(" "), _c("th", {
    staticClass: "col-md-1"
  }, [_vm._v("R$ Acrés.")]), _vm._v(" "), _c("th", {
    staticClass: "col-md-1"
  }, [_vm._v("R$ Desc.")]), _vm._v(" "), _c("th", {
    staticClass: "col-md-1"
  }, [_vm._v("R$ Final")]), _vm._v(" "), _c("th", {
    staticClass: "col-md-1"
  }, [_vm._v("Ações")])])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/dashboard/SaldoTanques.vue?vue&type=template&id=57b9fd10":
/*!******************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/dashboard/SaldoTanques.vue?vue&type=template&id=57b9fd10 ***!
  \******************************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "table-responsive m-0 p-0"
  }, [_c("table", {
    staticClass: "table table-sm table-bordered table-hover m-0"
  }, [_vm._m(0), _vm._v(" "), _c("transition-group", {
    tag: "tbody",
    attrs: {
      name: "fade"
    }
  }, _vm._l(_vm.tanques, function (tanque, index) {
    return _c("tr", {
      key: index,
      staticClass: "row m-0"
    }, [_c("td", {
      staticClass: "col-1 pool-right"
    }, [_vm._v(_vm._s(tanque.id))]), _vm._v(" "), _c("td", {
      staticClass: "col-5 pool-right"
    }, [_vm._v(_vm._s(tanque.descricao_tanque))]), _vm._v(" "), _c("td", {
      staticClass: "col-2 text-right"
    }, [_vm._v(_vm._s(tanque.capacidade))]), _vm._v(" "), _c("td", {
      staticClass: "col-2 text-right"
    }, [_vm._v(_vm._s(tanque.posicao_inicial))]), _vm._v(" "), _c("td", {
      staticClass: "col-2 text-right"
    }, [_vm._v(_vm._s(tanque.posicao_final))])]);
  }), 0)], 1)]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("thead", {
    staticClass: "thead-light"
  }, [_c("tr", {
    staticClass: "row m-0"
  }, [_c("th", {
    staticClass: "col-1"
  }, [_vm._v("ID")]), _vm._v(" "), _c("th", {
    staticClass: "col-5"
  }, [_vm._v("Tanque")]), _vm._v(" "), _c("th", {
    staticClass: "col-2"
  }, [_vm._v("Capacidade")]), _vm._v(" "), _c("th", {
    staticClass: "col-2"
  }, [_vm._v("Estoque Inicial")]), _vm._v(" "), _c("th", {
    staticClass: "col-2"
  }, [_vm._v("Estoque Atual")])])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/modal.vue?vue&type=template&id=478d961c":
/*!*************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/modal.vue?vue&type=template&id=478d961c ***!
  \*************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c("transition", {
    attrs: {
      name: "modal-fade"
    }
  }, [_c("div", {
    staticClass: "modal fade",
    attrs: {
      id: "confirmDelete",
      role: "dialog",
      "aria-labelledby": "confirmDeleteLabel",
      "aria-hidden": "true"
    }
  }, [_c("div", {
    staticClass: "modal-dialog"
  }, [_c("div", {
    staticClass: "modal-content"
  }, [_c("div", {
    staticClass: "modal-header"
  }, [_c("h4", {
    staticClass: "modal-title"
  }, [_c("strong", [_vm._v(_vm._s(this.modalTitle))])]), _vm._v(" "), _c("button", {
    staticClass: "close",
    attrs: {
      type: "button",
      "data-dismiss": "modal",
      "aria-label": "Close"
    }
  }, [_c("span", {
    attrs: {
      "aria-hidden": "true"
    }
  }, [_vm._v("×")])])]), _vm._v(" "), _c("div", {
    staticClass: "modal-body"
  }, [_c("p", [_vm._v("\n              " + _vm._s(this.modalText) + "                  \n            ")]), _vm._v(" "), _vm._t("default")], 2), _vm._v(" "), _c("div", {
    staticClass: "modal-footer"
  }, [_c("button", {
    staticClass: "btn btn-danger",
    attrs: {
      type: "button",
      "data-dismiss": "modal",
      id: "confirm"
    },
    on: {
      click: _vm.confirm
    }
  }, [_vm._v("Remover")]), _vm._v(" "), _c("button", {
    staticClass: "btn btn-primary",
    attrs: {
      type: "button",
      "data-dismiss": "modal"
    },
    on: {
      click: _vm.cancel
    }
  }, [_vm._v("Cancelar")])])])])])]);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/modal2.vue?vue&type=template&id=a9f5daa0":
/*!**************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/modal2.vue?vue&type=template&id=a9f5daa0 ***!
  \**************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c("transition", {
    attrs: {
      name: "modal-fade"
    }
  }, [_c("div", {
    staticClass: "modal fade",
    attrs: {
      id: "confirmDelete2",
      role: "dialog",
      "aria-labelledby": "confirmDeleteLabel",
      "aria-hidden": "true"
    }
  }, [_c("div", {
    staticClass: "modal-dialog"
  }, [_c("div", {
    staticClass: "modal-content modal-default"
  }, [_c("div", {
    staticClass: "modal-header"
  }, [_c("button", {
    staticClass: "close",
    attrs: {
      type: "button",
      "data-dismiss": "modal2",
      "aria-hidden": "true"
    }
  }, [_vm._v("×")]), _vm._v(" "), _c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col-sm-1"
  }, [_c("span", {
    staticClass: "glyphicon glyphicon-alert"
  })]), _vm._v(" "), _c("div", {
    staticClass: "col"
  }, [_c("h4", {
    staticClass: "modal-title"
  }, [_c("strong", [_vm._v(_vm._s(this.modalTitle))])])])])]), _vm._v(" "), _c("div", {
    staticClass: "modal-body"
  }, [_c("p", [_vm._v("\n              " + _vm._s(this.modalText) + "                  \n            ")])]), _vm._v(" "), _c("div", {
    staticClass: "modal-footer"
  }, [_c("button", {
    staticClass: "btn btn-danger",
    attrs: {
      type: "button",
      "data-dismiss": "modal",
      id: "confirm2"
    },
    on: {
      click: _vm.confirm2
    }
  }, [_vm._v("Remover")]), _vm._v(" "), _c("button", {
    staticClass: "btn btn-primary",
    attrs: {
      type: "button",
      "data-dismiss": "modal"
    },
    on: {
      click: _vm.cancel2
    }
  }, [_vm._v("Cancelar")])])])])])]);
};
var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./node_modules/is-buffer/index.js":
/*!*****************************************!*\
  !*** ./node_modules/is-buffer/index.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

/*!
 * Determine if an object is a Buffer
 *
 * @author   Feross Aboukhadijeh <https://feross.org>
 * @license  MIT
 */

module.exports = function isBuffer (obj) {
  return obj != null && obj.constructor != null &&
    typeof obj.constructor.isBuffer === 'function' && obj.constructor.isBuffer(obj)
}


/***/ }),

/***/ "./node_modules/process/browser.js":
/*!*****************************************!*\
  !*** ./node_modules/process/browser.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// shim for using process in browser
var process = module.exports = {};

// cached from whatever global is present so that test runners that stub it
// don't break things.  But we need to wrap it in a try catch in case it is
// wrapped in strict mode code which doesn't define any globals.  It's inside a
// function because try/catches deoptimize in certain engines.

var cachedSetTimeout;
var cachedClearTimeout;

function defaultSetTimout() {
    throw new Error('setTimeout has not been defined');
}
function defaultClearTimeout () {
    throw new Error('clearTimeout has not been defined');
}
(function () {
    try {
        if (typeof setTimeout === 'function') {
            cachedSetTimeout = setTimeout;
        } else {
            cachedSetTimeout = defaultSetTimout;
        }
    } catch (e) {
        cachedSetTimeout = defaultSetTimout;
    }
    try {
        if (typeof clearTimeout === 'function') {
            cachedClearTimeout = clearTimeout;
        } else {
            cachedClearTimeout = defaultClearTimeout;
        }
    } catch (e) {
        cachedClearTimeout = defaultClearTimeout;
    }
} ())
function runTimeout(fun) {
    if (cachedSetTimeout === setTimeout) {
        //normal enviroments in sane situations
        return setTimeout(fun, 0);
    }
    // if setTimeout wasn't available but was latter defined
    if ((cachedSetTimeout === defaultSetTimout || !cachedSetTimeout) && setTimeout) {
        cachedSetTimeout = setTimeout;
        return setTimeout(fun, 0);
    }
    try {
        // when when somebody has screwed with setTimeout but no I.E. maddness
        return cachedSetTimeout(fun, 0);
    } catch(e){
        try {
            // When we are in I.E. but the script has been evaled so I.E. doesn't trust the global object when called normally
            return cachedSetTimeout.call(null, fun, 0);
        } catch(e){
            // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error
            return cachedSetTimeout.call(this, fun, 0);
        }
    }


}
function runClearTimeout(marker) {
    if (cachedClearTimeout === clearTimeout) {
        //normal enviroments in sane situations
        return clearTimeout(marker);
    }
    // if clearTimeout wasn't available but was latter defined
    if ((cachedClearTimeout === defaultClearTimeout || !cachedClearTimeout) && clearTimeout) {
        cachedClearTimeout = clearTimeout;
        return clearTimeout(marker);
    }
    try {
        // when when somebody has screwed with setTimeout but no I.E. maddness
        return cachedClearTimeout(marker);
    } catch (e){
        try {
            // When we are in I.E. but the script has been evaled so I.E. doesn't  trust the global object when called normally
            return cachedClearTimeout.call(null, marker);
        } catch (e){
            // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error.
            // Some versions of I.E. have different rules for clearTimeout vs setTimeout
            return cachedClearTimeout.call(this, marker);
        }
    }



}
var queue = [];
var draining = false;
var currentQueue;
var queueIndex = -1;

function cleanUpNextTick() {
    if (!draining || !currentQueue) {
        return;
    }
    draining = false;
    if (currentQueue.length) {
        queue = currentQueue.concat(queue);
    } else {
        queueIndex = -1;
    }
    if (queue.length) {
        drainQueue();
    }
}

function drainQueue() {
    if (draining) {
        return;
    }
    var timeout = runTimeout(cleanUpNextTick);
    draining = true;

    var len = queue.length;
    while(len) {
        currentQueue = queue;
        queue = [];
        while (++queueIndex < len) {
            if (currentQueue) {
                currentQueue[queueIndex].run();
            }
        }
        queueIndex = -1;
        len = queue.length;
    }
    currentQueue = null;
    draining = false;
    runClearTimeout(timeout);
}

process.nextTick = function (fun) {
    var args = new Array(arguments.length - 1);
    if (arguments.length > 1) {
        for (var i = 1; i < arguments.length; i++) {
            args[i - 1] = arguments[i];
        }
    }
    queue.push(new Item(fun, args));
    if (queue.length === 1 && !draining) {
        runTimeout(drainQueue);
    }
};

// v8 likes predictible objects
function Item(fun, array) {
    this.fun = fun;
    this.array = array;
}
Item.prototype.run = function () {
    this.fun.apply(null, this.array);
};
process.title = 'browser';
process.browser = true;
process.env = {};
process.argv = [];
process.version = ''; // empty string to avoid regexp issues
process.versions = {};

function noop() {}

process.on = noop;
process.addListener = noop;
process.once = noop;
process.off = noop;
process.removeListener = noop;
process.removeAllListeners = noop;
process.emit = noop;
process.prependListener = noop;
process.prependOnceListener = noop;

process.listeners = function (name) { return [] }

process.binding = function (name) {
    throw new Error('process.binding is not supported');
};

process.cwd = function () { return '/' };
process.chdir = function (dir) {
    throw new Error('process.chdir is not supported');
};
process.umask = function() { return 0; };


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

function normalizeComponent(
  scriptExports,
  render,
  staticRenderFns,
  functionalTemplate,
  injectStyles,
  scopeId,
  moduleIdentifier /* server only */,
  shadowMode /* vue-cli only */
) {
  // Vue.extend constructor export interop
  var options =
    typeof scriptExports === 'function' ? scriptExports.options : scriptExports

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
  if (moduleIdentifier) {
    // server build
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
      ? function () {
          injectStyles.call(
            this,
            (options.functional ? this.parent : this).$root.$options.shadowRoot
          )
        }
      : injectStyles
  }

  if (hook) {
    if (options.functional) {
      // for template-only hot-reload because in that case the render fn doesn't
      // go through the normalizer
      options._injectStyles = hook
      // register for functional component in vue file
      var originalRender = options.render
      options.render = function renderWithStyleInjection(h, context) {
        hook.call(context)
        return originalRender(h, context)
      }
    } else {
      // inject component registration as beforeCreate hook
      var existing = options.beforeCreate
      options.beforeCreate = existing ? [].concat(existing, hook) : [hook]
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
/* harmony import */ var _OsProdutoComponent_vue_vue_type_template_id_d51a349a__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./OsProdutoComponent.vue?vue&type=template&id=d51a349a */ "./resources/js/components/OsProdutoComponent.vue?vue&type=template&id=d51a349a");
/* harmony import */ var _OsProdutoComponent_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./OsProdutoComponent.vue?vue&type=script&lang=js */ "./resources/js/components/OsProdutoComponent.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _OsProdutoComponent_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _OsProdutoComponent_vue_vue_type_template_id_d51a349a__WEBPACK_IMPORTED_MODULE_0__["render"],
  _OsProdutoComponent_vue_vue_type_template_id_d51a349a__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
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

/***/ "./resources/js/components/OsProdutoComponent.vue?vue&type=script&lang=js":
/*!********************************************************************************!*\
  !*** ./resources/js/components/OsProdutoComponent.vue?vue&type=script&lang=js ***!
  \********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_OsProdutoComponent_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./OsProdutoComponent.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/OsProdutoComponent.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_OsProdutoComponent_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/OsProdutoComponent.vue?vue&type=template&id=d51a349a":
/*!**************************************************************************************!*\
  !*** ./resources/js/components/OsProdutoComponent.vue?vue&type=template&id=d51a349a ***!
  \**************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_OsProdutoComponent_vue_vue_type_template_id_d51a349a__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../node_modules/vue-loader/lib??vue-loader-options!./OsProdutoComponent.vue?vue&type=template&id=d51a349a */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/OsProdutoComponent.vue?vue&type=template&id=d51a349a");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_OsProdutoComponent_vue_vue_type_template_id_d51a349a__WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_OsProdutoComponent_vue_vue_type_template_id_d51a349a__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/OsServicoComponent.vue":
/*!********************************************************!*\
  !*** ./resources/js/components/OsServicoComponent.vue ***!
  \********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _OsServicoComponent_vue_vue_type_template_id_49f03fad__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./OsServicoComponent.vue?vue&type=template&id=49f03fad */ "./resources/js/components/OsServicoComponent.vue?vue&type=template&id=49f03fad");
/* harmony import */ var _OsServicoComponent_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./OsServicoComponent.vue?vue&type=script&lang=js */ "./resources/js/components/OsServicoComponent.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _OsServicoComponent_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _OsServicoComponent_vue_vue_type_template_id_49f03fad__WEBPACK_IMPORTED_MODULE_0__["render"],
  _OsServicoComponent_vue_vue_type_template_id_49f03fad__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
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

/***/ "./resources/js/components/OsServicoComponent.vue?vue&type=script&lang=js":
/*!********************************************************************************!*\
  !*** ./resources/js/components/OsServicoComponent.vue?vue&type=script&lang=js ***!
  \********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_OsServicoComponent_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./OsServicoComponent.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/OsServicoComponent.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_OsServicoComponent_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/OsServicoComponent.vue?vue&type=template&id=49f03fad":
/*!**************************************************************************************!*\
  !*** ./resources/js/components/OsServicoComponent.vue?vue&type=template&id=49f03fad ***!
  \**************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_OsServicoComponent_vue_vue_type_template_id_49f03fad__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../node_modules/vue-loader/lib??vue-loader-options!./OsServicoComponent.vue?vue&type=template&id=49f03fad */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/OsServicoComponent.vue?vue&type=template&id=49f03fad");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_OsServicoComponent_vue_vue_type_template_id_49f03fad__WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_OsServicoComponent_vue_vue_type_template_id_49f03fad__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/dashboard/SaldoTanques.vue":
/*!************************************************************!*\
  !*** ./resources/js/components/dashboard/SaldoTanques.vue ***!
  \************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _SaldoTanques_vue_vue_type_template_id_57b9fd10__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SaldoTanques.vue?vue&type=template&id=57b9fd10 */ "./resources/js/components/dashboard/SaldoTanques.vue?vue&type=template&id=57b9fd10");
/* harmony import */ var _SaldoTanques_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SaldoTanques.vue?vue&type=script&lang=js */ "./resources/js/components/dashboard/SaldoTanques.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _SaldoTanques_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _SaldoTanques_vue_vue_type_template_id_57b9fd10__WEBPACK_IMPORTED_MODULE_0__["render"],
  _SaldoTanques_vue_vue_type_template_id_57b9fd10__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/dashboard/SaldoTanques.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/dashboard/SaldoTanques.vue?vue&type=script&lang=js":
/*!************************************************************************************!*\
  !*** ./resources/js/components/dashboard/SaldoTanques.vue?vue&type=script&lang=js ***!
  \************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SaldoTanques_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./SaldoTanques.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/dashboard/SaldoTanques.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SaldoTanques_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/dashboard/SaldoTanques.vue?vue&type=template&id=57b9fd10":
/*!******************************************************************************************!*\
  !*** ./resources/js/components/dashboard/SaldoTanques.vue?vue&type=template&id=57b9fd10 ***!
  \******************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_SaldoTanques_vue_vue_type_template_id_57b9fd10__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../../node_modules/vue-loader/lib??vue-loader-options!./SaldoTanques.vue?vue&type=template&id=57b9fd10 */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/dashboard/SaldoTanques.vue?vue&type=template&id=57b9fd10");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_SaldoTanques_vue_vue_type_template_id_57b9fd10__WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_SaldoTanques_vue_vue_type_template_id_57b9fd10__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/modal.vue":
/*!*******************************************!*\
  !*** ./resources/js/components/modal.vue ***!
  \*******************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _modal_vue_vue_type_template_id_478d961c__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./modal.vue?vue&type=template&id=478d961c */ "./resources/js/components/modal.vue?vue&type=template&id=478d961c");
/* harmony import */ var _modal_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./modal.vue?vue&type=script&lang=js */ "./resources/js/components/modal.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _modal_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _modal_vue_vue_type_template_id_478d961c__WEBPACK_IMPORTED_MODULE_0__["render"],
  _modal_vue_vue_type_template_id_478d961c__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
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

/***/ "./resources/js/components/modal.vue?vue&type=script&lang=js":
/*!*******************************************************************!*\
  !*** ./resources/js/components/modal.vue?vue&type=script&lang=js ***!
  \*******************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_modal_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./modal.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/modal.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_modal_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/modal.vue?vue&type=template&id=478d961c":
/*!*************************************************************************!*\
  !*** ./resources/js/components/modal.vue?vue&type=template&id=478d961c ***!
  \*************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_modal_vue_vue_type_template_id_478d961c__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../node_modules/vue-loader/lib??vue-loader-options!./modal.vue?vue&type=template&id=478d961c */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/modal.vue?vue&type=template&id=478d961c");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_modal_vue_vue_type_template_id_478d961c__WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_modal_vue_vue_type_template_id_478d961c__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/modal2.vue":
/*!********************************************!*\
  !*** ./resources/js/components/modal2.vue ***!
  \********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _modal2_vue_vue_type_template_id_a9f5daa0__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./modal2.vue?vue&type=template&id=a9f5daa0 */ "./resources/js/components/modal2.vue?vue&type=template&id=a9f5daa0");
/* harmony import */ var _modal2_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./modal2.vue?vue&type=script&lang=js */ "./resources/js/components/modal2.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _modal2_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _modal2_vue_vue_type_template_id_a9f5daa0__WEBPACK_IMPORTED_MODULE_0__["render"],
  _modal2_vue_vue_type_template_id_a9f5daa0__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
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

/***/ "./resources/js/components/modal2.vue?vue&type=script&lang=js":
/*!********************************************************************!*\
  !*** ./resources/js/components/modal2.vue?vue&type=script&lang=js ***!
  \********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_modal2_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./modal2.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/modal2.vue?vue&type=script&lang=js");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_modal2_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/modal2.vue?vue&type=template&id=a9f5daa0":
/*!**************************************************************************!*\
  !*** ./resources/js/components/modal2.vue?vue&type=template&id=a9f5daa0 ***!
  \**************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_modal2_vue_vue_type_template_id_a9f5daa0__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ref--6!../../../node_modules/vue-loader/lib??vue-loader-options!./modal2.vue?vue&type=template&id=a9f5daa0 */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/modal2.vue?vue&type=template&id=a9f5daa0");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_modal2_vue_vue_type_template_id_a9f5daa0__WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ref_6_node_modules_vue_loader_lib_index_js_vue_loader_options_modal2_vue_vue_type_template_id_a9f5daa0__WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



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

module.exports = __webpack_require__(/*! C:\xampp\htdocs\goldenfrota\resources\js\osservico.js */"./resources/js/osservico.js");


/***/ })

/******/ });