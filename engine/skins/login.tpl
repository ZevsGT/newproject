<!doctype html>
<html lang="ru">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="engine/skins/style/bootstrap.css">
    <script type="text/javascript" src="engine/skins/js/cssParser.js"></script>
    <!-- Main CSS -->
    <link rel="stylesheet" href="engine/skins/style/main.css">

    <title>Админ панель</title>
    <!-- Yandex.Metrika counter -->
</script>
    <!-- /Yandex.Metrika counter -->   
  </head>
  <body style="background-color: #352F47;">
<div id="reg" class="container-fluid carouselp">
    <br><br><br><br>
    <h2 class="dzh1">Авторизация</h2>
    <div class="row justify-content-sm-around">
        <div class="col-sm-auto">
            <form action="" method="post" id="registr">
                <input type="text" name="login" id="contactFF" required placeholder="Email (ivan@yandex.ru)" x-autocompletetype="email" class="w100 border" value="{{ login }}">
                <input type="password" name="password" id="password" required placeholder="Пароль" x-autocompletetype="name" class="w100 border">
                <input value="Войти" type="submit" id="submitFF" name="submitFF">
                <!--<a href="admin.php?mod=passwordrecovery">Забыли пароль?</a>-->
                <br><br>
                <div id="infoblock" style="background: #FF6B6B;">{{ error }}</div>
            </form>
        </div>
    </div>
</div>
<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="engine/skins/js/jquery-3.3.1.min.js"></script>
    <script src="engine/skins/js/bootstrap.min.js"></script>
  </body>
</html>