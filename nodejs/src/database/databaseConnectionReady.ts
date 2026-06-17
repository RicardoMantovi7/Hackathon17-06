import { AppDataSource } from "./data-source";

// Centraliza a inicialização do TypeORM para evitar chamadas duplicadas de `initialize()`.
export const databaseConnectionReady = AppDataSource.initialize();
