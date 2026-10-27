{{-- Key leaders — first content after hero (always visible; no scroll-reveal fade) --}}
@if(count($keyLeaders) > 0)
    @php
        $keyLeaderGroups = collect($keyLeaders)->groupBy(function ($leader) {
            if ($leader instanceof \App\Models\KeyLeader) {
                return $leader->group ?? 'key_leader';
            }

            return $leader['group'] ?? 'key_leader';
        });
        $leaderSections = [
            ['key_leader', null, $keyLeaderGroups->get('key_leader', collect())],
        ];
    @endphp
    <section id="key-leaders" class="irdc-leaders-section irdc-scroll-mt-header" aria-labelledby="key-leaders-heading">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <header class="irdc-leaders-head">
                <p class="irdc-leaders-eyebrow">Project Governance</p>
                <div class="irdc-leaders-title-row">
                    <h2 id="key-leaders-heading" class="irdc-leaders-title">
                        {{ __('messages.home_leaders_title') }}
                    </h2>
                    <span class="irdc-leaders-leaf" aria-hidden="true">
                        <svg class="h-7 w-7 sm:h-8 sm:w-8" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 22c-2-6 2-14 10-16 2 8-2 14-10 16Z" fill="currentColor" opacity="0.35"/>
                            <path d="M14 24c8-2 12-10 10-18-8 2-12 10-10 18Z" fill="currentColor"/>
                        </svg>
                    </span>
                </div>
                <p class="irdc-leaders-subtitle">
                    Leadership and institutional coordination for implementation, supervision, and partner collaboration.
                </p>
            </header>
            @foreach ($leaderSections as [$groupKey, $groupTitle, $leaders])
                @if($leaders->isNotEmpty())
                    <x-leader-grid :leaders="$leaders" :staff="$groupKey === 'project_staff'" />
                @endif
                @endforeach
            <div class="irdc-staff-callout" aria-labelledby="home-staff-heading">
                <div>
                    <p class="irdc-leaders-eyebrow">Implementation Team</p>
                    <h3 id="home-staff-heading" class="irdc-staff-callout__title">Project Staff</h3>
                    <p class="irdc-staff-callout__description">Core PMU and field staff responsible for project operations, monitoring, and stakeholder support.</p>
                </div>
                <a href="{{ route('organizational-structure') }}" class="irdc-button irdc-button--green">
                    Project Staff
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path d="M5 12h14m-6-6 6 6-6 6" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            </div>
        </div>
    </section>
@endif
