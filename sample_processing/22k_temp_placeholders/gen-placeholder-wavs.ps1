# Generate placeholder stim for ratesounds
# inspired strongly by https://mcpmag.com/articles/2018/03/07/talking-through-powershell.aspx
# and worse speech synthesizer in linux espeak
#
# Due to restrictions in powershell .ps1 execution this is easiest to run
# by opening up powershell manually and copy-pasting the commands
#

Add-Type -AssemblyName System.speech
$speak = New-Object System.Speech.Synthesis.SpeechSynthesizer

$speak.SetOutputToWaveFile("$($PWD)\long1.wav")
$speak.Speak("long r example 1")
$speak.SetOutputToWaveFile("$($PWD)\long2.wav")
$speak.Speak("long r example 2")
$speak.SetOutputToWaveFile("$($PWD)\long3.wav")
$speak.Speak("long r example 3")
$speak.SetOutputToWaveFile("$($PWD)\long4.wav")
$speak.Speak("long r example 4")
$speak.SetOutputToWaveFile("$($PWD)\long5.wav")
$speak.Speak("long r example 5")

$speak.SetOutputToWaveFile("$($PWD)\practice1.wav")
$speak.Speak("practice 1")
$speak.SetOutputToWaveFile("$($PWD)\practice2.wav")
$speak.Speak("practice 2")
$speak.SetOutputToWaveFile("$($PWD)\practice3.wav")
$speak.Speak("practice 3")
$speak.SetOutputToWaveFile("$($PWD)\practice4.wav")
$speak.Speak("practice 4")
$speak.SetOutputToWaveFile("$($PWD)\practice5.wav")
$speak.Speak("practice 5")


$speak.SetOutputToWaveFile("$($PWD)\sample1.wav")
$speak.Speak("sample rr 1")
$speak.SetOutputToWaveFile("$($PWD)\sample2.wav")
$speak.Speak("sample rrrh 2")
$speak.SetOutputToWaveFile("$($PWD)\sample3.wav")
$speak.Speak("sample rrsh 3")
$speak.SetOutputToWaveFile("$($PWD)\sample4.wav")
$speak.Speak("sample sshr 4")
$speak.SetOutputToWaveFile("$($PWD)\sample5.wav")
$speak.Speak("sample rrt 5")
$speak.SetOutputToWaveFile("$($PWD)\sample6.wav")
$speak.Speak("sample sr 6")
$speak.SetOutputToWaveFile("$($PWD)\sample7.wav")
$speak.Speak("sample rt 7")
$speak.SetOutputToWaveFile("$($PWD)\sample8.wav")
$speak.Speak("sample r 8")


# reset output
$speak.SetOutputToDefaultAudioDevice()


