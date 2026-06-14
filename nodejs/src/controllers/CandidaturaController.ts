import { Response, NextFunction } from "express";
import { CandidaturaService } from "../services/CandidaturaService";
import { AuthRequest } from "../middlewares/authMiddleware";

const candidaturaService = new CandidaturaService();

export class CandidaturaController {
  async create(req: AuthRequest, res: Response, next: NextFunction) {
    try {
      const vagaId = Number(req.body.vagaId);
      const result = await candidaturaService.create(vagaId, req.user);
      res.status(201).json({ success: true, data: result });
    } catch (error) {
      next(error);
    }
  }

  async findByAluno(req: AuthRequest, res: Response, next: NextFunction) {
    try {
      const result = await candidaturaService.findByAluno(req.user);
      res.status(200).json({ success: true, data: result });
    } catch (error) {
      next(error);
    }
  }

  async findByVaga(req: AuthRequest, res: Response, next: NextFunction) {
    try {
      const vagaId = Number(req.params.vagaId);
      const result = await candidaturaService.findByVaga(vagaId, req.user);
      res.status(200).json({ success: true, data: result });
    } catch (error) {
      next(error);
    }
  }

  async updateStatus(req: AuthRequest, res: Response, next: NextFunction) {
    try {
      const id = Number(req.params.id);
      const status = req.body.status;
      const result = await candidaturaService.updateStatus(id, status, req.user);
      res.status(200).json({ success: true, data: result });
    } catch (error) {
      next(error);
    }
  }
}
