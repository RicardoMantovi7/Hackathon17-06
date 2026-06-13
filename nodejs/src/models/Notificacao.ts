import {
  Column,
  CreateDateColumn,
  Entity,
  PrimaryGeneratedColumn,
} from "typeorm";

export type TipoUsuarioNotificacao = "aluno" | "empresa";

@Entity({ name: "notificacoes" })
export class Notificacao {
  @PrimaryGeneratedColumn()
  id!: number;

  @Column({
    type: "enum",
    enum: ["aluno", "empresa"],
    name: "usuario_tipo",
  })
  usuarioTipo!: TipoUsuarioNotificacao;

  @Column({ type: "int", name: "usuario_id" })
  usuarioId!: number;

  @Column({ type: "text" })
  mensagem!: string;

  @Column({ type: "boolean", default: false })
  lida!: boolean;

  @CreateDateColumn({ name: "created_at", type: "timestamp" })
  created_at!: Date;
}
