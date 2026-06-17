import {
  Column,
  CreateDateColumn,
  Entity,
  PrimaryGeneratedColumn,
  ManyToOne,
  JoinColumn,
} from "typeorm";
import { Aluno } from "./Aluno";
import { Vaga } from "./Vaga";

export type StatusCandidatura = "pendente" | "em_analise" | "aprovado" | "reprovado";

@Entity({ name: "candidaturas" })
export class Candidatura {
  @PrimaryGeneratedColumn()
  id!: number;

  // IMPORTANTE: Campo de chave estrangeira para a tabela `alunos`
  // - Sempre use @JoinColumn para mapear corretamente a coluna da FK
  @Column({ type: "int", name: "aluno_id" })
  alunoId!: number;

  // IMPORTANTE: Campo de chave estrangeira para a tabela `vagas`
  // - Sempre use @JoinColumn para mapear corretamente a coluna da FK
  @Column({ type: "int", name: "vaga_id" })
  vagaId!: number;

  @Column({
    type: "enum",
    enum: ["pendente", "em_analise", "aprovado", "reprovado"],
    default: "pendente",
  })
  status!: StatusCandidatura;

  @CreateDateColumn({ name: "data_candidatura", type: "timestamp" })
  dataCandidatura!: Date;

  // IMPORTANTE: Relação com Aluno
  // - @JoinColumn({ name: "aluno_id" }) é OBRIGATÓRIO
  // - onDelete: "CASCADE" remove todas as candidaturas de um aluno se ele for deletado
  @ManyToOne(() => Aluno, (aluno) => aluno.candidaturas, { onDelete: "CASCADE" })
  @JoinColumn({ name: "aluno_id" })
  aluno!: Aluno;

  // IMPORTANTE: Relação com Vaga
  // - @JoinColumn({ name: "vaga_id" }) é OBRIGATÓRIO
  // - onDelete: "CASCADE" remove todas as candidaturas de uma vaga se ela for deletada
  @ManyToOne(() => Vaga, (vaga) => vaga.candidaturas, { onDelete: "CASCADE" })
  @JoinColumn({ name: "vaga_id" })
  vaga!: Vaga;
}
