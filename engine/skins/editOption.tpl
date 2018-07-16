{% extends 'amain.tpl' %}
{% block acontent %}
 <div id="onas" class="container-fluid b2">
    <br>
      <h2 class="dzh2">Вопрос</h2>
        <div class="row justify-content-sm-around">
          <div class="col-sm-8">
            <form id="form" action="" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="id" value="{{ void.id }}">
                  <input type="text" name="num" id="name" required placeholder="Количетво вопросво" class="w100 border" value="{{ void.num_quest }}">
                  <input type="text" name="passing" id="true" required placeholder="Проходной бал" class="w100 border" value="{{ void.passing_score }}">
                  
                  <input value="Сохранить" type="submit" id="submit" name="submit">
                  <br><br>
              </form>
              <div id="infoblock1" style="color: #000"></div>
          </div>
        </div>
    </div>
  
<script type="text/javascript">
 
document.getElementById('form').addEventListener('submit', function(evt){
  var http = new XMLHttpRequest(), f = this;
  evt.preventDefault();
  http.open("POST", "/engine/modules/addOptions.php", true);
  http.onreadystatechange = function() {
    if (http.readyState == 4 && http.status == 200) {
      document.getElementById('infoblock1').innerHTML=http.responseText;
      if (http.responseText.indexOf("Добавленно") == 0) { 
        setTimeout(function(){
            window.location.href = '/admin.php';
        }, 1 * 1000);
      }
    }
  }
  http.onerror = function() {
    document.getElementById('infoblock1').innerHTML='Извините, данные не были переданы';
  }
  http.send(new FormData(f));
}, false);

</script>

{% endblock %}