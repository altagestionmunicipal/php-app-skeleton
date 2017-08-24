<?php
/**
 * slim-boilerplate-code
 *
 * (c) Nazareth Gutiérrez http://jn6h.com
 * License: MIT
 */

namespace Jn6h\View;

use Slim\Slim;

class TwigExtensions extends \Twig_Extension {

  /**
   * Returns the name of the extension.
   *
   * @return string The extension name
   */
  public function getName()
  {
    return 'jn6h';
  }

  /**
   * Returns a list of functions to add to the existing list.
   *
   * @return array An array of functions
   */
  public function getFunctions()
  {
    return array(
      new \Twig_SimpleFunction('gravatar_url', array($this, 'gravatarUrl')),
      new \Twig_SimpleFunction('appcfg', array($this, 'appConfig')),
      new \Twig_SimpleFunction('url_for', array($this, 'urlFor')),
      new \Twig_SimpleFunction('base_url', array($this, 'base')),
      new \Twig_SimpleFunction('site_url', array($this, 'site')),
    );
  }

  /**
   * gravatarUrl
   * @param $email string Email
   * @param $size strin Image size in pixelz e.g. '150x150'
   */
  public function gravatarUrl($email = null, $size = null)
  {
    $format = 'http://www.gravatar.com/avatar/%s?d=mm';
    $hash   = '00000000000000000000000000000000';

    if (null !== $email) {
      $hash = md5(strtolower(trim($email)));
    }

    $url = sprintf($format, $hash);
    if (null !== $size) {
      $url .= '&s=' . ((int) $size);
    }

    return $url;
  }

  /**
   * appConfig
   * @param $var string
   * @param $default mixed (optional)
   */
  public function appConfig($var, $default = null)
  {
    $configVar = Slim::getInstance()->config($var);
    return $configVar === null ? $default : $configVar;
  }

  /**
   * urlFor
   * @param $name string
   * @param $params array
   */
  public function urlFor($name, $params = array())
  {
    return Slim::getInstance()->urlFor($name, $params);
  }

  /**
   * site
   * @param $url strin url
   * @param $withUri bool
   */
  public function site($url, $withUri = true)
  {
    return $this->base($withUri) . '/' . ltrim($url, '/');
  }

  /**
   * base
   * @param $withUri bool
   */
  public function base($withUri = true)
  {
    $req = Slim::getInstance()->request();
    $uri = $req->getUrl();

    if ($withUri) {
      $uri .= $req->getRootUri();
    }

    return $uri;
  }
}
