<?php

foreach (glob('resource/*.swf') as $file) {
  $nameOld = trim(str_replace('.swf', '', basename($file)));

  echo "rename \"{$nameOld}\"\n";
  echo "> ";

  $nameNew = trim(str_replace('.swf', '', fgets(STDIN)));

  shell_exec("java -jar ffdec/ffdec.jar -swf2xml $file resource/tmp_old.xml");

  $hexOld = bin2hex($nameOld);
  $hexNew = bin2hex($nameNew);

  $xml = file_get_contents('resource/tmp_old.xml');
  $xml = str_replace([ $nameOld, $hexOld ], [ $nameNew, $hexNew ], $xml);

  file_put_contents('resource/tmp_new.xml', $xml);

  shell_exec("java -jar ffdec/ffdec.jar -xml2swf resource/tmp_new.xml resource/renamed/{$nameNew}.swf");

  unlink('resource/tmp_new.xml');
  unlink('resource/tmp_old.xml');
}

exit('done');
