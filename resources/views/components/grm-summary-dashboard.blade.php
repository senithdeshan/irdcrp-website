@props(['stats'])

@php
    $total = max((int) ($stats['total'] ?? 0), 0);
    $solved = (int) ($stats['solved'] ?? 0);
    $inProgress = (int) ($stats['in_progress'] ?? 0);
    $unsolved = (int) ($stats['unsolved'] ?? 0);

    $solvedPct = $total > 0 ? round(($solved / $total) * 100) : 0;
    $inProgressPct = $total > 0 ? round(($inProgress / $total) * 100) : 0;
    $unsolvedPct = $total > 0 ? round(($unsolved / $total) * 100) : 0;

    $solvedDeg = $total > 0 ? ($solved / $total) * 360 : 0;
    $inProgressDeg = $total > 0 ? ($inProgress / $total) * 360 : 0;
    $unsolvedDeg = $total > 0 ? ($unsolved / $total) * 360 : 0;

    $pieEndSolved = $solvedDeg;
    $pieEndInProgress = $pieEndSolved + $inProgressDeg;
    $pieEndUnsolved = $pieEndInProgress + $unsolvedDeg;

    $pieStyle = $total > 0
        ? "background: conic-gradient(#22c55e 0deg {$pieEndSolved}deg, #f59e0b {$pieEndSolved}deg {$pieEndInProgress}deg, #ef4444 {$pieEndInProgress}deg {$pieEndUnsolved}deg, #e2e8f0 {$pieEndUnsolved}deg 360deg);"
        : 'background: conic-gradient(#e2e8f0 0deg 360deg);';
@endphp

<section class="irdc-grm-summary" aria-label="GRM complaint statistics">
    <div class="irdc-grm-summary__grid">
        <div class="irdc-grm-summary__cards">
            <article class="irdc-grm-summary-card irdc-grm-summary-card--total">
                <p class="irdc-grm-summary-card__label">Received</p>
                <p class="irdc-grm-summary-card__value">{{ number_format($total) }}</p>
                <p class="irdc-grm-summary-card__hint">Total grievances submitted</p>
            </article>
            <article class="irdc-grm-summary-card irdc-grm-summary-card--solved">
                <p class="irdc-grm-summary-card__label">Solved</p>
                <p class="irdc-grm-summary-card__value">{{ number_format($solved) }}</p>
                <p class="irdc-grm-summary-card__hint">{{ $solvedPct }}% of total</p>
            </article>
            <article class="irdc-grm-summary-card irdc-grm-summary-card--progress">
                <p class="irdc-grm-summary-card__label">In Progress</p>
                <p class="irdc-grm-summary-card__value">{{ number_format($inProgress) }}</p>
                <p class="irdc-grm-summary-card__hint">{{ $inProgressPct }}% of total</p>
            </article>
            <article class="irdc-grm-summary-card irdc-grm-summary-card--unsolved">
                <p class="irdc-grm-summary-card__label">Unsolved</p>
                <p class="irdc-grm-summary-card__value">{{ number_format($unsolved) }}</p>
                <p class="irdc-grm-summary-card__hint">{{ $unsolvedPct }}% of total</p>
            </article>
        </div>

        <div class="irdc-grm-summary__chart-card">
            <h2 class="irdc-grm-summary__chart-title">Complaint overview</h2>
            <div class="irdc-grm-summary__chart-wrap">
                <div class="irdc-grm-summary__pie" style="{{ $pieStyle }}" role="img" aria-label="Pie chart of GRM complaints by status"></div>
                <ul class="irdc-grm-summary__legend">
                    <li><span class="irdc-grm-summary__dot irdc-grm-summary__dot--solved"></span>Solved ({{ $solved }})</li>
                    <li><span class="irdc-grm-summary__dot irdc-grm-summary__dot--progress"></span>In Progress ({{ $inProgress }})</li>
                    <li><span class="irdc-grm-summary__dot irdc-grm-summary__dot--unsolved"></span>Unsolved ({{ $unsolved }})</li>
                </ul>
            </div>
        </div>
    </div>
</section>
