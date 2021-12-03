% Read in subjects folder for ratesounds data
% original: 182 stimuli per one full evaluation, resulting output files 0.csv .. 181.csv 
% in the server-side (0.csv<=>sample0 etc)
% currently made with 22 stimuli (5 long + 5 practice + 12 actual)
%
% Simple usage: place the subjects\ folder copied from the server to the same
% folder where this script resides, the folder layout should look like
% this:
%
% read_subjects_dir_and_export.m
% subjects\
%    12348\
%         0.csv
%         1.csv
%         ...
%         data.txt
%    234789\
%         0.csv
%         ...
%
% Then, run the Matlab script. The script should write two Excel files with data
% collected from single CSV files (see below for the format, by default
% subjects_parsed.xlsx and a date-stamp copy).
%
% N.B. overwrites data in output files BUT should retain e.g. column width 
% formatting etc.
%
% 2021-11-29 english translation for rateosunds
% 2020-11-10 new version for ratesounds
% 2019-12-20 fixed issue with ratings overflowing to next line with
%            subjects with no ratings
% 2019-10-08 added datestr to additional output file, end result in style of 
%            "subjects_parsed_2019-10-08.xlsx"
% 2019-10-04 (unsuccessful) test with writetable, keep xlswrite, add some
%            comments
% 2019-10-03 initial version by jaakko.kauramaki@helsinki.fi
% 

datadir='subjects'; % location of subjects dir
outputfile='subjects_parsed.xlsx'; % where to store the output
outputfile2=['subjects_parsed_' datestr(datetime,29) '.xlsx']; % make a date-stamp copy
N_stimuli=22; % originally 182, github version less e.g. 22
N_long_samples=5; % number of long samples in the beginning, originally 12; github version 5

% zero-based background info, based on PHP code parser,
% specifically, compare the background information to questions defined in
% addme.php and register.php

bg_header={};
% English / background question 1: hearing disorder
bg_header{1}={'Normal hearing','Mild hearing loss','Moderate hearing loss','Severe hearing loss','Profound hearing loss'};
% Finnish / background question 1: kuulovika
%bg_header{1}={'Normaali kuulo','Lievä kuulovika','Keskivaikea kuulovika','Vaikea kuulovika','Erittäin vaikea kuulovika'};
% English / background question 2:experience on speech-language pathologist work
bg_header{2}={'student','1-3 year experience','3-5 year experience','over 5 years of experience'};
% Finnish / background question 2:kokemus puheterapeutin työstä
%bg_header{2}={'opiskelija','1-3 –vuoden työkokemus','3-5 –vuoden työkokemus','yli 5 vuoden työkokemus'};
% English/ background question 3:
bg_header{3}={'headphones','computer or mobile device speakers'};
% Finnish / background question 3:tekotapa
%bg_header{3}={'kuulokkeilla','tietokoneen tai mobiililaitteen kaiuttimilla'};


% create excel header row for sheet 1 with background + other information
%xls_header={'koehenkilökoodi','rekisteröitynyt','tehty%','käytetty aika','kommentit',...
%    'kuulovika','kokemus','tekotapa'}; % Finnish
xls_header={'subject number','registered','complete%','used time','comments',...
    'hearing','SLP experience','audio playback'}; % Finnish

% for single audio files / videos / other stimuli (sheet 2), header row with other info
annot_header={};
%annot_header{1}='koehenkilökoodi'; % Finnish
annot_header{1}='subject number';
for i=1:N_stimuli
    annot_header{i+1}=['sample ' num2str(i-1)]; %#ok<SAGROW>
end

if ~exist(outputfile,'file')
%    writetable(table(xls_header),outputfile,'Sheet',1,'Range','A1','WriteRowNames',false,'UseExcel',true); % optional 'UseExcel',true|false
% xlswrite "not recommended" (as of Matlab R2019a) ... but still way faster /
% less buggier than writetable, above writetable() single line write with
% Matlab R2018b froze / left xlsx in locked state for the same file where 
% xlswrite write went on just file
    xlswrite(outputfile,xls_header,1,'A1');
    xlswrite(outputfile,annot_header,2,'A1');
