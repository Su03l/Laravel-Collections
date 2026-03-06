<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CODE GALAXY // SYSTEM ONLINE</title>
    <meta name="description" content="Code Galaxy — Holographic Code Snippet Manager">

    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    {{-- Prism.js --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-php.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-javascript.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-sql.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-css.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-python.min.js" defer></script>

    <style>
        /* ╔══════════════════════════════════════════════════════════════╗
           ║  CODE GALAXY — SYSTEM STYLESHEET                           ║
           ║  Cyber-Brutalism × Ethereal WebGL                          ║
           ╚══════════════════════════════════════════════════════════════╝ */

        :root {
            --void: #000000;
            --abyss: #030305;
            --obsidian: #08080c;
            --graphite: #0e0e14;
            --slate: #16161e;
            --steel: #1e1e28;
            --ash: #2a2a36;
            --smoke: #3a3a48;
            --fog: #5a5a6a;
            --mist: #8a8a9a;
            --ghost: #b0b0be;

            --cyan: #00f0ff;
            --cyan-dim: #00a0aa;
            --cyan-glow: rgba(0, 240, 255, 0.08);
            --cyan-flare: rgba(0, 240, 255, 0.25);
            --cyan-ghost: rgba(0, 240, 255, 0.03);

            --panel-bg: rgba(8, 8, 14, 0.55);
            --panel-border: rgba(255, 255, 255, 0.04);
            --panel-hover: rgba(255, 255, 255, 0.07);

            --font-mono: 'JetBrains Mono', 'Fira Code', monospace;
            --font-display: 'Outfit', sans-serif;
            --font-ui: 'Inter', sans-serif;

            --scan-speed: 8s;
            --grain-opacity: 0.03;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--void);
            color: var(--ghost);
            font-family: var(--font-ui);
            overflow-x: hidden;
            min-height: 100vh;
            cursor: crosshair;
        }

        ::selection {
            background: var(--cyan);
            color: var(--void);
        }

        /* ═══════════ SCROLLBAR — MILITARY GRADE ═══════════ */
        ::-webkit-scrollbar {
            width: 4px;
        }

        ::-webkit-scrollbar-track {
            background: var(--void);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--ash);
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--cyan-dim);
        }

        /* ═══════════ WEBGL CANVAS ═══════════ */
        #voidCanvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: 0;
            pointer-events: none;
        }

        /* ═══════════ FILM GRAIN OVERLAY ═══════════ */
        .film-grain {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            pointer-events: none;
            opacity: var(--grain-opacity);
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='1'/%3E%3C/svg%3E");
            background-repeat: repeat;
            animation: grainShift 0.5s steps(5) infinite;
        }

        @keyframes grainShift {
            0% {
                transform: translate(0, 0);
            }

            20% {
                transform: translate(-3px, 2px);
            }

            40% {
                transform: translate(2px, -3px);
            }

            60% {
                transform: translate(-2px, -1px);
            }

            80% {
                transform: translate(3px, 3px);
            }

            100% {
                transform: translate(0, 0);
            }
        }

        /* ═══════════ SCAN LINES ═══════════ */
        .scan-lines {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 2;
            pointer-events: none;
            background: repeating-linear-gradient(0deg,
                    transparent,
                    transparent 2px,
                    rgba(0, 0, 0, 0.08) 2px,
                    rgba(0, 0, 0, 0.08) 4px);
        }

        /* ═══════════ HORIZONTAL SCAN BEAM ═══════════ */
        .scan-beam {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--cyan-flare), transparent);
            z-index: 3;
            pointer-events: none;
            animation: scanBeam var(--scan-speed) linear infinite;
            box-shadow: 0 0 30px 10px var(--cyan-glow);
        }

        @keyframes scanBeam {
            0% {
                top: -2px;
            }

            100% {
                top: 100vh;
            }
        }

        /* ═══════════ VOLUMETRIC FOG ORBS ═══════════ */
        .fog-orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(120px);
            z-index: 0;
            opacity: 0.06;
            animation: fogDrift 20s infinite ease-in-out alternate;
        }

        .fog-orb-1 {
            top: -20%;
            right: -15%;
            width: 60vw;
            height: 60vw;
            background: var(--cyan);
            animation-delay: 0s;
        }

        .fog-orb-2 {
            bottom: -20%;
            left: -15%;
            width: 50vw;
            height: 50vw;
            background: var(--cyan);
            animation-delay: -10s;
            opacity: 0.04;
        }

        .fog-orb-3 {
            top: 30%;
            left: 40%;
            width: 30vw;
            height: 30vw;
            background: var(--cyan);
            animation-delay: -5s;
            opacity: 0.03;
        }

        @keyframes fogDrift {
            0% {
                transform: translate(0, 0) scale(1);
            }

            100% {
                transform: translate(50px, 70px) scale(1.2);
            }
        }

        /* ═══════════ SYSTEM NAV — COMMAND BAR ═══════════ */
        .cmd-bar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 50;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            border-bottom: 1px solid var(--panel-border);
            padding: 0 24px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-family: var(--font-mono);
            transition: all 0.3s;
        }

        .cmd-bar.scrolled {
            border-bottom-color: rgba(0, 240, 255, 0.08);
            box-shadow: 0 1px 40px rgba(0, 0, 0, 0.5);
        }

        .cmd-bar__logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 11px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--ghost);
        }

        .cmd-bar__logo-mark {
            width: 8px;
            height: 8px;
            background: var(--cyan);
            clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%);
            box-shadow: 0 0 12px var(--cyan-flare);
            animation: logoPulse 3s ease-in-out infinite;
        }

        @keyframes logoPulse {

            0%,
            100% {
                opacity: 1;
                box-shadow: 0 0 12px var(--cyan-flare);
            }

            50% {
                opacity: 0.5;
                box-shadow: 0 0 4px var(--cyan-glow);
            }
        }

        .cmd-bar__meta {
            display: flex;
            align-items: center;
            gap: 16px;
            font-size: 10px;
            color: var(--fog);
            letter-spacing: 1px;
        }

        .cmd-bar__status {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .cmd-bar__dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: #00ff88;
            box-shadow: 0 0 8px rgba(0, 255, 136, 0.4);
            animation: statusBlink 2s infinite;
        }

        @keyframes statusBlink {

            0%,
            90%,
            100% {
                opacity: 1;
            }

            95% {
                opacity: 0.3;
            }
        }

        /* ═══════════ HERO — HOLOGRAPHIC TITLE ═══════════ */
        .hero {
            position: relative;
            z-index: 10;
            padding: 140px 24px 60px;
            text-align: center;
        }

        .hero__tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-family: var(--font-mono);
            font-size: 10px;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: var(--cyan-dim);
            margin-bottom: 32px;
            padding: 6px 16px;
            border: 1px solid rgba(0, 240, 255, 0.1);
            position: relative;
        }

        .hero__tag::before,
        .hero__tag::after {
            content: '';
            position: absolute;
            width: 6px;
            height: 6px;
            border: 1px solid var(--cyan-dim);
        }

        .hero__tag::before {
            top: -3px;
            left: -3px;
            border-right: none;
            border-bottom: none;
        }

        .hero__tag::after {
            bottom: -3px;
            right: -3px;
            border-left: none;
            border-top: none;
        }

        /* ── CHROMATIC ABERRATION TITLE ── */
        .hero__title {
            font-family: var(--font-display);
            font-weight: 900;
            font-size: clamp(48px, 10vw, 120px);
            letter-spacing: -2px;
            line-height: 0.95;
            color: var(--ghost);
            position: relative;
            margin-bottom: 24px;
            text-transform: uppercase;
        }

        .hero__title-main {
            position: relative;
            display: inline-block;
        }

        .hero__title-main::before,
        .hero__title-main::after {
            content: attr(data-text);
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .hero__title-main::before {
            color: rgba(255, 0, 80, 0.4);
            clip-path: polygon(0 0, 100% 0, 100% 45%, 0 45%);
            transform: translate(-2px, -1px);
            animation: glitch1 4s infinite linear alternate;
        }

        .hero__title-main::after {
            color: rgba(0, 240, 255, 0.4);
            clip-path: polygon(0 55%, 100% 55%, 100% 100%, 0 100%);
            transform: translate(2px, 1px);
            animation: glitch2 3s infinite linear alternate;
        }

        @keyframes glitch1 {

            0%,
            90% {
                transform: translate(-2px, -1px);
            }

            91% {
                transform: translate(4px, 0px) skewX(-1deg);
            }

            92% {
                transform: translate(-3px, 1px) skewX(1deg);
            }

            93%,
            100% {
                transform: translate(-2px, -1px);
            }
        }

        @keyframes glitch2 {

            0%,
            85% {
                transform: translate(2px, 1px);
            }

            86% {
                transform: translate(-4px, -1px) skewX(1deg);
            }

            87% {
                transform: translate(3px, 0px);
            }

            88%,
            100% {
                transform: translate(2px, 1px);
            }
        }

        .hero__title-accent {
            color: var(--cyan);
            text-shadow: 0 0 40px var(--cyan-flare), 0 0 80px var(--cyan-glow);
        }

        .hero__subtitle {
            font-family: var(--font-mono);
            font-size: 12px;
            letter-spacing: 6px;
            text-transform: uppercase;
            color: var(--fog);
            margin-bottom: 48px;
        }

        /* ── STATS GRID ── */
        .stats {
            display: flex;
            justify-content: center;
            gap: 2px;
            margin-bottom: 48px;
        }

        .stat {
            background: var(--panel-bg);
            border: 1px solid var(--panel-border);
            padding: 16px 28px;
            text-align: center;
            position: relative;
            overflow: hidden;
            transition: all 0.3s;
        }

        .stat:first-child {
            border-radius: 6px 0 0 6px;
        }

        .stat:last-child {
            border-radius: 0 6px 6px 0;
        }

        .stat:hover {
            border-color: rgba(0, 240, 255, 0.15);
            background: rgba(0, 240, 255, 0.02);
        }

        .stat::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--cyan-dim), transparent);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .stat:hover::after {
            opacity: 1;
        }

        .stat__value {
            font-family: var(--font-mono);
            font-size: 22px;
            font-weight: 700;
            color: var(--cyan);
            text-shadow: 0 0 20px var(--cyan-glow);
        }

        .stat__label {
            font-family: var(--font-mono);
            font-size: 9px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--fog);
            margin-top: 4px;
        }

        /* ═══════════ SEARCH TERMINAL ═══════════ */
        .search-terminal {
            max-width: 640px;
            margin: 0 auto 24px;
            position: relative;
        }

        .search-terminal__frame {
            background: rgba(0, 0, 0, 0.6);
            border: 1px solid var(--panel-border);
            border-radius: 4px;
            overflow: hidden;
            position: relative;
            transition: border-color 0.3s;
        }

        .search-terminal__frame:focus-within {
            border-color: rgba(0, 240, 255, 0.2);
            box-shadow: 0 0 40px rgba(0, 240, 255, 0.04), inset 0 0 40px rgba(0, 240, 255, 0.01);
        }

        .search-terminal__header {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            background: rgba(14, 14, 20, 0.8);
            border-bottom: 1px solid var(--panel-border);
            font-family: var(--font-mono);
            font-size: 9px;
            color: var(--fog);
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .search-terminal__prompt {
            color: var(--cyan-dim);
        }

        .search-terminal__input {
            width: 100%;
            background: transparent;
            border: none;
            outline: none;
            color: var(--ghost);
            font-family: var(--font-mono);
            font-size: 13px;
            padding: 14px 16px;
            letter-spacing: 0.5px;
        }

        .search-terminal__input::placeholder {
            color: var(--ash);
        }

        .search-terminal__scanline {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--cyan-dim), transparent);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .search-terminal__frame:focus-within .search-terminal__scanline {
            opacity: 0.6;
        }

        /* ═══════════ FILTER AXIS ═══════════ */
        .filter-axis {
            display: flex;
            justify-content: center;
            gap: 4px;
            margin-bottom: 56px;
            flex-wrap: wrap;
        }

        .filter-node {
            font-family: var(--font-mono);
            font-size: 10px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--fog);
            background: transparent;
            border: 1px solid var(--panel-border);
            padding: 8px 18px;
            cursor: crosshair;
            transition: all 0.3s;
            position: relative;
        }

        .filter-node::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            right: 50%;
            height: 1px;
            background: var(--cyan);
            transition: all 0.3s;
        }

        .filter-node:hover {
            color: var(--ghost);
            border-color: var(--panel-hover);
            background: rgba(255, 255, 255, 0.02);
        }

        .filter-node.active {
            color: var(--cyan);
            border-color: rgba(0, 240, 255, 0.15);
            background: rgba(0, 240, 255, 0.03);
            box-shadow: 0 0 30px rgba(0, 240, 255, 0.03);
        }

        .filter-node.active::before {
            left: 0;
            right: 0;
        }

        /* ═══════════ SECTION DIVIDER ═══════════ */
        .section-axis {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 32px;
        }

        .section-axis__line {
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, rgba(0, 240, 255, 0.1), transparent);
        }

        .section-axis__line--r {
            background: linear-gradient(270deg, rgba(0, 240, 255, 0.1), transparent);
        }

        .section-axis__title {
            font-family: var(--font-mono);
            font-size: 11px;
            letter-spacing: 6px;
            text-transform: uppercase;
            color: var(--fog);
            white-space: nowrap;
        }

        .section-axis__count {
            font-family: var(--font-mono);
            font-size: 9px;
            color: var(--cyan-dim);
            border: 1px solid rgba(0, 240, 255, 0.1);
            padding: 2px 8px;
            letter-spacing: 1px;
        }

        /* ═══════════ HOLOGRAPHIC SHARD — CODE PANEL ═══════════ */
        .shard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
            gap: 16px;
        }

        @media (max-width: 480px) {
            .shard-grid {
                grid-template-columns: 1fr;
            }
        }

        .shard {
            position: relative;
            background: var(--panel-bg);
            border: 1px solid var(--panel-border);
            border-radius: 3px;
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);

            /* Depth illusion */
            transform: perspective(1200px) rotateX(0deg) rotateY(0deg);
            transform-style: preserve-3d;
        }

        .shard:hover {
            border-color: rgba(0, 240, 255, 0.12);
            transform: perspective(1200px) rotateX(0.5deg) rotateY(-0.5deg) translateY(-4px);
            box-shadow:
                0 20px 60px rgba(0, 0, 0, 0.5),
                0 0 50px rgba(0, 240, 255, 0.03),
                inset 0 1px 0 rgba(255, 255, 255, 0.03);
        }

        /* Top accent beam */
        .shard::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--cyan-dim), transparent);
            opacity: 0;
            transition: opacity 0.4s;
        }

        .shard:hover::before {
            opacity: 0.8;
        }

        /* Refraction overlay */
        .shard::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            right: 0;
            width: 60%;
            height: 100%;
            background: linear-gradient(115deg, transparent 30%, rgba(0, 240, 255, 0.015) 50%, transparent 70%);
            transition: left 0.8s ease;
            pointer-events: none;
            z-index: 2;
        }

        .shard:hover::after {
            left: 120%;
        }

        /* Scan line on card */
        .shard__scan {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 3;
            overflow: hidden;
        }

        .shard__scan::after {
            content: '';
            position: absolute;
            top: -100%;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--cyan-flare), transparent);
            animation: shardScan 6s linear infinite;
            opacity: 0;
        }

        .shard:hover .shard__scan::after {
            opacity: 0.5;
        }

        @keyframes shardScan {
            0% {
                top: -2px;
            }

            100% {
                top: 100%;
            }
        }

        /* ── SHARD HEAD ── */
        .shard__head {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 18px 20px 12px;
            position: relative;
            z-index: 5;
        }

        .shard__icon-group {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .shard__icon {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--panel-border);
            border-radius: 3px;
            background: rgba(0, 240, 255, 0.02);
            position: relative;
        }

        .shard__icon img {
            width: 18px;
            height: 18px;
            filter: grayscale(1) brightness(0.6);
            transition: filter 0.3s;
        }

        .shard:hover .shard__icon img {
            filter: grayscale(0.5) brightness(0.8);
        }

        .shard__icon i {
            font-size: 14px;
            color: var(--fog);
            transition: color 0.3s;
        }

        .shard:hover .shard__icon i {
            color: var(--cyan-dim);
        }

        .shard__info h3 {
            font-family: var(--font-ui);
            font-size: 14px;
            font-weight: 600;
            color: var(--ghost);
            letter-spacing: 0.3px;
            margin-bottom: 2px;
            transition: color 0.3s;
        }

        .shard:hover .shard__info h3 {
            color: #fff;
        }

        .shard__info span {
            font-family: var(--font-mono);
            font-size: 9px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--smoke);
        }

        .shard__actions {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .shard__lang {
            font-family: var(--font-mono);
            font-size: 9px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--cyan-dim);
            border: 1px solid rgba(0, 240, 255, 0.1);
            padding: 3px 10px;
            background: rgba(0, 240, 255, 0.03);
        }

        .shard__copy {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: transparent;
            border: 1px solid var(--panel-border);
            border-radius: 3px;
            color: var(--fog);
            cursor: crosshair;
            transition: all 0.3s;
            position: relative;
        }

        .shard__copy:hover {
            border-color: rgba(0, 240, 255, 0.2);
            color: var(--cyan);
            background: rgba(0, 240, 255, 0.04);
            box-shadow: 0 0 15px rgba(0, 240, 255, 0.05);
        }

        .shard__copy-tooltip {
            position: absolute;
            bottom: calc(100% + 8px);
            left: 50%;
            transform: translateX(-50%);
            font-family: var(--font-mono);
            font-size: 9px;
            letter-spacing: 1px;
            color: var(--ghost);
            background: var(--slate);
            border: 1px solid var(--ash);
            padding: 4px 10px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s;
        }

        .shard__copy:hover .shard__copy-tooltip {
            opacity: 1;
        }

        /* ── SHARD DESC ── */
        .shard__desc {
            padding: 0 20px 14px;
            font-size: 12px;
            line-height: 1.65;
            color: var(--smoke);
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            position: relative;
            z-index: 5;
        }

        /* ── SHARD META BAR ── (Morse code micro-data) */
        .shard__meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px 10px;
            position: relative;
            z-index: 5;
        }

        .shard__morse {
            font-family: var(--font-mono);
            font-size: 8px;
            letter-spacing: 3px;
            color: var(--ash);
            opacity: 0.6;
        }

        .shard__data-graph {
            display: flex;
            align-items: flex-end;
            gap: 2px;
            height: 16px;
        }

        .shard__data-bar {
            width: 3px;
            background: rgba(0, 240, 255, 0.15);
            border-radius: 1px;
            transition: height 0.3s, background 0.3s;
        }

        .shard:hover .shard__data-bar {
            background: rgba(0, 240, 255, 0.3);
        }

        /* ── SHARD CODE BLOCK ── */
        .shard__code {
            border-top: 1px solid var(--panel-border);
            position: relative;
            z-index: 5;
        }

        .shard__code-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 16px;
            background: rgba(0, 0, 0, 0.4);
            border-bottom: 1px solid var(--panel-border);
        }

        .shard__dots {
            display: flex;
            gap: 5px;
        }

        .shard__dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            border: 1px solid;
            background: transparent;
        }

        .shard__dot--r {
            border-color: #ff5f56;
        }

        .shard__dot--y {
            border-color: #ffbd2e;
        }

        .shard__dot--g {
            border-color: #27c93f;
        }

        .shard__filename {
            font-family: var(--font-mono);
            font-size: 9px;
            color: var(--smoke);
            letter-spacing: 1px;
        }

        .shard__code-body {
            max-height: 180px;
            overflow-y: auto;
            overflow-x: auto;
            position: relative;
        }

        .shard__code-body pre {
            margin: 0 !important;
            padding: 16px !important;
            background: rgba(0, 0, 0, 0.5) !important;
            font-size: 11px !important;
            line-height: 1.8 !important;
        }

        .shard__code-body pre code {
            font-family: var(--font-mono) !important;
            font-size: 11px !important;
            text-shadow: none !important;
        }

        /* ═══════════ REVEAL ANIMATIONS ═══════════ */
        .reveal {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.8s cubic-bezier(0.23, 1, 0.32, 1),
                transform 0.8s cubic-bezier(0.23, 1, 0.32, 1);
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Stagger children */
        .shard.reveal:nth-child(1) {
            transition-delay: 0s;
        }

        .shard.reveal:nth-child(2) {
            transition-delay: 0.08s;
        }

        .shard.reveal:nth-child(3) {
            transition-delay: 0.16s;
        }

        .shard.reveal:nth-child(4) {
            transition-delay: 0.24s;
        }

        .shard.reveal:nth-child(5) {
            transition-delay: 0.32s;
        }

        .shard.reveal:nth-child(6) {
            transition-delay: 0.4s;
        }

        /* ═══════════ NO RESULTS — VOID STATE ═══════════ */
        .void-state {
            text-align: center;
            padding: 80px 24px;
        }

        .void-state__icon {
            width: 64px;
            height: 64px;
            margin: 0 auto 20px;
            border: 1px solid var(--panel-border);
            border-radius: 3px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .void-state__text {
            font-family: var(--font-mono);
            font-size: 12px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--smoke);
        }

        .void-state__sub {
            font-family: var(--font-mono);
            font-size: 10px;
            color: var(--ash);
            margin-top: 8px;
            letter-spacing: 1px;
        }

        /* ═══════════ FOOTER — SYSTEM STATUS ═══════════ */
        .sys-footer {
            position: relative;
            z-index: 10;
            border-top: 1px solid var(--panel-border);
            padding: 20px 24px;
            font-family: var(--font-mono);
            font-size: 9px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--ash);
        }

        .sys-footer__inner {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .sys-footer__tech {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--smoke);
        }

        .sys-footer__sep {
            color: var(--ash);
        }

        /* ═══════════ UTILITY ═══════════ */
        .hidden {
            display: none !important;
        }

        /* ═══════════ RESPONSIVE ═══════════ */
        @media (max-width: 768px) {
            .hero {
                padding: 120px 16px 40px;
            }

            .stats {
                flex-wrap: wrap;
            }

            .stat {
                padding: 12px 20px;
            }

            .cmd-bar__meta span:not(.cmd-bar__status) {
                display: none;
            }
        }
    </style>
