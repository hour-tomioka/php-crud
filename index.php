<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <style>
		
		@keyframes move{
			0%{
				transform: rotate(0deg);
			}
			100%{
				transform: rotate(10deg);
			}
		}
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            padding: 40px 20px;
            color: #333;
        }

        .container-plist {
            max-width: 1200px;
            margin: 0 auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            padding: 32px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
        }

        .header h2 {
            font-size: 1.6rem;
            font-weight: 700;
            color: #1a1a2e;
        }

        .btn-add {
			background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn-add:hover {
            transform: scale(1.10);
        }

		.btn-add:active{
			transform: scale(0.95);
		}

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.95rem;
        }

        thead tr {
            background-color: #f8f9ff;
            border-bottom: 2px solid #e5e7eb;
        }

        thead th {
            padding: 14px 16px;
            text-align: left;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }

        tbody tr {
            border-bottom: 1px solid #f3f4f6;
            transition: background 0.15s ease;
        }

        tbody tr:hover {
            background-color: #fafafa;
        }

        tbody td {
            padding: 14px 16px;
            color: #374151;
            vertical-align: middle;
        }

        .product-id {
            font-weight: 600;
            color: #9ca3af;
            font-size: 0.85rem;
        }

        .product-name {
            font-weight: 600;
            color: #111827;
        }

        .product-price {
            font-weight: 600;
            color: #059669;
        }

        .product-desc {
            color: #6b7280;
            max-width: 250px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .product-create{
            color: #6b7280;
            max-width: 250px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .product-update{
            color: #6b7280;
            max-width: 250px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .btn-edit, .btn-delete {
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 0.82rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-edit {
            background-color: #eff6ff;
            color: #3b82f6;
            border: 1px solid #bfdbfe;
        }

        .btn-edit:hover {
            background-color: #3b82f6;
            color: white;
        }

        .btn-delete {
            background-color: #fef2f2;
            color: #ef4444;
            border: 1px solid #fecaca;
        }

        .btn-delete:hover {
            background-color: #ef4444;
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 48px 0;
            color: #9ca3af;
            font-size: 0.95rem;
        }

        .empty-state span {
            font-size: 2rem;
            display: block;
            margin-bottom: 12px;
        }
    </style>
</head>
<body>
<div class="container-plist">
    <div class="header">
        <h2>Product List</h2>
        <a href="database.php" class="btn-add">+ Add New Product</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Unit Price</th>
                <th>Description</th>
                <th>Created</th>
                <th>Updated</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        include('db.php');

        $sql    = "SELECT * FROM Products WHERE IsDeleted = 0";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id    = htmlspecialchars($row['ProductId']);
                $name  = htmlspecialchars($row['Name']);
                $price = htmlspecialchars($row['UnitPrice']);
                $desc  = htmlspecialchars($row['Description']);
                $create = htmlspecialchars($row['CreatedDate']);
                $update = htmlspecialchars($row['UpdatedDate']);
                echo "
                <tr>
                    <td class='product-id'>#{$id}</td>
                    <td class='product-name'>{$name}</td>
                    <td class='product-price'>\${$price}</td>
                    <td class='product-desc' title='{$desc}'>{$desc}</td>
                    <td class='product-create'>{$create}</td>
                    <td class='product-update'>{$update}</td>
                    <td>
                        <div class='actions'>
                            <a href='edit.php?id={$id}' class='btn-edit'>Edit</a>
                            <a href='delete.php?id={$id}' class='btn-delete'
                               onclick=\"return confirm('Delete this product?');\">Delete</a>
                        </div>
                    </td>
                </tr>";
            }
        } else {
            echo "
            <tr>
                <td colspan='5'>
                    <div class='empty-state'>
                        <span>📦</span>
                        No products found. Add your first one!
                    </div>
                </td>
            </tr>";
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
