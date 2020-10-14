{% extends 'main.volt.php' %}

{% block title %}{{ tr('all_messages') | upper }}{% endblock %}

{% block css_custom %}
  <style type="text/css">
    .pager.pagination {
      padding-left: 0;
      margin: 20px 0;
      text-align: center;
      list-style: none;
    }
    .pager.pagination button {
      display: inline;
    }
    .pager.pagination button {
      display: inline-block;
      padding: 5px 14px;
      color: #1E2022;
      background-color: #FFFFFF;
      border: 1px solid #FFFFFF;
      border-radius: 15px;
    }
    .pager.pagination button:hover,
    .pager.pagination button:focus {
      color: #1E2022;
      background-color: #FFCD00;
      border: 1px solid #FFCD00;
      text-decoration: none;
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
            <strong>{{ tr('list_of_messages') }}</strong>
            <br>
            <a href="{{ url('mensajes') }}" class="btn-danger btn-xs">
              <i class="fa fa-redo"></i> {{ tr('form_reset_search') }}
            </a>
          </h2>
          {% if messages is defined and messages.current <= messages.last %}
            <div class="table-responsive">
              <table class="table table-striped table-condensed table-hover table-sm">
                <caption>
                  <b>Total: </b>{{ messages.total_items }} {{ tr('message') }}(s)
                </caption>
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">{{ tr('message_identifier') }}</th>
                    <th scope="col">{{ tr('message_name') }}</th>
                    <th scope="col">{{ tr('message_subject') }}</th>
                    <th scope="col">{{ tr('message_received_at') }}</th>
                    <th scope="col" class="text-center">{{ tr('form_options') }}</th>
                    <th scope="col" class="text-center">{{ tr('message_mark_as') }}</th>
                  </tr>
                </thead>
                <tbody>
                  {% for message in messages.items %}
                    <tr>
                      {% if message.read_at is not defined %}
                        <th><b>{{ message.message_id }}</b></th>
                        <td><b>{{ message.identifier }}</b></td>
                        <td><b>{{ message.name }}</b></td>
                        <td><b>{{ message.subject }}</b></td>
                        <td><b>{{ formatDate(message.received_at) }}</b></td>
                      {% else %}
                        <th>{{ message.message_id }}</th>
                        <td>{{ message.identifier }}</td>
                        <td>{{ message.name }}</td>
                        <td>{{ message.subject }}</td>
                        <td>{{ formatDate(message.received_at) }}</td>
                      {% endif %}
                      <td class="text-center">
                        <a href="{{ url('mensajes/leer/' ~ message.message_id) }}" title="{{ tr('form_read') }}" class="btn-options btn-success btn-xs">
                          <i class="fa fa-eye"></i>
                        </a>
                        <a href="{{ url('mensajes/actualizar/' ~ message.message_id) }}" title="{{ tr('form_update') }}" class="btn-options btn-warning btn-xs">
                          <i class="fa fa-pen-alt"></i>
                        </a>
                        {{ form('mensajes/borrar/' ~ message.message_id, 'method': 'post') }}
                          <input type="hidden" name="{{ security.getTokenKey() }}" value="{{ security.getToken() }}">
                          <button type="submit" title="{{ tr('form_delete') }}" class="btn-options btn-danger btn-xs">
                            <i class="fa fa-trash"></i>
                          </button>
                        {{ end_form() }}
                      </td>
                      <td class="text-center">
                        {{ form('mensajes/marcar-como-no-leido/' ~ message.message_id, 'method': 'post') }}
                        <input type="hidden" name="{{ security.getTokenKey() }}" value="{{ security.getToken() }}">
                          <button type="submit" title="{{ tr('message_not_read') }}" class="btn-options btn-danger btn-xs">
                            <i class="fa fa-check"></i>
                          </button>
                        {{ end_form() }}
                        {{ form('mensajes/marcar-como-leido/' ~ message.message_id, 'method': 'post') }}
                        <input type="hidden" name="{{ security.getTokenKey() }}" value="{{ security.getToken() }}">
                          <button type="submit" title="{{ tr('message_read') }}" class="btn-options btn-success btn-xs">
                            <i class="fa fa-check-double"></i>
                          </button>
                        {{ end_form() }}
                      </td>
                    </tr>
                  {% endfor %}
                </tbody>
              </table>
              <p>
              {{ tr('form_get_pages', ['current_page': messages.current,'total_pages': messages.total_pages]) }}
              </p>
            </div>
            {% if messages.total_pages > 0 %}
              <hr style="height: 2px; color: #8B8B8B; background-color: #8B8B8B">
              <p>
                {{ form('mensajes', 'method': 'post') }}
                  <div class="row form-group">
                    <div class="col-md-2">
                      <label>{{ tr('form_current') }}</label>
                      <input type="text" name="actual" value="{{ actual is defined ? actual : '1' }}" class="form-control input-sm frm" >
                    </div>
                    {% if orden is not defined or orden == 'desc' %}
                      <div class="col-md-2">
                        <label>{{ tr('form_order_by') }}</label>
                        <div class="radio">
                          <label>
                          <input type="radio" name="orden" value="desc" checked>
                            {{ tr('form_desc') }}
                          </label>
                        </div>
                        <div class="radio">
                          <label>
                          <input type="radio" name="orden" value="asc">
                            {{ tr('form_asc') }}
                          </label>
                        </div>
                      </div>
                    {% else %}
                      <div class="col-md-2">
                        <label>{{ tr('form_order_by') }}</label>
                        <div class="radio">
                          <label>
                          <input type="radio" name="orden" value="desc">
                            {{ tr('form_desc') }}
                          </label>
                        </div>
                        <div class="radio">
                          <label>
                          <input type="radio" name="orden" value="asc" checked>
                            {{ tr('form_asc') }}
                          </label>
                        </div>
                      </div>          
                    {% endif %}
                    <div class="col-md-2">
                      <label>{{ tr('form_limit') }}</label>
                      <input type="text" name="limite" value="{{ limite is defined ? limite : 10 }}" class="form-control input-sm frm" >
                    </div>
                    <div class="col-md-4">
                      <label>{{ tr('form_search_keyword') }}</label>
                      <input type="text" name="busqueda" value="{{ busqueda is defined ? busqueda : '' }}" class="form-control input-sm frm" >
                    </div>
                    <div class="col-md-2">
                      <label>{{ tr('form_options') }}</label>
                      <br>
                      <button type="submit" class="btn-primary btn-submit">
                        <i class="fa fa-search"></i>
                      </button>
                      <button type="reset" class="btn-danger btn-reset">
                        <i class="fa fa-eraser"></i>
                      </button>
                    </div>
                  </div>
                  <ul class="pager pagination">
                    <li>
                      <button type="submit" name="actual" value="1">{{ tr('form_first') }}</button>
                    </li>
                    {% if messages.total_pages > 2 %}
                      <li>
                        <button type="submit" name="actual" value="{{ messages.before }}">{{ tr('form_previous') }}</button>
                      </li>
                      <li>
                        <button type="submit" name="actual" value="{{ messages.next }}">{{ tr('form_next') }}</button>
                      </li>
                    {% endif %} 
                    <li>
                      <button type="submit" name="actual" value="{{ messages.last }}">{{ tr('form_last') }}</button>
                    </li>
                  </ul>
                {{ end_form() }}
              </p>
            {% endif %}
          {% else %}
            <div class="well well-lg">
              <h3 class="text-center"><i class="fa fa-exclamation-triangle fa-3x"></i></h3>
              <h3 class="cta-title text-center">{{ tr('form_no_data') }}</h3>
            </div>
          {% endif %}
        </div>
      </div>
    </div>
  </div>
{% endblock %}
