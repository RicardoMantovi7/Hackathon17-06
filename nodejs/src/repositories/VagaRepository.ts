import type { Repository } from "typeorm";
import type { Vaga } from "../models/Vaga";

export interface IVagaRepository {
  listarTodos(): Promise<Vaga[]>;
  listarPorEmpresa(empresaId: number): Promise<Vaga[]>;
  buscarPorId(id: number): Promise<Vaga | undefined>;
  criar(dados: Omit<Vaga, "id" | "created_at" | "empresa" | "candidaturas">): Promise<Vaga>;
  salvar(entidade: Vaga): Promise<Vaga>;
  remover(id: number): Promise<boolean>;
}

export class VagaRepository implements IVagaRepository {
  constructor(private readonly repo: Repository<Vaga>) {}

  async listarTodos(): Promise<Vaga[]> {
    return await this.repo.find({
      order: { id: "ASC" },
      relations: ["empresa"],
    });
  }

  async listarPorEmpresa(empresaId: number): Promise<Vaga[]> {
    return await this.repo.find({
      where: { empresaId },
      order: { id: "ASC" },
    });
  }

  async buscarPorId(id: number): Promise<Vaga | undefined> {
    const row = await this.repo.findOne({
      where: { id },
      relations: ["empresa"],
    });
    return row ?? undefined;
  }

  async criar(dados: Omit<Vaga, "id" | "created_at" | "empresa" | "candidaturas">): Promise<Vaga> {
    const ent = this.repo.create(dados);
    return await this.repo.save(ent);
  }

  async salvar(entidade: Vaga): Promise<Vaga> {
    return await this.repo.save(entidade);
  }

  async remover(id: number): Promise<boolean> {
    const r = await this.repo.delete(id);
    return (r.affected ?? 0) > 0;
  }
}
