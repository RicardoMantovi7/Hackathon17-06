import { Response, NextFunction } from "express";
import { VagaService } from "../services/VagaService";
import { AuthRequest } from "../middlewares/authMiddleware";

const vagaService = new VagaService();

export class VagaController {
  async create(req: AuthRequest, res: Response, next: NextFunction) {
    try {
      const result = await vagaService.create(req.body, req.user);
      res.status(201).json({ success: true, data: result });
    } catch (error) {
      next(error);
    }
  }

  async findAll(req: AuthRequest, res: Response, next: NextFunction) {
    try {
      const result = await vagaService.findAll();
      res.status(200).json({ success: true, data: result });
    } catch (error) {
      next(error);
    }
  }

  async findOne(req: AuthRequest, res: Response, next: NextFunction) {
    try {
      const id = Number(req.params.id);
      const result = await vagaService.findOne(id);
      res.status(200).json({ success: true, data: result });
    } catch (error) {
      next(error);
    }
  }

  async update(req: AuthRequest, res: Response, next: NextFunction) {
    try {
      const id = Number(req.params.id);
      const result = await vagaService.update(id, req.body, req.user);
      res.status(200).json({ success: true, data: result });
    } catch (error) {
      next(error);
    }
  }

  async delete(req: AuthRequest, res: Response, next: NextFunction) {
    try {
      const id = Number(req.params.id);
      await vagaService.delete(id, req.user);
      res.status(204).json();
    } catch (error) {
      next(error);
    }
  }

  async findByEmpresa(req: AuthRequest, res: Response, next: NextFunction) {
    try {
      const result = await vagaService.findByEmpresa(req.user);
      res.status(200).json({ success: true, data: result });
    } catch (error) {
      next(error);
    }
  }
}
