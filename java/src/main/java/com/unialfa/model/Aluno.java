package com.unialfa.model;

public class Aluno extends Pessoa {
    private int id;
    private String ra;
    private String senha;
    private String curso;
    private boolean statusAptidao;

    public Aluno() {}

    public Aluno(String nome, String email, String ra, String senha, String curso, boolean statusAptidao) {
        super(nome, email);
        this.ra = ra;
        this.senha = senha;
        this.curso = curso;
        this.statusAptidao = statusAptidao;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getRa() {
        return ra;
    }

    public void setRa(String ra) {
        this.ra = ra;
    }

    public String getSenha() {
        return senha;
    }

    public void setSenha(String senha) {
        this.senha = senha;
    }

    public String getCurso() {
        return curso;
    }

    public void setCurso(String curso) {
        this.curso = curso;
    }

    public boolean isStatusAptidao() {
        return statusAptidao;
    }

    public void setStatusAptidao(boolean statusAptidao) {
        this.statusAptidao = statusAptidao;
    }

    @Override
    public String getResumo() {
        return "Aluno{" +
                "id=" + id +
                ", ra='" + ra + '\'' +
                ", nome='" + getNome() + '\'' +
                ", email='" + getEmail() + '\'' +
                ", curso='" + curso + '\'' +
                ", statusAptidao=" + statusAptidao +
                '}';
    }
}
