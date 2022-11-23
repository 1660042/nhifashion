(function ($) {
    let ProductAdmin = function () { };
    jQuery.ProductAdmin = new ProductAdmin();
    jQuery.extend(ProductAdmin.prototype, {
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
                jQuery.ProductAdmin.showModalCallback
                // jQuery.ProductAdmin.showModalCallbackError
            );
        },

        showModalCallback: function (res) {
            if (res.data.status) {
                $("#product-admin-page #modal-box").html("");
                $("#product-admin-page #modal-box").html(res.data.view);
                // $("#product-admin-page #modal-form").modal({
                //     backdrop: "static",
                //     keyboard: false,
                // });
                $("#product-admin-page #modal-form").modal("show");
            }
        },
        showModalCallbackError: function (err) {
            console.log(err);

            if (err.status == 404) {
                swalAlert(err.data.icon, err.data.title, err.data.message);
                jQuery.ProductAdmin.getData();
            }
        },

        getData: function () {
            data = {};
            izanagi(
                "admin/products/get-data",
                "post",
                data,
                null,
                jQuery.ProductAdmin.getDataCallback,
                ""
            );
        },

        getDataCallback: function (res) {
            if (res.data.status) {
                $("#product-admin-page #list-area").html(res.data.view);
                $("#product-admin-page .pagination-custom").html(res.data.pagination);
                jQuery.ProductAdmin.clearSearch();
            }
        },

        getParams: function (ele, object = {}) {
            return ele.serializeArray().reduce(function (a, x) {
                a[x.name] = x.value;
                return a;
            }, object);
        },

        submitData: function (data, url, method) {
            izanagi(
                url,
                method,
                data,
                null,
                jQuery.ProductAdmin.submitDataCallback,
                jQuery.ProductAdmin.submitDataCallbackError
            );
        },

        submitDataCallback: function (res) {
            if (res.data.status) {
                $("#product-admin-page #modal-form").modal("hide");
                $("#product-admin-page #product-area").html(res.data.view);
                $("#product-admin-page .pagination-custom").html(res.data.pagination);
                if (res.data.clear_search) {
                    jQuery.ProductAdmin.clearSearch();
                }
            }
        },

        submitDataCallbackError: function (err) {
            // console.log(error.status);
            if (err.status == 422) {
                jQuery.ProductAdmin.validateError(err.data.errors);
            } else if (err.status == 404) {
                $("#product-admin-page #modal-form").modal("hide");
                swalAlert(err.data.icon, err.data.title, err.data.message);
                jQuery.ProductAdmin.getData();
            }
        },

        validateError: function (err) {
            $("#product-admin-page #modal-box .error-mes").remove();
            $("#product-admin-page #modal-box .is-invalid").removeClass("is-invalid");
            $.each(err, function (key, value) {
                $("#product-admin-page #modal-box  #" + key).addClass("is-invalid");

                $("#product-admin-page #modal-box  #" + key)
                    .parent()
                    .append(
                        "<span class='text-danger error-mes'>" +
                        value +
                        "</span>"
                    );
            });
        },

        clearSearch: function () {
            $("input[name='nameSearch']").val("");
            $("#categorySearch").val("");
            $("#categorySearch").trigger("change");
            $("#brandSearch").val("");
            $("#brandSearch").trigger("change");
        },

        searchData: function (data = {}, url = "admin/products/search", method = "post") {
            izanagi(
                url,
                method,
                data,
                null,
                jQuery.ProductAdmin.searchDataCallback,
                jQuery.ProductAdmin.searchDataCallbackError
            );
        },

        searchDataCallback: function (res) {
            if (res.data.status) {
                // $("#product-admin-page #search-area").html(res.data.view_search);
                $("#product-admin-page #product-area").html(res.data.view);
                $("#product-admin-page .pagination-custom").html(res.data.pagination);
            }
        },
        searchDataCallbackError: function (err) {
            console.log(err);

            if (err.status == 404) {
                swalAlert(err.data.icon, err.data.title, err.data.message);
                jQuery.ProductAdmin.getData();
            }
        },

        addCart: function (data = {}, url = "cart/add", method = "get") {
            izanagi(
                url,
                method,
                data,
                null,
                jQuery.ProductAdmin.addCartCallback,
                jQuery.ProductAdmin.addCartCallbackError
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
                jQuery.ProductAdmin.getData();
            }
        },

        removeCart: function (data = {}, url = "cart/remove", method = "get") {
            izanagi(url, method, data, null, jQuery.ProductAdmin.removeCartCallback);
        },

        removeCartCallback: function (res) {
            if (res.data.status) {
                swalAlert(res.data.icon, res.data.title, res.data.message);
                getCart();
            }
        },

        deleteConfirm: function (data) {
            // console.log(data);
            swalAlertConfirm(
                "warning",
                "Xóa món ăn này?",
                "Hành động xóa này không thể khôi phục!",
                "Xóa",
                "#6e7d88",
                "#ff0000",
                jQuery.ProductAdmin.deleteItems,
                data,
                "Đóng"
            );
        },
        deleteItems: function (data) {
            // console.log(data);
            izanagi(
                "admin/products/delete",
                "delete",
                null,
                data,
                jQuery.ProductAdmin.deleteItemsCallback,
                jQuery.ProductAdmin.deleteItemsCallbackError
            );
        },
        deleteItemsCallback: function (res) {
            if (res.data.status) {
                $("#product-admin-page #product-area").html(res.data.view);
                // jQuery.ProductAdmin.clearSearch();
            }
        },

        deleteItemsCallbackError: function (err) {
            // console.log(err);
            if (err.status == 404 || err.status == 500) {
                $("#product-admin-page #modal-form").modal("hide");
                swalAlert(err.data.icon, err.data.title, err.data.message);
                jQuery.ProductAdmin.getDataTable();
            }
        },
    });
})(jQuery);

