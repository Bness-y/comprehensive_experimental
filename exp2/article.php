<?php
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '123456';
$db_name = 'blog_ctf';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}
$conn->set_charset("utf8");

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // 漏洞点：直接拼接用户输入到SQL查询中，导致SQL注入
    $sql = "SELECT title, content FROM articles WHERE id = $id";
    $result = $conn->query($sql);
    
    if($result && $result->num_rows > 0) {
        $article = $result->fetch_assoc();
    } else {
        $article = null;
    }
} else {
    $article = null;
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $article ? htmlspecialchars($article['title']) : '文章未找到'; ?> - 企业产品展示博客</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        header {
            background-color: #f4f4f4;
            padding: 20px;
            margin-bottom: 20px;
            text-align: center;
        }
        article {
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #0066cc;
            text-decoration: none;
        }
        footer {
            margin-top: 30px;
            text-align: center;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
<body>
    <header>
        <h1>企业产品展示博客</h1>
        <p>欢迎访问我们的企业博客，了解更多产品信息</p>
    </header>

    <a href="index.php" class="back-link">← 返回首页</a>

    <main>
        <?php if($article): ?>
        <article>
            <h2><?php echo htmlspecialchars($article['title']); ?></h2>
            <div class="content">
                <?php echo nl2br(htmlspecialchars($article['content'])); ?>
            </div>
        </article>
        <?php else: ?>
        <div class="error-message">
            <h2>文章未找到</h2>
            <p>抱歉，您请求的文章不存在或已被删除。</p>
        </div>
        <?php endif; ?>
    </main>

    <footer>
        <p>版权所有 &copy; 2025 企业产品展示博客</p>
        <p><a href="admin/login.php">管理员登录</a></p>
    </footer>
</body>
</html>

<?php $conn->close(); ?> 