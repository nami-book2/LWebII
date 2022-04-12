<?php
class Tabela
{
    private $message = "";
    public function controller()
    {
        $this->massage = "Estou na class Tabela";
    }
    public function getMessage()
    {
        return $this->message;
    }
}