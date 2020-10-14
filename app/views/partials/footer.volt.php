<footer id="colorlib-footer" role="contentinfo">
  <div class="container">
    <div class="row row-pb-md">
      <div class="col-md-6 col-md-push-1 colorlib-widget">
        <h4>{{ tr('links') }}</h4>
        <p>
          <ul class="colorlib-footer-links">
            <li><a href="{{ url('inicio') }}"><i class="fa fa-home"></i>{{ tr('visitor_home') }}</a></li>
            <li><a href="{{ url('caracteristicas') }}"><i class="fa fa-list"></i>{{ tr('visitor_features') }}</a></li>
            <li><a href="{{ url('preguntas-frecuentes') }}"><i class="fa fa-question"></i> {{ tr('visitor_faqs') }}</a></li>
            <li><a href="{{ url('terminos') }}"><i class="fa fa-feather-alt"></i>{{ tr('visitor_terms') }}</a></li>
            <li><a href="{{ url('contacto') }}"><i class="fa fa-envelope"></i>{{ tr('visitor_contact') }}</a></li>
            <li><a href="{{ url('desuscribir') }}"><i class="fa fa-ban"></i>{{ tr('visitor_unsuscribe') }}</a></li>
          </ul>
        </p>
      </div>
      <div class="col-md-6 colorlib-widget">
        <h4>{{ tr('about_drunk_team') }}</h4>
        <p>
          {{ tr('drunk_team_description') }}
        </p>
        <p>
          <ul class="colorlib-social-icons">
            <li>
              <a href="https://t.me/">
                <i class="fa fa-comment"></i>
              </a>
            </li>
          </ul>
        </p>
      </div>
      <div class="row">
        <div class="col-md-12 text-center">
          <p>
            <small class="block">The Drunk Team &copy; {{ date('Y') }}
            <br>{{ tr('theme_by') }} <a href="https://colorlib.com" target="_blank">Colorlib</a>
            </small>
          </p>
        </div>
      </div>
    </div>
  </div>
</footer>