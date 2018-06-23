<?php

// TODO: to remove (for debug only)
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Database
class Db {
  private static $_instance = NULL;
  private function __construct() {}
  private function __clone() {}

  /**
   * Get the current instance of PDO
   */
  public static function getInstance() {
    if(!isset(self::$_instance)) {
      $pdoOptions[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
      self::$_instance = new PDO('mysql:host=localhost;dbname=test', 'root', '', $pdoOptions);
    }
    return self::$_instance;
  }
}

if(isset($_GET['controller'], $_GET['action'])) {
  $controller = $_GET['controller'];
  $action = $_GET['action'];
} else {
  // Open the default page
  $controller = 'pages';
  $action = 'home';
}

// Check the user connection
/// TODO: do better than just a global func
function g_isConnected() {
  return isset($_SESSION['id']);
}

// Redirect function
/// TODO: do better than just a global func
function g_redirect($controller, $action, $get = NULL) {
  $header = 'Location: /' . $controller . '/' . $action;
  if(NULL !== $get) {
    $header .= '?' . $get;
  }
  header($header);
  die();
}

session_start();
require_once('view/View.php');
require_once('routes.php');
$route = new Route($controller, $action);
$route->call();
$route->display();

?>
