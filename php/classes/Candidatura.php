<?php

class Candidatura {
    private int    $id;
    private int    $alunoId;
    private int    $vagaId;
    private string $vagaTitulo;
    private string $empresaNome;
    private string $status;      // pendente | em_analise | aprovado | reprovado
    private string $dataCandidatura;

    public function __construct(
        int    $id,
        int    $alunoId,
        int    $vagaId,
        string $vagaTitulo      = '',
        string $empresaNome     = '',
        string $status          = 'pendente',
        string $dataCandidatura = ''
    ) {
        $this->id              = $id;
        $this->alunoId         = $alunoId;
        $this->vagaId          = $vagaId;
        $this->vagaTitulo      = $vagaTitulo;
        $this->empresaNome     = $empresaNome;
        $this->status          = $status;
        $this->dataCandidatura = $dataCandidatura;
    }

    public function getId():              int    { return $this->id; }
    public function getAlunoId():         int    { return $this->alunoId; }
    public function getVagaId():          int    { return $this->vagaId; }
    public function getVagaTitulo():      string { return $this->vagaTitulo; }
    public function getEmpresaNome():     string { return $this->empresaNome; }
    public function getStatus():          string { return $this->status; }

    public function getDataFormatada(): string {
        if (empty($this->dataCandidatura)) return '-';
        $ts = strtotime($this->dataCandidatura);
        return $ts ? date('d/m/Y', $ts) : $this->dataCandidatura;
    }

    public function getStatusLabel(): string {
        return match($this->status) {
            'em_analise' => 'Em Análise',
            'aprovado'   => 'Aprovado',
            'reprovado'  => 'Reprovado',
            default      => 'Pendente',
        };
    }

    public function getStatusBadge(): string {
        return match($this->status) {
            'em_analise' => '<span class="badge badge-pendente">Em Análise</span>',
            'aprovado'   => '<span class="badge badge-sucesso">Aprovado</span>',
            'reprovado'  => '<span class="badge badge-erro">Reprovado</span>',
            default      => '<span class="badge badge-pendente">Pendente</span>',
        };
    }

    public static function fromArray(array $data): self {
        return new self(
            $data['id']              ?? 0,
            $data['alunoId']         ?? 0,
            $data['vagaId']          ?? 0,
            $data['vaga']['titulo']            ?? '',
            $data['vaga']['empresa']['nome']   ?? '',
            $data['status']          ?? 'pendente',
            $data['dataCandidatura'] ?? ''
        );
    }
}