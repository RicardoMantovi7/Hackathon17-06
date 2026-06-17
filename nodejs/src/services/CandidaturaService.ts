import { AppDataSource } from "../database/data-source";
import { Candidatura, StatusCandidatura } from "../models/Candidatura";
import { Vaga } from "../models/Vaga";
import AppError from "../utils/AppError";
import z from "zod";
import { AuthRequest } from "../middlewares/authMiddleware";

export class CandidaturaService {
  private candidaturaRepository = AppDataSource.getRepository(Candidatura);
  private vagaRepository = AppDataSource.getRepository(Vaga);

  async create(vagaId: number, user: AuthRequest["user"]) {
    if (!user || user.tipo !== "aluno") {
      throw new AppError("Usuário não é um aluno", 403);
    }

    const vaga = await this.vagaRepository.findOne({
      where: { id: vagaId },
    });

    if (!vaga) {
      throw new AppError("Vaga não encontrada", 404);
    }

    const existingCandidatura = await this.candidaturaRepository.findOne({
      where: { alunoId: user.id, vagaId },
    });

    if (existingCandidatura) {
      throw new AppError("Você já se candidatou a esta vaga", 400);
    }

    const candidatura = this.candidaturaRepository.create({
      alunoId: user.id,
      vagaId,
    });

    await this.candidaturaRepository.save(candidatura);
    return candidatura;
  }

  async findByAluno(user: AuthRequest["user"]) {
    if (!user || user.tipo !== "aluno") {
      throw new AppError("Usuário não é um aluno", 403);
    }

    return await this.candidaturaRepository.find({
      where: { alunoId: user.id },
      relations: ["aluno", "vaga", "vaga.empresa"],
    });
  }

  async findByVaga(vagaId: number, user: AuthRequest["user"]) {
    const vaga = await this.vagaRepository.findOne({
      where: { id: vagaId },
    });

    if (!vaga) {
      throw new AppError("Vaga não encontrada", 404);
    }

    if (!user || user.tipo !== "empresa" || vaga.empresaId !== user.id) {
      throw new AppError("Você não tem permissão para ver estas candidaturas", 403);
    }

    return await this.candidaturaRepository.find({
      where: { vagaId },
      relations: ["aluno", "vaga", "vaga.empresa"],
    });
  }

  async updateStatus(id: number, status: StatusCandidatura, user: AuthRequest["user"]) {
    const schema = z.object({
      status: z.enum(["pendente", "em_analise", "aprovado", "reprovado"]),
    });

    const dados = schema.parse({ status });

    const candidatura = await this.candidaturaRepository.findOne({
      where: { id },
      relations: ["vaga"],
    });

    if (!candidatura) {
      throw new AppError("Candidatura não encontrada", 404);
    }

    const vaga = await this.vagaRepository.findOne({
      where: { id: candidatura.vagaId },
    });

    if (!user || user.tipo !== "empresa" || vaga?.empresaId !== user.id) {
      throw new AppError("Você não tem permissão para atualizar esta candidatura", 403);
    }

    candidatura.status = dados.status;
    await this.candidaturaRepository.save(candidatura);

    return candidatura;
  }
}
