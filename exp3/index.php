<?php
require_once 'User.php';

$user_info = null;
$xxe_content = "";

// 漏洞点1：处理Cookie中的序列化对象
if (isset($_COOKIE['user_pref'])) {
    try {
        // base64解码并反序列化
        $user_info = unserialize(base64_decode($_COOKIE['user_pref']));
        
        // 添加bgcolor属性检查
        if (!isset($user_info->bgcolor)) {
            $user_info->bgcolor = "#ffffff";
        }
    } catch (Exception $e) {
        // 显示一条有用的错误信息
        echo "<!-- DEBUG: 无法加载用户偏好设置，请检查User.php是否存在 -->";
        $user_info = new UserInfo();
    }
} else {
    // 如果没有cookie，创建一个默认对象并设置它
    $user_info = new UserInfo();
    setcookie('user_pref', base64_encode(serialize($user_info)));
}

// 处理XML主题导入功能
$xml_result = '';
$xml_error = '';

// 漏洞点2：XXE漏洞
if (isset($_POST['import_theme'])) {
    $xml_string = $_POST['theme_xml'];
    
    // 创建一个新的XML解析器，不进行安全设置
    $dom = new DOMDocument();
    
    // 禁用实体加载限制 - 这是XXE漏洞的关键
    $prev = libxml_disable_entity_loader(false);
    
    // 错误处理
    $use_errors = libxml_use_internal_errors(true);
    
    try {
        // 解析XML，允许外部实体 - 这里存在XXE漏洞
        $dom->loadXML($xml_string, LIBXML_NOENT);
        
        // 提取主题信息
        $theme_nodes = $dom->getElementsByTagName('theme');
        if ($theme_nodes->length > 0) {
            $theme = $theme_nodes->item(0);
            
            // 获取XXE可能读取到的内容
            $name_nodes = $theme->getElementsByTagName('name');
            if ($name_nodes->length > 0) {
                $xxe_content = $name_nodes->item(0)->nodeValue;
            }
            
            $bgcolor_nodes = $theme->getElementsByTagName('bgcolor');
            if ($bgcolor_nodes->length > 0) {
                $user_info->bgcolor = $bgcolor_nodes->item(0)->nodeValue;
                setcookie('user_pref', base64_encode(serialize($user_info)));
                $xml_result = "主题已成功导入！";
            }
        }
    } catch (Exception $e) {
        $xml_error = "XML解析错误：" . $e->getMessage();
    }
    
    // 恢复设置
    libxml_disable_entity_loader($prev);
    libxml_use_internal_errors($use_errors);
}

// 开始输出缓冲，以便捕获User.php中__destruct()方法产生的输出
ob_start();

