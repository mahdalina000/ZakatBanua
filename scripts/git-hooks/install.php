<?php

/**
 * Pasang git hooks bersama untuk ZakatBanua.
 *
 * Dipanggil otomatis oleh `composer install` / `composer update`
 * (lihat "scripts" di composer.json). Menunjuk git `core.hooksPath`
 * ke folder scripts/git-hooks/ sehingga hook auto-push aktif untuk
 * semua orang yang menjalankan composer install, tanpa langkah manual.
 */

$root = dirname(__DIR__, 2);
$hooksDir = __DIR__;

// Hanya berlaku di dalam working tree git yang valid.
if (! is_dir($root.'/.git')) {
    fwrite(STDERR, "[hooks] Lewati: bukan working tree git.\n");

    return;
}

$current = trim((string) shell_exec('git -C '.escapeshellarg($root).' config --local --get core.hooksPath 2>/dev/null'));

if ($current === 'scripts/git-hooks') {
    echo "[hooks] core.hooksPath sudah menunjuk scripts/git-hooks.\n";

    return;
}

// Pastikan hook dapat dieksekusi (di Windows biasanya tidak berpengaruh, di Unix ya).
@chmod($hooksDir.'/post-commit', 0755);

shell_exec('git -C '.escapeshellarg($root).' config --local core.hooksPath scripts/git-hooks');
echo "[hooks] core.hooksPath diset ke scripts/git-hooks (auto-push feat/* aktif).\n";
