package com.unialfa.gui;

import com.unialfa.model.Aluno;

import javax.swing.*;
import java.awt.*;

public class AlunoFormDialog extends JDialog {
    private Aluno aluno;
    private boolean salvo;
    private JTextField txtRa, txtNome, txtEmail;
    private JCheckBox chkApto;

    public AlunoFormDialog(JDialog parent, Aluno aluno) {
        super(parent, aluno == null ? "Novo Aluno" : "Editar Aluno", true);
        this.aluno = aluno;
        this.salvo = false;
        setSize(400, 300);
        setLocationRelativeTo(parent);
        initComponents();
        if (aluno != null) {
            txtRa.setText(aluno.getRa());
            txtNome.setText(aluno.getNome());
            txtEmail.setText(aluno.getEmail());
            chkApto.setSelected(aluno.isApto());
        }
    }

    private void initComponents() {
        JPanel panel = new JPanel(new GridBagLayout());
        panel.setBorder(BorderFactory.createEmptyBorder(20, 20, 20, 20));
        GridBagConstraints gbc = new GridBagConstraints();
        gbc.insets = new Insets(5, 5, 5, 5);
        gbc.fill = GridBagConstraints.HORIZONTAL;

        gbc.gridx = 0; gbc.gridy = 0;
        panel.add(new JLabel("RA:"), gbc);
        gbc.gridx = 1; gbc.weightx = 1.0;
        txtRa = new JTextField(20);
        panel.add(txtRa, gbc);

        gbc.gridx = 0; gbc.gridy = 1; gbc.weightx = 0;
        panel.add(new JLabel("Nome:"), gbc);
        gbc.gridx = 1; gbc.weightx = 1.0;
        txtNome = new JTextField(20);
        panel.add(txtNome, gbc);

        gbc.gridx = 0; gbc.gridy = 2; gbc.weightx = 0;
        panel.add(new JLabel("Email:"), gbc);
        gbc.gridx = 1; gbc.weightx = 1.0;
        txtEmail = new JTextField(20);
        panel.add(txtEmail, gbc);

        gbc.gridx = 0; gbc.gridy = 3; gbc.weightx = 0;
        panel.add(new JLabel("Apto:"), gbc);
        gbc.gridx = 1; gbc.weightx = 1.0;
        chkApto = new JCheckBox();
        panel.add(chkApto, gbc);

        JPanel panelBotoes = new JPanel(new FlowLayout(FlowLayout.CENTER, 10, 10));
        JButton btnSalvar = new JButton("Salvar");
        btnSalvar.addActionListener(e -> salvar());
        JButton btnCancelar = new JButton("Cancelar");
        btnCancelar.addActionListener(e -> dispose());
        panelBotoes.add(btnSalvar);
        panelBotoes.add(btnCancelar);

        setLayout(new BorderLayout());
        add(panel, BorderLayout.CENTER);
        add(panelBotoes, BorderLayout.SOUTH);
    }

    private void salvar() {
        if (aluno == null) {
            aluno = new Aluno();
        }
        aluno.setRa(txtRa.getText().trim());
        aluno.setNome(txtNome.getText().trim());
        aluno.setEmail(txtEmail.getText().trim());
        aluno.setApto(chkApto.isSelected());
        salvo = true;
        dispose();
    }

    public boolean isSalvo() {
        return salvo;
    }

    public Aluno getAluno() {
        return aluno;
    }
}
