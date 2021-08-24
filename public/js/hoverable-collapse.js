/*
 * ATTENTION: An "eval-source-map" devtool has been used.
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file with attached SourceMaps in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
(self["webpackChunk"] = self["webpackChunk"] || []).push([["/js/hoverable-collapse"],{

/***/ "./resources/js/hoverable-collapse.js":
/*!********************************************!*\
  !*** ./resources/js/hoverable-collapse.js ***!
  \********************************************/
/***/ (() => {

eval("(function ($) {\n  'use strict'; //Open submenu on hover in compact sidebar mode and horizontal menu mode\n\n  $(document).on('mouseenter mouseleave', '.sidebar .nav-item', function (ev) {\n    var body = $('body');\n    var sidebarIconOnly = body.hasClass(\"sidebar-icon-only\");\n    var sidebarFixed = body.hasClass(\"sidebar-fixed\");\n\n    if (!('ontouchstart' in document.documentElement)) {\n      if (sidebarIconOnly) {\n        if (sidebarFixed) {\n          if (ev.type === 'mouseenter') {\n            body.removeClass('sidebar-icon-only');\n          }\n        } else {\n          var $menuItem = $(this);\n\n          if (ev.type === 'mouseenter') {\n            $menuItem.addClass('hover-open');\n          } else {\n            $menuItem.removeClass('hover-open');\n          }\n        }\n      }\n    }\n  });\n})(jQuery);//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvaG92ZXJhYmxlLWNvbGxhcHNlLmpzP2FlMmMiXSwibmFtZXMiOlsiJCIsImRvY3VtZW50Iiwib24iLCJldiIsImJvZHkiLCJzaWRlYmFySWNvbk9ubHkiLCJoYXNDbGFzcyIsInNpZGViYXJGaXhlZCIsImRvY3VtZW50RWxlbWVudCIsInR5cGUiLCJyZW1vdmVDbGFzcyIsIiRtZW51SXRlbSIsImFkZENsYXNzIiwialF1ZXJ5Il0sIm1hcHBpbmdzIjoiQUFBQSxDQUFDLFVBQVNBLENBQVQsRUFBWTtBQUNYLGVBRFcsQ0FFWDs7QUFDQUEsRUFBQUEsQ0FBQyxDQUFDQyxRQUFELENBQUQsQ0FBWUMsRUFBWixDQUFlLHVCQUFmLEVBQXdDLG9CQUF4QyxFQUE4RCxVQUFTQyxFQUFULEVBQWE7QUFDekUsUUFBSUMsSUFBSSxHQUFHSixDQUFDLENBQUMsTUFBRCxDQUFaO0FBQ0EsUUFBSUssZUFBZSxHQUFHRCxJQUFJLENBQUNFLFFBQUwsQ0FBYyxtQkFBZCxDQUF0QjtBQUNBLFFBQUlDLFlBQVksR0FBR0gsSUFBSSxDQUFDRSxRQUFMLENBQWMsZUFBZCxDQUFuQjs7QUFDQSxRQUFJLEVBQUUsa0JBQWtCTCxRQUFRLENBQUNPLGVBQTdCLENBQUosRUFBbUQ7QUFDakQsVUFBSUgsZUFBSixFQUFxQjtBQUNuQixZQUFJRSxZQUFKLEVBQWtCO0FBQ2hCLGNBQUlKLEVBQUUsQ0FBQ00sSUFBSCxLQUFZLFlBQWhCLEVBQThCO0FBQzVCTCxZQUFBQSxJQUFJLENBQUNNLFdBQUwsQ0FBaUIsbUJBQWpCO0FBQ0Q7QUFDRixTQUpELE1BSU87QUFDTCxjQUFJQyxTQUFTLEdBQUdYLENBQUMsQ0FBQyxJQUFELENBQWpCOztBQUNBLGNBQUlHLEVBQUUsQ0FBQ00sSUFBSCxLQUFZLFlBQWhCLEVBQThCO0FBQzVCRSxZQUFBQSxTQUFTLENBQUNDLFFBQVYsQ0FBbUIsWUFBbkI7QUFDRCxXQUZELE1BRU87QUFDTEQsWUFBQUEsU0FBUyxDQUFDRCxXQUFWLENBQXNCLFlBQXRCO0FBQ0Q7QUFDRjtBQUNGO0FBQ0Y7QUFDRixHQXBCRDtBQXFCRCxDQXhCRCxFQXdCR0csTUF4QkgiLCJzb3VyY2VzQ29udGVudCI6WyIoZnVuY3Rpb24oJCkge1xyXG4gICd1c2Ugc3RyaWN0JztcclxuICAvL09wZW4gc3VibWVudSBvbiBob3ZlciBpbiBjb21wYWN0IHNpZGViYXIgbW9kZSBhbmQgaG9yaXpvbnRhbCBtZW51IG1vZGVcclxuICAkKGRvY3VtZW50KS5vbignbW91c2VlbnRlciBtb3VzZWxlYXZlJywgJy5zaWRlYmFyIC5uYXYtaXRlbScsIGZ1bmN0aW9uKGV2KSB7XHJcbiAgICB2YXIgYm9keSA9ICQoJ2JvZHknKTtcclxuICAgIHZhciBzaWRlYmFySWNvbk9ubHkgPSBib2R5Lmhhc0NsYXNzKFwic2lkZWJhci1pY29uLW9ubHlcIik7XHJcbiAgICB2YXIgc2lkZWJhckZpeGVkID0gYm9keS5oYXNDbGFzcyhcInNpZGViYXItZml4ZWRcIik7XHJcbiAgICBpZiAoISgnb250b3VjaHN0YXJ0JyBpbiBkb2N1bWVudC5kb2N1bWVudEVsZW1lbnQpKSB7XHJcbiAgICAgIGlmIChzaWRlYmFySWNvbk9ubHkpIHtcclxuICAgICAgICBpZiAoc2lkZWJhckZpeGVkKSB7XHJcbiAgICAgICAgICBpZiAoZXYudHlwZSA9PT0gJ21vdXNlZW50ZXInKSB7XHJcbiAgICAgICAgICAgIGJvZHkucmVtb3ZlQ2xhc3MoJ3NpZGViYXItaWNvbi1vbmx5Jyk7XHJcbiAgICAgICAgICB9XHJcbiAgICAgICAgfSBlbHNlIHtcclxuICAgICAgICAgIHZhciAkbWVudUl0ZW0gPSAkKHRoaXMpO1xyXG4gICAgICAgICAgaWYgKGV2LnR5cGUgPT09ICdtb3VzZWVudGVyJykge1xyXG4gICAgICAgICAgICAkbWVudUl0ZW0uYWRkQ2xhc3MoJ2hvdmVyLW9wZW4nKVxyXG4gICAgICAgICAgfSBlbHNlIHtcclxuICAgICAgICAgICAgJG1lbnVJdGVtLnJlbW92ZUNsYXNzKCdob3Zlci1vcGVuJylcclxuICAgICAgICAgIH1cclxuICAgICAgICB9XHJcbiAgICAgIH1cclxuICAgIH1cclxuICB9KTtcclxufSkoalF1ZXJ5KTsiXSwiZmlsZSI6Ii4vcmVzb3VyY2VzL2pzL2hvdmVyYWJsZS1jb2xsYXBzZS5qcy5qcyIsInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./resources/js/hoverable-collapse.js\n");

/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ "use strict";
/******/ 
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ var __webpack_exports__ = (__webpack_exec__("./resources/js/hoverable-collapse.js"));
/******/ }
]);