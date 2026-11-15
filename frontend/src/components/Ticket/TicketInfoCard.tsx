import type { Ticket } from "../../types/Ticket";

interface TicketInfoCardProps {
    ticket: Ticket;
}

export default function TicketInfoCard(
    { ticket }: TicketInfoCardProps
) {

    return (

        <div
            style={{
                border: "1px solid #444",
                padding: "20px",
                borderRadius: "8px",
                marginBottom: "20px"
            }}
        >

            <h1>
                {ticket.title}
            </h1>

            <hr />

            <p>
                <strong>
                    Descrição:
                </strong>
            </p>

            <p>
                {ticket.description}
            </p>

            <p>
                <strong>
                    Categoria:
                </strong>{" "}
                {ticket.category_label}
            </p>

            <p>
                <strong>
                    Prioridade:
                </strong>{" "}
                {ticket.priority_label}
            </p>

            <p>
                <strong>
                    Status:
                </strong>{" "}
                {ticket.status_label}
            </p>

            <p>
                <strong>
                    Criado em:
                </strong>{" "}
                {new Date(
                    ticket.created_at
                ).toLocaleString()}
            </p>

            <p>
                <strong>
                    Atualizado em:
                </strong>{" "}
                {new Date(
                    ticket.updated_at
                ).toLocaleString()}
            </p>

        </div>

    );

}