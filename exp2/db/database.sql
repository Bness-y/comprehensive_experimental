-- 创建数据库
CREATE DATABASE IF NOT EXISTS blog_ctf;
USE blog_ctf;

-- 创建users表
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username TEXT NOT NULL,
    password TEXT NOT NULL
);

-- 创建articles表
CREATE TABLE IF NOT EXISTS articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title TEXT NOT NULL,
    content TEXT NOT NULL
);

-- 插入管理员账号，密码为123456的MD5值
INSERT INTO users (username, password) VALUES ('admin', 'CjvS%z3e^N5');

-- 插入一些示例文章
INSERT INTO articles (title, content) VALUES 
('公司简介', '我们是一家领先的科技创新公司，专注于为客户提供最前沿的技术解决方案。成立于2010年，公司已经发展成为行业内的知名品牌。'),
('产品展示：智能家居系统', '我们的智能家居系统采用最先进的物联网技术，让您可以通过手机随时控制家中的各种设备，包括灯光、空调、安防系统等。'),
('产品展示：云服务平台', '我们的云服务平台为企业提供高效、安全的数据存储和计算服务。具有弹性扩展、故障自愈等特性。'),
('技术分享：人工智能在企业中的应用', '人工智能技术正在改变企业的运营方式。本文将探讨AI如何帮助企业提升效率、降低成本并创造新的商业机会。'),
('联系我们', '地址：科技园区创新大厦B座5层<br>电话：010-12345678<br>邮箱：contact@example.com'); 