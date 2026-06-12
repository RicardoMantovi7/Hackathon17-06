package com.unialfa.service;

import com.unialfa.dao.CandidaturaDAO;
import com.unialfa.model.Candidatura;

import java.util.List;

public class CandidaturaService {
    private CandidaturaDAO candidaturaDAO;

    public CandidaturaService() {
        this.candidaturaDAO = new CandidaturaDAO();
    }

    public void salvar(Candidatura candidatura) {
        if (candidatura.getId() == 0) {
            candidaturaDAO.inserir(candidatura);
        } else {
            candidaturaDAO.atualizar(candidatura);
        }
    }

    public void deletar(int id) {
        candidaturaDAO.deletar(id);
    }

    public Candidatura buscarPorId(int id) {
        return candidaturaDAO.buscarPorId(id);
    }

    public List<Candidatura> listarTodos() {
        return candidaturaDAO.listarTodos();
    }

    public List<Candidatura> buscarPorAlunoOuVaga(String termo) {
        return candidaturaDAO.buscarPorAlunoOuVaga(termo);
    }
}
