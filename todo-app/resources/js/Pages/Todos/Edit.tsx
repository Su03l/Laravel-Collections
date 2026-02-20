import React from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import Layout from '@/Components/Layout';
import { Todo, Category } from '@/types';

interface Props {
    todo: Todo;
    categories: Category[];
}

export default function Edit({ todo, categories }: Props) {
    const { data, setData, put, processing, errors } = useForm({
        title: todo.title,
        description: todo.description || '',
        priority: todo.priority,
        due_date: todo.due_date || '',
        categories: todo.categories ? todo.categories.map(c => c.id) : [] as number[],
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        put(`/todos/${todo.id}`);
    };

    return (
        <Layout>
            <Head title={`Edit ${todo.title}`} />

            <div className="max-w-2xl mx-auto">
                {/* Back Button */}
                <Link
                    href="/todos"
                    className="inline-flex items-center gap-2 text-slate-400 hover:text-cyan-400 mb-8 group transition-colors"
                >
                    <div className="p-2 rounded-lg bg-white/5 group-hover:bg-cyan-500/10 transition-colors">
                        <svg className="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </div>
                    <span className="font-medium">Back to Tasks</span>
                </Link>

                {/* Form Card */}
                <div className="bg-[#252525]/60 backdrop-blur-xl rounded-3xl border border-white/10 p-8 shadow-2xl shadow-black/50">
                    <div className="mb-8">
                        <h1 className="text-3xl font-bold text-white mb-2">Edit Task</h1>
                        <p className="text-slate-400">Update your task details and keep things on track.</p>
                    </div>

                    <form onSubmit={handleSubmit} className="space-y-6">
                        {/* Title */}
                        <div className="space-y-2">
                            <label className="block text-sm font-medium text-cyan-400 ml-1">
                                Task Title
                            </label>
                            <input
                                type="text"
                                value={data.title}
                                onChange={e => setData('title', e.target.value)}
                                className="w-full px-5 py-4 bg-[#1a1a1a] border border-white/10 rounded-xl text-white placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-cyan-500/50 focus:border-transparent transition-all"
                            />
                            {errors.title && (
                                <p className="text-sm text-rose-400 ml-1">{errors.title}</p>
                            )}
                        </div>

                        {/* Description */}
                        <div className="space-y-2">
                            <label className="block text-sm font-medium text-cyan-400 ml-1">
                                Description <span className="text-slate-600 font-normal">(Optional)</span>
                            </label>
                            <textarea
                                value={data.description}
                                onChange={e => setData('description', e.target.value)}
                                rows={4}
                                className="w-full px-5 py-4 bg-[#1a1a1a] border border-white/10 rounded-xl text-white placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-cyan-500/50 focus:border-transparent transition-all resize-none"
                            />
                        </div>

                        {/* Priority and Due Date */}
                        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div className="space-y-2">
                                <label className="block text-sm font-medium text-cyan-400 ml-1">
                                    Priority
                                </label>
                                <div className="relative">
                                    <select
                                        value={data.priority}
                                        onChange={e => setData('priority', e.target.value as 'low' | 'medium' | 'high')}
                                        className="w-full px-5 py-4 bg-[#1a1a1a] border border-white/10 rounded-xl text-white appearance-none focus:outline-none focus:ring-2 focus:ring-cyan-500/50 focus:border-transparent transition-all cursor-pointer"
                                    >
                                        <option value="low">Low Priority</option>
                                        <option value="medium">Medium Priority</option>
                                        <option value="high">High Priority</option>
                                    </select>
                                    <div className="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-500">
                                        <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div className="space-y-2">
                                <label className="block text-sm font-medium text-cyan-400 ml-1">
                                    Due Date <span className="text-slate-600 font-normal">(Optional)</span>
                                </label>
                                <input
                                    type="date"
                                    value={data.due_date}
                                    onChange={e => setData('due_date', e.target.value)}
                                    className="w-full px-5 py-4 bg-[#1a1a1a] border border-white/10 rounded-xl text-white placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-cyan-500/50 focus:border-transparent transition-all [color-scheme:dark]"
                                />
                            </div>
                        </div>

                        {/* Categories */}
                        <div className="space-y-2">
                            <label className="block text-sm font-medium text-cyan-400 ml-1">
                                Categories <span className="text-slate-600 font-normal">(Optional)</span>
                            </label>
                            <div className="grid grid-cols-2 md:grid-cols-4 gap-3 p-4 bg-[#1a1a1a] border border-white/10 rounded-xl">
                                {categories.map((category) => (
                                    <label
                                        key={category.id}
                                        className={`flex items-center gap-3 p-3 rounded-lg border cursor-pointer transition-all ${
                                            data.categories.includes(category.id)
                                                ? 'bg-cyan-500/10 border-cyan-500/50'
                                                : 'bg-white/5 border-transparent hover:bg-white/10'
                                        }`}
                                    >
                                        <input
                                            type="checkbox"
                                            value={category.id}
                                            checked={data.categories.includes(category.id)}
                                            onChange={(e) => {
                                                const newCategories = e.target.checked
                                                    ? [...data.categories, category.id]
                                                    : data.categories.filter(id => id !== category.id);
                                                setData('categories', newCategories);
                                            }}
                                            className="hidden"
                                        />
                                        <span
                                            className={`w-4 h-4 rounded-full border flex items-center justify-center transition-all ${
                                                data.categories.includes(category.id)
                                                    ? 'border-cyan-400 bg-cyan-400'
                                                    : 'border-slate-500'
                                            }`}
                                        >
                                            {data.categories.includes(category.id) && (
                                                <svg className="w-3 h-3 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={3} d="M5 13l4 4L19 7" />
                                                </svg>
                                            )}
                                        </span>
                                        <span className="text-sm font-medium text-slate-300" style={{ color: data.categories.includes(category.id) ? category.color : '' }}>
                                            {category.name}
                                        </span>
                                    </label>
                                ))}
                            </div>
                        </div>

                        {/* Submit Button */}
                        <div className="pt-6">
                            <button
                                type="submit"
                                disabled={processing}
                                className="w-full relative group overflow-hidden rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 p-[1px] transition-all duration-300 hover:shadow-[0_0_2rem_-0.5rem_#06b6d4]"
                            >
                                <div className="relative h-full w-full bg-[#1a1a1a] group-hover:bg-opacity-0 transition-all duration-300 rounded-[11px] px-8 py-4">
                                    <div className="flex items-center justify-center gap-2">
                                        {processing ? (
                                            <svg className="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4"></circle>
                                                <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                        ) : (
                                            <svg className="w-5 h-5 text-cyan-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                        )}
                                        <span className="font-bold text-lg text-white">
                                            {processing ? 'Updating...' : 'Update Task'}
                                        </span>
                                    </div>
                                </div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </Layout>
    );
}
