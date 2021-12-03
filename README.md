# ratesounds
This online experiment has been used to collect simple evaluations on a web server running Apache and PHP.

The base code for user registration, data handling and stimulus randomization is from MIT-licensed "embody" project by Enrico Glerean at https://version.aalto.fi/gitlab/eglerean/embody/ but notably here without the Adobe Flash requirement. The directories are somewhat cleaned up of extra files which could possibly cause security issues.

For embody-based experiments, <tt>admin/data</tt> and <tt>subjects</tt> subdirectories have to be writable by apache or other web server process (e.g. <tt>sudo chown -R apache:apache ratesounds/subjects ratesounds/admin/data</tt>). Other suggested configuration option is disabling subjects directory browsing in httpd.conf, e.g. :
<pre>
&lt;Directory /var/www/html/ratesounds/subjects/&gt;
   Order Deny,allow
   Deny from all
&lt;/Directory&gt;
</pre>
and for the whole /var/www/html 
<pre>
# Options Indexes FollowSymLinks
</pre>

Specific notes and short descriptions for the experiments:

<ul>
  <li>Auditory-only evaluation of samples, with custom and easy-to-use CSS slider
  <li>Special handling of randomization: has first some categorical evaluations, then a few practise sounds before the final sounds. All portions have their own randomization. Adjust N of sounds in settings.php and editing stim list ratesounds_list.txt
  <li>Some placeholder samples are included. The current simple template has 5 long sounds + 5 practice sounds + 8 sample sounds of which 4 were repeated as control sounds => total 5+5+8+4=22 sounds. 
  <li>Includes shell scripts for stimulus sound preparation under <a href="sample_processing">sample_processing</a> using <a href="http://sox.sourceforge.net">SoX</a>: converts to unified format, adds silence, onset/offset ramps, repetition and mp3 conversion (with <a href="https://lame.sourceforge.io/">lame</a>)
  <li>Output data folder on the server (subjects, with per-subject code and single csv/txt files) can be converted to easy-to-interpret Excel file using a Matlab conversion script. This is included under <a href="matlab_process_subject/">matlab_process_subject</a> subdirectory, with instructions for use inside the script
  <li>Special admin interface (subdirectory <a href="admin/">admin/</a>) using a fixed password is not a mandatory feature to place on the server. This allows downloading the accumulated data more fluently by a user (say, by research assistant) without server user account, though.
</ul>
