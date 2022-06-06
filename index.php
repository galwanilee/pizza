<?php
include_once "db.php"

?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <title>Pizza House</title>
  <link rel="icon" href="images/favicon.png">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap"
        rel="stylesheet">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="slick/slick.css">
  <link rel="stylesheet" href="slick/slick-theme.css">
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/main.css?<?=rand(0,100000);?>">
  <link rel="stylesheet" href="css/responce.css?<?=rand(0,100000);?>">

</head>
<body>
<div class="modal modal-registration hidden">
  <div class="form-wrapper">
    <img src="images/icons/cross.svg" alt="Закрити" class="close-modal" onclick="closeModals()">
    <p class="title">Реєстрація</p>
    <form class="registration">
      <input type="text" placeholder="Ім'я" name="firstname">
      <input type="text" placeholder="Телефон" name="phone" maxlength="13" pattern="^\W+[0-9]+$">
      <input type="text" placeholder="Пароль" name="password" minlength="6" maxlength="16">
      <button type="submit" class="btn btn-red">Зареєструватись</button>
    </form>
  </div>
</div>
<div class="modal modal-login hidden">
  <div class="form-wrapper">
    <img src="images/icons/cross.svg" alt="Закрити" class="close-modal" onclick="closeModals()">
    <p class="title">Вхід</p>
    <form class="login">
      <div class="form-error hidden"></div>
      <input type="text" placeholder="Телефон" name="phone">
      <input type="password" placeholder="Пароль" name="password">
      <button type="submit" class="btn btn-red">Увійти</button>
    </form>
  </div>
</div>
<header>
  <div class="container header__container">
    <nav>
      <div class="nav__left">
        <img src="images/logo.svg" alt="Pizza House" class="logo" onclick="closeCart()">
      </div>
      <div class="nav__right">
        <ul>
          <li><a href="#pizza" class="nav__link" onclick="closeCart()">Піца</a></li>
          <li><a href="#drinks" class="nav__link" onclick="closeCart()">Напої</a></li>
          <li class="login-btn__wrapper"><a href="#login" class="btn-outline" onclick="openLogin()">Вхід</a></li>
          <li class="registration-btn__wrapper"><a href="#registration" class="btn-outline" onclick="openRegistration()">Реєстрація</a></li>
          <li class="user hidden">
            <span class="user-name"></span>
          </li>
          <li class="cart-btn__wrapper">
            <a class="cart" onclick="openCart()">
              <svg width="28" height="25" viewBox="0 0 28 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M25.6725 14.7128L27.9705 4.55659C28.1364 3.82329 27.5815 3.125 26.8328 3.125H7.73928L7.29371 0.937012C7.18268 0.39165 6.70493 0 6.15071 0H1.16667C0.522326 0 0 0.524658 0 1.17188V1.95312C0 2.60034 0.522326 3.125 1.16667 3.125H4.56376L7.97859 19.8943C7.16163 20.3662 6.61111 21.2511 6.61111 22.2656C6.61111 23.7758 7.82989 25 9.33333 25C10.8368 25 12.0556 23.7758 12.0556 22.2656C12.0556 21.5003 11.7422 20.8088 11.2377 20.3125H21.4289C20.9245 20.8088 20.6111 21.5003 20.6111 22.2656C20.6111 23.7758 21.8299 25 23.3333 25C24.8368 25 26.0556 23.7758 26.0556 22.2656C26.0556 21.183 25.4291 20.2475 24.5205 19.8044L24.7887 18.6191C24.9546 17.8858 24.3997 17.1875 23.651 17.1875H10.6029L10.2847 15.625H24.5349C25.0796 15.625 25.5518 15.2464 25.6725 14.7128Z"
                    fill="#282828"/>
              </svg>
              <span class="cart-count"></span>
            </a>
          </li>
        </ul>
      </div>
    </nav>
  </div>
</header>
<div class="hero">
  <div class="container hero__container">
    <div class="hero-slider">
      <div class="slide-wrapper">
        <img src="images/slider/slide1.png" alt="Усі зали піцерій вже відкриті!">
      </div>
      <div class="slide-wrapper">
        <img src="images/slider/slide2.png" alt="Безконтактна доставка. 30 хвилин">
      </div>
      <div class="slide-wrapper">
        <img src="images/slider/slide3.png" alt="-40% на кожну другу піцу">
      </div>
    </div>
  </div>
