<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function quotation(Request $request)
    {
        if ($request->filled('website')) {   // honeypot: bot mengisi, manusia tidak
            return back();
        }

        $data = $request->validate([
            'name'             => 'required|string|max:100',
            'whatsapp'         => ['required', 'string', 'max:20', 'regex:/^\+?[0-9\s\-]{8,20}$/'],
            'company'          => 'nullable|string|max:150',
            'project_type'     => 'required|string|max:60',
            'project_location' => 'required|string|max:150',
            'products_needed'  => 'required|string|max:1000',
            'quantity'         => 'nullable|string|max:100',
            'notes'            => 'nullable|string|max:1500',
            'source_page'      => 'nullable|string|max:150',
        ], [
            'required' => ':attribute wajib diisi.',
            'regex'    => 'Format nomor WhatsApp tidak valid.',
            'max'      => ':attribute terlalu panjang.',
        ], [
            'name' => 'Nama', 'whatsapp' => 'Nomor WhatsApp', 'project_type' => 'Jenis proyek',
            'project_location' => 'Lokasi proyek', 'products_needed' => 'Produk yang dibutuhkan',
        ]);

        Lead::create($data + ['type' => 'quotation']);

        $msg = "Halo Top Sains, saya ingin meminta penawaran untuk kebutuhan sanitary proyek.\n"
            . "Nama: {$data['name']}\n"
            . (filled($data['company'] ?? null) ? "Perusahaan: {$data['company']}\n" : '')
            . "Jenis proyek: {$data['project_type']}\n"
            . "Lokasi proyek: {$data['project_location']}\n"
            . "Kebutuhan: {$data['products_needed']}\n"
            . (filled($data['quantity'] ?? null) ? "Estimasi quantity: {$data['quantity']}\n" : '')
            . (filled($data['notes'] ?? null) ? "Catatan: {$data['notes']}" : '');

        return back()->with('wa', wa_url(trim($msg)));
    }
}