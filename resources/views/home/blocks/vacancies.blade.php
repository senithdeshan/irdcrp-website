{{-- 8. Vacancies & notices --}}
<section class="irdc-notices-section irdc-reveal-on-scroll">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <header class="irdc-notices-head">
            <div>
                <p class="irdc-notices-head__eyebrow">{{ __('messages.home_vacancies_eyebrow') }}</p>
                <h2 class="irdc-notices-head__title">{{ __('messages.home_vacancies_title') }}</h2>
                <p class="irdc-notices-head__lead">{{ __('messages.home_vacancies_sub') }}</p>
            </div>
            <a href="{{ route('vacancies.index') }}" class="irdc-notices-head__link">{{ __('messages.home_vacancies_all') }}</a>
        </header>
        @if($vacanciesPreview->isNotEmpty())
            <div class="irdc-notice-list">
                @foreach($vacanciesPreview as $v)
                    @php
                        $noticeClosed = $v->status !== 'open' || $v->deadline->copy()->endOfDay()->isPast();
                    @endphp
                    <article class="irdc-notice-card {{ $noticeClosed ? 'irdc-notice-card--closed' : '' }}">
                        <div class="irdc-notice-card__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M7 3h7l4 4v14H7V3Z"/>
                                <path d="M14 3v5h4"/>
                                <path d="M9.5 13h5"/>
                                <path d="M9.5 17h4"/>
                            </svg>
                        </div>
                        <div class="irdc-notice-card__content">
                            <span>{{ __('messages.home_vacancy_deadline') }}: {{ $v->deadline->format('M j, Y') }}</span>
                            <h3>{{ $v->title }}</h3>
                            <a
                                href="{{ route('vacancies.show', $v) }}"
                                class="irdc-notice-countdown"
                                x-data="irdcDeadlineCountdown('{{ $v->deadline->toDateString() }}')"
                                x-init="start()"
                                :class="{ 'irdc-notice-countdown--closed': expired }"
                            >
                                <span class="irdc-notice-countdown__dot" aria-hidden="true"></span>
                                <span x-text="label"></span>
                            </a>
                        </div>
                        <div class="irdc-notice-card__actions">
                            @if(filled($v->pdf_path))
                                <a href="{{ route('vacancies.file', $v) }}" class="irdc-button irdc-button--amber">{{ __('messages.vacancy_download_pdf') }}</a>
                            @endif
                            <a href="{{ route('vacancies.show', $v) }}" class="irdc-button irdc-button--small-outline">{{ __('messages.read_more') }}</a>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <p class="irdc-empty-state">{{ __('messages.home_vacancies_empty') }}</p>
        @endif
    </div>
</section>
