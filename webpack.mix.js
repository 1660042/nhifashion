const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js("resources/js/app.js", "public/js").postCss(
    "resources/css/app.css",
    "public/css",
    [require("postcss-import"), require("tailwindcss"), require("autoprefixer")]
);

mix.styles("resources/css/style.css", "public/css/style.css");

mix.copyDirectory("resources/js/common.js", "public/js/common.js");
mix.copyDirectory("resources/js/sweetalert2.js", "public/js/sweetalert2.js");
mix.copyDirectory("resources/js/theloai.js", "public/js/");
mix.copyDirectory("resources/js/sanpham.js", "public/js/");
mix.copyDirectory("resources/js/donhang.js", "public/js/");

//AdminLTE
//dist
// mix.copy('resources/adminlte3/dist/css/adminlte.min.css', 'public/adminlte3/dist/css');
// mix.copy('resources/adminlte3/dist/js/adminlte.min.js', 'public/adminlte3/dist/js');

//plugins
mix.copy(
    "resources/adminlte3-1-0/plugins/jquery/jquery.min.js",
    "public/adminlte3-1-0/plugins/jquery"
);
mix.copy(
    "resources/adminlte3-1-0/plugins/jquery-ui/jquery-ui.min.js",
    "public/adminlte3-1-0/plugins/jquery-ui"
);
mix.copy(
    "resources/adminlte3-1-0/plugins/bootstrap/js/bootstrap.bundle.min.js",
    "public/adminlte3-1-0/plugins/bootstrap/js"
);
mix.copy(
    "resources/adminlte3-1-0/plugins/moment/moment.min.js",
    "public/adminlte3-1-0/plugins/moment"
);
mix.copy(
    "resources/adminlte3-1-0/plugins/daterangepicker/daterangepicker.js",
    "public/adminlte3-1-0/plugins/daterangepicker"
);
// mix.copy('resources/adminlte3-1-0/plugins/sweetalert2/sweetalert2.min.js', 'public/adminlte3-1-0/plugins/sweetalert2');
mix.copy(
    "resources/adminlte3-1-0/dist/js/adminlte.js",
    "public/adminlte3-1-0/dist/js"
);
mix.copy(
    "resources/adminlte3-1-0/plugins/select2/js/select2.full.min.js",
    "public/adminlte3-1-0/plugins/select2/js"
);
mix.copy(
    "resources/adminlte3-1-0/plugins/icheck-bootstrap/icheck-bootstrap.min.css",
    "public/adminlte3-1-0/plugins/icheck-bootstrap"
);
mix.copy(
    "resources/adminlte3-1-0/dist/css/adminlte.min.css",
    "public/adminlte3-1-0/dist/css"
);

mix.copy(
    "resources/adminlte3-1-0/plugins/daterangepicker/daterangepicker.css",
    "public/adminlte3-1-0/plugins/daterangepicker"
);
mix.copy(
    "resources/adminlte3-1-0/plugins/select2/css/select2.min.css",
    "public/adminlte3-1-0/plugins/select2/css"
);
mix.copy(
    "resources/adminlte3-1-0/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css",
    "public/adminlte3-1-0/plugins/select2-bootstrap4-theme"
);
mix.copy(
    "resources/adminlte3-1-0/dist/img/AdminLTELogo.png",
    "public/adminlte3-1-0/dist/img"
);
mix.copy(
    "resources/adminlte3-1-0/plugins/fontawesome-free/css/all.min.css",
    "public/adminlte3-1-0/plugins/fontawesome-free/css"
);
mix.copy(
    "resources/adminlte3-1-0/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js",
    "public/adminlte3-1-0/plugins/tempusdominus-bootstrap-4/js"
);

mix.copy(
    "resources/adminlte3-1-0/plugins/fontawesome-free/webfonts/fa-solid-900.woff2",
    "public/adminlte3-1-0/plugins/fontawesome-free/webfonts"
);
mix.copy(
    "resources/adminlte3-1-0/plugins/fontawesome-free/webfonts/fa-solid-900.ttf",
    "public/adminlte3-1-0/plugins/fontawesome-free/webfonts"
);
mix.copy(
    "resources/adminlte3-1-0/plugins/fontawesome-free/webfonts/fa-solid-900.woff",
    "public/adminlte3-1-0/plugins/fontawesome-free/webfonts"
);

mix.copy(
    "resources/adminlte3-1-0/plugins/fontawesome-free/webfonts/fa-regular-400.ttf",
    "public/adminlte3-1-0/plugins/fontawesome-free/webfonts"
);
mix.copy(
    "resources/adminlte3-1-0/plugins/fontawesome-free/webfonts/fa-regular-400.woff",
    "public/adminlte3-1-0/plugins/fontawesome-free/webfonts"
);
mix.copy(
    "resources/adminlte3-1-0/plugins/fontawesome-free/webfonts/fa-regular-400.woff2",
    "public/adminlte3-1-0/plugins/fontawesome-free/webfonts"
);

mix.copy(
    "resources/adminlte3-1-0/dist/img/user2-160x160.jpg",
    "public/adminlte3-1-0/dist/img/user2-160x160.jpg"
);

//coloshop
mix.copyDirectory("resources/coloshop/plugins", "public/coloshop/plugins");

mix.copyDirectory("resources/coloshop/styles", "public/coloshop/styles");

mix.copyDirectory("resources/coloshop/js", "public/coloshop/js");

mix.copyDirectory("resources/coloshop/images", "public/coloshop/images");

mix.copy("resources/frontend/js/common.js", "public/frontend/js");
mix.copy("resources/frontend/js/frontend.js", "public/frontend/js");

mix.copyDirectory(
    "node_modules/tinymce/tinymce.min.js",
    "public/admin/tinymce/tinymce.min.js"
);
mix.copyDirectory(
    "node_modules/tinymce/plugins",
    "public/admin//tinymce/plugins"
);
mix.copyDirectory(
    "node_modules/tinymce/themes",
    "public/admin//tinymce/themes"
);
mix.copyDirectory(
    "node_modules/tinymce/models/dom",
    "public/admin/tinymce/models/dom"
);
mix.copyDirectory("node_modules/tinymce/icons", "public/admin/tinymce/icons");
mix.copyDirectory("node_modules/tinymce/skins", "public/admin/tinymce/skins");

mix.styles("resources/frontend/css/style.css", "public/frontend/css/style.css");
