<!DOCTYPE html>
<html lang="en" class="scroll-smooth snap-y snap-mandatory">
<head>
    <meta charset="UTF-8">
    {{-- Prevent theme flash before paint --}}
    <script>
        (function () {
            try {
                const stored = localStorage.getItem('theme');
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                const theme = stored || (prefersDark ? 'dark' : 'light');
                if (theme === 'dark') document.documentElement.classList.add('dark');
                else document.documentElement.classList.remove('dark');
            } catch (e) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ config('portfolio.description') }}">
    <meta name="author" content="{{ config('portfolio.full_name') }}">
    <meta name="theme-color" content="#09090b">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $ogTitle = config('portfolio.full_name').' | '.config('portfolio.title');
        $ogDescription = config('portfolio.description');
        $ogImage = asset(config('portfolio.og_image', 'images/bryan.jpg'));
        $ogUrl = rtrim(config('portfolio.site_url', config('app.url')), '/').'/';
    @endphp

    <link rel="canonical" href="{{ $ogUrl }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $ogUrl }}">
    <meta property="og:title" content="{{ $ogTitle }}">
    <meta property="og:description" content="{{ $ogDescription }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:image:alt" content="{{ config('portfolio.full_name') }} — portfolio photo">
    <meta property="og:locale" content="en_PH">
    <meta property="og:site_name" content="{{ config('portfolio.full_name') }} Portfolio">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $ogTitle }}">
    <meta name="twitter:description" content="{{ $ogDescription }}">
    <meta name="twitter:image" content="{{ $ogImage }}">

    <title>{{ $ogTitle }}</title>

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.8s ease-out forwards',
                        'float': 'float 6s ease-in-out infinite',
                        'float-slow': 'floatSlow 8s ease-in-out infinite',
                        'float-slower': 'floatSlower 11s ease-in-out infinite',
                        'blink': 'blink 1s step-end infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(16px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-12px)' },
                        },
                        floatSlow: {
                            '0%, 100%': { transform: 'translateY(0) translateX(0)' },
                            '50%': { transform: 'translateY(-18px) translateX(6px)' },
                        },
                        floatSlower: {
                            '0%, 100%': { transform: 'translateY(0) rotate(0deg)' },
                            '50%': { transform: 'translateY(-10px) rotate(3deg)' },
                        },
                        blink: {
                            '0%, 100%': { opacity: '1' },
                            '50%': { opacity: '0' },
                        },
                    },
                },
            },
        };
    </script>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Lucide Icons CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/lucide@0.468.0/dist/umd/lucide.min.js"></script>

    {{-- Alpine.js CDN --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    {{-- AOS (Animate On Scroll) --}}
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>

    <style>
        html {
            scroll-behavior: smooth;
            scroll-snap-type: y mandatory;
        }

        @media (max-width: 767px) {
            html {
                scroll-snap-type: none;
            }
        }

        body {
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
            overflow-x: hidden;
        }

        /* Avoid horizontal overflow from ambient blurs / absolute accents */
        section {
            overflow-x: clip;
        }

        /*
         * One section per viewport on desktop (nav/snap).
         * Compact inner padding so content doesn't feel stretched.
         */
        .section-screen {
            box-sizing: border-box;
            min-height: 100svh;
            scroll-snap-align: start;
            scroll-snap-stop: always;
            scroll-margin-top: 0;
            padding-top: 5.25rem;
            padding-bottom: 2.5rem;
        }

        #hero.section-screen {
            padding-top: 5.5rem;
            padding-bottom: 2.25rem;
        }

        @media (max-width: 767px) {
            .section-screen {
                min-height: auto;
                scroll-snap-stop: normal;
                padding-top: 4.5rem;
                padding-bottom: 2.75rem;
            }
        }

        @media (max-width: 639px) {
            .interactive-card:hover {
                transform: none;
            }

            .glow-emerald:hover {
                transform: none;
            }
        }

        .gradient-text {
            background: linear-gradient(to right, #34d399, #8b5cf6);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .glow-emerald {
            transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
        }

        .glow-emerald:hover {
            box-shadow: 0 0 28px rgba(16, 185, 129, 0.55);
            transform: translateY(-2px);
        }

        .interactive-card {
            transition: transform 0.35s ease, border-color 0.35s ease, box-shadow 0.35s ease, background-color 0.35s ease;
        }

        .interactive-card:hover {
            transform: translateY(-0.5rem);
            border-color: rgb(5 150 105 / 0.45);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12), 0 0 28px rgba(16, 185, 129, 0.1);
        }

        .dark .interactive-card:hover {
            border-color: rgb(16 185 129 / 0.4);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.35), 0 0 28px rgba(16, 185, 129, 0.12);
        }

        /* Premium glassmorphism cards */
        .glass-card {
            position: relative;
            overflow: hidden;
            border: 1px solid rgb(226 232 240 / 0.9);
            background: rgb(255 255 255 / 0.72);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 10px 25px -8px rgba(0, 0, 0, 0.12);
            transition: transform 0.35s ease, border-color 0.35s ease, box-shadow 0.35s ease, background-color 0.35s ease;
        }

        .dark .glass-card {
            border-color: rgb(39 39 42 / 0.6);
            background: rgb(24 24 27 / 0.4);
            box-shadow: 0 10px 25px -8px rgba(0, 0, 0, 0.35);
        }

        .glass-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(16, 185, 129, 0.35), transparent);
            pointer-events: none;
            z-index: 1;
        }

        .glass-card:hover {
            border-color: rgb(16 185 129 / 0.4);
            box-shadow: 0 12px 32px -8px rgba(0, 0, 0, 0.18), 0 0 24px rgba(16, 185, 129, 0.1);
        }

        .dark .glass-card:hover {
            border-color: rgb(16 185 129 / 0.4);
            box-shadow: 0 12px 32px -8px rgba(0, 0, 0, 0.4), 0 0 24px rgba(16, 185, 129, 0.12);
        }

        /* Unified section chip + title */
        .section-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            margin-bottom: 0.75rem;
            padding: 0.375rem 0.85rem;
            font-size: 0.68rem;
            font-weight: 650;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            border-radius: 9999px;
            border: 1px solid rgb(16 185 129 / 0.28);
            background: linear-gradient(135deg, rgb(16 185 129 / 0.14), rgb(139 92 246 / 0.12));
            color: #059669;
            box-shadow: 0 0 22px rgba(16, 185, 129, 0.18);
        }

        .dark .section-chip {
            border-color: rgb(16 185 129 / 0.35);
            color: #6ee7b7;
            box-shadow: 0 0 26px rgba(16, 185, 129, 0.22);
        }

        .section-title {
            color: #18181b;
        }

        .dark .section-title {
            background-image: linear-gradient(to right, #f4f4f5, #e4e4e7, #34d399);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        /* Soft micro-interactions */
        a, button, .skill-pill, .social-glow {
            transition: color 0.3s ease, border-color 0.3s ease, background-color 0.3s ease,
                        transform 0.3s ease, box-shadow 0.3s ease, opacity 0.3s ease;
        }

        .social-glow:hover {
            transform: translateY(-2px);
            border-color: rgb(16 185 129 / 0.55);
            color: #34d399;
            box-shadow: 0 0 22px rgba(16, 185, 129, 0.35);
        }

        .skill-pill:hover {
            border-color: rgb(5 150 105 / 0.45);
            background-color: rgb(16 185 129 / 0.08);
        }

        .dark .skill-pill:hover {
            border-color: rgb(16 185 129 / 0.5);
            background-color: rgb(16 185 129 / 0.1);
        }

        html {
            color-scheme: light;
        }

        html.dark {
            color-scheme: dark;
        }

        .ambient-glow {
            animation: ambientPulse 7s ease-in-out infinite;
        }

        .ambient-glow-delay {
            animation: ambientFloat 9s ease-in-out infinite;
        }

        @keyframes ambientPulse {
            0%, 100% { opacity: 0.45; transform: scale(1); }
            50% { opacity: 0.85; transform: scale(1.08); }
        }

        @keyframes ambientFloat {
            0%, 100% { opacity: 0.35; transform: translateY(0) scale(1); }
            50% { opacity: 0.7; transform: translateY(-12px) scale(1.05); }
        }

        .faq-panel {
            display: grid;
            grid-template-rows: 0fr;
            opacity: 0;
            transition: grid-template-rows 0.35s ease, opacity 0.35s ease;
        }

        .faq-panel.is-open {
            grid-template-rows: 1fr;
            opacity: 1;
        }

        .faq-panel > div {
            overflow: hidden;
        }

        .nav-shell {
            transition: box-shadow 0.3s ease, border-color 0.3s ease, background-color 0.3s ease;
        }

        .nav-shell.is-scrolled {
            border-color: rgb(16 185 129 / 0.35);
            box-shadow: 0 10px 40px -12px rgba(16, 185, 129, 0.25), 0 8px 24px rgba(0, 0, 0, 0.25);
        }

        .nav-link {
            position: relative;
            padding-bottom: 2px;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 0;
            height: 2px;
            background: #34d399;
            transition: width 0.3s ease;
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }

        .nav-link.active {
            color: #059669;
            font-weight: 600;
        }

        .dark .nav-link.active {
            color: #34d399;
        }

        .logo-text {
            transition: color 0.3s ease;
        }

        .group:hover .logo-text {
            background-image: linear-gradient(to right, #34d399, #8b5cf6);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            -webkit-text-fill-color: transparent;
        }

        #theme-toggle.is-spinning {
            transform: rotate(180deg);
        }

        #scroll-progress {
            transition: width 80ms linear;
        }

        #back-to-top {
            opacity: 0;
            pointer-events: none;
            transform: translateY(8px);
            transition: opacity 0.3s ease, transform 0.3s ease, background-color 0.3s ease, box-shadow 0.3s ease;
        }

        #back-to-top.is-visible {
            opacity: 1;
            pointer-events: auto;
            transform: translateY(0);
        }

        .skill-pill {
            transition: transform 0.2s ease, border-color 0.2s ease, background-color 0.2s ease;
        }

        .skill-pill:hover {
            transform: translateY(-2px);
        }

        .terminal-panel {
            background-color: #09090b;
            border-color: #27272a;
            color: #e4e4e7;
        }

        .typewriter-cursor {
            display: inline-block;
            width: 2px;
            height: 1.1em;
            margin-left: 2px;
            vertical-align: -0.1em;
            background: #34d399;
            animation: blink 1s step-end infinite;
        }

        .timeline-line {
            background: linear-gradient(to bottom, #34d399, #8b5cf6);
        }

        .toast-enter {
            animation: toastIn 0.35s ease-out forwards;
        }

        @keyframes toastIn {
            from { opacity: 0; transform: translateY(-12px) translateX(8px); }
            to { opacity: 1; transform: translateY(0) translateX(0); }
        }

        .hero-photo-stage {
            isolation: isolate;
        }

        .hero-photo-frame {
            position: relative;
            z-index: 10;
            background: transparent;
        }

        .hero-photo-img {
            background: transparent;
            -webkit-mask-image: linear-gradient(to bottom, #000 82%, transparent 100%);
            mask-image: linear-gradient(to bottom, #000 82%, transparent 100%);
            filter: drop-shadow(0 28px 40px rgba(0, 0, 0, 0.5));
        }

        /* Knock out solid black fill baked into the cutout PNG (dark theme) */
        html.dark .hero-photo-img {
            mix-blend-mode: screen;
            filter: drop-shadow(0 18px 28px rgba(16, 185, 129, 0.18));
        }

        .hero-name-gradient {
            background-image: linear-gradient(120deg, #34d399, #5eead4, #a78bfa, #34d399);
            background-size: 220% auto;
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            animation: heroGradientShift 7s ease infinite;
        }

        @keyframes heroGradientShift {
            0%, 100% { background-position: 0% center; }
            50% { background-position: 100% center; }
        }

        .hero-status-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.4rem 0.85rem;
            border-radius: 9999px;
            border: 1px solid rgb(39 39 42 / 0.85);
            background: rgb(24 24 27 / 0.65);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            font-size: 0.75rem;
            font-weight: 500;
            color: #d4d4d8;
        }

        html:not(.dark) .hero-status-pill {
            border-color: rgb(226 232 240 / 0.95);
            background: rgb(255 255 255 / 0.8);
            color: #3f3f46;
        }

        .hero-float-pill {
            position: absolute;
            z-index: 30;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.5rem 0.85rem;
            border-radius: 9999px;
            border: 1px solid rgb(39 39 42 / 0.85);
            background: rgb(24 24 27 / 0.78);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 10px 28px rgba(0, 0, 0, 0.4);
            font-size: 0.72rem;
            font-weight: 650;
            letter-spacing: 0.01em;
            color: #f4f4f5;
            white-space: nowrap;
            user-select: none;
            pointer-events: auto;
            cursor: default;
            transition: transform 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
            will-change: transform;
        }

        html:not(.dark) .hero-float-pill {
            border-color: rgb(226 232 240 / 0.95);
            background: rgb(255 255 255 / 0.88);
            color: #3f3f46;
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.1);
        }

        .hero-float-pill:hover {
            transform: scale(1.05);
            border-color: rgb(52 211 153 / 0.8);
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.3);
        }

        @keyframes heroFloatA {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        @keyframes heroFloatB {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-14px); }
        }

        @keyframes heroFloatC {
            0%, 100% { transform: translateY(0) translateX(0); }
            50% { transform: translateY(-9px) translateX(4px); }
        }

        .hero-float-pill.pill-a { animation: heroFloatA 3s ease-in-out infinite; }
        .hero-float-pill.pill-b { animation: heroFloatB 4s ease-in-out infinite alternate; }
        .hero-float-pill.pill-c { animation: heroFloatC 3.5s ease-in-out infinite; }

        .hero-float-pill.pill-a:hover,
        .hero-float-pill.pill-b:hover,
        .hero-float-pill.pill-c:hover {
            animation-play-state: paused;
        }

        @keyframes heroAuraBreath {
            0%, 100% { opacity: 0.55; transform: translate(-50%, -50%) scale(1); }
            50% { opacity: 0.95; transform: translate(-50%, -50%) scale(1.08); }
        }

        .hero-aura {
            animation: heroAuraBreath 6.5s ease-in-out infinite;
        }

        .hero-aura-delay {
            animation: heroAuraBreath 8s ease-in-out infinite;
            animation-delay: 1.2s;
        }

        .hero-deco-mark {
            position: absolute;
            z-index: 0;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-weight: 700;
            opacity: 0.2;
            pointer-events: none;
            user-select: none;
            color: #a1a1aa;
        }

        .hero-code-card {
            position: relative;
            border-top: 1px solid rgb(16 185 129 / 0.4);
            box-shadow: 0 0 30px rgba(16, 185, 129, 0.08), 0 20px 40px rgba(0, 0, 0, 0.35);
        }

        [x-cloak] { display: none !important; }
    </style>
