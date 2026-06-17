package com.unialfa.model;

import java.util.Date;

public class Vaga {
    private int id;
    private int empresaId;
    private String titulo;
    private String descricao;
    private String requisitos;
    private double valorBolsa;
    private String status;
    private Date createdAt;
    private int numeroCandidatos;
    private String nomeEmpresa;

    public Vaga() {}

    public Vaga(int empresaId, String titulo, String descricao, String requisitos, double valorBolsa, String status, Date createdAt) {
        this.empresaId = empresaId;
        this.titulo = titulo;
        this.descricao = descricao;
        this.requisitos = requisitos;
        this.valorBolsa = valorBolsa;
        this.status = status;
        this.createdAt = createdAt;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getEmpresaId() {
        return empresaId;
    }

    public void setEmpresaId(int empresaId) {
        this.empresaId = empresaId;
    }

    public String getTitulo() {
        return titulo;
    }

    public void setTitulo(String titulo) {
        this.titulo = titulo;
    }

    public String getDescricao() {
        return descricao;
    }

    public void setDescricao(String descricao) {
        this.descricao = descricao;
    }

    public String getRequisitos() {
        return requisitos;
    }

    public void setRequisitos(String requisitos) {
        this.requisitos = requisitos;
    }

    public double getValorBolsa() {
        return valorBolsa;
    }

    public void setValorBolsa(double valorBolsa) {
        this.valorBolsa = valorBolsa;
    }

    public String getStatus() {
        return status;
    }

    public void setStatus(String status) {
        this.status = status;
    }

    public Date getCreatedAt() {
        return createdAt;
    }

    public void setCreatedAt(Date createdAt) {
        this.createdAt = createdAt;
    }

    public int getNumeroCandidatos() {
        return numeroCandidatos;
    }

    public void setNumeroCandidatos(int numeroCandidatos) {
        this.numeroCandidatos = numeroCandidatos;
    }

    public String getNomeEmpresa() {
        return nomeEmpresa;
    }

    public void setNomeEmpresa(String nomeEmpresa) {
        this.nomeEmpresa = nomeEmpresa;
    }

    public String getResumo() {
        return "Vaga{" +
                "id=" + id +
                ", titulo='" + titulo + '\'' +
                ", empresa='" + nomeEmpresa + '\'' +
                ", status='" + status + '\'' +
                ", candidatos=" + numeroCandidatos +
                '}';
    }

    @Override
    public String toString() {
        return getResumo();
    }
}
