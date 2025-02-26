<?php
require_once 'db.php';
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT g.*, c.name as category_name 
                      FROM guidelines g 
                      LEFT JOIN categories c ON g.category_id = c.id 
                      WHERE g.id = ?");
$stmt->execute([$id]);
$guideline = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($guideline['title']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="assets/custom.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto p-4 md:p-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4"><?php echo htmlspecialchars($guideline['title']); ?></h1>
        <p class="text-sm text-gray-600 mb-6">Category: <?php echo $guideline['category_name'] ?? 'Uncategorized'; ?></p>
        <div class="bg-white p-6 rounded-lg shadow-md prose max-w-none">
            <?php echo $guideline['content']; ?>
        </div>
        <a href="index.php" class="mt-6 inline-block bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">Back</a>
    </div>
</body>
</html>
