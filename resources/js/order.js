(function ($) {
    let Order = function () {
        this.isDone = false;
    };
    jQuery.Order = new Order();
    jQuery.extend(Order.prototype, {
        getData: function () {
            data = {};
            izanagi(
                "order/get-data",
                "post",
                data,
                null,
                jQuery.Order.getDataCallback,
                ""
            );
        },

        getDataCallback: function (res) {
            if (res.data.status) {
                $("#order-page #cart-area").html(res.data.view);
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
                // "dashboard/orders/store",
                // "post",
                url,
                method,
                data,
                null,
                jQuery.Order.submitDataCallback,
                jQuery.Order.submitDataCallbackError
            );
        },

        submitDataCallback: function (res) {
            if (res.data.status) {
                swal.fire({
                    icon: res.data.icon,
                    title: res.data.title,
                    html: res.data.message,
                }).then(function () {
                    var protocol = window.location.protocol;
                    var hostname = window.location.hostname;
                    window.location =
                        protocol + "//" + hostname + "/order/placed";
                });
            } else {
                swalAlert(res.data.icon, res.data.title, res.data.message);
            }
        },

        submitDataCallbackError: function (err) {
            // console.log(error.status);
            if (err.status == 422) {
                jQuery.Order.validateError(err.data.errors);
            } else if (err.status == 404) {
                $("#order-page #modal-form").modal("hide");
                swalAlert(err.data.icon, err.data.title, err.data.message);
                jQuery.Order.getData();
            }
        },

        validateError: function (err) {
            $("#order-page #customer-area .error-mes").remove();
            $("#order-page #customer-area .is-invalid").removeClass(
                "is-invalid"
            );
            $.each(err, function (key, value) {
                $("#order-page  #customer-area  #" + key).addClass(
                    "is-invalid"
                );

                $("#order-page  #customer-area  #" + key)
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

        searchData: function (
            data = {},
            url = "order/search",
            method = "post"
        ) {
            izanagi(
                url,
                method,
                data,
                null,
                jQuery.Order.searchDataCallback,
                jQuery.Order.searchDataCallbackError
            );
        },

        searchDataCallback: function (res) {
            if (res.data.status) {
                // $("#order-page #search-area").html(res.data.view_search);
                $("#order-page #list-area").html(res.data.view);
                $("#order-page .pagination-custom").html(res.data.pagination);
            }
        },
        searchDataCallbackError: function (err) {
            console.log(err);

            if (err.status == 404) {
                swalAlert(err.data.icon, err.data.title, err.data.message);
                jQuery.Order.getData();
            }
        },

        updateCart: function (data = {}, url = "cart/update", method = "put") {
            izanagi(
                url,
                method,
                data,
                null,
                jQuery.Order.updateCartCallback,
                jQuery.Order.updateCartCallbackError
            );
        },

        updateCartCallback: function (res) {
            if (res.data.status) {
                // swalAlert(res.data.icon, res.data.title, res.data.message);
                getCart();
            }
        },

        updateCartCallbackError: function (err) {
            console.log(err);

            if (err.status == 404) {
                swalAlert(err.data.icon, err.data.title, err.data.message);
                jQuery.Order.getData();
            }
        },

        removeCart: function (data = {}, url = "cart/remove", method = "get") {
            izanagi(url, method, data, null, jQuery.Order.removeCartCallback);
        },

        removeCartCallback: function (res) {
            if (res.data.status) {
                swalAlert(res.data.icon, res.data.title, res.data.message);
                getCart();
                jQuery.Order.getData();
            }
        },
    });
})(jQuery);

$("document").ready(function () {
    try {
        let $cartArea = $("#order-page #cart-area");
        let $customerArea = $("#order-page #customer-area");
        let $myCart = $(".my-cart");

        //Increase quantity
        $cartArea.on("click", ".increase-qty", function () {
            let qty = $(this).parent().siblings("input").val();
            if ($.isNumeric(qty)) {
                $(this)
                    .parent()
                    .siblings("input")
                    .val(parseInt(qty) + 1);
            } else {
                $(this).parent().siblings("input").val(1);
            }

            qty = $(this).parent().siblings("input").val();
            let id = $(this).parent().parent().parent().parent().data("id");
            let data = { id: id, qty: qty };

            let url = "cart/update";
            let method = "put";
            jQuery.Order.updateCart(data, url, method);
        });

        //Decrease quantity
        $cartArea.on("click", ".decrease-qty", function () {
            let qty = $(this).parent().siblings("input").val();
            if ($.isNumeric(qty) && parseInt(qty) > 1) {
                $(this)
                    .parent()
                    .siblings("input")
                    .val(parseInt(qty) - 1);
            } else {
                $(this).parent().siblings("input").val(1);
            }

            qty = $(this).parent().siblings("input").val();
            let id = $(this).parent().parent().parent().parent().data("id");
            let data = { id: id, qty: qty };

            let url = "cart/update";
            let method = "put";
            jQuery.Order.updateCart(data, url, method);
        });

        //Check input quantity
        $cartArea.on("keyup", "input[name='qty']", function () {
            let qty = $(this).val();
            if (qty != '' && (!$.isNumeric(qty) || parseInt(qty) < 1)) {
                swalAlert("error", "Lỗi", "Vui lòng nhập số");
                $(this).val(1);
            }

            qty = $(this).val();
            let id = $(this).parent().parent().parent().data("id");
            let data = { id: id, qty: qty };
            jQuery.Order.updateCart(data);
        });

        //Xóa món ăn ở giỏ hàng trong trang giỏ hàng
        $cartArea.on("click", ".remove-item-cart", function () {
            let id = $(this).parent().parent().parent().data("id");
            let data = { id: id, isDelAll: false };

            let url = "cart/remove";
            let method = "post";
            jQuery.Order.removeCart(data, url, method);
        });

        //Xóa món ăn ở giỏ hàng ở góc trên cùng bên phải
        $myCart.on("click", ".cart-item", function () {
            let id = $(this).data("id");
            let data = { id: id, isDelAll: false };

            let url = "cart/remove";
            let method = "post";
            // $("#order-page #modal-form").modal("toggle");
            jQuery.Order.removeCart(data, url, method);
        });

        //Click vào button đặt hàng
        $customerArea.on("click", "button", function (e) {
            e.preventDefault();
            let qtyProduct = $(".qty-product-in-cart").text();

            if (parseInt(qtyProduct) <= 0) {
                swalAlert(
                    "error",
                    "Đặt hàng thất bại",
                    "Giỏ hàng trống! Vui lòng thêm món ăn vào giỏ hàng trước!"
                );
                return;
            }

            let data = jQuery.Order.getParams($("#form-customer"));
            let url = "order/order";
            let method = "post";
            jQuery.Order.submitData(data, url, method);
        });
    } catch (e) {
        console.log(e);
        alert("The engine can't understand this code, it's invalid");
    }
});
