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
// Complex code: Example 1
function getUserStatusComplex($user)
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

function getUserStatusSimple($user) {
    if ($user->isActive) {
        return "Active";
    } elseif ($user->isBanned) {
        return "Banned";
    } else {
        return "Inactive";
    }
}


// Complex code: Example 2
function calculateDiscountComplex($price, $customer) {
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

function calculateDiscountSimple($price, $customer) {
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


// Use Descriptive Names
// Poor naming
function calc($a, $b) {
    return $a * $b / 100;
}

// Improved naming
function calculatePercentages($number, $percentage) {
    return $number * $percentage / 100;
//    25*5/100 = 125/100 = 1,25 or 25 %
}

// Avoid Deep Nestings

// Deep nesting
function processOrderDeepnested($order) {
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

// Limit the number of parameters

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


// Modularize Your Code

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


// Comment Sparingly

// Excessive Comments

function add($a, $b) {
    // This function adds two numbers
    // It takes two parameters
    // The first parameter is the first number
    // The second parameter is the second number
    // It returns the sum of the two numbers
    return $a + $b;
}


// Necessary Comments

// Adds two numbers and returns the result
function add($a, $b) {
    return $a + $b;
}

// Computes the factorial of a number recursively
function factorial($n) {
    if ($n === 0) {
        return 1; // Base case: 0! is 1
    }
    return $n * factorial($n - 1); // Recursive case
}


?>

</body>
</html>