{% extends 'main.volt.php' %}

{% block title %}{{ tr('faqs_title') | upper }}{% endblock %}

{% block css_custom %}
  <style type="text/css">
    a.black-text {
      color: #000000;
      text-decoration: none;
    }

    a.black-text:hover {
      color: #000000;
      text-decoration: underline;
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
                  <h1>{{ tr('possible_faqs') }}</h1>
                </div>
              </div>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </aside>

  <div id="colorlib-about">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          {{ partial('partials/alerts') }}
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 animate-box">
          <div class="services">
            {{ parseMarkdown(md_content) }}
          </div>
        </div>
      </div>
    </div>
  </div>
{% endblock %}
