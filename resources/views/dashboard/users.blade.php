@extends('layouts.dashboard')
@section('title', 'Manajemen Pengguna — Zakat Banua')
@section('page-title', 'Manajemen Pengguna')
@section('page-sub', 'Seluruh akun terdaftar dalam sistem')
@section('content')

<div class="flex flex-wrap items-center gap-2 mb-4">
    <button data-role-f="all" class="rfbtn bg-olive text-white px-4 py-2 rounded-full text-xs font-semibold">Semua</button>
    <button data-role-f="super_admin" class="rfbtn bg-white border border-cream-3 text-olive px-4 py-2 rounded-full text-xs font-semibold">Super Admin</button>
    <button data-role-f="admin_baznas" class="rfbtn bg-white border border-cream-3 text-olive px-4 py-2 rounded-full text-xs font-semibold">Admin BAZNAS</button>
    <button data-role-f="admin_upz" class="rfbtn bg-white border border-cream-3 text-olive px-4 py-2 rounded-full text-xs font-semibold">Admin UPZ</button>
    <button data-role-f="user" class="rfbtn bg-white border border-cream-3 text-olive px-4 py-2 rounded-full text-xs font-semibold">User</button>
    <span id="apiStatus" class="text-xs text-olive/50 ml-auto">Memuat…</span>
</div>

<div class="bg-white rounded-[20px] border border-cream-3 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="text-left text-xs text-olive/50 bg-cream">
                <th class="px-4 py-3">Pengguna</th><th class="px-4 py-3">Role</th><th class="px-4 py-3">Status</th><th class="px-4 py-3">Login Terakhir</th>
            </tr></thead>
            <tbody id="tblBody">
                <tr><td colspan="4" class="px-4 py-10 text-center text-olive/40">Memuat data…</td></tr>
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4 bg-cream rounded-[16px] border border-cream-3 p-4 text-xs text-olive/60">
    <i class="fa-solid fa-circle-info text-olive mr-1"></i>
    Data pengguna disediakan backend. Pada tahap ini front-end menampilkan data contoh
    (endpoint manajemen user belum ada di kontrak API).
</div>
@endsection

@section('scripts')
<script>
const rc = { super_admin: 'bg-violet-100 text-violet-700', admin_baznas: 'bg-emerald-100 text-emerald-700', admin_upz: 'bg-orange-100 text-orange-700', user: 'bg-sky-100 text-sky-700' };

// data contoh (sementara — backend belum menyediakan endpoint user)
const demoUsers = [
    { name: 'Super Admin Pemko Banjarbaru', email: 'superadmin@banjarbaru.go.id', role: 'super_admin', role_label: 'Super Admin (Pemko)', is_active: true, last_login_at: '2026-10-12T08:10:00Z' },
    { name: 'Admin BAZNAS Kota Banjarbaru', email: 'admin@baznas-banjarbaru.id', role: 'admin_baznas', role_label: 'Admin BAZNAS', is_active: true, last_login_at: '2026-10-11T14:22:00Z' },
    { name: 'Admin UPZ Masjid Al-Munawwarah', email: 'admin@upz-banjarbaru.id', role: 'admin_upz', role_label: 'Admin UPZ', is_active: true, last_login_at: '2026-10-10T09:05:00Z' },
    { name: 'Warga Banjarbaru', email: 'user@gmail.com', role: 'user', role_label: 'User', is_active: true, last_login_at: '2026-10-12T06:41:00Z' },
    { name: 'Warga 1', email: 'warga1@gmail.com', role: 'user', role_label: 'User', is_active: true, last_login_at: null },
    { name: 'Warga 2', email: 'warga2@gmail.com', role: 'user', role_label: 'User', is_active: true, last_login_at: '2026-10-09T19:30:00Z' },
    { name: 'Admin UPZ 2', email: 'upz2@banjarbaru.id', role: 'admin_upz', role_label: 'Admin UPZ', is_active: false, last_login_at: '2026-10-05T11:12:00Z' },
];

let filter = 'all';
function fmt(t) { if (!t) return 'Belum pernah'; const d = new Date(t); return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }) + ', ' + d.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }); }

function draw() {
    const body = document.getElementById('tblBody');
    const data = demoUsers.filter(u => filter === 'all' || u.role === filter);
    body.innerHTML = data.map(u =>
        '<tr class="border-t border-cream-2 hover:bg-cream-2/50">' +
        '<td class="px-4 py-3"><div class="flex items-center gap-3"><span class="w-8 h-8 rounded-full bg-cream text-olive flex items-center justify-center font-bold text-xs">' + u.name.charAt(0).toUpperCase() + '</span>' +
        '<div><div class="font-semibold">' + u.name + '</div><div class="text-[11px] text-olive/50">' + u.email + '</div></div></div></td>' +
        '<td class="px-4 py-3"><span class="text-[11px] px-2 py-1 rounded-full ' + (rc[u.role] || 'bg-gray-100') + '">' + u.role_label + '</span></td>' +
        '<td class="px-4 py-3"><span class="text-[11px] ' + (u.is_active ? 'text-emerald-600' : 'text-gray-400') + '"><i class="fa-solid fa-circle text-[7px] mr-1"></i>' + (u.is_active ? 'Aktif' : 'Nonaktif') + '</span></td>' +
        '<td class="px-4 py-3 text-xs text-olive/60">' + fmt(u.last_login_at) + '</td>' +
        '</tr>').join('') || '<tr><td colspan="4" class="px-4 py-10 text-center text-olive/40">Tidak ada hasil.</td></tr>';
}

document.querySelectorAll('.rfbtn').forEach(b => b.addEventListener('click', () => {
    filter = b.dataset.roleF;
    document.querySelectorAll('.rfbtn').forEach(x => x.className = 'rfbtn bg-white border border-cream-3 text-olive px-4 py-2 rounded-full text-xs font-semibold');
    b.className = 'rfbtn bg-olive text-white px-4 py-2 rounded-full text-xs font-semibold';
    draw();
}));

document.getElementById('apiStatus').innerHTML = '<i class="fa-solid fa-database text-olive mr-1"></i> data contoh (' + demoUsers.length + ' akun)';
draw();
</script>
@endsection