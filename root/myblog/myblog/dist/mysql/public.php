<?php 
    function database(){
        require_once('./dist/mysql/mysql.class.php');
        $configArr=array(
            'host' => 'localhost',
            'port' => '3307',
            'user' => 'root',
            'passwd' => 'usbw',
            'dbname' => 'blog02',

        );
        return $mysql = new MMysql($configArr);
    }
?>