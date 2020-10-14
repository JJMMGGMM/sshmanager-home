{% extends 'main.volt.php' %}

{% block title %}{{ tr('all_options') | upper }}{% endblock %}

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
            <strong>{{ tr('all_options') }}</strong>
          </h2>
          <p>{{ tr('options_alias_greeting', ['alias': auth['alias']]) }}</p>
          <div class="btn-group btn-group-lg">
            <a href="{{ url('inicio/administrar') }}" class="btn btn-default btn-block">
              <i class="fa fa-home"></i> {{ tr('options_edit_home') }}
            </a>
            <a href="{{ url('caracteristicas/administrar') }}" class="btn btn-default btn-block">
              <i class="fa fa-list"></i> {{ tr('options_edit_features') }}
            </a>
            <a href="{{ url('preguntas-frecuentes/administrar') }}" class="btn btn-default btn-block">
              <i class="fa fa-question"></i> {{ tr('options_edit_faqs') }}
            </a>
            <a href="{{ url('terminos/administrar') }}" class="btn btn-default btn-block">
              <i class="fa fa-feather-alt"></i> {{ tr('options_edit_terms') }}
            </a>
            <a href="{{ url('contacto/administrar') }}" class="btn btn-default btn-block">
              <i class="fa fa-envelope"></i> {{ tr('options_edit_contact') }}
            </a>
            <a href="{{ url('desuscribir/administrar') }}" class="btn btn-default btn-block">
              <i class="fa fa-ban"></i> {{ tr('options_edit_unsuscribed') }}
            </a>
            <a href="{{ url('mensajes') }}" class="btn btn-default btn-block">
              <span class="badge badge-primary badge-pill">{{ messages }}</span>
                {{ tr('options_read_messages') }}
            </a>
          </div>
          <p>
            {{ tr('options_main_panel') }}
          </p>
        </div>
      </div>
    </div>
  </div>
{% endblock %}
