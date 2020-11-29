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
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./js/global.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./js/global.js":
/*!**********************!*\
  !*** ./js/global.js ***!
  \**********************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _scss_global_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../scss/global.scss */ "./scss/global.scss");
/* harmony import */ var _scss_global_scss__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_scss_global_scss__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _ui__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ui */ "./js/ui.js");
//we are importing stylesheets related files here, because putting non-js files as webpack entries generate js as well, see: https://github.com/webpack-contrib/extract-text-webpack-plugin/issues/518


document.addEventListener("DOMContentLoaded", function () {
  _ui__WEBPACK_IMPORTED_MODULE_1__["UI"].init();
  _ui__WEBPACK_IMPORTED_MODULE_1__["UI"].tabs.bind();
});
window.addEventListener('resize', function () {
  _ui__WEBPACK_IMPORTED_MODULE_1__["UI"].init();
});

/***/ }),

/***/ "./js/ui.js":
/*!******************!*\
  !*** ./js/ui.js ***!
  \******************/
/*! exports provided: UI */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "UI", function() { return UI; });
/* harmony import */ var _ui_tabs__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ui/tabs */ "./js/ui/tabs.js");

var UI = {
  mobile: /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent),
  windowWidth: null,
  windowHeight: null,
  debug: true,
  // calculate and store viewport dimensions
  // this method will be bound to window resize event so try not to overload it
  init: function init() {
    this.windowWidth = window.innerWidth;
    this.windowHeight = window.innerHeight;
    if (this.debug) console.log('Window width: ' + this.windowWidth + ', Window height: ' + this.windowHeight);
  },
  tabs: _ui_tabs__WEBPACK_IMPORTED_MODULE_0__["tabs"]
};

/***/ }),

/***/ "./js/ui/tabs.js":
/*!***********************!*\
  !*** ./js/ui/tabs.js ***!
  \***********************/
/*! exports provided: tabs */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "tabs", function() { return tabs; });
/* harmony import */ var _ui__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../ui */ "./js/ui.js");

var tabs = {
  selector: '.ui-tabs',
  tabSelector: '.item--tab',
  tabContentSelector: '.tab__content',
  buttonSelector: '.do-toggle-tab',
  activeClass: 'tab--open',
  bind: function bind() {
    var _this = this;

    var selector = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : this.selector;
    if (document.querySelector(selector) === null) return;
    var tabContainer = document.querySelector(selector);
    var buttons = tabContainer.querySelectorAll(this.buttonSelector);
    buttons.forEach(function (button) {
      button.addEventListener('click', function (event) {
        var target = event.target;
        var tab = target.closest(_this.tabSelector);

        _this.toggleTab(tab);

        event.preventDefault();
      });
    }); //some tabs are open by default (via hardcoded open class in markup), but on mobile we want all tabs collapsed

    if (_ui__WEBPACK_IMPORTED_MODULE_0__["UI"].windowWidth < 960) this.closeAllTabs(tabContainer);
  },
  toggleTab: function toggleTab(tab) {
    var _this2 = this;

    var tabName = tab.dataset.tabName;
    var tabsContainer = tab.closest(this.selector); //target both tab nav item and tab content item via mutual selector

    var tabs = tabsContainer.querySelectorAll('[data-tab-name="' + tabName + '"]'); //we don't want to allow multiple tabs to be opened at once
    //keep in mind this will prevent also from closing current tab - should you need to have all tabs collapsed, introduce "closeSiblings" method with current tab name param

    if (_ui__WEBPACK_IMPORTED_MODULE_0__["UI"].windowWidth < 960) {
      this.closeAllTabs(tabsContainer, tab);
    } else {
      this.closeAllTabs(tabsContainer);
    }

    tabs.forEach(function (tab) {
      if (tab.classList.contains(_this2.activeClass)) {
        _this2.closeTab(tab);
      } else {
        _this2.openTab(tab);
      }
    });
  },
  openTab: function openTab(tab) {
    tab.classList.add(this.activeClass);
    tab.setAttribute('data-collapsed', 'false');
  },
  closeTab: function closeTab(tab) {
    tab.classList.remove(this.activeClass);
    tab.setAttribute('data-collapsed', 'true');
  },

  /**
   * Close all tabs
   * @currentTab {DOM el} - when provide - close all but current (sibligns only)
   */
  closeAllTabs: function closeAllTabs(tabsContainer) {
    var _this3 = this;

    var currentTab = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
    var openedTabs = tabsContainer.querySelectorAll('.' + this.activeClass);
    var currentTabName;

    if (currentTab) {
      currentTabName = currentTab.dataset.tabName;
    }

    openedTabs.forEach(function (tab) {
      var tabName = tab.dataset.tabName;
      if (tabName !== currentTabName) _this3.closeTab(tab);
    });
  }
};

/***/ }),

/***/ "./scss/global.scss":
/*!**************************!*\
  !*** ./scss/global.scss ***!
  \**************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

// extracted by mini-css-extract-plugin

/***/ })

/******/ });
//# sourceMappingURL=global.bundle.js.map