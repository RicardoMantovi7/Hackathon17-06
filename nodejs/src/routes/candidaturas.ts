import { Router } from "express";
import { CandidaturaController } from "../controllers/CandidaturaController";
import { authMiddleware } from "../middlewares/authMiddleware";

const router = Router();
const candidaturaController = new CandidaturaController();

router.post("/", authMiddleware, candidaturaController.create);
router.get("/aluno/minhas", authMiddleware, candidaturaController.findByAluno);
router.get("/vaga/:vagaId", authMiddleware, candidaturaController.findByVaga);
router.put("/:id/status", authMiddleware, candidaturaController.updateStatus);

export default router;
