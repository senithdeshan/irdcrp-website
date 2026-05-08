<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ImpactMetric;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ImpactMetricController extends Controller
{
    public function index(): View
    {
        $metrics = ImpactMetric::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('admin.impact-metrics.index', compact('metrics'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'metrics' => ['required', 'array'],
            'metrics.*.label' => ['required', 'string', 'max:120'],
            'metrics.*.value' => ['required', 'string', 'max:120'],
            'metrics.*.count_target' => ['nullable', 'integer', 'min:0', 'max:999999999'],
            'metrics.*.helper' => ['nullable', 'string', 'max:255'],
            'metrics.*.sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'metrics.*.is_active' => ['nullable', 'boolean'],
        ]);

        foreach ($data['metrics'] as $id => $metricData) {
            $metric = ImpactMetric::findOrFail($id);
            $metric->update([
                'label' => $metricData['label'],
                'value' => $metricData['value'],
                'count_target' => $metricData['count_target'] ?? null,
                'helper' => $metricData['helper'] ?? null,
                'sort_order' => (int) ($metricData['sort_order'] ?? 0),
                'is_active' => $request->boolean("metrics.$id.is_active"),
            ]);
        }

        return redirect()->route('admin.impact-metrics.index')->with('success', 'Impact metrics updated.');
    }
}
