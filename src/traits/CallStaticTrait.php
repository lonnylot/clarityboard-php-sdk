<?php

namespace Clarityboard\Traits;

use Exception;

trait CallStaticTrait {
  protected static $instance = null;

  public static function reset() {
    if (!is_null(self::$instance)) {
      self::$instance = null;
    }
  }

  public static function __callStatic($name, $arguments) {
    if (method_exists(self::class, $name)) {
      return call_user_func_array([self::getInstance(), $name], $arguments);
    }

    throw new Exception('"'.$name.'" method does not exist on '.self::class);
  }

  public static function getInstance() {
    if (is_null(self::$instance)) {
      self::$instance = new self;
    }

    return self::$instance;
  }
}
