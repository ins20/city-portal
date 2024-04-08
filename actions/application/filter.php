<?php
$status = $_POST['status'];
header('Location: /profile.php?status=' . $status);
