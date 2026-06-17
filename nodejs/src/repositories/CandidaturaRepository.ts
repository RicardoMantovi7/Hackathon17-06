import type { Repository } from "typeorm";
import type { Candidatura } from "../models/Candidatura";

export interface ICandidaturaRepository {
  listarTodos(): Promise<Candidatura[]>;
  listarPorAluno(alunoId: number): Promise<Candidatura[]>;
  listarPorVaga(vagaId: number): Promise<Candidatura[]>;
  buscarPorId(id: number): Promise<Candidatura | undefined>;
  criar(dados: Omit<Candidatura, "id" | "dataCandidatura" | "aluno" | "vaga">): Promise<Candidatura>;
  salvar(entidade: Candidatura): Promise<Candidatura>;
  remover(id: number): Promise<boolean>;
}

export class CandidaturaRepository implements ICandidaturaRepository {
  constructor(private readonly repo: Repository<Candidatura>) {}

  async listarTodos(): Promise<Candidatura[]> {
    return await this.repo.find({
      order: { id: "ASC" },
      relations: ["aluno", "vaga", "vaga.empresa"],
    });
  }

  async listarPorAluno(alunoId: number): Promise<Candidatura[]> {
    return await this.repo.find({
      where: { alunoId },
      order: { id: "ASC" },
      relations: ["vaga", "vaga.empresa"],
    });
  }

  async listarPorVaga(vagaId: number): Promise<Candidatura[]> {
    return await this.repo.find({
      where: { vagaId },
      order: { id: "ASC" },
      relations: ["aluno"],
    });
  }

  async buscarPorId(id: number): Promise<Candidatura | undefined> {
    const row = await this.repo.findOne({
      where: { id },
      relations: ["aluno", "vaga", "vaga.empresa"],
    });
    return row ?? undefined;
  }

  async criar(dados: Omit<Candidatura, "id" | "dataCandidatura" | "aluno" | "vaga">): Promise<Candidatura> {
    const ent = this.repo.create(dados);
    return await this.repo.save(ent);
  }

  async salvar(entidade: Candidatura): Promise<Candidatura> {
    return await this.repo.save(entidade);
  }

  async remover(id: number): Promise<boolean> {
    const r = await this.repo.delete(id);
    return (r.affected ?? 0) > 0;
  }
}
