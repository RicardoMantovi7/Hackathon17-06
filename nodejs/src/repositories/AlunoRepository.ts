import type { Repository } from "typeorm";
import type { Aluno } from "../models/Aluno";

export interface IAlunoRepository {
  listarTodos(): Promise<Aluno[]>;
  buscarPorId(id: number): Promise<Aluno | undefined>;
  buscarPorEmail(email: string): Promise<Aluno | undefined>;
  buscarPorRa(ra: string): Promise<Aluno | undefined>;
  criar(dados: Omit<Aluno, "id" | "created_at" | "candidaturas">): Promise<Aluno>;
  salvar(entidade: Aluno): Promise<Aluno>;
  remover(id: number): Promise<boolean>;
}

export class AlunoRepository implements IAlunoRepository {
  constructor(private readonly repo: Repository<Aluno>) {}

  async listarTodos(): Promise<Aluno[]> {
    return await this.repo.find({ order: { id: "ASC" } });
  }

  async buscarPorId(id: number): Promise<Aluno | undefined> {
    const row = await this.repo.findOne({ where: { id } });
    return row ?? undefined;
  }

  async buscarPorEmail(email: string): Promise<Aluno | undefined> {
    const row = await this.repo.findOne({ where: { email } });
    return row ?? undefined;
  }

  async buscarPorRa(ra: string): Promise<Aluno | undefined> {
    const row = await this.repo.findOne({ where: { ra } });
    return row ?? undefined;
  }

  async criar(dados: Omit<Aluno, "id" | "created_at" | "candidaturas">): Promise<Aluno> {
    const ent = this.repo.create(dados);
    return await this.repo.save(ent);
  }

  async salvar(entidade: Aluno): Promise<Aluno> {
    return await this.repo.save(entidade);
  }

  async remover(id: number): Promise<boolean> {
    const r = await this.repo.delete(id);
    return (r.affected ?? 0) > 0;
  }
}
