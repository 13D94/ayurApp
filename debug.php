<?php
session_start();
?>
<table border="1">
<tr><th>Variable</th><th>Value</th></tr>
<tr><td>MFG_LOGIN_FLAG</td><td><?=$_SESSION['MFG_LOGIN_FLAG'];?></td></tr>
<tr><td>MFG_ID</td><td><?=$_SESSION['MFG_ID'];?></td></tr>
</table>