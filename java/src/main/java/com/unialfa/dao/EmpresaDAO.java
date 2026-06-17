package com.unialfa.dao;

import com.unialfa.model.Empresa;
import com.unialfa.util.DatabaseUtil;

import java.sql.*;
import java.util.ArrayList;
import java.util.List;

public class EmpresaDAO implements GenericDAO<Empresa> {

    @Override
    public void inserir(Empresa empresa) {
        String sql = "INSERT INTO empresas (nome, cnpj, email, senha, cidade, status) VALUES (?, ?, ?, ?, ?, ?)";
        try (Connection conn = DatabaseUtil.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {
            stmt.setString(1, empresa.getNome());
            stmt.setString(2, empresa.getCnpj());
            stmt.setString(3, empresa.getEmail());
            stmt.setString(4, empresa.getSenha());
            stmt.setString(5, empresa.getCidade());
            stmt.setString(6, empresa.getStatus());
            stmt.executeUpdate();
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    @Override
    public void atualizar(Empresa empresa) {
        String sql = "UPDATE empresas SET nome=?, cnpj=?, email=?, senha=?, cidade=?, status=? WHERE id=?";
        try (Connection conn = DatabaseUtil.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {
            stmt.setString(1, empresa.getNome());
            stmt.setString(2, empresa.getCnpj());
            stmt.setString(3, empresa.getEmail());
            stmt.setString(4, empresa.getSenha());
            stmt.setString(5, empresa.getCidade());
            stmt.setString(6, empresa.getStatus());
            stmt.setInt(7, empresa.getId());
            stmt.executeUpdate();
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    @Override
    public void deletar(int id) {
        String sql = "DELETE FROM empresas WHERE id=?";
        try (Connection conn = DatabaseUtil.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {
            stmt.setInt(1, id);
            stmt.executeUpdate();
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    @Override
    public Empresa buscarPorId(int id) {
        String sql = "SELECT * FROM empresas WHERE id=?";
        try (Connection conn = DatabaseUtil.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {
            stmt.setInt(1, id);
            ResultSet rs = stmt.executeQuery();
            if (rs.next()) {
                Empresa emp = new Empresa();
                emp.setId(rs.getInt("id"));
                emp.setNome(rs.getString("nome"));
                emp.setCnpj(rs.getString("cnpj"));
                emp.setEmail(rs.getString("email"));
                emp.setSenha(rs.getString("senha"));
                emp.setCidade(rs.getString("cidade"));
                emp.setStatus(rs.getString("status"));
                return emp;
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return null;
    }

    @Override
    public List<Empresa> listarTodos() {
        List<Empresa> lista = new ArrayList<>();
        String sql = "SELECT * FROM empresas";
        try (Connection conn = DatabaseUtil.getConnection();
             Statement stmt = conn.createStatement();
             ResultSet rs = stmt.executeQuery(sql)) {
            while (rs.next()) {
                Empresa emp = new Empresa();
                emp.setId(rs.getInt("id"));
                emp.setNome(rs.getString("nome"));
                emp.setCnpj(rs.getString("cnpj"));
                emp.setEmail(rs.getString("email"));
                emp.setSenha(rs.getString("senha"));
                emp.setCidade(rs.getString("cidade"));
                emp.setStatus(rs.getString("status"));
                lista.add(emp);
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return lista;
    }

    public List<Empresa> buscarPorNome(String nome) {
        List<Empresa> lista = new ArrayList<>();
        String sql = "SELECT * FROM empresas WHERE nome LIKE ?";
        try (Connection conn = DatabaseUtil.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {
            stmt.setString(1, "%" + nome + "%");
            ResultSet rs = stmt.executeQuery();
            while (rs.next()) {
                Empresa emp = new Empresa();
                emp.setId(rs.getInt("id"));
                emp.setNome(rs.getString("nome"));
                emp.setCnpj(rs.getString("cnpj"));
                emp.setEmail(rs.getString("email"));
                emp.setSenha(rs.getString("senha"));
                emp.setCidade(rs.getString("cidade"));
                emp.setStatus(rs.getString("status"));
                lista.add(emp);
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return lista;
    }
}
