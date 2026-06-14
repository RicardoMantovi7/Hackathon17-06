<?php

class ApiClient {
    private string $baseUrl;
    private bool   $useMock;

    public function __construct(string $baseUrl = 'http://localhost:3000') {
        $this->baseUrl = $baseUrl;
        // Se a API ainda não estiver rodando, usa dados de exemplo
        $this->useMock = !$this->apiDisponivel();
    }

    private function apiDisponivel(): bool {
        $ch = curl_init($this->baseUrl . '/vagas');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 2);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        $result = curl_exec($ch);
        $erro   = curl_errno($ch);
        curl_close($ch);
        return $erro === 0 && $result !== false;
    }

    public function get(string $rota): array {
        if ($this->useMock) return $this->getMock($rota);

        $ch = curl_init($this->baseUrl . $rota);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 10,
            CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
        ]);
        $resp = curl_exec($ch);
        curl_close($ch);
        return json_decode($resp, true) ?? ['success' => false, 'data' => []];
    }

    public function post(string $rota, array $dados): array {
        if ($this->useMock) return ['success' => true, 'data' => array_merge(['id' => rand(10,99)], $dados)];

        $ch = curl_init($this->baseUrl . $rota);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode($dados),
            CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
            CURLOPT_TIMEOUT        => 10,
        ]);
        $resp = curl_exec($ch);
        curl_close($ch);
        return json_decode($resp, true) ?? ['success' => false];
    }

    public function put(string $rota, array $dados): array {
        if ($this->useMock) return ['success' => true, 'data' => $dados];

        $ch = curl_init($this->baseUrl . $rota);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => 'PUT',
            CURLOPT_POSTFIELDS     => json_encode($dados),
            CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
        ]);
        $resp = curl_exec($ch);
        curl_close($ch);
        return json_decode($resp, true) ?? ['success' => false];
    }

    public function delete(string $rota): array {
        if ($this->useMock) return ['success' => true];

        $ch = curl_init($this->baseUrl . $rota);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => 'DELETE',
        ]);
        $resp = curl_exec($ch);
        curl_close($ch);
        return json_decode($resp, true) ?? ['success' => false];
    }

    // ── Dados de exemplo enquanto a API não está pronta ─────────
    private function getMock(string $rota): array {
        if (str_starts_with($rota, '/vagas')) {
            return ['success' => true, 'data' => [
                ['id'=>1,'titulo'=>'Estágio em Desenvolvimento Web','descricao'=>'Desenvolvimento de sistemas web com PHP e JavaScript.','requisitos'=>'Cursando Sistemas de Informação a partir do 2º período.','local'=>'Umuarama - PR','bolsa'=>'R$ 800,00','area'=>'Tecnologia','status'=>'aberta','empresa_id'=>1,'empresa_nome'=>'TechSoft Sistemas'],
                ['id'=>2,'titulo'=>'Estágio em Suporte de TI','descricao'=>'Atendimento e suporte técnico a usuários internos.','requisitos'=>'Conhecimento em redes e sistemas operacionais.','local'=>'Umuarama - PR','bolsa'=>'R$ 700,00','area'=>'Infraestrutura','status'=>'aberta','empresa_id'=>2,'empresa_nome'=>'Cooperativa Alfa'],
                ['id'=>3,'titulo'=>'Estágio em Análise de Dados','descricao'=>'Apoio na análise e visualização de dados corporativos.','requisitos'=>'Excel avançado, noções de SQL.','local'=>'Umuarama - PR','bolsa'=>'R$ 900,00','area'=>'Dados','status'=>'aberta','empresa_id'=>3,'empresa_nome'=>'Grupo Empresarial Norte PR'],
            ]];
        }
        if (str_starts_with($rota, '/candidaturas')) {
            return ['success' => true, 'data' => [
                ['id'=>1,'aluno_id'=>1,'aluno_nome'=>'João Silva','vaga_id'=>1,'vaga_titulo'=>'Estágio em Desenvolvimento Web','empresa_nome'=>'TechSoft Sistemas','status'=>'pendente','data_candidatura'=>'10/06/2026'],
                ['id'=>2,'aluno_id'=>1,'aluno_nome'=>'João Silva','vaga_id'=>2,'vaga_titulo'=>'Estágio em Suporte de TI','empresa_nome'=>'Cooperativa Alfa','status'=>'aprovada','data_candidatura'=>'08/06/2026'],
            ]];
        }
        return ['success' => true, 'data' => []];
    }
}