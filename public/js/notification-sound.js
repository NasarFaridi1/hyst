/**
 * HYST Global Notification Sound Engine
 * Handles playing audio for all normal & FCM notifications across iOS Safari, Android Chrome, and Desktop.
 */
(function() {
    let globalAudioCtx = null;

    function getAudioContext() {
        if (!globalAudioCtx) {
            const AudioCtx = window.AudioContext || window.webkitAudioContext;
            if (AudioCtx) {
                globalAudioCtx = new AudioCtx();
            }
        }
        if (globalAudioCtx && globalAudioCtx.state === 'suspended') {
            globalAudioCtx.resume();
        }
        return globalAudioCtx;
    }

    // Unlock AudioContext on first user interaction (Essential for iOS Safari & Android Chrome)
    function unlockAudioOnInteraction() {
        const ctx = getAudioContext();
        if (ctx) {
            ctx.resume().then(() => {
                console.log('[HYST Sound] AudioContext unlocked for iOS/Android.');
            }).catch(e => console.warn(e));
        }
        document.removeEventListener('touchstart', unlockAudioOnInteraction);
        document.removeEventListener('click', unlockAudioOnInteraction);
    }

    document.addEventListener('touchstart', unlockAudioOnInteraction, { once: true });
    document.addEventListener('click', unlockAudioOnInteraction, { once: true });

    window.playNotificationSound = function(options = {}) {
        console.log('[HYST Notification Sound] Playing audio notification on iOS/Android...');

        // Mobile Vibration API (Android & PWA supported)
        if ('vibrate' in navigator) {
            try {
                navigator.vibrate([200, 100, 200, 100, 200]);
            } catch(e) {}
        }

        // 1. Web Audio API Synthesizer (Instant, 0-latency, 100% reliable across iOS & Android)
        try {
            const ctx = getAudioContext();
            if (ctx) {
                // Signature HYST 2-Tone Chime (E5: 659.25Hz -> B5: 987.77Hz)
                const notes = [
                    { freq: 659.25, start: 0, duration: 0.18 },
                    { freq: 987.77, start: 0.18, duration: 0.35 }
                ];

                notes.forEach(n => {
                    const osc = ctx.createOscillator();
                    const gain = ctx.createGain();

                    osc.type = 'sine';
                    osc.frequency.setValueAtTime(n.freq, ctx.currentTime + n.start);

                    gain.gain.setValueAtTime(0, ctx.currentTime + n.start);
                    gain.gain.linearRampToValueAtTime(0.4, ctx.currentTime + n.start + 0.02);
                    gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + n.start + n.duration);

                    osc.connect(gain);
                    gain.connect(ctx.destination);

                    osc.start(ctx.currentTime + n.start);
                    osc.stop(ctx.currentTime + n.start + n.duration);
                });
            }
        } catch(e) {
            console.warn('[HYST Sound] Web Audio error:', e);
        }

        // 2. HTML5 Audio File Playback (/sounds/hyst_notification.mp3)
        try {
            const audioPath = options.soundUrl || (typeof window.RESTAURANT_SOUND_URL !== 'undefined' && window.RESTAURANT_SOUND_URL ? window.RESTAURANT_SOUND_URL : '/sounds/hyst_notification.mp3');
            const audio = new Audio(audioPath);
            audio.volume = options.volume || 1.0;
            const promise = audio.play();
            if (promise !== undefined) {
                promise.catch(err => {
                    console.log('[HYST Sound] HTML5 Audio autoplay policy catch; Web Audio synth played.');
                });
            }
        } catch(e) {
            console.warn('[HYST Sound] Audio file error:', e);
        }
    };
})();
