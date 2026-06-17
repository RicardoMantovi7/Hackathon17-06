package com.unialfa.service;

import com.unialfa.dao.AlunoDAO;
import com.unialfa.model.Aluno;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.util.List;

public class AlunoService {
    private AlunoDAO alunoDAO;

    public AlunoService() {
        this.alunoDAO = new AlunoDAO();
    }

    public void salvar(Aluno aluno) {
        if (aluno.getId() == 0) {
            alunoDAO.inserir(aluno);
        } else {
            alunoDAO.atualizar(aluno);
        }
    }

    public void deletar(int id) {
        alunoDAO.deletar(id);
    }

    public Aluno buscarPorId(int id) {
        return alunoDAO.buscarPorId(id);
    }

    public List<Aluno> listarTodos() {
        return alunoDAO.listarTodos();
    }

    public List<Aluno> buscarPorNomeOuRa(String termo) {
        return alunoDAO.buscarPorNomeOuRa(termo);
    }

    public void importarDeArquivo(File arquivo) throws Exception {
        try (BufferedReader br = new BufferedReader(new FileReader(arquivo))) {
            String linha;
            while ((linha = br.readLine()) != null) {
                String[] dados = linha.split(";");
                if (dados.length >= 3) {
                    Aluno aluno = new Aluno();
                    aluno.setRa(dados[0].trim());
                    aluno.setNome(dados[1].trim());
                    aluno.setEmail(dados[2].trim());
                    aluno.setStatusAptidao(true);
                    alunoDAO.inserir(aluno);
                }
            }
        }
    }
}
