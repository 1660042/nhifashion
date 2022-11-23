(function ($) {
    let OrderPlaced = function () {
        this.isDone = false;
    };
    jQuery.OrderPlaced = new OrderPlaced();
    jQuery.extend(OrderPlaced.prototype, {
        showModal: function (data = {}, url = "", method = "get") {
            izanagi(
                url,
                method,
                data,
                null,
                jQuery.OrderPlaced.showModalCallback
                // jQuery.OrderPlaced.showModalCallbackError
            );
        },

        showModalCallback: function (res) {
            if (res.data.status) {
                $("#order-placed-page #modal-box").html("");
                $("#order-placed-page #modal-box").html(res.data.view);
                // $("#menu-page #modal-form").modal({
                //     backdrop: "static",
                //     keyboard: false,
                // });
                $("#order-placed-page #modal-form").modal("show");
            }
        },
        showModalCallbackError: function (err) {
            console.log(err);

            if (err.status == 404) {
                swalAlert(err.data.icon, err.data.title, err.data.message);
                jQuery.OrderPlaced.getData();
            }
        },

        getData: function () {
            data = {};
            izanagi(
                "order/get-data",
                "post",
                data,
                null,
                jQuery.OrderPlaced.getDataCallback,
                ""
            );
        },

        getDataCallback: function (res) {
            if (res.data.status) {
                $("#order-placed-page #cart-area").html(res.data.view);
            }
        },

        removeCart: function (data = {}, url = "cart/remove", method = "get") {
            izanagi(
                url,
                method,
                data,
                null,
                jQuery.OrderPlaced.removeCartCallback
            );
        },

        removeCartCallback: function (res) {
            if (res.data.status) {
                swalAlert(res.data.icon, res.data.title, res.data.message);
                getCart();
                jQuery.OrderPlaced.getData();
            }
        },
    });
})(jQuery);

$("document").ready(function () {
    try {
        let $listOrderPlaced = $("#order-placed-page #list-order-placed");
        let $myCart = $(".my-cart");
        let $pagination = $("#order-placed-page .pagination-custom");

        //Remove product in cart
        $myCart.on("click", ".cart-item", function () {
            let id = $(this).data("id");
            let data = { id: id, isDelAll: false };

            let url = "cart/remove";
            let method = "post";
            // $("#order-placed-page #modal-form").modal("toggle");
            jQuery.OrderPlaced.removeCart(data, url, method);
        });

        //Hiển thị chi tiết đơn hàng
        $listOrderPlaced.on("click", ".fa-eye", function () {
            let id = $(this).parent().parent().data("id");

            let data = { id: id };
            let url = "order/placed-detail";
            let method = "post";
            jQuery.OrderPlaced.showModal(data, url, method);
        });

        //Pagination
        $pagination.on("click", ".page-link", function (e) {
            e.preventDefault();
            let liActive = $(this).parent().hasClass("active");
            let page = Number($(this).attr("data-page")) || false;
            if (page == false || liActive == true) {
                return;
            }
            let data = {};
            let url = "order/placed?page=" + page;
            let method = "get";
            jQuery.OrderPlaced.getDataWithPag(data, url, method);
        });
    } catch (e) {
        console.log(e);
        alert("The engine can't understand this code, it's invalid");
    }
});
