export interface Category {
    id: number;
    name: string;
    color: string;
    created_at: string;
    updated_at: string;
}

export interface Todo {
    id: number;
    title: string;
    description: string | null;
    completed: boolean;
    priority: 'low' | 'medium' | 'high';
    due_date: string | null;
    order: number;
    categories: Category[];
    created_at: string;
    updated_at: string;
}

export interface TodoFilters {
    filter: 'all' | 'completed' | 'pending';
    priority: 'all' | 'low' | 'medium' | 'high';
    category: 'all' | number;
    search: string;
}

export interface PageProps {
    todos?: Todo[];
    categories?: Category[];
    todo?: Todo;
    filters?: TodoFilters;
    message?: string;
}
