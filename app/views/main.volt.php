<!DOCTYPE html>
<html lang="{{ app_lang }}">
  <head>
    <meta charset="utf-8">
    <title>{% block title %}{% endblock %} :: SSHMANAGER</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="sshmanager">
    <meta name="keywords" content="sshmanager, adm, script">
    <meta name="author" content="Drunk Team">

    <!-- css libraries -->
    <link rel="stylesheet" href="{{ url('css/montserrat.css') }}">
    <link rel="stylesheet" href="{{ url('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ url('css/animate.css') }}">
    <link rel="stylesheet" href="{{ url('css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ url('css/flexslider.css') }}">
    <link rel="stylesheet" href="{{ url('css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ url('css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ url('css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ url('css/solid.css') }}">
    <link rel="stylesheet" href="{{ url('css/style.css') }}">
    
    <link rel="shortcut icon" href="{{ url('favicon.ico') }}">

    <!-- modernizr -->
    <script type="text/javascript" src="{{ url('js/modernizr-2.6.2.min.js') }}"></script>

    <!-- support for ie9 below -->
    <!--[if lt IE 9]>
    <script type="text/javascript" src="{{ url('js/respond.min.js') }}"></script>
    <![endif]-->

    <!-- custom css -->
    {% block css_extra_libs %}{% endblock %}

    {% block css_custom %}{% endblock %}
  </head>
  <body>
    <div class="colorlib-loader"></div>

    <div id="page">
      <!-- header -->
      {% set auth = session.get('auth-identity') %}
      {% if auth['permission_id'] == 1 %}
        {{ partial('partials/menu_admin') }}
      {% elseif auth['permission_id'] == 2 %}
        {{ partial('partials/menu_limited') }}
      {% else %}
        {{ partial('partials/menu_visitor') }}
      {% endif %}
      <!-- end header -->

      <!-- content -->
      {% block content %}{% endblock %}
      <!-- end content -->

      <!-- footer -->
      {{ partial('partials/footer') }}
      <!-- end footer -->
    </div>

    <div class="gototop js-top">
      <a href="#" class="js-gotop"><i class="fa fa-arrow-circle-up"></i></a>
    </div>
  
    <!-- js libraries -->
    <script type="text/javascript" src="{{ url('js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/jquery.easing.1.3.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/jquery.waypoints.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/jquery.stellar.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/jquery.flexslider-min.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/owl.carousel.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/jquery.magnific-popup.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/magnific-popup-options.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/jquery.countTo.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/main.js') }}"></script>

    <!-- custom js -->
    {% block js_extra_libs %}{% endblock %}

    {% block js_custom %}{% endblock %}  
  </body>
</html>
