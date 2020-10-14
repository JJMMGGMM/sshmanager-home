{% extends 'main.volt.php' %}

{% block title %}{{ tr('create_feature') | upper }}{% endblock %}

{% block css_custom %}
  <style type="text/css">
    .img-responsive {
      width: 70%;
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
            <strong>{{ tr('create_feature') }}</strong>
            <br>
            <a href="{{ url('caracteristicas/administrar') }}" class="btn-warning btn-xs">
              <i class="fa fa-arrow-left"></i> {{ tr('form_back') }}
            </a>
          </h2>
          {{ form('caracteristicas/crear', 'method': 'post', 'enctype': 'multipart/form-data', 'id': 'frm') }}
            <input type="hidden" name="lang_id" value="{{ app_lang_id }}">
            <div class="row form-group">
              <div class="col-md-12">
                <label for="titulo">{{ tr('feature_title') }}</label>
                <input type="text" name="titulo" value="{{ old.titulo is defined ? old.titulo : '' }}" class="form-control frm-id" placeholder="{{ tr('feature_title') }}">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-md-12">
                <label for="contenido">{{ tr('feature_content') }}</label>
                <input type="text" name="contenido" value="{{ old.contenido is defined ? old.contenido : '' }}" class="form-control frm-id" placeholder="{{ tr('feature_content') }}">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-md-12">
                <label for="icono">{{ tr('feature_icon') }}</label>
                <input type="file" name="icono" accept="image/png, image/jpeg" id="change_icon">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-md-12">
                <label for="imagen">{{ tr('feature_image') }}</label>
                <input type="file" name="imagen" accept="image/png, image/jpeg" id="change_image">
              </div>
            </div>
            <input type="hidden" name="{{ security.getTokenKey() }}" value="{{ security.getToken() }}">
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
            <div class="row">
              <center>
                <div class="col-md-6">
                  <strong>{{ tr('feature_icon') }}</strong>
                  <img
                    class="img-responsive"
                    src="{{ url('images/placeholder_image.png') }}"
                    alt="{{ tr('feature_icon') }}"
                    id="icon_feature"
                  >
                </div>
                <div class="col-md-6">
                  <strong>{{ tr('feature_image') }}</strong>
                  <img
                    class="img-responsive"
                    src="{{ url('images/placeholder_image.png') }}"
                    alt="{{ tr('feature_image') }}"
                    id="image_feature"
                  >
                </div>
              </center>
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

      // change icon before upload
      let icon_reader = new FileReader();
      icon_reader.onload = function (e) {
        dataIconURL = icon_reader.result;
        output = document.getElementById('icon_feature');
        output.src = dataIconURL;
      }
       
      function readIconURL(input) {
        if (input.files && input.files[0]) {
          icon_reader.readAsDataURL(input.files[0]);
        }
      }

      // change image before upload
      let change_icon = document.getElementById('change_icon');
      change_icon.addEventListener('change', function(){
        readIconURL(this);
      });

      let image_reader = new FileReader();
      image_reader.onload = function (e) {
        dataImageURL = image_reader.result;
        output = document.getElementById('image_feature');
        output.src = dataImageURL;
      }
       
      function readImageURL(input) {
        if (input.files && input.files[0]) {
          image_reader.readAsDataURL(input.files[0]);
        }
      }

      let change_image = document.getElementById('change_image');
      change_image.addEventListener('change', function(){
        readImageURL(this);
      });
    })();
  </script>
{% endblock %}
