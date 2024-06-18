<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHP Princliples</title>
</head>
<body>
<h3>KISS Keep it simple S.</h3>
<h5>Example 1: Simplifying Conditional Statements
    Complex Code:</h5>

<?php
// Complex code: Example 1
function getUserStatus($user)
{
    if ($user->isActive == true) {
        return "Active";
    } else {
        if ($user->isBanned == true) {
            return "Banned";
        } else {
            return "Inactive";
        }
    }
}

// Simplified code: Example 1

function getUserStatus($user) {
    if ($user->isActive) {
        return "Active";
    } elseif ($user->isBanned) {
        return "Banned";
    } else {
        return "Inactive";
    }
}


// Complex code: Example 2
function calculateDiscount($price, $customer) {
    $discount = 0;
    if ($customer->isPremium()) {
        if ($price > 100) {
            $discount = $price * 0.10;
        } else {
            $discount = $price * 0.05;
        }
    } else {
        if ($price > 100) {
            $discount = $price * 0.05;
        }
    }
    return $price - $discount;
}

// Simplified code: Example 2

function calculateDiscount($price, $customer) {
    $discountRate = 0;

    if ($customer->isPremium()) {
        $discountRate = $price > 100 ? 0.10 : 0.05;
    } else {
        $discountRate = $price > 100 ? 0.05 : 0;
    }

    $discount = $price * $discountRate;
    return $price - $discount;
}

// Complex code: Example 3
$numbers = [5, 3, 2];
$sum = 0;
for ($i = 0; $i < count($numbers); $i++) {
    $sum += $numbers[$i];
}

// Simplified code: Example 3

$sum = array_sum($numbers);



?>

</body>
</html>