{% extends 'main.volt.php' %}

{% block title %}{{ tr('index_title') | upper }}{% endblock %}

{% block css_custom %}
  <style type="text/css">
    a.underline {
      color: #1E2022;
    }

    a.underline:hover {
      color: #1E2022;
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

  <div id="colorlib-about">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          {{ partial('partials/verify') }}
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          {{ partial('partials/alerts') }}
        </div>
      </div>
      <div class="row row-pb-lg">
        <div class="col-md-6">
          <div class="about animate-box">
            {{ parseMarkdown(md_head) }}
          </div>
        </div>
        <div class="col-md-6">
          <img class="img-responsive" src="{{ url('images/snake_md.jpg') }}" alt="sshmanager">
        </div>
      </div>

      {{ parseMarkdown(md_body) }}

    </div>
  </div>

  <div id="colorlib-subscribe">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-md-offset-0 colorlib-heading animate-box">
          {{ parseMarkdown(md_foot) }}
        </div>
      </div>
    </div>
  </div>
{% endblock %}
