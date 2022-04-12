<?php
class Tabela
{
    private $message = "";
    public function controller()
    {
        $form = new Template("view/form.html");
        $this->massage = $form->saida;
    }
    public function getMessage()
    {
        return $this->message;
    }
}