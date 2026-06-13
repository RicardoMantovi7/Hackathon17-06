import {
  Column,
  CreateDateColumn,
  Entity,
  PrimaryGeneratedColumn,
  OneToMany,
} from "typeorm";
import { Candidatura } from "./Candidatura";

@Entity({ name: "alunos" })
export class Aluno {
  @PrimaryGeneratedColumn()
  id!: number;

  @Column({ type: "varchar", length: 20, unique: true })
  ra!: string;

  @Column({ type: "varchar", length: 255 })
  nome!: string;

  @Column({ type: "varchar", length: 255, unique: true })
  email!: string;

  @Column({ type: "varchar", length: 255 })
  senha!: string;

  @Column({ type: "varchar", length: 100, nullable: true })
  curso?: string;

  @Column({ type: "boolean", default: true, name: "status_aptidao" })
  statusAptidao!: boolean;

  @CreateDateColumn({ name: "created_at", type: "timestamp" })
  created_at!: Date;

  @OneToMany(() => Candidatura, (candidatura) => candidatura.aluno)
  candidaturas!: Candidatura[];
}
