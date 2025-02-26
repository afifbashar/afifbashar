<?php
require_once 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category_id = $_POST['category_id'] ?: null;
    
    $stmt = $pdo->prepare("INSERT INTO guidelines (title, content, category_id) VALUES (?, ?, ?)");
    $stmt->execute([$title, $content, $category_id]);
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Guideline</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="assets/custom.css" rel="stylesheet">
    <script src="assets/tinymce/tinymce.min.js"></script>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto p-4 md:p-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">Add New Guideline</h1>
        <form method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Title</label>
                <input type="text" name="title" class="w-full border p-2 rounded-lg focus:ring-2 focus:ring-blue-300 outline-none" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Category</label>
                <select name="category_id" class="w-full border p-2 rounded-lg focus:ring-2 focus:ring-blue-300 outline-none">
                    <option value="">Select Category</option>
                    <?php
                    $stmt = $pdo->query("SELECT * FROM categories");
                    while ($cat = $stmt->fetch()) {
                        echo "<option value='{$cat['id']}'>{$cat['name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Content</label>
                <textarea name="content" id="editor" class="w-full border rounded-lg"></textarea>
            </div>
            <div class="flex gap-4">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Save</button>
                <a href="index.php" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">Cancel</a>
            </div>
        </form>
    </div>

    <script>
    tinymce.init({
        selector: '#editor',
        plugins: 'image table link lists code',
        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist | image table link | code',
        images_upload_url: 'upload.php',
        images_upload_base_path: '/uploads',
        height: 400,
        mobile: {
            theme: 'mobile',
            toolbar: ['undo', 'redo', 'bold', 'italic', 'image']
        }
    });
    </script>
</body>
</html>
