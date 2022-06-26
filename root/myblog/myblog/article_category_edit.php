<?php 

$id = $_GET['id'];
require './dist/mysql/public.php';
$db = database();

//通过对应的id去查询要修改的记录内容
$rows = $db -> where (['id' => $id])->select('article_category');
$row = $rows[0];

//修改,修改完后先获取新的数据，然后更新数据库
if($_POST) {
    $data = [
        'name' => $_POST['name'],
        'engname' => $_POST['engname'],

    ];



// 插入数据
$result = $db->where(['id' => $id])->update('article_category',$data);
// 跳转 
header('Location:index.php');
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
        <form method="post">
            <div class="form-group">
                <label for="name">文章分类名称</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['name']; ?>">
            </div>
            <div class="form-group">
                <label for="nameEn">文章分类英文名称</label>
                <input type="text" class="form-control" id="engname" name="engname" value="<?php echo $row['engname']; ?>">
            </div>

            <button type="submit" class="btn btn-primary">修改</button>
        </form>
    </div>

    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="dist/js/bootstrap.min.js"></script>
    <script src="dist/js/button.js"></script>
    <script src="jquery.min.js"></script>
</body>

</html>