</head>
<body
    class="bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 antialiased"
    x-data="{
        mobileOpen: false,
        moreOpen: false,
        copied: false,
        toastVisible: false,
        toastMessage: 'Message sent successfully.',
        toastError: false,
        contactSending: false,
        resumeOpen: false,
        journeyOpen: false,
        journeyItem: null,
        cmdOpen: false,
        cmdQuery: '',
        cmdActive: 0,
        commands: [
            { label: 'Home', href: '#hero', hint: 'Hero section', icon: 'home' },
            { label: 'About', href: '#about', hint: 'Who I am', icon: 'user' },
            { label: 'Strengths', href: '#strengths', hint: 'Core competencies', icon: 'sparkles' },
            { label: 'Tech Stack', href: '#skills', hint: 'Tools & skills', icon: 'layers' },
            { label: 'Database Schema', href: '#schema', hint: 'MySQL architecture', icon: 'database' },
            { label: 'API Terminal', href: '#api-terminal', hint: 'Live demo', icon: 'terminal' },
            { label: 'Case Study', href: '#case-study', hint: 'Laravel + MySQL deep dive', icon: 'file-search' },
            { label: 'Journey', href: '#journey', hint: 'Career path', icon: 'route' },
            { label: 'Services', href: '#services', hint: 'What I build', icon: 'briefcase' },
            { label: 'Activity', href: '#activity', hint: 'Code pulse', icon: 'activity' },
            { label: 'FAQ', href: '#faq', hint: 'Common questions', icon: 'circle-help' },
            { label: 'Contact', href: '#contact', hint: 'Get in touch', icon: 'mail' },
        ],
        get filteredCommands() {
            const q = this.cmdQuery.trim().toLowerCase();
            if (!q) return this.commands;
            return this.commands.filter((c) =>
                c.label.toLowerCase().includes(q) ||
                c.hint.toLowerCase().includes(q) ||
                c.href.toLowerCase().includes(q)
            );
        },
        openResume() {
            this.resumeOpen = true;
            this.cmdOpen = false;
            this.$nextTick(() => window.initLucideIcons && window.initLucideIcons());
        },
        closeResume() {
            this.resumeOpen = false;
        },
        openJourney(item) {
            this.journeyItem = item;
            this.journeyOpen = true;
            this.cmdOpen = false;
            this.resumeOpen = false;
            this.$nextTick(() => window.initLucideIcons && window.initLucideIcons());
        },
        closeJourney() {
            this.journeyOpen = false;
            this.journeyItem = null;
        },
        openCmd() {
            this.cmdOpen = true;
            this.cmdQuery = '';
            this.cmdActive = 0;
            this.mobileOpen = false;
            this.moreOpen = false;
            this.$nextTick(() => {
                if (this.$refs.cmdInput) this.$refs.cmdInput.focus();
                window.initLucideIcons && window.initLucideIcons();
            });
        },
        closeCmd() {
            this.cmdOpen = false;
            this.cmdQuery = '';
            this.cmdActive = 0;
        },
        jumpTo(href) {
            this.closeCmd();
            this.mobileOpen = false;
            this.moreOpen = false;
            const el = document.querySelector(href);
            if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
            else window.location.hash = href;
        },
        runActiveCommand() {
            const list = this.filteredCommands;
            if (!list.length) return;
            const idx = Math.min(this.cmdActive, list.length - 1);
            this.jumpTo(list[idx].href);
        },
        moveCmd(delta) {
            const list = this.filteredCommands;
            if (!list.length) return;
            this.cmdActive = (this.cmdActive + delta + list.length) % list.length;
        },
        async copyEmail() {
            try {
                await navigator.clipboard.writeText((window.portfolioConfig && window.portfolioConfig.email) || '');
                this.copied = true;
                this.$nextTick(() => window.initLucideIcons && window.initLucideIcons());
                setTimeout(() => {
                    this.copied = false;
                    this.$nextTick(() => window.initLucideIcons && window.initLucideIcons());
                }, 2000);
            } catch (e) {
                console.error('Clipboard copy failed', e);
            }
        },
        showToast(message, isError = false) {
            this.toastMessage = message;
            this.toastError = isError;
            this.toastVisible = true;
            this.$nextTick(() => window.initLucideIcons && window.initLucideIcons());
            setTimeout(() => { this.toastVisible = false; }, 4500);
        },
        async handleContactSubmit(event) {
            event.preventDefault();
            const form = event.target;
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }
            if (this.contactSending) return;
            this.contactSending = true;
            const cfg = window.portfolioConfig || {};
            const token = document.querySelector('meta[name=csrf-token]')?.getAttribute('content') || '';
            const payload = Object.fromEntries(new FormData(form).entries());
            try {
                const res = await fetch(cfg.contactUrl || '/contact', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify(payload),
                });
                const data = await res.json().catch(() => ({}));
                if (!res.ok || !data.ok) {
                    this.showToast(data.message || 'Could not send message. Please try email instead.', true);
                    return;
                }
                form.reset();
                this.showToast(data.message || 'Message sent successfully!');
            } catch (e) {
                console.error(e);
                this.showToast('Network error. Please email ' + (cfg.email || 'me') + ' directly.', true);
            } finally {
                this.contactSending = false;
                this.$nextTick(() => window.initLucideIcons && window.initLucideIcons());
            }
        }
    }"
    @keydown.window="
        if (($event.ctrlKey || $event.metaKey) && $event.key.toLowerCase() === 'k') {
            $event.preventDefault();
            if (cmdOpen) { closeCmd(); } else { openCmd(); }
        }
        if ($event.key === 'Escape') {
            if (cmdOpen) closeCmd();
            if (resumeOpen) closeResume();
            if (journeyOpen) closeJourney();
        }
    "
