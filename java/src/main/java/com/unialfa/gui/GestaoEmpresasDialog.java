package com.unialfa.gui;

import com.unialfa.model.Empresa;
import com.unialfa.service.EmpresaService;

import javax.swing.*;
import javax.swing.table.DefaultTableModel;
import java.awt.*;
import java.util.List;

public class GestaoEmpresasDialog extends JDialog {
    private EmpresaService empresaService;
    private JTable table;
    private DefaultTableModel tableModel;
    private JTextField txtFiltro;

    public GestaoEmpresasDialog(JFrame parent, EmpresaService empresaService) {
        super(parent, "Gestão de Empresas", true);
        this.empresaService = empresaService;
        setSize(800, 500);
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
        panelFiltro.add(new JLabel("Filtrar por nome:"), BorderLayout.WEST);
        panelFiltro.add(txtFiltro, BorderLayout.CENTER);
        panelFiltro.add(btnBuscar, BorderLayout.EAST);

        panelTop.add(panelFiltro, BorderLayout.NORTH);

        String[] colunas = {"ID", "Nome", "CNPJ", "Email", "Status"};
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
        JButton btnAprovar = new JButton("Aprovar");
        btnAprovar.addActionListener(e -> aprovar());
        JButton btnBloquear = new JButton("Bloquear");
        btnBloquear.addActionListener(e -> bloquear());
        JButton btnDetalhes = new JButton("Ver Detalhes");
        btnDetalhes.addActionListener(e -> verDetalhes());
        JButton btnFechar = new JButton("Fechar");
        btnFechar.addActionListener(e -> dispose());
        panelBotoes.add(btnAprovar);
        panelBotoes.add(btnBloquear);
        panelBotoes.add(btnDetalhes);
        panelBotoes.add(btnFechar);

        setLayout(new BorderLayout());
        add(panelTop, BorderLayout.CENTER);
        add(panelBotoes, BorderLayout.SOUTH);
    }

    private void carregarDados() {
        carregarDados(empresaService.listarTodos());
    }

    private void carregarDados(List<Empresa> empresas) {
        tableModel.setRowCount(0);
        for (Empresa emp : empresas) {
            tableModel.addRow(new Object[]{
                    emp.getId(),
                    emp.getNome(),
                    emp.getCnpj(),
                    emp.getEmail(),
                    emp.getStatus()
            });
        }
    }

    private void buscar() {
        String filtro = txtFiltro.getText().trim();
        if (filtro.isEmpty()) {
            carregarDados();
        } else {
            carregarDados(empresaService.buscarPorNome(filtro));
        }
    }

    private void aprovar() {
        int row = table.getSelectedRow();
        if (row >= 0) {
            int id = (int) tableModel.getValueAt(row, 0);
            empresaService.aprovar(id);
            carregarDados();
            JOptionPane.showMessageDialog(this, "Empresa aprovada com sucesso!");
        } else {
            JOptionPane.showMessageDialog(this, "Selecione uma empresa!");
        }
    }

    private void bloquear() {
        int row = table.getSelectedRow();
        if (row >= 0) {
            int id = (int) tableModel.getValueAt(row, 0);
            empresaService.bloquear(id);
            carregarDados();
            JOptionPane.showMessageDialog(this, "Empresa bloqueada com sucesso!");
        } else {
            JOptionPane.showMessageDialog(this, "Selecione uma empresa!");
        }
    }

    private void verDetalhes() {
        int row = table.getSelectedRow();
        if (row >= 0) {
            int id = (int) tableModel.getValueAt(row, 0);
            Empresa emp = empresaService.buscarPorId(id);
            JOptionPane.showMessageDialog(this,
                    "ID: " + emp.getId() + "\n" +
                            "Nome: " + emp.getNome() + "\n" +
                            "CNPJ: " + emp.getCnpj() + "\n" +
                            "Email: " + emp.getEmail() + "\n" +
                            "Status: " + emp.getStatus(),
                    "Detalhes da Empresa",
                    JOptionPane.INFORMATION_MESSAGE);
        } else {
            JOptionPane.showMessageDialog(this, "Selecione uma empresa!");
        }
    }
}
