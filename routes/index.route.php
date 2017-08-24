<?php
/**
 * slim-boilerplate-code
 *
 * (c) Nazareth Gutiérrez http://jn6h.com
 * License: MIT
 */
$app->get('/', function() use ($app) {
  $app->render('index.html');
});