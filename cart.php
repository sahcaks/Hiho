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
            $totalPrice = $item['price'] * $item['quantity'];
            echo "<p>Цена: " . $totalPrice . "</p>";
            echo "<form action='update_cart.php' method='post' class='update'>";
            echo "<input type='hidden' name='id_plant' value='" . $id . "'>";
            echo "<input class = 'label_val' type='number' name='quantity' value='" . $item["quantity"] . "' min='1'>";
            echo "<button type='submit' name='action' value='update' class='submit-button'>Обновить</button>";
            echo "<button type='submit' name='action' value='remove' class='submit-button'>Удалить</button>";
            echo "</form>";
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
        echo "<p class='total_price'>Итого: " . $totalPrice . " Руб." . "</p>";
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

        // Обработка отправки формы
        document.getElementById('orderForm').addEventListener('submit', function (event) {
            event.preventDefault();

            var formData = new FormData(this);

            // Отправляем данные формы на сервер через fetch
            fetch('create_order.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.text())
                .then(data => {
                    alert(data);
                    closeModal();
                })
                .catch(error => console.error('Ошибка:', error));
        });
    </script>
</body>

</html>