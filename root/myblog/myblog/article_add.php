<?php 

require './dist/mysql/public.php';
$db = database();

// 获取文章分类的列表
$article_categories = $db -> order(['id' => 'asc'])->select('article_category');

if($_POST){
    $data = [
        'title' => $_POST['title'],
        'thumb' => $_POST['thumb'],
        'content' => $_POST['content'],
        'article_category_id' => $_POST['article_category_id'],
        'create_time' => time()
    ];
    
    $result = $db -> insert('article',$data);

//跳转
header('Location:article_list.php');
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
                    <li><a href="index.php">文章分类 <span class="sr-only">(current)</span></a></li>
                    <li><a href="article_list.php">文章列表</a></li>


                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#">Link</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">退出 <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something else here</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="#">Separated link</a></li>
                            </ul>
                        </li>
                    </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <div class="container">
        <form action="" method="post">
            <div class="form-group">
                <label for="name">文章标题</label>
                <input type="text" name="title" class="form-control" id="exampleInputEmail1" value="" placeholder="文章标题">
            </div>
            <div class="form-group">
                <label for="article_category_id">文章分类</label>
                <select name="article_category_id" class="form-control" id="">
                    <option value="">请选择</option>
                    <?php foreach($article_categories as $category) {
                        ?>  
                        <option value="<?php echo $category['id'] ?>">
                            <?php echo $category['name'] ?>
                        </option>
                        <?php
                    } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="">文章配图</label>
                <input type="text" name="thumb" class="form-control" id="exampleInputEmail1" value="" placeholder="文章配图">
            </div>
            <div class="form-group">
                <label for="">文章详情</label>
                <textarea name="content" id="" cols="30" rows="10" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">添加文章</button>
        </form>
    </div>

    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="dist/js/bootstrap.min.js"></script>
    <script src="dist/js/button.js"></script>
    <script src="jquery.min.js"></script>
</body>

</html>