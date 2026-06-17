package com.unialfa.service;

import com.unialfa.dao.EmpresaDAO;
import com.unialfa.model.Empresa;

import java.util.List;

public class EmpresaService {
    private EmpresaDAO empresaDAO;

    public EmpresaService() {
        this.empresaDAO = new EmpresaDAO();
    }

    public void salvar(Empresa empresa) {
        if (empresa.getId() == 0) {
            empresaDAO.inserir(empresa);
        } else {
            empresaDAO.atualizar(empresa);
        }
    }

    public void deletar(int id) {
        empresaDAO.deletar(id);
    }

    public Empresa buscarPorId(int id) {
        return empresaDAO.buscarPorId(id);
    }

    public List<Empresa> listarTodos() {
        return empresaDAO.listarTodos();
    }

    public List<Empresa> buscarPorNome(String nome) {
        return empresaDAO.buscarPorNome(nome);
    }

    public void aprovar(int id) {
        Empresa emp = empresaDAO.buscarPorId(id);
        if (emp != null) {
            emp.setStatus("aprovado");
            empresaDAO.atualizar(emp);
        }
    }

    public void bloquear(int id) {
        Empresa emp = empresaDAO.buscarPorId(id);
        if (emp != null) {
            emp.setStatus("bloqueado");
            empresaDAO.atualizar(emp);
        }
    }
}
