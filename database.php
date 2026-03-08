<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Match EXACTLY with the form field names
    $name = $_POST['name'] ?? '';
    $unitPrice = $_POST['Unit_price'] ?? '';
    $description = $_POST['description'] ?? '';

    // Basic validation
    if ($name == '' || $unitPrice == '' || $description == '') {
        echo "Please fill in all fields.";
        exit();
    }

    // Prepared statement (safe)
    $stmt = $conn->prepare("INSERT INTO Products (Name, UnitPrice, Description) VALUES (?, ?, ?)");
    $stmt->bind_param("sds", $name, $unitPrice, $description); // s=string, d=double, s=string

    if ($stmt->execute()) {
        // Redirect back to product list after insert
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Product</title>
    <linK rel="stylesheet" href="style.css">
</head>
<body style="place-items: center; text-align: center;">
    <div class="container">
        <div class="card">
            <h2>Create New Product</h2>
            <form method="POST">
                <div class="field">
                    <label>Product Name:</label>
                    <input type="text" name="name">
                </div>

                <div class="field">
                    <label>Unit Price:</label>
                    <input type="number" step="0.01" name="Unit_price">
                </div>

                <div class="field">
                    <label>Description:</label>
                    <textarea name="description"></textarea>
                </div>

                <div class="btn">
                    <input type="submit" value="Submit" class="btnSubmit">
                    <button class="btnBack"><a href="index.php">Product lists</a></button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>