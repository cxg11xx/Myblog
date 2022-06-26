<?php 

require './dist/mysql/public.php';
$db = database();

$rows = $db->order(['id' => 'asc']) -> select('article');

//获取文章分类的列表
$categories  = $db ->order(['id' => 'asc'])->select('article_category');
$article_category = [];
foreach($categories as $category){
    $article_categories[$category['id']] = $category;
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
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
                    <li><a href="index.php">文章分类 <span class="sr-only">(current)</span></a></li>
                    <li><a href="article_list.php">文章列表</a></li>


                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">前台 <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">前台</a></li>
                                <li><a href="#">退出</a></li>
                                
                            </ul>
                        </li>
                    </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
    <div class="container alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Warning!</strong> Better check yourself, you're not looking too good.
    </div>php
    <div class="container">
        <a href="article_add.php" class="btn btn-success" style="margin-bottom: 20px;">添加文章</a>
        <table class="table table-striped table-bordered">
            <tr>
                <th>文章id</th>
                <th>缩略图</th>
                <th>文章标题</th>
                <th>文章分类id</th>
                <th>文章发布时间</th>
                <th>操作</th>
            </tr>
            
            <?php foreach ($rows as $row) {
                ?> 
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['thumb']; ?></td>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $article_categories[$row['article_category_id']]['name']; ?></td>
                    <td><?php echo date('Y-m-d H:i:s',$row['create_time']) ?></td>
                    <td>
                        <a href="article_edit.php?id=<?php echo $row['id'] ?>" class="btn btn-primary">编辑</a>
                        <a href="article_delete.php?id=<?php echo $row['id'] ?>" class="btn btn-danger">删除</a>
                    </td>
                    
                </tr>
                <?php
            } 
           
           ?>


        </table>
    </div>

    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="dist/js/bootstrap.min.js"></script>
    <script src="dist/js/jquery.min.js"></script>
</body>
</html>