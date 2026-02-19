import React, { useState, useEffect } from 'react';
import { Head, Link, router } from '@inertiajs/react';
import { motion, AnimatePresence } from 'framer-motion';
import {
    Plus, Trash2, Edit2, X, Save, StickyNote, Calendar, Pin,
    Tag, CheckCircle, AlertCircle, Loader2, Search, LayoutGrid, List,
    Settings, LogOut, Filter, Menu, Eye, AlertTriangle, Clock
} from 'lucide-react';

interface Note {
    id: number;
    title: string;
    content: string;
    is_pinned: boolean;
    category: string;
    status: string;
    created_at: string;
    updated_at: string;
}

interface Link {
    url: string | null;
    label: string;
    active: boolean;
}

interface Pagination {
    data: Note[];
    links: Link[];
    current_page: number;
    last_page: number;
    prev_page_url: string | null;
    next_page_url: string | null;
}

interface Props {
    notes: Pagination;
}

export default function Index({ notes }: Props) {
    // State Management
    const [isCreating, setIsCreating] = useState(false);
    const [editingId, setEditingId] = useState<number | null>(null);
    const [viewingNote, setViewingNote] = useState<Note | null>(null);
    const [deletingId, setDeletingId] = useState<number | null>(null);
    const [isUpdating, setIsUpdating] = useState(false);
    const [isDeleting, setIsDeleting] = useState(false);
    const [viewMode, setViewMode] = useState<'grid' | 'list'>('grid');
    const [searchQuery, setSearchQuery] = useState('');
    const [selectedCategory, setSelectedCategory] = useState<string | null>(null);
    const [isSidebarOpen, setIsSidebarOpen] = useState(true);

    const [formData, setFormData] = useState({
        title: '',
        content: '',
        is_pinned: false,
        category: 'عام',
        status: 'جديد'
    });

    const categories = ['عام', 'عمل', 'شخصي', 'دراسة', 'أفكار', 'تسوق'];
    const statuses = ['جديد', 'قيد التنفيذ', 'مكتمل', 'معلق'];

    // Handle Screen Resize
    useEffect(() => {
        const handleResize = () => {
            if (window.innerWidth < 1024) {
                setIsSidebarOpen(false);
            } else {
                setIsSidebarOpen(true);
            }
        };
        handleResize();
        window.addEventListener('resize', handleResize);
        return () => window.removeEventListener('resize', handleResize);
    }, []);

    // Filtering Logic
    const filteredNotes = notes.data.filter(note => {
        const matchesCategory = selectedCategory ? note.category === selectedCategory : true;
        const matchesSearch = note.title.toLowerCase().includes(searchQuery.toLowerCase()) ||
                              note.content.toLowerCase().includes(searchQuery.toLowerCase());
        return matchesCategory && matchesSearch;
    });

    // Helpers for Colors
    const getStatusColor = (status: string) => {
        switch(status) {
            case 'مكتمل': return 'text-emerald-400 border-emerald-500/30 bg-emerald-500/10';
            case 'قيد التنفيذ': return 'text-blue-400 border-blue-500/30 bg-blue-500/10';
            case 'معلق': return 'text-amber-400 border-amber-500/30 bg-amber-500/10';
            default: return 'text-gray-400 border-gray-500/30 bg-gray-500/10';
        }
    };

    const getCategoryColor = (category: string) => {
        switch(category) {
            case 'عمل': return 'bg-purple-500/20 text-purple-300 border-purple-500/30';
            case 'شخصي': return 'bg-rose-500/20 text-rose-300 border-rose-500/30';
            case 'دراسة': return 'bg-indigo-500/20 text-indigo-300 border-indigo-500/30';
            case 'أفكار': return 'bg-amber-500/20 text-amber-300 border-amber-500/30';
            case 'تسوق': return 'bg-emerald-500/20 text-emerald-300 border-emerald-500/30';
            default: return 'bg-gray-500/20 text-gray-300 border-gray-500/30';
        }
    };

    // Handlers
    const handleCreate = (e: React.FormEvent) => {
        e.preventDefault();
        router.post('/notes', formData, {
            onSuccess: () => {
                setIsCreating(false);
                setFormData({ title: '', content: '', is_pinned: false, category: 'عام', status: 'جديد' });
            },
        });
    };

    const handleUpdate = (id: number) => {
        if (!id) return;
        setIsUpdating(true);
        router.post(`/notes/${id}`, { ...formData, _method: 'PUT' }, {
            onSuccess: () => {
                setEditingId(null);
                setFormData({ title: '', content: '', is_pinned: false, category: 'عام', status: 'جديد' });
                setIsUpdating(false);
            },
            onError: () => setIsUpdating(false),
            onFinish: () => setIsUpdating(false)
        });
    };

    const confirmDelete = (id: number) => {
        setDeletingId(id);
    };

    const handleDelete = () => {
        if (!deletingId) return;
        setIsDeleting(true);

        // استخدام POST مع _method: 'DELETE' لتجنب مشاكل 405
        router.post(`/notes/${deletingId}`, {
            _method: 'DELETE'
        }, {
            onSuccess: () => {
                setDeletingId(null);
                setIsDeleting(false);
            },
            onError: () => setIsDeleting(false),
            onFinish: () => setIsDeleting(false)
        });
    };

    const startEditing = (note: Note) => {
        setEditingId(note.id);
        setFormData({
            title: note.title,
            content: note.content,
            is_pinned: note.is_pinned,
            category: note.category,
            status: note.status
        });
    };

    const togglePin = (note: Note) => {
        if (!note.id) return;
        router.post(`/notes/${note.id}`, { ...note, is_pinned: !note.is_pinned, _method: 'PUT' });
    };

    return (
        <div className="min-h-screen bg-[#1a1a1a] text-white font-sans flex overflow-hidden relative" dir="rtl">
            <Head title="لوحة التحكم" />

            {/* Dotted Background Pattern */}
            <div className="absolute inset-0 pointer-events-none opacity-[0.07]"
                 style={{
                     backgroundImage: 'radial-gradient(#ffffff 1px, transparent 1px)',
                     backgroundSize: '24px 24px'
                 }}>
            </div>

            {/* Sidebar */}
            <aside
                className={`w-72 bg-[#1a1a1a] border-l border-[#333] flex flex-col fixed h-full right-0 z-40 transition-transform duration-300 ease-in-out ${
                    isSidebarOpen ? 'translate-x-0' : 'translate-x-full'
                }`}
            >
                <div className="p-8 border-b border-[#333] flex justify-between items-center">
                    <div className="flex items-center gap-3">
                        <div className="bg-white/10 p-2.5 rounded-xl border border-white/10 backdrop-blur-sm">
                            <StickyNote className="w-6 h-6 text-violet-400" />
                        </div>
                        <div>
                            <h1 className="text-xl font-bold tracking-tight text-white">ملاحظاتي</h1>
                            <p className="text-xs text-gray-500 font-medium mt-0.5">لوحة التحكم الشخصية</p>
                        </div>
                    </div>
                    <button
                        onClick={() => setIsSidebarOpen(false)}
                        className="lg:hidden text-gray-400 hover:text-white"
                    >
                        <X className="w-6 h-6" />
                    </button>
                </div>

                <nav className="flex-1 p-6 space-y-2 overflow-y-auto">
                    <div className="mb-8">
                        <button
                            onClick={() => setSelectedCategory(null)}
                            className={`w-full flex items-center gap-3 px-4 py-3.5 rounded-xl font-bold transition-all duration-200 ${
                                selectedCategory === null
                                ? 'bg-violet-600 text-white shadow-lg shadow-violet-900/20'
                                : 'text-gray-400 hover:bg-[#252525] hover:text-white'
                            }`}
                        >
                            <LayoutGrid className="w-5 h-5" />
                            <span>كل الملاحظات</span>
                        </button>
                    </div>

                    <div className="space-y-1">
                        <p className="px-4 text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-4">التصنيفات</p>
                        {categories.map(cat => (
                            <button
                                key={cat}
                                onClick={() => setSelectedCategory(cat)}
                                className={`w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all text-sm font-medium group ${
                                    selectedCategory === cat
                                    ? 'bg-[#252525] text-white border border-[#333]'
                                    : 'text-gray-400 hover:bg-[#252525] hover:text-white border border-transparent'
                                }`}
                            >
                                <div className="flex items-center gap-3">
                                    <span className={`w-2 h-2 rounded-full ${getCategoryColor(cat).split(' ')[0].replace('bg-', 'bg-')}`}></span>
                                    {cat}
                                </div>
                                {selectedCategory === cat && <CheckCircle className="w-4 h-4 text-violet-400" />}
                            </button>
                        ))}
                    </div>
                </nav>

                <div className="p-6 border-t border-[#333]">
                    <button className="w-full flex items-center gap-3 px-4 py-3 text-gray-400 hover:bg-[#252525] hover:text-white rounded-xl transition-colors text-sm font-medium">
                        <Settings className="w-5 h-5" />
                        <span>الإعدادات</span>
                    </button>
                </div>
            </aside>

            {/* Overlay for mobile */}
            {isSidebarOpen && (
                <div
                    className="fixed inset-0 bg-black/50 z-30 lg:hidden backdrop-blur-sm"
                    onClick={() => setIsSidebarOpen(false)}
                ></div>
            )}

            {/* Main Content */}
            <main
                className={`flex-1 min-h-screen relative z-10 transition-all duration-300 ease-in-out ${
                    isSidebarOpen ? 'lg:mr-72' : 'lg:mr-0'
                }`}
            >
                {/* Top Bar */}
                <header className="bg-[#1a1a1a]/80 backdrop-blur-xl border-b border-[#333] sticky top-0 z-30 px-8 py-5 flex justify-between items-center">
                    <div className="flex items-center gap-6 flex-1 max-w-2xl">
                        <button
                            onClick={() => setIsSidebarOpen(!isSidebarOpen)}
                            className="p-2 text-gray-400 hover:text-white hover:bg-[#252525] rounded-lg transition-colors"
                        >
                            <Menu className="w-6 h-6" />
                        </button>

                        <div className="relative flex-1 group">
                            <Search className="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-500 group-focus-within:text-violet-400 transition-colors" />
                            <input
                                type="text"
                                placeholder="ابحث عن ملاحظة..."
                                className="w-full pl-4 pr-12 py-3 bg-[#252525] border border-[#333] rounded-xl text-sm text-white placeholder-gray-600 focus:ring-2 focus:ring-violet-500/50 focus:border-violet-500 transition-all"
                                value={searchQuery}
                                onChange={(e) => setSearchQuery(e.target.value)}
                            />
                        </div>
                        <div className="flex bg-[#252525] p-1 rounded-xl border border-[#333]">
                            <button
                                onClick={() => setViewMode('grid')}
                                className={`p-2.5 rounded-lg transition-all ${viewMode === 'grid' ? 'bg-[#333] text-white shadow-sm' : 'text-gray-500 hover:text-gray-300'}`}
                            >
                                <LayoutGrid className="w-5 h-5" />
                            </button>
                            <button
                                onClick={() => setViewMode('list')}
                                className={`p-2.5 rounded-lg transition-all ${viewMode === 'list' ? 'bg-[#333] text-white shadow-sm' : 'text-gray-500 hover:text-gray-300'}`}
                            >
                                <List className="w-5 h-5" />
                            </button>
                        </div>
                    </div>

                    <div className="flex items-center gap-4">
                        <button
                            onClick={() => setIsCreating(true)}
                            className="bg-white text-black hover:bg-gray-200 px-6 py-3 rounded-xl font-bold shadow-[0_0_20px_rgba(255,255,255,0.1)] flex items-center gap-2 transition-all active:scale-95"
                        >
                            <Plus className="w-5 h-5" />
                            <span>إضافة ملاحظة</span>
                        </button>
                    </div>
                </header>

                {/* Content Area */}
                <div className="p-8">
                    <AnimatePresence mode="popLayout">
                        <div className={viewMode === 'grid' ? "grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-6" : "space-y-4"}>
                            {filteredNotes.length > 0 ? (
                                filteredNotes.map((note, index) => (
                                    <motion.div
                                        key={note.id}
                                        layout
                                        initial={{ opacity: 0, scale: 0.95, y: 10 }}
                                        animate={{ opacity: 1, scale: 1, y: 0 }}
                                        exit={{ opacity: 0, scale: 0.95, y: -10 }}
                                        transition={{ duration: 0.2 }}
                                        className={`bg-[#252525] rounded-2xl border border-[#333] hover:border-violet-500/30 hover:shadow-[0_0_30px_rgba(139,92,246,0.05)] transition-all group relative overflow-hidden ${viewMode === 'list' ? 'flex items-center gap-6 p-5' : 'p-6 flex flex-col h-[280px]'}`}
                                    >
                                        {/* Pin Indicator */}
                                        {note.is_pinned && (
                                            <div className="absolute top-0 left-0 w-full h-1 bg-violet-500 shadow-[0_0_15px_#8b5cf6]"></div>
                                        )}

                                        {editingId === note.id ? (
                                            <div className="flex flex-col h-full gap-4 w-full">
                                                <input
                                                    type="text"
                                                    value={formData.title}
                                                    onChange={(e) => setFormData({ ...formData, title: e.target.value })}
                                                    className="bg-[#1a1a1a] p-3 rounded-xl text-lg font-bold text-white border border-[#333] focus:border-violet-500 focus:ring-1 focus:ring-violet-500 outline-none transition-all"
                                                    placeholder="العنوان"
                                                    autoFocus
                                                />
                                                <div className="flex gap-2">
                                                    <select
                                                        value={formData.category}
                                                        onChange={(e) => setFormData({ ...formData, category: e.target.value })}
                                                        className="bg-[#1a1a1a] text-gray-300 p-2 rounded-lg text-xs border border-[#333] focus:border-violet-500 outline-none w-1/2"
                                                    >
                                                        {categories.map(cat => <option key={cat} value={cat}>{cat}</option>)}
                                                    </select>
                                                    <select
                                                        value={formData.status}
                                                        onChange={(e) => setFormData({ ...formData, status: e.target.value })}
                                                        className="bg-[#1a1a1a] text-gray-300 p-2 rounded-lg text-xs border border-[#333] focus:border-violet-500 outline-none w-1/2"
                                                    >
                                                        {statuses.map(stat => <option key={stat} value={stat}>{stat}</option>)}
                                                    </select>
                                                </div>
                                                <textarea
                                                    value={formData.content}
                                                    onChange={(e) => setFormData({ ...formData, content: e.target.value })}
                                                    className="bg-[#1a1a1a] p-3 rounded-xl flex-1 resize-none text-sm text-gray-300 border border-[#333] focus:border-violet-500 focus:ring-1 focus:ring-violet-500 outline-none transition-all"
                                                    placeholder="المحتوى..."
                                                />
                                                <div className="flex justify-end gap-2 mt-auto">
                                                    <button onClick={() => setEditingId(null)} className="p-2 hover:bg-[#333] rounded-full text-gray-400"><X className="w-5 h-5" /></button>
                                                    <button
                                                        onClick={() => handleUpdate(note.id)}
                                                        disabled={isUpdating}
                                                        className="p-2 bg-violet-600 hover:bg-violet-500 rounded-full text-white disabled:opacity-50 shadow-lg shadow-violet-900/20"
                                                    >
                                                        {isUpdating ? <Loader2 className="w-5 h-5 animate-spin" /> : <Save className="w-5 h-5" />}
                                                    </button>
                                                </div>
                                            </div>
                                        ) : (
                                            <>
                                                <div className={`flex justify-between items-start ${viewMode === 'list' ? 'w-1/4' : 'mb-5'}`}>
                                                    <div className="flex gap-2">
                                                        <span className={`px-3 py-1 rounded-lg text-[11px] font-bold border ${getCategoryColor(note.category)}`}>
                                                            {note.category}
                                                        </span>
                                                        <span className={`px-3 py-1 rounded-lg text-[11px] font-bold border ${getStatusColor(note.status)}`}>
                                                            {note.status}
                                                        </span>
                                                    </div>
                                                    <button
                                                        onClick={() => togglePin(note)}
                                                        className={`transition-all duration-300 ${note.is_pinned ? 'text-violet-400 rotate-45' : 'text-[#444] hover:text-white'}`}
                                                    >
                                                        <Pin className={`w-4 h-4 ${note.is_pinned ? 'fill-current' : ''}`} />
                                                    </button>
                                                </div>

                                                <div className={viewMode === 'list' ? 'flex-1' : 'flex-1 flex flex-col'}>
                                                    <h3 className="text-lg font-bold text-white mb-3 line-clamp-1 group-hover:text-violet-300 transition-colors">
                                                        {note.title}
                                                    </h3>
                                                    <p className="text-gray-400 text-sm leading-relaxed line-clamp-4 flex-1">
                                                        {note.content}
                                                    </p>
                                                </div>

                                                <div className={`flex items-center justify-between pt-5 mt-auto border-t border-[#333] ${viewMode === 'list' ? 'w-1/4 justify-end gap-4 border-t-0 pt-0 mt-0' : ''}`}>
                                                    <div className="flex items-center gap-2 text-xs text-gray-500 font-medium">
                                                        <Calendar className="w-3.5 h-3.5" />
                                                        <span>{new Date(note.created_at).toLocaleDateString('ar-SA')}</span>
                                                    </div>

                                                    <div className="flex gap-1 opacity-0 group-hover:opacity-100 transition-all translate-y-2 group-hover:translate-y-0">
                                                        <button onClick={() => setViewingNote(note)} className="p-2 hover:bg-[#333] rounded-lg text-gray-400 hover:text-blue-400 transition-colors" title="عرض التفاصيل">
                                                            <Eye className="w-4 h-4" />
                                                        </button>
                                                        <button onClick={() => startEditing(note)} className="p-2 hover:bg-[#333] rounded-lg text-gray-400 hover:text-white transition-colors" title="تعديل">
                                                            <Edit2 className="w-4 h-4" />
                                                        </button>
                                                        <button onClick={() => confirmDelete(note.id)} className="p-2 hover:bg-rose-900/20 rounded-lg text-gray-400 hover:text-rose-400 transition-colors" title="حذف">
                                                            <Trash2 className="w-4 h-4" />
                                                        </button>
                                                    </div>
                                                </div>
                                            </>
                                        )}
                                    </motion.div>
                                ))
                            ) : (
                                <div className="col-span-full flex flex-col items-center justify-center py-32 text-gray-600">
                                    <div className="bg-[#252525] p-6 rounded-full mb-4 border border-[#333]">
                                        <Search className="w-12 h-12 opacity-50" />
                                    </div>
                                    <p className="text-lg font-medium text-gray-400">لا توجد ملاحظات تطابق بحثك</p>
                                    <p className="text-sm mt-2">جرب تغيير كلمات البحث أو التصنيف</p>
                                </div>
                            )}
                        </div>
                    </AnimatePresence>

                    {/* Pagination */}
                    <div className="mt-12 flex justify-center">
                        <div className="flex items-center gap-1 bg-[#252525] p-1.5 rounded-xl border border-[#333] shadow-lg">
                            {notes.links.map((link, key) => (
                                link.url ? (
                                    <Link
                                        key={key}
                                        href={link.url}
                                        className={`px-4 py-2 rounded-lg text-sm font-bold transition-all ${
                                            link.active
                                                ? 'bg-violet-600 text-white shadow-md'
                                                : 'text-gray-500 hover:bg-[#333] hover:text-white'
                                        }`}
                                        dangerouslySetInnerHTML={{ __html: link.label }}
                                    />
                                ) : (
                                    <span
                                        key={key}
                                        className="px-4 py-2 text-sm text-[#444] font-bold cursor-not-allowed"
                                        dangerouslySetInnerHTML={{ __html: link.label }}
                                    />
                                )
                            ))}
                        </div>
                    </div>
                </div>
            </main>

            {/* Create Modal */}
            <AnimatePresence>
                {isCreating && (
                    <div className="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
                        <motion.div
                            initial={{ opacity: 0, scale: 0.95, y: 20 }}
                            animate={{ opacity: 1, scale: 1, y: 0 }}
                            exit={{ opacity: 0, scale: 0.95, y: 20 }}
                            className="bg-[#1a1a1a] rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden border border-[#333]"
                        >
                            <div className="p-6 border-b border-[#333] flex justify-between items-center bg-[#252525]">
                                <h2 className="text-lg font-bold text-white flex items-center gap-3">
                                    <div className="bg-violet-600 p-2 rounded-lg">
                                        <Plus className="w-5 h-5 text-white" />
                                    </div>
                                    إضافة ملاحظة جديدة
                                </h2>
                                <button onClick={() => setIsCreating(false)} className="text-gray-400 hover:text-white hover:bg-[#333] p-2 rounded-full transition-colors"><X className="w-5 h-5" /></button>
                            </div>

                            <form onSubmit={handleCreate} className="p-6 space-y-5">
                                <div>
                                    <label className="block text-sm font-bold text-gray-400 mb-2">العنوان</label>
                                    <input
                                        type="text"
                                        value={formData.title}
                                        onChange={(e) => setFormData({ ...formData, title: e.target.value })}
                                        className="w-full px-4 py-3 rounded-xl border border-[#333] bg-[#252525] text-white focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-all outline-none"
                                        placeholder="عنوان الملاحظة..."
                                        required
                                        autoFocus
                                    />
                                </div>

                                <div className="grid grid-cols-2 gap-4">
                                    <div>
                                        <label className="block text-sm font-bold text-gray-400 mb-2">التصنيف</label>
                                        <select
                                            value={formData.category}
                                            onChange={(e) => setFormData({ ...formData, category: e.target.value })}
                                            className="w-full px-4 py-3 rounded-xl border border-[#333] bg-[#252525] text-white focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-all outline-none"
                                        >
                                            {categories.map(cat => <option key={cat} value={cat}>{cat}</option>)}
                                        </select>
                                    </div>
                                    <div>
                                        <label className="block text-sm font-bold text-gray-400 mb-2">الحالة</label>
                                        <select
                                            value={formData.status}
                                            onChange={(e) => setFormData({ ...formData, status: e.target.value })}
                                            className="w-full px-4 py-3 rounded-xl border border-[#333] bg-[#252525] text-white focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-all outline-none"
                                        >
                                            {statuses.map(stat => <option key={stat} value={stat}>{stat}</option>)}
                                        </select>
                                    </div>
                                </div>

                                <div className="flex items-center gap-3 p-4 bg-[#252525] rounded-xl border border-[#333]">
                                    <input
                                        type="checkbox"
                                        id="is_pinned"
                                        checked={formData.is_pinned}
                                        onChange={(e) => setFormData({ ...formData, is_pinned: e.target.checked })}
                                        className="w-5 h-5 text-violet-600 border-gray-600 rounded focus:ring-violet-500 bg-[#1a1a1a]"
                                    />
                                    <label htmlFor="is_pinned" className="text-sm font-medium text-gray-300 cursor-pointer flex-1">تثبيت الملاحظة في الأعلى</label>
                                    <Pin className="w-4 h-4 text-gray-500" />
                                </div>

                                <div>
                                    <label className="block text-sm font-bold text-gray-400 mb-2">المحتوى</label>
                                    <textarea
                                        value={formData.content}
                                        onChange={(e) => setFormData({ ...formData, content: e.target.value })}
                                        className="w-full px-4 py-3 rounded-xl border border-[#333] bg-[#252525] text-white focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-all h-32 resize-none outline-none leading-relaxed"
                                        placeholder="اكتب تفاصيل ملاحظتك هنا..."
                                        required
                                    />
                                </div>
                                <div className="flex justify-end pt-2 gap-3">
                                    <button type="button" onClick={() => setIsCreating(false)} className="px-6 py-2.5 rounded-xl font-bold text-gray-400 hover:bg-[#333] hover:text-white transition-all">إلغاء</button>
                                    <button type="submit" className="bg-violet-600 hover:bg-violet-500 text-white font-bold py-2.5 px-8 rounded-xl shadow-lg shadow-violet-900/20 hover:shadow-xl hover:-translate-y-0.5 transition-all flex items-center gap-2">
                                        <Save className="w-5 h-5" />
                                        <span>حفظ</span>
                                    </button>
                                </div>
                            </form>
                        </motion.div>
                    </div>
                )}
            </AnimatePresence>

            {/* View Note Modal */}
            <AnimatePresence>
                {viewingNote && (
                    <div className="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
                        <motion.div
                            initial={{ opacity: 0, scale: 0.95, y: 20 }}
                            animate={{ opacity: 1, scale: 1, y: 0 }}
                            exit={{ opacity: 0, scale: 0.95, y: 20 }}
                            className="bg-[#1a1a1a] rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden border border-[#333] max-h-[90vh] flex flex-col"
                        >
                            <div className="p-6 border-b border-[#333] flex justify-between items-start bg-[#252525]">
                                <div>
                                    <div className="flex gap-2 mb-3">
                                        <span className={`px-3 py-1 rounded-lg text-[11px] font-bold border ${getCategoryColor(viewingNote.category)}`}>
                                            {viewingNote.category}
                                        </span>
                                        <span className={`px-3 py-1 rounded-lg text-[11px] font-bold border ${getStatusColor(viewingNote.status)}`}>
                                            {viewingNote.status}
                                        </span>
                                    </div>
                                    <h2 className="text-2xl font-bold text-white leading-tight">{viewingNote.title}</h2>
                                </div>
                                <button onClick={() => setViewingNote(null)} className="text-gray-400 hover:text-white hover:bg-[#333] p-2 rounded-full transition-colors"><X className="w-6 h-6" /></button>
                            </div>

                            <div className="p-8 overflow-y-auto custom-scrollbar">
                                <p className="text-gray-300 text-lg leading-relaxed whitespace-pre-wrap">
                                    {viewingNote.content}
                                </p>
                            </div>

                            <div className="p-6 border-t border-[#333] bg-[#252525] flex justify-between items-center text-sm text-gray-500">
                                <div className="flex items-center gap-4">
                                    <div className="flex items-center gap-2">
                                        <Calendar className="w-4 h-4" />
                                        <span>تم الإنشاء: {new Date(viewingNote.created_at).toLocaleDateString('ar-SA')}</span>
                                    </div>
                                    <div className="flex items-center gap-2">
                                        <Clock className="w-4 h-4" />
                                        <span>آخر تحديث: {new Date(viewingNote.updated_at).toLocaleDateString('ar-SA')}</span>
                                    </div>
                                </div>
                                <button
                                    onClick={() => {
                                        setViewingNote(null);
                                        startEditing(viewingNote);
                                    }}
                                    className="text-violet-400 hover:text-violet-300 font-bold flex items-center gap-2"
                                >
                                    <Edit2 className="w-4 h-4" />
                                    تعديل الملاحظة
                                </button>
                            </div>
                        </motion.div>
                    </div>
                )}
            </AnimatePresence>

            {/* Delete Confirmation Modal */}
            <AnimatePresence>
                {deletingId && (
                    <div className="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
                        <motion.div
                            initial={{ opacity: 0, scale: 0.95 }}
                            animate={{ opacity: 1, scale: 1 }}
                            exit={{ opacity: 0, scale: 0.95 }}
                            className="bg-[#1a1a1a] rounded-2xl shadow-2xl w-full max-w-md overflow-hidden border border-[#333]"
                        >
                            <div className="p-8 text-center">
                                <div className="w-16 h-16 bg-rose-500/10 rounded-full flex items-center justify-center mx-auto mb-6">
                                    <AlertTriangle className="w-8 h-8 text-rose-500" />
                                </div>
                                <h3 className="text-xl font-bold text-white mb-2">هل أنت متأكد؟</h3>
                                <p className="text-gray-400 mb-8">
                                    أنت على وشك حذف هذه الملاحظة نهائياً. لا يمكن التراجع عن هذا الإجراء.
                                </p>
                                <div className="flex gap-3 justify-center">
                                    <button
                                        onClick={() => setDeletingId(null)}
                                        className="px-6 py-3 rounded-xl font-bold text-gray-400 hover:bg-[#333] hover:text-white transition-all"
                                    >
                                        إلغاء
                                    </button>
                                    <button
                                        onClick={handleDelete}
                                        disabled={isDeleting}
                                        className="bg-rose-600 hover:bg-rose-500 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-rose-900/20 hover:shadow-xl hover:-translate-y-0.5 transition-all flex items-center gap-2 disabled:opacity-50"
                                    >
                                        {isDeleting ? <Loader2 className="w-5 h-5 animate-spin" /> : <Trash2 className="w-5 h-5" />}
                                        <span>نعم، احذفها</span>
                                    </button>
                                </div>
                            </div>
                        </motion.div>
                    </div>
                )}
            </AnimatePresence>
        </div>
    );
}
