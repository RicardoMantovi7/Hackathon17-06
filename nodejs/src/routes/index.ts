import { Router } from "express";
import { authMiddleware } from "../middlewares/authMiddleware";
import auth from "./auth";
import vagas from "./vagas";
import candidaturas from "./candidaturas";
import estatisticas from "./estatisticas";

const routes = Router();

routes.use("/estatisticas", estatisticas);
routes.use("/auth", auth);
routes.use(authMiddleware);
routes.use("/vagas", vagas);
routes.use("/candidaturas", candidaturas);

export default routes;
