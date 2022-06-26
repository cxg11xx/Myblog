<?php 

//获取文章分类数据
require './dist/mysql/public.php';
$db = database();

//获取数据分类
$categories = $db->order(['id' => 'asc'])->select('article_category');

$id = $_GET['id'];

$articles= $db->where(['article_category_id' => $id])->select('article');
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
                    <li><a href="index.php">首页 <span class="sr-only">(current)</span></a></li>
                    <?php foreach($categories as $category){ ?>
                        <li><a href="category_page.php?id=<?php echo $category['id']; ?>"><?php echo  $category['name'] ?></a></li>

                    <?php } ?>

                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="login.php">后台</a></li>  
                    </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
    
    <div class="container" style="margin-top: 100px;">
        <div class="row">
            <?php foreach($articles as $article){ ?>
                <div class="col-xs-12" style="border: 1px solid #666;">
                    <div class="media"> 
                        <div class="media-left">
                            <a href="#">
                                <img class="media-object img-rounded" src="<?php echo $article['thumb'] ?>"  alt="无图" style="width: 100px;">
                            </a>
                        </div>
                    <div class="media-body">
                        <a href="page.php?id=<?php echo $article['id'] ?>">
                            <span class="btn btn-primary"><?php echo $categories[$article['article_category_id']-1]['name']; ?></span>
                            <h4 class="media-heading" style="display: inline-block;"><?php echo $article['title']; ?></h4>
                            <p><?php echo $article['content'] ?></p>
                        </a>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    
    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="dist/js/bootstrap.min.js"></script>
    <script src="dist/js/jquery.min.js"></script>
</body>

</html>