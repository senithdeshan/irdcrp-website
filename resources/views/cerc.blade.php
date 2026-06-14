@extends('layouts.app')

@section('title', 'Contingent Emergency Response Component (CERC) | '.config('app.name'))

@section('content')
<section class="irdc-components-hero">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 sm:py-20 lg:px-8">
        <div class="max-w-3xl">
            <p class="irdc-components-eyebrow">{{ $cerc['hero_eyebrow'] ?? 'Resources' }}</p>
            <h1 class="irdc-components-title">{{ $cerc['hero_title'] ?? 'Contingent Emergency Response Component (CERC)' }}</h1>
            <p class="irdc-components-lead">
                {{ $cerc['hero_lead'] ?? 'A zero-allocation component that enables rapid project support when an eligible crisis or emergency is declared.' }}
            </p>
        </div>
    </div>
</section>

<section class="irdc-components-section">
    <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 sm:py-16 lg:px-8">
        <div class="irdc-components-summary">
            <div>
                <p class="irdc-components-summary__label">{{ $cerc['summary_label'] ?? 'Emergency readiness' }}</p>
                <h2 class="irdc-components-summary__title">
                    {{ $component?->title ?? 'Contingent Emergency Response Component' }}
                </h2>
            </div>
            <p class="irdc-components-summary__copy">
                {{ $cerc['summary_copy'] ?? 'CERC helps IRDCRP respond quickly to natural or man-made disasters and other eligible emergencies that may cause significant economic or social impacts.' }}
            </p>
        </div>

        <article class="irdc-component-card">
            <div class="irdc-component-card__body">
                <p class="irdc-component-card__kicker">Component {{ $component?->component_number ?? 5 }}</p>
                <h3 class="irdc-component-card__title">{{ $component?->title ?? 'Contingent Emergency Response Component' }}</h3>

                @if($component?->budget)
                    <p class="irdc-component-card__budget">{{ $component->budget }}</p>
                @else
                    <p class="irdc-component-card__budget">US$0 million</p>
                @endif

                @if($component?->beneficiaries)
                    <p class="irdc-component-card__beneficiaries">{{ $component->beneficiaries }}</p>
                @endif

                <p class="irdc-component-card__description">
                    {{ $component?->description ?? 'This component supports the provision of immediate response to an eligible crisis or emergency and provides flexibility for rapid response if a disaster or crisis leads to significant adverse economic or social impacts.' }}
                </p>
            </div>
        </article>

        <div class="mt-10">
            <header class="mb-8 max-w-3xl">
                <h2 class="font-display text-2xl font-extrabold tracking-tight text-[#0A3D62] sm:text-3xl">{{ $cerc['document_section_title'] ?? 'CERC document library' }}</h2>
                <p class="mt-2 text-sm leading-relaxed text-slate-600 sm:text-base">
                    {{ $cerc['document_section_description'] ?? 'Official CERC guidelines, forms, reports, and emergency response documents available for public download.' }}
                </p>
            </header>

            <div class="irdc-safeguard-table-wrap">
                <table class="irdc-safeguard-table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Description</th>
                            <th scope="col">Date</th>
                            <th scope="col">Document</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($documents as $doc)
                            <tr>
                                <td data-label="#">{{ $loop->iteration }}</td>
                                <td data-label="Title">
                                    <strong class="irdc-safeguard-table__title">{{ $doc->title }}</strong>
                                </td>
                                <td data-label="Description">
                                    @if ($doc->description)
                                        <div class="irdc-safeguard-table__description">{{ $doc->description }}</div>
                                    @else
                                        <span class="irdc-safeguard-table__muted">-</span>
                                    @endif
                                </td>
                                <td data-label="Date">
                                    @if ($doc->file_date)
                                        {{ $doc->file_date->format('M j, Y') }}
                                    @else
                                        <span class="irdc-safeguard-table__muted">-</span>
                                    @endif
                                </td>
                                <td data-label="Document">
                                    @if ($doc->fileExists())
                                        <a href="{{ route('cerc.file', $doc) }}" class="irdc-safeguard-download">
                                            <span class="irdc-safeguard-download__badge">{{ $doc->fileExtension() ?: 'FILE' }}</span>
                                            <span class="irdc-safeguard-download__text">
                                                <span class="irdc-safeguard-download__label">{{ $doc->fileTypeLabel() }}</span>
                                                @if ($doc->file_original_name)
                                                    <span class="irdc-safeguard-download__name">{{ $doc->file_original_name }}</span>
                                                @endif
                                            </span>
                                        </a>
                                    @else
                                        <span class="irdc-safeguard-table__muted">No file</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="irdc-safeguard-table__empty">
                                    No published CERC documents yet. Content will appear here once added from the admin CERC Documents area.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
