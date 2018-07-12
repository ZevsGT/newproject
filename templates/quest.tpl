{% extends 'main.tpl' %}


{% block content %}
<div class="container-fluid b2">
	<br>
    <h2 class="dzh2">Тесты</h2>
    <ul>
    	{% autoescape false %}
    		{{ render }}
    	{% endautoescape %}
    </ul>
</div>
{% endblock %} 