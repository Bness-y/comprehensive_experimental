<?php
session_start();

if(isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: panel.php');
    exit();
}

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '123456';
$db_name = 'blog_ctf';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}
$conn->set_charset("utf8");

$error_msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);
    
    if($result && $result->num_rows > 0) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        
        header('Location: panel.php');
        exit();
    } else {
        $error_msg = '用户名或密码错误！';
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理员登录 - 企业产品展示博客</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 350px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 3px;
        }
        .btn {
            background-color: #0066cc;
            color: #fff;
            border: none;
            padding: 10px 15px;
            width: 100%;
            cursor: pointer;
            border-radius: 3px;
        }
        .btn:hover {
            background-color: #0055b3;
        }
        .error {
            color: #ff0000;
            margin-bottom: 15px;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #0066cc;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>管理员登录</h1>
        
        <?php if($error_msg): ?>
        <div class="error"><?php echo htmlspecialchars($error_msg); ?></div>
        <?php endif; ?>
        
        <form method="post" action="">
            <div class="form-group">
                <label for="username">用户名</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">密码</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn">登录</button>
        </form>
        
        <a href="../index.php" class="back-link">返回首页</a>
    </div>
</body>
</html> 