package com.unialfa.model;

import java.util.Date;

public class Candidatura {
    private int id;
    private int alunoId;
    private int vagaId;
    private Date dataCandidatura;
    private String status;
    private String nomeAluno;
    private String tituloVaga;
    private String nomeEmpresa;

    public Candidatura() {}

    public Candidatura(int alunoId, int vagaId, Date dataCandidatura, String status) {
        this.alunoId = alunoId;
        this.vagaId = vagaId;
        this.dataCandidatura = dataCandidatura;
        this.status = status;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getAlunoId() {
        return alunoId;
    }

    public void setAlunoId(int alunoId) {
        this.alunoId = alunoId;
    }

    public int getVagaId() {
        return vagaId;
    }

    public void setVagaId(int vagaId) {
        this.vagaId = vagaId;
    }

    public Date getDataCandidatura() {
        return dataCandidatura;
    }

    public void setDataCandidatura(Date dataCandidatura) {
        this.dataCandidatura = dataCandidatura;
    }

    public String getStatus() {
        return status;
    }

    public void setStatus(String status) {
        this.status = status;
    }

    public String getNomeAluno() {
        return nomeAluno;
    }

    public void setNomeAluno(String nomeAluno) {
        this.nomeAluno = nomeAluno;
    }

    public String getTituloVaga() {
        return tituloVaga;
    }

    public void setTituloVaga(String tituloVaga) {
        this.tituloVaga = tituloVaga;
    }

    public String getNomeEmpresa() {
        return nomeEmpresa;
    }

    public void setNomeEmpresa(String nomeEmpresa) {
        this.nomeEmpresa = nomeEmpresa;
    }

    public String getResumo() {
        return "Candidatura{" +
                "id=" + id +
                ", aluno='" + nomeAluno + '\'' +
                ", vaga='" + tituloVaga + '\'' +
                ", empresa='" + nomeEmpresa + '\'' +
                ", status='" + status + '\'' +
                '}';
    }

    @Override
    public String toString() {
        return getResumo();
    }
}