// 输出HTML
echo "<!DOCTYPE html>
<html>
<head>
    <title>个性化设置网站</title>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2980b9;
            --success-color: #2ecc71;
            --error-color: #e74c3c;
            --bg-color: " . htmlspecialchars($user_info->bgcolor) . ";
            --text-color: #333;
            --border-color: #ddd;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            background-color: var(--bg-color);
            color: var(--text-color);
            padding: 20px;
            transition: background-color 0.3s ease;
        }
        
        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            max-width: 900px;
            margin: 20px auto;
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        header {
            margin-bottom: 30px;
            border-bottom: 2px solid var(--border-color);
            padding-bottom: 15px;
            text-align: center;
        }
        
        h1 {
            color: var(--primary-color);
            margin-bottom: 10px;
        }
        
        h2 {
            color: var(--secondary-color);
            margin: 25px 0 15px;
            border-left: 4px solid var(--primary-color);
            padding-left: 10px;
        }
        
        .theme-form {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 6px;
            border: 1px solid var(--border-color);
            margin-top: 20px;
        }
        
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-family: monospace;
            resize: vertical;
            min-height: 200px;
            margin: 10px 0;
        }
        
        .button {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 12px 24px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            font-weight: 500;
            margin: 10px 0;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        
        .button:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .success {
            color: var(--success-color);
            font-weight: bold;
            padding: 10px;
            background-color: rgba(46, 204, 113, 0.1);
            border-radius: 4px;
            margin: 10px 0;
        }
        
        .error {
            color: var(--error-color);
            font-weight: bold;
            padding: 10px;
            background-color: rgba(231, 76, 60, 0.1);
            border-radius: 4px;
            margin: 10px 0;
        }
        
        .xxe-output {
            background-color: #f8f8f8;
            border: 1px solid #ddd;
            padding: 15px;
            margin: 15px 0;
            overflow-wrap: break-word;
            white-space: pre-wrap;
            max-height: 400px;
            overflow-y: auto;
            border-radius: 4px;
            box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .user-action {
            background-color: rgba(52, 152, 219, 0.05);
            border-left: 4px solid var(--primary-color);
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
            font-style: italic;
            color: #555;
            animation: fadeIn 0.5s ease-in;
        }
        
        .notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            max-width: 300px;
            padding: 15px;
            background: #fff;
            border-radius: 6px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            border-left: 4px solid var(--primary-color);
            animation: slideIn 0.3s ease-out;
        }
        
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        nav {
            margin-top: 30px;
            text-align: center;
        }
        
        nav a {
            color: var(--primary-color);
            text-decoration: none;
            margin: 0 10px;
            font-weight: 500;
        }
        
        nav a:hover {
            text-decoration: underline;
        }
        
        footer {
            text-align: center;
            margin-top: 30px;
            color: #777;
            font-size: 14px;
        }
    </style>
</head>
<body>
<div class='container'>
    <header>
        <h1>个性化主题设置中心</h1>
        <p>你好, <span id='username'>" . htmlspecialchars($user_info->username) . "</span>! 欢迎使用主题定制功能</p>
    </header>
    
    <!-- 用户偏好设置由 User.php 中的 UserInfo 类管理 -->
    
    <h2>导入自定义主题</h2>
    <p>您可以通过导入XML格式的主题文件来自定义网站外观。</p>
    
    <div class='theme-form'>
        <form method='post' action=''>
            <label for='theme_xml'>XML主题配置:</label>
            <textarea id='theme_xml' name='theme_xml' rows='10' cols='60'><?xml version=\"1.0\" encoding=\"UTF-8\"?>
<theme>
    <name>默认主题</name>
    <bgcolor>#ffffff</bgcolor>
    <description>这是默认的白色主题</description>
</theme></textarea>
            <div>
                <input type='submit' name='import_theme' value='导入主题' class='button'>
            </div>
        </form>";

// 显示结果信息
if (!empty($xml_result)) {
    echo "<p class='success'>" . htmlspecialchars($xml_result) . "</p>";
}

if (!empty($xml_error)) {
    echo "<p class='error'>" . htmlspecialchars($xml_error) . "</p>";
}

// 显示XXE读取的内容 - 这是关键部分
if (!empty($xxe_content)) {
    echo "<div class='xxe-output'>
            <h3>主题名称内容：</h3>
            " . htmlspecialchars($xxe_content) . "
          </div>";
}

// 将缓冲区的内容保存到变量，然后清空缓冲区
$main_content = ob_get_clean();

// 现在启动另一个输出缓冲区来捕获__destruct()方法执行时的输出
ob_start();
// 当PHP脚本执行结束，所有对象会被销毁，触发__destruct()
// 我们手动结束脚本，以便捕获到__destruct()的输出
$user_info = null;
// 调用垃圾收集器确保对象被销毁
gc_collect_cycles();
// 获取__destruct()方法的输出
$destruct_output = ob_get_clean();

// 如果有__destruct()输出，将其添加到一个特殊的通知区域
if (!empty($destruct_output)) {
    // 将输出注入到主内容的最后一个</div>标签前
    $main_content = preg_replace('/(.*)<\/div>$/s', '$1<div class="user-action">' . $destruct_output . '</div></div>', $main_content);
}

// 输出修改后的主内容
echo $main_content;

echo "</div>

    <nav>
        <a href='help.php'>帮助文档</a>
    </nav>
    
    <footer>
        <p>© 2025 个性化主题设置 | CTF练习题目</p>
    </footer>
</div>";
?> 