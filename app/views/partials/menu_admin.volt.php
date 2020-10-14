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
            <li><a href="{{ url('opciones') }}">{{ tr('admin_options') }}</a></li>
            <li><a href="{{ url('mensajes') }}">{{ tr('admin_messages') }}</a></li>
            <li><a href="{{ url('perfil') }}">{{ tr('admin_profile') }}</a></li>
            <li><a href="{{ url('perfil/salir') }}">{{ tr('admin_logout') }}</a></li>
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
