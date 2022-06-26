<?php 

if($_POST) {
    require './dist/mysql/public.php';
    $db = database();

    $username = $_POST['username'];
    $password = $_POST['password'];

    //md5 先获取加密盐salt
    $salt = md5(mcrypt_create_iv(32));

    $data = [
        'username' => $username,
        'salt' => $salt,
        'password' => md5(md5($password).$salt),

    ];

    



    //存储以上数据到数据表 pg_insert
    $db -> insert('admin',$data);

    //跳转
    header("Location:login.php");

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
            <h3 class="text-center">注册</h3>
            <form class="form-inline">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon"><i class="glyphicon glyphicon-user"></i></div>
                    
                        <input name="username" type="text" class="form-control" id="examoleInuputAmount" placeholder="用户名">
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></div>
                        <input name="password" type="password" class="form-control" id="examoleInuputAmount" placeholder="密码">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-lg btn-block">注册</button>
            </form>
            
        </form>
    </div>

<script src="dist/js/bootstrap.min.js"></script>
    <script src="dist/js/jquery.min.js"></script>
</body>
</html>