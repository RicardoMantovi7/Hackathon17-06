<?php

class Vaga {
    private int     $id;
    private string  $titulo;
    private string  $descricao;
    private string  $requisitos;
    private float   $valorBolsa;
    private string  $status;     // aberta | fechada
    private int     $empresaId;
    private string  $empresaNome;

    public function __construct(
        int    $id,
        string $titulo,
        string $descricao   = '',
        string $requisitos  = '',
        float  $valorBolsa  = 0,
        string $status      = 'aberta',
        int    $empresaId   = 0,
        string $empresaNome = ''
    ) {
        $this->id          = $id;
        $this->titulo      = $titulo;
        $this->descricao   = $descricao;
        $this->requisitos  = $requisitos;
        $this->valorBolsa  = $valorBolsa;
        $this->status      = $status;
        $this->empresaId   = $empresaId;
        $this->empresaNome = $empresaNome;
    }

    public function getId():          int    { return $this->id; }
    public function getTitulo():      string { return $this->titulo; }
    public function getDescricao():   string { return $this->descricao; }
    public function getRequisitos():  string { return $this->requisitos; }
    public function getValorBolsa():  float  { return $this->valorBolsa; }
    public function getStatus():      string { return $this->status; }
    public function getEmpresaId():   int    { return $this->empresaId; }
    public function getEmpresaNome(): string { return $this->empresaNome; }

    public function getBolsaFormatada(bool $comSimbolo = true): string {
        if ($this->valorBolsa <= 0) {
            return '';
        }
        $valor = number_format($this->valorBolsa, 2, ',', '.');
        return $comSimbolo ? 'R$ ' . $valor : $valor;
    }

    public function isAberta(): bool { return $this->status === 'aberta'; }

    public static function fromArray(array $data): self {
        return new self(
            $data['id']         ?? 0,
            $data['titulo']     ?? '',
            $data['descricao']  ?? '',
            $data['requisitos'] ?? '',
            (float)($data['valorBolsa'] ?? 0),
            $data['status']     ?? 'aberta',
            $data['empresaId']  ?? 0,
            $data['empresa']['nome'] ?? ($data['empresaNome'] ?? '')
        );
    }
}