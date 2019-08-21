<html>
<body>
<?php
session_start();
unset($_SESSION['student']);
?>
<script type="text/javascript">
	alert("Your logout is successful");
	window.location="index.php";

</script>
</body>
</html>