<?php

require_once __DIR__ . '/Usuario.php';

class Aluno extends Usuario {
    private string $ra;
    private string $curso;
    private string $periodo;
    private bool   $apto;

    public function __construct(
        int    $id,
        string $nome,
        string $email,
        string $ra,
        string $curso   = '',
        string $periodo = '',
        bool   $apto    = true,
        string $senha   = ''
    ) {
        parent::__construct($id, $nome, $email, $senha);
        $this->ra      = $ra;
        $this->curso   = $curso;
        $this->periodo = $periodo;
        $this->apto    = $apto;
    }

    public function getRa():      string { return $this->ra; }
    public function getCurso():   string { return $this->curso; }
    public function getPeriodo(): string { return $this->periodo; }
    public function isApto():     bool   { return $this->apto; }

    public function setApto(bool $apto): void { $this->apto = $apto; }

    public function getPerfil(): string {
        return "Aluno — {$this->nome} | RA: {$this->ra} | {$this->curso}";
    }

    public function getTipo(): string { return 'aluno'; }

    // Cria objeto Aluno a partir de array da API
    public static function fromArray(array $data): self {
        return new self(
            $data['id']      ?? 0,
            $data['nome']    ?? '',
            $data['email']   ?? '',
            $data['ra']      ?? '',
            $data['curso']   ?? '',
            $data['periodo'] ?? '',
            $data['apto']    ?? true
        );
    }
}