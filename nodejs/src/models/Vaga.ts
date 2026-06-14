import {
  Column,
  CreateDateColumn,
  Entity,
  PrimaryGeneratedColumn,
  ManyToOne,
  OneToMany,
} from "typeorm";
import { Empresa } from "./Empresa";
import { Candidatura } from "./Candidatura";

export type StatusVaga = "aberta" | "fechada";

@Entity({ name: "vagas" })
export class Vaga {
  @PrimaryGeneratedColumn()
  id!: number;

  @Column({ type: "int", name: "empresa_id" })
  empresaId!: number;

  @Column({ type: "varchar", length: 255 })
  titulo!: string;

  @Column({ type: "text" })
  descricao!: string;

  @Column({ type: "text", nullable: true })
  requisitos?: string;

  @Column({ type: "decimal", precision: 10, scale: 2, nullable: true, name: "valor_bolsa" })
  valorBolsa?: number;

  @Column({
    type: "enum",
    enum: ["aberta", "fechada"],
    default: "aberta",
  })
  status!: StatusVaga;

  @CreateDateColumn({ name: "created_at", type: "timestamp" })
  created_at!: Date;

  @ManyToOne(() => Empresa, (empresa) => empresa.vagas, { onDelete: "CASCADE" })
  empresa!: Empresa;

  @OneToMany(() => Candidatura, (candidatura) => candidatura.vaga)
  candidaturas!: Candidatura[];
}
