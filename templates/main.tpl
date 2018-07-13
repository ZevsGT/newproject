<!doctype html>
<html lang="ru">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="templates/style/bootstrap.css">
    
    <!-- Main CSS -->
    <link rel="stylesheet" href="templates/style/main.css">
    <!-- icons CSS -->
    <link rel="stylesheet" href="templates/style/font-awesome.min.css">
    <script src="/templates/js/jquery-3.3.1.min.js"></script>
    <script src="/templates/js/bootstrap.min.js"></script>
    <title>Тестирование</title>
   
  </head>
  <body>
    {% include 'navbar.tpl' %}

    

    {% block content %}
    {% endblock %}


    {% include 'footer.tpl' %}
 	  <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    
    
  </body>
</html>