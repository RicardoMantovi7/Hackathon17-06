<?php

require_once __DIR__ . '/Usuario.php';

class Empresa extends Usuario {
    private string $cnpj;
    private string $telefone;
    private string $cidade;
    private string $status; // pendente | ativa | bloqueada

    public function __construct(
        int    $id,
        string $nome,
        string $email,
        string $cnpj     = '',
        string $telefone = '',
        string $cidade   = '',
        string $status   = 'pendente',
        string $senha    = ''
    ) {
        parent::__construct($id, $nome, $email, $senha);
        $this->cnpj     = $cnpj;
        $this->telefone = $telefone;
        $this->cidade   = $cidade;
        $this->status   = $status;
    }

    public function getCnpj():     string { return $this->cnpj; }
    public function getTelefone(): string { return $this->telefone; }
    public function getCidade():   string { return $this->cidade; }
    public function getStatus():   string { return $this->status; }

    public function isAtiva(): bool { return $this->status === 'ativa'; }

    public function getPerfil(): string {
        return "Empresa — {$this->nome} | CNPJ: {$this->cnpj} | {$this->cidade}";
    }

    public function getTipo(): string { return 'empresa'; }

    public static function fromArray(array $data): self {
        return new self(
            $data['id']       ?? 0,
            $data['nome']     ?? '',
            $data['email']    ?? '',
            $data['cnpj']     ?? '',
            $data['telefone'] ?? '',
            $data['cidade']   ?? '',
            $data['status']   ?? 'pendente'
        );
    }
}