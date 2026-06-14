<?php

class ApiClient {
    private string $baseUrl;
    private bool   $useMock;

    public function __construct(string $baseUrl = 'http://localhost:3000') {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->baseUrl = $baseUrl;
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

    // ── Autenticação ─────────────────────────────────────
    public function isLoggedIn(): bool {
        return !empty($_SESSION['token']);
    }

    public function getTipoLogado(): ?string {
        return $_SESSION['tipo'] ?? null;
    }

    public function getUsuarioLogado(): ?array {
        return $_SESSION['usuario'] ?? null;
    }

    public function logout(): void {
        unset($_SESSION['token'], $_SESSION['tipo'], $_SESSION['usuario']);
    }

    // tipo: 'aluno' ou 'empresa'
    public function login(string $tipo, string $email, string $senha): array {
        if ($this->useMock) {
            $_SESSION['token']   = 'mock-token';
            $_SESSION['tipo']    = $tipo;
            $_SESSION['usuario'] = ['id' => 1, 'nome' => 'Usuário Demo', 'email' => $email];
            return ['success' => true, 'data' => ['token' => 'mock-token']];
        }

        $result = $this->post("/auth/login/{$tipo}", ['email' => $email, 'senha' => $senha], false);

        if ($result['success'] ?? false) {
            $_SESSION['token']   = $result['data']['token'];
            $_SESSION['tipo']    = $tipo;
            $_SESSION['usuario'] = $result['data'][$tipo] ?? [];
        }
        return $result;
    }

    // tipo: 'aluno' ou 'empresa'
    public function register(string $tipo, array $dados): array {
        if ($this->useMock) {
            return ['success' => true, 'data' => ['id' => rand(10,99)]];
        }
        return $this->post("/auth/register/{$tipo}", $dados, false);
    }

// ── Dados de exemplo enquanto a API não está rodando ─────────
    private function getMock(string $rota): array {
        if (str_starts_with($rota, '/vagas/empresa/minhas')) {
            return ['success' => true, 'data' => [
                ['id'=>1,'titulo'=>'Estágio em Desenvolvimento Web','descricao'=>'Desenvolvimento de sistemas web com PHP e JavaScript.','requisitos'=>'Cursando Sistemas de Informação a partir do 2º período.','valorBolsa'=>800,'status'=>'aberta','empresaId'=>1],
            ]];
        }
        if (str_starts_with($rota, '/vagas')) {
            return ['success' => true, 'data' => [
                ['id'=>1,'titulo'=>'Estágio em Desenvolvimento Web','descricao'=>'Desenvolvimento de sistemas web com PHP e JavaScript.','requisitos'=>'Cursando Sistemas de Informação a partir do 2º período.','valorBolsa'=>800,'status'=>'aberta','empresaId'=>1,'empresa'=>['nome'=>'TechSoft Sistemas']],
                ['id'=>2,'titulo'=>'Estágio em Suporte de TI','descricao'=>'Atendimento e suporte técnico a usuários internos.','requisitos'=>'Conhecimento em redes e sistemas operacionais.','valorBolsa'=>700,'status'=>'aberta','empresaId'=>2,'empresa'=>['nome'=>'Cooperativa Alfa']],
                ['id'=>3,'titulo'=>'Estágio em Análise de Dados','descricao'=>'Apoio na análise e visualização de dados corporativos.','requisitos'=>'Excel avançado, noções de SQL.','valorBolsa'=>900,'status'=>'aberta','empresaId'=>3,'empresa'=>['nome'=>'Grupo Empresarial Norte PR']],
            ]];
        }
        if (str_starts_with($rota, '/candidaturas')) {
            return ['success' => true, 'data' => [
                ['id'=>1,'alunoId'=>1,'vagaId'=>1,'status'=>'pendente','dataCandidatura'=>'2026-06-10','vaga'=>['titulo'=>'Estágio em Desenvolvimento Web','empresa'=>['nome'=>'TechSoft Sistemas']]],
                ['id'=>2,'alunoId'=>1,'vagaId'=>2,'status'=>'aprovado','dataCandidatura'=>'2026-06-08','vaga'=>['titulo'=>'Estágio em Suporte de TI','empresa'=>['nome'=>'Cooperativa Alfa']]],
            ]];
        }
        return ['success' => true, 'data' => []];
    }
}