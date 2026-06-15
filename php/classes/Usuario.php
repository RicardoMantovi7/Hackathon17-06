<?php

abstract class Usuario {
    protected int    $id;
    protected string $nome;
    protected string $email;
    protected string $senha;

    public function __construct(int $id, string $nome, string $email, string $senha = '') {
        $this->id    = $id;
        $this->nome  = $nome;
        $this->email = $email;
        $this->senha = $senha;
    }

    public function getId():    int    { return $this->id; }
    public function getNome():  string { return $this->nome; }
    public function getEmail(): string { return $this->email; }

    public function setNome(string $nome):   void { $this->nome  = $nome; }
    public function setEmail(string $email): void { $this->email = $email; }

    // Polimorfismo — cada subclasse implementa do seu jeito
    abstract public function getPerfil(): string;
    abstract public function getTipo():   string;
}