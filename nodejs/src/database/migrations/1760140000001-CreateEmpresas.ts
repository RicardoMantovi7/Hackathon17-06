import { MigrationInterface, QueryRunner, Table } from "typeorm";

export class CreateEmpresas1760140000001 implements MigrationInterface {
  public async up(queryRunner: QueryRunner): Promise<void> {
    await queryRunner.createTable(
      new Table({
        name: "empresas",
        columns: [
          {
            name: "id",
            type: "int",
            isPrimary: true,
            isGenerated: true,
            generationStrategy: "increment",
            isUnsigned: true,
          },
          {
            name: "nome",
            type: "varchar",
            length: "255",
          },
          {
            name: "cnpj",
            type: "varchar",
            length: "18",
            isUnique: true,
          },
          {
            name: "email",
            type: "varchar",
            length: "255",
            isUnique: true,
          },
          {
            name: "senha",
            type: "varchar",
            length: "255",
          },
          {
            name: "cidade",
            type: "varchar",
            length: "100",
            isNullable: true,
          },
          {
            name: "status",
            type: "enum",
            enum: ["pendente", "aprovado", "bloqueado"],
            default: "'pendente'",
          },
          {
            name: "created_at",
            type: "timestamp",
            default: "CURRENT_TIMESTAMP",
          },
        ],
      }),
      true,
    );
  }

  public async down(queryRunner: QueryRunner): Promise<void> {
    await queryRunner.dropTable("empresas");
  }
}
