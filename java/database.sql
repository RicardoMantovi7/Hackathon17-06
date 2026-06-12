-- Criação do banco de dados
CREATE DATABASE IF NOT EXISTS portal_unialfa;
USE portal_unialfa;

-- Tabela de empresas
CREATE TABLE IF NOT EXISTS empresas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    cnpj VARCHAR(20) NOT NULL,
    email VARCHAR(255) NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'pendente'
);

-- Tabela de alunos
CREATE TABLE IF NOT EXISTS alunos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ra VARCHAR(20) NOT NULL UNIQUE,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    apto BOOLEAN NOT NULL DEFAULT TRUE
);

-- Tabela de vagas
CREATE TABLE IF NOT EXISTS vagas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    empresa_id INT NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    descricao TEXT,
    status VARCHAR(20) NOT NULL DEFAULT 'aberta',
    data_criacao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (empresa_id) REFERENCES empresas(id)
);

-- Tabela de candidaturas
CREATE TABLE IF NOT EXISTS candidaturas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    aluno_id INT NOT NULL,
    vaga_id INT NOT NULL,
    data_candidatura TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(20) NOT NULL DEFAULT 'pendente',
    FOREIGN KEY (aluno_id) REFERENCES alunos(id),
    FOREIGN KEY (vaga_id) REFERENCES vagas(id)
);

-- Dados de exemplo
INSERT INTO empresas (nome, cnpj, email, status) VALUES
('Tech Solutions Ltda', '12.345.678/0001-90', 'contato@techsolutions.com', 'ativa'),
('Inova Corp', '98.765.432/0001-10', 'rh@inovacorp.com', 'pendente'),
('Digital Factory', '11.222.333/0001-44', 'contato@digitalfactory.com', 'ativa');

INSERT INTO alunos (ra, nome, email, apto) VALUES
('2023001', 'João Silva', 'joao.silva@email.com', TRUE),
('2023002', 'Maria Santos', 'maria.santos@email.com', TRUE),
('2023003', 'Pedro Oliveira', 'pedro.oliveira@email.com', FALSE);

INSERT INTO vagas (empresa_id, titulo, descricao, status) VALUES
(1, 'Desenvolvedor Java', 'Vaga para desenvolvedor Java com experiência em Spring Boot', 'aberta'),
(1, 'Analista de Sistemas', 'Analista de sistemas com conhecimento em bancos de dados', 'aberta'),
(3, 'Estagiário de TI', 'Estágio para estudantes de ciência da computação', 'aberta');

INSERT INTO candidaturas (aluno_id, vaga_id, status) VALUES
(1, 1, 'pendente'),
(2, 1, 'aprovada'),
(2, 3, 'pendente');
