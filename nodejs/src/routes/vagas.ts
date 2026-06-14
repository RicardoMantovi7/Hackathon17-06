import { Router } from "express";
import { VagaController } from "../controllers/VagaController";
import { authMiddleware } from "../middlewares/authMiddleware";

const router = Router();
const vagaController = new VagaController();

router.get("/", vagaController.findAll);
router.get("/:id", vagaController.findOne);
router.get("/empresa/minhas", authMiddleware, vagaController.findByEmpresa);
router.post("/", authMiddleware, vagaController.create);
router.put("/:id", authMiddleware, vagaController.update);
router.delete("/:id", authMiddleware, vagaController.delete);

export default router;
