import { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import api from "../api/axios";
import TicketInfoCard from "../components/Ticket/TicketInfoCard";
import type { Ticket } from "../types/Ticket";
import CommentsCard from "../components/Ticket/CommentsCard";
import type { Comment } from "../types/Comment";
import type { History } from "../types/History";
import HistoryTimeline from "../components/Ticket/HistoryTimeline";
import type { Attachment } from "../types/Attachment";
import AttachmentsCard from "../components/Ticket/AttachmentsCard";
import CommentForm from "../components/Ticket/CommentForm";
import type { AIGeneration } from "../types/AIGeneration";
import AIGenerationsCard from "../components/AI/AIGenerationsCard";

export default function TicketDetailsPage() {

    const { id } = useParams();

    const [ticket, setTicket] =
        useState<Ticket | null>(null);

    const [attachments, setAttachments] =
        useState<Attachment[]>([]);

    const [comments, setComments] =
        useState<Comment[]>([]);

    const [generations, setGenerations] =
        useState<AIGeneration[]>([]);

    const [histories, setHistories] =
        useState<History[]>([]);

    async function handleCreateComment(
        message: string
    ) {

        try {

            await api.post(
                `/tickets/${id}/comments`,
                {
                    message
                }
            );

            const response =
                await api.get(
                    `/tickets/${id}/comments`
                );

            setComments(
                response.data.data
            );

            await loadHistories();

        } catch (error) {

            console.error(error);

        }

    }

    async function loadHistories() {

        try {

            const response = await api.get(
                `/tickets/${id}/history`
            );

            setHistories(
                response.data.data
            );

        } catch (error) {

            console.error(error);

        }

    }

    async function handleGenerateKnowledgeArticle() {

        try {

            const response = await api.post(
                `/tickets/${id}/knowledge-articles`,
                {
                    query: "Gerar artigo de conhecimento"
                }
            );

            alert(response.data.message);

            setTimeout(() => {
                window.location.reload();
            }, 3000);

        } catch (error) {

            console.error(error);

        }

    }

    useEffect(() => {

        api.get(`/tickets/${id}`)
            .then((response) => {

                setTicket(
                    response.data.data
                );

            })
            .catch(console.error);

        api.get(
            `/tickets/${id}/attachments`
        )
        .then((response) => {

            setAttachments(
                response.data.data
            );

        })
        .catch(console.error);
        
        api.get(`/tickets/${id}/comments`)
            .then((response) => {

                setComments(
                    response.data.data
                );

            })
            .catch(console.error);

        loadHistories();


        async function loadGenerations() {

            try {

                const response = await api.get(
                    `/tickets/${id}/ai-generations`
                );

                setGenerations(
                    response.data.data
                );

            } catch (error) {

                console.error(error);

            }

        }

        loadGenerations();

    }, [id]);

    if (!ticket) {

    return (
        <h1>
            Carregando...
        </h1>
    );

}

const latestSummary =
    generations
        .filter(
            generation =>
                generation.type === "summary"
                && generation.status === "completed"
        )
        .sort(
            (a, b) =>
                new Date(
                    b.created_at
                ).getTime()
                -
                new Date(
                    a.created_at
                ).getTime()
        )[0];

const latestKnowledgeArticle =
    generations
        .filter(
            generation =>
                generation.type ===
                    "knowledge_article"
                &&
                generation.status ===
                    "completed"
        )
        .sort(
            (a, b) =>
                new Date(
                    b.created_at
                ).getTime()
                -
                new Date(
                    a.created_at
                ).getTime()
        )[0];

return (

    <div>

        <TicketInfoCard
            ticket={ticket}
        />

        <AttachmentsCard
            attachments={attachments}
        />

        <CommentsCard
            comments={comments}
        />

        <CommentForm
            onSubmit={
                handleCreateComment
            }
        />

        <AIGenerationsCard
            summary={latestSummary}
            knowledgeArticle={
                latestKnowledgeArticle
            }
            onGenerateKnowledgeArticle={
                handleGenerateKnowledgeArticle
            }
        />
        
        <HistoryTimeline
            histories={histories}
        />

    </div>

);
}