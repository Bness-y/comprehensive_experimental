<?php
session_start();
$login_error = false;

if (isset($_POST['username']) && isset($_POST['password'])) {
    if ($_POST['username'] === 'admin' && $_POST['password'] === 'admin123') {
        $_SESSION['loggedin'] = true;
    } else {
        $login_error = true;
    }
}

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
?>
<!DOCTYPE html>
<html>
<head>
    <title>管理员登录 - 记事本系统</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/5.2.3/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Microsoft YaHei', sans-serif;
            padding-top: 20px;
        }
        .container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 30px;
            margin-top: 50px;
            max-width: 500px;
        }
        h1 {
            color: #343a40;
            margin-bottom: 30px;
            text-align: center;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .btn-primary {
            width: 100%;
            margin-top: 10px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #6c757d;
            font-size: 0.9em;
        }
        .alert {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>管理员登录</h1>
        
        <?php if ($login_error): ?>
        <div class="alert alert-danger" role="alert">
            用户名或密码错误，请重试！
        </div>
        <?php endif; ?>
        
        <form method="post">
            <div class="form-group">
                <label for="username">用户名:</label>
                <input type="text" name="username" id="username" class="form-control">
            </div>
            <div class="form-group">
                <label for="password">密码:</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">登录</button>
        </form>
        <div class="footer">
            <p>记事本系统 &copy; 2025</p>
        </div>
    </div>
    <script src="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/5.2.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
    die();
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>管理员上传面板 - 记事本系统</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/5.2.3/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Microsoft YaHei', sans-serif;
            padding-top: 20px;
        }
        .container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 30px;
            margin-top: 20px;
        }
        h1 {
            color: #343a40;
            margin-bottom: 20px;
        }
        .upload-form {
            margin-top: 30px;
        }
        .status-message {
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #6c757d;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>管理员上传面板</h1>
        
        <?php
        if (isset($_FILES['uploaded_file'])) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["uploaded_file"]["name"]);
            
            // 漏洞点：只检查了MIME类型，很容易伪造
            if ($_FILES['uploaded_file']['type'] === 'image/jpeg') {
                if (move_uploaded_file($_FILES["uploaded_file"]["tmp_name"], $target_file)) {
                    echo '<div class="status-message success">文件上传成功: ' . htmlspecialchars($target_file) . '</div>';
                } else {
                    echo '<div class="status-message error">上传失败！</div>';
                }
            } else {
                echo '<div class="status-message error">错误：只允许上传JPG图片！</div>';
            }
        }
        ?>
        
        <div class="upload-form">
            <div class="card">
                <div class="card-header">
                    请选择要上传的文件
                </div>
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="uploaded_file">文件选择:</label>
                            <input type="file" name="uploaded_file" id="uploaded_file" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">上传文件</button>
                    </form>
                </div>
            </div>
        </div>
        
        <p class="mt-4"><a href="index.php" class="btn btn-outline-secondary">返回首页</a></p>
        
        <div class="footer">
            <p>记事本系统 &copy; 2025</p>
        </div>
    </div>
    <script src="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/5.2.3/js/bootstrap.bundle.min.js"></script>
</body>
</html> 