{% for msg in flashSession.getMessages('success') %}
  <div class="alert alert-success alert-dismissible fade in" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    <i class="fa fa-check-circle"></i>
    <strong>{{ tr('alert_done') }}</strong>
    <ul>
      <li>{{ msg }}</li>
    </ul>
  </div>
{% endfor %}

{% set output = flash.getMessages('error') %}
{% if output | length %}
  <div class="alert alert-danger alert-dismissible fade in" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    <i class="fa fa-times-circle"></i>
    <strong>{{ tr('alert_error') }}</strong>
    <ul>
      {% for msg in output %}
        <li>{{ msg }}</li>
      {% endfor %}
    </ul>
  </div>
{% endif %}

{% for msg in flashSession.getMessages('warning') %}
  <div class="alert alert-warning alert-dismissible fade in" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    <i class="fa fa-exclamation-circle"></i>
    <strong>{{ tr('alert_warning') }}</strong>
    <ul>
      <li>{{ msg }}</li>
    </ul>
  </div>
{% endfor %}
