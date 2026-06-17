<?php

class ApiClient {
    private string $baseUrl;

    public function __construct(string $baseUrl = 'http://localhost:3000') {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->baseUrl = $baseUrl;
    }

    // ── Autenticação ───────────────────────────────────────
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

    public function login(string $tipo, string $email, string $senha): array {
        $result = $this->post("/auth/login/{$tipo}", ['email' => $email, 'senha' => $senha], false);

        if ($result['success'] ?? false) {
            $_SESSION['token']   = $result['data']['token'];
            $_SESSION['tipo']    = $tipo;
            $_SESSION['usuario'] = $result['data'][$tipo] ?? [];
        }
        return $result;
    }

    public function register(string $tipo, array $dados): array {
        return $this->post("/auth/register/{$tipo}", $dados, false);
    }

    // ── Requisições HTTP ──────────────────────────────────
    private function headers(bool $auth = true): array {
        $headers = ['Content-Type: application/json'];
        if ($auth && !empty($_SESSION['token'])) {
            $headers[] = 'Authorization: Bearer ' . $_SESSION['token'];
        }
        return $headers;
    }

    public function get(string $rota, bool $auth = true): array {
        $ch = curl_init($this->baseUrl . $rota);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 10,
            CURLOPT_HTTPHEADER     => $this->headers($auth),
        ]);
        $resp = curl_exec($ch);
        curl_close($ch);
        return json_decode($resp, true) ?? ['success' => false, 'data' => []];
    }

    public function post(string $rota, array $dados, bool $auth = true): array {
        $ch = curl_init($this->baseUrl . $rota);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode($dados),
            CURLOPT_HTTPHEADER     => $this->headers($auth),
            CURLOPT_TIMEOUT        => 10,
        ]);
        $resp = curl_exec($ch);
        curl_close($ch);
        return json_decode($resp, true) ?? ['success' => false];
    }

    public function put(string $rota, array $dados, bool $auth = true): array {
        $ch = curl_init($this->baseUrl . $rota);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => 'PUT',
            CURLOPT_POSTFIELDS     => json_encode($dados),
            CURLOPT_HTTPHEADER     => $this->headers($auth),
        ]);
        $resp = curl_exec($ch);
        curl_close($ch);
        return json_decode($resp, true) ?? ['success' => false];
    }

    public function delete(string $rota, bool $auth = true): array {
        $ch = curl_init($this->baseUrl . $rota);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => 'DELETE',
            CURLOPT_HTTPHEADER     => $this->headers($auth),
        ]);
        $resp = curl_exec($ch);
        curl_close($ch);
        return json_decode($resp, true) ?? ['success' => false];
    }
}
