
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
        $resultado = $documentos->insert("nome,descricao,datahora", "$nome,$descricao,$datatime");
      }catch (Exception $e) {
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