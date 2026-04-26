<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vacancy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class VacancyController extends Controller
{
    public function index(): View
    {
        $items = Vacancy::query()
            ->orderByDesc('deadline')
            ->get();

        return view('admin.vacancies.index', compact('items'));
    }

    public function create(): View
    {
        return view('admin.vacancies.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateVacancy($request, true);
        $data['pdf_path'] = $request->file('pdf')->store('vacancies', 'public');
        Vacancy::create($data);

        return redirect()->route('admin.vacancies.index')->with('success', 'Vacancy created.');
    }

    public function edit(Vacancy $vacancy): View
    {
        return view('admin.vacancies.edit', compact('vacancy'));
    }

    public function update(Request $request, Vacancy $vacancy): RedirectResponse
    {
        $data = $this->validateVacancy($request, false);

        if ($request->hasFile('pdf')) {
            if ($vacancy->pdf_path) {
                Storage::disk('public')->delete($vacancy->pdf_path);
            }
            $data['pdf_path'] = $request->file('pdf')->store('vacancies', 'public');
        }

        $vacancy->update($data);

        return redirect()->route('admin.vacancies.index')->with('success', 'Vacancy updated.');
    }

    public function destroy(Vacancy $vacancy): RedirectResponse
    {
        if ($vacancy->pdf_path) {
            Storage::disk('public')->delete($vacancy->pdf_path);
        }
        $vacancy->delete();

        return redirect()->route('admin.vacancies.index')->with('success', 'Vacancy deleted.');
    }

    private function validateVacancy(Request $request, bool $requirePdf): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date',
            'status' => 'required|in:open,closed,draft',
        ];
        if ($requirePdf) {
            $rules['pdf'] = 'required|mimes:pdf|max:15360';
        } else {
            $rules['pdf'] = 'nullable|mimes:pdf|max:15360';
        }

        return $request->validate($rules);
    }
}
