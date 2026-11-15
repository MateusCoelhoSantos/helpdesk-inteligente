export interface Attachment {
    id: number;

    original_name: string;

    file_path: string;

    created_at: string;

    user: {
        id: number;
        name: string;
    };
}