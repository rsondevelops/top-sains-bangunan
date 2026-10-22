<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

if (! function_exists('setting')) {
    function setting(string $key, $default = null)
    {
        static $all = null;
        $all ??= Setting::pluck('value', 'key')->all();

        return filled($all[$key] ?? null) ? $all[$key] : $default;
    }
}

// Satu-satunya tempat nomor WhatsApp dipakai.
if (! function_exists('wa_url')) {
    function wa_url(string $message = ''): string
    {
        $number = preg_replace('/\D/', '', (string) setting('whatsapp_number', ''));

        return 'https://wa.me/' . $number . '?text=' . rawurlencode($message);
    }
}

if (! function_exists('product_wa')) {
    function product_wa($p): string
    {
        return wa_url("Halo Top Sains, saya ingin menanyakan produk {$p->display_name}. Apakah produk ini tersedia dan berapa harganya?");
    }
}

if (! function_exists('rupiah')) {
    function rupiah($n): string
    {
        return 'Rp' . number_format($n, 0, ',', '.');
    }
}

// Slug unik: nama-produk, nama-produk-2, dst.
if (! function_exists('unique_slug')) {
    function unique_slug(string $model, string $text, ?int $ignoreId = null): string
    {
        $base = Str::slug($text) ?: 'item';
        $slug = $base;
        $n = 2;
        while ($model::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . $n++;
        }

        return $slug;
    }
}

// Upload satu gambar. Mengembalikan path baru, path lama, atau null (jika dihapus).
if (! function_exists('save_image')) {
    function save_image($request, string $field, string $dir, ?string $current): ?string
    {
        if ($request->hasFile($field)) {
            if ($current) Storage::disk('public')->delete($current);
            return $request->file($field)->store($dir, 'public');
        }
        if ($request->boolean("remove_{$field}") && $current) {
            Storage::disk('public')->delete($current);
            return null;
        }

        return $current;
    }
}

if (! function_exists('id_messages')) {
    function id_messages(): array
    {
        return [
            'required'   => ':attribute wajib diisi.',
            'image'      => ':attribute harus berupa gambar.',
            'max.file'   => ':attribute maksimal :max KB.',
            'max.string' => ':attribute terlalu panjang (maks :max karakter).',
            'unique'     => ':attribute sudah dipakai.',
            'regex'      => 'Format :attribute tidak valid.',
            'integer'    => ':attribute harus berupa angka.',
            'url'        => ':attribute harus berupa URL lengkap (https://...).',
        ];
    }
}

// Link WhatsApp ke nomor customer (08xx -> 628xx)
if (! function_exists('wa_customer')) {
    function wa_customer(?string $number, string $message = ''): string
    {
        $d = preg_replace('/\D/', '', (string) $number);
        if (str_starts_with($d, '0')) $d = '62' . substr($d, 1);

        return 'https://wa.me/' . $d . ($message ? '?text=' . rawurlencode($message) : '');
    }
}