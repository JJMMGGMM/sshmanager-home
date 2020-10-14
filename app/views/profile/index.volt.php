{% extends 'main.volt.php' %}

{% block title %}{{ tr('profile_title') | upper }}{% endblock %}

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
            <strong>{{ auth['alias'] }}</strong>
          </h2>
          <p>{{ tr('control_your_profile') }}</p>
          <div class="btn-group btn-group-lg">
            <a href="{{ url('perfil/actualizar-alias') }}" class="btn btn-default btn-block">
              <i class="fa fa-address-card"></i> {{ tr('update_alias') }}
            </a>
            <a href="{{ url('perfil/actualizar-correo') }}" class="btn btn-default btn-block">
              <i class="fa fa-envelope-open"></i> {{ tr('update_email') }}
            </a>
            <a href="{{ url('perfil/actualizar-contrasenia') }}" class="btn btn-default btn-block">
              <i class="fa fa-key"></i> {{ tr('update_password') }}
            </a>
            <a href="{{ url('perfil/borrar') }}" class="btn btn-default btn-block">
              <i class="fa fa-user-times"></i> {{ tr('delete_profile') }}
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
{% endblock %}
