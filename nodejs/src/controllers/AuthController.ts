import { Request, Response, NextFunction } from "express";
import { AuthService } from "../services/AuthService";

const authService = new AuthService();

export class AuthController {
  async registerAluno(req: Request, res: Response, next: NextFunction) {
    try {
      const result = await authService.registerAluno(req.body);
      res.status(201).json({ success: true, data: result });
    } catch (error) {
      next(error);
    }
  }

  async registerEmpresa(req: Request, res: Response, next: NextFunction) {
    try {
      const result = await authService.registerEmpresa(req.body);
      res.status(201).json({ success: true, data: result });
    } catch (error) {
      next(error);
    }
  }

  async loginAluno(req: Request, res: Response, next: NextFunction) {
    try {
      const result = await authService.loginAluno(req.body);
      res.status(200).json({ success: true, data: result });
    } catch (error) {
      next(error);
    }
  }

  async loginEmpresa(req: Request, res: Response, next: NextFunction) {
    try {
      const result = await authService.loginEmpresa(req.body);
      res.status(200).json({ success: true, data: result });
    } catch (error) {
      next(error);
    }
  }
}
