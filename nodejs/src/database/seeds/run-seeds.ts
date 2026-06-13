import "reflect-metadata";
import "dotenv/config";
import { AppDataSource } from "../data-source";
import { Aluno } from "../../models/Aluno";
import { Empresa } from "../../models/Empresa";
import { Vaga } from "../../models/Vaga";
import { Administrador } from "../../models/Administrador";
import bcrypt from "bcrypt";

async function rodarSeed() {
  await AppDataSource.initialize();

  const alunoRepo = AppDataSource.getRepository(Aluno);
  const empresaRepo = AppDataSource.getRepository(Empresa);
  const vagaRepo = AppDataSource.getRepository(Vaga);
  const adminRepo = AppDataSource.getRepository(Administrador);

  const hashedSenha = await bcrypt.hash("123456", 10);

  // Criar aluno
  const emailAluno = "aluno@example.com";
  const jaTemAluno = await alunoRepo.exists({ where: { email: emailAluno } });
  if (!jaTemAluno) {
    const aluno = alunoRepo.create({
      ra: "2024001",
      nome: "João Aluno",
      email: emailAluno,
      senha: hashedSenha,
      curso: "Engenharia de Software",
    });
    await alunoRepo.save(aluno);
  }

  // Criar empresa
  const emailEmpresa = "empresa@example.com";
  const jaTemEmpresa = await empresaRepo.exists({ where: { email: emailEmpresa } });
  if (!jaTemEmpresa) {
    const empresa = empresaRepo.create({
      nome: "Empresa XYZ",
      cnpj: "12345678000100",
      email: emailEmpresa,
      senha: hashedSenha,
      cidade: "São Paulo",
      status: "aprovado",
    });
    await empresaRepo.save(empresa);

    // Criar vagas para a empresa
    const vaga1 = vagaRepo.create({
      titulo: "Desenvolvedor Web Junior",
      descricao: "Vaga para desenvolvedor web com experiência em HTML, CSS e JavaScript.",
      requisitos: "Conhecimento em React é um diferencial.",
      valorBolsa: 1500,
      empresaId: empresa.id,
    });
    await vagaRepo.save(vaga1);

    const vaga2 = vagaRepo.create({
      titulo: "Estágio em QA",
      descricao: "Vaga de estágio para testes de software.",
      requisitos: "Conhecimento básico em testes.",
      valorBolsa: 1000,
      empresaId: empresa.id,
    });
    await vagaRepo.save(vaga2);
  }

  // Criar outro aluno
  const emailAluno2 = "maria@example.com";
  const jaTemAluno2 = await alunoRepo.exists({ where: { email: emailAluno2 } });
  if (!jaTemAluno2) {
    const aluno2 = alunoRepo.create({
      ra: "2024002",
      nome: "Maria Estudante",
      email: emailAluno2,
      senha: hashedSenha,
      curso: "Ciência da Computação",
    });
    await alunoRepo.save(aluno2);
  }

  // Criar administrador
  const usuarioAdmin = "admin";
  const jaTemAdmin = await adminRepo.exists({ where: { usuario: usuarioAdmin } });
  if (!jaTemAdmin) {
    const admin = adminRepo.create({
      nome: "Administrador",
      usuario: usuarioAdmin,
      senha: hashedSenha,
      perfil: "admin",
    });
    await adminRepo.save(admin);
  }

  await AppDataSource.destroy();
  console.log("Seeds executados com sucesso!");
}

rodarSeed().catch(async (err) => {
  console.error(err);
  if (AppDataSource.isInitialized) await AppDataSource.destroy();

  process.exit(1);
});
