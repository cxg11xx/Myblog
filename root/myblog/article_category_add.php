<?php 

// 判断是否提交了数据
// 如果提交了数据，连接数据库，将数据保存下来，写入到数据库
if($_POST) {
    $data = [
        'name' => $_POST['name'],
        'engname' => $_POST['engname'],

    ];

// 引入数据库操作类
require './dist/mysql/public.php';
$db = database();

// 插入数据
$result = $db->insert('article_category',$data);
// 跳转 
header('Location:article_category.php');
exit;
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="dist/css/bootstrap.css">
</head>

<style>
    .navbar {
        background-color: black;
    }
    
    .navbar-right {
        position: absolute;
        right: 0;
    }
</style>

<body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
                <a class="navbar-brand" href="#">Brand</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="article_category.php">文章分类 <span class="sr-only">(current)</span></a></li>
                    <li><a href="article_list.php">文章列表</a></li>


                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="index.php">前台</a></li>  
                    </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <div class="container">
        <form action="" method="post">
            <div class="form-group">
                <label for="name">文章分类名称</label>
                <input type="text" name="name" class="form-control" id="exampleInputEmail1" value="" placeholder="文章分类名称">
            </div>
            <div class="form-group">
                <label for="engname">文章分类英文名称</label>
                <input type="text" name="engname" class="form-control" id="exampleInputEmail1" value="" placeholder="文章分类英文名称">
            </div>

            <button type="submit" class="btn btn-primary">添加</button>
        </form>
    </div>

    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="dist/js/bootstrap.min.js"></script>
    <script src="dist/js/button.js"></script>
    <script src="jquery.min.js"></script>
</body>

</html>