<?php

$sampleRate = 44100;
$duration = 0.5; // half second total
$numSamples = (int)($sampleRate * $duration);

$outputFile = __DIR__ . '/../../public/sounds/hyst_notification.mp3';
$outputWav = __DIR__ . '/../../public/sounds/notification.wav';
$outputMp3Name = __DIR__ . '/../../public/sounds/notification.mp3';

if (!is_dir(dirname($outputFile))) {
    mkdir(dirname($outputFile), 0755, true);
}

// Generate two-tone chime samples (0.0-0.2s: 659.25Hz E5, 0.2-0.5s: 987.77Hz B5)
$samples = [];
for ($i = 0; $i < $numSamples; $i++) {
    $t = $i / $sampleRate;
    if ($t < 0.2) {
        $freq = 659.25; // E5
        $env = sin(M_PI * ($t / 0.2)); // smooth envelope
    } else {
        $freq = 987.77; // B5
        $tRel = ($t - 0.2) / 0.3;
        $env = exp(-4 * $tRel); // exponential decay
    }
    
    $val = sin(2 * M_PI * $freq * $t) * $env * 0.5;
    $valInt = (int)($val * 32767);
    $samples[] = pack('v', $valInt);
}

$data = implode('', $samples);
$dataSize = strlen($data);
$header = '';

// RIFF header
$header .= 'RIFF';
$header .= pack('V', 36 + $dataSize);
$header .= 'WAVE';

// Subchunk 1: fmt
$header .= 'fmt ';
$header .= pack('V', 16); // Subchunk1Size (16 for PCM)
$header .= pack('v', 1);  // AudioFormat (1 for PCM)
$header .= pack('v', 1);  // NumChannels (1 = Mono)
$header .= pack('V', $sampleRate); // SampleRate
$header .= pack('V', $sampleRate * 2); // ByteRate
$header .= pack('v', 2);  // BlockAlign
$header .= pack('v', 16); // BitsPerSample

// Subchunk 2: data
$header .= 'data';
$header .= pack('V', $dataSize);

$wavContent = $header . $data;

file_put_contents($outputWav, $wavContent);
file_put_contents($outputFile, $wavContent); // Works as audio source across HTML5 <audio>
file_put_contents($outputMp3Name, $wavContent);

echo "Notification audio files created successfully in public/sounds/\n";
