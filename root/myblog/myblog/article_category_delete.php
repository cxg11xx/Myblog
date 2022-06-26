<?php 
    require './dist/mysql/public.php';
    $db = database();

    //删除指定的分类记录
    $id = $_GET['id'];

    $db->where(['id' => $id]) -> delete('article_category');

    //跳转
    header('Location:index.php');
    exit;

?>