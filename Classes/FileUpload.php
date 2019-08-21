<?php
class FileUpload
{
	protected $filename;
	protected $size;
	protected $temp;
	protected $type;
	protected $path;
	function __construct($filename,$size,$type,$temp)
	{
		$this->filename=time().$filename;
		$this->size=$size;
		$this->type=$type;
		$this->temp=$temp;
	}
	
	function moveFile(){
		$status_upload=move_uploaded_file($this->temp, $this->path);
		return $status_upload;
	}
}
?>