>

    @php
        $portfolioEmail = config('portfolio.email');
        $portfolioGithub = config('portfolio.github');
        $portfolioLinkedin = config('portfolio.linkedin');
        $portfolioResume = asset(config('portfolio.resume_path'));

        $portfolioConfig = [
            'email' => $portfolioEmail,
            'github' => $portfolioGithub,
            'linkedin' => $portfolioLinkedin,
            'contactUrl' => route('contact.store'),
            'resumeUrl' => $portfolioResume,
        ];

        $navLinks = [
            ['label' => 'Home', 'href' => '#hero'],
            ['label' => 'About', 'href' => '#about'],
            ['label' => 'Tech Stack', 'href' => '#skills'],
            ['label' => 'Services', 'href' => '#services'],
            ['label' => 'Contact', 'href' => '#contact'],
        ];

        $moreLinks = [
            ['label' => 'Strengths', 'href' => '#strengths'],
            ['label' => 'Database Schema', 'href' => '#schema'],
            ['label' => 'API Terminal', 'href' => '#api-terminal'],
            ['label' => 'Case Study', 'href' => '#case-study'],
            ['label' => 'Journey', 'href' => '#journey'],
            ['label' => 'Activity', 'href' => '#activity'],
            ['label' => 'FAQ', 'href' => '#faq'],
        ];

        $schemaTables = [
            'users' => [
                'label' => 'users',
                'model' => 'User',
                'icon' => 'users',
                'columns' => [
                    ['name' => 'id', 'type' => 'bigIncrements', 'attrs' => 'PK · auto'],
                    ['name' => 'name', 'type' => 'string', 'attrs' => 'required'],
                    ['name' => 'email', 'type' => 'string', 'attrs' => 'unique'],
                    ['name' => 'password', 'type' => 'string', 'attrs' => 'hashed'],
                    ['name' => 'email_verified_at', 'type' => 'timestamp', 'attrs' => 'nullable'],
                    ['name' => 'created_at', 'type' => 'timestamps', 'attrs' => ''],
                ],
                'indexes' => ['PRIMARY KEY (id)', 'UNIQUE INDEX users_email_unique (email)'],
                'relations' => [
                    'hasMany(Order::class)',
                    'hasMany(Product::class) // as seller',
                ],
            ],
            'orders' => [
                'label' => 'orders',
                'model' => 'Order',
                'icon' => 'shopping-cart',
                'columns' => [
                    ['name' => 'id', 'type' => 'bigIncrements', 'attrs' => 'PK · auto'],
                    ['name' => 'user_id', 'type' => 'foreignId', 'attrs' => 'constrained'],
                    ['name' => 'status', 'type' => 'string', 'attrs' => 'indexed'],
                    ['name' => 'total', 'type' => 'decimal:10,2', 'attrs' => ''],
                    ['name' => 'placed_at', 'type' => 'timestamp', 'attrs' => 'indexed'],
                    ['name' => 'created_at', 'type' => 'timestamps', 'attrs' => ''],
                ],
                'indexes' => ['PRIMARY KEY (id)', 'INDEX orders_user_id_index (user_id)', 'INDEX orders_status_index (status)'],
                'relations' => [
                    'belongsTo(User::class)',
                    'belongsToMany(Product::class)',
                ],
            ],
            'products' => [
                'label' => 'products',
                'model' => 'Product',
                'icon' => 'package',
                'columns' => [
                    ['name' => 'id', 'type' => 'bigIncrements', 'attrs' => 'PK · auto'],
                    ['name' => 'sku', 'type' => 'string', 'attrs' => 'unique'],
                    ['name' => 'name', 'type' => 'string', 'attrs' => 'indexed'],
                    ['name' => 'price', 'type' => 'decimal:10,2', 'attrs' => ''],
                    ['name' => 'stock', 'type' => 'unsignedInteger', 'attrs' => 'default:0'],
                    ['name' => 'user_id', 'type' => 'foreignId', 'attrs' => 'seller'],
                    ['name' => 'created_at', 'type' => 'timestamps', 'attrs' => ''],
                ],
                'indexes' => ['PRIMARY KEY (id)', 'UNIQUE INDEX products_sku_unique (sku)', 'INDEX products_name_index (name)'],
                'relations' => [
                    'belongsTo(User::class)',
                    'belongsToMany(Order::class)',
                ],
            ],
        ];

        $allNavLinks = array_merge($navLinks, $moreLinks);

        $stackBars = [
            ['label' => 'PHP / Laravel', 'percent' => 92],
            ['label' => 'JavaScript', 'percent' => 78],
            ['label' => 'MySQL', 'percent' => 85],
            ['label' => 'Tailwind / Blade', 'percent' => 80],
        ];

        $aboutCards = [
            [
                'icon' => 'brain',
                'title' => 'Problem Solver',
                'desc' => 'Logical & architectural thinking',
            ],
            [
                'icon' => 'code-2',
                'title' => 'Clean Code Enthusiast',
                'desc' => 'Maintainable & scalable PHP/Laravel practices',
            ],
            [
                'icon' => 'book-open',
                'title' => 'Continuous Learner',
                'desc' => 'Exploring modern web tech & ecosystems',
            ],
        ];

        $strengthCards = [
            [
                'icon' => 'layers',
                'title' => 'Laravel & PHP Architecture',
                'desc' => 'Building secure, maintainable backend applications, custom RESTful APIs, and MVC architectures.',
            ],
            [
                'icon' => 'database',
                'title' => 'Database & Backend Systems',
                'desc' => 'Designing optimized MySQL database schemas, complex queries, and XAMPP local environment setups.',
            ],
            [
                'icon' => 'monitor-smartphone',
                'title' => 'Modern Responsive Frontends',
                'desc' => 'Crafting mobile-first, dynamic user interfaces using Tailwind CSS, JavaScript, and Blade templates.',
            ],
        ];

        $journeyItems = [
            [
                'title' => 'Full Stack Developer Focus (Present)',
                'desc' => 'Crafting end-to-end web applications with Laravel, PHP, MySQL, and Tailwind CSS.',
                'responsibilities' => [
                    'Design and ship complete Laravel applications from Blade UI to MySQL persistence',
                    'Implement authenticated flows, form validation, and reusable Blade components',
                    'Keep feature work responsive with Tailwind CSS and progressive enhancement',
                ],
                'tools' => ['Laravel', 'PHP', 'MySQL', 'Blade', 'Tailwind CSS', 'Git'],
                'architecture' => [
                    'MVC layering with Controllers, Form Requests, and Eloquent Models',
                    'Service-oriented helpers for reusable business logic',
                    'Mobile-first layouts with consistent design tokens',
                ],
            ],
            [
                'title' => 'Backend & API Mastery',
                'desc' => 'Specialized in REST APIs, authentication (JWT/Sanctum), and database management.',
                'responsibilities' => [
                    'Build JSON REST endpoints for SPA / mobile consumers',
                    'Secure APIs with token auth patterns (JWT / Laravel Sanctum concepts)',
                    'Model relational data and keep migrations / indexes production-ready',
                ],
                'tools' => ['Laravel', 'PHP', 'MySQL', 'Postman', 'JWT / Sanctum', 'GitHub'],
                'architecture' => [
                    'Resourceful routing and API Resources for consistent payloads',
                    'Foreign keys, unique constraints, and indexed lookup columns',
                    'Clear separation between auth, domain logic, and presentation',
                ],
            ],
            [
                'title' => 'Continuous Growth',
                'desc' => 'Consistently building personal full stack applications and expanding skills in modern web tech.',
                'responsibilities' => [
                    'Iterate on personal projects to practice architecture trade-offs',
                    'Document patterns and keep codebases easy for collaboration',
                    'Explore frontend interactivity (Alpine.js, AOS) while staying Laravel-first',
                ],
                'tools' => ['Laravel', 'JavaScript', 'Alpine.js', 'Tailwind CSS', 'XAMPP', 'Git'],
                'architecture' => [
                    'Incremental feature delivery with clean commits',
                    'Reusable UI sections and accessible interaction patterns',
                    'Local-first workflows (XAMPP / artisan) before deployment thinking',
                ],
            ],
        ];

        $serviceCards = [
            [
                'icon' => 'app-window',
                'title' => 'Custom Laravel Web Apps',
                'desc' => 'End-to-end web application development using Laravel, PHP, MySQL, and Tailwind CSS. Built with clean MVC architecture.',
            ],
            [
                'icon' => 'unplug',
                'title' => 'RESTful API Development & Integration',
                'desc' => 'Designing secure, structured, and fast API endpoints (JSON/JWT) for mobile apps or third-party frontend integrations.',
            ],
            [
                'icon' => 'database-zap',
                'title' => 'Database Design & Optimization',
                'desc' => 'Architecting relational MySQL databases, optimizing query performance, and implementing secure data management.',
            ],
        ];

        $faqItems = [
            [
                'question' => 'Are you available for full-time roles or freelance projects?',
                'answer' => 'Yes! I am open to full-time Full Stack / Backend Developer opportunities as well as freelance project requests.',
            ],
            [
                'question' => 'What is your primary backend tech stack?',
                'answer' => 'My core expertise lies in PHP and Laravel, paired with MySQL databases and XAMPP/local development setups, alongside Node.js for REST APIs.',
            ],
            [
                'question' => 'How do you ensure code quality and maintainability?',
                'answer' => 'I follow clean code principles, MVC patterns, write clear documentation, and leverage version control (Git/GitHub) for easy collaboration and scalability.',
            ],
        ];

        $skillGroups = [
            [
                'title' => 'Frontend',
                'category' => 'frontend',
                'icon' => 'layout',
                'skills' => ['HTML5', 'CSS3', 'JavaScript', 'Blade Templates', 'Tailwind CSS'],
            ],
            [
                'title' => 'Backend',
                'category' => 'backend',
                'icon' => 'server',
                'skills' => ['PHP', 'Laravel', 'Node.js', 'RESTful APIs'],
            ],
            [
                'title' => 'Database',
                'category' => 'database',
                'icon' => 'database',
                'skills' => ['MySQL'],
            ],
            [
                'title' => 'Tools & Ecosystem',
                'category' => 'tools',
                'icon' => 'wrench',
                'skills' => ['Git', 'GitHub', 'Postman', 'XAMPP'],
            ],
        ];

        $skillFilters = [
            ['key' => 'all', 'label' => 'All'],
            ['key' => 'backend', 'label' => 'Backend & PHP'],
            ['key' => 'frontend', 'label' => 'Frontend & UI'],
            ['key' => 'devtools', 'label' => 'Database & DevTools'],
        ];
    @endphp

    <script>
        window.portfolioConfig = @json($portfolioConfig);
    </script>

    {{-- Scroll progress bar --}}
    <div class="fixed left-0 top-0 z-[60] h-[3px] w-full bg-transparent" aria-hidden="true">
        <div
            id="scroll-progress"
            class="h-full w-0 bg-gradient-to-r from-emerald-500 to-violet-500"
        ></div>
    </div>

    {{-- Toast notification --}}
    <div
        x-show="toastVisible"
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-[-8px]"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="toast-enter fixed left-4 right-4 top-[4.5rem] z-[100] flex max-w-sm items-start gap-3 rounded-xl border border-emerald-500/40 bg-white/95 dark:bg-zinc-900/95 px-4 py-3 shadow-xl shadow-emerald-500/10 backdrop-blur-md sm:left-auto sm:right-6"
        role="status"
        aria-live="polite"
    >
        <span
            class="mt-0.5 inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full"
            :class="toastError ? 'bg-rose-500/20 text-rose-500' : 'bg-emerald-500/20 text-emerald-600 dark:text-emerald-400'"
        >
            <i x-show="!toastError" data-lucide="check-circle-2" class="h-5 w-5"></i>
            <i x-show="toastError" x-cloak data-lucide="alert-circle" class="h-5 w-5"></i>
        </span>
        <div>
            <p class="text-sm font-semibold text-zinc-900 dark:text-zinc-100" x-text="toastError ? 'Something went wrong' : 'Message Sent!'"></p>
            <p class="mt-0.5 text-xs leading-relaxed text-zinc-600 dark:text-zinc-400" x-text="toastMessage"></p>
        </div>
        <button
            type="button"
            class="ml-2 text-zinc-500 dark:text-zinc-500 transition hover:text-zinc-700 dark:hover:text-zinc-300"
            @click="toastVisible = false"
            aria-label="Dismiss notification"
        >
            <i data-lucide="x" class="h-4 w-4"></i>
        </button>
    </div>

    {{-- Theme confirmation modal --}}
    <div
        id="theme-modal"
        class="fixed inset-0 z-[110] flex items-center justify-center p-4 opacity-0 pointer-events-none transition-all duration-300 ease-in-out"
        aria-hidden="true"
        role="dialog"
        aria-modal="true"
        aria-labelledby="theme-modal-title"
    >
        <div id="theme-modal-backdrop" class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity duration-300 ease-in-out"></div>
        <div
            id="theme-modal-panel"
            class="relative z-10 w-full max-w-md scale-95 rounded-2xl border border-slate-200 bg-white/90 p-6 shadow-2xl shadow-emerald-500/10 backdrop-blur-xl transition-all duration-300 ease-in-out dark:border-zinc-700 dark:bg-zinc-900/90 sm:p-7"
        >
            <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500/20 to-violet-500/20 text-emerald-600 dark:text-emerald-400">
                <i data-lucide="palette" class="h-6 w-6"></i>
            </div>
            <h3 id="theme-modal-title" class="mb-2 text-xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">
                Switch Theme?
            </h3>
            <p id="theme-modal-desc" class="mb-6 text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">
                Are you sure you want to switch theme?
            </p>
            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                <button
                    type="button"
                    id="theme-modal-cancel"
                    class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-transparent px-5 py-2.5 text-sm font-semibold text-zinc-700 transition hover:bg-slate-100 dark:border-zinc-600 dark:text-zinc-300 dark:hover:bg-zinc-800"
                >
                    Cancel
                </button>
                <button
                    type="button"
                    id="theme-modal-confirm"
                    class="glow-emerald inline-flex items-center justify-center gap-2 rounded-lg bg-gradient-to-r from-emerald-500 to-violet-500 px-5 py-2.5 text-sm font-semibold text-zinc-950 transition hover:from-emerald-400 hover:to-violet-400"
                >
                    <i data-lucide="check" class="h-4 w-4"></i>
                    Confirm &amp; Switch
                </button>
            </div>
        </div>
    </div>

    {{-- ===================== NAVIGATION ===================== --}}
    <header class="pointer-events-none sticky top-0 z-50 px-3 pt-3 sm:px-4">
        <nav
            id="main-nav"
            class="nav-shell pointer-events-auto mx-auto flex max-w-6xl items-center justify-between gap-3 rounded-full border border-slate-200/80 bg-white/75 px-4 py-2.5 shadow-lg shadow-black/5 backdrop-blur-md dark:border-zinc-800/80 dark:bg-zinc-900/70 dark:shadow-black/20 sm:px-6 sm:py-3"
        >
            {{-- Logo --}}
            <a href="#hero" class="group flex shrink-0 items-center gap-2.5">
                <span class="relative flex h-2.5 w-2.5 shrink-0">
                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-60"></span>
                    <span class="relative inline-flex h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                </span>
                <span class="logo-text text-base font-bold tracking-tight text-zinc-900 dark:text-zinc-100 sm:text-lg">
                    John Bryan
                </span>
                <span class="hidden shrink-0 rounded-md border border-slate-300 dark:border-zinc-700 bg-slate-100/80 dark:bg-zinc-800/80 px-1.5 py-0.5 font-mono text-[10px] leading-none text-emerald-600 dark:text-emerald-400 md:inline-flex md:items-center">
                    &lt;/&gt;
                </span>
            </a>

            {{-- Desktop Nav --}}
            <ul class="hidden items-center gap-5 lg:flex xl:gap-6">
                @foreach ($navLinks as $link)
                    <li>
                        <a href="{{ $link['href'] }}"
                           data-nav-link
                           class="nav-link whitespace-nowrap text-sm font-medium text-zinc-600 transition-colors duration-300 hover:text-emerald-600 dark:text-zinc-400 dark:hover:text-emerald-400">
                            {{ $link['label'] }}
                        </a>
                    </li>
                @endforeach
                <li class="relative" @click.outside="moreOpen = false">
                    <button
                        type="button"
                        class="nav-link inline-flex items-center gap-1 whitespace-nowrap text-sm font-medium text-zinc-600 transition-colors duration-300 hover:text-emerald-600 dark:text-zinc-400 dark:hover:text-emerald-400"
                        @click="moreOpen = !moreOpen; $nextTick(() => window.initLucideIcons && window.initLucideIcons())"
                        :aria-expanded="moreOpen.toString()"
                    >
                        More
                        <i data-lucide="chevron-down" class="h-4 w-4 transition-transform duration-300" :class="moreOpen && 'rotate-180'"></i>
                    </button>
                    <div
                        x-show="moreOpen"
                        x-cloak
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                        x-transition:leave-end="opacity-0 translate-y-1 scale-95"
                        class="absolute right-0 top-full z-50 mt-3 min-w-[11rem] overflow-hidden rounded-2xl border border-slate-200/80 bg-white/95 p-1.5 shadow-xl shadow-black/10 backdrop-blur-md dark:border-zinc-700/80 dark:bg-zinc-900/95 dark:shadow-black/40"
                    >
                        @foreach ($moreLinks as $link)
                            <a href="{{ $link['href'] }}"
                               data-nav-link
                               @click="moreOpen = false"
                               class="block rounded-xl px-3 py-2 text-sm font-medium text-zinc-600 transition hover:bg-emerald-500/10 hover:text-emerald-600 dark:text-zinc-300 dark:hover:text-emerald-400">
                                {{ $link['label'] }}
                            </a>
                        @endforeach
                    </div>
                </li>
            </ul>

            {{-- Theme + Command + Mobile --}}
            <div class="flex items-center gap-2">
                <button
                    type="button"
                    class="hidden items-center gap-1.5 rounded-full border border-slate-300/80 bg-white/70 px-2.5 py-1.5 text-[11px] font-medium text-zinc-500 shadow-sm backdrop-blur-sm transition-all duration-300 hover:border-emerald-500/40 hover:text-emerald-600 dark:border-zinc-700/80 dark:bg-zinc-800/50 dark:text-zinc-400 dark:hover:text-emerald-400 xl:inline-flex"
                    @click="openCmd()"
                    title="Open command palette"
                >
                    <i data-lucide="command" class="h-3.5 w-3.5"></i>
                    <span>Press</span>
                    <kbd class="rounded border border-slate-300 bg-slate-100 px-1.5 py-0.5 font-mono text-[10px] text-zinc-600 dark:border-zinc-600 dark:bg-zinc-900 dark:text-zinc-300">Ctrl</kbd>
                    <span>+</span>
                    <kbd class="rounded border border-slate-300 bg-slate-100 px-1.5 py-0.5 font-mono text-[10px] text-zinc-600 dark:border-zinc-600 dark:bg-zinc-900 dark:text-zinc-300">K</kbd>
                    <span class="hidden 2xl:inline">to navigate</span>
                </button>
                <button
                    type="button"
                    class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-slate-300/80 bg-white/70 text-zinc-700 shadow-sm backdrop-blur-sm transition-all duration-300 hover:border-emerald-500/50 hover:text-emerald-600 dark:border-zinc-700/80 dark:bg-zinc-800/50 dark:text-zinc-300 dark:hover:text-emerald-400 xl:hidden"
                    @click="openCmd()"
                    aria-label="Open command palette"
                    title="Ctrl + K"
                >
                    <i data-lucide="search" class="h-4 w-4"></i>
                </button>
                <button
                    type="button"
                    id="theme-toggle"
                    class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-slate-300/80 bg-white/70 text-zinc-700 shadow-sm backdrop-blur-sm transition-all duration-300 hover:rotate-12 hover:border-emerald-500/50 hover:text-emerald-600 hover:shadow-[0_0_18px_rgba(16,185,129,0.35)] dark:border-zinc-700/80 dark:bg-zinc-800/50 dark:text-zinc-300 dark:hover:text-emerald-400"
                    aria-label="Toggle dark mode"
                    title="Toggle theme"
                >
                    <i id="theme-icon-sun" data-lucide="sun" class="hidden h-5 w-5"></i>
                    <i id="theme-icon-moon" data-lucide="moon" class="h-5 w-5"></i>
                </button>
                <button
                    type="button"
                    class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-slate-300/80 bg-white/70 text-zinc-700 backdrop-blur-sm transition hover:border-emerald-500/50 hover:text-emerald-600 dark:border-zinc-700/80 dark:bg-zinc-800/50 dark:text-zinc-300 dark:hover:text-emerald-400 lg:hidden"
                    @click="mobileOpen = !mobileOpen; moreOpen = false; $nextTick(() => window.initLucideIcons && window.initLucideIcons())"
                    :aria-expanded="mobileOpen.toString()"
                    aria-label="Toggle menu"
                >
                    <i x-show="!mobileOpen" data-lucide="menu" class="h-5 w-5"></i>
                    <i x-show="mobileOpen" x-cloak data-lucide="x" class="h-5 w-5"></i>
                </button>
            </div>
        </nav>

        {{-- Mobile glassmorphic drawer --}}
        <div
            x-show="mobileOpen"
            x-cloak
            class="pointer-events-auto fixed inset-0 z-40 lg:hidden"
            @keydown.escape.window="mobileOpen = false"
        >
            <div
                class="absolute inset-0 bg-black/50 backdrop-blur-sm"
                x-show="mobileOpen"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                @click="mobileOpen = false"
            ></div>
            <div
                class="absolute right-0 top-0 flex h-full w-[min(100%,20rem)] flex-col border-l border-slate-200/70 bg-white/90 shadow-2xl backdrop-blur-xl dark:border-zinc-800/80 dark:bg-zinc-950/90"
                x-show="mobileOpen"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="translate-x-full opacity-0"
                x-transition:enter-end="translate-x-0 opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="translate-x-0 opacity-100"
                x-transition:leave-end="translate-x-full opacity-0"
            >
                <div class="flex items-center justify-between border-b border-slate-200/80 px-5 py-4 dark:border-zinc-800">
                    <span class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Menu</span>
                    <button
                        type="button"
                        class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-slate-300 text-zinc-600 dark:border-zinc-700 dark:text-zinc-300"
                        @click="mobileOpen = false"
                        aria-label="Close menu"
                    >
                        <i data-lucide="x" class="h-4 w-4"></i>
                    </button>
                </div>
                <div class="flex-1 overflow-y-auto px-3 py-4">
                    <p class="mb-2 px-3 text-[11px] font-semibold uppercase tracking-wider text-zinc-500">Primary</p>
                    <ul class="mb-5 space-y-1">
                        @foreach ($navLinks as $link)
                            <li>
                                <a href="{{ $link['href'] }}"
                                   data-nav-link
                                   @click="mobileOpen = false"
                                   class="nav-link block rounded-xl px-3 py-2.5 text-sm font-medium text-zinc-700 transition hover:bg-emerald-500/10 hover:text-emerald-600 dark:text-zinc-300 dark:hover:text-emerald-400">
                                    {{ $link['label'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <p class="mb-2 px-3 text-[11px] font-semibold uppercase tracking-wider text-zinc-500">More</p>
                    <ul class="space-y-1">
                        @foreach ($moreLinks as $link)
                            <li>
                                <a href="{{ $link['href'] }}"
                                   data-nav-link
                                   @click="mobileOpen = false"
                                   class="nav-link block rounded-xl px-3 py-2.5 text-sm font-medium text-zinc-700 transition hover:bg-emerald-500/10 hover:text-emerald-600 dark:text-zinc-300 dark:hover:text-emerald-400">
                                    {{ $link['label'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <main>
        {{-- ===================== HERO ===================== --}}
        <section id="hero" class="section-screen relative flex scroll-mt-24 snap-start flex-col justify-center overflow-hidden">
            {{-- Ambient glow --}}
            <div class="pointer-events-none absolute -left-32 top-10 h-80 w-80 rounded-full bg-emerald-500/15 blur-3xl ambient-glow"></div>
            <div class="pointer-events-none absolute -right-24 bottom-8 h-96 w-96 rounded-full bg-violet-500/15 blur-3xl ambient-glow-delay"></div>

            <div class="relative mx-auto w-full max-w-7xl px-6 py-12 md:py-20">
                <div class="grid grid-cols-1 items-center gap-12 lg:grid-cols-12">
                    {{-- Left: bio / code / CTAs (7 cols) --}}
                    <div class="order-2 flex flex-col items-start lg:order-1 lg:col-span-7">
                        {{-- Status badges --}}
                        <div class="mb-7 flex flex-wrap items-center gap-2.5 animate-fade-in">
                            <div class="hero-status-pill">
                                <span class="relative flex h-2 w-2">
                                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-70"></span>
                                    <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.8)]"></span>
                                </span>
                                <span>Open for opportunities</span>
                            </div>
                            <div class="hero-status-pill">
                                <span>📍</span>
                                <span>Based in Philippines (PST / UTC+8)</span>
                            </div>
                            <div class="hero-status-pill">
                                <i data-lucide="clock" class="h-3.5 w-3.5 text-emerald-400"></i>
                                <span>Philippine Time: <span id="ph-clock">--:-- --</span></span>
                            </div>
                        </div>

                        <h1 class="mb-4 text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl xl:text-7xl animate-fade-in" style="animation-delay: 0.1s">
                            <span class="hero-name-gradient">John Bryan</span>
                        </h1>

                        {{-- Typewriter role title --}}
                        <p class="mb-5 flex min-h-[1.75rem] max-w-full items-center text-xl font-semibold text-zinc-800 dark:text-zinc-200 sm:min-h-[2.75rem] sm:text-2xl lg:text-3xl animate-fade-in" style="animation-delay: 0.2s">
                            <span id="typewriter-text" class="break-words text-zinc-800 dark:text-zinc-200">Full Stack Developer</span><span class="typewriter-cursor" aria-hidden="true"></span>
                        </p>

                        <p class="mb-8 max-w-2xl text-base leading-relaxed text-zinc-600 dark:text-zinc-400 sm:text-lg animate-fade-in" style="animation-delay: 0.3s">
                            Building scalable, responsive, and user-focused web applications from front to back — with Laravel architecture, clean APIs, and polished UI craft.
                        </p>

                        {{-- Mini IDE code preview --}}
                        <div
                            class="hero-code-card mb-2 w-full max-w-xl overflow-hidden rounded-2xl border border-zinc-800/80 bg-zinc-950/95 font-mono text-xs backdrop-blur-md animate-fade-in"
                            style="animation-delay: 0.35s"
                            x-data="{
                                copiedCode: false,
                                async copySnippet() {
                                    const text = [
                                        'const developer = {',
                                        '  name: \'John Bryan\',',
                                        '  stack: [\'Laravel\', \'JS\', \'MySQL\'],',
                                        '  status: \'available\'',
                                        '};',
                                    ].join('\n');
                                    try {
                                        await navigator.clipboard.writeText(text);
                                        this.copiedCode = true;
                                        this.$nextTick(() => window.initLucideIcons && window.initLucideIcons());
                                        setTimeout(() => {
                                            this.copiedCode = false;
                                            this.$nextTick(() => window.initLucideIcons && window.initLucideIcons());
                                        }, 2000);
                                    } catch (e) {
                                        console.error('Copy failed', e);
                                    }
                                }
                            }"
                        >
                            <div class="flex items-center justify-between border-b border-zinc-800/80 bg-zinc-900/90 px-4 py-3">
                                <div class="flex min-w-0 items-center gap-3">
                                    <div class="flex gap-1.5">
                                        <span class="h-2.5 w-2.5 rounded-full bg-red-500/80"></span>
                                        <span class="h-2.5 w-2.5 rounded-full bg-amber-500/80"></span>
                                        <span class="h-2.5 w-2.5 rounded-full bg-emerald-500/80"></span>
                                    </div>
                                    <span class="inline-flex items-center gap-1.5 truncate text-[11px] text-zinc-400">
                                        <span class="h-1.5 w-1.5 shrink-0 rounded-full bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.85)]"></span>
                                        active_session.json
                                    </span>
                                </div>
                                <button
                                    type="button"
                                    class="inline-flex shrink-0 items-center gap-1.5 rounded-lg border border-zinc-700/80 bg-zinc-950/70 px-2.5 py-1.5 text-[11px] font-medium text-zinc-400 transition-all duration-300 hover:border-emerald-500/40 hover:text-emerald-300"
                                    @click="copySnippet()"
                                    :class="copiedCode && 'border-emerald-500/50 text-emerald-300'"
                                >
                                    <svg x-show="!copiedCode" xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/></svg>
                                    <svg x-show="copiedCode" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                                    <span x-text="copiedCode ? 'Copied!' : 'Copy'"></span>
                                </button>
                            </div>
                            <div class="space-y-1 p-5 text-[13px] leading-relaxed sm:text-sm">
                                <p>
                                    <span class="text-violet-400">const</span>
                                    <span class="font-semibold text-zinc-100"> developer </span>
                                    <span class="text-zinc-400">=</span>
                                    <span class="text-zinc-400"> {</span>
                                </p>
                                <p class="pl-5">
                                    <span class="text-violet-300">name</span><span class="text-zinc-400">:</span>
                                    <span class="text-emerald-400"> "John Bryan"</span><span class="text-zinc-400">,</span>
                                </p>
                                <p class="pl-5">
                                    <span class="text-violet-300">stack</span><span class="text-zinc-400">:</span>
                                    <span class="text-zinc-400"> [</span><span class="text-emerald-400">"Laravel"</span><span class="text-zinc-400">,</span>
                                    <span class="text-emerald-400"> "JS"</span><span class="text-zinc-400">,</span>
                                    <span class="text-emerald-400"> "MySQL"</span><span class="text-zinc-400">],</span>
                                </p>
                                <p class="pl-5">
                                    <span class="text-violet-300">status</span><span class="text-zinc-400">:</span>
                                    <span class="text-emerald-400"> "available"</span>
                                </p>
                                <p><span class="text-zinc-400">};</span></p>
                            </div>
                        </div>

                        {{-- Unified CTA row --}}
                        <div class="mt-8 flex w-full flex-wrap items-center gap-3.5 animate-fade-in" style="animation-delay: 0.4s">
                            <a href="#skills"
                               class="glow-emerald inline-flex h-12 w-auto shrink-0 items-center justify-center gap-2 whitespace-nowrap rounded-xl bg-emerald-500 px-5 py-3 text-sm font-bold text-zinc-950 shadow-lg shadow-emerald-500/25 transition-all duration-300 hover:bg-emerald-400">
                                <i data-lucide="folders" class="h-4 w-4 shrink-0"></i>
                                View Projects
                            </a>
                            <a href="#contact"
                               class="inline-flex h-12 w-auto shrink-0 items-center justify-center gap-2 whitespace-nowrap rounded-xl border border-zinc-700/80 bg-zinc-900/60 px-5 py-3 text-sm font-semibold text-zinc-200 backdrop-blur-md transition-all duration-300 hover:border-violet-500 hover:text-violet-400">
                                <i data-lucide="mail" class="h-4 w-4 shrink-0"></i>
                                Contact Me
                            </a>
                            <button
                                type="button"
                                @click="openResume()"
                                class="inline-flex h-12 w-auto shrink-0 items-center justify-center gap-2 whitespace-nowrap rounded-xl border border-zinc-700/80 bg-zinc-900/60 px-5 py-3 text-sm font-semibold text-zinc-200 backdrop-blur-md transition-all duration-300 hover:border-emerald-500 hover:text-emerald-400"
                            >
                                <i data-lucide="download" class="h-4 w-4 shrink-0"></i>
                                Download Resume / CV
                            </button>
                        </div>
                    </div>

                    {{-- Right: transparent portrait + ambient glow (5 cols) --}}
                    <div class="hero-photo-stage relative order-1 mx-auto flex w-full max-w-md flex-col items-center lg:order-2 lg:col-span-5 lg:max-w-none animate-fade-in" style="animation-delay: 0.25s">
                        {{-- Multi-layer glowing aura --}}
                        <div class="hero-aura pointer-events-none absolute left-1/2 top-[42%] -z-10 h-72 w-72 -translate-x-1/2 -translate-y-1/2 rounded-full bg-gradient-to-tr from-emerald-500/25 via-violet-500/20 to-transparent blur-3xl sm:h-80 sm:w-80"></div>
                        <div class="hero-aura-delay pointer-events-none absolute left-[18%] top-[28%] -z-10 h-56 w-56 rounded-full bg-emerald-500/30 blur-3xl"></div>
                        <div class="hero-aura pointer-events-none absolute right-[10%] bottom-[20%] -z-10 h-52 w-52 rounded-full bg-violet-500/30 blur-3xl" style="animation-delay: 0.6s"></div>

                        {{-- Geometric rings --}}
                        <div class="pointer-events-none absolute left-1/2 top-[40%] h-56 w-56 -translate-x-1/2 -translate-y-1/2 rounded-full border border-emerald-500/20 opacity-40 sm:h-64 sm:w-64"></div>
                        <div class="pointer-events-none absolute left-1/2 top-[40%] h-72 w-72 -translate-x-1/2 -translate-y-1/2 rounded-full border border-violet-500/15 opacity-35 sm:h-80 sm:w-80"></div>

                        {{-- Faint floating code accents --}}
                        <span class="hero-deco-mark left-[8%] top-[18%] animate-float-slow text-emerald-400/80">{ }</span>
                        <span class="hero-deco-mark right-[10%] top-[22%] animate-float-slower text-violet-400/80">&lt;/&gt;</span>
                        <span class="hero-deco-mark left-[4%] top-[55%] animate-float text-xs tracking-wider text-emerald-300/80">=&gt;</span>
                        <span class="hero-deco-mark right-[6%] top-[58%] animate-float-slow text-[11px] tracking-widest text-violet-300/80">DB::</span>

                        {{-- Floating glass pills (staggered float + hover) --}}
                        <span class="hero-float-pill pill-a left-0 top-4 sm:-left-2 sm:top-6">⚡ Laravel 11 Specialist</span>
                        <span class="hero-float-pill pill-b right-0 top-14 sm:-right-1 sm:top-12">🟢 Available for Hire</span>
                        <span class="hero-float-pill pill-c right-2 bottom-24 sm:right-0 sm:bottom-28">🛠️ REST API &amp; MySQL</span>

                        <div class="hero-photo-frame relative w-full bg-transparent">
                            <img
                                src="{{ asset('images/bryan-cutout.png') }}"
                                alt="John Bryan — Full Stack Developer"
                                width="640"
                                height="800"
                                class="hero-photo-img relative z-10 mx-auto h-auto w-full max-h-[380px] bg-transparent object-contain object-bottom sm:max-h-[480px] lg:max-h-[540px]"
                                loading="eager"
                                decoding="async"
                            >
                        </div>

                        <div class="relative z-20 -mt-4 flex w-full max-w-sm items-center justify-between px-2">
                            <div>
                                <p class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">John Bryan Bolarde</p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">Full Stack / Laravel Developer</p>
                            </div>
                            <span class="inline-flex items-center gap-1.5 rounded-full border border-emerald-500/30 bg-emerald-500/10 px-2.5 py-1 text-[10px] font-semibold text-emerald-700 backdrop-blur-sm dark:text-emerald-400">
                                <span class="relative flex h-1.5 w-1.5">
                                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-70"></span>
                                    <span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                </span>
                                Online
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ===================== ABOUT ===================== --}}
        <section id="about" class="section-screen relative flex scroll-mt-24 snap-start flex-col justify-center border-t border-slate-200 dark:border-zinc-800/80" data-aos="fade-up">
            <div class="mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="mb-6 max-w-2xl" data-aos="fade-up">
                    <span class="section-chip">✦ Who I Am</span>
                    <h2 class="section-title mb-6 text-3xl font-bold tracking-tight sm:text-4xl">
                        About Me
                    </h2>
                    <p class="text-base leading-relaxed text-zinc-600 dark:text-zinc-400 sm:text-lg">
                        Hi! I'm John Bryan, a 25-year-old Full Stack Developer with a passion for turning complex problems into clean, efficient code. I specialize in building complete web solutions—from designing intuitive user interfaces to architecting robust backend APIs and databases. Constant learning drives my development journey, and I'm always eager to explore new technologies to build better web experiences.
                    </p>
                </div>

                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($aboutCards as $index => $card)
                        <article
                            class="interactive-card glass-card group rounded-xl p-6"
                            data-aos="fade-up"
                            data-aos-delay="{{ ($index + 1) * 100 }}"
                        >
                            <div class="mb-4 inline-flex h-11 w-11 items-center justify-center rounded-lg border border-slate-300 dark:border-zinc-700 bg-slate-100 dark:bg-zinc-800/80 text-emerald-600 dark:text-emerald-400 transition-all duration-300 group-hover:border-emerald-500/40 group-hover:text-violet-400">
                                <i data-lucide="{{ $card['icon'] }}" class="h-5 w-5"></i>
                            </div>
                            <h3 class="mb-2 text-lg font-semibold text-zinc-900 dark:text-zinc-100">{{ $card['title'] }}</h3>
                            <p class="text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">{{ $card['desc'] }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ===================== STRENGTHS ===================== --}}
        <section id="strengths" class="section-screen relative flex scroll-mt-24 snap-start flex-col justify-center border-t border-slate-200 dark:border-zinc-800/80" data-aos="fade-up">
            <div class="pointer-events-none absolute left-0 top-10 h-64 w-64 rounded-full bg-emerald-500/5 blur-3xl ambient-glow"></div>

            <div class="relative mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="mb-6 max-w-2xl" data-aos="fade-up">
                    <span class="section-chip">✦ Core Competencies</span>
                    <h2 class="section-title mb-4 text-3xl font-bold tracking-tight sm:text-4xl">
                        What I Bring to the Table
                    </h2>
                    <p class="text-base text-zinc-600 dark:text-zinc-400 sm:text-lg">
                        My core technical identity — the strengths I bring to every project I build.
                    </p>
                </div>

                <div class="grid gap-4 lg:grid-cols-3">
                    @foreach ($strengthCards as $index => $card)
                        <article
                            class="interactive-card glass-card group rounded-xl p-6"
                            data-aos="fade-up"
                            data-aos-delay="{{ ($index + 1) * 100 }}"
                        >
                            <div class="pointer-events-none absolute -right-8 -top-8 h-28 w-28 rounded-full bg-gradient-to-br from-emerald-500/10 to-violet-500/10 blur-2xl transition duration-300 group-hover:from-emerald-500/20 group-hover:to-violet-500/20"></div>
                            <div class="relative z-[1]">
                                <div class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500/20 to-violet-500/20 text-emerald-600 dark:text-emerald-400 transition-all duration-300 group-hover:text-violet-300">
                                    <i data-lucide="{{ $card['icon'] }}" class="h-6 w-6"></i>
                                </div>
                                <h3 class="mb-3 text-lg font-semibold text-zinc-900 dark:text-zinc-100">{{ $card['title'] }}</h3>
                                <p class="text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">{{ $card['desc'] }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ===================== SKILLS ===================== --}}
        <section
            id="skills"
            class="section-screen relative flex scroll-mt-24 snap-start flex-col justify-center border-t border-slate-200 dark:border-zinc-800/80"
            data-aos="fade-up"
            x-data="{
                skillFilter: 'all',
                matches(category) {
                    if (this.skillFilter === 'all') return true;
                    if (this.skillFilter === 'backend') return category === 'backend';
                    if (this.skillFilter === 'frontend') return category === 'frontend';
                    if (this.skillFilter === 'devtools') return category === 'database' || category === 'tools';
                    return true;
                },
                setFilter(key) {
                    this.skillFilter = key;
                    this.$nextTick(() => window.initLucideIcons && window.initLucideIcons());
                }
            }"
        >
            <div class="pointer-events-none absolute right-0 top-20 h-64 w-64 rounded-full bg-violet-500/5 blur-3xl ambient-glow-delay"></div>

            <div class="relative mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="mb-6 max-w-2xl" data-aos="fade-up">
                    <span class="section-chip">✦ Toolkit</span>
                    <h2 class="section-title mb-4 text-3xl font-bold tracking-tight sm:text-4xl">
                        Tech Stack
                    </h2>
                    <p class="text-base text-zinc-600 dark:text-zinc-400 sm:text-lg">
                        Technologies I use to design, build, and ship production-ready web applications.
                    </p>
                </div>

                {{-- Category filters --}}
                <div class="mb-8 flex flex-wrap gap-2" data-aos="fade-up" data-aos-delay="80" role="tablist" aria-label="Tech stack categories">
                    @foreach ($skillFilters as $filter)
                        <button
                            type="button"
                            role="tab"
                            class="rounded-full border px-3.5 py-2 text-xs font-semibold transition-all duration-300 sm:text-sm"
                            :class="skillFilter === '{{ $filter['key'] }}'
                                ? 'border-emerald-500/50 bg-emerald-500/15 text-emerald-700 shadow-sm shadow-emerald-500/10 dark:text-emerald-300'
                                : 'border-slate-300 bg-white/80 text-zinc-600 hover:border-emerald-500/40 hover:text-emerald-600 dark:border-zinc-700 dark:bg-zinc-900/60 dark:text-zinc-400 dark:hover:text-emerald-400'"
                            :aria-selected="(skillFilter === '{{ $filter['key'] }}').toString()"
                            @click="setFilter('{{ $filter['key'] }}')"
                        >
                            {{ $filter['label'] }}
                        </button>
                    @endforeach
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    @foreach ($skillGroups as $index => $group)
                        <div
                            x-show="matches('{{ $group['category'] }}')"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-y-2 scale-[0.98]"
                            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-[0.98]"
                            class="interactive-card glass-card rounded-xl p-6"
                            data-aos="fade-up"
                            data-aos-delay="{{ ($index + 1) * 100 }}"
                            data-skill-category="{{ $group['category'] }}"
                        >
                            <div class="mb-5 flex items-center gap-3">
                                <div class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-br from-emerald-500/20 to-violet-500/20 text-emerald-600 dark:text-emerald-400">
                                    <i data-lucide="{{ $group['icon'] }}" class="h-5 w-5"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">{{ $group['title'] }}</h3>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($group['skills'] as $skill)
                                    <span class="skill-pill rounded-md border border-slate-300 dark:border-zinc-700 bg-slate-100 dark:bg-zinc-800/60 px-3 py-1.5 text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                        {{ $skill }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ===================== DATABASE SCHEMA VISUALIZER ===================== --}}
        <section
            id="schema"
            class="section-screen relative flex scroll-mt-24 snap-start flex-col justify-center border-t border-slate-200 dark:border-zinc-800/80"
            data-aos="fade-up"
            x-data='{
                activeTable: "users",
                tables: @json($schemaTables),
                setTable(key) {
                    this.activeTable = key;
                    this.$nextTick(() => window.initLucideIcons && window.initLucideIcons());
                }
            }'
            x-init="$nextTick(() => window.initLucideIcons && window.initLucideIcons())"
        >
            <div class="pointer-events-none absolute left-10 top-16 h-64 w-64 rounded-full bg-emerald-500/5 blur-3xl ambient-glow"></div>

            <div class="relative mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="mb-6 max-w-2xl" data-aos="fade-up">
                    <span class="section-chip">✦ Data Layer</span>
                    <h2 class="section-title mb-4 text-3xl font-bold tracking-tight sm:text-4xl">
                        Database & System Architecture
                    </h2>
                    <p class="text-base text-zinc-600 dark:text-zinc-400 sm:text-lg">
                        How I structure relational MySQL databases for performance and scale.
                    </p>
                </div>

                <div class="glass-card overflow-hidden rounded-2xl" data-aos="fade-up" data-aos-delay="120">
                    {{-- Table tabs --}}
                    <div class="flex flex-wrap gap-2 border-b border-slate-200/80 bg-slate-50/80 p-3 dark:border-zinc-800/80 dark:bg-zinc-950/40 sm:p-4">
                        <template x-for="(table, key) in tables" :key="key">
                            <button
                                type="button"
                                class="inline-flex items-center gap-2 rounded-xl border px-3.5 py-2 text-sm font-semibold transition-all duration-300"
                                :class="activeTable === key
                                    ? 'border-emerald-500/50 bg-emerald-500/15 text-emerald-700 shadow-sm shadow-emerald-500/10 dark:text-emerald-300'
                                    : 'border-slate-200 bg-white text-zinc-600 hover:border-zinc-400 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-400 dark:hover:border-zinc-500 dark:hover:text-zinc-200'"
                                @click="setTable(key)"
                            >
                                <i :data-lucide="table.icon" class="h-4 w-4"></i>
                                <span class="font-mono" x-text="table.label"></span>
                            </button>
                        </template>
                    </div>

                    {{-- Schema body --}}
                    <div class="grid gap-0 lg:grid-cols-5">
                        <div class="border-b border-slate-200/80 p-4 dark:border-zinc-800/80 sm:p-6 lg:col-span-3 lg:border-b-0 lg:border-r">
                            <div class="mb-4 flex flex-wrap items-center justify-between gap-2">
                                <div>
                                    <p class="text-xs font-medium uppercase tracking-wider text-zinc-500">Migration columns</p>
                                    <h3 class="font-mono text-lg font-semibold text-zinc-900 dark:text-zinc-100">
                                        <span class="text-emerald-500">$</span>table<span class="text-zinc-500">-</span>&gt;<span class="text-violet-400" x-text="tables[activeTable].label"></span>
                                    </h3>
                                </div>
                                <span class="rounded-full border border-violet-500/30 bg-violet-500/10 px-2.5 py-1 font-mono text-[11px] text-violet-700 dark:text-violet-300"
                                      x-text="'App\\Models\\' + tables[activeTable].model"></span>
                            </div>

                            <div class="overflow-x-auto rounded-xl border border-slate-200 dark:border-zinc-800">
                                <table class="min-w-full text-left text-sm">
                                    <thead class="bg-slate-100/80 text-xs uppercase tracking-wider text-zinc-500 dark:bg-zinc-900/80">
                                        <tr>
                                            <th class="px-3 py-2.5 font-semibold">Column</th>
                                            <th class="px-3 py-2.5 font-semibold">Type</th>
                                            <th class="px-3 py-2.5 font-semibold">Attrs</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <template x-for="(col, i) in tables[activeTable].columns" :key="i">
                                            <tr class="border-t border-slate-200/80 transition-colors hover:bg-emerald-500/5 dark:border-zinc-800/80">
                                                <td class="px-3 py-2.5 font-mono text-emerald-700 dark:text-emerald-400" x-text="col.name"></td>
                                                <td class="px-3 py-2.5 font-mono text-violet-700 dark:text-violet-300" x-text="col.type"></td>
                                                <td class="px-3 py-2.5 text-xs text-zinc-500" x-text="col.attrs || '—'"></td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="space-y-5 p-4 sm:p-6 lg:col-span-2">
                            <div>
                                <p class="mb-2 flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-zinc-500">
                                    <i data-lucide="key-round" class="h-3.5 w-3.5 text-emerald-500"></i>
                                    Indexes
                                </p>
                                <ul class="space-y-2">
                                    <template x-for="(idx, i) in tables[activeTable].indexes" :key="i">
                                        <li class="rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 font-mono text-[11px] text-zinc-700 dark:border-zinc-800 dark:bg-zinc-900/60 dark:text-zinc-300 sm:text-xs" x-text="idx"></li>
                                    </template>
                                </ul>
                            </div>
                            <div>
                                <p class="mb-2 flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-zinc-500">
                                    <i data-lucide="git-branch" class="h-3.5 w-3.5 text-violet-500"></i>
                                    Eloquent relationships
                                </p>
                                <ul class="space-y-2">
                                    <template x-for="(rel, i) in tables[activeTable].relations" :key="i">
                                        <li class="rounded-lg border border-violet-500/20 bg-violet-500/5 px-3 py-2 font-mono text-[11px] text-violet-800 dark:text-violet-300 sm:text-xs">
                                            <span class="text-emerald-600 dark:text-emerald-400">$</span>this-&gt;<span x-text="rel"></span>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                            <p class="text-xs leading-relaxed text-zinc-500 dark:text-zinc-500">
                                Designed for referential integrity, indexed lookups, and clean Laravel Eloquent mapping.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ===================== API TERMINAL ===================== --}}
        <section
            id="api-terminal"
            class="section-screen relative flex scroll-mt-24 snap-start flex-col justify-center border-t border-slate-200 dark:border-zinc-800/80"
            x-data="{
                endpoint: 'profile',
                loading: false,
                response: null,
                copiedCurl: false,
                endpoints: {
                    profile: {
                        path: 'GET /api/v1/john-bryan/profile',
                        data: {
                            status: 200,
                            message: 'OK',
                            data: {
                                developer_name: 'John Bryan',
                                role: 'Full Stack Developer',
                                primary_framework: 'Laravel',
                                database: 'MySQL',
                                location: 'Philippines',
                                open_to_work: true
                            }
                        }
                    },
                    skills: {
                        path: 'GET /api/v1/john-bryan/skills',
                        data: {
                            status: 200,
                            message: 'OK',
                            data: {
                                developer_name: 'John Bryan',
                                primary_framework: 'Laravel',
                                database: 'MySQL',
                                frontend: ['HTML5', 'CSS3', 'JavaScript', 'Tailwind CSS', 'Blade'],
                                backend: ['PHP', 'Laravel', 'Node.js', 'RESTful APIs'],
                                tools: ['Git', 'GitHub', 'Postman', 'XAMPP']
                            }
                        }
                    }
                },
                sendRequest() {
                    this.loading = true;
                    this.response = null;
                    this.$nextTick(() => window.initLucideIcons && window.initLucideIcons());
                    setTimeout(() => {
                        this.response = this.endpoints[this.endpoint].data;
                        this.loading = false;
                        this.$nextTick(() => window.initLucideIcons && window.initLucideIcons());
                    }, 900);
                },
                buildApiSnippet() {
                    const ep = this.endpoints[this.endpoint];
                    const parts = ep.path.split(' ');
                    const method = parts[0];
                    const urlPath = parts.slice(1).join(' ');
                    const payload = this.response || ep.data;
                    const json = JSON.stringify(payload, null, 2);
                    const resource = this.endpoint === 'skills' ? 'skills' : 'profile';
                    return [
                        '# John Bryan — Laravel REST API Spec (portfolio demo)',
                        '# Stack: Laravel + Eloquent + MySQL + JSON Resources',
                        '',
                        '# Route (routes/api.php)',
                        'Route::get(\'/v1/john-bryan/' + resource + '\', [DeveloperController::class, \'' + resource + '\']);',
                        '',
                        '# Controller (app/Http/Controllers/DeveloperController.php)',
                        'public function ' + resource + '(): JsonResponse',
                        '{',
                        '    return response()->json($this->' + resource + 'Payload(), 200);',
                        '}',
                        '',
                        '# Request',
                        method + ' ' + urlPath,
                        'Accept: application/json',
                        '',
                        '# cURL (relative path — same contract as Laravel api.php)',
                        'curl -X ' + method + ' \\',
                        '  $APP_URL' + urlPath + ' \\',
                        '  -H \'Accept: application/json\'',
                        '',
                        '# Laravel HTTP client',
                        'Http::acceptJson()->get(url(\'' + urlPath + '\'));',
                        '',
                        '# Sample JSON response (what Send Request returns)',
                        json,
                    ].join('\n');
                },
                async copyCurl() {
                    try {
                        await navigator.clipboard.writeText(this.buildApiSnippet());
                        this.copiedCurl = true;
                        this.$nextTick(() => window.initLucideIcons && window.initLucideIcons());
                        setTimeout(() => {
                            this.copiedCurl = false;
                            this.$nextTick(() => window.initLucideIcons && window.initLucideIcons());
                        }, 1800);
                    } catch (e) {
                        console.error('Copy failed', e);
                    }
                }
            }"
        >
            <div class="pointer-events-none absolute left-1/4 top-10 h-64 w-64 rounded-full bg-emerald-500/5 blur-3xl ambient-glow"></div>

            <div class="relative mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8" data-aos="fade-up">
                <div class="mb-6 max-w-2xl" data-aos="fade-up">
                    <span class="section-chip">✦ System Logic</span>
                    <h2 class="section-title mb-4 text-3xl font-bold tracking-tight sm:text-4xl">
                        Interactive API Terminal
                    </h2>
                    <p class="text-base text-zinc-600 dark:text-zinc-400 sm:text-lg">
                        Test a sample REST API response built with Laravel structure.
                    </p>
                </div>

                <div class="terminal-panel glass-card overflow-hidden rounded-xl shadow-2xl shadow-emerald-500/5" data-aos="fade-up" data-aos-delay="150">
                    {{-- Terminal chrome (always dark) --}}
                    <div class="flex items-center justify-between border-b border-zinc-800 bg-zinc-900/90 px-4 py-3">
                        <div class="flex items-center gap-2">
                            <span class="h-3 w-3 rounded-full bg-red-500/80"></span>
                            <span class="h-3 w-3 rounded-full bg-amber-500/80"></span>
                            <span class="h-3 w-3 rounded-full bg-emerald-500/80"></span>
                            <span class="ml-3 hidden font-mono text-xs text-zinc-500 sm:inline">api-terminal — john-bryan</span>
                        </div>
                        <span class="rounded border border-emerald-500/30 bg-emerald-500/10 px-2 py-0.5 font-mono text-[10px] text-emerald-400">HTTP/1.1</span>
                    </div>

                    {{-- Endpoint tabs --}}
                    <div class="flex flex-col gap-2 border-b border-zinc-800 bg-zinc-900/50 px-3 py-3 sm:flex-row sm:flex-wrap sm:px-4">
                        <button
                            type="button"
                            class="w-full break-all rounded-lg border px-3 py-2 text-left font-mono text-[11px] transition sm:w-auto sm:break-normal sm:text-xs md:text-sm"
                            :class="endpoint === 'profile' ? 'border-emerald-500/50 bg-emerald-500/15 text-emerald-300' : 'border-zinc-700 bg-zinc-900 text-zinc-400 hover:border-zinc-500 hover:text-zinc-200'"
                            @click="endpoint = 'profile'; response = null"
                        >
                            GET /api/v1/john-bryan/profile
                        </button>
                        <button
                            type="button"
                            class="w-full break-all rounded-lg border px-3 py-2 text-left font-mono text-[11px] transition sm:w-auto sm:break-normal sm:text-xs md:text-sm"
                            :class="endpoint === 'skills' ? 'border-violet-500/50 bg-violet-500/15 text-violet-300' : 'border-zinc-700 bg-zinc-900 text-zinc-400 hover:border-zinc-500 hover:text-zinc-200'"
                            @click="endpoint = 'skills'; response = null"
                        >
                            GET /api/v1/john-bryan/skills
                        </button>
                    </div>

                    {{-- Request bar --}}
                    <div class="flex flex-col gap-3 border-b border-zinc-800 px-3 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-4">
                        <p class="break-all font-mono text-xs text-zinc-300 sm:text-sm">
                            <span class="text-emerald-400" x-text="endpoints[endpoint].path.split(' ')[0]"></span>
                            <span class="text-zinc-400" x-text="endpoints[endpoint].path.split(' ').slice(1).join(' ')"></span>
                        </p>
                        <div class="flex w-full flex-col gap-2 sm:w-auto sm:flex-row sm:items-center">
                            <button
                                type="button"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-zinc-700 bg-zinc-900/80 px-4 py-2.5 text-sm font-semibold text-zinc-300 transition-all duration-300 hover:border-emerald-500/50 hover:text-emerald-300 sm:w-auto"
                                @click="copyCurl()"
                                :class="copiedCurl && 'border-emerald-500/50 text-emerald-300'"
                            >
                                <svg x-show="!copiedCurl" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/></svg>
                                <svg x-show="copiedCurl" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                                <span x-text="copiedCurl ? 'Copied!' : 'Copy API Spec'"></span>
                            </button>
                            <button
                                type="button"
                                class="glow-emerald inline-flex w-full items-center justify-center gap-2 rounded-lg bg-emerald-500 px-5 py-2.5 text-sm font-semibold text-zinc-950 transition hover:bg-emerald-400 disabled:cursor-not-allowed disabled:opacity-60 sm:w-auto"
                                @click="sendRequest()"
                                :disabled="loading"
                            >
                                <svg x-show="!loading" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
                                <svg x-show="loading" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>
                                <span x-text="loading ? 'Sending...' : 'Send Request'"></span>
                            </button>
                        </div>
                    </div>

                    {{-- Response pane (always dark) --}}
                    <div class="min-h-[200px] bg-zinc-950 px-3 py-5 font-mono text-xs text-zinc-300 sm:min-h-[220px] sm:px-6 sm:text-sm">
                        <div x-show="!loading && !response" class="text-zinc-600">
                            <p>// Ready. Select an endpoint and click <span class="text-emerald-500/70">Send Request</span>.</p>
                        </div>

                        <div x-show="loading" x-cloak class="flex items-center gap-3 text-zinc-400">
                            <i data-lucide="loader-circle" class="h-5 w-5 animate-spin text-emerald-400"></i>
                            <span>Fetching Laravel JSON response...</span>
                        </div>

                        <div x-show="!loading && response" x-cloak>
                            <p class="mb-3 text-xs text-zinc-500">
                                Response
                                <span class="ml-2 rounded bg-emerald-500/15 px-1.5 py-0.5 text-emerald-400" x-text="response ? (response.status + ' ' + response.message) : ''"></span>
                            </p>
                            <pre class="max-w-full overflow-x-auto whitespace-pre-wrap break-words text-emerald-400/90 leading-relaxed" x-text="response ? JSON.stringify(response, null, 2) : ''"></pre>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ===================== CASE STUDY ===================== --}}
        <section id="case-study" class="section-screen relative flex scroll-mt-24 snap-start flex-col justify-center border-t border-slate-200 dark:border-zinc-800/80" data-aos="fade-up">
            <div class="pointer-events-none absolute right-1/4 top-10 h-64 w-64 rounded-full bg-emerald-500/5 blur-3xl ambient-glow"></div>

            <div class="relative mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="mb-6 max-w-2xl" data-aos="fade-up">
                    <span class="section-chip">✦ Case Study</span>
                    <h2 class="section-title mb-4 text-3xl font-bold tracking-tight sm:text-4xl">
                        OrderOps API — Laravel + MySQL
                    </h2>
                    <p class="text-base text-zinc-600 dark:text-zinc-400 sm:text-lg">
                        A compact architecture study of how I design relational schemas, Eloquent maps, and JSON API contracts for an order system.
                    </p>
                </div>

                <div class="grid gap-6 lg:grid-cols-5" data-aos="fade-up" data-aos-delay="100">
                    <article class="glass-card rounded-2xl p-6 lg:col-span-3">
                        <h3 class="mb-3 text-lg font-semibold text-zinc-900 dark:text-zinc-100">Problem → Approach</h3>
                        <p class="mb-5 text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">
                            Support users placing multi-product orders with referential integrity, fast status lookups, and a clean Laravel API surface for a future SPA or mobile client.
                        </p>

                        <div class="mb-5 grid gap-3 sm:grid-cols-3">
                            <div class="rounded-xl border border-slate-200 bg-slate-50/80 p-3 dark:border-zinc-800 dark:bg-zinc-950/50">
                                <p class="text-[11px] font-semibold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">Stack</p>
                                <p class="mt-1 text-sm text-zinc-700 dark:text-zinc-300">Laravel · MySQL · Eloquent · JSON</p>
                            </div>
                            <div class="rounded-xl border border-slate-200 bg-slate-50/80 p-3 dark:border-zinc-800 dark:bg-zinc-950/50">
                                <p class="text-[11px] font-semibold uppercase tracking-wider text-violet-600 dark:text-violet-400">Pattern</p>
                                <p class="mt-1 text-sm text-zinc-700 dark:text-zinc-300">MVC · API Resources · Migrations</p>
                            </div>
                            <div class="rounded-xl border border-slate-200 bg-slate-50/80 p-3 dark:border-zinc-800 dark:bg-zinc-950/50">
                                <p class="text-[11px] font-semibold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">Focus</p>
                                <p class="mt-1 text-sm text-zinc-700 dark:text-zinc-300">Indexes · FKs · Clear contracts</p>
                            </div>
                        </div>

                        <h4 class="mb-2 text-sm font-semibold text-zinc-900 dark:text-zinc-100">Migration highlights</h4>
                        <pre class="overflow-x-auto rounded-xl border border-zinc-800 bg-zinc-950 p-4 font-mono text-[11px] leading-relaxed text-zinc-300 sm:text-xs"><code><span class="text-zinc-500">// create_orders_table</span>
