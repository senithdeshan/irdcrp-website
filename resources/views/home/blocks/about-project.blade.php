{{-- 2. Project identity: Sinhala / Tamil / English + short lead --}}
<section id="about-project" class="irdc-identity-section irdc-reveal-on-scroll irdc-scroll-mt-header">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 sm:py-20 lg:px-8">
        <div class="irdc-identity-shell">
            <div class="irdc-identity-copy">
                <p class="irdc-identity-eyebrow">{{ __('messages.home_trilingual_eyebrow') }}</p>
                <h2 class="irdc-identity-title">Integrated Rurban Development and Climate Resilience Project</h2>
                <div class="irdc-identity-lead">
                    <p>The Integrated Rurban Development and Climate Resilience Project builds on current and recently closed World Bank-financed operations and other sector engagements designed to rapidly address pressing development challenges, especially as Sri Lanka recovers from the economic crisis. It is the first in a Series of Projects (SOP), envisioning two projects over a nine-year period, that incorporates learning and institutional development for multisector solutions and adjusts the implementation approach as needed across projects.</p>
                    <p>The World Bank and IFC are collaborating to create an enabling environment for smallholder producers to link with commercial buyers and financial institutions, with IFC providing complementary technical assistance to the sector to enhance service delivery.</p>
                    <p>The SOP will deepen investments in the enabling environment, boost market links, and invest in coordinated efforts for climate resilience to bring greater competitiveness and private sector engagement in the agriculture, livestock, plantation, and aquaculture sectors.</p>
                    <p>This will support Sri Lanka's objectives of increasing agriculture exports and ensuring a sustainable and climate-resilient agri-food production system with improved coordination among a number of departments and agencies.</p>
                </div>
                <div class="irdc-identity-badges" aria-label="Project focus areas">
                    <span>Climate resilience</span>
                    <span>Rurban development</span>
                    <span>Smallholder value chains</span>
                </div>
            </div>

            <div class="irdc-identity-names" aria-label="Project name in Sinhala, Tamil, and English">
                @foreach ($titleLines as $line)
                    <article @class([
                        'irdc-identity-name',
                    ])>
                        <span class="irdc-identity-name__lang">
                            {{ $loop->iteration === 1 ? 'Sinhala' : ($loop->iteration === 2 ? 'Tamil' : 'English') }}
                        </span>
                        <p>{{ $line }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </div>
</section>
