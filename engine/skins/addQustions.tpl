{% extends 'amain.tpl' %}
{% block acontent %}
 <div id="onas" class="container-fluid b2">
  <br>
    <h2 class="dzh2">Вопрос</h2>
      <div class="row justify-content-sm-around">
        <div class="col-sm-8">
          {% autoescape false %}
          {{ rend }}
          {% endautoescape %}
        </div>
      </div>
  </div>
{% endblock %}