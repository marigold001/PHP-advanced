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
<?php

// Use Descriptive Names - START
// Poor naming
function calc($a, $b) {
    return $a * $b / 100;
}

// Improved naming
function calculatePercentages($number, $percentage) {
    return $number * $percentage / 100;
//    25*5/100 = 125/100 = 1,25 or 25 %
}


// Use Descriptive Names - END

// Avoid Deep Nestings - START

// Deep nesting
function processOrderDeepNested($order) {
    if ($order->isPaid()) {
        if ($order->hasItems()) {
            foreach ($order->getItems() as $item) {
                if ($item->isInStock()) {
                    $item->reserve();
                } else {
                    return "Item out of stock";
                }
            }
            return "Order processed";
        } else {
            return "No items in order";
        }
    } else {
        return "Order not paid";
    }
}


// Refactored to avoid deep nesting

function processOrderrRefactored($order) {
    if (!$order->isPaid()) {
        return "Order not paid";
    }

    if (!$order->hasItems()) {
        return "No items in order";
    }

    foreach ($order->getItems() as $item) {
        if (!$item->isInStock()) {
            return "Item out of stock";
        }
        $item->reserve();
    }

    return "Order processed";
}

// Avoid Deep Nestings - END

// Limit the number of parameters - START

function createUserTooManyParameters($name, $email, $password, $age, $address, $phone) {
    // User creation logic
}


// Refactored with an Object

class UserData {
    public $name;
    public $email;
    public $password;
    public $age;
    public $address;
    public $phone;

    public function __construct($name, $email, $password, $age, $address, $phone) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->age = $age;
        $this->address = $address;
        $this->phone = $phone;
    }
}

function createUserExtractedToObject(UserData $userData) {
    // User creation logic
}

// Limit the number of parameters - END

// Modularize Your Code - START

// Monolithic Function

function handleRequest($request) {
    if ($request->isPost()) {
        $data = $request->getData();
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        if (filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
            // Save user to database
            $db = new Database();
            $db->save($user);
            return "User saved";
        } else {
            return "Invalid email";
        }
    } else {
        return "Invalid request";
    }
}


// Refactored with Modularity

function handleRequest($request) {
    if (!$request->isPost()) {
        return "Invalid request";
    }

    $data = $request->getData();
    $user = createUser($data);

    if (!validateUser($user)) {
        return "Invalid email";
    }

    saveUser($user);
    return "User saved";
}

function createUser($data) {
    $user = new User();
    $user->name = $data['name'];
    $user->email = $data['email'];
    return $user;
}

function validateUser($user) {
    return filter_var($user->email, FILTER_VALIDATE_EMAIL);
}

function saveUser($user) {
    $db = new Database();
    $db->save($user);
}

// Modularize Your Code - END

// Comment Sparingly - START

// Excessive Comments

/**
 * This function processes each item in the order to reserve stock if available
 * and calculates the total price after processing the items. It iterates over
 * each item, checks if it is in stock, reserves it if so, calculates its price,
 * adds the price to the total, and logs any out-of-stock items. After processing
 * all items, it applies any discount available on the order and returns the total
 * price.
 *
 * @param Order $order The order object containing items to process.
 * @return float The total price of the order after processing.
 */
function processOrderItemsExcessiveComments($order) {
    // Initialize total price accumulator
    $totalPrice = 0;

    // Loop through each item in the order
    foreach ($order->getItems() as $item) {
        // Check if the item is in stock
        if ($item->isInStock()) {
            // Reserve the item in stock
            $item->reserve();

            // Calculate the price of the item
            $itemPrice = $item->getPrice();

            // Add the price of the item to the total price
            $totalPrice += $itemPrice;
        } else {
            // Log a message indicating that the item is out of stock
            error_log("Item '{$item->getName()}' is out of stock.");
        }
    }

    // Apply any discount that may be available for the order
    if ($order->hasDiscount()) {
        // Retrieve the discount percentage
        $discount = $order->getDiscount();

        // Calculate the discount amount
        $discountAmount = $totalPrice * ($discount / 100);

        // Subtract the discount amount from the total price
        $totalPrice -= $discountAmount;
    }

    // Return the total price after processing and discount application
    return $totalPrice;
}



// Necessary Comments

/**
 * Processes each item in the order, reserves stock if available,
 * and calculates the total price.
 *
 * @param Order $order The order object containing items to process.
 * @return float The total price of the order after processing.
 */
function processOrderItemsWellCommented($order) {
    $totalPrice = 0;

    foreach ($order->getItems() as $item) {
        // Check if item is in stock
        if ($item->isInStock()) {
            // Reserve item
            $item->reserve();

            // Calculate item price
            $itemPrice = $item->getPrice();

            // Add item price to total price
            $totalPrice += $itemPrice;
        } else {
            // Log out-of-stock item
            error_log("Item '{$item->getName()}' is out of stock.");
        }
    }

    // Apply discount if applicable
    if ($order->hasDiscount()) {
        $discount = $order->getDiscount();
        $totalPrice -= $totalPrice * ($discount / 100);
    }

    return $totalPrice;
}

// Comment Sparingly - END

?>

</body>
</html>