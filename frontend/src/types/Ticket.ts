export interface Ticket {
    id: number;

    title: string;

    description: string;

    category: string;

    category_label: string;

    priority: string;

    priority_label: string;

    status: string;

    status_label: string;

    created_at: string;

    updated_at: string;

    resolved_at: string | null;

    resolution_time: string | null;

    ai_provider: string | null;

    ai_confidence: number | null;
}