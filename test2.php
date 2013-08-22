<html>
<head><title>My test for php</title></head>
<body>
<h3>This is a test how php works</h3>

<?php phpinfo()?>

<?php
$currtime = time ();
$currtimestr = strftime ("%H:%M:%S", $currtime);
echo "The current time is: $currtimestr";
?>

</body>
</html>