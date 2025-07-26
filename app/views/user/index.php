<!doctype html>
<html lang="ua">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Кабінет користувача</title>
    <meta name="description" content="Кабінет користувача">
    <link rel="stylesheet" href="/public/css/main.css" charset="utf-8">
    <link rel="stylesheet" href="/public/css/user.css" charset="utf-8">
    <script src="https://kit.fontawesome.com/5b4bf168f0.js" crossorigin="anonymous"></script>
</head>
<body>

<?php
if (!isset($_COOKIE['login'])) {    
    header('Location: /user/login');
    exit(); 
}
?>
   <div class="main-page">
   <?php require 'public/blocks/header.php'?>

    <div class="container main">
        <h1>Кабінет користувача</h1>
        <div class="user-info">
          <p>Привіт, <b><?=$data['name']?></b></p>         
          
          <form action="/user/dashboard" method="post">
            <input type="hidden" name="exit_btn">
            <button type="submit" class="btn">Вийти</button>
          </form>
          
        </div>
    </div>
   </div>

   <?php require 'public/blocks/footer.php'?>
   <?php require 'public/blocks/side.php'?>
</body>
</html>