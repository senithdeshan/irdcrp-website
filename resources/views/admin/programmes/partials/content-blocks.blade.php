@php
    $initialBlocks = old('blocks');

    if (! is_array($initialBlocks)) {
        $initialBlocks = collect($programme?->content_blocks ?? [])
            ->map(function ($block) {
                if (($block['type'] ?? null) === 'table') {
                    $block['headers_text'] = implode('|', $block['headers'] ?? []);
                    $block['rows_text'] = collect($block['rows'] ?? [])
                        ->map(fn ($row) => implode('|', $row))
                        ->implode("\n");
                }

                return $block;
            })
            ->values()
            ->all();
    }

    if ($initialBlocks === []) {
        $initialBlocks = [['type' => 'text', 'body' => '']];
    }
@endphp

<div class="irdc-admin-programme-blocks mb-4" data-programme-blocks>
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-2 mb-3">
        <div>
            <label class="form-label mb-1">Programme content blocks</label>
            <div class="form-text">Add text, images, or tables below the main description. Use the + buttons to insert more sections.</div>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <button type="button" class="btn btn-sm btn-outline-success" data-add-block="text">+ Text</button>
            <button type="button" class="btn btn-sm btn-outline-success" data-add-block="image">+ Image</button>
            <button type="button" class="btn btn-sm btn-outline-success" data-add-block="table">+ Table</button>
        </div>
    </div>

    <div class="irdc-admin-programme-blocks__list d-grid gap-3" data-block-list>
        @foreach ($initialBlocks as $index => $block)
            @include('admin.programmes.partials.content-block-item', [
                'index' => $index,
                'block' => $block,
                'programme' => $programme ?? null,
            ])
        @endforeach
    </div>
</div>

<template id="programme-block-template-text">
    @include('admin.programmes.partials.content-block-item', [
        'index' => '__INDEX__',
        'block' => ['type' => 'text', 'body' => ''],
        'programme' => null,
    ])
</template>

<template id="programme-block-template-image">
    @include('admin.programmes.partials.content-block-item', [
        'index' => '__INDEX__',
        'block' => ['type' => 'image', 'caption' => ''],
        'programme' => null,
    ])
</template>

<template id="programme-block-template-table">
    @include('admin.programmes.partials.content-block-item', [
        'index' => '__INDEX__',
        'block' => ['type' => 'table', 'title' => '', 'headers_text' => '', 'rows_text' => ''],
        'programme' => null,
    ])
</template>

<script>
document.querySelectorAll('[data-programme-blocks]').forEach((root) => {
    const list = root.querySelector('[data-block-list]');

    const renumberBlocks = () => {
        list.querySelectorAll('[data-block-item]').forEach((item, index) => {
            item.querySelector('[data-block-number]').textContent = index + 1;
            item.querySelectorAll('[name]').forEach((input) => {
                input.name = input.name.replace(/blocks\[\d+]/, `blocks[${index}]`);
            });
            item.querySelectorAll('[data-block-file]').forEach((input) => {
                input.name = `blocks[${index}][image]`;
            });
        });
    };

    root.querySelectorAll('[data-add-block]').forEach((button) => {
        button.addEventListener('click', () => {
            const type = button.getAttribute('data-add-block');
            const template = document.getElementById(`programme-block-template-${type}`);
            if (! template) {
                return;
            }

            const index = list.querySelectorAll('[data-block-item]').length;
            const html = template.innerHTML.replaceAll('__INDEX__', String(index));
            const wrapper = document.createElement('div');
            wrapper.innerHTML = html.trim();
            list.appendChild(wrapper.firstElementChild);
            renumberBlocks();
        });
    });

    list.addEventListener('click', (event) => {
        const removeButton = event.target.closest('[data-remove-block]');
        if (! removeButton) {
            return;
        }

        const items = list.querySelectorAll('[data-block-item]');
        if (items.length <= 1) {
            return;
        }

        removeButton.closest('[data-block-item]')?.remove();
        renumberBlocks();
    });

    renumberBlocks();
});
</script>
