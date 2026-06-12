package com.unialfa.gui;

import com.unialfa.model.Candidatura;
import com.unialfa.service.CandidaturaService;

import javax.swing.*;
import javax.swing.table.DefaultTableModel;
import java.awt.*;
import java.text.SimpleDateFormat;
import java.util.List;

public class ConsultaCandidaturasDialog extends JDialog {
    private CandidaturaService candidaturaService;
    private JTable table;
    private DefaultTableModel tableModel;
    private JTextField txtFiltro;

    public ConsultaCandidaturasDialog(JFrame parent, CandidaturaService candidaturaService) {
        super(parent, "Consulta de Candidaturas", true);
        this.candidaturaService = candidaturaService;
        setSize(900, 500);
        setLocationRelativeTo(parent);
        initComponents();
        carregarDados();
    }

    private void initComponents() {
        JPanel panelTop = new JPanel(new BorderLayout(10, 10));
        panelTop.setBorder(BorderFactory.createEmptyBorder(10, 10, 10, 10));

        txtFiltro = new JTextField();
        JButton btnBuscar = new JButton("Buscar");
        btnBuscar.addActionListener(e -> buscar());
        JPanel panelFiltro = new JPanel(new BorderLayout(5, 5));
        panelFiltro.add(new JLabel("Filtrar por aluno ou vaga:"), BorderLayout.WEST);
        panelFiltro.add(txtFiltro, BorderLayout.CENTER);
        panelFiltro.add(btnBuscar, BorderLayout.EAST);

        panelTop.add(panelFiltro, BorderLayout.NORTH);

        String[] colunas = {"ID", "Aluno", "Vaga", "Empresa", "Data", "Status"};
        tableModel = new DefaultTableModel(colunas, 0) {
            @Override
            public boolean isCellEditable(int row, int column) {
                return false;
            }
        };
        table = new JTable(tableModel);
        table.setSelectionMode(ListSelectionModel.SINGLE_SELECTION);
        JScrollPane scrollPane = new JScrollPane(table);
        panelTop.add(scrollPane, BorderLayout.CENTER);

        JPanel panelBotoes = new JPanel(new FlowLayout(FlowLayout.CENTER, 10, 10));
        JButton btnFechar = new JButton("Fechar");
        btnFechar.addActionListener(e -> dispose());
        panelBotoes.add(btnFechar);

        setLayout(new BorderLayout());
        add(panelTop, BorderLayout.CENTER);
        add(panelBotoes, BorderLayout.SOUTH);
    }

    private void carregarDados() {
        carregarDados(candidaturaService.listarTodos());
    }

    private void carregarDados(List<Candidatura> candidaturas) {
        tableModel.setRowCount(0);
        SimpleDateFormat sdf = new SimpleDateFormat("dd/MM/yyyy");
        for (Candidatura cand : candidaturas) {
            tableModel.addRow(new Object[]{
                    cand.getId(),
                    cand.getNomeAluno(),
                    cand.getTituloVaga(),
                    cand.getNomeEmpresa(),
                    sdf.format(cand.getDataCandidatura()),
                    cand.getStatus()
            });
        }
    }

    private void buscar() {
        String filtro = txtFiltro.getText().trim();
        if (filtro.isEmpty()) {
            carregarDados();
        } else {
            carregarDados(candidaturaService.buscarPorAlunoOuVaga(filtro));
        }
    }
}
