<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>{{ tr('contact_email_title') | upper }} :: SSHMANAGER</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ tr('contact_email_title') }}">
    <meta name="author" content="The Drunk Team">
    <style type="text/css">
      body {
        font-family: 'Calibri', 'Candara', 'Segoe', 'Segoe UI', 'Optima', 'Arial', 'sans-serif';
      }
    </style>
  </head>
  <body>
    <h2>{{ name }}</h2>
    {{ tr('contact_email_intro') }}
    <p>
      {{ tr('contact_email_disclaimer') }} <strong>{{ email }}</strong>

    </p>
    <p>
      {{ tr('contact_email_subject') }}
      <br>
      <strong>{{ subject }}</strong>
    </p>
    <p>
      {{ tr('contact_email_message') }}
      <br>
      <strong>{{ message }}</strong>
    </p>
    {{ tr('contact_email_notice') }}
    <hr>
    <small>
      {{ tr('contact_email_note', ['unsuscribe_url': config.application.publicUrl ~ url('desuscribir') ]) }}
    </small>
  </body>
</html>
