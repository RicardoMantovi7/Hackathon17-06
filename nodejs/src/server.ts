import "reflect-metadata";
import "dotenv/config";
import cors from "cors";
import auth from "./routes/auth";
import vagas from "./routes/vagas";
import candidaturas from "./routes/candidaturas";
import notificacoes from "./routes/notificacoes";

import express, { NextFunction, Request, Response } from "express";
import { AppDataSource } from "./database/data-source";
import { ZodError } from "zod";
import AppError from "./utils/AppError";

const app = express();
const PORT = process.env.PORT || 3000;

app.use(cors());

app.use(express.json());

app.use("/auth", auth);
app.use("/vagas", vagas);
app.use("/candidaturas", candidaturas);
app.use("/notificacoes", notificacoes);

const handleErrorMiddleware = (
  error: Error,
  _req: Request,
  res: Response,
  _next: NextFunction,
) => {
  if (error instanceof ZodError) {
    return res.status(400).json({
      success: false,
      message: "Erro de validação",
      issues: error.format(),
    });
  }

  if (error instanceof AppError) {
    return res.status(error.statusCode).json({
      success: false,
      message: error.message,
    });
  }

  console.error(error);
  return res.status(500).json({
    success: false,
    message: "Erro interno do servidor",
  });
};

app.use(handleErrorMiddleware);

app.listen(Number(PORT), () => {
  console.log('Iniciou o servidor na porta:' + PORT);
});

AppDataSource.initialize()
  .then(() => {
    console.log('Conectou no Banco de Dados');
  })
  .catch((err) => {
    console.log("Erro ao conectar no banco de dados");
    console.log(err);
  });
