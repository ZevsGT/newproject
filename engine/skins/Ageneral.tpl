{% extends 'amain.tpl' %}
{% block acontent %}
 <div id="onas" class="container-fluid b2">
  <br>
    <h2 class="dzh2">Тесты</h2>
      
          <div id="por">
        
        {% for test in tests %}
        <div class="row justify-content-sm-around Plist" id="{{ test.id }}">
            <div class="col-8">
              {{ test.name }}
            </div>  
            <div class="col-2">
              <a href="/admin.php?mod=editinterview&id={{ test.id }}"><span class="btnlist"> Редактировать</span></a>
            </div>
            <div class="col-2">
              <a id="{{ test.id }}" onClick="deltest(this)" href="#"></i><span class="btnlist"> Удалить</span></a>
            </div>                
        </div>
        {% endfor %}
      </div>
  </div>

<script>
    function deltest(obj) {
        //alert(obj.id);
        var id = obj.id;
        var xmlhttp = getXmlHttp(); // Создаём объект XMLHTTP
        xmlhttp.open('POST', 'engine/ajax/deletetest.php', true); // Открываем асинхронное соединение
        xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded'); // Отправляем кодировку
        xmlhttp.send("id=" + encodeURIComponent(id)); // Отправляем POST-запрос
        xmlhttp.onreadystatechange = function() { // Ждём ответа от сервера
            if (xmlhttp.readyState == 4) { // Ответ пришёл
                if(xmlhttp.status == 200) { // Сервер вернул код 200 (что хорошо)
                  $('div#'+id).hide(500, function () {    //удаляем объект 
                      $('div#'+id).remove();
                      count--;
                  });
                }
            }
        };
    }

     function getXmlHttp() {
    var xmlhtt
    try {
      xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
    try {
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (E) {
      xmlhttp = false;
    }
    }
    if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
      xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
  }

</script>

{% endblock %}