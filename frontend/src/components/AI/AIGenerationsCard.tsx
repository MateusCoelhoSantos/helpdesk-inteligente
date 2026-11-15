import type { AIGeneration } from "../../types/AIGeneration";

interface Props {
    summary?: AIGeneration;

    knowledgeArticle?: AIGeneration;

    onGenerateKnowledgeArticle: () => Promise<void>;
}

export default function AIGenerationsCard(
    {
        summary,
        knowledgeArticle,
        onGenerateKnowledgeArticle
    }: Props
) {
    return (
        <div
            style={{
                border: "1px solid #444",
                padding: "20px",
                borderRadius: "8px",
                marginTop: "20px"
            }}
        >
            <h2>
                🤖 Inteligência Artificial
            </h2>

            <button
                onClick={
                    onGenerateKnowledgeArticle
                }
                style={{
                    marginBottom: "20px"
                }}
            >
                Gerar Artigo de Conhecimento
            </button>

            {!summary && !knowledgeArticle && (
                <p>Nenhuma geração encontrada.</p>
            )}

            {summary && (
                <div
                    style={{
                        marginBottom: "20px"
                    }}
                >
                    <h3>
                        📝 Último Resumo
                    </h3>

                    <p>
                        {summary.result?.summary}
                    </p>
                </div>
            )}

            {knowledgeArticle && (
                <div>
                    <h3>
                        🧠 Último Artigo de Conhecimento
                    </h3>

                    <h4>
                        {knowledgeArticle.result?.title}
                    </h4>

                    <p>
                        <strong>Problema:</strong>{" "}
                        {knowledgeArticle.result?.problem}
                    </p>

                    <p>
                        <strong>Causa:</strong>{" "}
                        {knowledgeArticle.result?.cause}
                    </p>

                    <p>
                        <strong>Solução:</strong>{" "}
                        {knowledgeArticle.result?.solution}
                    </p>

                    <p>
                        <strong>Prevenção:</strong>{" "}
                        {knowledgeArticle.result?.prevention}
                    </p>
                </div>
            )}

        </div>
    );
}