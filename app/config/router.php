<?php

use Phalcon\Mvc\Router as Router;

$di->set('router', function() {
    $router = new Router(false);
    $router->removeExtraSlashes(true);

    $router->addGet('/', array(
       'controller' => 'index',
       'action' => 'public'
    ));

    $router->addGet('/inicio', array(
       'controller' => 'index',
       'action' => 'public'
    ));

    $router->addPost('/inicio/elegir-seccion', array(
       'controller' => 'index',
       'action' => 'selectSection'
    ));

    $router->addGet('/inicio/administrar', array(
       'controller' => 'index',
       'action' => 'index'
    ));

    $router->addPost('/inicio/previsualizar', array(
       'controller' => 'index',
       'action' => 'preview'
    ));

    $router->addPost('/inicio/actualizar', array(
       'controller' => 'index',
       'action' => 'update'
    ));

    $router->addGet('/inicio/reiniciar', array(
       'controller' => 'index',
       'action' => 'restart'
    ));

    $router->addGet('/caracteristicas', array(
       'controller' => 'features',
       'action' => 'public'
    ));

    $router->add('/caracteristicas/administrar', array(
       'controller' => 'features',
       'action' => 'index'
    ))->via(['GET', 'POST']);

    $router->add('/caracteristicas/crear', array(
       'controller' => 'features',
       'action' => 'create'
    ))->via(['GET', 'POST']);

    $router->addGet('/caracteristicas/leer/{feature_id:\d+}', array(
       'controller' => 'features',
       'action' => 'read'
    ));

    $router->add('/caracteristicas/actualizar/{feature_id:\d+}', array(
       'controller' => 'features',
       'action' => 'update'
    ))->via(['GET', 'POST']);

    $router->addPost('/caracteristicas/borrar/{feature_id:\d+}', array(
       'controller' => 'features',
       'action' => 'delete'
    ));

    $router->addGet('/preguntas-frecuentes', array(
       'controller' => 'faqs',
       'action' => 'public'
    ));

    $router->addGet('/preguntas-frecuentes/administrar', array(
       'controller' => 'faqs',
       'action' => 'index'
    ));

    $router->addPost('/preguntas-frecuentes/previsualizar', array(
       'controller' => 'faqs',
       'action' => 'preview'
    ));

    $router->addPost('/preguntas-frecuentes/actualizar', array(
       'controller' => 'faqs',
       'action' => 'update'
    ));

    $router->addGet('/preguntas-frecuentes/reiniciar', array(
       'controller' => 'faqs',
       'action' => 'restart'
    ));

    $router->addGet('/terminos', array(
       'controller' => 'terms',
       'action' => 'public'
    ));

    $router->addGet('/terminos/administrar', array(
       'controller' => 'terms',
       'action' => 'index'
    ));

    $router->addPost('/terminos/previsualizar', array(
       'controller' => 'terms',
       'action' => 'preview'
    ));

    $router->addPost('/terminos/actualizar', array(
       'controller' => 'terms',
       'action' => 'update'
    ));

    $router->addGet('/terminos/reiniciar', array(
       'controller' => 'terms',
       'action' => 'restart'
    ));

    $router->addGet('/contacto', array(
       'controller' => 'contact',
       'action' => 'public'
    ));

    $router->addPost('/contacto/enviar-datos', array(
       'controller' => 'contact',
       'action' => 'submitData'
    ));

    $router->addGet('/contacto/administrar', array(
       'controller' => 'contact',
       'action' => 'index'
    ));

    $router->addPost('/contacto/previsualizar', array(
       'controller' => 'contact',
       'action' => 'preview'
    ));

    $router->addPost('/contacto/actualizar', array(
       'controller' => 'contact',
       'action' => 'update'
    ));

    $router->addGet('/contacto/reiniciar', array(
       'controller' => 'contact',
       'action' => 'restart'
    ));

    $router->addGet('/desuscribir', array(
       'controller' => 'unsuscribe',
       'action' => 'public'
    ));

    $router->addPost('/desuscribir/enviar-datos', array(
       'controller' => 'unsuscribe',
       'action' => 'submitData'
    ));

    $router->add('/desuscribir/administrar', array(
       'controller' => 'unsuscribe',
       'action' => 'index'
    ))->via(['GET', 'POST']);

    $router->add('/desuscribir/crear', array(
       'controller' => 'unsuscribe',
       'action' => 'create'
    ))->via(['GET', 'POST']);

    $router->add('/desuscribir/actualizar/{ban_id:\d+}', array(
       'controller' => 'unsuscribe',
       'action' => 'update'
    ))->via(['GET', 'POST']);

    $router->addPost('/desuscribir/borrar/{ban_id:\d+}', array(
       'controller' => 'unsuscribe',
       'action' => 'delete'
    ));

    $router->addGet('/captcha/generar/{time:\d+}', array(
       'controller' => 'captcha',
       'action' => 'generateCaptcha'
    ));

    $router->add('/404/perfil/registro', array(
       'controller' => 'profile',
       'action' => 'register'
      ))->via(['GET', 'POST']);

    $router->add('/404/perfil/ingreso', array(
       'controller' => 'profile',
       'action' => 'login'
    ))->via(['GET', 'POST']);

    $router->add('/404/perfil/recuperar', array(
       'controller' => 'profile',
       'action' => 'recover'
    ))->via(['GET', 'POST']);

    $router->add('/404/perfil/recuperar/finalizar/{admin_id:\d+}/{token:([A-Za-z0-9]+)}', array(
       'controller' => 'profile',
       'action' => 'finishRecover'
    ))->via(['GET', 'POST']);

    $router->addGet('/opciones', array(
       'controller' => 'options',
       'action' => 'index'
    ));

    $router->add('/mensajes', array(
       'controller' => 'messages',
       'action' => 'index'
    ))->via(['GET', 'POST']);

    $router->addGet('/mensajes/leer/{message_id:\d+}', array(
       'controller' => 'messages',
       'action' => 'read'
    ));

    $router->add('/mensajes/actualizar/{message_id:\d+}', array(
       'controller' => 'messages',
       'action' => 'update'
    ))->via(['GET', 'POST']);

    $router->addPost('/mensajes/borrar/{message_id:\d+}', array(
       'controller' => 'messages',
       'action' => 'delete'
    ));

    $router->addPost('/mensajes/marcar-como-leido/{message_id:\d+}', array(
       'controller' => 'messages',
       'action' => 'markAsRead'
    ));

    $router->addPost('/mensajes/marcar-como-no-leido/{message_id:\d+}', array(
       'controller' => 'messages',
       'action' => 'markAsNotRead'
    ));

    $router->addGet('/perfil', array(
       'controller' => 'profile',
       'action' => 'index'
    ));

    $router->addGet('/perfil/salir', array(
       'controller' => 'profile',
       'action' => 'logout'
    ));

    $router->add('/perfil/actualizar-alias', array(
       'controller' => 'profile',
       'action' => 'updateAlias'
    ))->via(['GET', 'POST']);

    $router->add('/perfil/actualizar-correo', array(
       'controller' => 'profile',
       'action' => 'updateEmail'
    ))->via(['GET', 'POST']);

    $router->addGet('/perfil/actualizar-correo/finalizar/{admin_id:\d+}/{token:([A-Za-z0-9]+)}', array(
       'controller' => 'profile',
       'action' => 'finishUpdateEmail'
    ));

    $router->add('/perfil/actualizar-contrasenia', array(
       'controller' => 'profile',
       'action' => 'updatePassword'
    ))->via(['GET', 'POST']);

    $router->add('/perfil/actualizar-contrasenia/finalizar/{admin_id:\d+}/{token:([A-Za-z0-9]+)}', array(
       'controller' => 'profile',
       'action' => 'finishUpdatePassword'
    ))->via(['GET', 'POST']);

    $router->add('/perfil/borrar', array(
       'controller' => 'profile',
       'action' => 'delete'
    ))->via(['GET', 'POST']);

    $router->addGet('/perfil/borrar/finalizar/{admin_id:\d+}/{token:([A-Za-z0-9]+)}', array(
       'controller' => 'profile',
       'action' => 'finishDelete'
    ));

    $router->add('/perfil/actualizar-perfil-temporal', array(
       'controller' => 'profile',
       'action' => 'updateTempProfile'
    ))->via(['GET', 'POST']);

    $router->addGet('/perfil/verificar', array(
       'controller' => 'profile',
       'action' => 'verify'
    ));

    $router->addGet('/perfil/verificar/finalizar/{admin_id:\d+}/{token:([A-Za-z0-9]+)}', array(
       'controller' => 'profile',
       'action' => 'finishVerify'
    ));

    $router->addPost('/idioma', array(
       'controller' => 'language',
       'action' => 'change'
    ));

    // 404
    $router->notFound(array(
        'controller' => 'errors',
        'action' => 'show404'
    ));

    return $router;
});
