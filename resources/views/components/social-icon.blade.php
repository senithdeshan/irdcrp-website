@props(['name'])

<svg
    {{ $attributes->merge(['class' => 'h-4 w-4']) }}
    viewBox="0 0 24 24"
    fill="none"
    xmlns="http://www.w3.org/2000/svg"
    aria-hidden="true"
>
    @switch($name)
        @case('facebook')
            <path d="M14.25 8.35H16V5.3C15.7 5.26 14.66 5.18 13.45 5.18C10.92 5.18 9.18 6.77 9.18 9.69V12.38H6.38V15.78H9.18V24H12.61V15.78H15.29L15.72 12.38H12.61V10.03C12.61 9.05 12.88 8.35 14.25 8.35Z" fill="currentColor"/>
        @break

        @case('youtube')
            <rect x="2.6" y="6.1" width="18.8" height="11.8" rx="3.2" fill="currentColor"/>
            <path d="M10.35 9.25L15.55 12L10.35 14.75V9.25Z" fill="white"/>
        @break

        @case('twitter')
        @case('x')
            <path d="M5 5H8.35L12.45 10.5L17.05 5H20.15L13.9 12.25L20.45 21H17.1L12.75 15.15L7.75 21H4.65L11.3 13.25L5 5Z" fill="currentColor"/>
        @break

        @case('linkedin')
            <path d="M5.2 9.35H8.45V19.8H5.2V9.35Z" fill="currentColor"/>
            <path d="M6.83 4.2C7.88 4.2 8.72 5.04 8.72 6.08C8.72 7.12 7.88 7.96 6.83 7.96C5.79 7.96 4.95 7.12 4.95 6.08C4.95 5.04 5.79 4.2 6.83 4.2Z" fill="currentColor"/>
            <path d="M10.48 9.35H13.6V10.78H13.65C14.08 9.95 15.15 9.08 16.73 9.08C20.02 9.08 20.63 11.25 20.63 14.07V19.8H17.38V14.72C17.38 13.51 17.36 11.96 15.7 11.96C14.02 11.96 13.76 13.27 13.76 14.63V19.8H10.48V9.35Z" fill="currentColor"/>
        @break

        @case('instagram')
            <rect x="4.2" y="4.2" width="15.6" height="15.6" rx="4.2" stroke="currentColor" stroke-width="2.2"/>
            <circle cx="12" cy="12" r="3.45" stroke="currentColor" stroke-width="2"/>
            <circle cx="16.25" cy="7.75" r="1.25" fill="currentColor"/>
        @break

        @default
            <circle cx="12" cy="12" r="8" fill="currentColor"/>
    @endswitch
</svg>
