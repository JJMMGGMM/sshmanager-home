{% extends 'main.volt.php' %}

{% block title %}404{% endblock %}

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
            <strong>404</strong>
          </h2>
          <div class="well well-lg">
            <h3 class="text-center"><i class="fa fa-exclamation-triangle fa-3x"></i></h3>
            <h3 class="cta-title text-center">{{ tr('404_not_found') }}</h3>
            <center>
              <a href="{{ url('inicio') }}" class="btn btn-danger">
                <i class="fa fa-chevron-circle-left"></i> {{ tr('go_to_main_page') }}
              </a>
            </center>
          </div>
        </div>
      </div>
    </div>
  </div>
{% endblock %}
