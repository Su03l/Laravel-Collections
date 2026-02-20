import React from 'react';
import { Head, Link, router } from '@inertiajs/react';
import Layout from '@/Components/Layout';
import { Todo } from '@/types';

interface Props {
    todo: Todo;
}

export default function Show({ todo }: Props) {
    const toggleComplete = () => {
        router.patch(`/todos/${todo.id}/toggle`);
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
            <Head title={todo.title} />

            <div className="max-w-3xl mx-auto">
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

                {/* Todo Card */}
                <div className="bg-[#252525]/60 backdrop-blur-xl rounded-3xl border border-white/10 overflow-hidden shadow-2xl shadow-black/50">
                    {/* Header Image/Gradient */}
                    <div className="h-32 bg-gradient-to-r from-cyan-900/40 to-blue-900/40 relative">
                        <div className="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20"></div>
                        <div className="absolute -bottom-6 left-8">
                            <div className={`inline-flex items-center gap-2 px-4 py-2 rounded-xl border backdrop-blur-md shadow-lg ${getPriorityColor(todo.priority)}`}>
                                <span className="w-2 h-2 rounded-full bg-current animate-pulse"></span>
                                <span className="font-bold tracking-wide text-sm uppercase">{todo.priority} Priority</span>
                            </div>
                        </div>
                    </div>

                    <div className="p-8 pt-12">
                        {/* Title & Status */}
                        <div className="flex flex-col md:flex-row justify-between items-start gap-4 mb-8">
                            <h1 className={`text-4xl font-bold text-white leading-tight ${todo.completed ? 'line-through decoration-slate-500 text-slate-400' : ''}`}>
                                {todo.title}
                            </h1>
                            <div className={`px-4 py-2 rounded-lg font-medium text-sm border ${
                                todo.completed
                                    ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20'
                                    : 'bg-amber-500/10 text-amber-400 border-amber-500/20'
                            }`}>
                                {todo.completed ? '✓ Completed' : '○ Pending'}
                            </div>
                        </div>

                        {/* Description */}
                        {todo.description && (
                            <div className="mb-8 bg-[#1a1a1a] rounded-2xl p-6 border border-white/5">
                                <h2 className="text-sm font-medium text-cyan-400 mb-3 uppercase tracking-wider">Description</h2>
                                <p className="text-slate-300 text-lg leading-relaxed whitespace-pre-wrap">
                                    {todo.description}
                                </p>
                            </div>
                        )}

                        {/* Meta Info */}
                        <div className="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                            {todo.due_date && (
                                <div className="bg-[#1a1a1a] rounded-xl p-4 border border-white/5 flex items-center gap-4">
                                    <div className="p-3 rounded-lg bg-cyan-500/10 text-cyan-400">
                                        <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p className="text-xs text-slate-500 uppercase tracking-wider font-medium">Due Date</p>
                                        <p className="text-white font-medium">
                                            {new Date(todo.due_date).toLocaleDateString('en-US', {
                                                weekday: 'long',
                                                year: 'numeric',
                                                month: 'long',
                                                day: 'numeric'
                                            })}
                                        </p>
                                    </div>
                                </div>
                            )}

                            <div className="bg-[#1a1a1a] rounded-xl p-4 border border-white/5 flex items-center gap-4">
                                <div className="p-3 rounded-lg bg-slate-700/30 text-slate-400">
                                    <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p className="text-xs text-slate-500 uppercase tracking-wider font-medium">Created At</p>
                                    <p className="text-white font-medium">
                                        {new Date(todo.created_at).toLocaleDateString('en-US', {
                                            year: 'numeric',
                                            month: 'short',
                                            day: 'numeric'
                                        })}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {/* Actions */}
                        <div className="flex flex-col sm:flex-row gap-4 pt-8 border-t border-white/10">
                            <button
                                onClick={toggleComplete}
                                className={`flex-1 px-6 py-4 rounded-xl font-bold text-lg transition-all duration-300 flex items-center justify-center gap-2 ${
                                    todo.completed
                                        ? 'bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500/20 border border-emerald-500/20'
                                        : 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white hover:shadow-lg hover:shadow-cyan-500/25'
                                }`}
                            >
                                {todo.completed ? (
                                    <>
                                        <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                                        Mark as Pending
                                    </>
                                ) : (
                                    <>
                                        <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" /></svg>
                                        Mark as Completed
                                    </>
                                )}
                            </button>

                            <div className="flex gap-4">
                                <Link
                                    href={`/todos/${todo.id}/edit`}
                                    className="px-6 py-4 bg-[#1a1a1a] border border-white/10 rounded-xl text-slate-300 hover:text-white hover:border-cyan-500/50 hover:bg-cyan-500/5 transition-all font-medium flex items-center gap-2"
                                >
                                    <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit
                                </Link>

                                <Link
                                    as="button"
                                    method="delete"
                                    href={`/todos/${todo.id}`}
                                    className="px-6 py-4 bg-[#1a1a1a] border border-white/10 rounded-xl text-rose-400 hover:text-rose-300 hover:border-rose-500/50 hover:bg-rose-500/10 transition-all font-medium flex items-center gap-2"
                                >
                                    <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Delete
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </Layout>
    );
}
