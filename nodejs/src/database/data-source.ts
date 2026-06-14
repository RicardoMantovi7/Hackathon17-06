import "reflect-metadata";
import "dotenv/config";
import path from "path";
import { DataSource } from "typeorm";

import { Aluno } from "../models/Aluno";
import { Empresa } from "../models/Empresa";
import { Vaga } from "../models/Vaga";
import { Candidatura } from "../models/Candidatura";
import { Notificacao } from "../models/Notificacao";
import { Administrador } from "../models/Administrador";

const migrationsPath = path.join(__dirname, "migrations");

export const AppDataSource = new DataSource({
  type: "mysql",
  host: process.env.DB_HOST || "localhost",
  port: Number(process.env.DB_PORT) || 3306,
  username: process.env.DB_USER || "root",
  password: process.env.DB_PASSWORD || "",
  database: process.env.DB_NAME || "portal_estagios",
  entities: [Aluno, Empresa, Vaga, Candidatura, Notificacao, Administrador],
  migrations: [path.join(migrationsPath, "*.{js,ts}")],
  synchronize: false,
});
