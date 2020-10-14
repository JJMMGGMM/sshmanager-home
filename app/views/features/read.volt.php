{% extends 'main.volt.php' %}

{% block title %}{{ tr('read_feature') | upper }} {{ feature_id }}{% endblock %}

{% block css_custom %}
  <style type="text/css">
    .img-responsive {
      width: 70%;
    }
  </style>
{% endblock %}

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
            <strong>{{ tr('read_feature') }} {{ feature_id }}</strong>
            <br>
            <a href="{{ url('caracteristicas/administrar') }}" class="btn-warning btn-xs">
              <i class="fa fa-arrow-left"></i> {{ tr('form_back') }}
            </a>
          </h2>
          {% if feature %}
            <p>
              <strong>{{ tr('feature_title') }}</strong> {{ feature.title }}
              <br>
              {% if feature.updated_at %}
                <strong>{{ tr('feature_created_at') }}:</strong> {{ dateForHumans(feature.created_at, time_lang) }} ({{ tr('feature_updated_at') }}: {{ dateForHumans(feature.updated_at, time_lang) }})
              {% else %}
                <strong>{{ tr('feature_created_at') }}:</strong> {{ dateForHumans(feature.created_at, time_lang) }} ({{ tr('feature_updated_at') }}: No)
              {% endif %}
            </p>
            <p>
              <strong>{{ tr('feature_content') }}:</strong>
              <br>
               {{ feature.content }}
            </p>
            <div class="row">
              <center>
                <div class="col-md-6">
                  <strong>{{ tr('feature_icon') }}</strong>
                  <img
                    class="img-responsive"
                    src="{{ url('uploads/images/features/') ~ feature.icon }}"
                    alt="{{ tr('feature_icon') }}"
                    id="icon_feature"
                  >
                </div>
                <div class="col-md-6">
                  <strong>{{ tr('feature_image') }}</strong>
                  <img
                    class="img-responsive"
                    src="{{ url('uploads/images/features/') ~ feature.image }}"
                    alt="{{ tr('feature_image') }}"
                    id="image_feature"
                  >
                </div>
              </center>
            </div>
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
