<?php
// auto load
spl_autoload_extensions('.php');
function classLoader($class)
{
  $nomeArquivo = $class . '.php';
  $pastas = array('controller', 'model');
  foreach ($pastas as $pasta) {
    $arquivo = "{$pasta}/{$nomeArquivo}";
    if (file_exists($arquivo)) {
      require_once($arquivo);
    }
  }
}
spl_autoload_register('classLoader');
// Front Controller
class Aplicacao
{
  private static $app = "/NicoleWeb";
  public static function run()
  {
    $layout = new Template('view/layout.html');
    if (isset($_GET["class"])) {
      $class = $_GET["class"];
    } else {
      $class = "Inicio";
    }
    if (isset($_GET["method"])) {
      $method = $_GET["method"];
    } else {
      $method = "";
    }
    if (class_exists($class)) {
      $pagina = new $class();
      if (method_exists($pagina, $method)) {
        $pagina->$method();
      } else {
        $pagina->controller();
      }
      $layout->set("uri",self::$app);
      $layout->set('conteudo', $pagina->getMessage());
    }
    echo $layout->saida();
  }
}
Aplicacao::run();

//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 token git