import { Request, Response, NextFunction } from "express";
import jwt from "jsonwebtoken";
import AppError from "../utils/AppError";
import { AppDataSource } from "../database/data-source";
import { Aluno } from "../models/Aluno";
import { Empresa } from "../models/Empresa";

const JWT_SECRET = process.env.JWT_SECRET || "seu-segredo-super-secreto";

export interface AuthRequest extends Request {
  user?: {
    id: number;
    tipo: "aluno" | "empresa";
    aluno?: Aluno;
    empresa?: Empresa;
  };
}

export const authMiddleware = async (
  req: AuthRequest,
  res: Response,
  next: NextFunction
) => {
  try {
    const authHeader = req.headers.authorization;

    if (!authHeader) {
      throw new AppError("Token não fornecido", 401);
    }

    const token = authHeader.split(" ")[1];

    if (!token) {
      throw new AppError("Token inválido", 401);
    }

    const decoded = jwt.verify(token, JWT_SECRET) as { id: number; tipo: "aluno" | "empresa" };

    let user;
    if (decoded.tipo === "aluno") {
      const alunoRepository = AppDataSource.getRepository(Aluno);
      const aluno = await alunoRepository.findOne({ where: { id: decoded.id } });
      if (!aluno) throw new AppError("Usuário não encontrado", 401);
      user = { id: aluno.id, tipo: "aluno", aluno };
    } else {
      const empresaRepository = AppDataSource.getRepository(Empresa);
      const empresa = await empresaRepository.findOne({ where: { id: decoded.id } });
      if (!empresa) throw new AppError("Usuário não encontrado", 401);
      user = { id: empresa.id, tipo: "empresa", empresa };
    }

    req.user = user;
    next();
  } catch (error) {
    next(error);
  }
};
