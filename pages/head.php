<meta charset="utf-8">
<title>Test SCSS</title>
<link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300" rel="stylesheet">
<link rel="stylesheet" href="scss/styles.css">

<!--FontAwesome -->
<link rel="stylesheet" href="/lib/font/font-awesome.min.css" type='text/css'>
<?php
// LOAD APP
echo '<!-- Angular -->';
echo '<script src="lib/angular/angular.min.js"></script>';
echo '<script src="lib/angular/angular-sanitize.min.js"></script>';
echo '<script src="lib/angular/angular-route.min.js"></script>';

echo '<!-- Include App-->';
$appjs = getFilesOfTypeAll("app/","js");
foreach ($appjs as $filename) {  echo '<script src="'.$filename.'"></script>'; }
?>
