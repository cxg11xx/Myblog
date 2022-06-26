<?php
if ($_POST) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username && $password) {

        require './dist/mysql/public.php';
        $db = database();

        $rows = $db->where(['username' => '"' . $username . '"'])->select('admin');

        $row = $rows[0];
        var_dump($row);

        $password = md5(md5($password) . $row['salt']);
        if ($password == $row['password']) {
            setcookie('login_flag', '1', time() + 300);
            header('Location:article_category.php');
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="dist/css/bootstrap.css">
</head>
<style>
    form {
        width: 400px;
        position: absolute;
        top: 40%;
        left: 50%;
        transform: translate(-50%,-50%);
        border: 1px solid #999;
        padding: 20px;
        border-radius: 10px;
    }
</style>
<body>
    
    <div class="container">
        <form action="" method="post">
            <h3 class="text-center">登录</h3>
            <form class="form-inline">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon"><i class="glyphicon glyphicon-user"></i></div>
                    
                        <input name="username" type="text" class="form-control" id="examoleInuputAmount" placeholder="用户名">
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group" style="margin-bottom: 20px;">
                        <div class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></div>
                        <input name="password" type="password" class="form-control" id="examoleInuputAmount" placeholder="密码">
                    </div>
                    <div class="form-group">
                        <a href="register.php" >注册</a>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-lg btn-block">登录</button>
            </form>
            
        </form>
    </div>

<script src="dist/js/bootstrap.min.js"></script>
    <script src="dist/js/jquery.min.js"></script>
</body>
</html>