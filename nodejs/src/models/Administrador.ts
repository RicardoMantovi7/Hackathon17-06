import { Column, CreateDateColumn, Entity, PrimaryGeneratedColumn } from "typeorm";

export type PerfilAdministrador = "admin" | "coordenador" | "operador";

@Entity({ name: "administradores" })
export class Administrador {
  @PrimaryGeneratedColumn()
  id!: number;

  @Column({ type: "varchar", length: 255 })
  nome!: string;

  @Column({ type: "varchar", length: 50, unique: true })
  usuario!: string;

  @Column({ type: "varchar", length: 255 })
  senha!: string;

  @Column({
    type: "enum",
    enum: ["admin", "coordenador", "operador"],
    default: "operador",
  })
  perfil!: PerfilAdministrador;

  @CreateDateColumn({ name: "created_at", type: "timestamp" })
  created_at!: Date;
}
