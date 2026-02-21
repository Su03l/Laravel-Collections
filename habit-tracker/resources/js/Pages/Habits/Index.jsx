import React, { useState, useEffect } from 'react';
import { Head, useForm, router, usePage } from '@inertiajs/react';
import { Plus, Check, Flame, Trophy, Activity, Calendar, X, Save, BarChart3 } from 'lucide-react';
import { Toaster, toast } from 'sonner';

//
export default function Index({ habits }) {
    const { flash, auth } = usePage().props;
    const [showModal, setShowModal] = useState(false); // حالة إظهار المودال

    const { data, setData, post, reset, processing, errors } = useForm({
        name: '',
        description: '',
        color: '#0ea5e9',
        icon: 'Activity'
    });

    useEffect(() => {
        if (flash.message) {
            toast.success(flash.message);
        }
    }, [flash]);

    const submit = (e) => {
        e.preventDefault();
        post(route('habits.store'), {
            onSuccess: () => {
                setShowModal(false);
                reset();
            },
        });
    };

    //
    const playSuccessSound = () => {
        const audio = new Audio('/sounds/success-pop.mp3'); // ملف صغير جداً
        audio.volume = 0.2;
        audio.play().catch(e => console.log("Audio play failed", e)); // Handle potential autoplay restrictions
    };

    // دالة تسجيل الإنجاز
    const toggleHabit = (id) => {
        playSuccessSound(); // تشغيل الصوت فوراً للتفاعل اللحظي
        router.post(`/habits/${id}/toggle`, {}, {
            preserveScroll: true,
        });
    };

    return (
        <div className="min-h-screen bg-[#1a1a1a] text-white relative overflow-hidden font-sans">
            <Toaster position="top-center" richColors />
            {/* الخلفية المنقطة (Dot Pattern) */}
            <div className="absolute inset-0 z-0 opacity-20"
                 style={{ backgroundImage: 'radial-gradient(#ffffff 1px, transparent 1px)', backgroundSize: '30px 30px' }}>
            </div>

            <Head title="HabitSync - متتبع العادات" />

            <div className="relative z-10 max-w-5xl mx-auto px-6 py-12">

                {/* Header */}
                <header className="flex justify-between items-center mb-16">
                    <div>
                        <h1 className="text-4xl font-black tracking-tighter text-white flex items-center gap-2">
                            <Activity className="text-[#0ea5e9] w-10 h-10" />
                            HABIT<span className="text-[#0ea5e9]">SYNC</span>
                        </h1>
                        <p className="text-gray-400 mt-2 font-medium">ابدأ ببناء روتينك المثالي اليوم.</p>
                    </div>

                    <div className="flex items-center gap-6">
                         {/* User Level & XP */}
                        <div className="flex flex-col items-end">
                            <div className="flex items-center gap-3 mb-1">
                                <span className="text-xs font-black text-gray-500 uppercase">المستوى {auth.user.level}</span>
                                <div className="w-32 h-2 bg-white/5 rounded-full overflow-hidden border border-white/10">
                                    <div
                                        className="bg-[#0ea5e9] h-full shadow-[0_0_10px_#0ea5e9] transition-all duration-1000"
                                        style={{ width: `${auth.user.xp % 100}%` }}
                                    ></div>
                                </div>
                            </div>
                            <span className="text-[10px] font-bold text-[#0ea5e9]">{auth.user.xp} XP إجمالي</span>
                        </div>

                        <button
                            onClick={() => router.visit(route('habits.stats'))}
                            className="bg-white/5 text-white hover:bg-[#0ea5e9] hover:text-white px-4 py-3 rounded-full font-bold transition-all duration-300 flex items-center gap-2 border border-white/10">
                            <BarChart3 size={20} />
                        </button>

                        <button
                            onClick={() => setShowModal(true)}
                            className="bg-white text-black hover:bg-[#0ea5e9] hover:text-white px-8 py-3 rounded-full font-bold transition-all duration-300 flex items-center gap-2 shadow-lg shadow-white/5">
                            <Plus size={20} />
                            عادة جديدة
                        </button>
                    </div>
                </header>

                {/* Statistics Cards */}
                <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                    <StatCard title="إجمالي العادات" value={habits.length} icon={<Calendar className="text-[#0ea5e9]" />} />
                    <StatCard title="أعلى سلسلة (Best)" value={habits.length > 0 ? Math.max(...habits.map(h => h.best_streak)) : 0} icon={<Trophy className="text-yellow-500" />} />
                    <StatCard title="نشط الآن" value={habits.filter(h => h.current_streak > 0).length} icon={<Flame className="text-orange-500" />} />
                </div>

                {/* Habits List */}
                <div className="grid gap-4">
                    {habits.map((habit) => {
                        const todayString = new Date().toISOString().split('T')[0];
                        const isCompletedToday = habit.logs.some(log =>
                            new Date(log.completed_date).toISOString().split('T')[0] === todayString && log.completed
                        );

                        return (
                            <div key={habit.id}
                                 className={`group relative bg-[#242424]/80 backdrop-blur-sm p-6 rounded-[2rem] border-2 transition-all duration-500 flex justify-between items-center
                                 ${isCompletedToday ? 'border-[#0ea5e9] bg-[#0ea5e9]/5' : 'border-white/5 hover:border-white/20'}`}>

                                <div className="flex items-center gap-6">
                                    <div className={`w-14 h-14 rounded-2xl flex items-center justify-center transition-transform duration-500 group-hover:scale-110
                                        ${isCompletedToday ? 'bg-[#0ea5e9] text-white' : 'bg-[#2a2a2a] text-gray-400'}`}
                                        style={{ backgroundColor: isCompletedToday ? habit.color : '#2a2a2a' }}>
                                        <Activity size={28} />
                                    </div>

                                    <div>
                                        <h3 className="text-2xl font-bold tracking-tight">{habit.name}</h3>
                                        <div className="flex items-center gap-4 mt-1">
                                            <span className="flex items-center gap-1 text-sm font-semibold text-orange-500">
                                                <Flame size={16} />
                                                {habit.current_streak} أيام متتالية
                                            </span>
                                        </div>

                                        {/* Weekly Progress Mini-Calendar */}
                                        <div className="flex gap-2 mt-4">
                                            {[...Array(7)].map((_, i) => {
                                                const date = new Date();
                                                date.setDate(date.getDate() - (6 - i));
                                                const dateString = date.toISOString().split('T')[0];

                                                const isDayCompleted = habit.logs.some(log =>
                                                    new Date(log.completed_date).toISOString().split('T')[0] === dateString && log.completed
                                                );

                                                return (
                                                    <div key={i} className="flex flex-col items-center gap-1">
                                                        <div
                                                            className={`w-3 h-3 rounded-full transition-all duration-500 ${
                                                                isDayCompleted
                                                                ? 'shadow-[0_0_8px]'
                                                                : 'bg-white/10'
                                                            }`}
                                                            style={isDayCompleted ? { backgroundColor: habit.color, boxShadow: `0 0 8px ${habit.color}` } : {}}
                                                        />
                                                        <span className="text-[10px] text-gray-500 font-bold uppercase">
                                                            {date.toLocaleDateString('ar-SA', { weekday: 'narrow' })}
                                                        </span>
                                                    </div>
                                                );
                                            })}
                                        </div>
                                    </div>
                                </div>

                                <button
                                    onClick={() => toggleHabit(habit.id)}
                                    className={`w-16 h-16 rounded-full flex items-center justify-center transition-all duration-300 border-4
                                    ${isCompletedToday
                                        ? 'bg-[#0ea5e9] border-[#0ea5e9] text-white rotate-[360deg]'
                                        : 'bg-transparent border-white/10 text-white/10 hover:border-[#0ea5e9] hover:text-[#0ea5e9]'}`}
                                    style={isCompletedToday ? { backgroundColor: habit.color, borderColor: habit.color } : {}}>
                                    <Check size={32} strokeWidth={3} />
                                </button>
                            </div>
                        );
                    })}
                </div>

                {habits.length === 0 && (
                    <div className="text-center py-20 border-2 border-dashed border-white/5 rounded-[3rem]">
                        <p className="text-gray-500 font-medium">لا توجد عادات مضافة بعد.. ابدأ بإضافة أول عادة!</p>
                    </div>
                )}
            </div>

            {/* --- Modal (نافذة الإضافة) --- */}
            {showModal && (
                <div className="fixed inset-0 z-50 flex items-center justify-center p-6">
                    {/* Overlay (خلفية ضبابية) */}
                    <div className="absolute inset-0 bg-black/80 backdrop-blur-md" onClick={() => setShowModal(false)}></div>

                    {/* Modal Content */}
                    <div className="relative bg-[#242424] w-full max-w-lg rounded-[3rem] border border-white/10 p-10 shadow-2xl animate-in fade-in zoom-in duration-300">
                        <div className="flex justify-between items-center mb-8">
                            <h2 className="text-3xl font-black italic">أضف <span className="text-[#0ea5e9]">عادة</span></h2>
                            <button onClick={() => setShowModal(false)} className="p-2 hover:bg-white/5 rounded-full transition-colors">
                                <X size={24} />
                            </button>
                        </div>

                        <form onSubmit={submit} className="space-y-6">
                            <div>
                                <label className="block text-xs font-black uppercase tracking-widest text-gray-500 mb-2">اسم العادة</label>
                                <input
                                    type="text"
                                    value={data.name}
                                    onChange={e => setData('name', e.target.value)}
                                    className="w-full bg-[#1a1a1a] border-2 border-white/5 rounded-2xl p-4 focus:border-[#0ea5e9] outline-none transition-all text-xl font-bold"
                                    placeholder="مثلاً: القراءة، الجيم..."
                                    required
                                />
                                {errors.name && <p className="text-red-500 text-sm mt-1">{errors.name}</p>}
                            </div>

                            <div>
                                <label className="block text-xs font-black uppercase tracking-widest text-gray-500 mb-2">اللون المميز</label>
                                <div className="flex gap-3">
                                    {['#0ea5e9', '#f97316', '#a855f7', '#10b981', '#ef4444'].map(color => (
                                        <button
                                            key={color}
                                            type="button"
                                            onClick={() => setData('color', color)}
                                            className={`w-10 h-10 rounded-full border-4 transition-all ${data.color === color ? 'border-white scale-110' : 'border-transparent'}`}
                                            style={{ backgroundColor: color }}
                                        />
                                    ))}
                                </div>
                            </div>

                            <button
                                type="submit"
                                disabled={processing}
                                className="w-full bg-[#0ea5e9] hover:bg-[#38bdf8] text-white py-5 rounded-2xl font-black text-xl transition-all flex items-center justify-center gap-3 shadow-xl shadow-[#0ea5e9]/20">
                                <Save size={24} />
                                {processing ? 'جاري الحفظ...' : 'حفظ العادة'}
                            </button>
                        </form>
                    </div>
                </div>
            )}
        </div>
    );
}

function StatCard({ title, value, icon }) {
    return (
        <div className="bg-[#242424]/50 backdrop-blur-md p-8 rounded-[2.5rem] border border-white/5 hover:border-white/10 transition-all">
            <div className="flex justify-between items-start mb-4">
                <div className="p-3 bg-white/5 rounded-2xl">{icon}</div>
                <span className="text-4xl font-black">{value}</span>
            </div>
            <p className="text-gray-400 font-bold uppercase tracking-widest text-xs">{title}</p>
        </div>
    );
}
