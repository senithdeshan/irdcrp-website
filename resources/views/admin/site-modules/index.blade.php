@extends('layouts.app')

@section('content')
<section class="container py-5">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h1 class="section-title mb-1">Site modules</h1>
            <p class="text-muted mb-0">Plug in or remove whole features from the public website. Data is kept in the database — turn a module back on anytime. Example: disable Vacancies when there are no open jobs.</p>
        </div>
        <a href="{{ route('admin.home') }}" class="btn btn-outline-secondary">Back to admin</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.site-modules.update') }}">
        @csrf
        @method('PUT')

        <div class="card feature-card p-0 overflow-hidden mb-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Module</th>
                            <th style="width: 8rem;">Plugged in</th>
                            <th style="width: 8rem;">Manage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modules as $module)
                            <tr>
                                <td>
                                    <strong>{{ $module['label'] }}</strong>
                                    <div class="small text-muted">{{ $module['description'] }}</div>
                                    @if(filled($module['home_block'] ?? null))
                                        <div class="small text-muted mt-1">Home block: {{ str_replace('_', ' ', $module['home_block']) }}</div>
                                    @endif
                                </td>
                                <td>
                                    <div class="form-check form-switch mb-0">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            role="switch"
                                            id="module-{{ $module['id'] }}"
                                            name="modules[{{ $module['id'] }}]"
                                            value="1"
                                            @checked($module['enabled'] ?? true)
                                        >
                                        <label class="form-check-label visually-hidden" for="module-{{ $module['id'] }}">Enable {{ $module['label'] }}</label>
                                    </div>
                                </td>
                                <td>
                                    @if(filled($module['admin_route'] ?? null))
                                        <a href="{{ route($module['admin_route']) }}" class="btn btn-sm btn-outline-primary">Content</a>
                                    @else
                                        <span class="small text-muted">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="alert alert-info small">
            <strong>When unplugged:</strong> menu links, public pages, and related home page blocks are hidden. Admin content stays saved. Use <a href="{{ route('admin.home-layout.edit') }}">Home page layout</a> to reorder visible blocks.
        </div>

        <button type="submit" class="btn btn-green">Save modules</button>
    </form>
</section>
@endsection
