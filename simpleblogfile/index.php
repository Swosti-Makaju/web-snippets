<?php
// Load existing posts
$filename = "blog_data.json";
$posts = file_exists($filename) ? json_decode(file_get_contents($filename), true) : [];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = htmlspecialchars($_POST['title']);
    $content = htmlspecialchars($_POST['content']);

    if (!empty($title) && !empty($content)) {
        $post = [
            "title" => $title,
            "content" => nl2br($content),
            "timestamp" => date("Y-m-d H:i:s")
        ];
        $posts[] = $post;
        file_put_contents($filename, json_encode($posts, JSON_PRETTY_PRINT));
        header("Location: #" . urlencode($title));
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="A simple PHP blog page">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple PHP Blog</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>📝 Simple Blog Page</h1>

    <form method="POST" class="blog-form">
        <input type="text" name="title" placeholder="Post Title" required>
        <textarea name="content" placeholder="Write your blog content..." rows="5" required></textarea>
        <button type="submit">Post</button>
    </form>

    <hr>

    <h2>📚 Blog Posts</h2>
    <ul class="post-links">
        <?php foreach ($posts as $post): ?>
            <li><a href="#<?= urlencode($post['title']) ?>"><?= htmlspecialchars($post['title']) ?></a></li>
        <?php endforeach; ?>
    </ul>

    <?php foreach ($posts as $post): ?>
        <div class="blog-post" id="<?= urlencode($post['title']) ?>">
            <meta name="post-title" content="<?= htmlspecialchars($post['title']) ?>">
            <h3><?= htmlspecialchars($post['title']) ?></h3>
            <small>Posted on: <?= $post['timestamp'] ?></small>
            <p><?= $post['content'] ?></p>
            <a href="#top">⬆️ Back to top</a>
        </div>
        <hr>
    <?php endforeach; ?>
</body>
</html>
