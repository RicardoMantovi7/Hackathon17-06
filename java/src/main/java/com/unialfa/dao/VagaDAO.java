package com.unialfa.dao;

import com.unialfa.model.Vaga;
import com.unialfa.util.DatabaseUtil;

import java.sql.*;
import java.util.ArrayList;
import java.util.List;

public class VagaDAO implements GenericDAO<Vaga> {

    @Override
    public void inserir(Vaga vaga) {
        String sql = "INSERT INTO vagas (empresa_id, titulo, descricao, requisitos, valor_bolsa, status) VALUES (?, ?, ?, ?, ?, ?)";
        try (Connection conn = DatabaseUtil.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {
            stmt.setInt(1, vaga.getEmpresaId());
            stmt.setString(2, vaga.getTitulo());
            stmt.setString(3, vaga.getDescricao());
            stmt.setString(4, vaga.getRequisitos());
            stmt.setDouble(5, vaga.getValorBolsa());
            stmt.setString(6, vaga.getStatus());
            stmt.executeUpdate();
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    @Override
    public void atualizar(Vaga vaga) {
        String sql = "UPDATE vagas SET empresa_id=?, titulo=?, descricao=?, requisitos=?, valor_bolsa=?, status=? WHERE id=?";
        try (Connection conn = DatabaseUtil.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {
            stmt.setInt(1, vaga.getEmpresaId());
            stmt.setString(2, vaga.getTitulo());
            stmt.setString(3, vaga.getDescricao());
            stmt.setString(4, vaga.getRequisitos());
            stmt.setDouble(5, vaga.getValorBolsa());
            stmt.setString(6, vaga.getStatus());
            stmt.setInt(7, vaga.getId());
            stmt.executeUpdate();
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    @Override
    public void deletar(int id) {
        String sql = "DELETE FROM vagas WHERE id=?";
        try (Connection conn = DatabaseUtil.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {
            stmt.setInt(1, id);
            stmt.executeUpdate();
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    @Override
    public Vaga buscarPorId(int id) {
        String sql = "SELECT v.*, e.nome as nome_empresa, " +
                "(SELECT COUNT(*) FROM candidaturas WHERE vaga_id = v.id) as numero_candidatos " +
                "FROM vagas v JOIN empresas e ON v.empresa_id = e.id WHERE v.id=?";
        try (Connection conn = DatabaseUtil.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {
            stmt.setInt(1, id);
            ResultSet rs = stmt.executeQuery();
            if (rs.next()) {
                Vaga vaga = new Vaga();
                vaga.setId(rs.getInt("id"));
                vaga.setEmpresaId(rs.getInt("empresa_id"));
                vaga.setTitulo(rs.getString("titulo"));
                vaga.setDescricao(rs.getString("descricao"));
                vaga.setRequisitos(rs.getString("requisitos"));
                vaga.setValorBolsa(rs.getDouble("valor_bolsa"));
                vaga.setStatus(rs.getString("status"));
                vaga.setCreatedAt(rs.getTimestamp("created_at"));
                vaga.setNomeEmpresa(rs.getString("nome_empresa"));
                vaga.setNumeroCandidatos(rs.getInt("numero_candidatos"));
                return vaga;
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return null;
    }

    @Override
    public List<Vaga> listarTodos() {
        List<Vaga> lista = new ArrayList<>();
        String sql = "SELECT v.*, e.nome as nome_empresa, " +
                "(SELECT COUNT(*) FROM candidaturas WHERE vaga_id = v.id) as numero_candidatos " +
                "FROM vagas v JOIN empresas e ON v.empresa_id = e.id";
        try (Connection conn = DatabaseUtil.getConnection();
             Statement stmt = conn.createStatement();
             ResultSet rs = stmt.executeQuery(sql)) {
            while (rs.next()) {
                Vaga vaga = new Vaga();
                vaga.setId(rs.getInt("id"));
                vaga.setEmpresaId(rs.getInt("empresa_id"));
                vaga.setTitulo(rs.getString("titulo"));
                vaga.setDescricao(rs.getString("descricao"));
                vaga.setRequisitos(rs.getString("requisitos"));
                vaga.setValorBolsa(rs.getDouble("valor_bolsa"));
                vaga.setStatus(rs.getString("status"));
                vaga.setCreatedAt(rs.getTimestamp("created_at"));
                vaga.setNomeEmpresa(rs.getString("nome_empresa"));
                vaga.setNumeroCandidatos(rs.getInt("numero_candidatos"));
                lista.add(vaga);
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return lista;
    }

    public List<Vaga> buscarPorTituloOuEmpresa(String termo) {
        List<Vaga> lista = new ArrayList<>();
        String sql = "SELECT v.*, e.nome as nome_empresa, " +
                "(SELECT COUNT(*) FROM candidaturas WHERE vaga_id = v.id) as numero_candidatos " +
                "FROM vagas v JOIN empresas e ON v.empresa_id = e.id " +
                "WHERE v.titulo LIKE ? OR e.nome LIKE ?";
        try (Connection conn = DatabaseUtil.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {
            String pattern = "%" + termo + "%";
            stmt.setString(1, pattern);
            stmt.setString(2, pattern);
            ResultSet rs = stmt.executeQuery();
            while (rs.next()) {
                Vaga vaga = new Vaga();
                vaga.setId(rs.getInt("id"));
                vaga.setEmpresaId(rs.getInt("empresa_id"));
                vaga.setTitulo(rs.getString("titulo"));
                vaga.setDescricao(rs.getString("descricao"));
                vaga.setRequisitos(rs.getString("requisitos"));
                vaga.setValorBolsa(rs.getDouble("valor_bolsa"));
                vaga.setStatus(rs.getString("status"));
                vaga.setCreatedAt(rs.getTimestamp("created_at"));
                vaga.setNomeEmpresa(rs.getString("nome_empresa"));
                vaga.setNumeroCandidatos(rs.getInt("numero_candidatos"));
                lista.add(vaga);
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return lista;
    }
}
