import { Router } from "express";
import { AuthController } from "../controllers/AuthController";

const router = Router();
const authController = new AuthController();

router.post("/register/aluno", authController.registerAluno);
router.post("/register/empresa", authController.registerEmpresa);
router.post("/login/aluno", authController.loginAluno);
router.post("/login/empresa", authController.loginEmpresa);

export default router;
