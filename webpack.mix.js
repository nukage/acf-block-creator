let mix = require('laravel-mix');
let path = require('path');

mix.setResourceRoot('../');
mix.setPublicPath(path.resolve('./'));

mix.webpackConfig({
    watchOptions: { ignored: [
        path.posix.resolve(__dirname, './node_modules'),
        path.posix.resolve(__dirname, './css'),
        path.posix.resolve(__dirname, './js')
    ] }
});

mix.js('resources/js/app.js', 'js');

mix.postCss("resources/css/app.css", "css");

// mix.postCss('resources/blocks/**/*.css', 'resources/blocks/');


let fs = require('fs');
const blockPath = 'resources/blocks' // the path you want to discover

 

// function discover(dir, type) {
//     let cssFiles = [];
//     fs.readdirSync(dir).forEach(file => {
//         let fileName = `${dir}/${file}`;
//         if (fs.statSync(fileName).isFile()) {
//             if (fileName.endsWith(type)) {
//                 cssFiles.push(fileName);
//             }
//         } else {
//             cssFiles = cssFiles.concat(discover(fileName, type));
//         }
//     });
//     return cssFiles;
// }

// discover(blockPath, '.css').forEach(file => {
//     const outputDir = path.dirname(file);
//     const outputFile = path.basename(file, '.css') + '.compiled.css';
//     if (outputFile.includes('compiled.compiled')){
//         return;
//     }
//     mix.postCss(file, `${outputDir}/${outputFile}`);
// });


// let options = {
// 	rootValue: 10,
// 	propList: ["*"],
// 	mediaQuery: true,
// };

// mix.postCss("resources/css/editor-style.css", "css", [
// 	require("postcss-rem-to-pixel")(options),
// ]);

mix.browserSync({
    proxy: 'http://qntm-zero.loc',
    host: 'qntm-zero.loc',
    open: 'external',
    port: 8000,
    files: ['*.php', './css/app.css', './js/app.js'],
});

if (mix.inProduction()) {
    mix.version();
} else {
    mix.options({ manifest: false });
}
