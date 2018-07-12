<!doctype html>
<html lang="ru">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/engine/skins/style/bootstrap.css">
    <script type="text/javascript" src="/engine/skins/js/cssParser.js"></script>
    <!-- Main CSS -->
    <link rel="stylesheet" href="/engine/skins/style/main.css">
    <!-- icons CSS -->
    <link rel="stylesheet" href="/templates/style/font-awesome.min.css">
    
    <title>Админ панель</title>
    <script src="/engine/ckeditor5/ckeditor.js"></script>
    <script src="/engine/ckeditor5/translations/ru.js"></script>
  </head>
  <body>
    <?php
      include 'navbar.tpl';
    ?>
    <div id="onas" class="container-fluid b2">
  <br>
    <h2 class="dzh2">Информация</h2>
      <div class="row justify-content-sm-around">
        <div class="col-sm" style="min-height: 50px; background: #fff; text-align: center; padding: 10px;">
        
            <?= $text ?>

        </div>
      </div>
  </div>
    <?php
      include 'footer.tpl'; 
    ?>

  <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    
    <script src="/engine/skins/js/jquery-3.3.1.min.js"></script>
    <script src="/engine/skins/js/bootstrap.min.js"></script>
  </body>
</html>