@props(['programme'])

@php
    $blocks = $programme->normalizedContentBlocks();
@endphp

@if (count($blocks) > 0)
    <div class="irdc-programme-blocks">
        @foreach ($blocks as $block)
            @if (($block['type'] ?? null) === 'text' && filled($block['body'] ?? null))
                <div class="irdc-programme-block irdc-programme-block--text">
                    <div class="irdc-programme-block__text">{!! nl2br(e($block['body'])) !!}</div>
                </div>
            @elseif (($block['type'] ?? null) === 'image' && filled($block['path'] ?? null))
                <figure class="irdc-programme-block irdc-programme-block--image">
                    <img
                        src="{{ $programme->storageImageUrl($block['path']) }}"
                        alt="{{ $block['caption'] ?? $programme->title }}"
                        loading="lazy"
                        decoding="async"
                    >
                    @if (filled($block['caption'] ?? null))
                        <figcaption>{{ $block['caption'] }}</figcaption>
                    @endif
                </figure>
            @elseif (($block['type'] ?? null) === 'table' && filled($block['headers'] ?? null))
                <div class="irdc-programme-block irdc-programme-block--table">
                    @if (filled($block['title'] ?? null))
                        <h3 class="irdc-programme-block__table-title">{{ $block['title'] }}</h3>
                    @endif
                    <div class="irdc-programme-block__table-wrap">
                        <table class="irdc-programme-block__table">
                            <thead>
                                <tr>
                                    @foreach ($block['headers'] as $header)
                                        <th scope="col">{{ $header }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($block['rows'] ?? [] as $row)
                                    @if (filled(array_filter($row)))
                                        <tr>
                                            @foreach ($block['headers'] as $cellIndex => $header)
                                                <td data-label="{{ $header }}">{{ $row[$cellIndex] ?? '' }}</td>
                                            @endforeach
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@endif
