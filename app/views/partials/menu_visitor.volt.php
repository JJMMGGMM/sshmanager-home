<nav class="colorlib-nav" role="navigation">
  <div class="top-menu">
    <div class="container">
      <div class="row">
        <div class="col-xs-2">
          <div id="colorlib-logo">
            <a href="{{ url('inicio') }}">sshmanager</a>
          </div>
        </div>
        <div class="col-xs-10 text-right menu-1">
          <ul class="dropdown">
            <li><a href="{{ url('inicio') }}">{{ tr('visitor_home') }}</a></li>
            <li><a href="{{ url('caracteristicas') }}">{{ tr('visitor_features') }}</a></li>
            <li><a href="{{ url('preguntas-frecuentes') }}">{{ tr('visitor_faqs') }}</a></li>
            <li><a href="{{ url('terminos') }}">{{ tr('visitor_terms') }}</a></li>
            <li><a href="{{ url('contacto') }}">{{ tr('visitor_contact') }}</a></li>
            <li>
              <a class="dropdown-item" href="#"
                onclick="event.preventDefault();
                document.getElementById('lang').value = 'en';
                document.getElementById('lang_form').submit();
              "> en
              </a>
              |
              <a class="dropdown-item" href="#"
                onclick="event.preventDefault();
                document.getElementById('lang').value = 'es';
                document.getElementById('lang_form').submit();
              "> es
              </a>
              <form id="lang_form" action="{{ url('idioma') }}" method="post" style="display: none;">
                <input type="hidden" name="lang" id="lang"> 
                </input>  
              </form>  
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</nav>