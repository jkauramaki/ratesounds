<?php
include('settings.php');
function makePresentation($pfpath){
	// 2020-11-05 special case of randomization for ratesounds
	// three groups, all shuffled within their group
	//
	// group 1: 0..n_long_samples-1
	//        c=0..4 => shuffled (long samples for categorization)
	//
	// group 2: n_long_samples..n_long_samples+n_practice_samples-1
	//        c=5..9 => shuffled (practice ratings)
    //
	// group 3: n_long_samples+n_practice_samples..Nstimuli-1
	//        c=10..21 => shuffled (the actual to-be-rated samples)
	
    global $Nstimuli,$n_long_samples,$n_practice_samples;
    $temp=array();
    $counter=0;
	// first, the long sounds (N=12 or so)
    for($c=0;$c<$n_long_samples;$c++)
    {
        $temp[$counter]=$c;
        $counter++;
    }
    shuffle($temp);
	
    $pfh=fopen($pfpath,'w');     // presentation file handle
    foreach($temp as $line)
        fwrite($pfh,"$line\n");

	// then, the 5 practise sounds
    $temp=array();
    $counter=0;
    for($c=$n_long_samples;$c<$n_long_samples+$n_practice_samples;$c++)
    {
        $temp[$counter]=$c;
        $counter++;
    }
    shuffle($temp);

    foreach($temp as $line)
        fwrite($pfh,"$line\n");

	// finally, bulk of actual sounds
    $temp=array();
    $counter=0;
    for($c=$n_long_samples+$n_practice_samples;$c<$Nstimuli;$c++)
    {
        $temp[$counter]=$c;
        $counter++;
    }
    shuffle($temp);

    foreach($temp as $line)
        fwrite($pfh,"$line\n");

    fclose($pfh);
}


function loadFolder($folder){
    $list=array();
    $allowed=array(
        "jpeg",
        "png",
        "gif",
        "jpg",
        "mp3",
        "flv",
        "JPEG",
        "PNG",
        "GIF",
        "JPG",
        "MP3",
        "FLV"
    );
    //List files in images directory
    $stat=exec("ls -t $folder",$files);
    foreach($files as $file)
    {
        if($file[0] == ".") continue;
        $temp=explode(".",$file);
        if(count($temp) == 2)
        {
            $extension=$temp[1];
            if(in_array($extension,$allowed))
                array_push($list,$file);
        }
    }
    return $list;
}

function loadTxt($file,$level){
    if(is_dir($file))
        return loadFolder($file);

    // the variable $level tells us if we have nested arrays, i.e. level 0 just a string, level 1 array split as |, level 2 array split as ,
    $fh=fopen($file,'r');
    $list=array();
    while(!feof($fh))
    {   
        $line=trim(fgets($fh));
	if($line=="") continue;
        if($level==0)
            $out=$line;

        if($level>=1)
        {
            $arr=explode("|",$line);
            $out=$arr;
            if($level==2)
            {
                $tmparr=array();
                foreach($arr as $val)
                {
                    $subarr=explode(",",trim($val));
                    array_push($tmparr,$subarr);
                }
                $out=$tmparr;
            }
        }
        array_push($list,$out);
    }
    return $list;
}
