package com.unialfa.gui;

import com.unialfa.model.Vaga;
import com.unialfa.service.VagaService;

import javax.swing.*;
import javax.swing.table.DefaultTableModel;
import java.awt.*;
import java.text.SimpleDateFormat;
import java.util.List;

public class ConsultaVagasDialog extends JDialog {
    private VagaService vagaService;
    private JTable table;
    private DefaultTableModel tableModel;
    private JTextField txtFiltro;

    public ConsultaVagasDialog(JFrame parent, VagaService vagaService) {
        super(parent, "Consulta de Vagas", true);
        this.vagaService = vagaService;
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
        panelFiltro.add(new JLabel("Filtrar por título ou empresa:"), BorderLayout.WEST);
        panelFiltro.add(txtFiltro, BorderLayout.CENTER);
        panelFiltro.add(btnBuscar, BorderLayout.EAST);

        panelTop.add(panelFiltro, BorderLayout.NORTH);

        String[] colunas = {"ID", "Título", "Empresa", "Status", "Candidatos", "Data Criação"};
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
        carregarDados(vagaService.listarTodos());
    }

    private void carregarDados(List<Vaga> vagas) {
        tableModel.setRowCount(0);
        SimpleDateFormat sdf = new SimpleDateFormat("dd/MM/yyyy");
        for (Vaga vaga : vagas) {
            tableModel.addRow(new Object[]{
                    vaga.getId(),
                    vaga.getTitulo(),
                    vaga.getNomeEmpresa(),
                    vaga.getStatus(),
                    vaga.getNumeroCandidatos(),
                    sdf.format(vaga.getCreatedAt())
            });
        }
    }

    private void buscar() {
        String filtro = txtFiltro.getText().trim();
        if (filtro.isEmpty()) {
            carregarDados();
        } else {
            carregarDados(vagaService.buscarPorTituloOuEmpresa(filtro));
        }
    }
}
