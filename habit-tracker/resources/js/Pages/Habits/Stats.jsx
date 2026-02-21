import React from 'react';
import { Head, Link } from '@inertiajs/react';
import { BarChart, Bar, XAxis, YAxis, Tooltip, ResponsiveContainer, Cell } from 'recharts';
import { ChevronLeft, BarChart3, PieChart, Flame, Bell, Download } from 'lucide-react';
import { toast } from 'sonner';

export default function Stats({ stats }) {

    const enableNotifications = () => {
        if (!("Notification" in window)) {
            toast.error("هذا المتصفح لا يدعم التنبيهات");
            return;
        }

        Notification.requestPermission().then(permission => {
            if (permission === "granted") {
                new Notification("HabitSync مفعّل! 🚀", {
                    body: "سنقوم بتذكيرك بعاداتك يومياً لنحافظ على الـ Streak.",
                    // icon: "/logo-blue.png" // يمكن إضافة أيقونة لاحقاً
                });
                toast.success("تم تفعيل التنبيهات بنجاح!");
            } else {
                toast.error("تم رفض إذن التنبيهات.");
            }
        });
    };

    return (
        <div className="min-h-screen bg-[#1a1a1a] text-white relative overflow-hidden font-sans p-8">
            {/* الخلفية المنقطة */}
            <div className="absolute inset-0 z-0 opacity-10"
                 style={{ backgroundImage: 'radial-gradient(#ffffff 1px, transparent 1px)', backgroundSize: '40px 40px' }}>
            </div>

            <Head title="تحليلات الأداء - HabitSync" />

            <div className="relative z-10 max-w-6xl mx-auto">
                <header className="flex justify-between items-center mb-12">
                    <div className="flex items-center gap-4">
                        <Link href={route('habits.index')} className="p-3 bg-white/5 rounded-2xl hover:bg-[#0ea5e9] transition-all">
                            <ChevronLeft size={24} />
                        </Link>
                        <h1 className="text-3xl font-black">تحليلات <span className="text-[#0ea5e9]">الأداء</span></h1>
                    </div>

                    <a
                        href="/habits/export"
                        target="_blank"
                        className="flex items-center gap-2 px-6 py-3 bg-[#0ea5e9]/10 border border-[#0ea5e9]/20 text-[#0ea5e9] rounded-2xl hover:bg-[#0ea5e9] hover:text-white transition-all font-bold text-sm shadow-lg shadow-[#0ea5e9]/5"
                    >
                        <Download size={18} />
                        تصدير البيانات (CSV)
                    </a>
                </header>

                <div className="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                    {/* كرت الرسم البياني */}
                    <div className="bg-[#242424]/80 backdrop-blur-xl p-8 rounded-[3rem] border border-white/5 h-[500px] flex flex-col">
                        <h3 className="text-xl font-bold mb-8 flex items-center gap-2">
                            <BarChart3 className="text-[#0ea5e9]" /> مقارنة الإنجاز
                        </h3>
                        <div className="flex-1 w-full">
                            <ResponsiveContainer width="100%" height="100%">
                                <BarChart data={stats}>
                                    <XAxis dataKey="name" stroke="#666" fontSize={12} tickLine={false} axisLine={false} />
                                    <Tooltip
                                        cursor={{fill: 'transparent'}}
                                        contentStyle={{ backgroundColor: '#1a1a1a', border: 'none', borderRadius: '15px', fontWeight: 'bold' }}
                                    />
                                    <Bar dataKey="completed" radius={[10, 10, 10, 10]} barSize={40}>
                                        {stats.map((entry, index) => (
                                            <Cell key={`cell-${index}`} fill={index % 2 === 0 ? '#0ea5e9' : '#ffffff'} />
                                        ))}
                                    </Bar>
                                </BarChart>
                            </ResponsiveContainer>
                        </div>
                    </div>

                    <div className="flex flex-col gap-8">
                        {/* كرت كفاءة الالتزام */}
                        <div className="bg-[#242424]/80 backdrop-blur-xl p-8 rounded-[3rem] border border-white/5 flex-1">
                            <h3 className="text-xl font-bold mb-8 flex items-center gap-2">
                                <PieChart className="text-[#0ea5e9]" /> كفاءة العادات (%)
                            </h3>
                            <div className="space-y-6">
                                {stats.map((habit, i) => (
                                    <div key={i}>
                                        <div className="flex justify-between mb-2">
                                            <span className="font-bold">{habit.name}</span>
                                            <span className="text-[#0ea5e9] font-black">{habit.efficiency}%</span>
                                        </div>
                                        <div className="w-full bg-white/5 h-3 rounded-full overflow-hidden">
                                            <div
                                                className="bg-[#0ea5e9] h-full rounded-full transition-all duration-1000"
                                                style={{ width: `${habit.efficiency}%` }}
                                            ></div>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </div>

                        {/* كرت التنبيهات */}
                        <div className="bg-[#242424]/80 backdrop-blur-xl p-8 rounded-[3rem] border border-white/5 flex justify-between items-center">
                            <div>
                                <h3 className="text-xl font-bold italic flex items-center gap-2">
                                    <Bell className="text-[#0ea5e9]" /> تنبيهات الانضباط
                                </h3>
                                <p className="text-gray-400 text-sm mt-1 font-medium">فعل التنبيهات عشان ما يصفر الـ Streak حقك.</p>
                            </div>

                            <button
                                onClick={enableNotifications}
                                className="px-6 py-3 bg-white/5 border border-white/10 rounded-2xl hover:bg-[#0ea5e9] hover:text-white transition-all font-black text-xs uppercase tracking-widest"
                            >
                                تفعيل الآن
                            </button>
                        </div>
                    </div>
                </div>

                {/* قسم الأوسمة (Badges) */}
                <div className="bg-[#242424]/80 backdrop-blur-xl p-8 rounded-[3rem] border border-white/5">
                    <h3 className="text-xl font-bold mb-6 italic flex items-center gap-2">
                        <Flame className="text-orange-500" /> الأوسمة المحققة
                    </h3>
                    <div className="flex flex-wrap gap-8">
                        {stats.some(h => (h.best_streak || 0) >= 7) ? (
                            <div className="group relative flex flex-col items-center gap-2">
                                <div className="w-24 h-24 bg-[#0ea5e9]/10 border-2 border-[#0ea5e9] rounded-[2rem] flex items-center justify-center text-[#0ea5e9] shadow-[0_0_20px_rgba(14,165,233,0.2)] transition-transform duration-300 group-hover:scale-110 group-hover:rotate-3">
                                    <Flame size={48} strokeWidth={1.5} />
                                </div>
                                <span className="text-sm font-black text-white mt-2">أسبوع نار! 🔥</span>
                                <span className="text-[10px] text-gray-500 font-bold uppercase tracking-widest">7 أيام متتالية</span>
                            </div>
                        ) : (
                            <p className="text-gray-500 font-medium">استمر في عاداتك لمدة 7 أيام لفتح أول وسام!</p>
                        )}

                        {/* وسام المستوى 5 */}
                        {/* يمكن إضافة المزيد من الشروط هنا */}
                    </div>
                </div>
            </div>
        </div>
    );
}
