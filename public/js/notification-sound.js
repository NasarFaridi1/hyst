/**
 * HYST Global Notification Sound Engine
 * Handles playing audio for all normal & FCM notifications across the platform.
 */
(function() {
    window.playNotificationSound = function(options = {}) {
        console.log('[HYST Notification Sound] Playing audio notification...');

        // 1. Web Audio API Synthesizer (Instant, 0-latency, 100% reliable)
        try {
            const AudioCtx = window.AudioContext || window.webkitAudioContext;
            if (AudioCtx) {
                const ctx = new AudioCtx();
                if (ctx.state === 'suspended') {
                    ctx.resume();
                }

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
            const audioPath = options.soundUrl || '/sounds/hyst_notification.mp3';
            const audio = new Audio(audioPath);
            audio.volume = options.volume || 1.0;
            const promise = audio.play();
            if (promise !== undefined) {
                promise.catch(err => {
                    // Browser autoplay policy catch
                    console.log('[HYST Sound] HTML5 Audio autoplay policy prevented file playback; Web Audio synth played.');
                });
            }
        } catch(e) {
            console.warn('[HYST Sound] Audio file error:', e);
        }
    };
})();
