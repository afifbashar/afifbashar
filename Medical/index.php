<?php require_once 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Guidelines</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="assets/custom.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen font-sans">
    <header class="sticky top-0 bg-white shadow-md z-10">
        <div class="container mx-auto p-4">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Medical Guidelines</h1>
        </div>
    </header>

    <main class="container mx-auto p-4 md:p-6">
        <!-- Search and Filter -->
        <div class="flex flex-col md:flex-row gap-4 mb-6 bg-white p-4 rounded-lg shadow">
            <input type="text" id="search" class="border p-2 rounded-lg flex-1 focus:ring-2 focus:ring-blue-300 outline-none" placeholder="Search guidelines...">
            <select id="category" class="border p-2 rounded-lg focus:ring-2 focus:ring-blue-300 outline-none">
                <option value="">All Categories</option>
                <?php
                $stmt = $pdo->query("SELECT * FROM categories");
                while ($cat = $stmt->fetch()) {
                    echo "<option value='{$cat['id']}'>{$cat['name']}</option>";
                }
                ?>
            </select>
            <div class="flex gap-2">
                <a href="add.php" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Add Guideline</a>
                <a href="categories.php" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Categories</a>
            </div>
        </div>

        <!-- Guidelines List -->
        <div id="guidelines" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            $stmt = $pdo->query("SELECT g.*, c.name as category_name 
                               FROM guidelines g 
                               LEFT JOIN categories c ON g.category_id = c.id 
                               ORDER BY g.created_at DESC");
            while ($row = $stmt->fetch()) {
                echo "<div class='bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow'>";
                echo "<h2 class='text-lg font-semibold text-gray-800 truncate'>{$row['title']}</h2>";
                echo "<p class='text-sm text-gray-600 mt-1'>Category: " . ($row['category_name'] ?? 'Uncategorized') . "</p>";
                echo "<div class='mt-3 flex gap-3 text-sm'>";
                echo "<a href='view.php?id={$row['id']}' class='text-blue-600 hover:text-blue-800'>View</a>";
                echo "<a href='edit.php?id={$row['id']}' class='text-yellow-600 hover:text-yellow-800'>Edit</a>";
                echo "<a href='delete.php?id={$row['id']}' class='text-red-600 hover:text-red-800' onclick='return confirm(\"Are you sure?\")'>Delete</a>";
                echo "</div></div>";
            }
            ?>
        </div>
    </main>

    <script>
    document.getElementById('search').addEventListener('keyup', filterGuidelines);
    document.getElementById('category').addEventListener('change', filterGuidelines);

    function filterGuidelines() {
        const search = document.getElementById('search').value.toLowerCase();
        const category = document.getElementById('category').value;
        const guidelines = document.querySelectorAll('#guidelines > div');

        guidelines.forEach(guide => {
            const title = guide.querySelector('h2').textContent.toLowerCase();
            const cat = guide.querySelector('p').textContent.toLowerCase();
            
            const matchesSearch = title.includes(search);
            const matchesCategory = !category || cat.includes(category.toLowerCase());
            
            guide.style.display = (matchesSearch && matchesCategory) ? '' : 'none';
        });
    }
    </script>
</body>
</html>
