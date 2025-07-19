<!DOCTYPE html>
<html>
<head>
    <title>帮助中心 - 个性化设置</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2980b9;
            --accent-color: #e74c3c;
            --bg-color: #f5f5f5;
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
        
        h2 {
            color: var(--primary-color);
            margin-bottom: 20px;
        }
        
        h3 {
            color: var(--secondary-color);
            margin: 25px 0 15px;
            border-left: 4px solid var(--primary-color);
            padding-left: 10px;
        }
        
        p {
            margin-bottom: 15px;
        }
        
        ul {
            margin: 15px 0;
            padding-left: 20px;
        }
        
        li {
            margin-bottom: 8px;
        }
        
        pre {
            background-color: #f0f0f0;
            padding: 15px;
            border-radius: 6px;
            overflow: auto;
            margin: 15px 0;
            border: 1px solid var(--border-color);
            box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);
            font-family: 'Consolas', 'Courier New', monospace;
        }
        
        .dev-section {
            margin-top: 30px;
            padding: 20px;
            border: 1px solid var(--border-color);
            background-color: #f9f9f9;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        
        .nav-links {
            margin-top: 40px;
            text-align: center;
            padding: 15px 0;
            border-top: 1px solid var(--border-color);
        }
        
        .nav-links a {
            display: inline-block;
            color: var(--primary-color);
            text-decoration: none;
            padding: 8px 16px;
            margin: 0 10px;
            border-radius: 4px;
            transition: all 0.3s;
            font-weight: 500;
        }
        
        .nav-links a:hover {
            background-color: rgba(52, 152, 219, 0.1);
            transform: translateY(-2px);
        }
        
        .note {
            background-color: rgba(52, 152, 219, 0.1);
            border-left: 4px solid var(--primary-color);
            padding: 15px;
            margin: 15px 0;
            border-radius: 4px;
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
<div class="container">
    <header>
        <h2>帮助中心</h2>
        <p>个性化主题设置使用说明</p>
    </header>
    
    <p>欢迎使用个性化主题设置系统。您可以通过以下方式自定义您的用户体验：</p>
    <ul>
        <li><strong>更改用户名显示</strong> - 定制您的身份标识</li>
        <li><strong>自定义背景颜色</strong> - 让界面符合您的视觉偏好</li>
        <li><strong>设置个人偏好</strong> - 根据您的需求调整系统行为</li>
    </ul>

    <h3>如何导入主题</h3>
    <p>您可以使用XML格式导入自定义主题。标准的主题XML格式如下：</p>
    <pre>&lt;?xml version="1.0" encoding="UTF-8"?&gt;
&lt;theme&gt;
    &lt;name&gt;我的主题&lt;/name&gt;
    &lt;bgcolor&gt;#f0f0f0&lt;/bgcolor&gt;
    &lt;description&gt;主题描述&lt;/description&gt;
&lt;/theme&gt;</pre>

    <div class="note">
        <p><strong>提示：</strong> 您可以使用任何有效的颜色代码作为背景色，例如 #ff0000（红色）、#00ff00（绿色）或 #0000ff（蓝色）。</p>
    </div>


    <p>如有任何问题，请联系管理员获取更多帮助。</p>

    <div class="dev-section">
        <h3>开发者区域</h3>
        <p><strong>待办事项：</strong></p>
        <ul>
            <li>修复Cookie中的安全问题</li>
            <li>改进用户偏好设置的存储方式</li>
            <li>检查XML解析器的配置</li>
            <li>禁用外部实体引用功能</li>
        </ul>
        <p><strong>调试笔记：</strong> XML解析器支持DTD，需要在后续版本中禁用ENTITY加载。</p>
    </div>

    <div class="nav-links">
        <a href="index.php">返回首页</a>
    </div>
    
    <footer>
        <p>© 2025 个性化主题设置 | CTF练习题目</p>
    </footer>
</div>
</body>
</html> 