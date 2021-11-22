# ratesounds
This online experiment has been used to collect simple evaluations on a web server running Apache and PHP.

The base code for user registration, data handling and stimulus randomization is from MIT-licensed "embody" project by Enrico Glerean at https://version.aalto.fi/gitlab/eglerean/embody/ but notably here without the Adobe Flash requirement. The directories are somewhat cleaned up of extra files which could possibly cause security issues.

For embody-based experiments, <tt>admin/data</tt> and <tt>subjects</tt> subdirectories have to be writable by apache (<tt>sudo chown -R apache:apache EXPNAME/subjects EXPNAME/admin/data</tt>). Other suggested configuration option is disabling directory browsing in httpd.conf:
<pre>
&lt;Directory /var/www/html/EXPNAME/subjects/&gt;
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
  <li>Special handling of randomization: has first some categorical evaluations, then a few practise sounds before the final sounds. All portions have their own randomization
  <li>Some placeholder samples are included
  <li>Includes shell scripts for stimulus sound preparation (using SoX http://sox.sourceforge.net/ ): adding silence, onset/offset ramps, repetition and mp3 conversion
</ul>
