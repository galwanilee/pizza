let order = []
$(window).on("load", function() {
    let productsCount = 0
    $('.hero-slider').ready(function () {
        $('.hero-slider').slick({
            fade: true,
            speed: 500,
            autoplay: 4000,
            arrows: false,
            dots: true
        })
    })
    $('.main-loader').addClass('hidden');
    $('.product-card .product-sizes span:first-child').addClass('selected');
    $('.product-card .product-card_price:first-child').removeClass('hidden');
    $('.product-card .product-sizes span').on('click', function () {
        let parent =  $(this).parents('.product-card');
        let index = $(this).index();

        parent.find('.selected').removeClass('selected');
        $(this).addClass('selected');

        parent.find('.product-card_price').addClass('hidden');
        parent.find('.product-card_price').eq(index).removeClass('hidden')
        let current_count = parseInt(parent.find('span.selected').attr('data-product-count'));
        if (parent.find('.between .number span')) {
            parent.find('span.selected').attr('data-product-count', current_count)
            parent.find('.between .number span').text(current_count)
            if (current_count > 0) {
                parent.find('.between .btn-cart').addClass('hidden')
                parent.find('.between .number').removeClass('hidden')
            } else {
                parent.find('.between .btn-cart').removeClass('hidden')
                parent.find('.between .number').addClass('hidden')
            }
        }
    })
    $('.product-card button.btn-cart').on('click', function () {
        let parent =  $(this).parents('.product-card');

        $(this).addClass('hidden')
        parent.find('.between .number').removeClass('hidden')
        productsCount += 1
        $('.cart-count').text(productsCount).css('width', 'auto')
        $('.to-cart').removeClass('hidden')
        let current_count = parseInt(parent.find('span.selected').attr('data-product-count'));
        if (current_count < 20) {
            parent.find('span.selected').attr('data-product-count', current_count + 1)
            parent.find('.between .number span').text(current_count + 1)
        }
        refreshOrder()
    })
    $('.product-card .number button.plus').on('click', function () {
        let parent =  $(this).parents('.product-card');
        let numberElement = parent.find('.number span')
        let currentNumber = parseInt(numberElement.text())
        if (currentNumber < 20) {
            numberElement.text(currentNumber+1)
            productsCount += 1
            $('.cart-count').text(productsCount).css('width', 'auto')
            $('.to-cart').removeClass('hidden')

            let current_count = parseInt(parent.find('span.selected').attr('data-product-count'));
            parent.find('span.selected').attr('data-product-count', current_count + 1)
            parent.find('.between .number span').text(current_count + 1)
        }
        refreshOrder()
    })
    $('.product-card .number button.minus').on('click', function () {
        let parent =  $(this).parents('.product-card');
        let numberElement = parent.find('.number span')
        let currentNumber = parseInt(numberElement.text())
        productsCount -= 1

        let current_count = parseInt(parent.find('span.selected').attr('data-product-count'));
        if (current_count === 1) {
            numberElement.text(currentNumber-1)
            $('.cart-count').text(productsCount).css('width', 'auto')
        }
        parent.find('span.selected').attr('data-product-count', current_count - 1)
        parent.find('.between .number span').text(current_count - 1)
        if (currentNumber === 1) {
            parent.find('.between .number').addClass('hidden')
            parent.find('.between .btn-cart').removeClass('hidden')
        } else {
            numberElement.text(currentNumber-1)
            $('.cart-count').text(productsCount).css('width', 'auto')
        }
        if (productsCount === 0) {
            $('.cart-count').text('').css('width', '0')
            $('.to-cart').addClass('hidden')
        }
        refreshOrder()
    })
});
function openCart() {
    $('.main').addClass('hidden')
    $('.hero').addClass('hidden')
    $('.to-cart').addClass('hidden')
    $('.cart-btn__wrapper').addClass('hidden')
    $('.cart-main').removeClass('hidden')
    if (order.length > 0) {
        $('.cart-warning').addClass('hidden')
        $('.order-sum').removeClass('hidden')
        $('.order-form').removeClass('hidden')
    } else {
        $('.cart-warning').removeClass('hidden')
        $('.order-sum').addClass('hidden')
        $('.order-form').addClass('hidden')
    }
    $.ajax({
        type: "POST",
        url: 'getProducts.php',
        data: {
            'order': order,
        }, success: function(response) {
            response = JSON.parse(response)
            let sum = 0
            $('.cart-main .order-list').html('')
            for (let i = 0; i <= response.length; i++) {
                $('.cart-main .order-list').append('<div class="product-card">' +
                  `<div class="card-left"><img src="images/products/${response[i].imgname}.png" alt="">` +
                  `<div><p class="title">${response[i].name}</p><p class="description">${(response[i].desc) ? response[i].desc : ''}</p><div class="product-sizes"><span class="selected">${response[i].size}</span></div></div></div>` +
                  `<div class="card-right"><p class="price">${response[i].price} грн.</p><p class="count" data-order-count="${order[i].orderCount}">${order[i].orderCount} шт.</p></div>` +
                  '</div>')
                sum += parseInt(response[i].price);
                $('.cart-main .order-sum').text('Сума:  ' + sum + ' грн.')
            }

        }
    })
}
function closeCart() {
    $('.main').removeClass('hidden')
    $('.hero').removeClass('hidden')
    $('.to-cart').removeClass('hidden')
    $('.cart-btn__wrapper').removeClass('hidden')
    $('.cart-main').addClass('hidden')
    if (order.length > 0) {
        $('.cart-warning').addClass('hidden')
    } else {
        $('.cart-warning').removeClass('hidden')
    }
}
function openLogin() {
    $('.modal-login').removeClass('hidden')
}
function openRegistration() {
    $('.modal-registration').removeClass('hidden')
}
function closeModals() {
    $('.modal').addClass('hidden')
}
$('form.login').on('submit', function (e) {
    let dataPhone = $(this).find('input[name="phone"]').val()
    let dataPassword = $(this).find('input[name="password"]').val()
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: 'login.php',
        data: {
          phone: dataPhone,
          password: dataPassword
        },
        success: function(response)
        {
            if (response !== 'error') {
                response = JSON.parse(response)
                $.cookie("pizzaHouseUserPhone", response.phone);
                $.cookie("pizzaHouseUserPass", response.password);
                $.cookie("pizzaHouseUserId", response.id_user);
                $('.login-btn__wrapper').addClass('hidden');
                $('.registration-btn__wrapper').addClass('hidden');
                $('.user').removeClass('hidden');
                $('.user-name').text(response.name);
                closeModals();
            } else {
                $('form.login .form-error').removeClass('hidden').text('Невірний телефон або пароль');
            }
        }
    });
})
$('form.registration').on('submit', function (e) {
    let dataName = $(this).find('input[name="firstname"]').val()
    let dataPhone = $(this).find('input[name="phone"]').val()
    let dataPassword = $(this).find('input[name="password"]').val()
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: 'registration.php',
        data: {
            phone: dataPhone,
            password: dataPassword,
            name: dataName
        },
        success: function(response)
        {
            if (response !== 'error') {
                response = JSON.parse(response)
                $.cookie("pizzaHouseUserPhone", response.phone);
                $.cookie("pizzaHouseUserPass", response.password);
                $.cookie("pizzaHouseUserId", response.id_user);
                document.location.reload();
            }
        }
    });
})

if ($.cookie("pizzaHouseUserPhone") && $.cookie("pizzaHouseUserPass")) {
    let dataPhone = $.cookie("pizzaHouseUserPhone");
    let dataPassword = $.cookie("pizzaHouseUserPass");
    $.ajax({
        type: "POST",
        url: 'login.php',
        data: {
            phone: dataPhone,
            password: dataPassword
        },
        success: function(response)
        {
            if (response !== 'error') {
                response = JSON.parse(response)
                $.cookie("pizzaHouseUserPhone", response.phone);
                $.cookie("pizzaHouseUserPass", response.password);
                $('.login-btn__wrapper').addClass('hidden');
                $('.registration-btn__wrapper').addClass('hidden');
                $('.user').removeClass('hidden');
                $('.user-name').text(response.name);
            }
        }
    });
}
function refreshOrder() {
    order = []
    $('.product-sizes span').each(function () {
        let obj = {
            'id': $(this).attr('data-id_product'),
            'orderCount': $(this).attr('data-product-count'),
        }
        if (obj.orderCount > 0) {
            order.push(obj);
            console.log(order)
        }
    })
}