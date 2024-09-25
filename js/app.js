/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/***/ (() => {

jQuery(document).ready(function ($) {
  console.log('goooo');
  var acf_parent = document.querySelector('[data-acf-mode="parent"]');

  // $('[data-acf-mode="parent"]');
  var acf_data = acf_parent.dataset.acf;
  acf_data_json = JSON.parse(acf_data);
  // console.log(acf_data_json);

  var acf_children = acf_parent.querySelectorAll('[data-acf-mode="child"]');
  var fields = [];

  // console.log(acf_children);

  acf_children.forEach(function (element, index) {
    var data = element.dataset.acf;
    var dataParsed = JSON.parse(data);
    console.log('data', dataParsed);
    fields.push(dataParsed);
  });
  console.log('fields', fields);
  if (acf_data_json) {
    console.log('adding data');
    acf_data_json.fields = fields;
    acf_data_json.test = 'test';
  }
  console.log(acf_data_json);
});

/***/ }),

/***/ "./resources/css/app.css":
/*!*******************************!*\
  !*** ./resources/css/app.css ***!
  \*******************************/
/***/ (() => {

throw new Error("Module build failed (from ./node_modules/mini-css-extract-plugin/dist/loader.js):\nModuleBuildError: Module build failed (from ./node_modules/postcss-loader/dist/cjs.js):\nTypeError: Cannot convert undefined or null to object\n    at Function.keys (<anonymous>)\n    at Object.customMapper (C:\\Users\\nukag\\Local Sites\\powder-tailpress\\app\\public\\wp-content\\plugins\\acf-blockmaker\\node_modules\\@nukage\\tailthemer\\index.js:41:12)\n    at C:\\Users\\nukag\\Local Sites\\powder-tailpress\\app\\public\\wp-content\\plugins\\acf-blockmaker\\tailwind.config.js:88:20\n    at evalModule (C:\\Users\\nukag\\Local Sites\\powder-tailpress\\app\\public\\wp-content\\plugins\\acf-blockmaker\\node_modules\\jiti\\dist\\jiti.js:1:247313)\n    at jiti (C:\\Users\\nukag\\Local Sites\\powder-tailpress\\app\\public\\wp-content\\plugins\\acf-blockmaker\\node_modules\\jiti\\dist\\jiti.js:1:245241)\n    at C:\\Users\\nukag\\Local Sites\\powder-tailpress\\app\\public\\wp-content\\plugins\\acf-blockmaker\\node_modules\\tailwindcss\\lib\\lib\\load-config.js:56:30\n    at loadConfig (C:\\Users\\nukag\\Local Sites\\powder-tailpress\\app\\public\\wp-content\\plugins\\acf-blockmaker\\node_modules\\tailwindcss\\lib\\lib\\load-config.js:58:6)\n    at getTailwindConfig (C:\\Users\\nukag\\Local Sites\\powder-tailpress\\app\\public\\wp-content\\plugins\\acf-blockmaker\\node_modules\\tailwindcss\\lib\\lib\\setupTrackingContext.js:71:116)\n    at C:\\Users\\nukag\\Local Sites\\powder-tailpress\\app\\public\\wp-content\\plugins\\acf-blockmaker\\node_modules\\tailwindcss\\lib\\lib\\setupTrackingContext.js:100:92\n    at C:\\Users\\nukag\\Local Sites\\powder-tailpress\\app\\public\\wp-content\\plugins\\acf-blockmaker\\node_modules\\tailwindcss\\lib\\processTailwindFeatures.js:46:11\n    at plugins (C:\\Users\\nukag\\Local Sites\\powder-tailpress\\app\\public\\wp-content\\plugins\\acf-blockmaker\\node_modules\\tailwindcss\\lib\\plugin.js:38:69)\n    at LazyResult.runOnRoot (C:\\Users\\nukag\\Local Sites\\powder-tailpress\\app\\public\\wp-content\\plugins\\acf-blockmaker\\node_modules\\postcss\\lib\\lazy-result.js:329:16)\n    at LazyResult.runAsync (C:\\Users\\nukag\\Local Sites\\powder-tailpress\\app\\public\\wp-content\\plugins\\acf-blockmaker\\node_modules\\postcss\\lib\\lazy-result.js:258:26)\n    at async Object.loader (C:\\Users\\nukag\\Local Sites\\powder-tailpress\\app\\public\\wp-content\\plugins\\acf-blockmaker\\node_modules\\postcss-loader\\dist\\index.js:97:14)\n    at processResult (C:\\Users\\nukag\\Local Sites\\powder-tailpress\\app\\public\\wp-content\\plugins\\acf-blockmaker\\node_modules\\webpack\\lib\\NormalModule.js:885:19)\n    at C:\\Users\\nukag\\Local Sites\\powder-tailpress\\app\\public\\wp-content\\plugins\\acf-blockmaker\\node_modules\\webpack\\lib\\NormalModule.js:1026:5\n    at C:\\Users\\nukag\\Local Sites\\powder-tailpress\\app\\public\\wp-content\\plugins\\acf-blockmaker\\node_modules\\loader-runner\\lib\\LoaderRunner.js:400:11\n    at C:\\Users\\nukag\\Local Sites\\powder-tailpress\\app\\public\\wp-content\\plugins\\acf-blockmaker\\node_modules\\loader-runner\\lib\\LoaderRunner.js:252:18\n    at context.callback (C:\\Users\\nukag\\Local Sites\\powder-tailpress\\app\\public\\wp-content\\plugins\\acf-blockmaker\\node_modules\\loader-runner\\lib\\LoaderRunner.js:124:13)\n    at Object.loader (C:\\Users\\nukag\\Local Sites\\powder-tailpress\\app\\public\\wp-content\\plugins\\acf-blockmaker\\node_modules\\postcss-loader\\dist\\index.js:142:7)");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	__webpack_modules__["./resources/js/app.js"]();
/******/ 	// This entry module doesn't tell about it's top-level declarations so it can't be inlined
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./resources/css/app.css"]();
/******/ 	
/******/ })()
;