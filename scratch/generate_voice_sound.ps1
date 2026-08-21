Add-Type -AssemblyName System.Speech

# 1. HYST Notification (Short Voice)
$synth1 = New-Object System.Speech.Synthesis.SpeechSynthesizer
$synth1.Rate = 0
$synth1.Volume = 100
$wav1 = "c:\hyst\public\sounds\hyst_voice.wav"
$mp31 = "c:\hyst\public\sounds\hyst_voice.mp3"
$synth1.SetOutputToWaveFile($wav1)
$synth1.Speak("HYST Notification")
$synth1.Dispose()
Copy-Item $wav1 $mp31 -Force

# 2. HYST Notification - New Order Received
$synth2 = New-Object System.Speech.Synthesis.SpeechSynthesizer
$synth2.Rate = 0
$synth2.Volume = 100
$wav2 = "c:\hyst\public\sounds\hyst_voice_order.wav"
$mp32 = "c:\hyst\public\sounds\hyst_voice_order.mp3"
$synth2.SetOutputToWaveFile($wav2)
$synth2.Speak("HYST Notification. New order received!")
$synth2.Dispose()
Copy-Item $wav2 $mp32 -Force

Write-Host "Voice Notification MP3 Audio files created successfully!"
