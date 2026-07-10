<?php
require_once __DIR__ . '/../includes/config.php';
requireLogin();

$id = $_GET['id'] ?? null;
$post = null;
if ($id) { $stmt = $pdo->prepare("SELECT * FROM blog_posts WHERE id = ?"); $stmt->execute([$id]); $post = $stmt->fetch(); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'title' => trim($_POST['title']),
        'slug' => slugify($_POST['title']),
        'content' => $_POST['content'],
        'excerpt' => trim($_POST['excerpt']),
        'status' => $_POST['status'],
        'meta_title' => trim($_POST['meta_title']),
        'meta_description' => trim($_POST['meta_description']),
        'author_id' => $_SESSION['admin_id'],
        'published_at' => $_POST['status'] === 'published' ? date('Y-m-d H:i:s') : null,
    ];
    if ($id) {
        $fields = implode(', ', array_map(fn($k) => "$k = ?", array_keys($data)));
        $pdo->prepare("UPDATE blog_posts SET $fields WHERE id = ?")->execute([...array_values($data), $id]);
    } else {
        $fields = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $pdo->prepare("INSERT INTO blog_posts ($fields) VALUES ($placeholders)")->execute(array_values($data));
    }
    header('Location: blog.php'); exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $id ? 'Edit' : 'New' ?> Blog Post | Marine Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/admin.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css">
</head>
<body>
    <?php include __DIR__ . '/includes/sidebar.php'; ?>
    <div class="admin-main">
        <?php include __DIR__ . '/includes/topbar.php'; ?>
        <div class="admin-content">
            <h1 class="page-title"><?= $id ? 'Edit' : 'New' ?> Blog Post</h1>
            <form method="POST">
                <div style="display:grid;grid-template-columns:2fr 1fr;gap:25px;">
                    <div>
                        <div class="admin-card"><div class="card-body">
                            <div class="form-group"><label>Title</label><input type="text" name="title" required value="<?= sanitize($post['title'] ?? '') ?>"></div>
                            <div class="form-group"><label>Excerpt</label><textarea name="excerpt" rows="2"><?= sanitize($post['excerpt'] ?? '') ?></textarea></div>
                            <div class="form-group"><label>Content</label>
                                <div id="editor" style="min-height:300px;"><?= $post['content'] ?? '' ?></div>
                                <input type="hidden" name="content" id="contentField">
                            </div>
                        </div></div>
                    </div>
                    <div>
                        <div class="admin-card"><div class="card-body">
                            <div class="form-group"><label>Status</label>
                                <select name="status">
                                    <option value="draft" <?= ($post['status'] ?? '') === 'draft' ? 'selected' : '' ?>>Draft</option>
                                    <option value="published" <?= ($post['status'] ?? '') === 'published' ? 'selected' : '' ?>>Published</option>
                                </select>
                            </div>
                            <div class="form-group"><label>Meta Title</label><input type="text" name="meta_title" value="<?= sanitize($post['meta_title'] ?? '') ?>"></div>
                            <div class="form-group"><label>Meta Description</label><textarea name="meta_description" rows="2"><?= sanitize($post['meta_description'] ?? '') ?></textarea></div>
                            <button type="submit" class="btn btn-primary" style="width:100%;"><i class="fas fa-save"></i> Save Post</button>
                        </div></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <script>
    const quill = new Quill('#editor', { theme: 'snow', modules: { toolbar: [[{'header':[1,2,3,false]}],['bold','italic','underline'],[{'list':'ordered'},{'list':'bullet'}],['link','image'],['clean']] } });
    document.querySelector('form').addEventListener('submit', function() { document.getElementById('contentField').value = quill.root.innerHTML; });
    </script>
    <script src="<?= SITE_URL ?>/assets/js/admin.js"></script>
</body>
</html>
