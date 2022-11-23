(function ($) {
    let Menu = function () {};
    jQuery.Menu = new Menu();
    jQuery.extend(Menu.prototype, {
        showModal: function (
            data = {},
            url = "dashboard/menus/create",
            method = "get"
        ) {
            izanagi(
                url,
                method,
                data,
                null,
                jQuery.Menu.showModalCallback
                // jQuery.Menu.showModalCallbackError
            );
        },

        showModalCallback: function (res) {
            if (res.data.status) {
                $("#menu-page #modal-box").html("");
                $("#menu-page #modal-box").html(res.data.view);
                // $("#menu-page #modal-form").modal({
                //     backdrop: "static",
                //     keyboard: false,
                // });
                $("#menu-page #modal-form").modal("show");
            }
        },
        showModalCallbackError: function (err) {
            console.log(err);

            if (err.status == 404) {
                swalAlert(err.data.icon, err.data.title, err.data.message);
                jQuery.Menu.getData();
            }
        },

        getData: function () {
            data = {};
            izanagi(
                "menu/get-data",
                "post",
                data,
                null,
                jQuery.Menu.getDataCallback,
                ""
            );
        },

        getDataCallback: function (res) {
            if (res.data.status) {
                $("#menu-page #list-area").html(res.data.view);
                $("#menu-page .pagination-custom").html(res.data.pagination);
                jQuery.Menu.clearSearch();
            }
        },

        getParams: function (ele, object = {}) {
            return ele.serializeArray().reduce(function (a, x) {
                a[x.name] = x.value;
                return a;
            }, object);
        },

        clearSearch: function () {
            $("input[name='nameSearch']").val("");
            $("#categorySearch").val("");
            $("#categorySearch").trigger("change");
            $("#brandSearch").val("");
            $("#brandSearch").trigger("change");
        },

        searchData: function (data = {}, url = "menu/search", method = "post") {
            izanagi(
                url,
                method,
                data,
                null,
                jQuery.Menu.searchDataCallback,
                jQuery.Menu.searchDataCallbackError
            );
        },

        searchDataCallback: function (res) {
            if (res.data.status) {
                // $("#menu-page #search-area").html(res.data.view_search);
                $("#menu-page #list-area").html(res.data.view);
                $("#menu-page .pagination-custom").html(res.data.pagination);
            }
        },
        searchDataCallbackError: function (err) {
            console.log(err);

            if (err.status == 404) {
                swalAlert(err.data.icon, err.data.title, err.data.message);
                jQuery.Menu.getData();
            }
        },

        addCart: function (data = {}, url = "cart/add", method = "get") {
            izanagi(
                url,
                method,
                data,
                null,
                jQuery.Menu.addCartCallback,
                jQuery.Menu.addCartCallbackError
            );
        },

        addCartCallback: function (res) {
            if (res.data.status) {
                swalAlert(res.data.icon, res.data.title, res.data.message);
                getCart();
            }
        },

        addCartCallbackError: function (err) {
            console.log(err);

            if (err.status == 404) {
                swalAlert(err.data.icon, err.data.title, err.data.message);
                jQuery.Menu.getData();
            }
        },

        removeCart: function (data = {}, url = "cart/remove", method = "get") {
            izanagi(url, method, data, null, jQuery.Menu.removeCartCallback);
        },

        removeCartCallback: function (res) {
            if (res.data.status) {
                swalAlert(res.data.icon, res.data.title, res.data.message);
                getCart();
            }
        },
    });
})(jQuery);

$("document").ready(function () {
    try {
        let $layoutSearch = $("#menu-page #search-area");
        let $layoutList = $("#menu-page #list-area");
        let $modalBox = $("#menu-page #modal-box");
        let $myCart = $(".my-cart");
        let $pagination = $("#menu-page .pagination-custom");

        //clear search form
        $layoutSearch.on("click", ".button-clear", function () {
            jQuery.Menu.clearSearch();
            data = jQuery.Menu.getParams($("#form-search"));
            jQuery.Menu.searchData(data);
        });

        //button search form
        $layoutSearch.on("click", ".button-search", function () {
            // e.preventDefault();
            data = jQuery.Menu.getParams($("#form-search"));
            let url = "menu/search";
            let method = "post";
            jQuery.Menu.searchData(data, url, method);
        });

        //open modal product when click image product
        $layoutList.on("click", ".product-detail", function () {
            let data = {};
            let id = $(this).parent().parent().attr("data-key");
            if (id == null || id == "" || id == "undefined") {
                return;
            }
            let url = "menu/detail/" + id;
            let method = "post";
            jQuery.Menu.showModal(data, url, method);
        });

        //open modal product use button order
        $layoutList.on("click", ".btn-order", function () {
            let data = {};
            let id = $(this).parent().parent().parent().attr("data-key");
            if (id == null || id == "" || id == "undefined") {
                return;
            }
            let url = "menu/detail/" + id;
            let method = "post";
            jQuery.Menu.showModal(data, url, method);
        });

        //Modal box

        //Increase quantity
        $modalBox.on("click", ".increase-qty", function () {
            let qty = $(this).parent().siblings("input").val();
            if ($.isNumeric(qty)) {
                $(this)
                    .parent()
                    .siblings("input")
                    .val(parseInt(qty) + 1);
            } else {
                $(this).parent().siblings("input").val(1);
            }
        });

        //Decrease quantity
        $modalBox.on("click", ".decrease-qty", function () {
            let qty = $(this).parent().siblings("input").val();
            if ($.isNumeric(qty) && parseInt(qty) > 1) {
                $(this)
                    .parent()
                    .siblings("input")
                    .val(parseInt(qty) - 1);
            } else {
                $(this).parent().siblings("input").val(1);
            }
        });

        //Check input quantity
        $modalBox.on("keyup", "input[name='qty']", function () {
            let qty = $(this).val();
            if (qty != '' && (!$.isNumeric(qty) || parseInt(qty) < 1)) {
                swalAlert("error", "Lỗi", "Vui lòng nhập số");
                $(this).val(1);
            }
        });

        //Add product to cart
        $modalBox.on("click", "#add-cart", function () {
            let qty = $(this).siblings(".qty-product").children("input").val();
            let id = $("input[name='id-product']").val();
            let data = { id: id, qty: qty };

            let url = "cart/add";
            let method = "post";
            $("#menu-page #modal-form").modal("toggle");
            jQuery.Menu.addCart(data, url, method);
        });

        //Remove product in cart
        $myCart.on("click", ".cart-item", function () {
            let id = $(this).data("id");
            let data = { id: id, isDelAll: false };

            let url = "cart/remove";
            let method = "post";
            // $("#menu-page #modal-form").modal("toggle");
            jQuery.Menu.removeCart(data, url, method);
        });

        //Pagination
        $pagination.on("click", ".page-link", function (e) {
            e.preventDefault();
            let liActive = $(this).parent().hasClass("active");
            let page = Number($(this).attr("data-page")) || false;
            if (page == false || liActive == true) {
                return;
            }
            data = jQuery.Menu.getParams($("#form-search"), {
                page: page,
            });
            jQuery.Menu.searchData(data);
        });
    } catch (e) {
        console.log(e);
        alert("The engine can't understand this code, it's invalid");
    }
});
