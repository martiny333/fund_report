<?php

FUNCTION boxBegin()
{
    ?><div class="box3"><p><?php
}

FUNCTION boxEnd()
{
    ?></p></div><?php
}


FUNCTION htmlHeader()
{

    ?><!DOCTYPE html>
    <html>
<head></head>
<style>

div{

  margin: 8 !important;
  padding: 8 !important;}

p{
  margin: 6 !important;
  padding: 2;
}

.box1
{
  border-style: solid;
  font-family: "Times New Roman", serif;
  box-shadow: 0 0 0.25rem hsl(0, 0%, 80%) inset,
              0 4rem 2rem -4rem hsl(0, 0%, 85%) inset,
              0 -4rem 2rem -4rem hsl(0, 0%, 85%) inset;
}
.box2 {
  height: 50vh;
  max-height: 20rem;
  overflow: auto;
  margin-top: 1.5rem;
  background-color: white;
  padding: 0.75rem;
  font-family: "Times New Roman", serif;
}

.box3{
  background-color: hsl(0, 0%, 95%);
  width: 85%;
  max-width: 52rem;
  margin: auto;
  color: hsl(0, 0%, 20%);
  border: 1px solid hsl(0, 0%, 0%);
  padding: 1rem;
}

.box4{
  background: linear-gradient(hsl(300, 50%, 20%), hsl(300, 50%, 10%));
  padding: 2rem 0.5rem;
  text-align: center;
  color: hsl(300, 50%, 95%);
  border-top: 1px solid hsl(300, 50%, 35%);
  border-bottom: 1px solid hsl(300, 50%, 5%);
}
.error {
  width: 85%;
  max-width: 48rem;
  margin: 0.2rem auto 0.2rem auto;
  padding: 1rem;
  background: #ffd0d0;
  font-weight: bold;
  border: 1px solid #dd2222;
}
</style>
<body><?php
}

FUNCTION errorDisplay($msg)
{
    ?><div class=error><?= htmlspecialchars($msg) ?></div><?php
}

FUNCTION htmlFooter()
{
    ?></body></html><?php
}

/*============*/
function serverName()
{
    $app = $GLOBALS['app'] ?? 'default';
    $env = myConfig('ENV', $app);
    if($env=="TEST") {
        $me = "FOLIO TEST SERVER";
    }elseif($env=="DRYR") {
        $me = "FOLIO DRYRUN SERVER";
    }elseif($env=="PROD") {
        $me = "FOLIO PRODUCTION SERVER";
    }
    return $me;
}


function bodyBegin()
{
    ?><p><?= htmlspecialchars(serverName()) ?></p>
    <br /><?php
}

