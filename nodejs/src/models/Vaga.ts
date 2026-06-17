import {
  Column,
  CreateDateColumn,
  Entity,
  PrimaryGeneratedColumn,
  ManyToOne,
  OneToMany,
  JoinColumn,
} from "typeorm";
import { Empresa } from "./Empresa";
import { Candidatura } from "./Candidatura";

export type StatusVaga = "aberta" | "fechada";

@Entity({ name: "vagas" })
export class Vaga {
  @PrimaryGeneratedColumn()
  id!: number;

  // IMPORTANTE: Campo de chave estrangeira para a tabela `empresas`
  // - O TypeORM requer a propriedade com o nome do campo no banco (empresa_id)
  // - Sempre use @JoinColumn para mapear corretamente a coluna da FK
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

  // IMPORTANTE: Relação com Empresa
  // - @JoinColumn({ name: "empresa_id" }) é OBRIGATÓRIO para mapear a coluna correta
  // - onDelete: "CASCADE" faz com que todas as vagas sejam deletadas se a empresa for deletada
  @ManyToOne(() => Empresa, (empresa) => empresa.vagas, { onDelete: "CASCADE" })
  @JoinColumn({ name: "empresa_id" })
  empresa!: Empresa;

  @OneToMany(() => Candidatura, (candidatura) => candidatura.vaga)
  candidaturas!: Candidatura[];
}