$("document").ready(function () {
    try {
        let $layoutSearch = $("#product-admin-page #search-area");
        let $layoutList = $("#product-admin-page #product-area");
        let $modalBox = $("#product-admin-page #modal-box");
        let $myCart = $(".my-cart");
        let $pagination = $("#product-admin-page .pagination-custom");

        //clear search form
        $layoutSearch.on("click", ".button-clear", function () {
            jQuery.ProductAdmin.clearSearch();
            data = jQuery.ProductAdmin.getParams($("#form-search"));
            jQuery.ProductAdmin.searchData(data);
        });

        //button search form
        $layoutSearch.on("click", ".button-search", function () {
            // e.preventDefault();
            data = jQuery.ProductAdmin.getParams($("#form-search"));
            let url = "admin/products/search";
            let method = "post";
            jQuery.ProductAdmin.searchData(data, url, method);
        });

        //Xem thông tin món ăn khi click vào icon view (eye)
        $layoutList.on("click", ".product-view", function () {
            let data = {};
            let id = $(this).parent().parent().attr("data-id");
            if (id == null || id == "" || id == "undefined") {
                return;
            }

            let url = "admin/products/detail/" + id;
            let method = "post";
            jQuery.ProductAdmin.showModal(data, url, method);
        });

        //Check input quantity
        $modalBox.on("keyup", "input[name='gia']", function () {
            let qty = $(this).val();
            if (qty != '' && (!$.isNumeric(qty) || parseInt(qty) < 1)) {
                swalAlert("error", "Lỗi", "Vui lòng nhập số");
                $(this).val(1);
            }
        });

        //Click vào button thêm món ăn
        $layoutList.on("click", ".btn-add-product", function () {
            // e.preventDefault();
            data = {};
            let url = "admin/products/add";
            let method = "post";
            jQuery.ProductAdmin.showModal(data, url, method);
        });

        //Click vào button Lưu thông tin khi thêm món ăn
        $modalBox.on("click", "#btn-store-product", function () {

            let formData = new FormData($("#form-add")[0]);
            let url = "admin/products/store";
            let method = "post";
            jQuery.ProductAdmin.submitData(formData, url, method);
        });

        //Click vào button cập nhật món ăn
        $layoutList.on("click", ".product-edit", function () {

            let id = $(this).parent().parent().attr("data-id");
            if (id == null || id == "" || id == "undefined") {
                return;
            }

            data = {};
            let url = "admin/products/edit/" + id;
            let method = "post";
            jQuery.ProductAdmin.showModal(data, url, method);
        });

        //Click vào button Lưu thông tin khi cập nhật món ăn
        $modalBox.on("click", "#btn-update-product", function () {
            let id = $("input[name='id']").val();
            console.log("aaaa");
            let formData = new FormData($("#form-update")[0]);
            let url = "admin/products/update/" + id;
            let method = "post";
            jQuery.ProductAdmin.submitData(formData, url, method);
        });

        //Click vào button xóa món ăn
        $layoutList.on("click", ".product-delete", function () {
            // let data = {};
            let id = $(this).parent().parent().attr("data-id");
            if (id == null || id == "" || id == "undefined") {
                return;
            }

            let page =
                Number(
                    $(".page-item.active").find(".page-link").attr("data-page")
                ) || 1;

            let data = jQuery.ProductAdmin.getParams($("#form-search"), {
                page: page,
                id: id,
            });
            jQuery.ProductAdmin.deleteConfirm(data);
        });

        //Remove product in cart
        $myCart.on("click", ".cart-item", function () {
            let id = $(this).data("id");
            let data = { id: id, isDelAll: false };

            let url = "cart/remove";
            let method = "post";
            // $("#product-admin-page #modal-form").modal("toggle");
            jQuery.ProductAdmin.removeCart(data, url, method);
        });

        //Pagination
        $pagination.on("click", ".page-link", function (e) {
            e.preventDefault();
            let liActive = $(this).parent().hasClass("active");
            let page = Number($(this).attr("data-page")) || false;
            if (page == false || liActive == true) {
                return;
            }
            data = jQuery.ProductAdmin.getParams($("#form-search"), {
                page: page,
            });
            jQuery.ProductAdmin.searchData(data);
        });
    } catch (e) {
        console.log(e);
        alert("The engine can't understand this code, it's invalid");
    }
});
