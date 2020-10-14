{% extends 'main.volt.php' %}

{% block title %}{{ tr('features_title') | upper }}{% endblock %}

{% block css_custom %}
  <style type="text/css">
    .features-img {
      width: 50px;
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
                  <h1>{{ tr('main_features') }}</h1>
                </div>
              </div>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </aside>

  <div id="colorlib-project">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          {{ partial('partials/alerts') }}
        </div>
      </div>
      <div class="row">
        {% if count(features) > 0 %}
          {% for feature in features %}
            <div class="col-md-6 animate-box">
              <div class="item item-2">
                <a href="{{ url('uploads/images/features/') ~ feature.image }}" class="project image-popup-link" style="background-image: url({{ url('uploads/images/features/') ~ feature.image }});">
                  <div class="desc-t">
                    <div class="desc-tc">
                      <div class="desc">
                        <h3>
                          <span><small><img src="{{ url('uploads/images/features/') ~ feature.icon }}" class="features-img"></small></span>
                          {{ feature.title }}
                        </h3>
                        <p>{{ feature.content }}</p>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            </div>
          {% endfor %}
        {% else %}
          <div class="well well-lg">
            <h3 class="text-center"><i class="fa fa-exclamation-triangle fa-3x"></i></h3>
            <h3 class="cta-title text-center">{{ tr('no_data') }}</h3>
          </div>
        {% endif %}
      </div>
    </div>
  </div>
{% endblock %}
