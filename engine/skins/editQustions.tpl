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
  </head>
  <body>

  <nav class="navbar navbar-expand-lg navbar-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="#navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a href="/admin.php" class="nav-link">Главная</a>
                </li>

                <li class="nav-item">
                    <a href="/index.php" class="nav-link" target="_blank">Посмотреть сайт</a>
                </li>
                
                <li class="nav-item">
                    <a href="/admin.php?mod=addtest" class="nav-link">Добавить Тест</a>
                </li>
            </ul>
            <a href="/engine/modules/logout.php">Выйти</a>
        </div>  
    </nav>


   <div id="onas" class="container-fluid b2">
    <br>
      <h2 class="dzh2">Вопрос</h2>
        <div class="row justify-content-sm-around">
          <div class="col-sm-8">
          	<form action="/engine/modules/editQustion.php" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="id" value="<?= $questions[quest][id]?>">
                  <input type="text" name="name" id="name" required placeholder="Название вопроса" class="w100 border" value="<?= $questions[quest][name]?>">
                  <input type="text" name="<?php $questions[answers][0][id]?>" id="true" required placeholder="Правильный ответ" class="w100 border" value="<?= $questions[answers][0][name]?>">
                  <input type="text" name="<?= $questions[answers][1][id]?>" id="false" required placeholder="Варинат ответа" class="w100 border" value="<?= $questions[answers][1][name]?>">
                  <input type="text" name="<?php
                                                if(isset($questions[answers][2][id])) echo $questions[answers][2][id];
                                                else echo 'false2';
                                                ?>" id="false" placeholder="Варинат ответа" class="w100 border" value="<?= $questions[answers][2][name]?>">
                  <input type="text" name="<?php
                                                if(isset($questions[answers][3][id])) echo $questions[answers][3][id];
                                                else echo 'false3';
                                                ?>" id="false"  placeholder="Варинат ответа" class="w100 border" value="<?= $questions[answers][3][name]?>">
                  <input type="text" name="<?php
                                                if(isset($questions[answers][4][id])) echo $questions[answers][4][id];
                                                else echo 'false4';
                                                ?>" id="false"  placeholder="Варинат ответа" class="w100 border" value="<?= $questions[answers][4][name]?>">
                  <input type="text" name="<?php
                                                if(isset($questions[answers][5][id])) echo $questions[answers][5][id];
                                                else echo 'false5';
                                                ?>" id="false" placeholder="Варинат ответа" class="w100 border" value="<?= $questions[answers][5][name]?>">
                  <input type="text" name="<?php
                                                if(isset($questions[answers][6][id])) echo $questions[answers][6][id];
                                                else echo 'false6';
                                                ?>" id="false"  placeholder="Варинат ответа" class="w100 border" value="<?= $questions[answers][6][name]?>">
                  <input type="text" name="<?php
                                                if(isset($questions[answers][7][id])) echo $questions[answers][7][id];
                                                else echo 'false7';
                                                ?>" id="false"  placeholder="Варинат ответа" class="w100 border" value="<?= $questions[answers][7][name]?>">
                  <input type="text" name="<?php
                                                if(isset($questions[answers][8][id])) echo $questions[answers][8][id];
                                                else echo 'false8';
                                                ?>" id="false" placeholder="Варинат ответа" class="w100 border" value="<?= $questions[answers][8][name]?>">
                  

                  <input value="Сохранить" type="submit" id="further" name="further">
                  <br><br>
              </form>
          </div>
        </div>
    </div>
    <script src="/engine/skins/js/jquery-3.3.1.min.js"></script>
    <script src="/engine/skins/js/bootstrap.min.js"></script>
  </body>
</html>