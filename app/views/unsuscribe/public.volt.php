{% extends 'main.volt.php' %}

{% block title %}{{ tr('unsuscribe_title') | upper }}{% endblock %}

{% block css_extra_libs %}
  <link rel="stylesheet" href="{{ url('css/toastr.custom.css') }}">
{% endblock %}

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
                  <h1>{{ tr('unsuscribe_form') }}</h1>
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
            <strong>
            {{ tr('unsuscribe_page_intro') }}
            </strong>
          </h2>
          <p>
            {{ tr('unsuscribe_page_content') }}
          </p>
          <p>
            {{ tr('unsuscribe_page_end') }}
          </p>
          <form id="frm">
            <div class="row form-group">
              <div class="col-md-8">
                <label for="nombre">{{ tr('unsuscribe_email') }}</label>
                <input type="text" id="correo" class="form-control frm-id" placeholder="{{ tr('unsuscribe_email') }}">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-md-4">
                <label for="nombre">{{ tr('unsuscribe_captcha') }}</label>
                <input type="text" id="captcha" class="form-control frm-id" placeholder="{{ tr('unsuscribe_captcha') }}">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-md-4">
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
              <button type="reset" id="btn_reset" class="btn btn-danger btn-reset">
                <i class="fa fa-eraser"></i>
                {{ tr('form_clear') }}
              </button>
              <button type="button" id="btn_submit" class="btn btn-primary btn-submit">
                <i class="fa fa-chevron-circle-right"></i>
                <span>{{ tr('form_send') }}</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
{% endblock %}

{% block js_extra_libs %}
  <script type="text/javascript" src="{{ url('js/toastr.min.js') }}"></script>
{% endblock %}

{% block js_custom %}
  <!-- form -->
  <script type="text/javascript" src="{{ url('js/functions/resetData.js') }}"></script>
  <script type="text/javascript" src="{{ url('js/functions/submitData.js') }}"></script>
  <script type="text/javascript" src="{{ url('js/functions/disableFrm.js') }}"></script>
  <script type="text/javascript" src="{{ url('js/functions/enableFrm.js') }}"></script>

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

      // config toastr messages
      let toastr_options = {
        error_title: '<i class="fa fa-times-circle"></i> ' + '{{ tr("ERR_OP") }}',
        success_title: '<i class="fa fa-check-circle"></i> ' + '{{ tr("OK_OP") }}',

        msg_status_200: '{{ tr("STATUS_200") }}',
        msg_status_422: '{{ tr("STATUS_422") }}',
        msg_status_404: '{{ tr("STATUS_404") }}',
        msg_status_0: '{{ tr("STATUS_0") }}',
        msg_status_unknown: '{{ tr("STATUS_UNKNOWN") }}'
      }

      // initiallize buttons ids
      let btn_submit_frm = document.getElementById(frm_options.submit_btn_id);
      let btn_reset_frm =  document.getElementById(frm_options.reset_btn_id);

      // submit data
      btn_submit_frm.addEventListener('click', function prepareData(event) {
        event.preventDefault();

        route = '{{ url("desuscribir/enviar-datos") }}';
        method = 'post';
        data = {};

        //captcha
        captcha_url = '{{ url("captcha/generar/") }}';
        captcha_route = captcha_url + Date.now();
        captcha_img_id = 'captcha_img';

        elements = document.getElementsByClassName('frm-id');
        for (current = 0; current < elements.length; current++) {
          data[elements[current].id] = elements[current].value;
        }

        data['{{ security.getTokenKey() }}'] = '{{ security.getToken() }}';

        disableFrm(
          frm_options
        )
        .then(function submitFrm(){
          return submitData(
            route, method, data, toastr_options, frm_options
          );
        })
        .catch(function enableUI(){
          return enableFrm(frm_options);
        })
        .finally(function enableUI(){
          return enableFrm(frm_options);
        });

        updateCaptcha(captcha_route, captcha_img_id);
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
