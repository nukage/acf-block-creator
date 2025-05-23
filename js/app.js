/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/***/ (() => {

function _toConsumableArray(r) { return _arrayWithoutHoles(r) || _iterableToArray(r) || _unsupportedIterableToArray(r) || _nonIterableSpread(); }
function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
function _unsupportedIterableToArray(r, a) { if (r) { if ("string" == typeof r) return _arrayLikeToArray(r, a); var t = {}.toString.call(r).slice(8, -1); return "Object" === t && r.constructor && (t = r.constructor.name), "Map" === t || "Set" === t ? Array.from(r) : "Arguments" === t || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t) ? _arrayLikeToArray(r, a) : void 0; } }
function _iterableToArray(r) { if ("undefined" != typeof Symbol && null != r[Symbol.iterator] || null != r["@@iterator"]) return Array.from(r); }
function _arrayWithoutHoles(r) { if (Array.isArray(r)) return _arrayLikeToArray(r); }
function _arrayLikeToArray(r, a) { (null == a || a > r.length) && (a = r.length); for (var e = 0, n = Array(a); e < a; e++) n[e] = r[e]; return n; }
jQuery(document).ready(function ($) {
  // STYLE PREVIEW

  var nkg_groups = document.querySelectorAll(".nkg-group-hidden, .nkg-hidden");
  var nkg_parents = document.querySelectorAll('[data-acf-mode="parent"]');
  // If there's no hidden groups on this page, don't run any code.
  if (!nkg_groups[0]) {
    return;
  }
  $("[data-style]").each(function () {
    $(this).next().attr("style", $(this).attr("data-style"));
  });

  // Check for data-attributes and add them to their sibling element - great for Alpine.js etc
  nkg_groups.forEach(function (element) {
    var nextElement = element.nextElementSibling;
    var dataAttributes = element.dataset.attributes ? JSON.parse(element.dataset.attributes) : false;
    if (dataAttributes && nextElement) {
      for (var attribute in dataAttributes) {
        nextElement.setAttribute(attribute, dataAttributes[attribute]);
      }
    }
    replaceATags(element, nextElement);
  });
  function replaceATags(acf_parent, acf_root) {
    var _acf_parent$dataset;
    if ((acf_parent === null || acf_parent === void 0 || (_acf_parent$dataset = acf_parent.dataset) === null || _acf_parent$dataset === void 0 ? void 0 : _acf_parent$dataset.element) == 'a') {
      console.log("element.dataset.element", acf_parent.dataset.element);
      var aElement = acf_root.outerHTML.replace(/^<div/, '<a').replace(/<\/div>$/, '</a>');
      acf_root.outerHTML = aElement;
    }
  }
  var devMode = document.body.classList.contains("nkg-dev-mode") ? true : false;
  var cssMode = document.body.classList.contains("nkg-css-mode") ? true : false;
  var acf_parent = document.querySelector('[data-acf-mode="parent"]');
  var acf_root = acf_parent === null || acf_parent === void 0 ? void 0 : acf_parent.nextElementSibling;
  function removeHidden(acf_parent) {
    var _acf_parent$nextEleme;
    var hiddenElements = acf_parent === null || acf_parent === void 0 || (_acf_parent$nextEleme = acf_parent.nextElementSibling) === null || _acf_parent$nextEleme === void 0 ? void 0 : _acf_parent$nextEleme.querySelectorAll(".nkg-hidden, .nkg-group-hidden");
    hiddenElements.forEach(function (element) {
      element.parentNode.removeChild(element);
    });
    acf_parent.parentNode.removeChild(acf_parent);
  }
  ///-----------------------RENDER MODE -----------------------------

  if (devMode) {
    // Clean up hidden elements

    nkg_parents.forEach(function (acf_parent) {
      removeHidden(acf_parent);
    });
  } else {
    // Get ACF JSON and Block.JSON
    var get_block_json = function get_block_json(acf_parent) {
      var _acf_parent$dataset2;
      var acf_block = acf_parent === null || acf_parent === void 0 || (_acf_parent$dataset2 = acf_parent.dataset) === null || _acf_parent$dataset2 === void 0 ? void 0 : _acf_parent$dataset2.block;
      console.log(acf_block);
      var acf_block_json = acf_block !== undefined ? JSON.parse(acf_parent.dataset.block) : "";

      // console.log(
      // 	`-----> BLOCK.JSON FOR: ${acf_block_json.title}`,
      // 	acf_block_json
      // );
      return acf_block_json;
    }; // get_block_json();
    var get_acf_json = function get_acf_json(acf_parent) {
      var _acf_parent$dataset3, _acf_parent$dataset4, _acf_parent$dataset5;
      var acf_root = acf_parent === null || acf_parent === void 0 ? void 0 : acf_parent.nextElementSibling;
      var acf_data = acf_parent === null || acf_parent === void 0 || (_acf_parent$dataset3 = acf_parent.dataset) === null || _acf_parent$dataset3 === void 0 ? void 0 : _acf_parent$dataset3.acf;
      if (!acf_data) {
        return;
      }
      console.log('acf_data', acf_data);
      var acf_parent_name = acf_parent === null || acf_parent === void 0 || (_acf_parent$dataset4 = acf_parent.dataset) === null || _acf_parent$dataset4 === void 0 ? void 0 : _acf_parent$dataset4.name;
      var acf_parent_title = acf_parent === null || acf_parent === void 0 || (_acf_parent$dataset5 = acf_parent.dataset) === null || _acf_parent$dataset5 === void 0 ? void 0 : _acf_parent$dataset5.title;
      var acf_data_json = acf_data !== undefined ? JSON.parse(acf_data) : "";
      var acf_parent_key = acf_data_json.key;
      var acf_children = acf_root ? acf_root === null || acf_root === void 0 ? void 0 : acf_root.querySelectorAll('[data-acf-mode="child"], [data-acf-mode="repeater"]') : "";
      var fields = acf_data_json !== null && acf_data_json !== void 0 && acf_data_json.fields ? acf_data_json.fields : [];
      if (acf_children) {
        // Object to keep track of label counts
        // Function to process the child field and update accordingly
        var processChildField = function processChildField(childElement, childField, parentKey, parentLabel, parentName, index) {
          var namesep = arguments.length > 6 && arguments[6] !== undefined ? arguments[6] : '-';
          if (childElement.dataset.acfId == 'inherit') {
            console.log('inherit found');
            childField.key = parentKey + '_' + index;
            if (parentLabel) {
              childField.label = parentLabel + ' ' + childField.label;
            }

            // if (parentName && parentName!== 'false') {
            // 	childField.name = parentName + '-' + childField.name;
            // }

            // Manage the label count for the same label
            if (labelCount[childField.label]) {
              labelCount[childField.label] += 1; // Increment count
              childField.name = childField.name + '-' + labelCount[childField.label]; // Append the count to the name if you want unique CSS classes
              childField.label += ' ' + labelCount[childField.label]; // Append the count to the label
            } else {
              labelCount[childField.label] = 1; // Initialize count
            }
            if (parentName) {
              childField.name = parentName + namesep + childField.name;
            }
            childElement.dataset.nameOrig = childElement.dataset.name;
            childElement.dataset.name = childField.name;
            if (cssMode) {
              // childElement.classList = childField.name;
            }
          }
          return childField;
        };
        var labelCount = {};
        acf_children.forEach(function (element, index) {
          var _element$dataset;
          if (element !== null && element !== void 0 && (_element$dataset = element.dataset) !== null && _element$dataset !== void 0 && _element$dataset.acf) {
            var _element$dataset2;
            if ((element === null || element === void 0 || (_element$dataset2 = element.dataset) === null || _element$dataset2 === void 0 ? void 0 : _element$dataset2.acfMode) === "repeater") {
              var _element$nextElementS;
              var repeaterField = JSON.parse(element.dataset.acf);
              console.log('repeaterField', repeaterField);
              var repeaterKey = repeaterField.key;
              var repeaterSingleTitle = element.dataset.acfSingleTitle;
              var repeaterName = repeaterField.name;
              console.log('repeaterSingleTitle', repeaterSingleTitle);
              var acf_repeater_children = element === null || element === void 0 || (_element$nextElementS = element.nextElementSibling) === null || _element$nextElementS === void 0 ? void 0 : _element$nextElementS.querySelectorAll('[data-acf-mode="child"]');
              var acf_repeater_children_fields = [];
              if (acf_repeater_children) {
                acf_repeater_children.forEach(function (childElement, index) {
                  var _childElement$dataset;
                  if (childElement !== null && childElement !== void 0 && (_childElement$dataset = childElement.dataset) !== null && _childElement$dataset !== void 0 && _childElement$dataset.acf) {
                    var childField = JSON.parse(childElement.dataset.acf);
                    var processedChildField = processChildField(childElement, childField, repeaterKey, repeaterSingleTitle, repeaterName, index);
                    acf_repeater_children_fields.push(processedChildField);
                    childElement.dataset.acf = ""; // Removing them so they don't get added to the parent
                    childElement.dataset.acfMode = "none";
                  }
                });
                repeaterField.sub_fields = acf_repeater_children_fields;
                fields.push(repeaterField);
                console.log('repeaterField', repeaterField);
              }
            } else {
              var _element$dataset3, _element$dataset4;
              if ((element === null || element === void 0 || (_element$dataset3 = element.dataset) === null || _element$dataset3 === void 0 ? void 0 : _element$dataset3.acfMode) !== "none" && element !== null && element !== void 0 && (_element$dataset4 = element.dataset) !== null && _element$dataset4 !== void 0 && _element$dataset4.acf) {
                var childField = JSON.parse(element.dataset.acf);
                var processedChildField = processChildField(element, childField, acf_parent_key, false, acf_parent_name, index, '__');
                fields.push(processedChildField);
              }
            }
          }
        });
        if (acf_data_json) {
          var utilityClassesObject = fields.splice(fields.findIndex(function (obj) {
            return obj.name === 'utility_classes';
          }), 1)[0];
          fields.push(utilityClassesObject);
          acf_data_json.fields = fields;
        }
        return acf_data_json;
      }
    }; // get_acf_json(); // ONLY RUN ONCE
    // CLASS EXTRACTOR
    var classExtractor = function classExtractor(acf_parent) {
      var _ref;
      var whereToPutRules = acf_parent.previousElementSibling;
      var sibling = acf_parent.nextElementSibling;
      var name = acf_parent.dataset.name;
      var classElements = (_ref = [acf_parent]).concat.apply(_ref, _toConsumableArray(sibling.querySelectorAll("[data-classes]")));
      var classList = {};
      classElements.forEach(function (element, index) {
        var _element$dataset5, _element$dataset6;
        var classes = element === null || element === void 0 || (_element$dataset5 = element.dataset) === null || _element$dataset5 === void 0 ? void 0 : _element$dataset5.classes;
        var name = element === null || element === void 0 || (_element$dataset6 = element.dataset) === null || _element$dataset6 === void 0 ? void 0 : _element$dataset6.name;
        if (!classes || !name) {
          return;
        }
        classList[name] = classes.split(" ");
      });
      var container = document.createElement("div");
      container.id = "css-rules-container";
      var title = document.createElement("h5");
      title.textContent = "Tailwind CSS";
      whereToPutRules.appendChild(title);
      function removeName(classname) {
        // Remove the parent name from the beginning of the class name
        if (classname.startsWith(name)) {
          var newName = classname.substring(name.length);
          return newName ? "&" + newName : '';
        }
        return '.' + classname;
      }
      var OpeningCodeElement = document.createElement("code");
      OpeningCodeElement.textContent = ".".concat(name, " {");
      container.appendChild(OpeningCodeElement);
      for (var key in classList) {
        var className = removeName(key);
        var rules = classList[key];
        var codeElement = document.createElement("code");
        if (!className) {
          codeElement.textContent = "@apply ".concat(rules.join(" "), ";");
        } else {
          codeElement.textContent = "".concat(className, " {\n\t\t\t\t@apply ").concat(rules.join(" "), ";\n\t\t\t}\n");
        }
        container.appendChild(codeElement);
      }
      var closingCodeElement = document.createElement("code");
      closingCodeElement.textContent = "}";
      container.appendChild(closingCodeElement);
      var hr = document.createElement("hr");
      container.appendChild(hr);
      whereToPutRules.appendChild(container);
    };
    var updateInheriterNames = function updateInheriterNames(acf_parent) {
      var _acf_parent$nextEleme2;
      var inheriterElements = acf_parent === null || acf_parent === void 0 || (_acf_parent$nextEleme2 = acf_parent.nextElementSibling) === null || _acf_parent$nextEleme2 === void 0 ? void 0 : _acf_parent$nextEleme2.querySelectorAll('[data-acf-id="inherit"]');
      inheriterElements.forEach(function (element) {
        var _element$dataset$name, _element$dataset$name2;
        var name = (_element$dataset$name = element.dataset.nameOrig) !== null && _element$dataset$name !== void 0 ? _element$dataset$name : '';
        var newName = (_element$dataset$name2 = element.dataset.name) !== null && _element$dataset$name2 !== void 0 ? _element$dataset$name2 : '';
        if (name && newName) {
          var nextSibling = element.nextSibling.nextSibling;
          if (nextSibling && nextSibling.nodeType === 8) {
            console.log('next sibling is a comment node', nextSibling);
            nextSibling.nodeValue = nextSibling.nodeValue.replaceAll(name, newName);
          }
        }
      });
    };
    var fixSubField = function fixSubField(acf_parent) {
      var _acf_parent$nextEleme3;
      var repeaters = acf_parent === null || acf_parent === void 0 || (_acf_parent$nextEleme3 = acf_parent.nextElementSibling) === null || _acf_parent$nextEleme3 === void 0 ? void 0 : _acf_parent$nextEleme3.querySelectorAll('[data-acf-mode="repeater"]');
      repeaters.forEach(function (repeaterElement) {
        replaceTextInComments(repeaterElement.nextElementSibling, "get_field", "get_sub_field");
      });
    }; // Find the hidden elements
    // Replace PHP tags
    // hiddenGroupElements.forEach(function (element) {
    // 	const nextSibling = element?.nextElementSibling;
    // 	if (nextSibling) {
    // 		replaceTextInComments(
    // 			element.nextElementSibling,
    // 			"<php",
    // 			"<?php",
    // 			false
    // 		);
    // 	}
    // });
    var replaceTextInComments = function replaceTextInComments(element, oldText, newText) {
      var commentsToText = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : false;
      if (!element) return;
      console.log("replaceTextInComments", element, oldText, newText, commentsToText);
      // Get all text nodes within the element and its descendants
      var textNodes = [];
      var elementNodes = element.querySelectorAll(":not(script):not(style)");
      elementNodes = elementNodes.forEach(function (node) {
        if (node.nodeType === Node.TEXT_NODE) {
          textNodes.push(node);
        } else {
          textNodes.push.apply(textNodes, _toConsumableArray(node.childNodes));
        }
      });
      console.log("textNodes", textNodes);

      // Iterate over each text node
      textNodes.forEach(function (textNode) {
        // Check if the text node is within a comment
        if (textNode.nodeType === Node.COMMENT_NODE) {
          // Replace the text within the comment

          textNode.nodeValue = textNode.nodeValue.replaceAll(oldText, newText);
          if (commentsToText) {
            var newTextNode = document.createTextNode(textNode.nodeValue);
            textNode.parentNode.replaceChild(newTextNode, textNode);
          }
        } else {}
      });
    };
    var printPhpCode = function printPhpCode(acf_root) {
      var container = document.createElement("code");
      container.id = "php-container";
      container.textContent = acf_root.outerHTML;
      container.textContent = container.textContent.replace(/="php([^"]*)"/g, '="<?php $1 ?>"');
      container.textContent = container.textContent.replaceAll("<php", "<?php");
      container.textContent = container.textContent.replaceAll("<!--", "");
      container.textContent = container.textContent.replaceAll("-->", "");
      container.textContent = container.textContent.replaceAll("&quot;", "\'");
      container.textContent = container.textContent.replaceAll("\\'", "\'");
      container.textContent = container.textContent.replace(/\s{4,}/g, "\n");
      // This was only needed if JSX is true but apparently its true by default now
      // container.textContent = container.textContent.replace(/x-data="\{(.*)\}"/g, '<?= !$is_preview ? \'x-data="{ $1 }"\' : \'\'; ?>'); 
      var whereToPutCode = acf_root.previousElementSibling;
      var title = document.createElement("h5");
      title.textContent = "PHP Code";
      whereToPutCode.appendChild(title);
      whereToPutCode.appendChild(container);
      var hr = document.createElement("hr");
      whereToPutCode.appendChild(hr);
    };
    var printBlockJson = function printBlockJson(acf_parent) {
      var container = document.createElement("code");
      container.id = "block-json-container";
      container.textContent = JSON.stringify(get_block_json(acf_parent)), null, 3;
      var whereToPutCode = acf_parent.previousElementSibling;
      var title = document.createElement("h5");
      title.textContent = "Block JSON";
      whereToPutCode.appendChild(title);
      whereToPutCode.appendChild(container);
      var hr = document.createElement("hr");
      whereToPutCode.appendChild(hr);
    };
    var printAcfJson = function printAcfJson(acf_parent) {
      var container = document.createElement("code");
      container.id = "acf-json-container";
      container.textContent = JSON.stringify(get_acf_json(acf_parent)), null, 3;
      var whereToPutCode = acf_parent.previousElementSibling;
      var title = document.createElement("h5");
      title.textContent = "ACF JSON";
      whereToPutCode.appendChild(title);
      whereToPutCode.appendChild(container);
      var hr = document.createElement("hr");
      whereToPutCode.appendChild(hr);
    };
    var _replaceATags = function _replaceATags(acf_parent, acf_root) {
      if (acf_parent.dataset.element == 'a') {
        console.log("element.dataset.element", element.dataset.element);
        var aElement = acf_root.outerHTML.replace(/^<div/, '<a').replace(/<\/div>$/, '</a>');
        acf_root.outerHTML = aElement;
      }
    };
    var printScript = function printScript(scriptElement, acf_parent) {
      if (!scriptElement) {
        return;
      }
      console.log(scriptElement);
      var container = document.createElement("code");
      container.id = "script-container";
      container.textContent = scriptElement.innerHTML;
      var whereToPutCode = acf_parent.previousElementSibling;
      var title = document.createElement("h5");
      title.textContent = "Script";
      whereToPutCode.appendChild(title);
      whereToPutCode.appendChild(container);
      var hr = document.createElement("hr");
      whereToPutCode.appendChild(hr);
    };
    console.log("Render Mode Enabled");
    nkg_parents.forEach(function (acf_parent) {
      var acf_root = acf_parent.nextElementSibling;
      var acf_script = acf_root.nextElementSibling && acf_root.nextElementSibling.tagName.toLowerCase() == 'script' ? acf_root.nextElementSibling : false;
      // console.log("acf_script", acf_root.nextElementSibling.tagName)

      printScript(acf_script, acf_parent);
      printBlockJson(acf_parent);
      printAcfJson(acf_parent);
      // printScript(acf_parent);
      updateInheriterNames(acf_parent);
      fixSubField(acf_parent);
      if (cssMode) {
        classExtractor(acf_parent);
      }
      _replaceATags(acf_parent, acf_root);
      removeHidden(acf_parent);
      printPhpCode(acf_root);
      $(acf_root).hide();
    });
  }
});

/***/ }),

/***/ "./resources/css/app.css":
/*!*******************************!*\
  !*** ./resources/css/app.css ***!
  \*******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/js/app": 0,
/******/ 			"css/app": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunkacf_blockmaker"] = self["webpackChunkacf_blockmaker"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["css/app"], () => (__webpack_require__("./resources/js/app.js")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["css/app"], () => (__webpack_require__("./resources/css/app.css")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;