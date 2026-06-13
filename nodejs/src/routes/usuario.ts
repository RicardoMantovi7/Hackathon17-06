import { Router } from "express"
import z from "zod"
import { AppDataSource } from "../database/data-source"
import { Usuario } from "../models/Usuario"
import AppError from "../utils/AppError"

const router = Router()

router.post("/", async (req, res, next) => {

    try {

        const schema = z.object({
            nome: z.string({ message: "obrigatorio" }),
            email: z.email({ message: "email INvalido" }),
            senha: z.string({ message: "obrigatorio" }).min(6),
        })

        const dados = schema.parse(req.body)

        const repository = AppDataSource.getRepository(Usuario)

        const entidade = repository.create(dados)

        const usuario = await repository.save(entidade)

        res.json({ usuario }).status(201)

    } catch (err) {
       next(err)
    }


})

router.get("/", async (req, res) => {

    try {

        const repository = AppDataSource.getRepository(Usuario)

        const usuario = await repository.find()

        res.json({ usuario }).status(201)

    } catch (err) {
        throw new AppError("Erro ao buscar", 400);
    }
})

router.put("/:id", async (req, res, next) => {

    try {

        const id = Number(req.params.id);

        if (!Number.isInteger(id) || id < 1) {
            throw new AppError("Parâmetro id inválido", 400);
        }

        const schemaAtualizar = z.object({
            nome: z.string().optional(),
            email: z.string().email().optional(),
            senha: z.string().min(6).optional(),
        }).refine((d) => d.nome || d.email || d.senha, {
            message: "Informe pelo menos um campo para atualizar",
            path: ["body"],
        });

        const dados = schemaAtualizar.parse(req.body);

        const repository = AppDataSource.getRepository(Usuario);

        const usuarioAtual = await repository.findOne({ where: { id } });

        if (!usuarioAtual) {
            throw new AppError("Usuário não encontrado", 404);
        }

        if (dados.nome !== undefined) usuarioAtual.nome = dados.nome;
        if (dados.email !== undefined) usuarioAtual.email = dados.email;
        if (dados.senha !== undefined) usuarioAtual.senha = dados.senha;

        const usuario = await repository.save(usuarioAtual)

        res.json({
            message: "Usuário alterado com sucesso",
            usuario,
        });

    } catch (err) {
       next(err)
    }
})

router.delete("/:id", async (req, res) => {

    try {

        const id = Number(req.params.id);

        if (!Number.isInteger(id) || id < 1) {
            throw new AppError("Parâmetro id inválido", 400);
        }

        const repository = AppDataSource.getRepository(Usuario)

        await repository.delete(id)

        res.json().status(204)

    } catch (err) {
        throw new AppError("Erro ao deletar", 400);
    }
})

export default router