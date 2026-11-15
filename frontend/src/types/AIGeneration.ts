export interface AIGeneration {
    id: number;

    type: string;

    status: string;

    result: {
        title?: string;
        problem?: string;
        cause?: string;
        solution?: string;
        prevention?: string;
        summary?: string;
    } | null;

    error: string | null;

    created_at: string;
}