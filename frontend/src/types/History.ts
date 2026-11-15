export interface History {
    id: number;

    action: string;

    description: string;

    created_at: string;

    user: {
        id: number;
        name: string;
    };
}