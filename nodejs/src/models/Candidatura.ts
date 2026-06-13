import {
  Column,
  CreateDateColumn,
  Entity,
  PrimaryGeneratedColumn,
  ManyToOne,
} from "typeorm";
import { Aluno } from "./Aluno";
import { Vaga } from "./Vaga";

export type StatusCandidatura = "pendente" | "em_analise" | "aprovado" | "reprovado";

@Entity({ name: "candidaturas" })
export class Candidatura {
  @PrimaryGeneratedColumn()
  id!: number;

  @Column({ type: "int", name: "aluno_id" })
  alunoId!: number;

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

  @ManyToOne(() => Aluno, (aluno) => aluno.candidaturas, { onDelete: "CASCADE" })
  aluno!: Aluno;

  @ManyToOne(() => Vaga, (vaga) => vaga.candidaturas, { onDelete: "CASCADE" })
  vaga!: Vaga;
}
