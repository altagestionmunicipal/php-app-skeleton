<?php
/**
 * slim-boilerplate-code
 *
 * (c) Nazareth Gutiérrez http://jn6h.com
 * License: MIT
 */
return array(
  /**
   * Application
   */
  'app.id'        => 'slim-boilerplate-code',
  'app.name'      => 'slim-boilerplate-code',
  'app.version'   => '1.0',
  'app.baseUrl'   => 'http://example.com',

  /**
   * SEO
   */
  'seo.keywords'    => 'etiqueta1, etiqueta2, etiqueta3',
  'seo.description' => 'Descripción de la página',

  /**
   * Logger
   */
  'logger.app.logfile'    => ROOT . 'logs/app.log',
  'logger.app.level'      => \Monolog\Logger::DEBUG,

  /**
   * Slim configuration
   */
  'slim' => array(
    'debug'               => true,
    "view"                => new \Slim\Views\Twig(),
    'templates.path'      => ROOT . '/templates',
    'cookies.encrypt'     => true,
    'cookies.secret_key'  => 'JN78Loh.$h_tf3G',
    'cookies.cipher'      => MCRYPT_RIJNDAEL_256,
    'cookies.cipher_mode' => MCRYPT_MODE_CBC,
  ),

  /**
   * Twig template engine
   */
  'twig' => array(
    'environment' => array(
      'charset'          => 'utf-8',
      'cache'            => ROOT . 'templates/cache',
      'auto_reload'      => true,
      'strict_variables' => false,
      'autoescape'       => true,
      'debug'            => false,
    ),
  ),
);