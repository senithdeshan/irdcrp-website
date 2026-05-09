<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Launching Soon | {{ config('app.name', 'IRDCRP') }}</title>
    <style>
        :root {
            --navy: #031529;
            --blue: #083b66;
            --cyan: #36d6ff;
            --aqua: #74f7ff;
            --white: #ffffff;
            --muted: rgba(226, 244, 255, 0.76);
            --glass: rgba(255, 255, 255, 0.105);
            --line: rgba(255, 255, 255, 0.18);
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            min-height: 100%;
        }

        body {
            margin: 0;
            font-family: "Segoe UI", system-ui, -apple-system, BlinkMacSystemFont, Arial, sans-serif;
            color: var(--white);
            background:
                radial-gradient(circle at 18% 18%, rgba(54, 214, 255, 0.24), transparent 28rem),
                radial-gradient(circle at 86% 12%, rgba(116, 247, 255, 0.18), transparent 24rem),
                radial-gradient(circle at 50% 100%, rgba(20, 184, 166, 0.18), transparent 28rem),
                linear-gradient(135deg, var(--navy) 0%, #05233d 45%, #020b18 100%);
            overflow-x: hidden;
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            pointer-events: none;
            background:
                linear-gradient(90deg, rgba(255, 255, 255, 0.055) 0 1px, transparent 1px 100%),
                linear-gradient(180deg, rgba(255, 255, 255, 0.045) 0 1px, transparent 1px 100%);
            background-size: 76px 76px;
            mask-image: radial-gradient(circle at center, black, transparent 76%);
        }

        .page {
            position: relative;
            min-height: 100svh;
            display: grid;
            place-items: center;
            padding: 32px 16px;
        }

        .glow {
            position: fixed;
            width: 360px;
            height: 360px;
            border-radius: 999px;
            filter: blur(24px);
            opacity: 0.26;
            pointer-events: none;
            animation: floatGlow 8s ease-in-out infinite;
        }

        .glow.one {
            left: -120px;
            top: 10%;
            background: var(--cyan);
        }

        .glow.two {
            right: -140px;
            bottom: 8%;
            background: #7dd3fc;
            animation-delay: -3s;
        }

        .card {
            width: min(100%, 1040px);
            position: relative;
            overflow: hidden;
            border: 1px solid var(--line);
            border-radius: 34px;
            background:
                linear-gradient(145deg, rgba(255, 255, 255, 0.14), rgba(255, 255, 255, 0.06)),
                rgba(3, 21, 41, 0.62);
            box-shadow:
                0 34px 90px rgba(0, 0, 0, 0.42),
                0 0 80px rgba(54, 214, 255, 0.16),
                inset 0 1px 0 rgba(255, 255, 255, 0.22);
            backdrop-filter: blur(22px);
        }

        .card::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            background:
                radial-gradient(circle at 20% 0%, rgba(116, 247, 255, 0.18), transparent 32%),
                linear-gradient(90deg, rgba(255, 255, 255, 0.08), transparent 18%, transparent 82%, rgba(255, 255, 255, 0.06));
        }

        .inner {
            position: relative;
            display: grid;
            gap: 36px;
            padding: clamp(28px, 5vw, 58px);
        }

        .brand {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 14px;
        }

        .logo {
            width: 72px;
            height: 72px;
            display: grid;
            place-items: center;
            border: 1px solid rgba(255, 255, 255, 0.22);
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.96);
            box-shadow: 0 18px 42px rgba(0, 0, 0, 0.24);
        }

        .logo img {
            max-width: 82%;
            max-height: 82%;
            object-fit: contain;
        }

        .brand-text span {
            display: inline-flex;
            margin-bottom: 8px;
            border: 1px solid rgba(116, 247, 255, 0.38);
            border-radius: 999px;
            padding: 7px 12px;
            color: var(--aqua);
            background: rgba(54, 214, 255, 0.08);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.2em;
            text-transform: uppercase;
        }

        .brand-text strong {
            display: block;
            font-size: clamp(18px, 2vw, 25px);
            line-height: 1.15;
            letter-spacing: -0.02em;
        }

        .content {
            display: grid;
            gap: 30px;
        }

        h1 {
            margin: 0;
            max-width: 820px;
            font-size: clamp(40px, 7vw, 84px);
            line-height: 0.98;
            letter-spacing: -0.055em;
            text-wrap: balance;
        }

        .message {
            max-width: 680px;
            margin: 0;
            color: var(--muted);
            font-size: clamp(17px, 2vw, 22px);
            line-height: 1.7;
        }

        .message strong {
            color: #ffffff;
            font-weight: 700;
        }

        .countdown {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 12px;
            max-width: 760px;
            transition: opacity 0.45s ease, transform 0.45s ease, max-height 0.45s ease;
        }

        .countdown.is-hidden {
            max-height: 0;
            opacity: 0;
            transform: translateY(12px);
            overflow: hidden;
            pointer-events: none;
        }

        .time-box {
            min-height: 118px;
            display: grid;
            align-content: center;
            justify-items: center;
            border: 1px solid rgba(116, 247, 255, 0.22);
            border-radius: 24px;
            background:
                linear-gradient(180deg, rgba(255, 255, 255, 0.14), rgba(255, 255, 255, 0.06)),
                rgba(255, 255, 255, 0.06);
            box-shadow:
                0 16px 40px rgba(0, 0, 0, 0.18),
                inset 0 1px 0 rgba(255, 255, 255, 0.16);
        }

        .time-box b {
            color: var(--white);
            font-size: clamp(30px, 5vw, 52px);
            line-height: 1;
            letter-spacing: -0.04em;
            text-shadow: 0 0 26px rgba(54, 214, 255, 0.34);
        }

        .time-box span {
            margin-top: 10px;
            color: rgba(226, 244, 255, 0.68);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.18em;
            text-transform: uppercase;
        }

        .status-row {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 12px;
            color: rgba(226, 244, 255, 0.72);
            font-size: 14px;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            border: 1px solid rgba(116, 247, 255, 0.24);
            border-radius: 999px;
            padding: 10px 14px;
            background: rgba(255, 255, 255, 0.07);
            color: rgba(255, 255, 255, 0.9);
            font-weight: 700;
        }

        .status-pill::before {
            content: "";
            width: 10px;
            height: 10px;
            border-radius: 999px;
            background: var(--cyan);
            box-shadow: 0 0 0 6px rgba(54, 214, 255, 0.1), 0 0 24px rgba(54, 214, 255, 0.72);
            animation: pulse 1.8s ease-in-out infinite;
        }

        .live-panel {
            display: none;
            max-width: 760px;
            border: 1px solid rgba(116, 247, 255, 0.26);
            border-radius: 28px;
            padding: clamp(22px, 4vw, 34px);
            background:
                linear-gradient(145deg, rgba(116, 247, 255, 0.16), rgba(255, 255, 255, 0.08)),
                rgba(255, 255, 255, 0.07);
            box-shadow:
                0 22px 56px rgba(0, 0, 0, 0.26),
                0 0 60px rgba(54, 214, 255, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.18);
        }

        .live-panel.is-visible {
            display: block;
            animation: fadeLiveIn 0.75s cubic-bezier(0.22, 1, 0.36, 1) both;
        }

        .live-panel h2 {
            margin: 0;
            font-size: clamp(32px, 5vw, 60px);
            line-height: 1.05;
            letter-spacing: -0.04em;
            text-shadow: 0 0 32px rgba(54, 214, 255, 0.34);
        }

        .live-panel p {
            margin: 14px 0 0;
            color: var(--muted);
            font-size: 16px;
            line-height: 1.65;
        }

        .enter-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-top: 24px;
            border: 1px solid rgba(116, 247, 255, 0.42);
            border-radius: 999px;
            padding: 14px 24px;
            color: #031529;
            background: linear-gradient(135deg, #74f7ff, #36d6ff);
            box-shadow: 0 16px 36px rgba(54, 214, 255, 0.26);
            font-weight: 900;
            text-decoration: none;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .enter-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 22px 48px rgba(54, 214, 255, 0.34);
        }

        @keyframes pulse {
            50% {
                transform: scale(1.25);
                opacity: 0.74;
            }
        }

        @keyframes floatGlow {
            50% {
                transform: translateY(-24px) scale(1.08);
            }
        }

        @keyframes fadeLiveIn {
            from {
                opacity: 0;
                transform: translateY(18px) scale(0.98);
                filter: blur(8px);
            }
            to {
                opacity: 1;
                transform: none;
                filter: blur(0);
            }
        }

        @media (max-width: 720px) {
            .page {
                padding: 18px;
            }

            .card {
                border-radius: 26px;
            }

            .inner {
                padding: 24px;
            }

            .logo {
                width: 62px;
                height: 62px;
                border-radius: 18px;
            }

            .countdown {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .time-box {
                min-height: 104px;
                border-radius: 20px;
            }
        }

        @media (max-width: 420px) {
            .countdown {
                gap: 10px;
            }

            .time-box {
                min-height: 92px;
            }
        }
    </style>
</head>
<body>
    <main class="page">
        <span class="glow one" aria-hidden="true"></span>
        <span class="glow two" aria-hidden="true"></span>

        <section class="card" aria-labelledby="launch-title">
            <div class="inner">
                <header class="brand">
                    <div class="logo">
                        <img src="{{ asset(config('irdcrp.logos.irdcrp', 'images/irdcrp-logo.png')) }}" alt="IRDCRP logo">
                    </div>
                    <div class="brand-text">
                        <span>Official launch</span>
                        <strong>{{ config('irdcrp.project_name.en', config('app.name', 'IRDCRP')) }}</strong>
                    </div>
                </header>

                <div class="content">
                    <div>
                        <h1 id="launch-title">Launching soon.</h1>
                        <p class="message">
                            <strong>We are preparing something special.</strong> Our official website will launch soon.
                        </p>
                    </div>

                    <div class="countdown" id="countdown" aria-label="Countdown to launch">
                        <div class="time-box"><b id="days">00</b><span>Days</span></div>
                        <div class="time-box"><b id="hours">00</b><span>Hours</span></div>
                        <div class="time-box"><b id="minutes">00</b><span>Minutes</span></div>
                        <div class="time-box"><b id="seconds">00</b><span>Seconds</span></div>
                    </div>

                    <div class="live-panel" id="live-panel" aria-live="polite">
                        <h2>🚀 We Are Live Now</h2>
                        <p>The official website is ready. Thank you for waiting while we prepared the launch.</p>
                        <a href="/" class="enter-button">Enter Website</a>
                    </div>

                    <div class="status-row">
                        <span class="status-pill">Final checks in progress</span>
                        <span id="launch-date-text">Launch date will be announced soon.</span>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        (function () {
            // TEMPORARY TEST TIMER: change back to the real launch date/time after testing.
            var launchDate = new Date(Date.now() + 300000);
            var labels = {
                days: document.getElementById('days'),
                hours: document.getElementById('hours'),
                minutes: document.getElementById('minutes'),
                seconds: document.getElementById('seconds'),
                launchText: document.getElementById('launch-date-text'),
                countdown: document.getElementById('countdown'),
                livePanel: document.getElementById('live-panel')
            };
            var finished = false;

            function pad(value) {
                return String(value).padStart(2, '0');
            }

            function updateDateText() {
                try {
                    labels.launchText.textContent = 'Launching on ' + new Intl.DateTimeFormat('en-LK', {
                        dateStyle: 'full',
                        timeStyle: 'short',
                        timeZone: 'Asia/Colombo'
                    }).format(launchDate);
                } catch (error) {
                    labels.launchText.textContent = 'Launching soon.';
                }
            }

            function tick() {
                var diff = Math.max(0, launchDate.getTime() - Date.now());

                var totalSeconds = Math.ceil(diff / 1000);
                var days = Math.floor(totalSeconds / 86400);
                var hours = Math.floor((totalSeconds % 86400) / 3600);
                var minutes = Math.floor((totalSeconds % 3600) / 60);
                var seconds = totalSeconds % 60;

                labels.days.textContent = pad(days);
                labels.hours.textContent = pad(hours);
                labels.minutes.textContent = pad(minutes);
                labels.seconds.textContent = pad(seconds);

                if (totalSeconds === 0) {
                    if (finished) {
                        return;
                    }
                    finished = true;
                    labels.launchText.textContent = 'Launch day has arrived.';
                    labels.countdown.classList.add('is-hidden');
                    labels.livePanel.classList.add('is-visible');
                    return;
                }
            }

            updateDateText();
            tick();
            window.setInterval(tick, 1000);
        })();
    </script>
</body>
</html>
