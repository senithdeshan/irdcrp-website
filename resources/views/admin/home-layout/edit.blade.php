@extends('layouts.app')

@section('content')
<section class="container py-5">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h1 class="section-title mb-1">Home page layout</h1>
            <p class="text-muted mb-0">Choose which sections appear on the home page and drag their order. Content inside each block is still managed from its own admin area.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ url('/') }}" target="_blank" class="btn btn-outline-secondary">View home page</a>
            <a href="{{ route('admin.home') }}" class="btn btn-outline-secondary">Back to admin</a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="alert alert-info small mb-4">
        Unplugged modules are hidden from the home page even if listed here. Use <a href="{{ route('admin.site-modules.index') }}">Site modules</a> to turn whole features on or off (e.g. Vacancies when there are no open jobs).
    </div>

    <form method="POST" action="{{ route('admin.home-layout.update') }}" id="home-layout-form">
        @csrf
        @method('PUT')

        <div class="card feature-card p-0 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 3rem;">Order</th>
                            <th>Section</th>
                            <th style="width: 7rem;">Visible</th>
                            <th style="width: 8rem;">Move</th>
                            <th style="width: 8rem;">Content</th>
                        </tr>
                    </thead>
                    <tbody id="home-layout-rows">
                        @foreach($blocks as $index => $block)
                            <tr data-block-row>
                                <td class="text-muted">{{ $index + 1 }}</td>
                                <td>
                                    <strong>{{ $block['label'] }}</strong>
                                    <div class="small text-muted">{{ $block['description'] ?? '' }}</div>
                                    <input type="hidden" name="blocks[{{ $index }}][id]" value="{{ $block['id'] }}" data-block-id>
                                </td>
                                <td>
                                    <div class="form-check form-switch mb-0">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            role="switch"
                                            id="block-enabled-{{ $block['id'] }}"
                                            name="blocks[{{ $index }}][enabled]"
                                            value="1"
                                            @checked($block['enabled'] ?? true)
                                        >
                                        <label class="form-check-label visually-hidden" for="block-enabled-{{ $block['id'] }}">Show section</label>
                                    </div>
                                </td>
                                <td class="text-nowrap">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" data-move="up" aria-label="Move up">↑</button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" data-move="down" aria-label="Move down">↓</button>
                                </td>
                                <td>
                                    @if(filled($block['admin_route'] ?? null))
                                        <a href="{{ route($block['admin_route']) }}" class="btn btn-sm btn-primary">Manage</a>
                                    @else
                                        <span class="small text-muted">Fixed copy</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4 d-flex flex-wrap gap-2">
            <button type="submit" class="btn btn-green">Save layout</button>
            <a href="{{ url('/') }}" target="_blank" class="btn btn-outline-secondary">Preview home page</a>
        </div>
    </form>
</section>

<script>
    (function () {
        const tbody = document.getElementById('home-layout-rows');
        const form = document.getElementById('home-layout-form');
        if (!tbody || !form) {
            return;
        }

        function reindexRows() {
            tbody.querySelectorAll('[data-block-row]').forEach(function (row, index) {
                row.querySelector('[data-block-id]')?.setAttribute('name', 'blocks[' + index + '][id]');
                const toggle = row.querySelector('input[type="checkbox"][role="switch"]');
                if (toggle) {
                    toggle.setAttribute('name', 'blocks[' + index + '][enabled]');
                }
                const orderCell = row.querySelector('td');
                if (orderCell) {
                    orderCell.textContent = String(index + 1);
                }
            });
        }

        tbody.addEventListener('click', function (event) {
            const button = event.target.closest('[data-move]');
            if (!button) {
                return;
            }

            const row = button.closest('[data-block-row]');
            if (!row) {
                return;
            }

            if (button.dataset.move === 'up') {
                const previous = row.previousElementSibling;
                if (previous) {
                    tbody.insertBefore(row, previous);
                }
            } else {
                const next = row.nextElementSibling;
                if (next) {
                    tbody.insertBefore(next, row);
                }
            }

            reindexRows();
        });

        form.addEventListener('submit', reindexRows);
    })();
</script>
@endsection
