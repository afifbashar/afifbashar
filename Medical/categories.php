<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
    $name = $_POST['name'];
    $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (?)");
    $stmt->execute([$name]);
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->execute([$id]);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="assets/custom.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto p-4 md:p-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">Manage Categories</h1>
        
        <!-- Add Category -->
        <form method="POST" class="mb-6 bg-white p-4 rounded-lg shadow-md">
            <div class="flex flex-col sm:flex-row gap-4">
                <input type="text" name="name" class="border p-2 rounded-lg flex-1 focus:ring-2 focus:ring-blue-300 outline-none" placeholder="New category name" required>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Add</button>
            </div>
        </form>

        <!-- Categories List -->
        <div class="bg-white p-4 rounded-lg shadow-md">
            <?php
            $stmt = $pdo->query("SELECT * FROM categories ORDER BY name");
            while ($cat = $stmt->fetch()) {
                echo "<div class='flex justify-between items-center py-3 border-b last:border-b-0'>";
                echo "<span class='text-gray-800'>{$cat['name']}</span>";
                echo "<a href='?delete={$cat['id']}' class='text-red-600 hover:text-red-800' onclick='return confirm(\"Are you sure?\")'>Delete</a>";
                echo "</div>";
            }
            ?>
        </div>
        <a href="index.php" class="mt-6 inline-block bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">Back</a>
    </div>
</body>
</html>