$table-&gt;<span class="text-violet-300">id</span>();
$table-&gt;<span class="text-violet-300">foreignId</span>(<span class="text-emerald-400">'user_id'</span>)-&gt;constrained()-&gt;cascadeOnDelete();
$table-&gt;<span class="text-violet-300">string</span>(<span class="text-emerald-400">'status'</span>)-&gt;index();
$table-&gt;<span class="text-violet-300">decimal</span>(<span class="text-emerald-400">'total'</span>, 10, 2);
$table-&gt;<span class="text-violet-300">timestamp</span>(<span class="text-emerald-400">'placed_at'</span>)-&gt;nullable()-&gt;index();
$table-&gt;<span class="text-violet-300">timestamps</span>();

<span class="text-zinc-500">// order_product pivot</span>
$table-&gt;<span class="text-violet-300">foreignId</span>(<span class="text-emerald-400">'order_id'</span>)-&gt;constrained();
$table-&gt;<span class="text-violet-300">foreignId</span>(<span class="text-emerald-400">'product_id'</span>)-&gt;constrained();
$table-&gt;<span class="text-violet-300">unsignedInteger</span>(<span class="text-emerald-400">'qty'</span>);</code></pre>
                    </article>

                    <aside class="glass-card flex flex-col rounded-2xl p-6 lg:col-span-2">
                        <h3 class="mb-4 text-lg font-semibold text-zinc-900 dark:text-zinc-100">Relationship map</h3>
                        <div class="mb-5 space-y-3 font-mono text-xs text-zinc-600 dark:text-zinc-300">
                            <div class="rounded-lg border border-emerald-500/25 bg-emerald-500/5 px-3 py-2">User <span class="text-emerald-500">hasMany</span> Order</div>
                            <div class="rounded-lg border border-violet-500/25 bg-violet-500/5 px-3 py-2">Order <span class="text-violet-400">belongsToMany</span> Product</div>
                            <div class="rounded-lg border border-emerald-500/25 bg-emerald-500/5 px-3 py-2">Product <span class="text-emerald-500">belongsTo</span> User <span class="text-zinc-500">(seller)</span></div>
                        </div>

                        <h4 class="mb-2 text-sm font-semibold text-zinc-900 dark:text-zinc-100">API surface</h4>
                        <ul class="mb-5 space-y-2 text-sm text-zinc-600 dark:text-zinc-400">
                            <li class="flex gap-2"><span class="text-emerald-500">→</span> <span class="font-mono text-xs sm:text-sm">GET /api/v1/orders</span></li>
                            <li class="flex gap-2"><span class="text-emerald-500">→</span> <span class="font-mono text-xs sm:text-sm">POST /api/v1/orders</span></li>
                            <li class="flex gap-2"><span class="text-emerald-500">→</span> <span class="font-mono text-xs sm:text-sm">GET /api/v1/products?sku=</span></li>
                        </ul>

                        <p class="mt-auto text-xs leading-relaxed text-zinc-500">
                            Explore the interactive <a href="#schema" class="font-medium text-emerald-600 hover:underline dark:text-emerald-400">schema visualizer</a> and
                            <a href="#api-terminal" class="font-medium text-violet-600 hover:underline dark:text-violet-400">API terminal</a> for the same mental model.
                        </p>
                    </aside>
                </div>
            </div>
        </section>

        {{-- ===================== JOURNEY TIMELINE ===================== --}}
        <section id="journey" class="section-screen relative flex scroll-mt-24 snap-start flex-col justify-center border-t border-slate-200 dark:border-zinc-800/80" data-aos="fade-up">
            <div class="pointer-events-none absolute left-1/3 top-16 h-56 w-56 rounded-full bg-violet-500/5 blur-3xl ambient-glow-delay"></div>

            <div class="relative mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="mb-6 max-w-2xl" data-aos="fade-up">
                    <span class="section-chip">✦ Work History</span>
                    <h2 class="section-title mb-4 text-3xl font-bold tracking-tight sm:text-4xl">
                        My Journey as a Developer
                    </h2>
                    <p class="text-base text-zinc-600 dark:text-zinc-400 sm:text-lg">
                        Highlights that shape how I build software — from backend craft to continuous growth.
                    </p>
                </div>

                <div class="relative mx-auto max-w-3xl">
                    {{-- Vertical line centered on the 32px (w-8) rail --}}
                    <div class="absolute bottom-3 left-4 top-3 w-0.5 -translate-x-1/2 timeline-line opacity-70"></div>

                    <ol class="relative space-y-8">
                        @foreach ($journeyItems as $index => $item)
                            <li
                                class="relative flex items-start gap-5 sm:gap-6"
                                data-aos="fade-up"
                                data-aos-delay="{{ ($index + 1) * 100 }}"
                            >
                                {{-- Fixed-width rail so the line always hits the dot center --}}
                                <div class="relative z-10 flex w-8 shrink-0 justify-center pt-1.5">
                                    <span class="relative flex h-4 w-4 items-center justify-center">
                                        <span class="absolute inset-0 animate-ping rounded-full bg-emerald-400/35"></span>
                                        <span class="relative block h-3.5 w-3.5 rounded-full border-2 border-emerald-400 bg-zinc-50 dark:bg-zinc-950 shadow-[0_0_14px_rgba(52,211,153,0.7)]"></span>
                                    </span>
                                </div>
                                <button
                                    type="button"
                                    class="interactive-card glass-card group min-w-0 flex-1 rounded-xl p-5 text-left sm:p-6"
                                    @click='openJourney(@json($item))'
                                >
                                    <div class="mb-2 flex items-start justify-between gap-3">
                                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">{{ $item['title'] }}</h3>
                                        <span class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg border border-slate-300 text-emerald-600 transition-all duration-300 group-hover:border-emerald-500/50 group-hover:bg-emerald-500/10 dark:border-zinc-700 dark:text-emerald-400">
                                            <i data-lucide="maximize-2" class="h-4 w-4"></i>
                                        </span>
                                    </div>
                                    <p class="text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">{{ $item['desc'] }}</p>
                                    <p class="mt-3 text-xs font-medium text-violet-600 dark:text-violet-400">Click for technical breakdown →</p>
                                </button>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </section>

        {{-- ===================== SERVICES ===================== --}}
        <section id="services" class="section-screen relative flex scroll-mt-24 snap-start flex-col justify-center border-t border-slate-200 dark:border-zinc-800/80" data-aos="fade-up">
            <div class="pointer-events-none absolute right-10 top-20 h-64 w-64 rounded-full bg-emerald-500/5 blur-3xl ambient-glow"></div>

            <div class="relative mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="mb-6 max-w-2xl" data-aos="fade-up">
                    <span class="section-chip">✦ Capabilities</span>
                    <h2 class="section-title mb-4 text-3xl font-bold tracking-tight sm:text-4xl">
                        Services & Capabilities
                    </h2>
                    <p class="text-base text-zinc-600 dark:text-zinc-400 sm:text-lg">
                        Tailored full-stack solutions built for performance and scalability.
                    </p>
                </div>

                <div class="grid gap-4 lg:grid-cols-3">
                    @foreach ($serviceCards as $index => $card)
                        <article
                            class="interactive-card glass-card group rounded-xl p-6"
                            data-aos="fade-up"
                            data-aos-delay="{{ ($index + 1) * 100 }}"
                        >
                            <div class="pointer-events-none absolute -right-10 -top-10 h-32 w-32 rounded-full bg-gradient-to-br from-emerald-500/10 to-violet-500/10 blur-2xl transition duration-300 group-hover:from-emerald-500/20 group-hover:to-violet-500/20"></div>
                            <div class="relative z-[1]">
                                <div class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500/20 to-violet-500/20 text-emerald-600 dark:text-emerald-400 transition-all duration-300 group-hover:text-violet-300">
                                    <i data-lucide="{{ $card['icon'] }}" class="h-6 w-6"></i>
                                </div>
                                <h3 class="mb-3 text-lg font-semibold text-zinc-900 dark:text-zinc-100">{{ $card['title'] }}</h3>
                                <p class="text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">{{ $card['desc'] }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ===================== CODE ACTIVITY ===================== --}}
        <section id="activity" class="section-screen relative flex scroll-mt-24 snap-start flex-col justify-center border-t border-slate-200 dark:border-zinc-800/80" data-aos="fade-up">
            <div class="pointer-events-none absolute right-1/4 top-16 h-64 w-64 rounded-full bg-violet-500/5 blur-3xl ambient-glow-delay"></div>

            <div class="relative mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="mb-6 max-w-2xl" data-aos="fade-up">
                    <span class="section-chip">✦ Code Pulse</span>
                    <h2 class="section-title mb-4 text-3xl font-bold tracking-tight sm:text-4xl">
                        Code Activity & Commitment
                    </h2>
                    <p class="text-base text-zinc-600 dark:text-zinc-400 sm:text-lg">
                        Consistent growth and continuous shipping.
                    </p>
                </div>

                <div class="grid gap-4 lg:grid-cols-3">
                    {{-- Card 1: Primary Stack --}}
                    <article class="interactive-card glass-card rounded-xl p-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="mb-5 flex items-center gap-3">
                            <div class="inline-flex h-11 w-11 items-center justify-center rounded-lg bg-gradient-to-br from-emerald-500/20 to-violet-500/20 text-emerald-600 dark:text-emerald-400">
                                <i data-lucide="bar-chart-3" class="h-5 w-5"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Primary Stack</h3>
                        </div>
                        <p class="mb-5 text-sm text-zinc-600 dark:text-zinc-400">PHP / Laravel / JavaScript / MySQL</p>
                        <div class="space-y-4">
                            @foreach ($stackBars as $bar)
                                <div>
                                    <div class="mb-1.5 flex items-center justify-between text-xs">
                                        <span class="font-medium text-zinc-700 dark:text-zinc-300">{{ $bar['label'] }}</span>
                                        <span class="text-emerald-600 dark:text-emerald-400">{{ $bar['percent'] }}%</span>
                                    </div>
                                    <div class="h-2 overflow-hidden rounded-full bg-slate-100 dark:bg-zinc-800">
                                        <div
                                            class="h-full rounded-full bg-gradient-to-r from-emerald-500 to-violet-500"
                                            style="width: {{ $bar['percent'] }}%"
                                        ></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </article>

                    {{-- Card 2: Code Quality --}}
                    <article class="interactive-card glass-card rounded-xl p-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="mb-5 flex items-center gap-3">
                            <div class="inline-flex h-11 w-11 items-center justify-center rounded-lg bg-gradient-to-br from-emerald-500/20 to-violet-500/20 text-violet-600 dark:text-violet-400">
                                <i data-lucide="shield-check" class="h-5 w-5"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Code Quality</h3>
                        </div>
                        <ul class="space-y-3">
                            <li class="flex items-start gap-2.5 text-sm text-zinc-700 dark:text-zinc-300">
                                <i data-lucide="check" class="mt-0.5 h-4 w-4 shrink-0 text-emerald-600 dark:text-emerald-400"></i>
                                Clean MVC Architecture
                            </li>
                            <li class="flex items-start gap-2.5 text-sm text-zinc-700 dark:text-zinc-300">
                                <i data-lucide="check" class="mt-0.5 h-4 w-4 shrink-0 text-emerald-600 dark:text-emerald-400"></i>
                                Structured REST APIs
                            </li>
                            <li class="flex items-start gap-2.5 text-sm text-zinc-700 dark:text-zinc-300">
                                <i data-lucide="check" class="mt-0.5 h-4 w-4 shrink-0 text-emerald-600 dark:text-emerald-400"></i>
                                Version Control (Git / GitHub)
                            </li>
                            <li class="flex items-start gap-2.5 text-sm text-zinc-700 dark:text-zinc-300">
                                <i data-lucide="check" class="mt-0.5 h-4 w-4 shrink-0 text-emerald-600 dark:text-emerald-400"></i>
                                Maintainable, documented code
                            </li>
                        </ul>
                    </article>

                    {{-- Card 3: Availability --}}
                    <article class="interactive-card glass-card rounded-xl p-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="mb-5 flex items-center gap-3">
                            <div class="inline-flex h-11 w-11 items-center justify-center rounded-lg bg-gradient-to-br from-emerald-500/20 to-violet-500/20 text-emerald-600 dark:text-emerald-400">
                                <i data-lucide="briefcase" class="h-5 w-5"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Availability</h3>
                        </div>
                        <div class="mb-4 inline-flex items-center gap-2 rounded-full border border-emerald-500/30 bg-emerald-500/10 px-3 py-1 text-xs font-medium text-emerald-700 dark:text-emerald-300">
                            <span class="relative flex h-2 w-2">
                                <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-60"></span>
                                <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-500"></span>
                            </span>
                            Open for opportunities
                        </div>
                        <p class="text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">
                            Ready for Full-Time Backend/Full Stack Roles &amp; Selected Freelance Projects.
                        </p>
                        <a href="#contact"
                           class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-violet-700 dark:text-violet-300 transition-all duration-300 hover:gap-3 hover:text-violet-800 dark:hover:text-violet-200">
                            Let's talk
                            <i data-lucide="arrow-right" class="h-4 w-4"></i>
                        </a>
                    </article>
                </div>
            </div>
        </section>

        {{-- ===================== FAQ ===================== --}}
        <section id="faq" class="section-screen relative flex scroll-mt-24 snap-start flex-col justify-center border-t border-slate-200 dark:border-zinc-800/80" x-data="{ openFaq: 0 }" data-aos="fade-up">
            <div class="pointer-events-none absolute left-10 top-24 h-56 w-56 rounded-full bg-violet-500/5 blur-3xl ambient-glow"></div>

            <div class="relative mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="mb-6 max-w-2xl" data-aos="fade-up">
                    <span class="section-chip">✦ FAQ</span>
                    <h2 class="section-title mb-4 text-3xl font-bold tracking-tight sm:text-4xl">
                        Frequently Asked Questions
                    </h2>
                    <p class="text-base text-zinc-600 dark:text-zinc-400 sm:text-lg">
                        Quick answers to common questions about working with me.
                    </p>
                </div>

                <div class="mx-auto max-w-3xl space-y-3">
                    @foreach ($faqItems as $index => $faq)
                        <div
                            class="glass-card overflow-hidden rounded-xl transition-all duration-300 ease-in-out"
                            data-aos="fade-up"
                            data-aos-delay="{{ ($index + 1) * 100 }}"
                        >
                            <button
                                type="button"
                                class="flex w-full items-start justify-between gap-3 px-4 py-4 text-left transition-all duration-300 ease-in-out hover:bg-emerald-500/5 sm:items-center sm:gap-4 sm:px-6"
                                @click="openFaq = openFaq === {{ $index }} ? null : {{ $index }}; $nextTick(() => window.initLucideIcons && window.initLucideIcons())"
                                :aria-expanded="(openFaq === {{ $index }}).toString()"
                            >
                                <span class="pr-2 text-sm font-semibold leading-snug text-zinc-900 dark:text-zinc-100 sm:text-base">{{ $faq['question'] }}</span>
                                <span
                                    class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg border border-slate-300 dark:border-zinc-700 bg-slate-100 dark:bg-zinc-800/60 text-emerald-600 dark:text-emerald-400 transition-all duration-300 ease-in-out"
                                    :class="openFaq === {{ $index }} ? 'border-emerald-500/40 rotate-180' : ''"
                                >
                                    <i data-lucide="chevron-down" class="h-4 w-4"></i>
                                </span>
                            </button>
                            <div
                                class="faq-panel"
                                :class="openFaq === {{ $index }} ? 'is-open' : ''"
                            >
                                <div>
                                    <div class="border-t border-slate-200 dark:border-zinc-800/80 px-5 pb-5 pt-3 sm:px-6">
                                        <p class="text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">{{ $faq['answer'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ===================== CONTACT ===================== --}}
        <section id="contact" class="section-screen relative flex scroll-mt-24 snap-start flex-col justify-center border-t border-slate-200 dark:border-zinc-800/80" data-aos="fade-up">
            <div class="pointer-events-none absolute left-1/2 top-0 h-72 w-72 -translate-x-1/2 rounded-full bg-emerald-500/5 blur-3xl ambient-glow"></div>

            <div class="relative mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="mb-6 max-w-2xl" data-aos="fade-up">
                    <span class="section-chip">✦ Get In Touch</span>
                    <h2 class="section-title mb-4 text-3xl font-bold tracking-tight sm:text-4xl">
                        Let's Connect
                    </h2>
                    <p class="text-base text-zinc-600 dark:text-zinc-400 sm:text-lg">
                        Have a project in mind or want to collaborate? Drop me a message — I'd love to hear from you.
                    </p>
                </div>

                <div class="grid gap-10 lg:grid-cols-5">
                    {{-- Contact info & socials --}}
                    <div class="space-y-6 lg:col-span-2">
                        <div class="glass-card rounded-xl p-6">
                            <h3 class="mb-4 text-lg font-semibold text-zinc-900 dark:text-zinc-100">Contact Info</h3>

                            <div class="mb-4">
                                <p class="mb-1.5 text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-500">Email</p>
                                <div class="flex flex-wrap items-center gap-2">
                                    <a href="mailto:{{ $portfolioEmail }}"
                                       class="inline-flex max-w-full items-center gap-2 break-all text-sm font-medium text-emerald-600 dark:text-emerald-400 transition-all duration-300 hover:text-emerald-700 dark:hover:text-emerald-300">
                                        <i data-lucide="mail" class="h-4 w-4 shrink-0"></i>
                                        {{ $portfolioEmail }}
                                    </a>
                                    <button
                                        type="button"
                                        class="inline-flex items-center gap-1 rounded-md border border-slate-300 dark:border-zinc-700 px-2 py-1 text-xs text-zinc-600 dark:text-zinc-400 transition-all duration-300 hover:border-emerald-500/50 hover:text-emerald-600 dark:hover:text-emerald-400"
                                        @click="copyEmail()"
                                        :class="copied && 'border-emerald-500/50 text-emerald-400'"
                                    >
                                        <i data-lucide="copy" class="h-3 w-3" x-show="!copied"></i>
                                        <i data-lucide="check" class="h-3 w-3 text-emerald-600 dark:text-emerald-400" x-show="copied" x-cloak></i>
                                        <span x-text="copied ? 'Copied!' : 'Copy'"></span>
                                    </button>
                                </div>
                            </div>

                            <div>
                                <p class="mb-3 text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-500">Social</p>
                                <div class="flex gap-3">
                                    @if ($portfolioGithub)
                                        <a href="{{ $portfolioGithub }}" target="_blank" rel="noopener noreferrer"
                                           class="social-glow inline-flex h-10 w-10 items-center justify-center rounded-lg border border-slate-300 dark:border-zinc-700 bg-slate-100 dark:bg-zinc-800/60 text-zinc-700 dark:text-zinc-300"
                                           aria-label="GitHub">
                                            <i data-lucide="github" class="h-5 w-5"></i>
                                        </a>
                                    @endif
                                    @if ($portfolioLinkedin)
                                        <a href="{{ $portfolioLinkedin }}" target="_blank" rel="noopener noreferrer"
                                           class="social-glow inline-flex h-10 w-10 items-center justify-center rounded-lg border border-slate-300 dark:border-zinc-700 bg-slate-100 dark:bg-zinc-800/60 text-zinc-700 dark:text-zinc-300"
                                           aria-label="LinkedIn">
                                            <i data-lucide="linkedin" class="h-5 w-5"></i>
                                        </a>
                                    @endif
                                    <a href="mailto:{{ $portfolioEmail }}"
                                       class="social-glow inline-flex h-10 w-10 items-center justify-center rounded-lg border border-slate-300 dark:border-zinc-700 bg-slate-100 dark:bg-zinc-800/60 text-zinc-700 dark:text-zinc-300"
                                       aria-label="Email">
                                        <i data-lucide="mail" class="h-5 w-5"></i>
                                    </a>
                                    <a href="{{ $portfolioResume }}"
                                       download="John-Bryan-Bolarde-Resume.pdf"
                                       class="social-glow inline-flex h-10 w-10 items-center justify-center rounded-lg border border-slate-300 dark:border-zinc-700 bg-slate-100 dark:bg-zinc-800/60 text-zinc-700 dark:text-zinc-300"
                                       aria-label="Download resume">
                                        <i data-lucide="file-down" class="h-5 w-5"></i>
                                    </a>
                                </div>
                                @unless ($portfolioGithub)
                                    <p class="mt-3 text-[11px] text-zinc-500">Set <code class="text-emerald-600 dark:text-emerald-400">PORTFOLIO_GITHUB</code> in <code>.env</code> to show your GitHub.</p>
                                @endunless
                            </div>
                        </div>
                    </div>

                    {{-- Contact form --}}
                    <div class="lg:col-span-3">
                        <form
                            id="contact-form"
                            action="{{ route('contact.store') }}"
                            method="POST"
                            class="glass-card rounded-xl p-6 sm:p-8"
                            @submit="handleContactSubmit($event)"
                        >
                            @csrf
                            {{-- Honeypot --}}
                            <input type="text" name="website" value="" tabindex="-1" autocomplete="off" class="hidden" aria-hidden="true">
                            <div class="grid gap-5 sm:grid-cols-2">
                                <div>
                                    <label for="name" class="mb-1.5 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Name</label>
                                    <input
                                        type="text"
                                        id="name"
                                        name="name"
                                        required
                                        placeholder="Your name"
                                        class="w-full rounded-lg border border-slate-300 dark:border-zinc-700 bg-slate-100 dark:bg-zinc-950/60 px-3.5 py-2.5 text-sm text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 dark:placeholder-zinc-500 outline-none transition focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500"
                                    >
                                </div>
                                <div>
                                    <label for="email" class="mb-1.5 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Email</label>
                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        required
                                        placeholder="you@example.com"
                                        class="w-full rounded-lg border border-slate-300 dark:border-zinc-700 bg-slate-100 dark:bg-zinc-950/60 px-3.5 py-2.5 text-sm text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 dark:placeholder-zinc-500 outline-none transition focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500"
                                    >
                                </div>
                            </div>

                            <div class="mt-5">
                                <label for="subject" class="mb-1.5 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Subject</label>
                                <input
                                    type="text"
                                    id="subject"
                                    name="subject"
                                    required
                                    placeholder="What's this about?"
                                    class="w-full rounded-lg border border-slate-300 dark:border-zinc-700 bg-slate-100 dark:bg-zinc-950/60 px-3.5 py-2.5 text-sm text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 dark:placeholder-zinc-500 outline-none transition focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500"
                                >
                            </div>

                            <div class="mt-5">
                                <label for="message" class="mb-1.5 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Message</label>
                                <textarea
                                    id="message"
                                    name="message"
                                    rows="5"
                                    required
                                    placeholder="Tell me about your project or idea..."
                                    class="w-full resize-y rounded-lg border border-slate-300 dark:border-zinc-700 bg-slate-100 dark:bg-zinc-950/60 px-3.5 py-2.5 text-sm text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 dark:placeholder-zinc-500 outline-none transition focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500"
                                ></textarea>
                            </div>

                            <div class="mt-6">
                                <button
                                    type="submit"
                                    class="glow-emerald inline-flex w-full items-center justify-center gap-2 rounded-lg bg-gradient-to-r from-emerald-500 to-violet-500 px-6 py-3 text-sm font-semibold text-zinc-950 transition-all duration-300 ease-in-out hover:from-emerald-400 hover:to-violet-400 hover:shadow-[0_0_28px_rgba(16,185,129,0.4)] disabled:cursor-not-allowed disabled:opacity-60 sm:w-auto"
                                    :disabled="contactSending"
                                >
                                    <i x-show="!contactSending" data-lucide="send" class="h-4 w-4"></i>
                                    <i x-show="contactSending" x-cloak data-lucide="loader-circle" class="h-4 w-4 animate-spin"></i>
                                    <span x-text="contactSending ? 'Sending...' : 'Send Message'"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    {{-- ===================== JOURNEY DETAILS MODAL ===================== --}}
    <div
        x-show="journeyOpen"
        x-cloak
        class="fixed inset-0 z-[90] flex items-end justify-center p-3 sm:items-center sm:p-6"
        role="dialog"
        aria-modal="true"
        aria-labelledby="journey-modal-title"
    >
        <div
            class="absolute inset-0 bg-black/65 backdrop-blur-sm"
            x-show="journeyOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="closeJourney()"
        ></div>

        <div
            class="relative z-10 flex max-h-[90vh] w-full max-w-2xl flex-col overflow-hidden rounded-2xl border border-zinc-700/60 bg-white/90 shadow-2xl shadow-violet-500/10 backdrop-blur-xl dark:border-zinc-700/70 dark:bg-zinc-900/90"
            x-show="journeyOpen && journeyItem"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 scale-95"
            @click.stop
        >
            <div class="flex items-start justify-between gap-3 border-b border-slate-200/80 px-5 py-4 dark:border-zinc-800/80 sm:px-6">
                <div>
                    <p class="mb-1 text-[11px] font-semibold uppercase tracking-[0.14em] text-violet-600 dark:text-violet-400">Journey Milestone</p>
                    <h3 id="journey-modal-title" class="text-lg font-bold text-zinc-900 dark:text-zinc-100 sm:text-xl" x-text="journeyItem ? journeyItem.title : ''"></h3>
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400" x-text="journeyItem ? journeyItem.desc : ''"></p>
                </div>
                <button
                    type="button"
                    class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-slate-300 text-zinc-500 transition hover:border-violet-500/40 hover:text-violet-600 dark:border-zinc-700 dark:text-zinc-400 dark:hover:text-violet-400"
                    @click="closeJourney()"
                    aria-label="Close journey details"
                >
                    <i data-lucide="x" class="h-4 w-4"></i>
                </button>
            </div>

            <div class="space-y-6 overflow-y-auto px-5 py-5 sm:px-6" x-show="journeyItem">
                <div>
                    <h4 class="mb-3 flex items-center gap-2 text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                        <i data-lucide="list-checks" class="h-4 w-4 text-emerald-500"></i>
                        Key technical responsibilities
                    </h4>
                    <ul class="space-y-2">
                        <template x-for="(item, i) in (journeyItem ? journeyItem.responsibilities : [])" :key="'r'+i">
                            <li class="flex gap-2 text-sm text-zinc-600 dark:text-zinc-400">
                                <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-emerald-500"></span>
                                <span x-text="item"></span>
                            </li>
                        </template>
                    </ul>
                </div>

                <div>
                    <h4 class="mb-3 flex items-center gap-2 text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                        <i data-lucide="wrench" class="h-4 w-4 text-violet-500"></i>
                        Tools used
                    </h4>
                    <div class="flex flex-wrap gap-2">
                        <template x-for="(tool, i) in (journeyItem ? journeyItem.tools : [])" :key="'t'+i">
                            <span class="rounded-md border border-slate-300 bg-slate-100 px-2.5 py-1 text-xs font-medium text-zinc-700 dark:border-zinc-700 dark:bg-zinc-800/70 dark:text-zinc-300" x-text="tool"></span>
                        </template>
                    </div>
                </div>

                <div>
                    <h4 class="mb-3 flex items-center gap-2 text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                        <i data-lucide="network" class="h-4 w-4 text-emerald-500"></i>
                        Architectural highlights
                    </h4>
                    <ul class="space-y-2">
                        <template x-for="(item, i) in (journeyItem ? journeyItem.architecture : [])" :key="'a'+i">
                            <li class="rounded-lg border border-violet-500/20 bg-violet-500/5 px-3 py-2 text-sm text-zinc-700 dark:text-zinc-300" x-text="item"></li>
                        </template>
                    </ul>
                </div>
            </div>

            <div class="flex justify-end border-t border-slate-200/80 bg-slate-50/80 px-5 py-4 dark:border-zinc-800/80 dark:bg-zinc-950/50 sm:px-6">
                <button
                    type="button"
                    class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-zinc-700 transition hover:border-zinc-400 dark:border-zinc-700 dark:text-zinc-300 dark:hover:border-zinc-500"
                    @click="closeJourney()"
                >
                    Close
                </button>
            </div>
        </div>
    </div>

    {{-- ===================== RESUME PREVIEW MODAL ===================== --}}
    <div
        x-show="resumeOpen"
        x-cloak
        class="fixed inset-0 z-[90] flex items-end justify-center p-3 sm:items-center sm:p-6"
        role="dialog"
        aria-modal="true"
        aria-labelledby="resume-modal-title"
        @keydown.escape.window="if (resumeOpen) closeResume()"
    >
        <div
            class="absolute inset-0 bg-black/65 backdrop-blur-sm"
            x-show="resumeOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="closeResume()"
        ></div>

        <div
            class="relative z-10 flex max-h-[90vh] w-full max-w-2xl flex-col overflow-hidden rounded-2xl border border-zinc-700/60 bg-white/90 shadow-2xl shadow-emerald-500/10 backdrop-blur-xl dark:border-zinc-700/70 dark:bg-zinc-900/90"
            x-show="resumeOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 scale-95"
            @click.stop
        >
            <div class="flex items-start justify-between gap-3 border-b border-slate-200/80 px-5 py-4 dark:border-zinc-800/80 sm:px-6">
                <div>
                    <p class="mb-1 text-[11px] font-semibold uppercase tracking-[0.14em] text-emerald-600 dark:text-emerald-400">Resume Preview</p>
                    <h3 id="resume-modal-title" class="text-lg font-bold text-zinc-900 dark:text-zinc-100 sm:text-xl">John Bryan — Full Stack / Laravel</h3>
                    <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">Philippines · Open for opportunities · PHP · Laravel · MySQL</p>
                </div>
                <button
                    type="button"
                    class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-slate-300 text-zinc-500 transition hover:border-emerald-500/40 hover:text-emerald-600 dark:border-zinc-700 dark:text-zinc-400 dark:hover:text-emerald-400"
                    @click="closeResume()"
                    aria-label="Close preview"
                >
                    <i data-lucide="x" class="h-4 w-4"></i>
                </button>
            </div>

            <div class="overflow-y-auto px-5 py-5 sm:px-6">
                <div class="mb-5 rounded-xl border border-dashed border-emerald-500/30 bg-gradient-to-br from-emerald-500/5 via-transparent to-violet-500/5 p-4">
                    <p class="text-sm leading-relaxed text-zinc-600 dark:text-zinc-300">
                        Full Stack Developer specializing in Laravel, PHP, MySQL, and Tailwind CSS. Builds scalable web apps, clean REST APIs, and optimized relational schemas with maintainable MVC architecture.
                    </p>
                </div>

                <div class="space-y-5">
                    <div>
                        <h4 class="mb-2 flex items-center gap-2 text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                            <i data-lucide="briefcase" class="h-4 w-4 text-emerald-500"></i>
                            Experience Highlights
                        </h4>
                        <ul class="space-y-2 text-sm text-zinc-600 dark:text-zinc-400">
                            <li class="flex gap-2"><span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-emerald-500"></span>End-to-end Laravel web applications with Blade + Tailwind frontends</li>
                            <li class="flex gap-2"><span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-emerald-500"></span>RESTful API design with authentication (JWT / Sanctum)</li>
                            <li class="flex gap-2"><span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-emerald-500"></span>MySQL schema design, indexing, and query optimization</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="mb-2 flex items-center gap-2 text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                            <i data-lucide="code-2" class="h-4 w-4 text-violet-500"></i>
                            Core Stack
                        </h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach (['PHP', 'Laravel', 'MySQL', 'JavaScript', 'Tailwind CSS', 'Blade', 'Git', 'REST APIs'] as $tag)
                                <span class="rounded-md border border-slate-300 bg-slate-100 px-2.5 py-1 text-xs font-medium text-zinc-700 dark:border-zinc-700 dark:bg-zinc-800/70 dark:text-zinc-300">{{ $tag }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <h4 class="mb-2 flex items-center gap-2 text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                            <i data-lucide="mail" class="h-4 w-4 text-emerald-500"></i>
                            Contact
                        </h4>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400">bolardejohnbryan24@gmail.com</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col-reverse gap-2 border-t border-slate-200/80 bg-slate-50/80 px-5 py-4 dark:border-zinc-800/80 dark:bg-zinc-950/50 sm:flex-row sm:justify-end sm:px-6">
                <button
                    type="button"
                    class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-zinc-700 transition hover:border-zinc-400 dark:border-zinc-700 dark:text-zinc-300 dark:hover:border-zinc-500"
                    @click="closeResume()"
                >
                    <i data-lucide="x" class="h-4 w-4"></i>
                    Close Preview
                </button>
                <a
                    href="{{ $portfolioResume }}"
                    download="John-Bryan-Bolarde-Resume.pdf"
                    class="glow-emerald inline-flex items-center justify-center gap-2 rounded-lg bg-emerald-500 px-4 py-2.5 text-sm font-semibold text-zinc-950 shadow-lg shadow-emerald-500/20 transition hover:bg-emerald-400"
                >
                    <i data-lucide="download" class="h-4 w-4"></i>
                    Download PDF File
                </a>
            </div>
        </div>
    </div>

    {{-- ===================== COMMAND PALETTE ===================== --}}
    <div
        x-show="cmdOpen"
        x-cloak
        class="fixed inset-0 z-[95] flex items-start justify-center px-3 pt-[12vh] sm:px-4"
        role="dialog"
        aria-modal="true"
        aria-label="Command palette"
    >
        <div
            class="absolute inset-0 bg-black/60 backdrop-blur-sm"
            x-show="cmdOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="closeCmd()"
        ></div>

        <div
            class="relative z-10 w-full max-w-lg overflow-hidden rounded-2xl border border-zinc-700/60 bg-white/95 shadow-2xl shadow-black/30 backdrop-blur-xl dark:border-zinc-700/80 dark:bg-zinc-900/95"
            x-show="cmdOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 -translate-y-2 scale-95"
            @click.stop
            @keydown.arrow-down.prevent="moveCmd(1)"
            @keydown.arrow-up.prevent="moveCmd(-1)"
            @keydown.enter.prevent="runActiveCommand()"
        >
            <div class="flex items-center gap-3 border-b border-slate-200 px-4 py-3 dark:border-zinc-800">
                <i data-lucide="search" class="h-4 w-4 shrink-0 text-emerald-500"></i>
                <input
                    type="text"
                    x-ref="cmdInput"
                    x-model="cmdQuery"
                    @input="cmdActive = 0; $nextTick(() => window.initLucideIcons && window.initLucideIcons())"
                    placeholder="Search sections… (About, Skills, Contact)"
                    class="w-full bg-transparent text-sm text-zinc-900 outline-none placeholder:text-zinc-400 dark:text-zinc-100 dark:placeholder:text-zinc-500"
                    autocomplete="off"
                    spellcheck="false"
                >
                <kbd class="hidden rounded border border-slate-300 px-1.5 py-0.5 font-mono text-[10px] text-zinc-500 sm:inline dark:border-zinc-600">ESC</kbd>
            </div>

            <ul class="max-h-72 overflow-y-auto p-2" role="listbox">
                <template x-for="(item, index) in filteredCommands" :key="item.href">
                    <li>
                        <button
                            type="button"
                            class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-left transition-all duration-200"
                            :class="cmdActive === index
                                ? 'bg-emerald-500/15 text-emerald-800 dark:text-emerald-300'
                                : 'text-zinc-700 hover:bg-slate-100 dark:text-zinc-300 dark:hover:bg-zinc-800/80'"
                            @click="jumpTo(item.href)"
                            @mouseenter="cmdActive = index"
                            role="option"
                            :aria-selected="(cmdActive === index).toString()"
                        >
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-slate-50 dark:border-zinc-700 dark:bg-zinc-800/80">
                                <i :data-lucide="item.icon" class="h-4 w-4"></i>
                            </span>
                            <span class="min-w-0 flex-1">
                                <span class="block text-sm font-semibold" x-text="item.label"></span>
                                <span class="block truncate text-xs text-zinc-500" x-text="item.hint"></span>
                            </span>
                            <span class="font-mono text-[10px] text-zinc-400" x-text="item.href"></span>
                        </button>
                    </li>
                </template>
                <li x-show="filteredCommands.length === 0" class="px-3 py-6 text-center text-sm text-zinc-500">
                    No sections match your search.
                </li>
            </ul>

            <div class="flex items-center justify-between border-t border-slate-200 px-4 py-2.5 text-[11px] text-zinc-500 dark:border-zinc-800">
                <span>↑↓ navigate · Enter jump · Esc close</span>
                <span class="inline-flex items-center gap-1">
                    <kbd class="rounded border border-slate-300 px-1 font-mono dark:border-zinc-600">Ctrl</kbd>
                    <span>+</span>
                    <kbd class="rounded border border-slate-300 px-1 font-mono dark:border-zinc-600">K</kbd>
                </span>
            </div>
        </div>
    </div>

    {{-- ===================== FOOTER ===================== --}}
    <footer class="border-t border-slate-200 dark:border-zinc-800/80 bg-white/70 dark:bg-zinc-950/80 backdrop-blur-md py-10">
        <div class="mx-auto grid max-w-6xl gap-8 px-4 text-center sm:grid-cols-3 sm:items-center sm:text-left sm:px-6 lg:px-8">
            {{-- Left --}}
            <div class="space-y-1.5 sm:justify-self-start">
                <p class="text-sm font-semibold text-zinc-800 dark:text-zinc-200">
                    John Bryan — Full Stack / Laravel Developer
                </p>
                <p class="text-xs text-zinc-500 dark:text-zinc-500">
                    📍 Philippines · Philippine Time: <span id="ph-clock-footer">--:-- --</span>
                </p>
            </div>

            {{-- Center: social icons --}}
            <div class="flex items-center justify-center gap-3">
                @if ($portfolioGithub)
                    <a href="{{ $portfolioGithub }}" target="_blank" rel="noopener noreferrer"
                       class="social-glow inline-flex h-10 w-10 items-center justify-center rounded-full border border-slate-300 dark:border-zinc-700 bg-slate-100/80 dark:bg-zinc-900/80 text-zinc-700 dark:text-zinc-300"
                       aria-label="GitHub">
                        <i data-lucide="github" class="h-4 w-4"></i>
                    </a>
                @endif
                @if ($portfolioLinkedin)
                    <a href="{{ $portfolioLinkedin }}" target="_blank" rel="noopener noreferrer"
                       class="social-glow inline-flex h-10 w-10 items-center justify-center rounded-full border border-slate-300 dark:border-zinc-700 bg-slate-100/80 dark:bg-zinc-900/80 text-zinc-700 dark:text-zinc-300"
                       aria-label="LinkedIn">
                        <i data-lucide="linkedin" class="h-4 w-4"></i>
                    </a>
                @endif
                <a href="mailto:{{ $portfolioEmail }}"
                   class="social-glow inline-flex h-10 w-10 items-center justify-center rounded-full border border-slate-300 dark:border-zinc-700 bg-slate-100/80 dark:bg-zinc-900/80 text-zinc-700 dark:text-zinc-300"
                   aria-label="Email">
                    <i data-lucide="mail" class="h-4 w-4"></i>
                </a>
            </div>

            {{-- Right --}}
            <div class="sm:justify-self-end sm:text-right">
                <p class="text-xs leading-relaxed text-zinc-500 dark:text-zinc-500 sm:text-sm">
                    &copy; 2026 John Bryan. All rights reserved.
                </p>
                <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-500">
                    Built with
                    <span class="text-emerald-600 dark:text-emerald-400">Laravel</span>
                    &amp;
                    <span class="text-violet-600 dark:text-violet-400">Tailwind CSS</span>.
                </p>
            </div>
        </div>
    </footer>

    {{-- Back to top --}}
    <button
        type="button"
        id="back-to-top"
        class="fixed bottom-6 right-6 z-40 inline-flex h-12 w-12 items-center justify-center rounded-full border border-emerald-500/40 bg-gradient-to-br from-emerald-500 to-violet-500 text-zinc-950 shadow-lg shadow-emerald-500/20 transition hover:scale-105 hover:shadow-emerald-500/40"
        aria-label="Back to top"
        title="Back to top"
    >
        <i data-lucide="arrow-up" class="h-5 w-5"></i>
    </button>

    <script>
        window.initLucideIcons = function () {
            if (window.lucide && typeof lucide.createIcons === 'function') {
                lucide.createIcons();
            }
        };

        document.addEventListener('DOMContentLoaded', () => {
            window.initLucideIcons();

            if (window.AOS) {
                AOS.init({
                    duration: 800,
                    once: false, // Allows animations to repeat on scroll up and down
                    mirror: true, // Animates elements out when scrolling past them
                    offset: window.innerWidth < 640 ? 40 : 100,
                    easing: 'ease-out-cubic',
                    disable: false,
                });
            }

            // Scroll progress bar
            const progressBar = document.getElementById('scroll-progress');
            const backToTop = document.getElementById('back-to-top');
            const mainNav = document.getElementById('main-nav');
            const updateScrollUI = () => {
                const doc = document.documentElement;
                const scrollTop = window.scrollY || doc.scrollTop;
                const max = Math.max(doc.scrollHeight - window.innerHeight, 1);
                const pct = Math.min(100, Math.max(0, (scrollTop / max) * 100));
                if (progressBar) progressBar.style.width = pct + '%';
                if (backToTop) backToTop.classList.toggle('is-visible', scrollTop > 300);
                if (mainNav) mainNav.classList.toggle('is-scrolled', scrollTop > 24);
            };
            window.addEventListener('scroll', updateScrollUI, { passive: true });
            updateScrollUI();

            if (backToTop) {
                backToTop.addEventListener('click', () => {
                    const hero = document.getElementById('hero');
                    if (hero) hero.scrollIntoView({ behavior: 'smooth' });
                    else window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            }

            // Active nav scrollspy
            const sectionIds = [
                'hero', 'about', 'strengths', 'skills', 'schema', 'api-terminal',
                'case-study', 'journey', 'services', 'activity', 'faq', 'contact',
            ];
            const navLinks = Array.from(document.querySelectorAll('[data-nav-link]'));
            const setActiveNav = (id) => {
                navLinks.forEach((link) => {
                    const href = link.getAttribute('href') || '';
                    const match = href === '#' + id;
                    link.classList.toggle('active', match);
                });
            };
            const sectionNodes = sectionIds
                .map((id) => document.getElementById(id))
                .filter(Boolean);
            if (sectionNodes.length && 'IntersectionObserver' in window) {
                const spyObserver = new IntersectionObserver(
                    (entries) => {
                        const visible = entries
                            .filter((e) => e.isIntersecting)
                            .sort((a, b) => b.intersectionRatio - a.intersectionRatio);
                        if (visible[0] && visible[0].target.id) {
                            setActiveNav(visible[0].target.id);
                        }
                    },
                    {
                        root: null,
                        rootMargin: '-35% 0px -45% 0px',
                        threshold: [0.1, 0.25, 0.5, 0.75],
                    }
                );
                sectionNodes.forEach((section) => spyObserver.observe(section));
                setActiveNav('hero');
            }

            // Philippine live clock (Asia/Manila)
            const clockEls = [
                document.getElementById('ph-clock'),
                document.getElementById('ph-clock-footer'),
            ].filter(Boolean);
            const tickClock = () => {
                if (!clockEls.length) return;
                let formatted;
                try {
                    formatted = new Intl.DateTimeFormat('en-PH', {
                        timeZone: 'Asia/Manila',
                        hour: 'numeric',
                        minute: '2-digit',
                        hour12: true,
                    }).format(new Date());
                } catch (e) {
                    formatted = new Date().toLocaleTimeString();
                }
                clockEls.forEach((el) => { el.textContent = formatted; });
            };
            tickClock();
            setInterval(tickClock, 1000);

            // Typewriter effect for hero role title
            const roles = [
                'Full Stack Developer',
                'Laravel Specialist',
                'Backend & API Developer',
            ];
            const el = document.getElementById('typewriter-text');
            if (!el) return;

            let roleIndex = 0;
            let charIndex = roles[0].length;
            let deleting = false;
            let pauseUntil = Date.now() + 1800;

            const tick = () => {
                const now = Date.now();
                if (now < pauseUntil) {
                    requestAnimationFrame(tick);
                    return;
                }

                const current = roles[roleIndex];

                if (!deleting) {
                    charIndex += 1;
                    el.textContent = current.slice(0, charIndex);
                    if (charIndex >= current.length) {
                        deleting = true;
                        pauseUntil = now + 1800;
                    } else {
                        pauseUntil = now + 70;
                    }
                } else {
                    charIndex -= 1;
                    el.textContent = current.slice(0, charIndex);
                    if (charIndex <= 0) {
                        deleting = false;
                        roleIndex = (roleIndex + 1) % roles.length;
                        pauseUntil = now + 400;
                    } else {
                        pauseUntil = now + 40;
                    }
                }

                requestAnimationFrame(tick);
            };

            requestAnimationFrame(tick);
        });
    </script>

    <script>
        (function () {
            const root = document.documentElement;
            const toggle = document.getElementById('theme-toggle');
            const sun = document.getElementById('theme-icon-sun');
            const moon = document.getElementById('theme-icon-moon');
            const modal = document.getElementById('theme-modal');
            const modalDesc = document.getElementById('theme-modal-desc');
            const modalCancel = document.getElementById('theme-modal-cancel');
            const modalConfirm = document.getElementById('theme-modal-confirm');
            const modalBackdrop = document.getElementById('theme-modal-backdrop');
            const modalPanel = document.getElementById('theme-modal-panel');

            let pendingTheme = null;

            function currentTheme() {
                return root.classList.contains('dark') ? 'dark' : 'light';
            }

            function syncIcons() {
                const isDark = currentTheme() === 'dark';
                if (sun && moon) {
                    // Dark mode → show sun (switch to light). Light mode → show moon.
                    sun.classList.toggle('hidden', !isDark);
                    moon.classList.toggle('hidden', isDark);
                }
                if (window.initLucideIcons) window.initLucideIcons();
            }

            function setTheme(theme) {
                if (theme === 'dark') root.classList.add('dark');
                else root.classList.remove('dark');
                try { localStorage.setItem('theme', theme); } catch (e) {}
                syncIcons();
            }

            function openThemeModal() {
                if (!modal) return;
                pendingTheme = currentTheme() === 'dark' ? 'light' : 'dark';
                if (modalDesc) {
                    modalDesc.textContent = pendingTheme === 'light'
                        ? 'Are you sure you want to switch to Light Mode?'
                        : 'Are you sure you want to switch to Dark Mode?';
                }
                modal.classList.remove('pointer-events-none', 'opacity-0');
                modal.setAttribute('aria-hidden', 'false');
                if (modalPanel) {
                    modalPanel.classList.remove('scale-95');
                    modalPanel.classList.add('scale-100');
                }
                document.body.style.overflow = 'hidden';
                if (window.initLucideIcons) window.initLucideIcons();
            }

            function closeThemeModal() {
                if (!modal) return;
                pendingTheme = null;
                modal.classList.add('opacity-0', 'pointer-events-none');
                modal.setAttribute('aria-hidden', 'true');
                if (modalPanel) {
                    modalPanel.classList.add('scale-95');
                    modalPanel.classList.remove('scale-100');
                }
                document.body.style.overflow = '';
            }

            document.addEventListener('DOMContentLoaded', syncIcons);

            if (toggle) {
                toggle.addEventListener('click', () => {
                    toggle.classList.add('is-spinning');
                    setTimeout(() => toggle.classList.remove('is-spinning'), 320);
                    openThemeModal();
                });
            }

            if (modalCancel) {
                modalCancel.addEventListener('click', closeThemeModal);
            }

            if (modalBackdrop) {
                modalBackdrop.addEventListener('click', closeThemeModal);
            }

            if (modalConfirm) {
                modalConfirm.addEventListener('click', () => {
                    if (pendingTheme) setTheme(pendingTheme);
                    closeThemeModal();
                });
            }

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && modal && !modal.classList.contains('pointer-events-none')) {
                    closeThemeModal();
                }
            });
        })();
    </script>

</body>
</html>
