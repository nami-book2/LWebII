<?php
class Tabela
{
  private $message = "";
  private $error = "";
  public function __construct()
  {
    Transaction::open();
  }
  public function controller()
  {
    try{
    Transaction::get();
    $documentos = new Crud("documentos");
    $resultado = $documentos->select();
    $tabela = new Template("view/tabela.html");
    if (is_array($resultado)) {
      $tabela->set("linha", $resultado);
      $this->message = $tabela->saida();
    } else{
      $this->message = $documentos->getMessage();
        $this->error = $documentos->getError();
    } 
  } catch (Exception $e) {
    $this->message = $e->getMessage();
    $this->error = true;
    }
  }
  public function remover()
  {
    if (isset($_GET["id"])) {
      try {
        $conexao = Transaction::get();
        $id = $conexao->quote($_GET["id"]);
        $documentos = new Crud("documentos");
        $documentos->delete("id=$id");
        $this->message = $documentos->getMessage();
        $this->error = $documentos->getError();
      } catch (Exception $e) {
        $this->message = $e->getMessage();
        $this->error = true;
      }
    } else {
      $this->message = "Faltando parâmetro!";
      $this->error = true;
    }
  }
  public function getMessage()
  {
    if (is_string($this->error)) {
      return $this->message;
    } else {
      $msg = new Template("view/msg.html");
      if ($this->error) {
        $msg->set("cor", "danger");
      } else {
        $msg->set("cor", "success");
      }
      $msg->set("msg", $this->message);
      $msg->set("uri", "?class=Tabela");
      return $msg->saida();
    }
  }
  public function __destruct()
  {
    Transaction::close();
  }
}