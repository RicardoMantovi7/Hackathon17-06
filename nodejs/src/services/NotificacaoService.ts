import { AppDataSource } from "../database/data-source";
import { Notificacao } from "../models/Notificacao";
import AppError from "../utils/AppError";
import { AuthRequest } from "../middlewares/authMiddleware";

export class NotificacaoService {
  private notificacaoRepository = AppDataSource.getRepository(Notificacao);

  async findByAluno(user: AuthRequest["user"]) {
    if (!user || user.tipo !== "aluno") {
      throw new AppError("Você não tem permissão para ver estas notificações", 403);
    }

    return await this.notificacaoRepository.find({
      where: { usuarioTipo: "aluno", usuarioId: user.id },
      order: { created_at: "DESC" },
    });
  }

  async markAsRead(id: number, user: AuthRequest["user"]) {
    const notificacao = await this.notificacaoRepository.findOne({
      where: { id },
    });

    if (!notificacao) {
      throw new AppError("Notificação não encontrada", 404);
    }

    if (!user || user.tipo !== notificacao.usuarioTipo || user.id !== notificacao.usuarioId) {
      throw new AppError("Você não tem permissão para marcar esta notificação", 403);
    }

    notificacao.lida = true;
    await this.notificacaoRepository.save(notificacao);
    return notificacao;
  }
}
