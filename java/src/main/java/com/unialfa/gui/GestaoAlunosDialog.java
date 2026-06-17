package com.unialfa.gui;

import com.unialfa.model.Aluno;
import com.unialfa.service.AlunoService;

import javax.swing.*;
import javax.swing.table.DefaultTableModel;
import java.awt.*;
import java.io.File;
import java.util.List;

public class GestaoAlunosDialog extends JDialog {
    private AlunoService alunoService;
    private JTable table;
    private DefaultTableModel tableModel;
    private JTextField txtFiltro;

    public GestaoAlunosDialog(JFrame parent, AlunoService alunoService) {
        super(parent, "Gestão de Alunos", true);
        this.alunoService = alunoService;
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
        panelFiltro.add(new JLabel("Filtrar por nome ou RA:"), BorderLayout.WEST);
        panelFiltro.add(txtFiltro, BorderLayout.CENTER);
        panelFiltro.add(btnBuscar, BorderLayout.EAST);

        panelTop.add(panelFiltro, BorderLayout.NORTH);

        String[] colunas = {"ID", "RA", "Nome", "Email", "Apto"};
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
        JButton btnNovo = new JButton("Novo Aluno");
        btnNovo.addActionListener(e -> novoAluno());
        JButton btnEditar = new JButton("Editar");
        btnEditar.addActionListener(e -> editarAluno());
        JButton btnExcluir = new JButton("Excluir");
        btnExcluir.addActionListener(e -> excluirAluno());
        JButton btnImportar = new JButton("Importar .txt");
        btnImportar.addActionListener(e -> importarArquivo());
        JButton btnFechar = new JButton("Fechar");
        btnFechar.addActionListener(e -> dispose());
        panelBotoes.add(btnNovo);
        panelBotoes.add(btnEditar);
        panelBotoes.add(btnExcluir);
        panelBotoes.add(btnImportar);
        panelBotoes.add(btnFechar);

        setLayout(new BorderLayout());
        add(panelTop, BorderLayout.CENTER);
        add(panelBotoes, BorderLayout.SOUTH);
    }

    private void carregarDados() {
        carregarDados(alunoService.listarTodos());
    }

    private void carregarDados(List<Aluno> alunos) {
        tableModel.setRowCount(0);
        for (Aluno aluno : alunos) {
            tableModel.addRow(new Object[]{
                    aluno.getId(),
                    aluno.getRa(),
                    aluno.getNome(),
                    aluno.getEmail(),
                    aluno.isStatusAptidao() ? "SIM" : "NÃO"
            });
        }
    }

    private void buscar() {
        String filtro = txtFiltro.getText().trim();
        if (filtro.isEmpty()) {
            carregarDados();
        } else {
            carregarDados(alunoService.buscarPorNomeOuRa(filtro));
        }
    }

    private void novoAluno() {
        AlunoFormDialog dialog = new AlunoFormDialog(this, null);
        dialog.setVisible(true);
        if (dialog.isSalvo()) {
            alunoService.salvar(dialog.getAluno());
            carregarDados();
        }
    }

    private void editarAluno() {
        int row = table.getSelectedRow();
        if (row >= 0) {
            int id = (int) tableModel.getValueAt(row, 0);
            Aluno aluno = alunoService.buscarPorId(id);
            AlunoFormDialog dialog = new AlunoFormDialog(this, aluno);
            dialog.setVisible(true);
            if (dialog.isSalvo()) {
                alunoService.salvar(dialog.getAluno());
                carregarDados();
            }
        } else {
            JOptionPane.showMessageDialog(this, "Selecione um aluno!");
        }
    }

    private void excluirAluno() {
        int row = table.getSelectedRow();
        if (row >= 0) {
            int confirm = JOptionPane.showConfirmDialog(this, "Deseja realmente excluir?", "Confirmação", JOptionPane.YES_NO_OPTION);
            if (confirm == JOptionPane.YES_OPTION) {
                int id = (int) tableModel.getValueAt(row, 0);
                alunoService.deletar(id);
                carregarDados();
            }
        } else {
            JOptionPane.showMessageDialog(this, "Selecione um aluno!");
        }
    }

    private void importarArquivo() {
        JFileChooser fileChooser = new JFileChooser();
        fileChooser.setDialogTitle("Selecione o arquivo .txt");
        int userSelection = fileChooser.showOpenDialog(this);
        if (userSelection == JFileChooser.APPROVE_OPTION) {
            File fileToOpen = fileChooser.getSelectedFile();
            try {
                alunoService.importarDeArquivo(fileToOpen);
                carregarDados();
                JOptionPane.showMessageDialog(this, "Importação realizada com sucesso!");
            } catch (Exception e) {
                JOptionPane.showMessageDialog(this, "Erro na importação: " + e.getMessage());
            }
        }
    }
}
