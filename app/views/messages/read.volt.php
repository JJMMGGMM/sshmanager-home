{% extends 'main.volt.php' %}

{% block title %}{{ tr('read_message') | upper }} {{ msg_id }}{% endblock %}

{% block content %}
  <aside id="colorlib-hero">
    <div class="flexslider">
      <ul class="slides">
        <li style="background-image: url({{ url('images/main_light.jpg') }});">
          <div class="overlay"></div>
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-8 col-sm-12 col-md-offset-2 slider-text">
                <div class="slider-text-inner text-center">
                  <h2>The Drunk Team Presents</h2>
                  <h1>sshmanager</h1>
                </div>
              </div>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </aside>

  <div id="colorlib-contact">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          {{ partial('partials/alerts') }}
        </div>
      </div>
      <div class="row">
        <div class="col-md-10 col-md-offset-1 animate-box">
          <h2>
            <strong>{{ tr('read_message') }} {{ msg_id }}</strong>
            <br>
            <a href="{{ url('mensajes') }}" class="btn-warning btn-xs">
              <i class="fa fa-arrow-left"></i> {{ tr('form_back') }}
            </a>
          </h2>
          {% if message %}
            <p>
              <strong>{{ tr('message_name') }}:</strong> {{ message.name }} ({{ message.email }})
              <br>
              <strong>{{ tr('message_subject') }}:</strong> {{ message.subject }}
              <br>
              {% if message.read_at %}
                <strong>{{ tr('message_received_at') }}:</strong>
                {{
                  dateForHumans(message.received_at, time_lang)
                }}
                ({{ tr('message_read_at') }}: {{
                 dateForHumans(message.read_at, time_lang) 
                }})
              {% else %}
                <strong>{{ tr('message_read_at') }}:</strong>
                {{
                  dateForHumans(message.received_at, time_lang) }}
                ({{ tr('message_read') }}: No)
              {% endif %}
            </p>
            <p>
              <strong>{{ tr('message_message') }}:</strong>
              <br>
              {{ message.message }}
            </p>
            <p>
              <strong>{{ tr('message_identifier') }}:</strong> {{ message.identifier }}
            </p>
          {% else %}
            <div class="well well-lg">
              <h3 class="text-center"><i class="fa fa-exclamation-triangle fa-3x"></i></h3>
              <h3 class="cta-title text-center">{{ tr('form_no_data') }}</h3>
            </div>
          {% endif %}
        </div>
      </div>
    </div>
  </div>
{% endblock %}
