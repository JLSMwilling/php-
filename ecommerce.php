<?php
include_once "dbconnection-ecommerce.php"; // Connect to the DB server and select the DB.
// Create the query string:
$my_query = "SELECT sku,title,left(description,35) AS 'description',unit_price,in_stock FROM `inventory`";

// Send the query to the database server:
$result = $db->query($my_query);
?>
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

<table>
    <tr>
        <th>Items</th>
        <th>price</th>
        <th>How many in stock</th>
    </tr><?php
            // Fetch the results of the query:
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

                // Do something with each $row of data.
                ?>
    <tr>
        <td><a href="details.php?sku=<?= $row["sku"] ?>"><?= $row["title"] ?></a>
        </td>

        <td>$<?= number_format($row["unit_price"], 2) ?></td>
        <td><?= $row["in_stock"] ?></td>




    </tr>
    <?php // the closing curly bracket is PHP, not HTML.
    }
    ?>
</table>