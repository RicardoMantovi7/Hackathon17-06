import { Request, Response } from "express";
import { AppDataSource } from "../database/data-source";
import { Vaga } from "../models/Vaga";
import { Empresa } from "../models/Empresa";
import { Candidatura } from "../models/Candidatura";

export class EstatisticasController {
  async getEstatisticas(req: Request, res: Response) {
    try {
      const vagaRepo = AppDataSource.getRepository(Vaga);
      const empresaRepo = AppDataSource.getRepository(Empresa);
      const candidaturaRepo = AppDataSource.getRepository(Candidatura);

      const totalVagas = await vagaRepo.count({ where: { status: "aberta" } });
      const totalEmpresas = await empresaRepo.count({ where: { status: "aprovado" } });
      const totalCandidaturas = await candidaturaRepo.count();
      // Para "contratações", vamos usar candidaturas aprovadas como exemplo
      const totalContratacoes = await candidaturaRepo.count({ where: { status: "aprovado" } });

      res.status(200).json({
        success: true,
        data: {
          totalVagas,
          totalEmpresas,
          totalCandidaturas,
          totalContratacoes
        }
      });
    } catch (error) {
      res.status(500).json({ success: false, message: "Erro ao buscar estatísticas" });
    }
  }
}
