import { Router } from "express";
import { EstatisticasController } from "../controllers/EstatisticasController";

const router = Router();
const controller = new EstatisticasController();

router.get("/", controller.getEstatisticas);

export default router;