</head>

<body>

    {{-- ═══ ATMOSPHERIC LAYERS ═══ --}}
    <canvas id="voidCanvas"></canvas>
    <div class="film-grain"></div>
    <div class="scan-lines"></div>
    <div class="scan-beam"></div>
    <div class="fog-orb fog-orb-1"></div>
    <div class="fog-orb fog-orb-2"></div>
    <div class="fog-orb fog-orb-3"></div>

    {{-- ═══════════════════════════════════════════════════════════════
         COMMAND BAR (NAVBAR)
    ═══════════════════════════════════════════════════════════════ --}}
    <nav class="cmd-bar" id="cmdBar">
        <div class="cmd-bar__logo">
            <div class="cmd-bar__logo-mark"></div>
            <span>CODE GALAXY</span>
        </div>
        <div class="cmd-bar__meta">
            @php
            $totalSnippets = 0;
            $langMap = [];
            $catCount = 0;
            foreach($groupedCategories as $cats) {
            foreach($cats as $cat) {
            $catCount++;
            $totalSnippets += $cat->snippets->count();
            foreach($cat->snippets as $s) {
            $langMap[$s->language] = true;
            }
            }
            }
            @endphp
            <span>NODES: {{ $totalSnippets }}</span>
            <span>LANGS: {{ count($langMap) }}</span>
            <span class="cmd-bar__status">
                <span class="cmd-bar__dot"></span>
                SYS ONLINE
            </span>
        </div>
    </nav>

    {{-- ═══════════════════════════════════════════════════════════════
         HERO — HOLOGRAPHIC HEADER
    ═══════════════════════════════════════════════════════════════ --}}
    <header class="hero">
        {{-- TAG --}}
        <div class="hero__tag">
            <span>◇</span>
            HOLOGRAPHIC SNIPPET INTERFACE
        </div>

        {{-- TITLE WITH CHROMATIC ABERRATION --}}
        <h1 class="hero__title">
            <span class="hero__title-main" data-text="CODE">CODE</span>
            <br>
            <span class="hero__title-accent hero__title-main" data-text="GALAXY">GALAXY</span>
        </h1>

        {{-- SUBTITLE --}}
        <p class="hero__subtitle">
            ── CLASSIFIED DATA ARCHIVE ──
        </p>

        {{-- STATS --}}
        <div class="stats">
            <div class="stat">
                <div class="stat__value">{{ $totalSnippets }}</div>
                <div class="stat__label">FRAGMENTS</div>
            </div>
            <div class="stat">
                <div class="stat__value">{{ count($langMap) }}</div>
                <div class="stat__label">PROTOCOLS</div>
            </div>
            <div class="stat">
                <div class="stat__value">{{ $groupedCategories->count() }}</div>
                <div class="stat__label">SECTORS</div>
            </div>
            <div class="stat">
                <div class="stat__value">{{ $catCount }}</div>
                <div class="stat__label">CLUSTERS</div>
            </div>
        </div>

        {{-- SEARCH TERMINAL --}}
        <div class="search-terminal">
            <div class="search-terminal__frame">
                <div class="search-terminal__header">
                    <span class="search-terminal__prompt">⟩</span>
                    <span>QUERY.INTERFACE</span>
                    <span style="margin-right:auto"></span>
                    <span style="opacity:0.4">ESC TO CLEAR</span>
                </div>
                <input type="text" id="searchInput"
                    class="search-terminal__input"
                    placeholder="ENTER SEARCH VECTOR..."
                    autocomplete="off" spellcheck="false">
                <div class="search-terminal__scanline"></div>
            </div>
        </div>

        {{-- FILTERS --}}
        <div class="filter-axis" id="filters">
            <button class="filter-node active" data-filter="all">◆ ALL SECTORS</button>
            @foreach($groupedCategories->keys() as $type)
            <button class="filter-node" data-filter="{{ $type }}">
                △ {{ strtoupper($type) }}
            </button>
            @endforeach
        </div>
    </header>

    {{-- ═══════════════════════════════════════════════════════════════
         CONTENT — HOLOGRAPHIC SHARDS
    ═══════════════════════════════════════════════════════════════ --}}
    <main style="max-width:1400px; margin:0 auto; padding:0 24px 80px; position:relative; z-index:10;">

        @foreach($groupedCategories as $type => $categories)
        <section class="category-section reveal" data-type="{{ $type }}" style="margin-bottom:56px;">

            {{-- SECTION AXIS --}}
            <div class="section-axis">
                <div class="section-axis__line"></div>
                <span class="section-axis__title">SECTOR::{{ strtoupper($type) }}</span>
                <span class="section-axis__count">{{ $categories->sum(fn($c) => $c->snippets->count()) }} NODES</span>
                <div class="section-axis__line section-axis__line--r"></div>
            </div>

            {{-- SHARD GRID --}}
            <div class="shard-grid">
                @foreach($categories as $category)
                @foreach($category->snippets as $snippet)
                @php
                // Generate pseudo-morse from title
                $morse = '';
                $chars = str_split(strtoupper($snippet->title));
                foreach(array_slice($chars, 0, 8) as $c) {
                $morse .= (ord($c) % 2 === 0) ? '─ ' : '• ';
                }
                // Random mini data bars
                $bars = [];
                for($i = 0; $i < 8; $i++) {
                    $bars[]=rand(3, 14);
                    }
                    $ext=match($snippet->language) {
                    'javascript' => 'js',
                    'python' => 'py',
                    default => $snippet->language
                    };
                    @endphp

                    <div class="shard reveal"
                        data-title="{{ $snippet->title }}"
                        data-desc="{{ $snippet->description }}"
                        data-lang="{{ $snippet->language }}">

                        <div class="shard__scan"></div>

                        {{-- HEAD --}}
                        <div class="shard__head">
                            <div class="shard__icon-group">
                                <div class="shard__icon">
                                    @if($category->icon)
                                    <img src="{{ $category->icon }}" alt="{{ $category->name }}">
                                    @else
                                    <i class="fa-solid fa-terminal"></i>
                                    @endif
                                </div>
                                <div class="shard__info">
                                    <h3 class="shard__title">{{ $snippet->title }}</h3>
                                    <span>{{ strtoupper($category->name) }}</span>
                                </div>
                            </div>
                            <div class="shard__actions">
                                <span class="shard__lang">{{ $snippet->language }}</span>
                                <button onclick="copyCode(this, '{{ base64_encode($snippet->code) }}')"
                                    class="shard__copy">
                                    <span class="shard__copy-tooltip">COPY</span>
                                    <i class="fa-regular fa-copy" style="font-size:11px;"></i>
                                </button>
                            </div>
                        </div>

                        {{-- DESCRIPTION --}}
                        <p class="shard__desc snippet-desc">{{ $snippet->description }}</p>

                        {{-- MICRO META BAR --}}
                        <div class="shard__meta">
                            <span class="shard__morse">{{ $morse }}</span>
                            <div class="shard__data-graph">
                                @foreach($bars as $h)
                                <div class="shard__data-bar" style="height:{{ $h }}px;"></div>
                                @endforeach
                            </div>
                        </div>

                        {{-- CODE BLOCK --}}
                        <div class="shard__code">
                            <div class="shard__code-head">
                                <div class="shard__dots">
                                    <span class="shard__dot shard__dot--r"></span>
                                    <span class="shard__dot shard__dot--y"></span>
                                    <span class="shard__dot shard__dot--g"></span>
                                </div>
                                <span class="shard__filename">main.{{ $ext }}</span>
                            </div>
                            <div class="shard__code-body">
                                <pre><code class="language-{{ $snippet->language }}">{{ $snippet->code }}</code></pre>
                            </div>
                        </div>
                    </div>

                    @endforeach
                    @endforeach
            </div>
        </section>
        @endforeach

        {{-- VOID STATE --}}
        <div id="noResults" class="void-state hidden">
            <div class="void-state__icon">
                <i class="fa-solid fa-satellite-dish" style="color:var(--ash); font-size:20px;"></i>
            </div>
            <p class="void-state__text">NO SIGNAL DETECTED</p>
            <p class="void-state__sub">Adjust search vector and retry</p>
        </div>
    </main>

    {{-- ═══════════════════════════════════════════════════════════════
         SYSTEM FOOTER
    ═══════════════════════════════════════════════════════════════ --}}
    <footer class="sys-footer">
        <div class="sys-footer__inner">
            <span>CODE GALAXY &copy; {{ date('Y') }} — ALL RIGHTS RESERVED</span>
            <div class="sys-footer__tech">
                <span>LARAVEL</span>
                <span class="sys-footer__sep">◇</span>
                <span>PHP</span>
                <span class="sys-footer__sep">◇</span>
                <span>BLADE</span>
            </div>
        </div>
    </footer>


    {{-- ═══════════════════════════════════════════════════════════════
         SYSTEM SCRIPTS
    ═══════════════════════════════════════════════════════════════ --}}
    <script>
        (function() {
            'use strict';

            /* ═══════ 1. WEBGL PARTICLE FIELD ═══════ */
            const canvas = document.getElementById('voidCanvas');
            const ctx = canvas.getContext('2d');
            let particles = [];
            const PARTICLE_COUNT = 100;
            let mouse = {
                x: -1000,
                y: -1000
            };

            function resizeCanvas() {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
            }
            resizeCanvas();
            window.addEventListener('resize', resizeCanvas);

            document.addEventListener('mousemove', (e) => {
                mouse.x = e.clientX;
                mouse.y = e.clientY;
            });

            class Particle {
                constructor() {
                    this.init();
                }
                init() {
                    this.x = Math.random() * canvas.width;
                    this.y = Math.random() * canvas.height;
                    this.size = Math.random() * 1.2 + 0.3;
                    this.vx = (Math.random() - 0.5) * 0.15;
                    this.vy = (Math.random() - 0.5) * 0.15;
                    this.baseOpacity = Math.random() * 0.25 + 0.05;
                    this.opacity = this.baseOpacity;
                    this.pulse = Math.random() * Math.PI * 2;
                }
                update() {
                    this.x += this.vx;
                    this.y += this.vy;
                    this.pulse += 0.01;
                    this.opacity = this.baseOpacity + Math.sin(this.pulse) * 0.05;

                    // Mouse proximity reaction
                    const dx = this.x - mouse.x;
                    const dy = this.y - mouse.y;
                    const dist = Math.sqrt(dx * dx + dy * dy);
                    if (dist < 150) {
                        const force = (150 - dist) / 150;
                        this.opacity = Math.min(this.baseOpacity + force * 0.4, 0.7);
                        this.x += (dx / dist) * force * 0.5;
                        this.y += (dy / dist) * force * 0.5;
                    }

                    if (this.x < 0 || this.x > canvas.width) this.vx *= -1;
                    if (this.y < 0 || this.y > canvas.height) this.vy *= -1;
                }
                draw() {
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                    ctx.fillStyle = `rgba(0, 240, 255, ${this.opacity})`;
                    ctx.fill();
                }
            }

            for (let i = 0; i < PARTICLE_COUNT; i++) {
                particles.push(new Particle());
            }

            function drawConnections() {
                for (let i = 0; i < particles.length; i++) {
                    for (let j = i + 1; j < particles.length; j++) {
                        const dx = particles[i].x - particles[j].x;
                        const dy = particles[i].y - particles[j].y;
                        const dist = Math.sqrt(dx * dx + dy * dy);
                        if (dist < 100) {
                            ctx.beginPath();
                            ctx.strokeStyle = `rgba(0, 240, 255, ${0.04 * (1 - dist / 100)})`;
                            ctx.lineWidth = 0.5;
                            ctx.moveTo(particles[i].x, particles[i].y);
                            ctx.lineTo(particles[j].x, particles[j].y);
                            ctx.stroke();
                        }
                    }
                }
            }

            function animateParticles() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                particles.forEach(p => {
                    p.update();
                    p.draw();
                });
                drawConnections();
                requestAnimationFrame(animateParticles);
            }
            animateParticles();

            /* ═══════ 2. DATA GRAPH PROXIMITY PULSE ═══════ */
            document.querySelectorAll('.shard').forEach(shard => {
                shard.addEventListener('mouseenter', () => {
                    const bars = shard.querySelectorAll('.shard__data-bar');
                    bars.forEach((bar, i) => {
                        setTimeout(() => {
                            bar.style.height = (Math.random() * 12 + 3) + 'px';
                        }, i * 40);
                    });
                });
            });

            /* ═══════ 3. NAVBAR SCROLL ═══════ */
            const cmdBar = document.getElementById('cmdBar');
            window.addEventListener('scroll', () => {
                cmdBar.classList.toggle('scrolled', window.scrollY > 30);
            });

            /* ═══════ 4. INTERSECTION OBSERVER ═══════ */
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.08,
                rootMargin: '0px 0px -40px 0px'
            });

            document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

            /* ═══════ 5. SEARCH ═══════ */
            const searchInput = document.getElementById('searchInput');
            const shards = document.querySelectorAll('.shard');
            const noResults = document.getElementById('noResults');
            const catSections = document.querySelectorAll('.category-section');

            searchInput.addEventListener('input', (e) => {
                const term = e.target.value.toLowerCase().trim();
                let found = false;

                shards.forEach(s => {
                    const t = (s.dataset.title || '').toLowerCase();
                    const d = (s.dataset.desc || '').toLowerCase();
                    const l = (s.dataset.lang || '').toLowerCase();
                    const match = !term || t.includes(term) || d.includes(term) || l.includes(term);
                    s.style.display = match ? '' : 'none';
                    if (match) found = true;
                });

                catSections.forEach(sec => {
                    const vis = sec.querySelectorAll('.shard:not([style*="display: none"])');
                    sec.style.display = vis.length === 0 ? 'none' : '';
                });

                noResults.classList.toggle('hidden', found || !term);
            });

            /* ═══════ 6. FILTERS ═══════ */
            const filterBtns = document.querySelectorAll('.filter-node');
            filterBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    filterBtns.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                    const f = btn.dataset.filter;
                    let found = false;

                    catSections.forEach(sec => {
                        if (f === 'all' || sec.dataset.type === f) {
                            sec.style.display = '';
                            found = true;
                        } else {
                            sec.style.display = 'none';
                        }
                    });

                    noResults.classList.toggle('hidden', found);
                    searchInput.value = '';
                });
            });

            /* ═══════ 7. KEYBOARD SHORTCUTS ═══════ */
            document.addEventListener('keydown', (e) => {
                if (e.key === '/' && document.activeElement !== searchInput) {
                    e.preventDefault();
                    searchInput.focus();
                }
                if (e.key === 'Escape') {
                    searchInput.blur();
                    searchInput.value = '';
                    searchInput.dispatchEvent(new Event('input'));
                }
            });

            /* ═══════ 8. PRISM HIGHLIGHT ═══════ */
            document.addEventListener('DOMContentLoaded', () => {
                if (window.Prism) Prism.highlightAll();
            });
            // Also try after all deferred scripts load
            window.addEventListener('load', () => {
                if (window.Prism) Prism.highlightAll();
            });

        })();

        /* ═══════ COPY FUNCTION (global) ═══════ */
        function copyCode(btn, base64Code) {
            const code = decodeURIComponent(escape(atob(base64Code)));
            navigator.clipboard.writeText(code).then(() => {
                const icon = btn.querySelector('i');
                const tooltip = btn.querySelector('.shard__copy-tooltip');
                const origClass = icon.className;

                icon.className = 'fa-solid fa-check';
                icon.style.color = '#00ff88';
                btn.style.borderColor = 'rgba(0, 255, 136, 0.3)';
                btn.style.background = 'rgba(0, 255, 136, 0.06)';
                if (tooltip) tooltip.textContent = 'COPIED ✓';

                setTimeout(() => {
                    icon.className = origClass;
                    icon.style.color = '';
                    btn.style.borderColor = '';
                    btn.style.background = '';
                    if (tooltip) tooltip.textContent = 'COPY';
                }, 2000);
            });
        }
    </script>
</body>

</html>