end

tmp_list=dir(datadir);
subj_codes=[];
% parse through directory
for i=1:numel(tmp_list)
    if tmp_list(i).isdir && ~isnan(str2double(tmp_list(i).name))
        subj_codes(end+1)=str2double(tmp_list(i).name); %#ok<SAGROW>
    end
end

% read in background data file 
clear tmp_list;
for i=1:numel(subj_codes)
    tmp=dir([datadir filesep num2str(subj_codes(i)) filesep 'data.txt']);
    tmp_list(i)=tmp(1); %#ok<SAGROW>
end


% sort by date, ascending
[~,sort_idx]=sort([tmp_list.datenum]);
subj_codes=subj_codes(sort_idx);


for s=1:numel(subj_codes)
    subj=subj_codes(s);
    bg_data=dlmread([datadir filesep num2str(subj) filesep 'data.txt']);
    if numel(bg_data)<7
        bg_data(7)=0; % for early subjects less background questions, replace with default value
    end 
    tmp_list=dir([datadir filesep num2str(subj) filesep 'data.txt']);
    regdate=datetime(tmp_list(1).datenum,'ConvertFrom','datenum');
    %regdate.Format='uuuu-MM-dd HH:mm:ss'; % not needed

    % read in possible comments
    comments="";
    if exist([datadir filesep num2str(subj) filesep 'comments.txt'],'file')
        f=fopen([datadir filesep num2str(subj) filesep 'comments.txt'],'r','n','UTF-8');
        comments=fread(f,'*char')';
        fclose(f);
    end

    % read in actual data
    tmp_list=dir([datadir filesep num2str(subj) filesep '*.csv']);
    
    maxdate=regdate;
    annot_data={};
    for i=1:N_stimuli
        annot_data{i}=""; %#ok<SAGROW> % initialize all to empty strings
    end
    for i=1:numel(tmp_list)
        if datetime(tmp_list(i).datenum,'ConvertFrom','datenum')>maxdate
            maxdate=datetime(tmp_list(i).datenum,'ConvertFrom','datenum');
        end
        % 0-based csv files (0-99) vs. matlab requirements of one-based
        % (1-100)
        sentence_num=str2double(tmp_list(i).name(1:strfind(tmp_list(i).name,'.csv')-1))+1;
        f=fopen([datadir filesep num2str(subj) filesep tmp_list(i).name],'r','n','UTF-8');
        sentence_data=fread(f,'*char')';
        split_data=strsplit(sentence_data,';');
        fclose(f);
        if ~isnan(sentence_num)
            if (sentence_num<=N_long_samples)
                if (numel(split_data{3})==0)
                    annot_data{sentence_num}=split_data{2}; % only category number, e.g. '4'
                else
                    annot_data{sentence_num}=[split_data{2} ':' split_data{3}]; % category number:text, e.g. '8:muuta'
                end
            else
                annot_data{sentence_num}=split_data{1}; % only store numeric annotation 1-100
            end
        else
            disp(['error with subj ' num2str(subj) ' and file ' tmp_list(i).name]);
        end
    end
        
    dur=between(regdate,maxdate,'time');

    subj_row={};
    subj_row{1}=num2str(subj);
    subj_row{2}=datestr(regdate,31);
    subj_row{3}=sprintf('%.0f%%',numel(tmp_list)/N_stimuli*100);
    subj_row{4}=sprintf('%s',dur);
    subj_row{5}=comments;
    subj_row{6}=bg_header{1}{bg_data(1)+1}; % 0 vs 1-based;
    subj_row{7}=bg_header{2}{bg_data(2)+1}; % 0 vs 1-based;
    subj_row{8}=bg_header{3}{bg_data(3)+1}; % 0 vs 1-based;

    % slow row-to-row write..
    xlswrite(outputfile,subj_row,1,['A' num2str(s+1)]);
    xlswrite(outputfile,{subj_row{1}},2,['A' num2str(s+1)]);
    xlswrite(outputfile,annot_data,2,['B' num2str(s+1)]);
end

% make a copy of the file with date & time
[succ,msg,msgid]=copyfile(outputfile,outputfile2);