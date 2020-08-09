const mix = require('laravel-mix');
const lodash = require("lodash");

const folder = {
    src: "src", // source files
    dist: "src", // build files
    dist_assets: "dist/" //build assets files
};
mix.setPublicPath('dist');
mix.setResourceRoot('/assets/');


var third_party_assets = {
    css_js: [
        {"name": "jquery", "assets": ["./node_modules/jquery/dist/jquery.min.js"]},
        {"name": "bootstrap", "assets": ["./node_modules/bootstrap/dist/js/bootstrap.bundle.js"]},
        {"name": "metismenu", "assets": ["./node_modules/metismenu/dist/metisMenu.js"]},
        {"name": "simplebar", "assets": ["./node_modules/simplebar/dist/simplebar.js"]},
        {"name": "node-waves", "assets": ["./node_modules/node-waves/dist/waves.js"]},
        {"name": "noty", "assets": [
                "./node_modules/noty/lib/noty.js",
                "./node_modules/noty/lib/noty.css",
                "./node_modules/noty/lib/themes/relax.css"
            ]},
        {
            "name": "select2",
            "assets": ["./node_modules/select2/dist/js/select2.min.js", "./node_modules/select2/dist/css/select2.min.css"]
        },
        {"name": "jquery-repeater", "assets": ["./node_modules/jquery.repeater/jquery.repeater.min.js"]},
        {"name": "jquery-validation", "assets": [
                "./node_modules/jquery-validation/dist/jquery.validate.js",
                "./node_modules/jquery-validation/dist/additional-methods.js",
                "./node_modules/jquery-validation/dist/localization/messages_ru.js"
            ]},
        {"name": "slugify", "assets": ["./node_modules/slugify/slugify.js"]},
    ]
};

//copying third party assets
lodash(third_party_assets).forEach(function (assets, type) {
    if (type == "css_js") {
        lodash(assets).forEach(function (plugin) {
            var name = plugin['name'],
                assetlist = plugin['assets'],
                css = [],
                js = [];
            lodash(assetlist).forEach(function (asset) {
                var ass = asset.split(',');
                for (let i = 0; i < ass.length; ++i) {
                    if (ass[i].substr(ass[i].length - 3) == ".js") {
                        js.push(ass[i]);
                    } else {
                        css.push(ass[i]);
                    }
                }
                ;
            });
            if (js.length > 0) {
                mix.combine(js, folder.dist_assets + "/libs/" + name + "/" + name + ".min.js");
            }
            if (css.length > 0) {
                mix.combine(css, folder.dist_assets + "/libs/" + name + "/" + name + ".min.css");
            }
        });
    }
});

mix.copyDirectory("./node_modules/tinymce", folder.dist_assets + "/libs/tinymce");

//Admin
mix.js(folder.src + '/js/app.js', folder.dist_assets + 'js/app.min.js');
mix.sass(folder.src + '/scss/app.scss', folder.dist_assets + "css").minify(folder.dist_assets + "css/app.css");
mix.copyDirectory(folder.src + "/fonts", folder.dist_assets + "fonts");
mix.copyDirectory(folder.src + "/images", folder.dist_assets + "images");
