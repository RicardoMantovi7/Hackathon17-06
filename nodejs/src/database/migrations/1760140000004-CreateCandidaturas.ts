import { MigrationInterface, QueryRunner, Table } from "typeorm";

export class CreateCandidaturas1760140000004 implements MigrationInterface {
  public async up(queryRunner: QueryRunner): Promise<void> {
    await queryRunner.createTable(
      new Table({
        name: "candidaturas",
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
            name: "aluno_id",
            type: "int",
            isUnsigned: true,
          },
          {
            name: "vaga_id",
            type: "int",
            isUnsigned: true,
          },
          {
            name: "status",
            type: "enum",
            enum: ["pendente", "em_analise", "aprovado", "reprovado"],
            default: "'pendente'",
          },
          {
            name: "data_candidatura",
            type: "timestamp",
            default: "CURRENT_TIMESTAMP",
          },
        ],
        foreignKeys: [
          {
            columnNames: ["aluno_id"],
            referencedTableName: "alunos",
            referencedColumnNames: ["id"],
            onDelete: "CASCADE",
          },
          {
            columnNames: ["vaga_id"],
            referencedTableName: "vagas",
            referencedColumnNames: ["id"],
            onDelete: "CASCADE",
          },
        ],
      }),
      true,
    );
  }

  public async down(queryRunner: QueryRunner): Promise<void> {
    await queryRunner.dropTable("candidaturas");
  }
}
