% segment long 10-15min speech samples to shorter segments, normalize
% output files as well
%
% Req. Matlab R2020a+ because of detectSpeech() function
%
%
% 2021-11-29 cleaned up version for github
% 2020-10-08 fine-tuned parameters for lower quality session + 
%            added extraTime_* parameters to be added to the sound offset
% 2020-10-02 version for plain dir (all samples in one dir)
% 2020-09-08 initial version by jaakko.kauramaki@helsinki.fi


outdir='ultrasound-speechseg';
basedir='input_audio'; % short wav samples

% e.g. subj=1:2 / session=1:5 loop requires named like below to be found inside input_audio
% (zero-padding subject and session numbers is not mandatory)
%
% subj1_sess1_first.wav
% subj1_sess2.wav
% subj1_sess3.wav
% subj1_sess4.wav
% subj1_sess5_final_session.wav
% subj2_sess1_first.wav
% subj2_sess2.wav
% subj2_sess3.wav
% subj2_sess4.wav
% subj2_sess5.wav
% 
% => this creates output directory structure like below
%
% ultrasound-speechseg\subj1_sess01\
%                                   s1_sess01_sample001.wav
% 									s1_sess01_sample002.wav
%                                   [...]
% ultrasound-speechseg\subj1_sess02\
%                                   s2_sess01_sample001.wav
% 									s2_sess01_sample002.wav
%                                   [...]
% [...]

for subj=1:2
    for session=1:5
        
        dirlist=dir([basedir filesep 'subj*' num2str(subj) '*sess*' num2str(session) '*.wav']);
        if numel(dirlist)==0
            % try alternative spelling
            dirlist=dir([basedir filesep 'subj*' num2str(subj) '*kerta_' num2str(session) '*.wav']);
        end
        
        if numel(dirlist)==1
            fprintf('OK => found 1 file for subj %d / session %d: %s\n',subj,session,dirlist.name);
            
            
            [audioIn,fs] = audioread([basedir filesep dirlist.name]);
            audioInMono = audioIn(:,1);
            %detectSpeech(audioInMono,fs); % req. Matlab R2020a
            
            
            windowDuration = 0.1; % seconds
            numWindowSamples = round(windowDuration*fs);
            win = hamming(numWindowSamples,'periodic');
            
            percentOverlap = 30;
            overlap = round(numWindowSamples*percentOverlap/100);
            
            mergeDuration = 0.2; % seconds as well
            mergeDist = round(mergeDuration*fs);
            
            [speechIdx, thresholds] = detectSpeech(audioInMono,fs, ...
                'Window',win, ...
                'OverlapLength',percentOverlap, ...
                'MergeDistance',mergeDist);
            
            % subjNsessM better?
            full_outdir=[outdir filesep 'subj' num2str(subj) '_sess' sprintf('%02d',session)];
            if ~exist(full_outdir,'dir')
                mkdir(full_outdir);
            end
            
            extraTime_pre=0.1; % extra in seconds to be added to the beginning
            extraTime_post=0.1; % extra in seconds to be added to the end
            for i=1:size(speechIdx,1)
                sample=audioIn(max(1,speechIdx(i,1)-round(extraTime_post*fs)):min(size(audioIn,1),speechIdx(i,2)+round(extraTime_post*fs)),:);
                sample=0.999*sample./max(abs(sample(1:end))); % normalize on 0dB
                disp(['writing ' sprintf('s%d_sess%02d_sample%03d',subj,session,i) '.wav']);
                % output file name format subj1_sess09\s1_sess09_sample007.wav
                audiowrite([full_outdir filesep sprintf('s%d_sess%02d_sample%03d',subj,session,i) '.wav'],sample,fs);
                %soundsc(audioInMono(speechIdx(i,1):speechIdx(i,2)),fs);
                %pause;
            end
            
        elseif numel(dirlist)==0
            fprintf('Warning: 0 files found subj %d / session %d\n',subj,session);
        else
            error('Error: multiples files found subj %d / session %d\n',subj,session);
        end
        
    end
end