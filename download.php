<?php

	$fullPath = str_replace("_thumb", "", $_GET['file']);
	if(isset($fullPath))
	{
		if ($fd = fopen ($fullPath, "r")) {
		    $fsize = filesize($fullPath);
		    $path_parts = pathinfo($fullPath);
		    $ext = strtolower($path_parts["extension"]);
		    switch ($ext) {
		        case "pdf":
		        header("Content-type: application/pdf");
		        header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\""); // use 'attachment' to force a file download
		        break;
		        // add more headers for other content types here
		        default;
		        header("Content-type: application/octet-stream");
		        header("Content-Disposition: filename=\"".$path_parts["basename"]."\"");
		        break;
		    }
		    header("Content-length: $fsize");
		    header("Cache-control: private"); //use this to open files directly
		    while(!feof($fd)) {
		        $buffer = fread($fd, 2048);
		        echo $buffer;
		    }
		}
		fclose ($fd);
		exit;
	}
?>
