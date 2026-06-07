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
            ['project_staff', 'Project Staff', $keyLeaderGroups->get('project_staff', collect())],
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
                    @if($groupKey === 'project_staff')
                        <div class="irdc-leaders-divider" aria-hidden="true"></div>
                        <div class="irdc-leaders-group-head">
                            <p class="irdc-leaders-eyebrow">Implementation Team</p>
                            <h3>
                                <a href="{{ route('organizational-structure') }}" class="text-inherit no-underline transition hover:text-emerald-700">
                                    {{ $groupTitle }}
                                </a>
                            </h3>
                        </div>
                    @endif

                    <x-leader-grid :leaders="$leaders" :staff="$groupKey === 'project_staff'" />
                @endif
                @endforeach
        </div>
    </section>
@endif
