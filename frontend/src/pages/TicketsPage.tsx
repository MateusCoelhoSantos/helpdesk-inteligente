import { useEffect, useState } from "react";
import api from "../api/axios";
import { Link } from "react-router-dom";

interface Ticket {
    id: number;
    title: string;
    status: string;
    priority: string;
    category: string;
}

export default function TicketsPage() {

    const [tickets, setTickets] =
        useState<Ticket[]>([]);

    useEffect(() => {

        api.get("/tickets")
            .then((response) => {

                console.log(
                    response.data
                );

                setTickets(
                    response.data.data
                );

            })
            .catch((error) => {

                console.error(error);

            });

    }, []);

    return (

        <div>

            <h1>
                HelpDesk Inteligente
            </h1>

            <h3>
                Tickets:
            </h3>

            {tickets.map((ticket) => (

                <div
                    key={ticket.id}
                    style={{
                        border:
                            "1px solid #ccc",
                        padding: "10px",
                        marginBottom: "10px",
                    }}
                >

                    <h4>

                        <Link
                            to={`/tickets/${ticket.id}`}
                        >
                            {ticket.title}
                        </Link>

                    </h4>

                    <p>
                        Status:
                        {" "}
                        {ticket.status}
                    </p>

                    <p>
                        Categoria:
                        {" "}
                        {ticket.category}
                    </p>

                    <p>
                        Prioridade:
                        {" "}
                        {ticket.priority}
                    </p>

                </div>

            ))}

        </div>

    );
}