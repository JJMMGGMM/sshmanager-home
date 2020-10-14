{% extends 'main.volt.php' %}

{% block title %}{{ tr('recover_profile_title') | upper }}{% endblock %}

{% block css_custom %}
  <style type="text/css">
    .btn-update-captcha {
      padding: 6px 6px;
      font-size: 60%;
      line-height: 1.2;
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
            <strong>{{ tr('recover_profile_title') }}</strong>
          </h2>
          {{ form('404/perfil/recuperar', 'method': 'post', 'id': 'frm') }}
            <div class="row form-group">
              <div class="col-md-8">
                <label for="correo">{{ tr('rcv_prf_current_email') }}</label>
                <input type="text" name="correo" value="{{ old.correo is defined ? old.correo : '' }}" class="form-control" placeholder="{{ tr('rcv_prf_current_email') }}">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-md-4">
                <label for="captcha">{{ tr('rcv_prf_recover_captcha') }}</label>
                <input type="text" id="captcha" name="captcha" class="form-control frm-id" placeholder="{{ tr('rcv_prf_recover_captcha') }}">
              </div>
            </div>
            <input type="hidden" name="{{ security.getTokenKey() }}" value="{{ security.getToken() }}">
            <div class="row form-group">
              <div class="col-md-6">
                <img src="{{ url('captcha/generar/' ~ randomInt(0, 999999999)) }}"
                  id="captcha_img"
                  alt="captcha-img"
                >
                <button type="button" id="btn_update_captcha" class="btn btn-info btn-xs btn-update-captcha">
                  <i class="fa fa-redo"></i>
                </button>
              </div>
            </div>
            <div class="form-group">
              <button type="reset" class="btn btn-danger btn-reset">
                <i class="fa fa-eraser"></i>
                {{ tr('form_clear') }}
              </button>
              <button type="submit" class="btn btn-primary btn-submit">
                <i class="fa fa-chevron-circle-right"></i>
                <span>{{ tr('form_send') }}</span>
              </button>
            </div>
          {{ end_form() }}
        </div>
      </div>
    </div>
  </div>
{% endblock %}

{% block js_custom %}
  <!-- form -->
  <script type="text/javascript" src="{{ url('js/functions/disableFrm.js') }}"></script>
  <script type="text/javascript" src="{{ url('js/functions/resetData.js') }}"></script>

  <!-- captcha -->
  <script type="text/javascript" src="{{ url('js/functions/disableFrmCaptcha.js') }}"></script>
  <script type="text/javascript" src="{{ url('js/functions/enableFrmCaptcha.js') }}"></script>
  <script type="text/javascript" src="{{ url('js/functions/updateCaptcha.js') }}"></script>

  <script type="text/javascript">
    (function() {
      // config frm
      let frm_options = {
        frm_id: 'frm',
        submit_btn_id: 'btn_submit',
        reset_btn_id: 'btn_reset',
        submit_btn_class: 'btn-submit',
        reset_btn_class: 'btn-reset',
        ondis_btn_spantxt: '{{ tr("form_wait") }}',
        onenb_btn_spantxt: '{{ tr("form_send") }}',
        onenb_btn_icon: 'fa-chevron-circle-right',
        ondis_btn_icon: 'fa-spinner',
        ondis_btn_icon_spin: 'fa-pulse'
      }

      let captcha_options = {
        frm_id: 'frm',
        captcha_btn_id: 'btn_update_captcha',
        captcha_btn_class: 'btn-update-captcha',
        onenb_btn_icon: 'fa-redo',
        ondis_btn_icon_spin: 'fa-spin'
      }

      // initiallize buttons ids
      let btn_submit_frm;
      let btn_reset_frm;

      // set ids
      function setIds() {
        // select buttons by class
        btn_submit_frm = document.getElementsByClassName(frm_options.submit_btn_class)[0];
        btn_reset_frm = document.getElementsByClassName(frm_options.reset_btn_class)[0];

        // assign an Id to each variable
        btn_submit_frm.setAttribute('id', frm_options.submit_btn_id);
        btn_reset_frm.setAttribute('id', frm_options.reset_btn_id);
      }

      setIds();

      // submit data
      btn_submit_frm.addEventListener('click', function prepareData(event) {
        setTimeout(function wait() {
          disableFrm(frm_options);
        }, 0);
      });

      // reset data
      btn_reset_frm.addEventListener('click', function prepareData(event){
        resetData(frm_options.frm_id);
      });

      // update captcha
      let btn_update_captcha = document.getElementById(captcha_options.captcha_btn_id);
      btn_update_captcha.addEventListener('click', function prepareCaptcha(event) {
        event.preventDefault();

        url = '{{ url("captcha/generar/") }}';
        route = url + Date.now();
        captcha_img_id = 'captcha_img';

        disableFrmCaptcha(
          captcha_options
        )
        .then(function renewCaptcha(){
          return updateCaptcha(route, captcha_img_id);
        })
        .catch(function enableUI(){
          return enableFrmCaptcha(captcha_options);
        })
        .finally(function enableUI(){
          return enableFrmCaptcha(captcha_options);
        });
      });
    })();
  </script>
{% endblock %}
