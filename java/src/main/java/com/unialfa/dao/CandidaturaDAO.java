package com.unialfa.dao;

import com.unialfa.model.Candidatura;
import com.unialfa.util.DatabaseUtil;

import java.sql.*;
import java.util.ArrayList;
import java.util.List;

public class CandidaturaDAO implements GenericDAO<Candidatura> {

    @Override
    public void inserir(Candidatura candidatura) {
        String sql = "INSERT INTO candidaturas (aluno_id, vaga_id, data_candidatura, status) VALUES (?, ?, ?, ?)";
        try (Connection conn = DatabaseUtil.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {
            stmt.setInt(1, candidatura.getAlunoId());
            stmt.setInt(2, candidatura.getVagaId());
            stmt.setTimestamp(3, new Timestamp(candidatura.getDataCandidatura().getTime()));
            stmt.setString(4, candidatura.getStatus());
            stmt.executeUpdate();
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    @Override
    public void atualizar(Candidatura candidatura) {
        String sql = "UPDATE candidaturas SET aluno_id=?, vaga_id=?, status=? WHERE id=?";
        try (Connection conn = DatabaseUtil.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {
            stmt.setInt(1, candidatura.getAlunoId());
            stmt.setInt(2, candidatura.getVagaId());
            stmt.setString(3, candidatura.getStatus());
            stmt.setInt(4, candidatura.getId());
            stmt.executeUpdate();
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    @Override
    public void deletar(int id) {
        String sql = "DELETE FROM candidaturas WHERE id=?";
        try (Connection conn = DatabaseUtil.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {
            stmt.setInt(1, id);
            stmt.executeUpdate();
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    @Override
    public Candidatura buscarPorId(int id) {
        String sql = "SELECT c.*, a.nome as nome_aluno, v.titulo as titulo_vaga, e.nome as nome_empresa " +
                "FROM candidaturas c " +
                "JOIN alunos a ON c.aluno_id = a.id " +
                "JOIN vagas v ON c.vaga_id = v.id " +
                "JOIN empresas e ON v.empresa_id = e.id " +
                "WHERE c.id=?";
        try (Connection conn = DatabaseUtil.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {
            stmt.setInt(1, id);
            ResultSet rs = stmt.executeQuery();
            if (rs.next()) {
                Candidatura cand = new Candidatura();
                cand.setId(rs.getInt("id"));
                cand.setAlunoId(rs.getInt("aluno_id"));
                cand.setVagaId(rs.getInt("vaga_id"));
                cand.setDataCandidatura(rs.getTimestamp("data_candidatura"));
                cand.setStatus(rs.getString("status"));
                cand.setNomeAluno(rs.getString("nome_aluno"));
                cand.setTituloVaga(rs.getString("titulo_vaga"));
                cand.setNomeEmpresa(rs.getString("nome_empresa"));
                return cand;
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return null;
    }

    @Override
    public List<Candidatura> listarTodos() {
        List<Candidatura> lista = new ArrayList<>();
        String sql = "SELECT c.*, a.nome as nome_aluno, v.titulo as titulo_vaga, e.nome as nome_empresa " +
                "FROM candidaturas c " +
                "JOIN alunos a ON c.aluno_id = a.id " +
                "JOIN vagas v ON c.vaga_id = v.id " +
                "JOIN empresas e ON v.empresa_id = e.id";
        try (Connection conn = DatabaseUtil.getConnection();
             Statement stmt = conn.createStatement();
             ResultSet rs = stmt.executeQuery(sql)) {
            while (rs.next()) {
                Candidatura cand = new Candidatura();
                cand.setId(rs.getInt("id"));
                cand.setAlunoId(rs.getInt("aluno_id"));
                cand.setVagaId(rs.getInt("vaga_id"));
                cand.setDataCandidatura(rs.getTimestamp("data_candidatura"));
                cand.setStatus(rs.getString("status"));
                cand.setNomeAluno(rs.getString("nome_aluno"));
                cand.setTituloVaga(rs.getString("titulo_vaga"));
                cand.setNomeEmpresa(rs.getString("nome_empresa"));
                lista.add(cand);
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return lista;
    }

    public List<Candidatura> buscarPorAlunoOuVaga(String termo) {
        List<Candidatura> lista = new ArrayList<>();
        String sql = "SELECT c.*, a.nome as nome_aluno, v.titulo as titulo_vaga, e.nome as nome_empresa " +
                "FROM candidaturas c " +
                "JOIN alunos a ON c.aluno_id = a.id " +
                "JOIN vagas v ON c.vaga_id = v.id " +
                "JOIN empresas e ON v.empresa_id = e.id " +
                "WHERE a.nome LIKE ? OR v.titulo LIKE ?";
        try (Connection conn = DatabaseUtil.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {
            String pattern = "%" + termo + "%";
            stmt.setString(1, pattern);
            stmt.setString(2, pattern);
            ResultSet rs = stmt.executeQuery();
            while (rs.next()) {
                Candidatura cand = new Candidatura();
                cand.setId(rs.getInt("id"));
                cand.setAlunoId(rs.getInt("aluno_id"));
                cand.setVagaId(rs.getInt("vaga_id"));
                cand.setDataCandidatura(rs.getTimestamp("data_candidatura"));
                cand.setStatus(rs.getString("status"));
                cand.setNomeAluno(rs.getString("nome_aluno"));
                cand.setTituloVaga(rs.getString("titulo_vaga"));
                cand.setNomeEmpresa(rs.getString("nome_empresa"));
                lista.add(cand);
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return lista;
    }
}
