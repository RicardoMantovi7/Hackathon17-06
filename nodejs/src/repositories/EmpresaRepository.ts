import type { Repository } from "typeorm";
import type { Empresa } from "../models/Empresa";

export interface IEmpresaRepository {
  listarTodos(): Promise<Empresa[]>;
  buscarPorId(id: number): Promise<Empresa | undefined>;
  buscarPorEmail(email: string): Promise<Empresa | undefined>;
  buscarPorCnpj(cnpj: string): Promise<Empresa | undefined>;
  criar(dados: Omit<Empresa, "id" | "created_at" | "vagas">): Promise<Empresa>;
  salvar(entidade: Empresa): Promise<Empresa>;
  remover(id: number): Promise<boolean>;
}

export class EmpresaRepository implements IEmpresaRepository {
  constructor(private readonly repo: Repository<Empresa>) {}

  async listarTodos(): Promise<Empresa[]> {
    return await this.repo.find({ order: { id: "ASC" } });
  }

  async buscarPorId(id: number): Promise<Empresa | undefined> {
    const row = await this.repo.findOne({ where: { id } });
    return row ?? undefined;
  }

  async buscarPorEmail(email: string): Promise<Empresa | undefined> {
    const row = await this.repo.findOne({ where: { email } });
    return row ?? undefined;
  }

  async buscarPorCnpj(cnpj: string): Promise<Empresa | undefined> {
    const row = await this.repo.findOne({ where: { cnpj } });
    return row ?? undefined;
  }

  async criar(dados: Omit<Empresa, "id" | "created_at" | "vagas">): Promise<Empresa> {
    const ent = this.repo.create(dados);
    return await this.repo.save(ent);
  }

  async salvar(entidade: Empresa): Promise<Empresa> {
    return await this.repo.save(entidade);
  }

  async remover(id: number): Promise<boolean> {
    const r = await this.repo.delete(id);
    return (r.affected ?? 0) > 0;
  }
}
