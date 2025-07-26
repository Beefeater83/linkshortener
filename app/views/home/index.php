<!doctype html>
<html lang="ua">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Головна сторінка</title>
    <meta name="description" content="Головна сторінка">
    <link rel="stylesheet" href="/public/css/main.css" charset="utf-8">
    <link rel="stylesheet" href="/public/css/form.css" charset="utf-8">
    <script src="https://kit.fontawesome.com/5b4bf168f0.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="main-page">
        <?php require 'public/blocks/header.php'?>
        <div class="container main">
            <h1>Ненавидиш довгі посилання?</h1>
            <p>Зараз все скоротимо!</p>
            <form action="" method="post" class="form-control">
                <input type="hidden" name="csrf_token" value="<?= $data['csrf_token'] ?>">
                <input type="text" name="longurl" placeholder="Довге посилання" value="<?= isset($_POST['longurl']) ? $_POST['longurl'] : ""?>"><br>  
                <input type="text" name="shorturl" placeholder="Коротка назва" value="<?= isset($_POST['shorturl']) ? $_POST['shorturl'] : ""?>"><br>           
                
                
                <div class="error"><?= isset($data['error']) ? $data['error'] : ""?></div>
                
                <button class="btn" id="send">Скоротити</button>
            </form>

            <?php if(isset($data['user_links']) && count($data['user_links']) > 0): ?>
                <div class="links_block" id="links_block">
                    
                <h2>Скорочені посилання</h2>   

                <?php foreach($data['user_links'] as $el): ?>
                    <div class="one-link">
                        <p><b>Довге: </b><?=$el['long_url']?></p>
                        <p><b>Коротке: </b><a href="<?=$el['long_url']?>" target="_blank" rel="noopener noreferrer"><?=$el['short_url']?></a></p>
                        <form action="/home/deleteLink" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= $data['csrf_token'] ?>">
                            <input type="hidden" name="link_id" value="<?=$el['id']?>">
                            <button type="submit" >Видалити <i class="fa-solid fa-circle-xmark"></i></button>
                        </form>
                    </div>
                <?php endforeach?>   

                </div>
                
            <?php endif ?> 
        </div>
    </div>    

    <?php require 'public/blocks/footer.php'?>
    <?php require 'public/blocks/side.php'?>
</body>
</html>