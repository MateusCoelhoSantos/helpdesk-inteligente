export interface Comment {
    id: number;

    message: string;

    created_at: string;

    user: {
        id: number;
        name: string;
    };
}