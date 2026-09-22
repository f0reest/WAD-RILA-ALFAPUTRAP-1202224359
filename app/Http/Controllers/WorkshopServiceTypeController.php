<?php

namespace App\Http\Controllers;

use App\Models\WorkshopServiceType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class WorkshopServiceTypeController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        WorkshopServiceType::create($validated);

        return redirect()->route('workshops.index')->with('success', 'Jenis layanan berhasil ditambahkan.');
    }

    public function update(Request $request, WorkshopServiceType $serviceType): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $serviceType->update($validated);

        return redirect()->route('workshops.index')->with('success', 'Jenis layanan berhasil diperbarui.');
    }

    public function destroy(WorkshopServiceType $serviceType): RedirectResponse
    {
        $serviceType->delete();

        return redirect()->route('workshops.index')->with('success', 'Jenis layanan berhasil dihapus.');
    }
}
