/**
 * HYST Global Notification Sound Engine
 * Handles playing audio for custom ringtones & notifications across iOS Safari, Android Chrome, and Desktop.
 */
(function() {
    let globalAudioCtx = null;
    const soundBufferCache = {};

    function getAudioContext() {
        if (!globalAudioCtx) {
            const AudioCtx = window.AudioContext || window.webkitAudioContext;
            if (AudioCtx) {
                globalAudioCtx = new AudioCtx();
            }
        }
        if (globalAudioCtx && globalAudioCtx.state === 'suspended') {
            globalAudioCtx.resume().catch(e => console.warn(e));
        }
        return globalAudioCtx;
    }

    // Helper: Pre-fetch & decode custom sound buffer into Web Audio API (Essential for 0-latency iOS/Android playback)
    function preloadSoundBuffer(soundUrl) {
        if (!soundUrl || soundBufferCache[soundUrl]) return;
        const ctx = getAudioContext();
        if (!ctx) return;

        fetch(soundUrl)
            .then(res => res.arrayBuffer())
            .then(arrayBuffer => ctx.decodeAudioData(arrayBuffer))
            .then(audioBuffer => {
                soundBufferCache[soundUrl] = audioBuffer;
                console.log('[HYST Sound] Preloaded & decoded audio buffer for:', soundUrl);
            })
            .catch(e => console.warn('[HYST Sound] Audio preload error:', e));
    }

    // Unlock AudioContext & Prime Audio Engine on first user touch/click (Essential for iOS Safari & Android Chrome)
    function unlockAudioOnInteraction() {
        const ctx = getAudioContext();
        if (ctx) {
            ctx.resume().then(() => {
                console.log('[HYST Sound] AudioContext unlocked for iOS/Android.');
                if (window.RESTAURANT_SOUND_URL) {
                    preloadSoundBuffer(window.RESTAURANT_SOUND_URL);
                }
            }).catch(e => console.warn(e));
        }
        document.removeEventListener('touchstart', unlockAudioOnInteraction);
        document.removeEventListener('click', unlockAudioOnInteraction);
    }

    document.addEventListener('touchstart', unlockAudioOnInteraction, { once: true });
    document.addEventListener('click', unlockAudioOnInteraction, { once: true });

    window.playNotificationSound = function(options = {}) {
        console.log('[HYST Notification Sound] Triggering sound playback...', options);

        // Mobile Vibration API (Android & PWA supported)
        if ('vibrate' in navigator) {
            try {
                navigator.vibrate([200, 100, 200, 100, 200]);
            } catch(e) {}
        }

        // Determine sound URL
        let soundUrl = options.soundUrl || (typeof window.RESTAURANT_SOUND_URL !== 'undefined' && window.RESTAURANT_SOUND_URL ? window.RESTAURANT_SOUND_URL : '/sounds/hyst_notification.mp3');
        
        // Ensure relative URLs point to valid sound assets
        if (soundUrl && !soundUrl.startsWith('http://') && !soundUrl.startsWith('https://') && !soundUrl.startsWith('/')) {
            soundUrl = '/sounds/' + soundUrl;
        }

        let playedViaWebAudio = false;

        // 1. Try Web Audio API Buffer Playback (0-latency, 100% reliable on iOS & Android if preloaded/decoded)
        try {
            const ctx = getAudioContext();
            if (ctx && soundBufferCache[soundUrl]) {
                const source = ctx.createBufferSource();
                source.buffer = soundBufferCache[soundUrl];
                const gainNode = ctx.createGain();
                gainNode.gain.value = options.volume || 1.0;
                source.connect(gainNode);
                gainNode.connect(ctx.destination);
                source.start(0);
                playedViaWebAudio = true;
                console.log('[HYST Sound] Played via Web Audio Buffer Node:', soundUrl);
            }
        } catch(e) {
            console.warn('[HYST Sound] Web Audio Buffer playback error:', e);
        }

        // 2. HTML5 Audio File Playback (Direct MP3/WAV playback)
        try {
            const audio = new Audio(soundUrl);
            audio.volume = options.volume || 1.0;
            const promise = audio.play();
            if (promise !== undefined) {
                promise.then(() => {
                    console.log('[HYST Sound] Played via HTML5 Audio:', soundUrl);
                }).catch(err => {
                    console.log('[HYST Sound] HTML5 Audio play error/policy restriction:', err);
                    if (!playedViaWebAudio && (!soundUrl || soundUrl.includes('hyst_notification.mp3'))) {
                        playSynthChimeFallback();
                    }
                });
            }
        } catch(e) {
            console.warn('[HYST Sound] HTML5 Audio error:', e);
            if (!playedViaWebAudio) {
                playSynthChimeFallback();
            }
        }

        // If not preloaded, trigger background preload for next notification
        if (soundUrl && !soundBufferCache[soundUrl]) {
            preloadSoundBuffer(soundUrl);
        }
    };

    function playSynthChimeFallback() {
        try {
            const ctx = getAudioContext();
            if (ctx) {
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
        } catch(e) {}
    }
})();
