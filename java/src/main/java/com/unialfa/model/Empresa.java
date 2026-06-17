package com.unialfa.model;

public class Empresa {
    private int id;
    private String nome;
    private String cnpj;
    private String email;
    private String senha;
    private String cidade;
    private String status;

    public Empresa() {}

    public Empresa(String nome, String cnpj, String email, String senha, String cidade, String status) {
        this.nome = nome;
        this.cnpj = cnpj;
        this.email = email;
        this.senha = senha;
        this.cidade = cidade;
        this.status = status;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getNome() {
        return nome;
    }

    public void setNome(String nome) {
        this.nome = nome;
    }

    public String getCnpj() {
        return cnpj;
    }

    public void setCnpj(String cnpj) {
        this.cnpj = cnpj;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public String getSenha() {
        return senha;
    }

    public void setSenha(String senha) {
        this.senha = senha;
    }

    public String getCidade() {
        return cidade;
    }

    public void setCidade(String cidade) {
        this.cidade = cidade;
    }

    public String getStatus() {
        return status;
    }

    public void setStatus(String status) {
        this.status = status;
    }

    public String getResumo() {
        return "Empresa{" +
                "id=" + id +
                ", nome='" + nome + '\'' +
                ", cnpj='" + cnpj + '\'' +
                ", email='" + email + '\'' +
                ", cidade='" + cidade + '\'' +
                ", status='" + status + '\'' +
                '}';
    }

    @Override
    public String toString() {
        return getResumo();
    }
}
