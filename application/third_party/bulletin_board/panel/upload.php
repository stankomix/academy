<?PHP 
session_start();
ob_start();
include ("../mysqlbaglanti/baglan.php");

    function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
}

$targetFile="";
$tempFile = htmlspecialchars($_FILES[file]['tmp_name']);
$file_sizeu=formatSizeUnits(filesize($tempFile));
if($tempFile!=""){
$otomatikrakam=rand(59,591000);
$otomatikrakami=rand(59,591000);
$rand =time();
$upfile=htmlspecialchars($_FILES[file]['name']);
$filepath = pathinfo($upfile, PATHINFO_EXTENSION);
$filepath = strtolower($filepath);
$targetFile = "../uploads/59-$otomatikrakam$rand$otomatikrakami.$filepath";
$burasi = "59a-$otomatikrakam$rand$otomatikrakami.$filepath";
move_uploaded_file($tempFile,$targetFile);
}
?>
<script>
$("#file_name").val("<? echo "59-$otomatikrakam$rand$otomatikrakami.$filepath"; ?>");
$("#file_type").val("<? echo "$filepath"; ?>");
$("#file_size").val("<? echo "$file_sizeu"; ?>");
</script>

