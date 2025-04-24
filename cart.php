<?php
session_start();
function displayCart()
{
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        echo "<p>Ваша корзина пуста</p>";
    } else {
        foreach ($_SESSION['cart'] as $id => $item) {
            echo "<div class='cart-item'>";
            echo "<img src='img/dish/" . $item["image"] . "' alt='" . $item["dish"] . "'>";
            echo "<h2 class = 'cardname'>" . $item["dish"] . "</h2>";
            echo "<p class='cost'>Цена: <span class='price'>" . $item['price'] . "</span> </p>";
            echo "<input type='hidden' name='id_plant' value='" . $id . "'>";
            echo "<input class='label_val qty' type='number' name='quantity' data-id='" . $id . "' value='" . $item["quantity"] . "' min='1'>";
            echo "<button type='submit' name='action' value='remove' class='submit-button remove-from-cart'  data-id='" . $id . "'>Удалить</button>";
            echo "</div>";
        }
    }
}

function checkout()
{
}

include 'header.php';
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Cart</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
          rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <?php
    include "shared_styles.php";
    ?>
</head>

<body>
<h2 class="name-cart">Корзина</h2>
<div class="cart_items">
    <?php
    echo "<div class = 'cart_card'>";
    displayCart();
    $totalPrice = 0;
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $id => $item) {
            $quantity = $item['quantity'];
            $price = $item['price'];
            $totalPrice += $price * $quantity;
        }
    }
    echo "</div>";
    echo "<div>";
    echo "<p class='total_price'>Итого: <span id='total-price'>" . $totalPrice . "</span> Руб." . "</p>";
    echo "</div>" ?>
</div>
<button class='order_button' onclick='showModal()'>Заказать</button>
<div id="modalOverlay" class="modal-overlay" style="display:none;">
    <div id="orderModal" class="modal">
        <span class="close-modal" onclick="closeModal()">&times;</span>
        <form id="orderForm">
            <h2>Оформление заказа</h2>
            <label for="name">Имя:</label>
            <input type="text" id="name" name="name" required>
            <label for="phone">Телефон:</label>
            <input type="tel" id="phone" name="phone" required>
            <button type="submit" class="submit-button">Оформить заказ</button>
        </form>
    </div>
</div>
<script>
    function showModal() {
        document.getElementById('modalOverlay').style.display = 'flex';
        setTimeout(() => {
            document.getElementById('modalOverlay').classList.add('show-modal');
            document.getElementById('orderModal').classList.add('show-modal');
        }, 10);
    }

    function closeModal() {
        document.getElementById('modalOverlay').classList.remove('show-modal');
        document.getElementById('orderModal').classList.remove('show-modal');
        setTimeout(() => {
            document.getElementById('modalOverlay').style.display = 'none';
        }, 300);
    }
</script>
<script>
    const cartEndpoint = 'cart_handler.php';

    async function removeItem(id) {
        const response = await fetch(cartEndpoint, {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({action: 'remove', id_dish: id})
        });

        const result = await response.json();
        if (result.success) {
            window.location.reload();
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        let quantities = document.querySelectorAll('input.qty');
        let removeBtn = document.querySelectorAll('button.remove-from-cart');

        Array.prototype.slice.call(quantities).forEach(function (qty) {
            qty.addEventListener('change', async function () {
                const id = this.dataset.id;
                const quantity = parseFloat(this.value);

                const response = await fetch(cartEndpoint, {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({action: 'update', id, quantity})
                });
                const result = await response.json();
                document.querySelector('#total-price').innerHTML = result.total;
            });
        });


        Array.prototype.slice.call(removeBtn).forEach(function (btn) {
            btn.addEventListener('click', async function () {
                const id = this.dataset.id;
                await removeItem(id)
            });
        });
    });
</script>
<script type="module">
    import Toaster from './js/modules/notification/toaster.js'

    const toaster = new Toaster();

    document.getElementById('orderForm').addEventListener('submit', function (event) {
        event.preventDefault();

        var formData = new FormData(this);

        fetch('create_order.php', {
            method: 'POST',
            body: formData
        })
            .then(async response => {
                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.description);
                }
                return response.json();
            })
            .then(response => {
                toaster.showNotification({
                    title: 'Успешно',
                    message: response.description,
                    type: 'success',
                });
            })
            .catch(error => {
                toaster.showNotification({
                    title: 'Ошибка',
                    message: error.message,
                    type: 'danger',
                });
            });
    });
</script>
</body>

</html>