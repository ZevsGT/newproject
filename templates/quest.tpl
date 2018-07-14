{% extends 'main.tpl' %}


{% block content %}
<div class="container-fluid b2">
	<br>
    <h2 class="dzh2">Тесты</h2>
    <h4>{{ count }}</h4>
    
    	{% autoescape false %}
    		{{ render }}
    	{% endautoescape %}
        <div id="infoblock" style="color: #000"></div>
</div>

<script type="text/javascript">
	$("input[name=reply]").prop('disabled', $('form.poll :radio:checked').length == 0);

	$(":radio").on('change', function () {
    $("input[name=reply]").prop('disabled', false);
});

document.getElementById('form').addEventListener('submit', function(evt){
  var http = new XMLHttpRequest(), f = this;
  evt.preventDefault();
  http.open("POST", "/engine/ajax/email.php", true);
  http.onreadystatechange = function() {
    if (http.readyState == 4 && http.status == 200) {
      document.getElementById('infoblock').innerHTML=http.responseText;
      if (http.responseText.indexOf(f.name.value) == 0) { // очистить поле сообщения, если в ответе первым словом будет имя отправителя
        f.name.removeAttribute('value');
        f.contacts.removeAttribute('value');
        f.name.value='';
        f.contacts.value='';
      }
    }
  }
  http.onerror = function() {
    document.getElementById('infoblock').innerHTML='Извините, данные не были переданы';
  }
  http.send(new FormData(f));
}, false);

</script>

{% endblock %} 