/* ╔══════════════════════════════════════════════════════════╗
   ║  CODE GALAXY V2 — SYSTEM SCRIPTS                       ║
   ╚══════════════════════════════════════════════════════════╝ */
(function () {
    'use strict';

    /* ═══════ 1. WEBGL PARTICLE FIELD ═══════ */
    const canvas = document.getElementById('voidCanvas');
    const ctx = canvas.getContext('2d');
    let particles = [];
    const PC = 120;
    let mouse = { x: -1000, y: -1000 };

    function resize() { canvas.width = innerWidth; canvas.height = innerHeight }
    resize(); addEventListener('resize', resize);
    document.addEventListener('mousemove', e => { mouse.x = e.clientX; mouse.y = e.clientY });

    class P {
        constructor() { this.init() }
        init() {
            this.x = Math.random() * canvas.width; this.y = Math.random() * canvas.height;
            this.sz = Math.random() * 1.2 + .3; this.vx = (Math.random() - .5) * .12; this.vy = (Math.random() - .5) * .12;
            this.bo = Math.random() * .2 + .05; this.op = this.bo; this.ph = Math.random() * Math.PI * 2;
        }
        update() {
            this.x += this.vx; this.y += this.vy; this.ph += .008;
            this.op = this.bo + Math.sin(this.ph) * .04;
            const dx = this.x - mouse.x, dy = this.y - mouse.y, d = Math.sqrt(dx * dx + dy * dy);
            if (d < 160) { const f = (160 - d) / 160; this.op = Math.min(this.bo + f * .5, .8); this.x += dx / d * f * .6; this.y += dy / d * f * .6 }
            if (this.x < 0 || this.x > canvas.width) this.vx *= -1;
            if (this.y < 0 || this.y > canvas.height) this.vy *= -1;
        }
        draw() {
            ctx.beginPath(); ctx.arc(this.x, this.y, this.sz, 0, Math.PI * 2);
            ctx.fillStyle = `rgba(0,240,255,${this.op})`; ctx.fill();
        }
    }

    for (let i = 0; i < PC; i++)particles.push(new P());

    function drawLines() {
        for (let i = 0; i < particles.length; i++) {
            for (let j = i + 1; j < particles.length; j++) {
                const dx = particles[i].x - particles[j].x, dy = particles[i].y - particles[j].y;
                const d = Math.sqrt(dx * dx + dy * dy);
                if (d < 110) {
                    ctx.beginPath(); ctx.strokeStyle = `rgba(0,240,255,${.035 * (1 - d / 110)})`;
                    ctx.lineWidth = .5; ctx.moveTo(particles[i].x, particles[i].y);
                    ctx.lineTo(particles[j].x, particles[j].y); ctx.stroke();
                }
            }
        }
    }

    function animLoop() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        particles.forEach(p => { p.update(); p.draw() }); drawLines();
        requestAnimationFrame(animLoop);
    }
    animLoop();

    /* ═══════ 2. DATA GRAPH PROXIMITY PULSE ═══════ */
    document.querySelectorAll('.shard').forEach(s => {
        s.addEventListener('mouseenter', () => {
            s.querySelectorAll('.shard__bar').forEach((b, i) => {
                setTimeout(() => { b.style.height = (Math.random() * 12 + 3) + 'px' }, i * 40);
            });
        });
    });

    /* ═══════ 3. NAVBAR SCROLL ═══════ */
    const cmdBar = document.getElementById('cmdBar');
    addEventListener('scroll', () => { cmdBar.classList.toggle('scrolled', scrollY > 30) });

    /* ═══════ 4. INTERSECTION OBSERVER ═══════ */
    const obs = new IntersectionObserver(entries => {
        entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); obs.unobserve(e.target) } });
    }, { threshold: .08, rootMargin: '0px 0px -40px 0px' });
    document.querySelectorAll('.reveal').forEach(el => obs.observe(el));

    /* ═══════ 5. SEARCH ═══════ */
    const sInput = document.getElementById('searchInput');
    const shards = document.querySelectorAll('.shard');
    const noRes = document.getElementById('noResults');
    const sectors = document.querySelectorAll('.sector');

    sInput.addEventListener('input', e => {
        const t = e.target.value.toLowerCase().trim(); let found = false;
        shards.forEach(s => {
            const m = !t || (s.dataset.title || '').toLowerCase().includes(t) || (s.dataset.desc || '').toLowerCase().includes(t) || (s.dataset.lang || '').toLowerCase().includes(t);
            s.style.display = m ? '' : 'none'; if (m) found = true;
        });
        sectors.forEach(s => { const v = s.querySelectorAll('.shard:not([style*="display: none"])'); s.style.display = v.length ? '' : 'none' });
        noRes.classList.toggle('hidden', found || !t);
    });

    /* ═══════ 6. FILTERS ═══════ */
    const fBtns = document.querySelectorAll('.fbtn');
    fBtns.forEach(b => {
        b.addEventListener('click', () => {
            fBtns.forEach(x => x.classList.remove('active')); b.classList.add('active');
            const f = b.dataset.filter; let found = false;
            sectors.forEach(s => { if (f === 'all' || s.dataset.type === f) { s.style.display = ''; found = true } else { s.style.display = 'none' } });
            noRes.classList.toggle('hidden', found); sInput.value = '';
        });
    });

    /* ═══════ 7. CLICK TO EXPAND — PARTICLE ASSEMBLY ═══════ */
    document.querySelectorAll('.shard').forEach(shard => {
        shard.addEventListener('click', function (e) {
            if (e.target.closest('.shard__copy')) return;

            const wasExpanded = this.classList.contains('expanded');

            // Collapse all others
            document.querySelectorAll('.shard.expanded').forEach(s => {
                if (s !== this) { s.classList.remove('expanded', 'assembling') }
            });

            if (wasExpanded) {
                this.classList.remove('expanded', 'assembling');
                return;
            }

            // Particle assembly effect
            const pc = this.querySelector('.shard__particles');
            if (pc) {
                pc.width = this.offsetWidth; pc.height = this.offsetHeight;
                this.classList.add('assembling');
                runAssembly(pc, () => {
                    this.classList.remove('assembling');
                    this.classList.add('expanded');
                });
            } else {
                this.classList.add('expanded');
            }
        });
    });

    function runAssembly(cvs, cb) {
        const c = cvs.getContext('2d');
        const w = cvs.width, h = cvs.height;
        const pts = []; const count = 80;
        const cx = w / 2, cy = h / 2;

        for (let i = 0; i < count; i++) {
            const angle = Math.random() * Math.PI * 2;
            const dist = Math.random() * Math.max(w, h) * .8;
            pts.push({
                x: cx + Math.cos(angle) * dist,
                y: cy + Math.sin(angle) * dist,
                tx: Math.random() * w,
                ty: h * .3 + Math.random() * h * .5,
                sz: Math.random() * 2 + .5,
                sp: Math.random() * .08 + .04
            });
        }

        let frame = 0; const maxFrames = 40;
        function draw() {
            c.clearRect(0, 0, w, h);
            let allDone = true;
            pts.forEach(p => {
                p.x += (p.tx - p.x) * p.sp; p.y += (p.ty - p.y) * p.sp;
                const dx = p.tx - p.x, dy = p.ty - p.y;
                if (Math.abs(dx) > 1 || Math.abs(dy) > 1) allDone = false;
                const alpha = Math.max(0, 1 - frame / maxFrames);
                c.beginPath(); c.arc(p.x, p.y, p.sz, 0, Math.PI * 2);
                c.fillStyle = `rgba(0,240,255,${alpha * .6})`; c.fill();
                // Trails
                c.beginPath(); c.moveTo(p.x, p.y);
                c.lineTo(p.x - (p.tx - p.x) * .3, p.y - (p.ty - p.y) * .3);
                c.strokeStyle = `rgba(0,240,255,${alpha * .15})`; c.lineWidth = .5; c.stroke();
            });
            frame++;
            if (frame < maxFrames && !allDone) { requestAnimationFrame(draw) }
            else { c.clearRect(0, 0, w, h); cb() }
        }
        draw();
    }

    /* ═══════ 8. KEYBOARD SHORTCUTS ═══════ */
    document.addEventListener('keydown', e => {
        if (e.key === '/' && document.activeElement !== sInput) { e.preventDefault(); sInput.focus() }
        if (e.key === 'Escape') {
            sInput.blur(); sInput.value = ''; sInput.dispatchEvent(new Event('input'));
            document.querySelectorAll('.shard.expanded').forEach(s => s.classList.remove('expanded', 'assembling'));
        }
    });

    /* ═══════ 9. PRISM HIGHLIGHT ═══════ */
    window.addEventListener('load', () => { if (window.Prism) Prism.highlightAll() });

})();

/* ═══════ COPY (global) ═══════ */
function copyCode(btn, b64) {
    const code = decodeURIComponent(escape(atob(b64)));
    navigator.clipboard.writeText(code).then(() => {
        const i = btn.querySelector('i'), tip = btn.querySelector('.shard__tip'), oc = i.className;
        i.className = 'fa-solid fa-check'; i.style.color = '#0f8';
        btn.style.borderColor = 'rgba(0,255,136,.3)'; btn.style.background = 'rgba(0,255,136,.06)';
        if (tip) tip.textContent = 'COPIED ✓';
        setTimeout(() => { i.className = oc; i.style.color = ''; btn.style.borderColor = ''; btn.style.background = ''; if (tip) tip.textContent = 'COPY' }, 2000);
    });
}
