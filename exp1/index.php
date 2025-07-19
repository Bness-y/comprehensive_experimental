<?php
    if (isset($_GET['page'])) {
        $file = $_GET['page'];
        $file = explode('?', $file)[0];
        if ($file == 'index.php' || $file == basename(__FILE__)) {
            highlight_file(__FILE__);
            exit;
        }
        include($file);
    } else {
?>
<!DOCTYPE html>
<html>
<head>
    <title>记事本系统 - 首页</title>
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
        .nav-links {
            margin: 20px 0;
        }
        .nav-links a {
            margin-right: 15px;
            text-decoration: none;
            color: #007bff;
            font-weight: 500;
            transition: color 0.3s;
        }
        .nav-links a:hover {
            color: #0056b3;
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
        <h1>欢迎来到我们的记事本！</h1>
        <div class="nav-links">
            <a href="?page=help.html" class="btn btn-outline-primary">帮助</a>
            <a href="?page=about.html" class="btn btn-outline-info">关于</a>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">记事本功能</h5>
                        <p class="card-text">这是一个简单的记事本系统，可以帮助您记录和管理信息。</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer">
            <p>记事本系统 &copy; 2025</p>
        </div>
    </div>
    <script src="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/5.2.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
    }

    /*
     * TODO: 管理员上传功能开发完成后需要删除此入口
     * 入口: upload.php
    */
?> 