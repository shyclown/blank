<?php
require_once('autoload.php');
$db = new System\Database;
new System\Session($db);
new System\Tables($db);



?>

<!DOCTYPE html>
<html>
  <head>
    <base href="/">
    <?php require "pages/head.php"?>
  </head>
  <body ng-app='app' ng-controller="mainController">
    <div id="pageGrid">
      <section id="topPanel">
        <ul class="maintop">
          <li><a href="home"><b>Moravcik</b></a></li>
        </ul>
        <ul class="sub-maintop">
          <li><a href="programming">Programming</a></li>
          <li><a href="architecture">Architecture</a></li>
          <li><a href="illustration">Illustration</a></li>
          <li><a href="photos">Photography</a></li>
        </ul>
      </section>
      <section id="sidePanel">
        <div class="fixed">
          <ul class="sub" ng-if="url == '/programming'">
            <li><a href="#">PHP</a></li>
            <li><a href="#">Javascript</a></li>
            <li><a href="#">CSS / SASS</a></li>
            <li><a href="#">C#</a></li>
          </ul>
          <ul class="sub" ng-if="url == '/architecture'">
            <li><a href="#">Studies</a></li>
            <li><a href="#">Visualisation</a></li>
          </ul>
          <ul class="sub" ng-if="url == '/photos'">
            <li><a href="#">People</a></li>
            <li><a href="#">Cities</a></li>
            <li><a href="#">Nature</a></li>
          </ul>
        </div>
      </section>
      <section id="mainPanel">
      <div ng-view></div>
      </section>


    <section id="footerPanel">
      <?php require "pages/footer.php"; ?>
    </section>
    </div>

  </body>
</html>
