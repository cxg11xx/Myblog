<?php 


ini_set('date.timezone','Asia/Shanghai');

//获取文章分类数据
require './dist/mysql/public.php';
$db = database();

$categories = $db->order(['id' => 'asc'])->select('article_category');

$id = $_GET['id'];

// $admins = $db->order(['id' => 'asc'])->select('admin');
// $admin = $admins[1];

$articles = $db->where(['id' => $id]) -> select('article');
$article=$articles[0];

$c_id=$article['article_category_id'];
$cates = $db->where(['id' => $c_id])->select('article_category');
$cate = $cates[0];


if($_POST) {
    $data = [
        'comment' => $_POST['comment'],
        'create_time' => time(),
        'article_id' => $id,
        'name' => $_POST['name'],
    ];

    $result = $db->insert('message',$data);
}

$messages = $db->where(['article_id' => $id])->select('message');


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

    button {
        margin-top: 20px;
    }

    textarea {
        width: 500px;
        height: 200px;
        resize: none;
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
        <h1><?php echo $article['title']; ?></h1>
            <p>类别：<?php echo $cate['name']; ?></p>
            <p>发布时间:  <?php echo date('Y-m-d H:i:s',$article['create_time']) ?></p>
            <p>正文:  <?php echo $article['content']; ?></p>

        <h3 style="padding-top: 100px;">评论区</h3>
        <form action="" method="post">
            
            <textarea name="comment" id="" cols="20" rows="10" class="form-control" placeholder="一起来评论吧~~~"></textarea>
            <div class="row">
                <div class="col-md-4 col-md-offset-8">
                    <input type="text" name="name" class="form-control" style="margin-top: 20px;" placeholder="您要用什么昵称发出评论呢？">
                </div>
                    <div class="col-md-1 col-md-offset-11">
                    <button type="submit" class="btn btn-primary">提交</button>
                </div>
            </div>

            <h4 style="padding-top: 50px;">热门评论</h4>
            <div class="row">
            
                <div class="col-xs-12" style="border: 1px solid #666;">
                    <div class="media-body">
                        <?php foreach($messages as $message){?> 
                            <span class="btn btn-primary"><?php echo $message['name'] ?></span>
                            <h4 class="media-heading" style="display: inline-block;"><?php echo date('Y-m-d H:i:s',$message['create_time']) ?></h4>
                            <p><?php echo $message['comment'] ?></p>
                            <hr>       
                        <?php } ?>
                    </div>
                    <br>
                </div>
            </div>
        </div>
        </form>
        </div>
    
    
    
    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="dist/js/bootstrap.min.js"></script>
    <script src="dist/js/jquery.min.js"></script>
</body>

</html>