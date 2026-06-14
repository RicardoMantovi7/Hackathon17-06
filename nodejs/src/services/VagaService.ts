import { AppDataSource } from "../database/data-source";
import { Vaga } from "../models/Vaga";
import AppError from "../utils/AppError";
import z from "zod";
import { AuthRequest } from "../middlewares/authMiddleware";

export class VagaService {
  private vagaRepository = AppDataSource.getRepository(Vaga);

  async create(data: {
    titulo: string;
    descricao: string;
    requisitos?: string;
    valorBolsa?: number;
  }, user: AuthRequest["user"]) {
    const schema = z.object({
      titulo: z.string().min(3),
      descricao: z.string().min(10),
      requisitos: z.string().optional(),
      valorBolsa: z.number().optional(),
    });

    const dados = schema.parse(data);

    if (!user || user.tipo !== "empresa") {
      throw new AppError("Usuário não é uma empresa", 403);
    }

    const vaga = this.vagaRepository.create({
      ...dados,
      empresaId: user.id,
    });

    await this.vagaRepository.save(vaga);
    return vaga;
  }

  async findAll() {
    return await this.vagaRepository.find({
      relations: ["empresa"],
    });
  }

  async findOne(id: number) {
    const vaga = await this.vagaRepository.findOne({
      where: { id },
      relations: ["empresa", "candidaturas", "candidaturas.aluno"],
    });

    if (!vaga) {
      throw new AppError("Vaga não encontrada", 404);
    }

    return vaga;
  }

  async update(id: number, data: Partial<{
    titulo: string;
    descricao: string;
    requisitos?: string;
    valorBolsa?: number;
    status?: string;
  }>, user: AuthRequest["user"]) {
    const schema = z.object({
      titulo: z.string().min(3).optional(),
      descricao: z.string().min(10).optional(),
      requisitos: z.string().optional(),
      valorBolsa: z.number().optional(),
      status: z.enum(["aberta", "fechada"]).optional(),
    });

    const dados = schema.parse(data);

    const vaga = await this.findOne(id);

    if (!user || user.tipo !== "empresa" || vaga.empresaId !== user.id) {
      throw new AppError("Você não tem permissão para editar esta vaga", 403);
    }

    Object.assign(vaga, dados);
    await this.vagaRepository.save(vaga);
    return vaga;
  }

  async delete(id: number, user: AuthRequest["user"]) {
    const vaga = await this.findOne(id);

    if (!user || user.tipo !== "empresa" || vaga.empresaId !== user.id) {
      throw new AppError("Você não tem permissão para deletar esta vaga", 403);
    }

    await this.vagaRepository.delete(id);
  }

  async findByEmpresa(user: AuthRequest["user"]) {
    if (!user || user.tipo !== "empresa") {
      throw new AppError("Usuário não é uma empresa", 403);
    }

    return await this.vagaRepository.find({
      where: { empresaId: user.id },
      relations: ["empresa"],
    });
  }
}
