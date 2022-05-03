
<?php
class Form
{
  private $message = "";
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
        $if (empty($_POST["id"])) {
          $documentos->insert("nome,descricao,datahora","$nome,$descricao,$datatime");
        } else {
          $id = $conexao->quote($_POST['id']);
          $documentos->update("nome=$nome,descricao=$descricao,datahora=$datatime", "id=$id");
        }
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
        $form = new Template("view/form.html");
        foreach ($resultado[0] as $cod => $datatime) {
          $form->set($cod, $datatime);
        }
        $this->message = $form->saida();
      } catch (Exception $e) {
        echo $e->getMessage();
      }
    }
  }

  public function getMessage()
  {
    return $this->message;
  }
  public function __destruct()
  {
    Transaction::close();
  }
}