</div>
<div class="main">
  <div class="main-loader">
    <div class="loader">
      <div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div>
    </div>
  </div>
  <div class="container">
    <h3 class="title" id="pizza">Піца</h3>
    <div class="product-cards__wrapper">
        <?php
        if ($result = $mysqli->query("SELECT DISTINCT product_imgname, product_name, product_desc FROM products;")) {
            foreach ($result as $row) {
                if (strpos($row["product_name"], 'Піца') !== false) {
                    $product_imgname = $row["product_imgname"];
                    echo '<div class="product-card">';
                    echo '<div class="product-card__top">';
                    echo '<img src="images/products/' . $product_imgname . '.png"></img>';
                    echo '<p class="title">' . $row["product_name"] . '</p>';
                    if ($row["product_desc"]) {
                        echo '<p class="description">' . $row["product_desc"] . '</p>';
                    }
                    echo '</div>';
                    if ($result1 = $mysqli->query("SELECT id_product, product_imgname, product_size, product_price FROM products WHERE product_imgname = '" . $product_imgname . "'")) {
                        echo '<div class="product-card__bottom">';
                        echo '<div class="product-sizes">';
                        foreach ($result1 as $row1) {
                            echo '<span data-product-count="0" data-id_product="' . $row1["id_product"] . '" >' . $row1["product_size"] . '</span>';
                        }
                        echo '</div>';
                        echo '<div class="between">';
                        foreach ($result1 as $row1) {
                            echo '<span class="product-card_price hidden">' . $row1["product_price"] . ' грн.</span>';
                        }
                        echo '<button class="btn btn-red btn-cart">В кошик</button>';
                        echo '<div class="number hidden"><button class="btn btn-red minus">-</button><span>1</span><button class="btn btn-red plus">+</button></div>';
                        echo '</div>';
                        echo '</div>';
                    } else {
                        echo '<script> console.log("SQL error \n\n Number: ' . $mysqli->errno . '\n\n' . $mysqli->error . '")</script>';
                    }
                    echo '</div>';
                }
            }
        } else {
            echo '<script> console.log("SQL error \n\n Number: ' . $mysqli->errno . '\n\n' . $mysqli->error . '")</script>';
        }

        ?>
    </div>
    <h3 class="title" id="drinks">Напої</h3>
    <div class="product-cards__wrapper">
        <?php
        if ($result = $mysqli->query("SELECT DISTINCT product_imgname, product_name, product_desc FROM products;")) {
            foreach ($result as $row) {
                if (strpos($row["product_name"], 'Піца') === false) {
                    $product_imgname = $row["product_imgname"];
                    echo '<div class="product-card">';
                    echo '<div class="product-card__top">';
                    echo '<img src="images/products/' . $product_imgname . '.png"></img>';
                    echo '<p class="title">' . $row["product_name"] . '</p>';
                    if ($row["product_desc"]) {
                        echo '<p class="description">' . $row["product_desc"] . '</p>';
                    }
                    echo '</div>';
                    if ($result1 = $mysqli->query("SELECT id_product, product_imgname, product_size, product_price FROM products WHERE product_imgname = '" . $product_imgname . "'")) {
                        echo '<div class="product-card__bottom">';
                        echo '<div class="product-sizes">';
                        foreach ($result1 as $row1) {
                            echo '<span data-product-count="0" data-id_product="' . $row1["id_product"] . '" >' . $row1["product_size"] . '</span>';
                        }
                        echo '</div>';
                        echo '<div class="between">';
                        foreach ($result1 as $row1) {
                            echo '<span class="product-card_price hidden">' . $row1["product_price"] . ' грн.</span>';
                        }
                        echo '<button class="btn btn-red btn-cart">В кошик</button>';
                        echo '<div class="number hidden"><button class="btn btn-red minus">-</button><span>1</span><button class="btn btn-red plus">+</button></div>';
                        echo '</div>';
                        echo '</div>';
                    } else {
                        echo '<script> console.log("SQL error \n\n Number: ' . $mysqli->errno . '\n\n' . $mysqli->error . '")</script>';
                    }
                    echo '</div>';
                }
            }
        } else {
            echo '<script> console.log("SQL error \n\n Number: ' . $mysqli->errno . '\n\n' . $mysqli->error . '")</script>';
        }

        ?>
    </div>
  </div>
</div>
<div class="cart-main hidden">
  <div class="container">
    <p class="cart-warning">Кошик порожній</p>
    <div class="order-list"></div>
    <p class="order-sum hidden"></p>
    <form class="order-form hidden">
      <div class="form-item">
        <label for="address">Адреса доставки</label>
        <input type="text" placeholder="Адреса доставки" id="address" name="address" required>
      </div>
      <div class="form-item">
        <label for="payment_type">Оплата</label>
        <select name="payment_type" id="payment_type">
          <option value="Карта">Карта</option>
          <option value="Готівка">Готівка</option>
        </select>
      </div>
      <button type="submit" class="btn btn-red">Оформити замовлення</button>
    </form>
  </div>
</div>
<footer>
  <div class="container footer__container">
    © 2022 Pizza House
  </div>
</footer>
<button class="to-cart hidden" onclick="openCart()">
  <svg width="28" height="25" viewBox="0 0 28 25" fill="none" xmlns="http://www.w3.org/2000/svg" class="cart">
    <path
        d="M25.6725 14.7128L27.9705 4.55659C28.1364 3.82329 27.5815 3.125 26.8328 3.125H7.73928L7.29371 0.937012C7.18268 0.39165 6.70493 0 6.15071 0H1.16667C0.522326 0 0 0.524658 0 1.17188V1.95312C0 2.60034 0.522326 3.125 1.16667 3.125H4.56376L7.97859 19.8943C7.16163 20.3662 6.61111 21.2511 6.61111 22.2656C6.61111 23.7758 7.82989 25 9.33333 25C10.8368 25 12.0556 23.7758 12.0556 22.2656C12.0556 21.5003 11.7422 20.8088 11.2377 20.3125H21.4289C20.9245 20.8088 20.6111 21.5003 20.6111 22.2656C20.6111 23.7758 21.8299 25 23.3333 25C24.8368 25 26.0556 23.7758 26.0556 22.2656C26.0556 21.183 25.4291 20.2475 24.5205 19.8044L24.7887 18.6191C24.9546 17.8858 24.3997 17.1875 23.651 17.1875H10.6029L10.2847 15.625H24.5349C25.0796 15.625 25.5518 15.2464 25.6725 14.7128Z"
        fill="#ffffff"/>
  </svg>
  <span class="cart-count"></span>
</button>
<script src="js/jquery.min.js"></script>
<script src="js/jquery.cookie.js"></script>
<script src="slick/slick.min.js"></script>
<script src="js?<?=rand(0,100000);?>"></script>
</body>
</html>
