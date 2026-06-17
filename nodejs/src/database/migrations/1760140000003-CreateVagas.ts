import { MigrationInterface, QueryRunner, Table } from "typeorm";

export class CreateVagas1760140000003 implements MigrationInterface {
  public async up(queryRunner: QueryRunner): Promise<void> {
    await queryRunner.createTable(
      new Table({
        name: "vagas",
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
            name: "empresa_id",
            type: "int",
            isUnsigned: true,
          },
          {
            name: "titulo",
            type: "varchar",
            length: "255",
          },
          {
            name: "descricao",
            type: "text",
          },
          {
            name: "requisitos",
            type: "text",
            isNullable: true,
          },
          {
            name: "valor_bolsa",
            type: "decimal",
            precision: 10,
            scale: 2,
            isNullable: true,
          },
          {
            name: "status",
            type: "enum",
            enum: ["aberta", "fechada"],
            default: "'aberta'",
          },
          {
            name: "created_at",
            type: "timestamp",
            default: "CURRENT_TIMESTAMP",
          },
        ],
        foreignKeys: [
          {
            columnNames: ["empresa_id"],
            referencedTableName: "empresas",
            referencedColumnNames: ["id"],
            onDelete: "CASCADE",
          },
        ],
      }),
      true,
    );
  }

  public async down(queryRunner: QueryRunner): Promise<void> {
    await queryRunner.dropTable("vagas");
  }
}
