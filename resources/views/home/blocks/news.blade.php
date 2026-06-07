{{-- 6. News & updates --}}
@if($homeNews->isNotEmpty())
    <section class="irdc-news-section irdc-reveal-on-scroll">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <header class="irdc-news-head">
                <div>
                    <p class="irdc-news-head__eyebrow">{{ __('messages.home_news_events') }}</p>
                    <h2 class="irdc-news-head__title">{{ __('messages.home_news_title') }}</h2>
                    <p class="irdc-news-head__lead">{{ __('messages.home_news_sub') }}</p>
                </div>
                <a href="{{ route('news.index') }}" class="irdc-news-head__link">{{ __('messages.home_news_all') }}</a>
            </header>
            <div class="irdc-news-grid">
                @foreach ($homeNews as $article)
                    <a href="{{ route('news.show', $article) }}" class="irdc-news-card group">
                        <article>
                            @if ($article->imageUrl())
                                <div class="irdc-news-card__image">
                                    <img src="{{ $article->imageUrl() }}" alt="" loading="lazy" decoding="async">
                                </div>
                            @else
                                <div class="irdc-news-card__image irdc-news-card__image--empty">
                                    <span>News</span>
                                </div>
                            @endif
                            <div class="irdc-news-card__body">
                                <div class="irdc-news-card__meta">
                                    @if ($article->published_date)
                                        <time datetime="{{ $article->published_date->toDateString() }}">{{ $article->published_date->format('M j, Y') }}</time>
                                    @endif
                                    @if($article->is_pinned)
                                        <span class="irdc-news-card__pin">Pinned</span>
                                    @endif
                                </div>
                                <h3>{{ $article->{'title_'.$tLoc} ?? $article->title_en }}</h3>
                                <p><span>{{ __('messages.read_more') }}</span></p>
                            </div>
                        </article>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endif
