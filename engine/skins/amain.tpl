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
    <!-- icons CSS -->
    <link rel="stylesheet" href="templates/style/font-awesome.min.css">
    
    <title>Админ панель</title>
  </head>
  <body>
    {% include 'navbar.tpl' %}

    {% block acontent %}
    {% endblock %}

    {% include 'footer.tpl' %}
 	<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    
    <script src="engine/skins/js/jquery-3.3.1.min.js"></script>
    <script src="engine/skins/js/bootstrap.min.js"></script>
  </body>
</html>