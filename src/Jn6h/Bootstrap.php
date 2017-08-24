<?php
/**
 * slim-boilerplate-code
 *
 * (c) Nazareth Gutiérrez http://jn6h.com
 * License: MIT
 */

namespace Jn6h;

use Slim\Slim;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Illuminate\Database\Connectors\ConnectionFactory;
use Illuminate\Container\Container;
use Illuminate\Database\ConnectionResolver;
use Illuminate\Database\Eloquent\Model;

class Bootstrap
{
  /**
   * @var Slim
   */
  protected $app;

  /**
   * @var array
   */
  protected $config;

  /**
   * Constructor
   * @param Slim $app
   * @param array $config
   */
  public function __construct(Slim $app, $config)
  {
    $this->app = $app;
    $this->config = $config;
  }

  /**
   * Bootstrap application
   */
  public function bootstrap()
  {
    $app = $this->app;
    $config = $this->config;

    $app->config($config);
    $this->addDefaultHeaders($app);
    $this->configureView($app, $config);
    $this->configureLogging($app, $config);
    $this->addMiddleware($app, $config);
    $this->setupDb($config);

    return $app;
  }

  /**
   * Twig Setup
   */
  public function configureView(Slim $app, array $config)
  {
    $app->view->parserOptions = $config['twig']['environment'];
    $twig = $app->view()->getInstance();
    $twig->addExtension(new \Jn6h\View\TwigExtensions());
  }

  /**
   * Configure app logging
   */
  public function configureLogging(Slim $app, array $config)
  {
    $app->container->singleton('log', function () use ($app, $config) {
      $log = new Logger('app');

      // Application logger
      $log->pushHandler(
        new StreamHandler(
          $config['logger.app.logfile'],
          $config['logger.app.level']
        )
      );

      return $log;
    });
  }

  /**
   * Add default headers
   */
  public function addDefaultHeaders(Slim $app)
  {
    $app->response->headers->set('Content-Type', 'text/html; charset=utf-8');
  }

  /**
   * Middleware
   */
  public function addMiddleware(Slim $app, array $config)
  {
    $app->add(new \Slim\Middleware\SessionCookie());
  }

  /**
   * Setup Eloquent
   */
  public function setupDb(array $config)
  {
    $connFactory = new ConnectionFactory(new Container);
    $conn = $connFactory->make($config['db']);

    $resolver = new ConnectionResolver();
    $resolver->addConnection('default', $conn);
    $resolver->setDefaultConnection('default');

    Model::setConnectionResolver($resolver);
  }
}