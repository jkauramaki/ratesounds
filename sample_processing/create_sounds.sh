#!/bin/bash
# Bash script to create short three time repeated sounds from ultrasound theraphy sampes
# Requires sox for audio concatenation + fade-in/fade-out, lame for wav => mp3 conversion
# Used in web experiment, filename obfuscation (sampleNNN.[mp3/wav]) due to this
# Output written under output/ directory, input/output correspondence to 
# ratesounds_key.txt
#
# 2021-11-12 simpler input directory format for github
# 2020-11-19 added normalization ( --norm )
# 2020-11-05 initial version by jaakko.kauramaki@helsinki.fi

# padding sounds
sox -n -r 48000 -c 2 sil_1s_48k.wav trim 0.0 1.0
sox -n -r 48000 -c 2 sil_3s_48k.wav trim 0.0 3.0
sox -n -r 44100 -c 2 sil_1s_44.1k.wav trim 0.0 1.0
sox -n -r 44100 -c 2 sil_3s_44.1k.wav trim 0.0 3.0

mkdir output

echo "orig_file;new_file">list.txt
# first create long sounds
i=0

for f in long_sounds/*; do
	echo $f / $i
	sox --norm $f tmp.wav fade h 0.005 0 0.005 # 5ms fade in and fade out
	sox sil_1s_48k.wav tmp.wav sil_3s_48k.wav tmp.wav sil_3s_48k.wav tmp.wav sil_1s_48k.wav output/sample$i.wav
	if [ ! -f output/sample$i.wav ]; then 
	# no output due to mismatching sampling rate? try out 44.1k as well
	sox sil_1s_44.1k.wav tmp.wav sil_3s_44.1k.wav tmp.wav sil_3s_44.1k.wav tmp.wav sil_1s_44.1k.wav output/sample$i.wav
	fi;
	lame -b 192k -h output/sample$i.wav output/sample$i.mp3
	echo "$f;sample$i.wav" >> list.txt
	i=$((i+1))
	rm tmp.wav # clean temp file to detect problems in output
done


# then, practice sounds
for f in practice_sounds/*; do
	echo $f / $i
	sox --norm $f tmp.wav fade h 0.005 0 0.005 # 5ms fade in and fade out
	sox sil_1s_48k.wav tmp.wav sil_3s_48k.wav tmp.wav sil_3s_48k.wav tmp.wav sil_1s_48k.wav output/sample$i.wav
	if [ ! -f output/sample$i.wav ]; then 
	# no output due to mismatching sampling rate? try out 44.1k as well
		sox sil_1s_44.1k.wav tmp.wav sil_3s_44.1k.wav tmp.wav sil_3s_44.1k.wav tmp.wav sil_1s_44.1k.wav output/sample$i.wav
	fi;
	lame -b 192k -h output/sample$i.wav output/sample$i.mp3
	echo "$f;sample$i.wav" >> list.txt
	i=$((i+1))
	rm tmp.wav # clean temp file to detect problems in output
done

# then, actual sounds
for f in samples_speech_sounds/*; do
	echo $f / $i
	sox --norm $f tmp.wav fade h 0.005 0 0.005 # 5ms fade in and fade out
	sox sil_1s_48k.wav tmp.wav sil_3s_48k.wav tmp.wav sil_3s_48k.wav tmp.wav sil_1s_48k.wav output/sample$i.wav
	if [ ! -f output/sample$i.wav ]; then 
	# no output due to mismatching sampling rate? try out 44.1k as well
		sox sil_1s_44.1k.wav tmp.wav sil_3s_44.1k.wav tmp.wav sil_3s_44.1k.wav tmp.wav sil_1s_44.1k.wav output/sample$i.wav
	fi;
	lame -b 192k -h output/sample$i.wav output/sample$i.mp3
	echo "$f;sample$i.wav" >> list.txt
	i=$((i+1))
	rm tmp.wav # clean temp file to detect problems in output
done


# finally, repeated control sounds

controls=(
"samples_speech_sounds/sample1.wav"
"samples_speech_sounds/sample2.wav"
"samples_speech_sounds/sample3.wav"
"samples_speech_sounds/sample4.wav"
)

# create control sounds
  for f in ${controls[*]}; do
     echo $f / $i
     sox --norm $f tmp.wav fade h 0.005 0 0.005 # 5ms fade in and fade out
     sox sil_1s_48k.wav tmp.wav sil_3s_48k.wav tmp.wav sil_3s_48k.wav tmp.wav sil_1s_48k.wav output/sample$i.wav
     if [ ! -f output/sample$i.wav ]; then 
       # no output due to mismatching sampling rate? try out 44.1k as well
       sox sil_1s_44.1k.wav tmp.wav sil_3s_44.1k.wav tmp.wav sil_3s_44.1k.wav tmp.wav sil_1s_44.1k.wav output/sample$i.wav
     fi;
     lame -b 192k -h output/sample$i.wav output/sample$i.mp3
     echo "$f;sample$i.wav" >> list.txt
     i=$((i+1))
	 rm tmp.wav # clean temp file to detect problems in output
  done


cp list.txt ratesounds_key.txt
