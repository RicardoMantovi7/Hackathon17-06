import { AppDataSource } from "../database/data-source";
import { Aluno } from "../models/Aluno";
import { Empresa } from "../models/Empresa";
import bcrypt from "bcrypt";
import jwt from "jsonwebtoken";
import AppError from "../utils/AppError";
import z from "zod";

const JWT_SECRET = process.env.JWT_SECRET || "seu-segredo-super-secreto";

export class AuthService {
  private alunoRepository = AppDataSource.getRepository(Aluno);
  private empresaRepository = AppDataSource.getRepository(Empresa);

  async registerAluno(data: {
    ra: string;
    nome: string;
    email: string;
    senha: string;
    curso?: string;
  }) {
    const schema = z.object({
      ra: z.string().min(1),
      nome: z.string().min(2),
      email: z.string().email(),
      senha: z.string().min(6),
      curso: z.string().optional(),
    });

    const dados = schema.parse(data);

    const existingAluno = await this.alunoRepository.findOne({
      where: [{ email: dados.email }, { ra: dados.ra }],
    });

    if (existingAluno) {
      throw new AppError("Email ou RA já cadastrado", 400);
    }

    const hashedSenha = await bcrypt.hash(dados.senha, 10);

    const aluno = this.alunoRepository.create({
      ...dados,
      senha: hashedSenha,
    });

    await this.alunoRepository.save(aluno);

    const alunoSemSenha = { ...aluno, senha: undefined };
    return { aluno: alunoSemSenha };
  }

  async registerEmpresa(data: {
    nome: string;
    cnpj: string;
    email: string;
    senha: string;
    cidade?: string;
  }) {
    const schema = z.object({
      nome: z.string().min(2),
      cnpj: z.string().min(14),
      email: z.string().email(),
      senha: z.string().min(6),
      cidade: z.string().optional(),
    });

    const dados = schema.parse(data);

    const existingEmpresa = await this.empresaRepository.findOne({
      where: [{ email: dados.email }, { cnpj: dados.cnpj }],
    });

    if (existingEmpresa) {
      throw new AppError("Email ou CNPJ já cadastrado", 400);
    }

    const hashedSenha = await bcrypt.hash(dados.senha, 10);

    const empresa = this.empresaRepository.create({
      ...dados,
      senha: hashedSenha,
    });

    await this.empresaRepository.save(empresa);

    const empresaSemSenha = { ...empresa, senha: undefined };
    return { empresa: empresaSemSenha };
  }

  async loginAluno(data: { email: string; senha: string }) {
    const schema = z.object({
      email: z.string().email(),
      senha: z.string().min(1),
    });

    const dados = schema.parse(data);

    const aluno = await this.alunoRepository.findOne({
      where: { email: dados.email },
    });

    if (!aluno) {
      throw new AppError("Usuário ou senha incorretos", 401);
    }

    const senhaValida = await bcrypt.compare(dados.senha, aluno.senha);

    if (!senhaValida) {
      throw new AppError("Usuário ou senha incorretos", 401);
    }

    const token = jwt.sign({ id: aluno.id, tipo: "aluno" }, JWT_SECRET, {
      expiresIn: "7d",
    });

    const alunoSemSenha = { ...aluno, senha: undefined };
    return { aluno: alunoSemSenha, token };
  }

  async loginEmpresa(data: { email: string; senha: string }) {
    const schema = z.object({
      email: z.string().email(),
      senha: z.string().min(1),
    });

    const dados = schema.parse(data);

    const empresa = await this.empresaRepository.findOne({
      where: { email: dados.email },
    });

    if (!empresa) {
      throw new AppError("Usuário ou senha incorretos", 401);
    }

    const senhaValida = await bcrypt.compare(dados.senha, empresa.senha);

    if (!senhaValida) {
      throw new AppError("Usuário ou senha incorretos", 401);
    }

    const token = jwt.sign({ id: empresa.id, tipo: "empresa" }, JWT_SECRET, {
      expiresIn: "7d",
    });

    const empresaSemSenha = { ...empresa, senha: undefined };
    return { empresa: empresaSemSenha, token };
  }
}
