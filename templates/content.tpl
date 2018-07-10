<div class="container-fluid b2">
	<br>
    <h2 class="dzh2">Тесты</h2>
    <ul>
    {% for test in tests %}
        <li><a href="?id={{ test.id }}">{{ test.name }}</a></li>
    {% endfor %}
    </ul>
</div>