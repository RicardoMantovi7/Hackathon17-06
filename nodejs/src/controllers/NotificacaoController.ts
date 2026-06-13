import { Response, NextFunction } from "express";
import { NotificacaoService } from "../services/NotificacaoService";
import { AuthRequest } from "../middlewares/authMiddleware";

const notificacaoService = new NotificacaoService();

export class NotificacaoController {
  async findByAluno(req: AuthRequest, res: Response, next: NextFunction) {
    try {
      const result = await notificacaoService.findByAluno(req.user);
      res.status(200).json({ success: true, data: result });
    } catch (error) {
      next(error);
    }
  }

  async markAsRead(req: AuthRequest, res: Response, next: NextFunction) {
    try {
      const id = Number(req.params.id);
      const result = await notificacaoService.markAsRead(id, req.user);
      res.status(200).json({ success: true, data: result });
    } catch (error) {
      next(error);
    }
  }
}
