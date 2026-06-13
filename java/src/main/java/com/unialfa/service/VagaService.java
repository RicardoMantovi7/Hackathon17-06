package com.unialfa.service;

import com.unialfa.dao.VagaDAO;
import com.unialfa.model.Vaga;

import java.util.List;

public class VagaService {
    private VagaDAO vagaDAO;

    public VagaService() {
        this.vagaDAO = new VagaDAO();
    }

    public void salvar(Vaga vaga) {
        if (vaga.getId() == 0) {
            vagaDAO.inserir(vaga);
        } else {
            vagaDAO.atualizar(vaga);
        }
    }

    public void deletar(int id) {
        vagaDAO.deletar(id);
    }

    public Vaga buscarPorId(int id) {
        return vagaDAO.buscarPorId(id);
    }

    public List<Vaga> listarTodos() {
        return vagaDAO.listarTodos();
    }

    public List<Vaga> buscarPorTituloOuEmpresa(String termo) {
        return vagaDAO.buscarPorTituloOuEmpresa(termo);
    }
}
