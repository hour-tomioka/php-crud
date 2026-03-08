<?php
include('db.php');

if (!isset($_GET['id'])) {
    echo "Missing product id";
    exit();
}

$id = (int) $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = $_POST['name']        ?? '';
    $unitPrice   = $_POST['Unit_price']  ?? '';
    $description = $_POST['description'] ?? '';

    if ($name === '' || $unitPrice === '' || $description === '') {
        echo "Please fill in all fields.";
        exit();
    }

    $stmt = $conn->prepare("UPDATE Products SET Name = ?, UnitPrice = ?, Description = ? WHERE ProductId = ? AND IsDeleted = 0");
    $stmt->bind_param("sdsi", $name, $unitPrice, $description, $id);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Update error: " . $stmt->error;
    }

    $stmt->close();
}

// 2) Load product data to show in form
$stmt = $conn->prepare("SELECT ProductId, Name, UnitPrice, Description FROM Products WHERE ProductId = ? AND IsDeleted = 0");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Product not found";
    exit();
}

$product = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update</title>
    <linK rel="stylesheet" href="style.css">
</head>
<body style="place-items: center; text-align: center;">
    <div class="container">
        <div class="card">
        <h2>Update Product</h2>
            <form method="POST">
                <label>Product Name:</label>
                
                <input type="text" name="name" value="<?= htmlspecialchars($product['Name']) ?>"><br><br>

                <label>Unit Price:</label>

                <input type="number" step="0.01" name="Unit_price" value="<?= htmlspecialchars($product['UnitPrice']) ?>"><br><br>

                <label>Description:</label>

                <textarea name="description"><?= htmlspecialchars($product['Description']) ?></textarea><br><br>

                <div class="btn">
                    <button class="btnSubmit" type="submit">Update</button>
                    <button class="btnBack"><a href="index.php">Product Lists</a></button>
                </div>
            </form>
        </div>
    </div>
    
</body>
</html>