<?php 
    require './dist/mysql/public.php';
    $db = database();

    //删除指定的分类记录
    $id = $_GET['id'];

    $db->where(['id' => $id]) -> delete('article');

    //跳转
    header('Location:article_list.php');
    exit;

?>