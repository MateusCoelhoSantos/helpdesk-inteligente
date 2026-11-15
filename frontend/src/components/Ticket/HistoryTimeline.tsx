import type { History } from "../../types/History";

interface Props {
    histories: History[];
}

function getActionIcon(
    action: string
) {

    switch (action) {

        case "assigned":
            return "👤";

        case "commented":
            return "💬";

        case "status_changed":
            return "📌";

        case "priority_changed":
            return "⚠️";

        case "category_changed":
            return "📁";

        default:
            return "•";
    }
}

export default function HistoryTimeline(
    { histories }: Props
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
                Histórico
            </h2>

            {histories.map(history => (

                <div
                    key={history.id}
                    style={{
                        marginBottom: "16px",
                        borderBottom:
                            "1px solid #ddd",
                        paddingBottom: "12px"
                    }}
                >

                    <div>

                        {getActionIcon(
                            history.action
                        )}

                        {" "}

                        {history.description}

                    </div>

                    <small
                        style={{
                            color: "#777"
                        }}
                    >
                        {
                            new Date(
                                history.created_at
                            ).toLocaleString()
                        }
                    </small>

                </div>

            ))}

        </div>

    );

}