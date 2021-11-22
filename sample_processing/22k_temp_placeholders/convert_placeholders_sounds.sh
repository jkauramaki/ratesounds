# Bash source for converting 22050 Hz / mono sounds to 44.1k / stereo

for f in long*; do
   sox $f -r 44100 -e signed -c 2  ../long_sounds/$f
done

for f in prac*; do
   sox $f -r 44100 -e signed -c 2 ../practice_sounds/$f
done

for f in samp*; do
   sox $f -r 44100 -e signed -c 2 ../samples_speech_sounds/$f
done