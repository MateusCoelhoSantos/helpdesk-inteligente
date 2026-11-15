import type { Comment } from "../../types/Comment";

interface CommentsCardProps {
    comments: Comment[];
}

export default function CommentsCard(
    { comments }: CommentsCardProps
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
                Comentários
            </h2>

            {comments.length === 0 && (

                <p>
                    Nenhum comentário encontrado.
                </p>

            )}

            {comments.map(comment => (

                <div
                    key={comment.id}
                    style={{
                        borderBottom: "1px solid #ddd",
                        marginBottom: "12px",
                        paddingBottom: "12px"
                    }}
                >

                    <strong>
                        {comment.user.name}
                    </strong>

                    <p
                        style={{
                            color: "#777",
                            fontSize: "14px"
                        }}
                    >
                        {
                            new Date(
                                comment.created_at
                            ).toLocaleString()
                        }
                    </p>

                    <p>
                        {comment.message}
                    </p>

                </div>

            ))}

        </div>

    );

}