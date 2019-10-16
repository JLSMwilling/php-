<?php
$sku = empty($_GET["sku"]) ? "" : $_GET["sku"];
if ($sku == "") {
    header('location: ecommerce.php');
    exit();
}
include 'dbconnection-ecommerce.php';

$my_query = "SELECT * FROM inventory where sku=:sku";
$stmt = $db->prepare($my_query);
$stmt->bindParam(':sku',$sku,PDO::PARAM_STR);
// Send the query to the database server://

 $stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Details</title>
    <style>
        body{
            background-image:linear-gradient(330deg, rgba(225, 225, 225, 0.05) 0%, rgba(225, 225, 225, 0.05) 33.333%,rgba(114, 114, 114, 0.05) 33.333%, rgba(114, 114, 114, 0.05) 66.666%,rgba(52, 52, 52, 0.05) 66.666%, rgba(52, 52, 52, 0.05) 99.999%),linear-gradient(66deg, rgba(181, 181, 181, 0.05) 0%, rgba(181, 181, 181, 0.05) 33.333%,rgba(27, 27, 27, 0.05) 33.333%, rgba(27, 27, 27, 0.05) 66.666%,rgba(251, 251, 251, 0.05) 66.666%, rgba(251, 251, 251, 0.05) 99.999%),linear-gradient(225deg, rgba(98, 98, 98, 0.05) 0%, rgba(98, 98, 98, 0.05) 33.333%,rgba(222, 222, 222, 0.05) 33.333%, rgba(222, 222, 222, 0.05) 66.666%,rgba(228, 228, 228, 0.05) 66.666%, rgba(228, 228, 228, 0.05) 99.999%),linear-gradient(90deg, rgb(28, 20, 63),rgb(40, 160, 253));
        }
        h1{
            text-align: center;
            margin:5rem ;
            color:rgb(46, 255, 140) ;
        }

        #descrip{
            text-indent: 1rem;
            margin:0 5rem 0;
            color:rgb(160, 255, 40) ;
        }
        
        #price{
            text-align: center;
            font-size: 1.5rem;
            color: rgb(123, 102, 241);
        }
        form{
            display: flex;
            align-content: center;
        }
    </style>
</head>

<body>
    <main>

        <h1><?=$row["title"]?></h1>
        
        <p id="descrip"><?=$row["description"]?></p>
        <div>
            <p id="price">price:<?=$row["unit_price"]?> each</p>

            <form action="cart.php">
                <input type="hidden" name="sku" value="<?=$row['sku']?>">
                <input id="form" type="number" name="addtocart" min="1" placeholder="How many?">
                <input type="submit" value="submit">
            </form>
        </div>

    </main>
</body>

</html>