package com.unialfa.gui;

import com.unialfa.util.RelatorioUtil;
import com.unialfa.service.*;

import javax.swing.*;
import java.awt.*;

public class MainFrame extends JFrame {
    private EmpresaService empresaService;
    private AlunoService alunoService;
    private VagaService vagaService;
    private CandidaturaService candidaturaService;

    public MainFrame() {
        this.empresaService = new EmpresaService();
        this.alunoService = new AlunoService();
        this.vagaService = new VagaService();
        this.candidaturaService = new CandidaturaService();

        setTitle("Portal UniALFA - Gestão");
        setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        setSize(900, 600);
        setLocationRelativeTo(null);

        createMenuBar();

        JPanel painelPrincipal = new JPanel(new BorderLayout());
        JLabel labelBemVindo = new JLabel("Bem-vindo ao Portal de Gestão UniALFA", SwingConstants.CENTER);
        labelBemVindo.setFont(new Font("Arial", Font.BOLD, 24));
        painelPrincipal.add(labelBemVindo, BorderLayout.CENTER);

        add(painelPrincipal);
    }

    private void createMenuBar() {
        JMenuBar menuBar = new JMenuBar();

        JMenu menuEmpresas = new JMenu("Empresas");
        JMenuItem itemGestaoEmpresas = new JMenuItem("Gestão de Empresas");
        itemGestaoEmpresas.addActionListener(e -> new GestaoEmpresasDialog(this, empresaService).setVisible(true));
        menuEmpresas.add(itemGestaoEmpresas);

        JMenu menuAlunos = new JMenu("Alunos");
        JMenuItem itemGestaoAlunos = new JMenuItem("Gestão de Alunos");
        itemGestaoAlunos.addActionListener(e -> new GestaoAlunosDialog(this, alunoService).setVisible(true));
        menuAlunos.add(itemGestaoAlunos);

        JMenu menuVagas = new JMenu("Vagas e Candidaturas");
        JMenuItem itemConsultaVagas = new JMenuItem("Consulta de Vagas");
        itemConsultaVagas.addActionListener(e -> new ConsultaVagasDialog(this, vagaService).setVisible(true));
        JMenuItem itemConsultaCandidaturas = new JMenuItem("Consulta de Candidaturas");
        itemConsultaCandidaturas.addActionListener(e -> new ConsultaCandidaturasDialog(this, candidaturaService).setVisible(true));
        menuVagas.add(itemConsultaVagas);
        menuVagas.add(itemConsultaCandidaturas);

        JMenu menuRelatorios = new JMenu("Relatórios");
        JMenuItem itemRelEmpresas = new JMenuItem("Relatório de Empresas");
        itemRelEmpresas.addActionListener(e -> RelatorioUtil.gerarRelatorioEmpresas(empresaService.listarTodos()));
        JMenuItem itemRelAlunos = new JMenuItem("Relatório de Alunos");
        itemRelAlunos.addActionListener(e -> RelatorioUtil.gerarRelatorioAlunos(alunoService.listarTodos()));
        JMenuItem itemRelVagas = new JMenuItem("Relatório de Vagas");
        itemRelVagas.addActionListener(e -> RelatorioUtil.gerarRelatorioVagas(vagaService.listarTodos()));
        JMenuItem itemRelCandidaturas = new JMenuItem("Relatório de Candidaturas");
        itemRelCandidaturas.addActionListener(e -> RelatorioUtil.gerarRelatorioCandidaturas(candidaturaService.listarTodos()));
        menuRelatorios.add(itemRelEmpresas);
        menuRelatorios.add(itemRelAlunos);
        menuRelatorios.add(itemRelVagas);
        menuRelatorios.add(itemRelCandidaturas);

        menuBar.add(menuEmpresas);
        menuBar.add(menuAlunos);
        menuBar.add(menuVagas);
        menuBar.add(menuRelatorios);

        setJMenuBar(menuBar);
    }
}
