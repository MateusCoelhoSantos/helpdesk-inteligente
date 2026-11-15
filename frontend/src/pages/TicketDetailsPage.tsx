import { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import api from "../api/axios";
import TicketInfoCard from "../components/Ticket/TicketInfoCard";
import type { Ticket } from "../types/Ticket";
import CommentsCard from "../components/Ticket/CommentsCard";
import type { Comment } from "../types/Comment";

export default function TicketDetailsPage() {

    const { id } = useParams();

    const [ticket, setTicket] =
        useState<Ticket | null>(null);

    const [comments, setComments] =
    useState<Comment[]>([]);

    useEffect(() => {

        api.get(`/tickets/${id}`)
            .then((response) => {

                setTicket(
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

    }, [id]);

    if (!ticket) {

    return (
        <h1>
            Carregando...
        </h1>
    );

}

return (

    <div>

        <TicketInfoCard
            ticket={ticket}
        />

        <CommentsCard
            comments={comments}
        />

    </div>

);
}