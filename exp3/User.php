<?php
if (!class_exists('UserInfo')) {
    class UserInfo {
        public $username;
        public $command; // 这个属性将是注入点
        public $bgcolor; // 背景色属性
        
        function __construct() {
            $this->username = 'guest';
            $this->command = 'echo "欢迎回来，" . $this->username . "！";';
            $this->bgcolor = 'User.php';
        }
        
        function __destruct() {
            // 漏洞点：当对象销毁时，会执行这里的代码
            if (isset($this->command)) {
                echo "<strong>系统消息:</strong> ";
                // 危险函数，执行任意PHP代码
                eval($this->command);
            }
        }
    }
}
?> 