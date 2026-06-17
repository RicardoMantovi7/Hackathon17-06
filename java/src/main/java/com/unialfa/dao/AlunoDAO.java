package com.unialfa.dao;

import com.unialfa.model.Aluno;
import com.unialfa.util.DatabaseUtil;

import java.sql.*;
import java.util.ArrayList;
import java.util.List;

public class AlunoDAO implements GenericDAO<Aluno> {

    @Override
    public void inserir(Aluno aluno) {
        String sql = "INSERT INTO alunos (ra, nome, email, senha, curso, status_aptidao) VALUES (?, ?, ?, ?, ?, ?)";
        try (Connection conn = DatabaseUtil.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {
            stmt.setString(1, aluno.getRa());
            stmt.setString(2, aluno.getNome());
            stmt.setString(3, aluno.getEmail());
            stmt.setString(4, aluno.getSenha());
            stmt.setString(5, aluno.getCurso());
            stmt.setBoolean(6, aluno.isStatusAptidao());
            stmt.executeUpdate();
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    @Override
    public void atualizar(Aluno aluno) {
        String sql = "UPDATE alunos SET ra=?, nome=?, email=?, senha=?, curso=?, status_aptidao=? WHERE id=?";
        try (Connection conn = DatabaseUtil.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {
            stmt.setString(1, aluno.getRa());
            stmt.setString(2, aluno.getNome());
            stmt.setString(3, aluno.getEmail());
            stmt.setString(4, aluno.getSenha());
            stmt.setString(5, aluno.getCurso());
            stmt.setBoolean(6, aluno.isStatusAptidao());
            stmt.setInt(7, aluno.getId());
            stmt.executeUpdate();
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    @Override
    public void deletar(int id) {
        String sql = "DELETE FROM alunos WHERE id=?";
        try (Connection conn = DatabaseUtil.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {
            stmt.setInt(1, id);
            stmt.executeUpdate();
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    @Override
    public Aluno buscarPorId(int id) {
        String sql = "SELECT * FROM alunos WHERE id=?";
        try (Connection conn = DatabaseUtil.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {
            stmt.setInt(1, id);
            ResultSet rs = stmt.executeQuery();
            if (rs.next()) {
                Aluno aluno = new Aluno();
                aluno.setId(rs.getInt("id"));
                aluno.setRa(rs.getString("ra"));
                aluno.setNome(rs.getString("nome"));
                aluno.setEmail(rs.getString("email"));
                aluno.setSenha(rs.getString("senha"));
                aluno.setCurso(rs.getString("curso"));
                aluno.setStatusAptidao(rs.getBoolean("status_aptidao"));
                return aluno;
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return null;
    }

    @Override
    public List<Aluno> listarTodos() {
        List<Aluno> lista = new ArrayList<>();
        String sql = "SELECT * FROM alunos";
        try (Connection conn = DatabaseUtil.getConnection();
             Statement stmt = conn.createStatement();
             ResultSet rs = stmt.executeQuery(sql)) {
            while (rs.next()) {
                Aluno aluno = new Aluno();
                aluno.setId(rs.getInt("id"));
                aluno.setRa(rs.getString("ra"));
                aluno.setNome(rs.getString("nome"));
                aluno.setEmail(rs.getString("email"));
                aluno.setSenha(rs.getString("senha"));
                aluno.setCurso(rs.getString("curso"));
                aluno.setStatusAptidao(rs.getBoolean("status_aptidao"));
                lista.add(aluno);
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return lista;
    }

    public List<Aluno> buscarPorNomeOuRa(String termo) {
        List<Aluno> lista = new ArrayList<>();
        String sql = "SELECT * FROM alunos WHERE nome LIKE ? OR ra LIKE ?";
        try (Connection conn = DatabaseUtil.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {
            String pattern = "%" + termo + "%";
            stmt.setString(1, pattern);
            stmt.setString(2, pattern);
            ResultSet rs = stmt.executeQuery();
            while (rs.next()) {
                Aluno aluno = new Aluno();
                aluno.setId(rs.getInt("id"));
                aluno.setRa(rs.getString("ra"));
                aluno.setNome(rs.getString("nome"));
                aluno.setEmail(rs.getString("email"));
                aluno.setSenha(rs.getString("senha"));
                aluno.setCurso(rs.getString("curso"));
                aluno.setStatusAptidao(rs.getBoolean("status_aptidao"));
                lista.add(aluno);
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return lista;
    }
}
