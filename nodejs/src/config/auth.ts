export default {
    jwt: {
        secret: process.env.JWT_SECRET || "seu-segredo-super-secreto-aqui",
        expiresIn: "1h" as const,
    },
};
