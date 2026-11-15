import type { Attachment }
from "../../types/Attachment";

interface Props {
    attachments: Attachment[];
}

export default function AttachmentsCard(
    { attachments }: Props
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
                Anexos
            </h2>

            {attachments.length === 0 && (

                <p>
                    Nenhum anexo encontrado.
                </p>

            )}

            {attachments.map(
                attachment => (

                <div
                    key={attachment.id}
                    style={{
                        marginBottom: "12px"
                    }}
                >

                    <a
                        href={
                            `http://127.0.0.1:8000/storage/${attachment.file_path}`
                        }
                        target="_blank"
                        rel="noreferrer"
                    >
                        📎 {attachment.original_name}
                    </a>

                    <div>

                        <small>

                            enviado por {" "}
                            {
                                attachment.user.name
                            }

                        </small>

                    </div>

                </div>

            ))}

        </div>

    );

}