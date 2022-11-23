var modal_show = 0;
var modal_create = 1;
var modal_edit = 2;
var modal_request = 3;
var modal_swichtoperator = 4;
var modal_instrumentoperator = 5;

function showProgress() {
    var progress_bar = jQuery("#progress");
    if (progress_bar.length == 1) {
        progress_bar.show();
    }
}

function hideProgress() {
    var progress_bar = jQuery("#progress");
    if (progress_bar.length == 1) {
        progress_bar.hide();
    }
}

axios.interceptors.request.use(
    function (options) {
        showProgress();
        return options;
    },
    function (error) {
        hideProgress();
    }
);

function izanagi(
    _action,
    _method,
    _data,
    _params,
    _callback,
    _callbackError,
    isDownload = false,
    disabled = []
) {
    var protocol = window.location.protocol;
    var hostname = window.location.hostname;
    var prefix = "";

    var options = {
        baseURL: protocol + "//" + hostname + "/" + prefix + "/",
        url: _action,
        method: _method,
    };

    var arrTemp = [];

    if (disabled.length > 0) {
        disabled.forEach(element => {
            if ($(element).prop('disabled') == true) {
                arrTemp.push(element);
            } else $(element).prop('disabled', true);
        });
    }

    if (typeof _data === "object") {
        if (_data instanceof FormData) {
            options.headers = {};
            options.headers["Content-Type"] = "multipart/form-data";
            options.data = _data;
        } else {
            options.data = qs.stringify(_data);
        }
    }

    if (isDownload) {
        options.responseType = "blob";
    }

    if (typeof _params === "object") {
        options.params = _params;
    }

    axios(options)
        .then(function (response) {
            if (disabled.length > 0) {
                disabled.forEach(element => {
                    if ($.inArray(element, arrTemp) == -1) {
                        $(element).prop("disabled", false);
                    }
                });
            }
            if (response.status === 205) {
                location.reload(true);
            } else if (typeof _callback == "function") {
                _callback(response, _data);
            }
        })
        .catch(function (error) {
            if (disabled.length > 0) {
                disabled.forEach(element => {
                    if ($.inArray(element, arrTemp) == -1) {
                        $(element).prop("disabled", false);
                    }
                });
            }
            if (
                error.response &&
                (error.response.status === 401 || error.response.status === 419)
            ) {
                if (error.response.status === 401) {
                    return (window.location.href = "/" + prefix + "/login");
                } else if (error.response.status === 419) {
                    location.reload();
                }
            } else if (typeof _callbackError == "function") {
                // console.log(error.response);
                _callbackError(error.response, _data);
            }
        });
}

function swalAlert(type, title, message) {
    swal.fire({
        icon: type,
        title: title,
        html: message,
        confirmButtonText: "Đóng",
    });
}

function swalConfirm(
    message,
    title = "Warning",
    icon = "warning",
    confirmButtonText = "Xóa",
    cancelButtonText = "Hủy",
    confirmButtonColor = "#dc3545",
    cancelButtonColor = "#6e7881"
) {
    return swal.mixin({
        title: title,
        html: message,
        icon: icon,
        showCancelButton: true,
        confirmButtonText: confirmButtonText,
        confirmButtonColor: confirmButtonColor,
        cancelButtonColor: cancelButtonColor,
        cancelButtonText: cancelButtonText,
        reverseButtons: true,
    });
}

function swalAlertConfirm(
    icon,
    title,
    message,
    confirmBtn,
    colorButtonCancel,
    colorButtonConfirm,
    _functionSubmit,
    data,
    cancelBtn = 'Cancel',
) {
    Swal.fire({
        title: title,
        text: message,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: colorButtonConfirm,
        cancelButtonColor: colorButtonCancel,
        confirmButtonText: confirmBtn,
        cancelButtonText: cancelBtn,
    }).then((result) => {
        if (result.isConfirmed) {
            // _functionSubmit(data);
            if (typeof _functionSubmit == "function") {
                _functionSubmit(data);
            }
        }
    });
}

