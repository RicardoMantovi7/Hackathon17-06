package com.unialfa.dao;

import java.util.List;

public interface GenericDAO<T> {
    void inserir(T entity);
    void atualizar(T entity);
    void deletar(int id);
    T buscarPorId(int id);
    List<T> listarTodos();
}
