// ============================================================
// Latar Abstrak Dinamis — Zakat Banua
// ------------------------------------------------------------
// Aliran melengkung partikel cahaya + jejak energi cair yang
// menghubungkan dua bentuk yang bergeser, dengan motion blur halus.
// Palet: biru bercahaya, ungu lembut, amber, sentuhan hijau zaitun.
// ============================================================

const PALETTE = [
    { rgb: '56,189,248',  a: 0.95 }, // biru bercahaya
    { rgb: '34,211,238',  a: 0.85 }, // cyan cahaya
    { rgb: '139,92,246',  a: 0.90 }, // ungu lembut
    { rgb: '167,139,250', a: 0.80 }, // lavender
    { rgb: '245,158,11',  a: 0.85 }, // amber
    { rgb: '132,204,22',  a: 0.70 }, // sentuhan hijau zaitun
];

// Kurva Bezier kubik
function bezier(p0, p1, p2, p3, t) {
    const u = 1 - t;
    const uu = u * u, tt = t * t;
    return {
        x: uu * u * p0.x + 3 * uu * t * p1.x + 3 * u * tt * p2.x + tt * t * p3.x,
        y: uu * u * p0.y + 3 * uu * t * p1.y + 3 * u * tt * p2.y + tt * t * p3.y,
    };
}

