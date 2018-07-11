{% extends 'amain.tpl' %}
{% block acontent %}
 <div id="onas" class="container-fluid b2">
  <br>
    <h2 class="dzh2">Название теста</h2>
      {{ error }}
      <div class="row justify-content-sm-around">
        <div class="col-sm-8">
        	<form action="engine/modules/editTitleTest.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="{{ interv.id }}">
                <input type="text" name="name" id="name" required placeholder="Название теста" class="w100 border" value="{{ interv.name }}">
    
                <input value="Далее" type="submit" id="submitPP" name="further">
                <br><br>
            </form>
        </div>
      </div>
  </div>
{% endblock %}