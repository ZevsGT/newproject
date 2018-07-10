{% extends 'amain.tpl' %}
{% block acontent %}
 <div id="onas" class="container-fluid b2">
  <br>
    <h2 class="dzh2">Вопрос</h2>
      <div class="row justify-content-sm-around">
        <div class="col-sm-8">
        	<form action="engine/modules/addQustion.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="{{ id }}">
                <input type="text" name="name" id="name" required placeholder="Название вопроса" class="w100 border" value="{{ name }}">
                <input type="text" name="true" id="true" required placeholder="Правильный ответ" class="w100 border" value="{{ name }}">
                <input type="text" name="false1" id="false1" required placeholder="Варинат ответа" class="w100 border" value="{{ name }}">
                {% for i in 2..8 %}
                   <input type="text" name="false{{ i }}" id="false{{ i }}" placeholder="Варинат ответа" class="w100 border" value="{{ name }}">
                {% endfor %}

                <input value="Следующий вопрос" type="submit" id="further" name="further">
                <input value="Закончить опрос" type="submit" id="close" name="close">
                <br><br>
            </form>
        </div>
      </div>
  </div>
{% endblock %}