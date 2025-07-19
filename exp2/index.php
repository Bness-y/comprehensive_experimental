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

$sql = "SELECT id, title FROM articles";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>企业产品展示博客</title>
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
        .article-list {
            list-style: none;
            padding: 0;
        }
        .article-item {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .article-item a {
            color: #333;
            text-decoration: none;
            font-size: 18px;
        }
        .article-item a:hover {
            color: #0066cc;
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

    <main>
        <h2>文章列表</h2>
        <ul class="article-list">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<li class="article-item">';
                    echo '<a href="article.php?id=' . $row["id"] . '">' . htmlspecialchars($row["title"]) . '</a>';
                    echo '</li>';
                }
            } else {
                echo '<p>暂无文章</p>';
            }
            ?>
        </ul>
    </main>

    <footer>
        <p>版权所有 &copy; 2025 企业产品展示博客</p>
        <p><a href="admin/login.php">管理员登录</a></p>
    </footer>
</body>
</html>

<?php $conn->close(); ?> 