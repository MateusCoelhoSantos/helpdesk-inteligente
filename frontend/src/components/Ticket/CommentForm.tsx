import { useState } from "react";

interface Props {
    onSubmit: (
        message: string
    ) => Promise<void>;
}

export default function CommentForm(
    { onSubmit }: Props
) {

    const [message, setMessage] =
        useState("");

    async function handleSubmit(
        e: React.FormEvent
    ) {

        e.preventDefault();

        if (!message.trim()) {
            return;
        }

        await onSubmit(message);

        setMessage("");
    }

    return (

        <form
            onSubmit={handleSubmit}
            style={{
                marginTop: "20px"
            }}
        >

            <h2>
                Novo Comentário
            </h2>

            <textarea
                rows={4}
                value={message}
                onChange={(e) =>
                    setMessage(
                        e.target.value
                    )
                }
                style={{
                    width: "100%"
                }}
            />

            <button
                type="submit"
            >
                Adicionar comentário
            </button>

        </form>

    );

}