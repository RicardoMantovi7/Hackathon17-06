package com.unialfa.util;

import com.unialfa.model.Aluno;
import com.unialfa.model.Candidatura;
import com.unialfa.model.Empresa;
import com.unialfa.model.Vaga;

import javax.swing.*;
import java.io.BufferedWriter;
import java.io.File;
import java.io.FileWriter;
import java.io.IOException;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.List;

public class RelatorioUtil {
    private static final SimpleDateFormat sdf = new SimpleDateFormat("dd/MM/yyyy HH:mm:ss");

    public static void gerarRelatorioEmpresas(List<Empresa> empresas) {
        JFileChooser fileChooser = new JFileChooser();
        fileChooser.setDialogTitle("Salvar Relatório de Empresas");
        int userSelection = fileChooser.showSaveDialog(null);

        if (userSelection == JFileChooser.APPROVE_OPTION) {
            File fileToSave = fileChooser.getSelectedFile();
            try (BufferedWriter writer = new BufferedWriter(new FileWriter(fileToSave))) {
                writer.write("=======================================\n");
                writer.write("        RELATÓRIO DE EMPRESAS          \n");
                writer.write("=======================================\n");
                writer.write("Data de geração: " + sdf.format(new Date()) + "\n\n");
                writer.write(String.format("%-5s %-30s %-20s %-15s %-10s\n", "ID", "Nome", "CNPJ", "Email", "Status"));
                writer.write("--------------------------------------------------------------------------------\n");

                for (Empresa emp : empresas) {
                    writer.write(String.format("%-5d %-30s %-20s %-15s %-10s\n",
                            emp.getId(),
                            emp.getNome(),
                            emp.getCnpj(),
                            emp.getEmail(),
                            emp.getStatus()));
                }

                writer.write("\n=======================================\n");
                writer.write("Total de empresas: " + empresas.size() + "\n");
                JOptionPane.showMessageDialog(null, "Relatório gerado com sucesso!");
            } catch (IOException e) {
                JOptionPane.showMessageDialog(null, "Erro ao gerar relatório: " + e.getMessage());
            }
        }
    }

    public static void gerarRelatorioAlunos(List<Aluno> alunos) {
        JFileChooser fileChooser = new JFileChooser();
        fileChooser.setDialogTitle("Salvar Relatório de Alunos");
        int userSelection = fileChooser.showSaveDialog(null);

        if (userSelection == JFileChooser.APPROVE_OPTION) {
            File fileToSave = fileChooser.getSelectedFile();
            try (BufferedWriter writer = new BufferedWriter(new FileWriter(fileToSave))) {
                writer.write("=======================================\n");
                writer.write("          RELATÓRIO DE ALUNOS          \n");
                writer.write("=======================================\n");
                writer.write("Data de geração: " + sdf.format(new Date()) + "\n\n");
                writer.write(String.format("%-5s %-15s %-30s %-30s %-10s\n", "ID", "RA", "Nome", "Email", "Apto"));
                writer.write("--------------------------------------------------------------------------------\n");

                for (Aluno aluno : alunos) {
                    writer.write(String.format("%-5d %-15s %-30s %-30s %-10s\n",
                            aluno.getId(),
                            aluno.getRa(),
                            aluno.getNome(),
                            aluno.getEmail(),
                            aluno.isStatusAptidao() ? "SIM" : "NÃO"));
                }

                writer.write("\n=======================================\n");
                writer.write("Total de alunos: " + alunos.size() + "\n");
                JOptionPane.showMessageDialog(null, "Relatório gerado com sucesso!");
            } catch (IOException e) {
                JOptionPane.showMessageDialog(null, "Erro ao gerar relatório: " + e.getMessage());
            }
        }
    }

    public static void gerarRelatorioVagas(List<Vaga> vagas) {
        JFileChooser fileChooser = new JFileChooser();
        fileChooser.setDialogTitle("Salvar Relatório de Vagas");
        int userSelection = fileChooser.showSaveDialog(null);

        if (userSelection == JFileChooser.APPROVE_OPTION) {
            File fileToSave = fileChooser.getSelectedFile();
            try (BufferedWriter writer = new BufferedWriter(new FileWriter(fileToSave))) {
                writer.write("=======================================\n");
                writer.write("           RELATÓRIO DE VAGAS          \n");
                writer.write("=======================================\n");
                writer.write("Data de geração: " + sdf.format(new Date()) + "\n\n");
                writer.write(String.format("%-5s %-30s %-30s %-15s %-10s\n", "ID", "Título", "Empresa", "Status", "Candidatos"));
                writer.write("--------------------------------------------------------------------------------\n");

                for (Vaga vaga : vagas) {
                    writer.write(String.format("%-5d %-30s %-30s %-15s %-10d\n",
                            vaga.getId(),
                            vaga.getTitulo(),
                            vaga.getNomeEmpresa(),
                            vaga.getStatus(),
                            vaga.getNumeroCandidatos()));
                }

                writer.write("\n=======================================\n");
                writer.write("Total de vagas: " + vagas.size() + "\n");
                JOptionPane.showMessageDialog(null, "Relatório gerado com sucesso!");
            } catch (IOException e) {
                JOptionPane.showMessageDialog(null, "Erro ao gerar relatório: " + e.getMessage());
            }
        }
    }

    public static void gerarRelatorioCandidaturas(List<Candidatura> candidaturas) {
        JFileChooser fileChooser = new JFileChooser();
        fileChooser.setDialogTitle("Salvar Relatório de Candidaturas");
        int userSelection = fileChooser.showSaveDialog(null);

        if (userSelection == JFileChooser.APPROVE_OPTION) {
            File fileToSave = fileChooser.getSelectedFile();
            try (BufferedWriter writer = new BufferedWriter(new FileWriter(fileToSave))) {
                writer.write("=======================================\n");
                writer.write("       RELATÓRIO DE CANDIDATURAS       \n");
                writer.write("=======================================\n");
                writer.write("Data de geração: " + sdf.format(new Date()) + "\n\n");
                writer.write(String.format("%-5s %-20s %-20s %-20s %-15s %-15s\n", "ID", "Aluno", "Vaga", "Empresa", "Data", "Status"));
                writer.write("--------------------------------------------------------------------------------\n");

                SimpleDateFormat dataCand = new SimpleDateFormat("dd/MM/yyyy");
                for (Candidatura cand : candidaturas) {
                    writer.write(String.format("%-5d %-20s %-20s %-20s %-15s %-15s\n",
                            cand.getId(),
                            cand.getNomeAluno(),
                            cand.getTituloVaga(),
                            cand.getNomeEmpresa(),
                            dataCand.format(cand.getDataCandidatura()),
                            cand.getStatus()));
                }

                writer.write("\n=======================================\n");
                writer.write("Total de candidaturas: " + candidaturas.size() + "\n");
                JOptionPane.showMessageDialog(null, "Relatório gerado com sucesso!");
            } catch (IOException e) {
                JOptionPane.showMessageDialog(null, "Erro ao gerar relatório: " + e.getMessage());
            }
        }
    }
}
