<?php

function getOrderItems($mysqli, $orderId): array
{
    $itemsQuery = "
        SELECT 
            oi.dish_id, 
            d.dish, 
            d.weight,
            d.recipes,
            oi.quantity, 
            oi.price
        FROM 
            order_items AS oi
        JOIN 
            dish AS d ON oi.dish_id = d.id_dish
        WHERE 
            oi.order_id = ?";
    $stmt = $mysqli->prepare($itemsQuery);
    $stmt->bind_param('i', $orderId);
    $stmt->execute();
    $itemsResult = $stmt->get_result();

    $orderItems = [];
    while ($item = $itemsResult->fetch_assoc()) {
        $orderItems[] = $item;
    }

    return $orderItems;
}