@php
    $popup = $homePopup ?? [];
    $imageUrl = app(\App\Support\SiteSettings::class)->homePopupImageUrl($popup['image'] ?? null);
    $shouldRender = filled($imageUrl)
        && ($popup['enabled'] ?? false)
        && request()->path() === '/';
@endphp

@if($shouldRender)
    <div
        id="irdc-home-popup"
        class="irdc-home-popup"
        hidden
        data-version="{{ $popup['updated_at'] ?? '1' }}"
        role="dialog"
        aria-modal="false"
        aria-label="{{ $popup['alt'] ?? 'Important announcement' }}"
    >
        <div class="irdc-home-popup__backdrop" data-dismiss></div>
        <div class="irdc-home-popup__dialog">
            <button type="button" class="irdc-home-popup__close" data-dismiss aria-label="Close announcement">
                <svg class="irdc-home-popup__close-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                    <path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/>
                </svg>
            </button>

            @if(filled($popup['link_url'] ?? null))
                <a href="{{ $popup['link_url'] }}" class="irdc-home-popup__link" target="_blank" rel="noopener noreferrer" data-popup-link>
                    <img
                        src="{{ $imageUrl }}"
                        alt="{{ $popup['alt'] ?? 'Important announcement' }}"
                        class="irdc-home-popup__image"
                        loading="eager"
                        decoding="async"
                    >
                </a>
            @else
                <img
                    src="{{ $imageUrl }}"
                    alt="{{ $popup['alt'] ?? 'Important announcement' }}"
                    class="irdc-home-popup__image"
                    loading="eager"
                    decoding="async"
                >
            @endif
        </div>
    </div>

    <script>
        (function () {
            const popup = document.getElementById('irdc-home-popup');
            if (!popup) {
                return;
            }

            const version = popup.dataset.version || '1';
            const storageKey = 'irdcrp_home_popup_dismissed';

            function readDismissedVersion() {
                try {
                    return localStorage.getItem(storageKey);
                } catch (error) {
                    return null;
                }
            }

            function rememberDismissedVersion() {
                try {
                    localStorage.setItem(storageKey, version);
                } catch (error) {
                    // If storage is unavailable, keep the popup dismissible for this page view.
                }
            }

            if (readDismissedVersion() === version) {
                return;
            }

            popup.hidden = false;
            document.body.classList.add('irdc-home-popup-open');

            function dismissPopup() {
                rememberDismissedVersion();
                popup.hidden = true;
                document.body.classList.remove('irdc-home-popup-open');
            }

            popup.querySelectorAll('[data-dismiss]').forEach(function (element) {
                element.addEventListener('click', dismissPopup);
            });

            popup.querySelectorAll('[data-popup-link]').forEach(function (element) {
                element.addEventListener('click', rememberDismissedVersion);
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && !popup.hidden) {
                    dismissPopup();
                }
            });
        })();
    </script>
@endif
