<?php
include 'dbconnection-ecommerce.php';

$sku = empty($_GET['sku']) ? "" : $_GET['sku'];
$addToCart = empty($_GET['addtocart']) ? "" : $_GET['addtocart'];
$delete = array_key_exists('delete',$_GET);

if($delete){
 $query = "DELETE FROM cart WHERE sku = :sku";
 $stmt= $db->prepare($query);
 $stmt->bindParam(':sku',$sku,PDO::PARAM_STR);
 $stmt->execute();
}else{

    
    $my_cart_query = "INSERT INTO `cart`(`sku`, `in_cart`) VALUES (:sku,:addtocart) 
ON DUPLICATE KEY UPDATE in_cart= in_cart + :addtocart";


$stmt = $db->prepare($my_cart_query);
$stmt->bindParam(":sku", $sku);
$stmt->bindParam(':addtocart', $addToCart);
$stmt->execute();
}

$my_query = " SELECT inventory.sku,title,unit_price, in_cart,round(in_cart * unit_price, 2) AS subtotal
FROM
cart
LEFT JOIN inventory ON (
 cart.sku = inventory.sku
)";
$result = $db->query($my_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        td:nth-child(3) {
            text-align: center;
        }

        td:nth-child(2) {
            text-align: right;
        }

        tr:nth-child(even) {
            background-color: greenyellow;
        }

        tr:nth-child(odd) {
            background-color: hotpink;
        }

        table {
            width: 75%;
            box-shadow: 5rem 5rem 5rem royalblue;
            margin: auto;
        }
    </style>
</head>

<body>

    <table>
        <tr>
            <th>Item</th>
            <th>Unit Price</th>
            <th>In cart</th>
            <th>Subtotal</th>

        </tr>
        <?php
        $total = 0;
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $total += $row['subtotal'];
            ?>
        <tr>
            <td><?= $row['title'] ?></td>
            <td><?= $row['unit_price'] ?></td>
            <td><?= $row['in_cart'] ?></td>
            <td><?= $row['subtotal'] ?></td>
            <td><a href="cart.php?delete=&sku=<?= $row["sku"]?>">Delete</a></td>
        </tr>
        <?php
        }
        ?>
        <tr>
            <th colspan="3">total</th>
            <td><?= $total ?></td>
        </tr>
    </table>
</body>

</html>