import { Router } from "express";
import { NotificacaoController } from "../controllers/NotificacaoController";
import { authMiddleware } from "../middlewares/authMiddleware";

const router = Router();
const notificacaoController = new NotificacaoController();

router.get("/aluno/minhas", authMiddleware, notificacaoController.findByAluno);
router.put("/:id/lida", authMiddleware, notificacaoController.markAsRead);

export default router;
