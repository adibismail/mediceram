/*
 * ATTENTION: An "eval-source-map" devtool has been used.
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file with attached SourceMaps in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
(self["webpackChunk"] = self["webpackChunk"] || []).push([["/js/misc"],{

/***/ "./resources/js/misc.js":
/*!******************************!*\
  !*** ./resources/js/misc.js ***!
  \******************************/
/***/ (() => {

eval("(function ($) {\n  'use strict';\n\n  $(function () {\n    var body = $('body');\n    var contentWrapper = $('.content-wrapper');\n    var scroller = $('.container-scroller');\n    var footer = $('.footer');\n    var sidebar = $('.sidebar'); //Add active class to nav-link based on url dynamically\n    //Active class can be hard coded directly in html file also as required\n\n    function addActiveClass(element) {\n      if (current === \"\") {\n        //for root url\n        if (element.attr('href').indexOf(\"index.html\") !== -1) {\n          element.parents('.nav-item').last().addClass('active');\n\n          if (element.parents('.sub-menu').length) {\n            element.closest('.collapse').addClass('show');\n            element.addClass('active');\n          }\n        }\n      } else {\n        //for other url\n        if (element.attr('href').indexOf(current) !== -1) {\n          element.parents('.nav-item').last().addClass('active');\n\n          if (element.parents('.sub-menu').length) {\n            element.closest('.collapse').addClass('show');\n            element.addClass('active');\n          }\n\n          if (element.parents('.submenu-item').length) {\n            element.addClass('active');\n          }\n        }\n      }\n    }\n\n    var current = location.pathname.split(\"/\").slice(-1)[0].replace(/^\\/|\\/$/g, '');\n    $('.nav li a', sidebar).each(function () {\n      var $this = $(this);\n      addActiveClass($this);\n    });\n    $('.horizontal-menu .nav li a').each(function () {\n      var $this = $(this);\n      addActiveClass($this);\n    }); //Close other submenu in sidebar on opening any\n\n    sidebar.on('show.bs.collapse', '.collapse', function () {\n      sidebar.find('.collapse.show').collapse('hide');\n    }); //Change sidebar and content-wrapper height\n\n    applyStyles();\n\n    function applyStyles() {\n      //Applying perfect scrollbar\n      if (!body.hasClass(\"rtl\")) {\n        if ($('.settings-panel .tab-content .tab-pane.scroll-wrapper').length) {\n          var settingsPanelScroll = new PerfectScrollbar('.settings-panel .tab-content .tab-pane.scroll-wrapper');\n        }\n\n        if ($('.chats').length) {\n          var chatsScroll = new PerfectScrollbar('.chats');\n        }\n\n        if (body.hasClass(\"sidebar-fixed\")) {\n          var fixedSidebarScroll = new PerfectScrollbar('#sidebar .nav');\n        }\n      }\n    }\n\n    $('[data-toggle=\"minimize\"]').on(\"click\", function () {\n      if (body.hasClass('sidebar-toggle-display') || body.hasClass('sidebar-absolute')) {\n        body.toggleClass('sidebar-hidden');\n      } else {\n        body.toggleClass('sidebar-icon-only');\n      }\n    }); //checkbox and radios\n\n    $(\".form-check label,.form-radio label\").append('<i class=\"input-helper\"></i>'); //fullscreen\n\n    $(\"#fullscreen-button\").on(\"click\", function toggleFullScreen() {\n      if (document.fullScreenElement !== undefined && document.fullScreenElement === null || document.msFullscreenElement !== undefined && document.msFullscreenElement === null || document.mozFullScreen !== undefined && !document.mozFullScreen || document.webkitIsFullScreen !== undefined && !document.webkitIsFullScreen) {\n        if (document.documentElement.requestFullScreen) {\n          document.documentElement.requestFullScreen();\n        } else if (document.documentElement.mozRequestFullScreen) {\n          document.documentElement.mozRequestFullScreen();\n        } else if (document.documentElement.webkitRequestFullScreen) {\n          document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);\n        } else if (document.documentElement.msRequestFullscreen) {\n          document.documentElement.msRequestFullscreen();\n        }\n      } else {\n        if (document.cancelFullScreen) {\n          document.cancelFullScreen();\n        } else if (document.mozCancelFullScreen) {\n          document.mozCancelFullScreen();\n        } else if (document.webkitCancelFullScreen) {\n          document.webkitCancelFullScreen();\n        } else if (document.msExitFullscreen) {\n          document.msExitFullscreen();\n        }\n      }\n    });\n  });\n})(jQuery);//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvbWlzYy5qcz8wYmE3Il0sIm5hbWVzIjpbIiQiLCJib2R5IiwiY29udGVudFdyYXBwZXIiLCJzY3JvbGxlciIsImZvb3RlciIsInNpZGViYXIiLCJhZGRBY3RpdmVDbGFzcyIsImVsZW1lbnQiLCJjdXJyZW50IiwiYXR0ciIsImluZGV4T2YiLCJwYXJlbnRzIiwibGFzdCIsImFkZENsYXNzIiwibGVuZ3RoIiwiY2xvc2VzdCIsImxvY2F0aW9uIiwicGF0aG5hbWUiLCJzcGxpdCIsInNsaWNlIiwicmVwbGFjZSIsImVhY2giLCIkdGhpcyIsIm9uIiwiZmluZCIsImNvbGxhcHNlIiwiYXBwbHlTdHlsZXMiLCJoYXNDbGFzcyIsInNldHRpbmdzUGFuZWxTY3JvbGwiLCJQZXJmZWN0U2Nyb2xsYmFyIiwiY2hhdHNTY3JvbGwiLCJmaXhlZFNpZGViYXJTY3JvbGwiLCJ0b2dnbGVDbGFzcyIsImFwcGVuZCIsInRvZ2dsZUZ1bGxTY3JlZW4iLCJkb2N1bWVudCIsImZ1bGxTY3JlZW5FbGVtZW50IiwidW5kZWZpbmVkIiwibXNGdWxsc2NyZWVuRWxlbWVudCIsIm1vekZ1bGxTY3JlZW4iLCJ3ZWJraXRJc0Z1bGxTY3JlZW4iLCJkb2N1bWVudEVsZW1lbnQiLCJyZXF1ZXN0RnVsbFNjcmVlbiIsIm1velJlcXVlc3RGdWxsU2NyZWVuIiwid2Via2l0UmVxdWVzdEZ1bGxTY3JlZW4iLCJFbGVtZW50IiwiQUxMT1dfS0VZQk9BUkRfSU5QVVQiLCJtc1JlcXVlc3RGdWxsc2NyZWVuIiwiY2FuY2VsRnVsbFNjcmVlbiIsIm1vekNhbmNlbEZ1bGxTY3JlZW4iLCJ3ZWJraXRDYW5jZWxGdWxsU2NyZWVuIiwibXNFeGl0RnVsbHNjcmVlbiIsImpRdWVyeSJdLCJtYXBwaW5ncyI6IkFBQUEsQ0FBQyxVQUFTQSxDQUFULEVBQVk7QUFDWDs7QUFDQUEsRUFBQUEsQ0FBQyxDQUFDLFlBQVc7QUFDWCxRQUFJQyxJQUFJLEdBQUdELENBQUMs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QUFBLFFBQVEsQ0FBQ2dCLGdCQUFUO0FBQ0Q7QUFDRjtBQUNGLEtBdEJEO0FBdUJELEdBMUdBLENBQUQ7QUEyR0QsQ0E3R0QsRUE2R0dDLE1BN0dIIiwic291cmNlc0NvbnRlbnQiOlsiKGZ1bmN0aW9uKCQpIHtcclxuICAndXNlIHN0cmljdCc7XHJcbiAgJChmdW5jdGlvbigpIHtcclxuICAgIHZhciBib2R5ID0gJCgnYm9keScpO1xyXG4gICAgdmFyIGNvbnRlbnRXcmFwcGVyID0gJCgnLmNvbnRlbnQtd3JhcHBlcicpO1xyXG4gICAgdmFyIHNjcm9sbGVyID0gJCgnLmNvbnRhaW5lci1zY3JvbGxlcicpO1xyXG4gICAgdmFyIGZvb3RlciA9ICQoJy5mb290ZXInKTtcclxuICAgIHZhciBzaWRlYmFyID0gJCgnLnNpZGViYXInKTtcclxuXHJcbiAgICAvL0FkZCBhY3RpdmUgY2xhc3MgdG8gbmF2LWxpbmsgYmFzZWQgb24gdXJsIGR5bmFtaWNhbGx5XHJcbiAgICAvL0FjdGl2ZSBjbGFzcyBjYW4gYmUgaGFyZCBjb2RlZCBkaXJlY3RseSBpbiBodG1sIGZpbGUgYWxzbyBhcyByZXF1aXJlZFxyXG5cclxuICAgIGZ1bmN0aW9uIGFkZEFjdGl2ZUNsYXNzKGVsZW1lbnQpIHtcclxuICAgICAgaWYgKGN1cnJlbnQgPT09IFwiXCIpIHtcclxuICAgICAgICAvL2ZvciByb290IHVybFxyXG4gICAgICAgIGlmIChlbGVtZW50LmF0dHIoJ2hyZWYnKS5pbmRleE9mKFwiaW5kZXguaHRtbFwiKSAhPT0gLTEpIHtcclxuICAgICAgICAgIGVsZW1lbnQucGFyZW50cygnLm5hdi1pdGVtJykubGFzdCgpLmFkZENsYXNzKCdhY3RpdmUnKTtcclxuICAgICAgICAgIGlmIChlbGVtZW50LnBhcmVudHMoJy5zdWItbWVudScpLmxlbmd0aCkge1xyXG4gICAgICAgICAgICBlbGVtZW50LmNsb3Nlc3QoJy5jb2xsYXBzZScpLmFkZENsYXNzKCdzaG93Jyk7XHJcbiAgICAgICAgICAgIGVsZW1lbnQuYWRkQ2xhc3MoJ2FjdGl2ZScpO1xyXG4gICAgICAgICAgfVxyXG4gICAgICAgIH1cclxuICAgICAgfSBlbHNlIHtcclxuICAgICAgICAvL2ZvciBvdGhlciB1cmxcclxuICAgICAgICBpZiAoZWxlbWVudC5hdHRyKCdocmVmJykuaW5kZXhPZihjdXJyZW50KSAhPT0gLTEpIHtcclxuICAgICAgICAgIGVsZW1lbnQucGFyZW50cygnLm5hdi1pdGVtJykubGFzdCgpLmFkZENsYXNzKCdhY3RpdmUnKTtcclxuICAgICAgICAgIGlmIChlbGVtZW50LnBhcmVudHMoJy5zdWItbWVudScpLmxlbmd0aCkge1xyXG4gICAgICAgICAgICBlbGVtZW50LmNsb3Nlc3QoJy5jb2xsYXBzZScpLmFkZENsYXNzKCdzaG93Jyk7XHJcbiAgICAgICAgICAgIGVsZW1lbnQuYWRkQ2xhc3MoJ2FjdGl2ZScpO1xyXG4gICAgICAgICAgfVxyXG4gICAgICAgICAgaWYgKGVsZW1lbnQucGFyZW50cygnLnN1Ym1lbnUtaXRlbScpLmxlbmd0aCkge1xyXG4gICAgICAgICAgICBlbGVtZW50LmFkZENsYXNzKCdhY3RpdmUnKTtcclxuICAgICAgICAgIH1cclxuICAgICAgICB9XHJcbiAgICAgIH1cclxuICAgIH1cclxuXHJcbiAgICB2YXIgY3VycmVudCA9IGxvY2F0aW9uLnBhdGhuYW1lLnNwbGl0KFwiL1wiKS5zbGljZSgtMSlbMF0ucmVwbGFjZSgvXlxcL3xcXC8kL2csICcnKTtcclxuICAgICQoJy5uYXYgbGkgYScsIHNpZGViYXIpLmVhY2goZnVuY3Rpb24oKSB7XHJcbiAgICAgIHZhciAkdGhpcyA9ICQodGhpcyk7XHJcbiAgICAgIGFkZEFjdGl2ZUNsYXNzKCR0aGlzKTtcclxuICAgIH0pXHJcblxyXG4gICAgJCgnLmhvcml6b250YWwtbWVudSAubmF2IGxpIGEnKS5lYWNoKGZ1bmN0aW9uKCkge1xyXG4gICAgICB2YXIgJHRoaXMgPSAkKHRoaXMpO1xyXG4gICAgICBhZGRBY3RpdmVDbGFzcygkdGhpcyk7XHJcbiAgICB9KVxyXG5cclxuICAgIC8vQ2xvc2Ugb3RoZXIgc3VibWVudSBpbiBzaWRlYmFyIG9uIG9wZW5pbmcgYW55XHJcblxyXG4gICAgc2lkZWJhci5vbignc2hvdy5icy5jb2xsYXBzZScsICcuY29sbGFwc2UnLCBmdW5jdGlvbigpIHtcclxuICAgICAgc2lkZWJhci5maW5kKCcuY29sbGFwc2Uuc2hvdycpLmNvbGxhcHNlKCdoaWRlJyk7XHJcbiAgICB9KTtcclxuXHJcblxyXG4gICAgLy9DaGFuZ2Ugc2lkZWJhciBhbmQgY29udGVudC13cmFwcGVyIGhlaWdodFxyXG4gICAgYXBwbHlTdHlsZXMoKTtcclxuXHJcbiAgICBmdW5jdGlvbiBhcHBseVN0eWxlcygpIHtcclxuICAgICAgLy9BcHBseWluZyBwZXJmZWN0IHNjcm9sbGJhclxyXG4gICAgICBpZiAoIWJvZHkuaGFzQ2xhc3MoXCJydGxcIikpIHtcclxuICAgICAgICBpZiAoJCgnLnNldHRpbmdzLXBhbmVsIC50YWItY29udGVudCAudGFiLXBhbmUuc2Nyb2xsLXdyYXBwZXInKS5sZW5ndGgpIHtcclxuICAgICAgICAgIGNvbnN0IHNldHRpbmdzUGFuZWxTY3JvbGwgPSBuZXcgUGVyZmVjdFNjcm9sbGJhcignLnNldHRpbmdzLXBhbmVsIC50YWItY29udGVudCAudGFiLXBhbmUuc2Nyb2xsLXdyYXBwZXInKTtcclxuICAgICAgICB9XHJcbiAgICAgICAgaWYgKCQoJy5jaGF0cycpLmxlbmd0aCkge1xyXG4gICAgICAgICAgY29uc3QgY2hhdHNTY3JvbGwgPSBuZXcgUGVyZmVjdFNjcm9sbGJhcignLmNoYXRzJyk7XHJcbiAgICAgICAgfVxyXG4gICAgICAgIGlmIChib2R5Lmhhc0NsYXNzKFwic2lkZWJhci1maXhlZFwiKSkge1xyXG4gICAgICAgICAgdmFyIGZpeGVkU2lkZWJhclNjcm9sbCA9IG5ldyBQZXJmZWN0U2Nyb2xsYmFyKCcjc2lkZWJhciAubmF2Jyk7XHJcbiAgICAgICAgfVxyXG4gICAgICB9XHJcbiAgICB9XHJcblxyXG4gICAgJCgnW2RhdGEtdG9nZ2xlPVwibWluaW1pemVcIl0nKS5vbihcImNsaWNrXCIsIGZ1bmN0aW9uKCkge1xyXG4gICAgICBpZiAoKGJvZHkuaGFzQ2xhc3MoJ3NpZGViYXItdG9nZ2xlLWRpc3BsYXknKSkgfHwgKGJvZHkuaGFzQ2xhc3MoJ3NpZGViYXItYWJzb2x1dGUnKSkpIHtcclxuICAgICAgICBib2R5LnRvZ2dsZUNsYXNzKCdzaWRlYmFyLWhpZGRlbicpO1xyXG4gICAgICB9IGVsc2Uge1xyXG4gICAgICAgIGJvZHkudG9nZ2xlQ2xhc3MoJ3NpZGViYXItaWNvbi1vbmx5Jyk7XHJcbiAgICAgIH1cclxuICAgIH0pO1xyXG5cclxuICAgIC8vY2hlY2tib3ggYW5kIHJhZGlvc1xyXG4gICAgJChcIi5mb3JtLWNoZWNrIGxhYmVsLC5mb3JtLXJhZGlvIGxhYmVsXCIpLmFwcGVuZCgnPGkgY2xhc3M9XCJpbnB1dC1oZWxwZXJcIj48L2k+Jyk7XHJcblxyXG4gICAgLy9mdWxsc2NyZWVuXHJcbiAgICAkKFwiI2Z1bGxzY3JlZW4tYnV0dG9uXCIpLm9uKFwiY2xpY2tcIiwgZnVuY3Rpb24gdG9nZ2xlRnVsbFNjcmVlbigpIHtcclxuICAgICAgaWYgKChkb2N1bWVudC5mdWxsU2NyZWVuRWxlbWVudCAhPT0gdW5kZWZpbmVkICYmIGRvY3VtZW50LmZ1bGxTY3JlZW5FbGVtZW50ID09PSBudWxsKSB8fCAoZG9jdW1lbnQubXNGdWxsc2NyZWVuRWxlbWVudCAhPT0gdW5kZWZpbmVkICYmIGRvY3VtZW50Lm1zRnVsbHNjcmVlbkVsZW1lbnQgPT09IG51bGwpIHx8IChkb2N1bWVudC5tb3pGdWxsU2NyZWVuICE9PSB1bmRlZmluZWQgJiYgIWRvY3VtZW50Lm1vekZ1bGxTY3JlZW4pIHx8IChkb2N1bWVudC53ZWJraXRJc0Z1bGxTY3JlZW4gIT09IHVuZGVmaW5lZCAmJiAhZG9jdW1lbnQud2Via2l0SXNGdWxsU2NyZWVuKSkge1xyXG4gICAgICAgIGlmIChkb2N1bWVudC5kb2N1bWVudEVsZW1lbnQucmVxdWVzdEZ1bGxTY3JlZW4pIHtcclxuICAgICAgICAgIGRvY3VtZW50LmRvY3VtZW50RWxlbWVudC5yZXF1ZXN0RnVsbFNjcmVlbigpO1xyXG4gICAgICAgIH0gZWxzZSBpZiAoZG9jdW1lbnQuZG9jdW1lbnRFbGVtZW50Lm1velJlcXVlc3RGdWxsU2NyZWVuKSB7XHJcbiAgICAgICAgICBkb2N1bWVudC5kb2N1bWVudEVsZW1lbnQubW96UmVxdWVzdEZ1bGxTY3JlZW4oKTtcclxuICAgICAgICB9IGVsc2UgaWYgKGRvY3VtZW50LmRvY3VtZW50RWxlbWVudC53ZWJraXRSZXF1ZXN0RnVsbFNjcmVlbikge1xyXG4gICAgICAgICAgZG9jdW1lbnQuZG9jdW1lbnRFbGVtZW50LndlYmtpdFJlcXVlc3RGdWxsU2NyZWVuKEVsZW1lbnQuQUxMT1dfS0VZQk9BUkRfSU5QVVQpO1xyXG4gICAgICAgIH0gZWxzZSBpZiAoZG9jdW1lbnQuZG9jdW1lbnRFbGVtZW50Lm1zUmVxdWVzdEZ1bGxzY3JlZW4pIHtcclxuICAgICAgICAgIGRvY3VtZW50LmRvY3VtZW50RWxlbWVudC5tc1JlcXVlc3RGdWxsc2NyZWVuKCk7XHJcbiAgICAgICAgfVxyXG4gICAgICB9IGVsc2Uge1xyXG4gICAgICAgIGlmIChkb2N1bWVudC5jYW5jZWxGdWxsU2NyZWVuKSB7XHJcbiAgICAgICAgICBkb2N1bWVudC5jYW5jZWxGdWxsU2NyZWVuKCk7XHJcbiAgICAgICAgfSBlbHNlIGlmIChkb2N1bWVudC5tb3pDYW5jZWxGdWxsU2NyZWVuKSB7XHJcbiAgICAgICAgICBkb2N1bWVudC5tb3pDYW5jZWxGdWxsU2NyZWVuKCk7XHJcbiAgICAgICAgfSBlbHNlIGlmIChkb2N1bWVudC53ZWJraXRDYW5jZWxGdWxsU2NyZWVuKSB7XHJcbiAgICAgICAgICBkb2N1bWVudC53ZWJraXRDYW5jZWxGdWxsU2NyZWVuKCk7XHJcbiAgICAgICAgfSBlbHNlIGlmIChkb2N1bWVudC5tc0V4aXRGdWxsc2NyZWVuKSB7XHJcbiAgICAgICAgICBkb2N1bWVudC5tc0V4aXRGdWxsc2NyZWVuKCk7XHJcbiAgICAgICAgfVxyXG4gICAgICB9XHJcbiAgICB9KVxyXG4gIH0pO1xyXG59KShqUXVlcnkpOyJdLCJmaWxlIjoiLi9yZXNvdXJjZXMvanMvbWlzYy5qcy5qcyIsInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./resources/js/misc.js\n");

/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ "use strict";
/******/ 
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ var __webpack_exports__ = (__webpack_exec__("./resources/js/misc.js"));
/******/ }
]);