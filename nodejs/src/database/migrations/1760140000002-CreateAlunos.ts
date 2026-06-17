import { MigrationInterface, QueryRunner, Table } from "typeorm";

export class CreateAlunos1760140000002 implements MigrationInterface {
  public async up(queryRunner: QueryRunner): Promise<void> {
    await queryRunner.createTable(
      new Table({
        name: "alunos",
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
            name: "ra",
            type: "varchar",
            length: "20",
            isUnique: true,
          },
          {
            name: "nome",
            type: "varchar",
            length: "255",
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
            name: "curso",
            type: "varchar",
            length: "100",
            isNullable: true,
          },
          {
            name: "status_aptidao",
            type: "boolean",
            default: true,
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
    await queryRunner.dropTable("alunos");
  }
}