function getCart(data = {}, url = "cart", method = "get") {
    izanagi(
        url,
        method,
        data,
        null,
        getCartCallback
    );
}

function getCartCallback(res) {
    if (res.data.status) {
        let myCart = $(".my-cart");
        let listProductInCart = $(".list-product-in-cart");
        let qtyProduct = $(".qty-product-in-cart");

        let protocol = window.location.protocol;
        let hostname = window.location.hostname;

        let url = protocol + "//" + hostname + "/order";

        // console.log(res.data);
        qtyProduct.html(Object.keys(res.data.cart).length);

        let html = "";
        $.each(res.data.cart, function (key, value) {
            // alert(value.tenmon);
            html +=
                `
                <a href="#" class="dropdown-item cart-item" data-id="` +
                value.id +
                `">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="` +
                value.anh +
                `"
                            alt="Image product" class="img-size-50 mr-3 img-circle">
                        <div class="media-body">
                            <h3 class="dropdown-item-title text-wrap">` +
                value.tenmon +
                `</h3>
                            <p class="text-sm">Số lượng: ` +
                value.qty +
                `</p>
                            <p class="text-sm text-muted"><i class="fas fa-dollar-sign"></i> Giá: ` +
                value.gia +
                ` VND</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>`;
        });
        html +=
            `<a href="` +
            url +
            `" class="dropdown-item dropdown-footer">Tới trang giỏ hàng</a>`;
        listProductInCart.html(html);
    }
}

function func_get_value_form(ele) {
    return $(ele)
        .serializeArray()
        .reduce(function (a, x) {
            let inputName = x.name;
            if (
                inputName.indexOf("[") !== -1 &&
                inputName.indexOf["]"] !== -1
            ) {
                let name = inputName.substring(0, inputName.indexOf("["));
                if (a[name]) {
                    let temp = a[name];
                    a[name] = temp.concat([x.value]);
                } else {
                    a[name] = [x.value];
                }
            } else a[x.name] = x.value;
            return a;
        }, {});
}

function func_clear_form(ele) {

    $(ele).find(".is-invalid").removeClass("is-invalid");
    $(ele).find("span[class='error invalid-feedback']").remove();
    $(ele).find(
        "input:text:not(:disabled), input:password, input:file, textarea:not(:disabled)"
    ).val("");
    $(ele).find("input:radio:not(:disabled), input:checkbox:not(:disabled)")
        .prop("checked", false)
        .removeAttr("selected");
    let radios = $(ele).find("input:radio");
    $(radios).each(function () {
        let el = $(this);
        if (el.val().length == 0) {
            el.prop("checked", true);
        }
    });
    let selects = $(ele).find("select:not(:disabled)");
    $(selects).each(function () {
        let el = $(this);
        if (el.prop("multiple")) {
            $(this).val("").trigger("change");
        } else if (typeof el[0].id !== "undefined" && el[0].id.trim()) {
            $(el[0].children).removeAttr("selected");
            $(this).val($("#" + el[0].id + " option:first").val());
            el.trigger("change");
        }
    });

    $("#sort_column1, #sort_column2").val("customer_id").change();
    $("#sort_type1_desc, #sort_type2_desc").prop("checked", true);
}

function func_show_error_validation(errs, idForm) {
    $(idForm).find(".is-invalid").removeClass("is-invalid");
    $(idForm).find("span[class='error invalid-feedback']").remove();
    $.each(errs, function (key, value) {
        $(idForm + " #" + key).addClass("is-invalid");
        let html = '<span class="error invalid-feedback">' + value + "</span>";
        $(idForm + " #" + key)
            .parent()
            .append(html);
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
}

function func_hide_error_validation(idForm) {
    $(idForm).find(".is-invalid").removeClass("is-invalid");
    $(idForm).find("span[class='error invalid-feedback']").remove();
}