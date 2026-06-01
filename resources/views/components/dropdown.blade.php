@props([
    'align' => 'right',
    'width' => '48',
    'contentClasses' => 'py-1 bg-white',
    /* false = auto (min 220px for wide menus); '' = no min; or pass a custom class */
    'panelMinWidth' => false,
    'panelExtraClass' => '',
    'panelRounded' => 'rounded-xl',
    'contentOverflow' => 'overflow-hidden',
])

@php
$alignmentClasses = match ($align) {
    /* top-full keeps the panel below the trigger so the label (e.g. Gallery) stays visible */
    'left' => 'start-0 top-full origin-top-start',
    'top' => 'end-0 top-full origin-top-end',
    default => 'end-0 top-full origin-top-end',
};

$width = match ($width) {
    '48' => 'w-48',
    default => $width,
};

$panelMin = $panelMinWidth !== false
    ? $panelMinWidth
    : ($width === 'w-48' ? '' : 'min-w-[220px]');
@endphp

<div class="irdc-dropdown relative inline-flex shrink-0 flex-col items-start" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
    <div class="irdc-dropdown__trigger relative inline-flex shrink-0 cursor-pointer" @click="open = ! open">
        {{ $trigger }}
    </div>

    <div
            x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-1"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-1"
            class="irdc-dropdown__panel absolute z-[10000] mt-2 {{ $panelMin }} {{ $width }} {{ $panelRounded }} bg-white shadow-[0_10px_25px_rgba(0,0,0,0.15)] ring-1 ring-black/5 {{ $alignmentClasses }} {{ $panelExtraClass }}"
            style="display: none;"
            @click="open = false"
    >
        <div class="{{ $contentOverflow }} {{ $panelRounded }} {{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>
