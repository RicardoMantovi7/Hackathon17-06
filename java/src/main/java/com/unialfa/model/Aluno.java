package com.unialfa.model;

public class Aluno extends Pessoa {
    private int id;
    private String ra;
    private boolean apto;

    public Aluno() {}

    public Aluno(String nome, String email, String ra, boolean apto) {
        super(nome, email);
        this.ra = ra;
        this.apto = apto;
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

    public boolean isApto() {
        return apto;
    }

    public void setApto(boolean apto) {
        this.apto = apto;
    }

    @Override
    public String getResumo() {
        return "Aluno{" +
                "id=" + id +
                ", ra='" + ra + '\'' +
                ", nome='" + getNome() + '\'' +
                ", email='" + getEmail() + '\'' +
                ", apto=" + apto +
                '}';
    }
}
