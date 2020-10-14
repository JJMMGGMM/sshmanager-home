{% extends 'main.volt.php' %}

{% block title %}{{ tr('md_preview') | upper }}{% endblock %}

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
          {{ partial('partials/alerts') }}
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 animate-box">
          <div class="services">
            <h3>
              <strong>
                <i>{{ tr('md_preview') }}</i>
              </strong>
            </h3>
            <hr style="height: 2px; color: #AAAAAA; background-color: #AAAAAA">
            {{ parseMarkdown(md_content_text) }}
            {{ form('preguntas-frecuentes/actualizar', 'method': 'post', 'id': 'frm') }}
              <input type="hidden" name="contenido" value="{{ md_content }}">
              <input type="hidden" name="{{ security.getTokenKey() }}" value="{{ security.getToken() }}">
              <button type="submit" class="btn btn-danger btn-back" name="accion" value="back">
                <i class="fa fa-chevron-circle-left"></i>
                  <span>{{ tr('form_back') }}</span>
              </button>
              <button type="submit" class="btn btn-primary btn-submit" name="accion" value="send">
                <i class="fa fa-chevron-circle-right"></i>
                <span>{{ tr('form_send') }}</span>
              </button>
            {{ end_form() }}
          </div>
        </div>
      </div>
    </div>
  </div>
{% endblock %}

{% block js_custom %}
  <!-- form -->
  <script type="text/javascript" src="{{ url('js/functions/disableFrm.js') }}"></script>

  <script type="text/javascript">
    (function() {
      // config frm
      let frm_options = {
        frm_id: 'frm',
        submit_btn_id: 'btn_submit',
        back_btn_id: 'btn_back',
        submit_btn_class: 'btn-submit',
        back_btn_class: 'btn-back',
        ondis_btn_spantxt: '{{ tr("form_wait") }}',
        onenb_btn_spantxt: '{{ tr("form_send") }}',
        onenb_btn_icon: 'fa-chevron-circle-right',
        ondis_btn_icon: 'fa-spinner',
        ondis_btn_icon_spin: 'fa-pulse'
      }

      // initiallize buttons ids
      let btn_submit_frm;
      let btn_reset_frm;

      // set ids
      function setIds() {
        // select buttons by class
        btn_submit_frm = document.getElementsByClassName(frm_options.submit_btn_class)[0];
        btn_back_frm = document.getElementsByClassName(frm_options.back_btn_class)[0];

        // assign an Id to each variable
        btn_submit_frm.setAttribute('id', frm_options.submit_btn_id);
        btn_back_frm.setAttribute('id', frm_options.back_btn_id);
      }

      setIds();

      // submit data
      btn_submit_frm.addEventListener('click', function prepareData(event) {
        setTimeout(function wait() {
          disablePreviewFrm(frm_options, btn_id = 'submit');
        }, 0);
      });

      // back page
      btn_back_frm.addEventListener('click', function prepareData(event) {
        setTimeout(function wait() {
          disablePreviewFrm(frm_options, btn_id = 'back');
        }, 0);
      });
    })();
  </script>
{% endblock %}
