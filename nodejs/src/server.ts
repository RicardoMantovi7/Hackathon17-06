import "reflect-metadata";
import "dotenv/config";
import cors from "cors";

import express, { NextFunction, Request, Response } from "express";
import { databaseConnectionReady } from "./database/databaseConnectionReady";
import { ZodError } from "zod";
import AppError from "./utils/AppError";
import routes from "./routes";

const app = express();
const PORT = process.env.PORT || 3000;

// IMPORTANTE: CORS permite requisições de origens diferentes (como o PHP)
// - Em produção, você deve especificar a origem exata (ex: 'http://localhost')
app.use(cors());

// IMPORTANTE: Parseia o corpo das requisições como JSON
// - Sem isso, você não consegue acessar req.body
app.use(express.json());

// IMPORTANTE: As rotas públicas devem vir ANTES do middleware de autenticação
app.use(routes);

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

// IMPORTANTE: Inicializa a conexão com o banco ANTES de iniciar o servidor.
// - `databaseConnectionReady` centraliza essa etapa em um único arquivo.
databaseConnectionReady
  .then(() => {
    console.log("Conectou no Banco de Dados");

    app.listen(Number(PORT), () => {
      console.log("Iniciou o servidor na porta:" + PORT);
    });
  })
  .catch((err) => {
    console.log("Erro ao conectar no banco de dados");
    console.log(err);
  });
