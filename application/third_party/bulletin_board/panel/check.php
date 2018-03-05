<?php
$fileArray = array();
foreach ($_POST as $key => $value) {
	if ($key != 'folder') {
	}
}
echo json_encode($fileArray);

?>