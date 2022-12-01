(function ($) {
    let Index = function () {
        this.baseUrl = "";
    };
    jQuery.Index = new Index();
    jQuery.extend(Index.prototype, {
        func_init: function () {
            // $(".select2").select2();
        },
        func_callback_error: function (err, data) {
            func_hide_error_validation("#form-modal");
            if (err.data.messages) {
                jQuery.Index.func_show_error_validation(
                    err.data.messages,
                    "#form-modal"
                );
            }
            if (err.data.message) {
                swalAlert("error", "Lỗi", err.data.message);
            }
        },

        func_search: function (data = {}, page = 1) {
            data.page = page;
            izanagi(
                jQuery.Index.baseUrl,
                "post",
                data,
                null,
                jQuery.Index.func_search_callback,
                jQuery.Index.func_callback_error
            );
        },
        func_search_callback: function (res) {
            $("#list-area").html(res.data.view);
        },

        func_view_modal: function (data = {}) {
            let url = "/create";
            if (data.type_modal == modal_edit) {
                url = "/edit" + "/" + data.id;
            }
            izanagi(
                jQuery.Index.baseUrl + url,
                "post",
                data,
                null,
                jQuery.Index.func_view_modal_callback,
                jQuery.Index.func_callback_error
            );
        },

        func_view_modal_callback: function (res) {
            $("#modal-box").html(res.data.view);
            $("#my-modal").modal({
                backdrop: "static",
                keyboard: false,
            });
            $("#my-modal").modal("show");
            jQuery.Index.func_init();
        },

        func_get_cart: function (data) {
            let url = "get-cart";
            let method = "get";

            if (url.length == 0) return;
            izanagi(
                url,
                method,
                data,
                null,
                jQuery.Index.func_get_cart_callback,
                jQuery.Index.func_callback_error
            );
        },

        func_get_cart_callback: function (res, _data) {
            console.log(res.data.cart);
            $("#modal-area").html(res.data.view);
            $("#cart-modal").modal("show");
            // $(".grid_sorting_button.active").removeClass("active");
            // $(_data.el).addClass("active");
            // var selector = $(_data.el).attr("data-filter");
            // $(".product-grid").isotope({
            //     filter: selector,
            //     animationOptions: {
            //         duration: 750,
            //         easing: "linear",
            //         queue: false,
            //     },
            // });
        },

        func_delete_data: function (id) {
            izanagi(
                jQuery.Index.baseUrl + "/delete/" + id,
                "delete",
                null,
                null,
                jQuery.Index.func_delete_data_callback,
                jQuery.Index.func_callback_error
            );
        },
        func_delete_data_callback: function (res) {
            swalAlert("success", "Thành công", res.data.message);
            let data = func_get_value_form("#form-search");
            jQuery.Index.func_search(data, jQuery.Index.page);
        },

        func_reload_num_id: function (el, isAddRow = true) {
            $(el).each(function (i, subEle) {
                $(subEle).find("select[name='mau_sac[]']")[0].id =
                    "mau_sac_" + i;

                $(subEle).find("select[name='trang_thai[]']")[0].id =
                    "trang_thai_" + i;
                $(subEle).find("input[name='size[]']")[0].id = "size_" + i;
                $(subEle).find("input[name='gia[]']")[0].id = "gia_" + i;
            });

            if (isAddRow) {
                $(el).last().find(".is-invalid").removeClass("is-invalid");
                $(el)
                    .last()
                    .find("span[class='error invalid-feedback']")
                    .remove();
                $(el).last().find("input").val("");
            }
        },

        func_show_error_validation: function (errs, idForm) {
            $(idForm).find(".is-invalid").removeClass("is-invalid");
            $(idForm).find("span[class='error invalid-feedback']").remove();
            let keys = [];
            $.each(errs, function (key, value) {
                if (key.indexOf("anh.") != -1) {
                    key = "anh";
                } else key = key.replace(".", "_");
                if (jQuery.inArray(key, keys) == -1) {
                    $(idForm + " #" + key).addClass("is-invalid");
                    let html =
                        '<span class="error invalid-feedback">' +
                        value +
                        "</span>";
                    $(idForm + " #" + key)
                        .parent()
                        .append(html);
                }
                keys.push(key);
            });
            let listSelect = $(idForm).find("select");
            $(listSelect).each(function () {
                let el = $(this);
                if (el.hasClass("is-invalid")) {
                    el.siblings("span:first")
                        .children("span:first")
                        .children("span:first")
                        .addClass("is-invalid");
                }
            });
        },
    });
})(jQuery);

jQuery(document).ready(function () {
    console.log("OK");
    try {
        let $navbar = $(".navbar");
        // let $newProduct = $("#index-page #new-product");
        // let $layoutList = $("#index-page #list-area");
        // let $modalBox = $("#index-page #modal-box");
        // let $myCart = $(".my-cart");
        // let $pagination = $("#index-page .pagination-custom");

        // let idFormSearch = "#form-search";
        // let idFormModal = "#form-modal";

        // jQuery.Index.func_init();

        $navbar.on("click", "#gio_hang", function (e) {
            e.preventDefault();
            jQuery.Index.func_get_cart();
            // console.log($("#cart-modal"));
            // $("#cart-modal").modal("show");
        });
    } catch (e) {
        console.log(e);
        alert("The engine can't understand this code, it's invalid");
    }
});
