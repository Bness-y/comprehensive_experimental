<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

$output = '';

if (isset($_POST['ip'])) {
    $ip = $_POST['ip'];
    
    // 漏洞点：直接将用户输入拼接到命令中，没有过滤或转义
    if (stristr(php_uname('s'), 'windows')) {
        // Windows系统
        $command = "ping " . $ip;
    } else {
        // Linux系统
        $command = "ping -c 4 " . $ip;
    }
    
    $result = shell_exec($command);
    if ($result !== null) {
        $output = $result;
    } else {
        $output = "命令执行失败或无返回结果";
    }
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理面板 - 企业产品展示博客</title>
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
            border-radius: 5px;
        }
        .dashboard {
            display: grid;
            grid-template-columns: 250px 1fr;
            gap: 20px;
        }
        .sidebar {
            background-color: #f4f4f4;
            padding: 20px;
            border-radius: 5px;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        .sidebar ul li {
            margin-bottom: 10px;
        }
        .sidebar ul li a {
            display: block;
            padding: 10px;
            background-color: #e0e0e0;
            color: #333;
            text-decoration: none;
            border-radius: 3px;
        }
        .sidebar ul li a:hover {
            background-color: #d0d0d0;
        }
        .main-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }
        .network-tool form {
            margin-bottom: 20px;
        }
        .network-tool input[type="text"] {
            padding: 8px;
            width: 300px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }
        .network-tool button {
            padding: 8px 15px;
            background-color: #0066cc;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        .network-tool button:hover {
            background-color: #0055b3;
        }
        .output {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 3px;
            white-space: pre-wrap;
            font-family: monospace;
            max-height: 400px;
            overflow-y: auto;
        }
        .logout {
            text-align: right;
        }
        .logout a {
            color: #0066cc;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <header>
        <div class="logout">
            <a href="logout.php">退出登录</a>
        </div>
        <h1>管理面板</h1>
        <p>欢迎回来，<?php echo htmlspecialchars($_SESSION['admin_username']); ?>！</p>
    </header>

    <div class="dashboard">
        <div class="sidebar">
            <h3>管理菜单</h3>
            <ul>
                <li><a href="#dashboard">仪表盘</a></li>
                <li><a href="#articles">文章管理</a></li>
                <li><a href="#users">用户管理</a></li>
                <li><a href="#network-tool">网络诊断</a></li>
                <li><a href="#settings">系统设置</a></li>
            </ul>
        </div>

        <div class="main-content">
            <h2 id="network-tool">网络诊断工具</h2>
            <p>使用此工具可以测试服务器与指定IP地址的连通性。</p>
            
            <div class="network-tool">
                <form method="post">
                    <label for="ip">输入IP地址或域名：</label><br>
                    <input type="text" id="ip" name="ip" placeholder="例如：8.8.8.8 或 example.com" required><br><br>
                    <button type="submit">开始测试</button>
                </form>

                <?php if (isset($_POST['ip'])): ?>
                <h3>测试结果：</h3>
                <div class="output"><?php echo "{$output}" ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html> 