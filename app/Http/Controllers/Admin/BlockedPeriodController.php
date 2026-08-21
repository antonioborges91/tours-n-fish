<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlockedPeriod;
use Illuminate\Http\Request;

class BlockedPeriodController extends Controller
{
    public function index()
    {
        $blockedPeriods = BlockedPeriod::orderBy('start_at')->get();

        return view(
            'admin.blocked-periods.index',
            compact('blockedPeriods')
        );
    }

    public function create()
    {
        return view('admin.blocked-periods.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'start_at' => ['required', 'date'],
            'end_at' => ['required', 'date', 'after:start_at'],
            'reason' => ['nullable', 'string', 'max:255'],
        ]);

        BlockedPeriod::create($validated);

        return redirect()
            ->route('admin.blocked-periods.index')
            ->with('success', 'Período bloqueado com sucesso.');
    }

    public function show(BlockedPeriod $blockedPeriod)
    {
        return redirect()
            ->route('admin.blocked-periods.edit', $blockedPeriod);
    }

    public function edit(BlockedPeriod $blockedPeriod)
    {
        return view(
            'admin.blocked-periods.edit',
            compact('blockedPeriod')
        );
    }

    public function update(
        Request $request,
        BlockedPeriod $blockedPeriod
    ) {
        $validated = $request->validate([
            'start_at' => ['required', 'date'],
            'end_at' => ['required', 'date', 'after:start_at'],
            'reason' => ['nullable', 'string', 'max:255'],
        ]);

        $blockedPeriod->update($validated);

        return redirect()
            ->route('admin.blocked-periods.index')
            ->with('success', 'Período bloqueado atualizado com sucesso.');
    }

    public function destroy(BlockedPeriod $blockedPeriod)
    {
        $blockedPeriod->delete();

        return redirect()
            ->route('admin.blocked-periods.index')
            ->with('success', 'Período bloqueado removido com sucesso.');
    }
}