export function initAbstractBg(canvas, options = {}) {
    const opts = Object.assign({
        trailAlpha: 0.16,      // makin kecil = jejak makin panjang
        streams: 14,           // jumlah aliran energi
        perStream: 26,         // partikel per aliran
        micro: 110,            // partikel mikro latar
    }, options);

    const ctx = canvas.getContext('2d', { alpha: false });
    const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    let w = 0, h = 0, dpr = 1, running = true, rafId = null, t = 0;

    function resize() {
        dpr = Math.min(window.devicePixelRatio || 1, 2);
        const rect = canvas.getBoundingClientRect();
        w = Math.max(1, rect.width);
        h = Math.max(1, rect.height);
        canvas.width = Math.round(w * dpr);
        canvas.height = Math.round(h * dpr);
        ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
        // isi awal gelap
        ctx.fillStyle = '#0c1108';
        ctx.fillRect(0, 0, w, h);
    }

    // Dua "bentuk" yang bergeser perlahan
    const orbs = [
        { base: [0.22, 0.38], amp: 0.10, spd: 0.11, phase: 0,   r: 0.30 },
        { base: [0.78, 0.62], amp: 0.09, spd: 0.09, phase: 1.7, r: 0.34 },
    ];

    function orbPos(o, time) {
        return {
            x: (o.base[0] + Math.sin(time * o.spd + o.phase) * o.amp) * w,
            y: (o.base[1] + Math.cos(time * o.spd * 0.8 + o.phase) * o.amp) * h,
        };
    }

    // Aliran energi
    const streams = [];
    for (let i = 0; i < opts.streams; i++) {
        const p = PALETTE[i % PALETTE.length];
        streams.push({
            pal: p,
            spread: (Math.random() - 0.5) * 0.55,
            spread2: (Math.random() - 0.5) * 0.55,
            speed: 0.06 + Math.random() * 0.10,
            width: 0.7 + Math.random() * 1.6,
            particles: Array.from({ length: opts.perStream }, () => ({
                t: Math.random(),
                size: 0.5 + Math.random() * 2.1,
                tw: Math.random() * Math.PI * 2,   // fase kilau
            })),
        });
    }

    // Partikel mikro latar
    const micro = Array.from({ length: opts.micro }, () => ({
        x: Math.random(), y: Math.random(),
        vx: (Math.random() - 0.5) * 0.00016,
        vy: -0.00006 - Math.random() * 0.00020,
        size: 0.4 + Math.random() * 1.4,
        pal: PALETTE[(Math.random() * PALETTE.length) | 0],
        tw: Math.random() * Math.PI * 2,
    }));

    function drawShape(p, r, rgb, alpha) {
        const g = ctx.createRadialGradient(p.x, p.y, 0, p.x, p.y, r);
        g.addColorStop(0, `rgba(${rgb},${alpha})`);
        g.addColorStop(0.45, `rgba(${rgb},${alpha * 0.28})`);
        g.addColorStop(1, `rgba(${rgb},0)`);
        ctx.fillStyle = g;
        ctx.beginPath();
        ctx.arc(p.x, p.y, r, 0, Math.PI * 2);
        ctx.fill();
    }

    function frame() {
        if (!running) return;
        t += 0.016;

        // motion blur: lapisan gelap transparan
        ctx.globalCompositeOperation = 'source-over';
        ctx.fillStyle = `rgba(12,17,8,${opts.trailAlpha})`;
        ctx.fillRect(0, 0, w, h);

        ctx.globalCompositeOperation = 'lighter';

        // dua bentuk bercahaya yang bergeser
        const A = orbPos(orbs[0], t);
        const B = orbPos(orbs[1], t);
        drawShape(A, orbs[0].r * Math.min(w, h), '90,180,255', 0.30);
        drawShape(B, orbs[1].r * Math.min(w, h), '150,110,250', 0.26);

        // aliran energi penghubung
        const wob = t * 0.5;
        for (const s of streams) {
            const mod = s.spread;
            const mod2 = s.spread2;
            const p0 = { x: A.x + mod * w * 0.5, y: A.y + mod2 * h * 0.4 };
            const p3 = { x: B.x - mod2 * w * 0.5, y: B.y - mod * h * 0.4 };
            const p1 = { x: A.x + (0.35 + Math.sin(wob + s.spread * 6) * 0.12) * w, y: A.y + (mod * 0.7) * h };
            const p2 = { x: B.x - (0.35 + Math.cos(wob + s.spread2 * 6) * 0.12) * w, y: B.y + (mod2 * 0.7) * h };

            for (const q of s.particles) {
                q.t += s.speed * 0.01;
                if (q.t > 1) q.t -= 1;

                const pt = bezier(p0, p1, p2, p3, q.t);
                const twinkle = 0.55 + 0.45 * Math.sin(t * 2.4 + q.tw);
                const fade = Math.sin(q.t * Math.PI); // redup di ujung
                const alpha = s.pal.a * twinkle * (0.35 + fade * 0.65);

                // jejak cair
                const prev = bezier(p0, p1, p2, p3, Math.max(0, q.t - 0.035));
                ctx.strokeStyle = `rgba(${s.pal.rgb},${alpha * 0.35})`;
                ctx.lineWidth = s.width * 0.8;
                ctx.lineCap = 'round';
                ctx.beginPath();
                ctx.moveTo(prev.x, prev.y);
                ctx.lineTo(pt.x, pt.y);
                ctx.stroke();

                // inti partikel bercahaya
                const rad = q.size * (0.9 + twinkle * 0.5) * 2.2;
                const gg = ctx.createRadialGradient(pt.x, pt.y, 0, pt.x, pt.y, rad);
                gg.addColorStop(0, `rgba(255,255,255,${alpha * 0.9})`);
                gg.addColorStop(0.35, `rgba(${s.pal.rgb},${alpha})`);
                gg.addColorStop(1, `rgba(${s.pal.rgb},0)`);
                ctx.fillStyle = gg;
                ctx.beginPath();
                ctx.arc(pt.x, pt.y, rad, 0, Math.PI * 2);
                ctx.fill();
            }
        }

        // partikel mikro
        for (const m of micro) {
            m.x += m.vx; m.y += m.vy;
            if (m.y < -0.02) { m.y = 1.02; m.x = Math.random(); }
            if (m.x < -0.02) m.x = 1.02;
            if (m.x > 1.02) m.x = -0.02;
            const tw = 0.4 + 0.6 * Math.sin(t * 1.6 + m.tw);
            const px = m.x * w, py = m.y * h;
            ctx.fillStyle = `rgba(${m.pal.rgb},${0.30 * tw})`;
            ctx.beginPath();
            ctx.arc(px, py, m.size, 0, Math.PI * 2);
            ctx.fill();
        }

        rafId = requestAnimationFrame(frame);
    }

    resize();
    window.addEventListener('resize', resize);

    // hemat daya: hentikan saat tab tidak terlihat
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) { running = false; if (rafId) cancelAnimationFrame(rafId); }
        else if (!reduce) { running = true; rafId = requestAnimationFrame(frame); }
    });

    if (reduce) {
        // tampilkan satu bingkai statis
        ctx.globalCompositeOperation = 'lighter';
        const A = orbPos(orbs[0], 0), B = orbPos(orbs[1], 0);
        drawShape(A, orbs[0].r * Math.min(w, h), '90,180,255', 0.35);
        drawShape(B, orbs[1].r * Math.min(w, h), '150,110,250', 0.30);
    } else {
        rafId = requestAnimationFrame(frame);
    }

    return { stop() { running = false; if (rafId) cancelAnimationFrame(rafId); }, resize };
}

// Inisialisasi otomatis untuk setiap elemen [data-abstract-bg]
export function autoInitAbstractBg() {
    document.querySelectorAll('[data-abstract-bg]').forEach(canvas => {
        if (canvas.dataset.absInit) return;
        canvas.dataset.absInit = '1';
        initAbstractBg(canvas);
    });
}

document.addEventListener('DOMContentLoaded', autoInitAbstractBg);