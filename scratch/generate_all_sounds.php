<?php

$soundsDir = __DIR__ . '/../public/sounds';
if (!is_dir($soundsDir)) {
    mkdir($soundsDir, 0755, true);
}

function generateWav($filename, $sampleRate, $duration, $sampleGenerator) {
    $numSamples = (int)($sampleRate * $duration);
    $samples = [];
    
    for ($i = 0; $i < $numSamples; $i++) {
        $t = $i / $sampleRate;
        $val = $sampleGenerator($t, $duration);
        $val = max(-1.0, min(1.0, $val));
        $valInt = (int)($val * 32767);
        $samples[] = pack('v', $valInt);
    }
    
    $data = implode('', $samples);
    $dataSize = strlen($data);
    
    $header = 'RIFF';
    $header .= pack('V', 36 + $dataSize);
    $header .= 'WAVE';
    $header .= 'fmt ';
    $header .= pack('V', 16);
    $header .= pack('v', 1); // Mono PCM
    $header .= pack('v', 1); 
    $header .= pack('V', $sampleRate);
    $header .= pack('V', $sampleRate * 2);
    $header .= pack('v', 2);
    $header .= pack('v', 16);
    $header .= 'data';
    $header .= pack('V', $dataSize);
    
    $content = $header . $data;
    file_put_contents($filename, $content);
}

$sampleRate = 44100;

// 1. Default Chime (hyst_notification.mp3)
generateWav($soundsDir . '/hyst_notification.mp3', $sampleRate, 0.5, function($t) {
    if ($t < 0.2) {
        $freq = 659.25; // E5
        $env = sin(M_PI * ($t / 0.2));
    } else {
        $freq = 987.77; // B5
        $tRel = ($t - 0.2) / 0.3;
        $env = exp(-4 * $tRel);
    }
    return sin(2 * M_PI * $freq * $t) * $env * 0.6;
});

// 2. Cash Register (cash_register.mp3)
generateWav($soundsDir . '/cash_register.mp3', $sampleRate, 0.6, function($t) {
    if ($t < 0.15) {
        $freq = 523.25; // C5
        $env = sin(M_PI * ($t / 0.15));
    } elseif ($t < 0.3) {
        $freq = 659.25; // E5
        $env = sin(M_PI * (($t - 0.15) / 0.15));
    } else {
        $freq = 1046.50; // C6
        $tRel = ($t - 0.3) / 0.3;
        $env = exp(-5 * $tRel);
    }
    return sin(2 * M_PI * $freq * $t) * $env * 0.7;
});

// 3. Loud Alarm (loud_alarm.mp3)
generateWav($soundsDir . '/loud_alarm.mp3', $sampleRate, 0.8, function($t) {
    $cycle = fmod($t, 0.2);
    $freq = ($cycle < 0.1) ? 1200 : 1600;
    $env = 0.8;
    return sin(2 * M_PI * $freq * $t) * $env;
});

// 4. Service Bell (bell_ring.mp3)
generateWav($soundsDir . '/bell_ring.mp3', $sampleRate, 0.7, function($t) {
    $freq = 880.0; // A5
    $overtone = 1760.0; // A6
    $env = exp(-4 * $t);
    return (sin(2 * M_PI * $freq * $t) * 0.7 + sin(2 * M_PI * $overtone * $t) * 0.3) * $env;
});

echo "All 4 ringtone files generated in public/sounds/\n";
