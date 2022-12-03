(function ($) {
    let Index = function () {
        this.baseUrl = "";
    };
    jQuery.Index = new Index();
    jQuery.extend(Index.prototype, {
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

        func_submit_callback_error: function (err, data) {
            func_hide_error_validation("#mua-hang-form");
            if (err.data.messages) {
                jQuery.Index.func_show_error_validation(
                    err.data.messages,
                    "#mua-hang-form"
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
            $("#modal-area").html(res.data.view);
            $("#checkout_items").text(res.data.num_cart);
            $("#cart-modal").modal("show");
        },

        func_update_cart: function (data) {
            let url = "update-cart";
            let method = "post";

            if (url.length == 0) return;
            izanagi(
                url,
                method,
                data,
                null,
                jQuery.Index.func_update_cart_callback,
                jQuery.Index.func_callback_error
            );
        },

        func_update_cart_callback: function (res, _data) {
            if (_data.is_reload_page) {
                location.reload(true);
                return;
            }
            jQuery.Index.func_get_cart();
        },

        func_init_dia_ly: function () {
            let tinh = $("#tinh").val();
            let huyen = $("#huyen").val();
            if (tinh == "") {
                $("#mua-hang-page #huyen").html(
                    "<option value=''>Chọn Quận/Huyện</option>"
                );
                $("#mua-hang-page #xa").html(
                    "<option value=''>Chọn Phường/Xã</option>"
                );
            }
            let data = {
                tinh: tinh,
                huyen: huyen,
            };
            izanagi(
                "get-dia-ly",
                "post",
                data,
                null,
                jQuery.Index.func_init_dia_ly_callback,
                jQuery.Index.func_callback_error
            );
        },
        func_init_dia_ly_callback: function (res) {
            if (res.data.xa && res.data.xa.length > 0) {
                let html = "<option value=''>Chọn Phường/Xã</option>";
                let ds = res.data.xa;
                jQuery.each(ds, function (i, row) {
                    html +=
                        "<option value='" +
                        row.Id +
                        "'>" +
                        row.Name +
                        "</option>";
                });
                $("#mua-hang-page #xa").html(html);
                return;
            }
            if (res.data.huyen && res.data.huyen.length > 0) {
                let html = "<option value=''>Chọn Quận/Huyện</option>";
                let ds = res.data.huyen;
                jQuery.each(ds, function (i, row) {
                    html +=
                        "<option value='" +
                        row.Id +
                        "'>" +
                        row.Name +
                        "</option>";
                });
                $("#mua-hang-page #huyen").html(html);
                $("#mua-hang-page #xa").html(
                    "<option value=''>Chọn Phường/Xã</option>"
                );
            }
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

        func_submit_form: function (data) {
            let url = "dat-hang";
            let method = "post";

            if (url.length == 0) return;
            izanagi(
                url,
                method,
                data,
                null,
                jQuery.Index.func_submit_form_callback,
                jQuery.Index.func_submit_callback_error
            );
        },

        func_submit_form_callback: function (res, _data) {
            // swalAlert("success", "Thành công", res.data.message);

            const $mess = res.data.message;
            const sw_confirm = swalConfirm(
                $mess,
                "Thành công",
                "success",
                "OK",
                "",
                "#007bff",
                "#007bff",
                false
            );
            sw_confirm.fire({}).then((result) => {
                if (result.value) {
                    location.reload(true);
                }
            });
        },
    });
})(jQuery);

jQuery(document).ready(function () {
    console.log("OK");
    try {
        let $navbar = $(".navbar");
        let $modalArea = $("#modal-area");

        $("#mua-hang-page").on("change", "#tinh, #huyen", function () {
            jQuery.Index.func_init_dia_ly();
        });

        $navbar.on("click", "#gio_hang", function (e) {
            e.preventDefault();
            jQuery.Index.func_get_cart();
        });

        $modalArea.on("click", ".fa-caret-left,.fa-caret-right", function (e) {
            let input = $(this).siblings("input");
            if (typeof input == "undefined") return;
            if ($(this).hasClass("fa-caret-left") && input.val() > 1) {
                input.val(parseInt(input.val()) - 1);
            }
            if ($(this).hasClass("fa-caret-right")) {
                input.val(parseInt(input.val()) + 1);
            }
        });

        $modalArea.on("click", ".fa-trash", function (e) {
            $(this).parent().parent().remove();
        });

        $modalArea.on("keyup", "input[name='so_luong']", function (e) {
            let key = event.keyCode || event.charCode;
            if (
                key != 8 &&
                key != 46 &&
                (Math.floor($(this).val()) != $(this).val() ||
                    !$.isNumeric($(this).val()))
            ) {
                $(this).val(1);
            }
        });

        $modalArea.on("click", "#update-cart", function (e) {
            let dsSoLuong = $("input[name='so_luong']");
            let arr = [];
            dsSoLuong.each(function (i, el) {
                arr[el.id] = el.value;
            });

            let is_reload_page = false;
            if ($("#mua-hang-page").length > 0) {
                is_reload_page = true;
            }

            console.log(is_reload_page);
            let data = {
                carts: arr,
                is_reload_page: is_reload_page,
            };

            jQuery.Index.func_update_cart(data);
        });

        $("#mua-hang-page").on("click", "#cap-nhat-gio-hang", function (e) {
            e.preventDefault();
            let data = {
                id: "cap-nhat-gio-hang",
            };
            jQuery.Index.func_get_cart(data);
        });
        $("#mua-hang-page").on("click", "#dat-hang", function (e) {
            e.preventDefault();
            let data = func_get_value_form("#mua-hang-form");

            if (data.tinh && data.tinh.length > 0) {
                data.tinh = $("#tinh option:selected").text();
            }
            if (data.huyen && data.huyen.length > 0) {
                data.huyen = $("#huyen option:selected").text();
            }
            if (data.xa && data.xa.length > 0) {
                data.xa = $("#xa option:selected").text();
            }

            jQuery.Index.func_submit_form(data);
        });
    } catch (e) {
        console.log(e);
        alert("The engine can't understand this code, it's invalid");
    }
});
