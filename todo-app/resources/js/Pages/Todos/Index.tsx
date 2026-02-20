import React, { useState, useEffect } from 'react';
import { Head, Link, router } from '@inertiajs/react';
import Layout from '@/Components/Layout';
import { Todo, Category, TodoFilters, PageProps } from '@/types';
import { AnimatePresence, motion } from 'framer-motion';
import {
    DndContext,
    closestCenter,
    KeyboardSensor,
    PointerSensor,
    useSensor,
    useSensors,
    DragEndEvent,
} from '@dnd-kit/core';
import {
    arrayMove,
    SortableContext,
    sortableKeyboardCoordinates,
    verticalListSortingStrategy,
    useSortable,
} from '@dnd-kit/sortable';
import { CSS } from '@dnd-kit/utilities';

interface Props extends PageProps {
    todos: Todo[];
    categories: Category[];
    filters: TodoFilters;
}

function SortableTodoItem({ todo, toggleComplete, setDeleteConfirm, getPriorityColor }: any) {
    const {
        attributes,
        listeners,
        setNodeRef,
        transform,
        transition,
        isDragging,
    } = useSortable({ id: todo.id });

    const style = {
        transform: CSS.Transform.toString(transform),
        transition,
        opacity: isDragging ? 0.5 : 1,
        zIndex: isDragging ? 999 : 'auto',
    };

    return (
        <div ref={setNodeRef} style={style} {...attributes}>
            <div className={`group relative bg-[#252525]/60 backdrop-blur-sm rounded-2xl border border-white/5 p-6 transition-all duration-300 hover:bg-[#2a2a2a] hover:border-cyan-500/30 hover:shadow-2xl hover:shadow-black/50 hover:-translate-y-1 ${
                todo.completed ? 'opacity-60 grayscale-[0.5]' : ''
            }`}>
                {/* Drag Handle */}
                <div
                    {...listeners}
                    className="absolute top-2 right-2 cursor-move p-2 text-slate-500 hover:text-cyan-400 transition-colors z-10"
                >
                    <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 8h16M4 16h16" />
                    </svg>
                </div>

                {/* Priority Badge */}
                <div className="flex justify-between items-start mb-4 pr-8">
                    <span className={`px-3 py-1 rounded-full text-xs font-semibold border ${getPriorityColor(todo.priority)}`}>
                        {todo.priority.toUpperCase()}
                    </span>
                    {todo.due_date && (
                        <span className="text-xs font-mono text-slate-500 bg-black/20 px-2 py-1 rounded">
                            {new Date(todo.due_date).toLocaleDateString('en-US', { month: 'short', day: 'numeric' })}
                        </span>
                    )}
                </div>

                {/* Categories */}
                {todo.categories && todo.categories.length > 0 && (
                    <div className="flex flex-wrap gap-2 mb-3">
                        {todo.categories.map((category: Category) => (
                            <span
                                key={category.id}
                                className="px-2 py-1 text-[10px] uppercase font-bold tracking-wider rounded-md text-white/90"
                                style={{ backgroundColor: category.color + '40', border: `1px solid ${category.color}60`, color: category.color }}
                            >
                                {category.name}
                            </span>
                        ))}
                    </div>
                )}

                {/* Content */}
                <div className="mb-6">
                    <h3 className={`text-xl font-bold text-white mb-2 line-clamp-1 group-hover:text-cyan-400 transition-colors ${todo.completed ? 'line-through decoration-slate-500' : ''}`}>
                        {todo.title}
                    </h3>
                    {todo.description && (
                        <p className="text-slate-400 text-sm line-clamp-2 leading-relaxed">
                            {todo.description}
                        </p>
                    )}
                </div>

                {/* Actions */}
                <div className="flex items-center gap-3 pt-4 border-t border-white/5 relative z-20">
                    <button
                        onClick={() => toggleComplete(todo)}
                        className={`flex-1 flex items-center justify-center gap-2 py-2 rounded-lg text-sm font-medium transition-all duration-300 ${
                            todo.completed
                                ? 'bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500/20'
                                : 'bg-white/5 text-slate-300 hover:bg-cyan-500/10 hover:text-cyan-400'
                        }`}
                    >
                        {todo.completed ? (
                            <>
                                <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" /></svg>
                                Done
                            </>
                        ) : (
                            <>
                                <span className="w-4 h-4 rounded-full border-2 border-current opacity-50"></span>
                                Complete
                            </>
                        )}
                    </button>

                    <div className="flex gap-1">
                        <Link
                            href={`/todos/${todo.id}`}
                            className="p-2 text-slate-400 hover:text-white hover:bg-white/10 rounded-lg transition-colors"
                        >
                            <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </Link>
                        <Link
                            href={`/todos/${todo.id}/edit`}
                            className="p-2 text-slate-400 hover:text-white hover:bg-white/10 rounded-lg transition-colors"
                        >
                            <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </Link>
                        <button
                            onClick={() => setDeleteConfirm(todo)}
                            className="p-2 text-slate-400 hover:text-rose-400 hover:bg-rose-500/10 rounded-lg transition-colors"
                        >
                            <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default function Index({ todos, categories, filters }: Props) {
    const [selectedFilter, setSelectedFilter] = useState<TodoFilters['filter']>(filters.filter);
    const [selectedPriority, setSelectedPriority] = useState<TodoFilters['priority']>(filters.priority);
    const [selectedCategory, setSelectedCategory] = useState<TodoFilters['category']>(filters.category);
    const [search, setSearch] = useState(filters.search);
    const [deleteConfirm, setDeleteConfirm] = useState<Todo | null>(null);
    const [localTodos, setLocalTodos] = useState(todos);

    // Update localTodos when todos prop changes (e.g. after filtering)
    useEffect(() => {
        setLocalTodos(todos);
    }, [todos]);

    const sensors = useSensors(
        useSensor(PointerSensor),
        useSensor(KeyboardSensor, {
            coordinateGetter: sortableKeyboardCoordinates,
        })
    );

    const updateFilters = (filterType: string, value: any) => {
        let newFilter = {
            filter: selectedFilter,
            priority: selectedPriority,
            category: selectedCategory,
            search: search
        };

        switch(filterType) {
            case 'filter':
                setSelectedFilter(value);
                newFilter.filter = value;
                break;
            case 'priority':
                setSelectedPriority(value);
                newFilter.priority = value;
                break;
            case 'category':
                setSelectedCategory(value);
                newFilter.category = value;
                break;
            case 'search':
                setSearch(value);
                newFilter.search = value;
                break;
        }

        router.get('/todos', newFilter as any, { preserveState: true, replace: true });
    };

    const handleDragEnd = (event: DragEndEvent) => {
        const { active, over } = event;

        if (active.id !== over?.id) {
            setLocalTodos((items) => {
                const oldIndex = items.findIndex((item) => item.id === active.id);
                const newIndex = items.findIndex((item) => item.id === over?.id);
                const newOrder = arrayMove(items, oldIndex, newIndex);

                // Send new order to server
                const orderData = newOrder.map((item, index) => ({
                    id: item.id,
                    order: index
                }));

                router.post('/todos/reorder', { order: orderData }, {
                    preserveState: true,
                    preserveScroll: true,
                });

                return newOrder;
            });
        }
    };

    const toggleComplete = (todo: Todo) => {
        router.patch(`/todos/${todo.id}/toggle`, {}, {
            preserveState: true,
            preserveScroll: true,
        });
    };

    const handleDelete = () => {
        if (deleteConfirm) {
            router.delete(`/todos/${deleteConfirm.id}`, {
                onSuccess: () => setDeleteConfirm(null),
            });
        }
    };

    const getPriorityColor = (priority: string) => {
        switch(priority) {
            case 'high': return 'bg-rose-500/20 text-rose-400 border-rose-500/30';
            case 'medium': return 'bg-amber-500/20 text-amber-400 border-amber-500/30';
            case 'low': return 'bg-emerald-500/20 text-emerald-400 border-emerald-500/30';
            default: return 'bg-slate-500/20 text-slate-400 border-slate-500/30';
        }
    };

    return (
        <Layout>
            <Head title="Tasks" />

            {/* Delete Confirmation Modal */}
            <AnimatePresence>
                {deleteConfirm && (
                    <div className="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
                        <motion.div
                            initial={{ opacity: 0, scale: 0.95 }}
                            animate={{ opacity: 1, scale: 1 }}
                            exit={{ opacity: 0, scale: 0.95 }}
                            className="bg-[#1a1a1a] border border-white/10 rounded-2xl p-6 max-w-md w-full shadow-2xl shadow-black/50"
                        >
                            <h3 className="text-xl font-bold text-white mb-2">Delete Task?</h3>
                            <p className="text-slate-400 mb-6">
                                Are you sure you want to delete <span className="text-cyan-400 font-semibold">"{deleteConfirm.title}"</span>? This action cannot be undone.
                            </p>
                            <div className="flex justify-end gap-3">
                                <button
                                    onClick={() => setDeleteConfirm(null)}
                                    className="px-4 py-2 rounded-lg text-slate-300 hover:bg-white/5 transition-colors"
                                >
                                    Cancel
                                </button>
                                <button
                                    onClick={handleDelete}
                                    className="px-4 py-2 rounded-lg bg-rose-500/20 text-rose-400 hover:bg-rose-500/30 border border-rose-500/20 transition-all"
                                >
                                    Delete Task
                                </button>
                            </div>
                        </motion.div>
                    </div>
                )}
            </AnimatePresence>

            {/* Header */}
            <div className="flex flex-col md:flex-row justify-between items-end mb-8 gap-6">
                <div>
                    <h1 className="text-5xl font-bold text-white mb-3 tracking-tight">
                        My Tasks
                    </h1>
                    <p className="text-slate-400 text-lg">
                        You have <span className="text-cyan-400 font-semibold">{todos.filter(t => !t.completed).length}</span> pending tasks today
                    </p>
                </div>
            </div>

            {/* Search Bar */}
            <div className="mb-8">
                <div className="relative group">
                    <input
                        type="text"
                        placeholder="Search tasks..."
                        value={search}
                        onChange={(e) => {
                            setSearch(e.target.value);
                            if (e.target.value.length > 2 || e.target.value.length === 0) {
                                updateFilters('search', e.target.value);
                            }
                        }}
                        className="w-full px-6 py-4 pl-14 bg-[#252525]/60 backdrop-blur-md border border-white/10 rounded-2xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/50 focus:border-transparent transition-all shadow-lg shadow-black/20"
                    />
                    <svg className="absolute left-5 top-4.5 w-6 h-6 text-slate-500 group-focus-within:text-cyan-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            {/* Filters */}
            <div className="mb-8 flex flex-wrap gap-4 bg-[#252525]/80 backdrop-blur-md p-2 rounded-2xl border border-white/5 shadow-xl shadow-black/20">
                <div className="flex bg-[#1a1a1a] rounded-xl p-1">
                    {(['all', 'pending', 'completed'] as const).map((status) => (
                        <button
                            key={status}
                            onClick={() => updateFilters('filter', status)}
                            className={`px-5 py-2 rounded-lg text-sm font-medium transition-all duration-300 capitalize ${
                                selectedFilter === status
                                    ? 'bg-cyan-500/20 text-cyan-400 shadow-lg shadow-cyan-500/10'
                                    : 'text-slate-400 hover:text-white hover:bg-white/5'
                            }`}
                        >
                            {status}
                        </button>
                    ))}
                </div>

                <select
                    value={selectedPriority}
                    onChange={(e) => updateFilters('priority', e.target.value)}
                    className="bg-[#1a1a1a] text-slate-300 text-sm rounded-xl px-4 py-2 border-none focus:ring-2 focus:ring-cyan-500/50 outline-none cursor-pointer hover:bg-[#2a2a2a] transition-colors"
                >
                    <option value="all">All Priorities</option>
                    <option value="high">High Priority</option>
                    <option value="medium">Medium Priority</option>
                    <option value="low">Low Priority</option>
                </select>

                <select
                    value={selectedCategory}
                    onChange={(e) => updateFilters('category', e.target.value)}
                    className="bg-[#1a1a1a] text-slate-300 text-sm rounded-xl px-4 py-2 border-none focus:ring-2 focus:ring-cyan-500/50 outline-none cursor-pointer hover:bg-[#2a2a2a] transition-colors"
                >
                    <option value="all">All Categories</option>
                    {categories.map((category) => (
                        <option key={category.id} value={category.id}>
                            {category.name}
                        </option>
                    ))}
                </select>

                <button
                    onClick={() => {
                        setSelectedFilter('all');
                        setSelectedPriority('all');
                        setSelectedCategory('all');
                        setSearch('');
                        router.get('/todos', { filter: 'all', priority: 'all', category: 'all', search: '' } as any);
                    }}
                    className="ml-auto px-4 py-2 text-sm text-slate-400 hover:text-white hover:bg-white/5 rounded-xl transition-colors"
                >
                    Clear Filters
                </button>
            </div>

            {/* Tasks Grid */}
            {localTodos.length === 0 ? (
                <div className="flex flex-col items-center justify-center py-32 text-center border-2 border-dashed border-white/5 rounded-3xl bg-white/[0.02]">
                    <div className="w-20 h-20 bg-cyan-500/10 rounded-full flex items-center justify-center mb-6 animate-pulse">
                        <svg className="w-10 h-10 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3 className="text-2xl font-bold text-white mb-2">No tasks found</h3>
                    <p className="text-slate-400 max-w-sm mx-auto mb-8">
                        Your list is empty. Start by creating a new task to keep track of your work.
                    </p>
                    <Link
                        href="/todos/create"
                        className="px-8 py-3 bg-cyan-500 hover:bg-cyan-400 text-black font-semibold rounded-xl transition-all duration-300 shadow-lg shadow-cyan-500/20 hover:shadow-cyan-500/40 hover:-translate-y-1"
                    >
                        Create First Task
                    </Link>
                </div>
            ) : (
                <DndContext
                    sensors={sensors}
                    collisionDetection={closestCenter}
                    onDragEnd={handleDragEnd}
                >
                    <SortableContext
                        items={localTodos.map(t => t.id)}
                        strategy={verticalListSortingStrategy}
                    >
                        <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                            {localTodos.map((todo) => (
                                <SortableTodoItem
                                    key={todo.id}
                                    todo={todo}
                                    toggleComplete={toggleComplete}
                                    setDeleteConfirm={setDeleteConfirm}
                                    getPriorityColor={getPriorityColor}
                                />
                            ))}
                        </div>
                    </SortableContext>
                </DndContext>
            )}
        </Layout>
    );
}
