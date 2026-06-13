import {
  Column,
  CreateDateColumn,
  Entity,
  PrimaryGeneratedColumn,
  OneToMany,
} from "typeorm";
import { Vaga } from "./Vaga";

export type StatusEmpresa = "pendente" | "aprovado" | "bloqueado";

@Entity({ name: "empresas" })
export class Empresa {
  @PrimaryGeneratedColumn()
  id!: number;

  @Column({ type: "varchar", length: 255 })
  nome!: string;

  @Column({ type: "varchar", length: 18, unique: true })
  cnpj!: string;

  @Column({ type: "varchar", length: 255, unique: true })
  email!: string;

  @Column({ type: "varchar", length: 255 })
  senha!: string;

  @Column({ type: "varchar", length: 100, nullable: true })
  cidade?: string;

  @Column({
    type: "enum",
    enum: ["pendente", "aprovado", "bloqueado"],
    default: "pendente",
  })
  status!: StatusEmpresa;

  @CreateDateColumn({ name: "created_at", type: "timestamp" })
  created_at!: Date;

  @OneToMany(() => Vaga, (vaga) => vaga.empresa)
  vagas!: Vaga[];
}
