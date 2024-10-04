/**
 * Delete Function
 */
function confirmDelete(id) {
    const deleteUrl = $(".deleteUrl_" + id).attr("data-url");
    document.getElementById("delete-form").action = deleteUrl;
}

/**
 * Add To Cart
 */

const addToCart = (id) => {
    const orderProductId = $.trim(id);
    const orderProductQty = parseInt($("#order_qty_" + orderProductId).val());
    const addToCartUrl = $("#addToCart_" + orderProductId).attr("data-url");
    const productStockQty = parseInt(
        $("#addToCart_" + orderProductId).attr("data-qty")
    );
    const comingsoon = $("#addToCart_" + orderProductId).attr(
        "data-comingsoon"
    );

    $("#successCart_" + orderProductId).html("");
    $("#errorCart_" + orderProductId).html("");

    if (
        $.trim(orderProductQty) == "" ||
        $.trim(orderProductQty) == null ||
        $.trim(orderProductQty) <= 0
    ) {
        $("#order_qty_" + orderProductId).focus();
        $("#errorCart_" + orderProductId).html(
            "Order quantity cannot be less than 1."
        );
        return false;
    }

    if (orderProductQty > productStockQty && comingsoon == "0") {
        $("#order_qty_" + orderProductId).val(0);
        $("#errorCart_" + orderProductId).html(
            "Order quantity cannot be greater than Total stock available."
        );
        return false;
    }

    var request = $.ajax({
        url: addToCartUrl,
        type: "post",
        data: { product_id: orderProductId, order_quantity: orderProductQty },
        dataType: "json",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    request.done(function (msg) {
        /**
         * Show in Cart
         */
        $("#orderCartNo").html(msg);
        $("#successCart_" + orderProductId).html(
            "Product added to order list."
        );
    });

    request.fail(function (jqXHR, textStatus) {
        location.reload();
    });
};

/**
 * Remove From Cart
 */

const removeFromCart = (id) => {
    const orderProductId = $.trim(id);
    const removeFromCartUrl = $("#removeFromCart_" + orderProductId).attr(
        "data-url"
    );
    const orderProductQty = $("#order_qty_" + orderProductId).val();

    if (
        $.trim(orderProductQty) == "" ||
        $.trim(orderProductQty) == null ||
        $.trim(orderProductQty) <= 0
    ) {
        return false;
    }

    var request = $.ajax({
        url: removeFromCartUrl,
        type: "post",
        data: { product_id: orderProductId },
        dataType: "json",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    request.done(function (msg) {
        if (msg == "notfound") {
            $("#order_qty_" + orderProductId).val("");
            return true;
        }
        /**
         * Show in Cart
         */
        if (msg == 0) {
            location.reload();
        }
        $("#orderCartNo").html(msg);
        $("#row_" + orderProductId).fadeOut();
        $("#order_qty_" + orderProductId).val("");
        $("#successCart_" + orderProductId).html(
            "Product removed from order list."
        );
    });

    request.fail(function (jqXHR, textStatus) {
        location.reload();
    });
};

/**
 * SHOW NEW ORDER
 */

const showNewOrders = () => {
    var request = $.ajax({
        url: "/common/allneworders",
        type: "get",
        dataType: "json",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    request.done(function (data) {
        var orderCountNotification = $("#orderNotification");
        var orderList = $("#orderMessages");
        var content = "";
        if (data.newOrderCount === 0) {
            content += '<a class="dropdown-item d-flex" href="/order/list/">';
            content += '<div class="wd-90p">';
            content += '<div class="d-flex">';
            content += '<h5 class="mb-1">No New Orders</h5>';
            content += "</div>";
            content += "</div>";
            content += "</a>";
            orderList.html(content);
            orderCountNotification.removeAttr("class");
        } else {
            $.each(data.newOrders, function (index, newOrders) {
                content +=
                    '<a class="dropdown-item d-flex" href="/order/orderdetails/' +
                    newOrders.order_id +
                    '">';
                content += '<div class="wd-90p">';
                content += '<div class="d-flex">';
                content += '<h5 class="mb-1">' + newOrders.order_id + "</h5>";
                content +=
                    '<small class="text-muted ms-auto text-end">' +
                    newOrders.user_code +
                    "</small>";
                content += "</div>";
                content +=
                    '<span class="fs-12 text-muted">' +
                    newOrders.dealer_name +
                    "</span>";
                content += "</div>";
                content += "</a>";
            });
            orderList.html(content);
            orderCountNotification.attr("class", "pulse-danger");
        }
    });

    request.fail(function (jqXHR, textStatus) {
        location.reload();
    });
};

const checkOutOfStock = () => {
    $.ajax({
        url: "/common/checkoutofstock", // Route URL for fetching users
        method: "GET",
        dataType: "json",
        success: function (data) {},
        error: function (xhr, status, error) {
            console.error(error);
        },
    });
};
