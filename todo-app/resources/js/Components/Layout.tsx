import React, { useEffect, useRef, useState } from 'react';
import { Link, usePage } from '@inertiajs/react';
import { PageProps } from '@/types';
import { AnimatePresence, motion } from 'framer-motion';

interface LayoutProps {
    children: React.ReactNode;
}

export default function Layout({ children }: LayoutProps) {
    const { props } = usePage<PageProps>();
    const [showToast, setShowToast] = useState(false);
    const canvasRef = useRef<HTMLCanvasElement>(null);

    useEffect(() => {
        if (props.message) {
            setShowToast(true);
            const timer = setTimeout(() => setShowToast(false), 3000);
            return () => clearTimeout(timer);
        }
    }, [props.message]);

    useEffect(() => {
        const canvas = canvasRef.current;
        if (!canvas) return;

        const ctx = canvas.getContext('2d');
        if (!ctx) return;

        let width = window.innerWidth;
        let height = window.innerHeight;
        canvas.width = width;
        canvas.height = height;

        const dots: { x: number; y: number; vx: number; vy: number; originalX: number; originalY: number }[] = [];
        const spacing = 30;
        const mouse = { x: -1000, y: -1000 };
        const radius = 100;

        for (let x = 0; x < width; x += spacing) {
            for (let y = 0; y < height; y += spacing) {
                dots.push({
                    x,
                    y,
                    vx: 0,
                    vy: 0,
                    originalX: x,
                    originalY: y
                });
            }
        }

        const animate = () => {
            ctx.clearRect(0, 0, width, height);

            dots.forEach(dot => {
                const dx = mouse.x - dot.x;
                const dy = mouse.y - dot.y;
                const distance = Math.sqrt(dx * dx + dy * dy);

                if (distance < radius) {
                    const angle = Math.atan2(dy, dx);
                    const force = (radius - distance) / radius;
                    const pushX = Math.cos(angle) * force * 5;
                    const pushY = Math.sin(angle) * force * 5;

                    dot.vx -= pushX;
                    dot.vy -= pushY;
                }

                const dxHome = dot.originalX - dot.x;
                const dyHome = dot.originalY - dot.y;

                dot.vx += dxHome * 0.05;
                dot.vy += dyHome * 0.05;

                dot.vx *= 0.8;
                dot.vy *= 0.8;

                dot.x += dot.vx;
                dot.y += dot.vy;

                ctx.fillStyle = 'rgba(56, 189, 248, 0.2)';
                ctx.beginPath();
                ctx.arc(dot.x, dot.y, 1.5, 0, Math.PI * 2);
                ctx.fill();
            });

            requestAnimationFrame(animate);
        };

        const handleMouseMove = (e: MouseEvent) => {
            mouse.x = e.clientX;
            mouse.y = e.clientY;
        };

        const handleResize = () => {
            width = window.innerWidth;
            height = window.innerHeight;
            canvas.width = width;
            canvas.height = height;
        };

        window.addEventListener('mousemove', handleMouseMove);
        window.addEventListener('resize', handleResize);
        const animationId = requestAnimationFrame(animate);

        return () => {
            window.removeEventListener('mousemove', handleMouseMove);
            window.removeEventListener('resize', handleResize);
            cancelAnimationFrame(animationId);
        };
    }, []);

    return (
        <div className="min-h-screen bg-[#1a1a1a] text-slate-200 font-sans selection:bg-cyan-500/30">
            {/* Toast Notification */}
            <AnimatePresence>
                {showToast && props.message && (
                    <motion.div
                        initial={{ opacity: 0, y: -50, x: '-50%' }}
                        animate={{ opacity: 1, y: 0, x: '-50%' }}
                        exit={{ opacity: 0, y: -50, x: '-50%' }}
                        className="fixed top-6 left-1/2 z-[100] flex items-center gap-3 px-6 py-3 bg-cyan-500/10 backdrop-blur-md border border-cyan-500/20 rounded-full shadow-lg shadow-cyan-500/20"
                    >
                        <div className="w-6 h-6 rounded-full bg-cyan-500 flex items-center justify-center">
                            <svg className="w-4 h-4 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2.5} d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span className="text-cyan-400 font-medium">{props.message}</span>
                    </motion.div>
                )}
            </AnimatePresence>

            {/* Interactive Background */}
            <canvas
                ref={canvasRef}
                className="fixed inset-0 pointer-events-none z-0"
            />

            {/* Ambient Glow */}
            <div className="fixed top-0 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-cyan-500/10 blur-[120px] rounded-full pointer-events-none z-0"></div>

            {/* Navbar */}
            <nav className="relative z-50 backdrop-blur-md bg-[#1a1a1a]/70 border-b border-white/5 sticky top-0">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex justify-between items-center h-20">
                        <Link href="/todos" className="flex items-center gap-3 group">
                            <div className="relative w-10 h-10 flex items-center justify-center bg-gradient-to-tr from-cyan-500 to-blue-600 rounded-xl shadow-lg shadow-cyan-500/20 group-hover:shadow-cyan-500/40 transition-all duration-300">
                                <svg className="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2.5} d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span className="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-white to-slate-400">
                                Todo<span className="text-cyan-400">App</span>
                            </span>
                        </Link>

                        <Link
                            href="/todos/create"
                            className="group relative px-6 py-2.5 bg-cyan-500/10 hover:bg-cyan-500/20 text-cyan-400 rounded-lg border border-cyan-500/20 hover:border-cyan-500/50 transition-all duration-300 overflow-hidden"
                        >
                            <div className="absolute inset-0 bg-cyan-400/10 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                            <span className="relative flex items-center gap-2 font-medium">
                                <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 4v16m8-8H4" />
                                </svg>
                                New Task
                            </span>
                        </Link>
                    </div>
                </div>
            </nav>

            {/* Main Content */}
            <main className="relative z-10 max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                {children}
            </main>
        </div>
    );
}
