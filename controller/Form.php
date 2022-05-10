<?php
class Form
{
  private $message = "";
  private $error = "";
  public function __construct()
  {
    Transaction::open();
  }
  public function controller()
  {
    $form = new Template("view/form.html");
    $form->set("id", "");
    $form->set("name", "");
    $form->set("descricao", "");
    $form->set("datatime", "");
    $this->message = $form->saida();
  }
  public function salvar()
  {
    if (isset($_POST['nome']) && isset($_POST['descricao']) && isset($_POST['datatime'])) {
      try {
        $conexao = Transaction::get();
        $documentos = new Crud('documentos');
        $nome = $conexao->quote($_POST['nome']);
        $descricao = $conexao->quote($_POST['descricao']);
        $datatime = $conexao->quote($_POST['datatime']);
        if (empty($_POST["id"])) {
          $documentos->insert("nome,descricao,datahora", "$nome,$descricao,$datatime");
        } else {
          $id = $conexao->quote($_POST['id']);
          $documentos->update("nome=$nome,descricao=$descricao,datahora=$datatime", "id=$id");
        }
        $this->message = $documentos->getMessage();
        $this->error = $documentos->getError();
      }catch (Exception $e) {
        echo $e->getMessage();
      }
    }
  }
  public function editar()
  {
    if (isset($_GET['id'])) {
      try {
        $conexao = Transaction::get();
        $id = $conexao->quote($_GET['id']);
        $documentos = new Crud('documentos');
        $resultado = $documentos->select("*", "id=$id");
        if (!$documentos->getError()) {
          $form = new Template("view/form.html");
        foreach ($resultado[0] as $cod => $datatime) {
          $form->set($cod, $datatime);
        }
        $this->message = $form->saida();
      } else {
        $this->message = $documentos->getMessage();
        $this->error = true;
      }
    } catch (Exception $e) {
      $this->message = $e->getMessage();
      $this->error = true;
    }
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