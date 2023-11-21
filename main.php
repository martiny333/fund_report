<?php

require __DIR__ . '/../lib/apiinc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    if ($action == 'funds-report') {
        require __DIR__ . '/funds.php';
    }
    else {
        # No appropriate action was passed!
        http_response_code(400);
        ?><h1>400 Bad Request</h1>
        <p>No action was passed in the form!</p><?php
        exit(0);
    }
}

echo htmlHeader();
echo bodyBegin();
echo boxBegin();

?><form method="post" action="/funds/">
  <input type="hidden" name="action" value="funds-report" />
  <p><label for="fid">Search by Funds:</label><br>
  <input type="text" id="fid" name="fid" size="25" placeholder="Ex. '*FY*2022' or 'canmo*'">

  <select name="s" id="s">
    <option value="ga" selected>GA Funds</option>
    <option value="sp">Special Funds</option>
    <option value="all">All Funds</option>
  </select> 
  <br />

   <input type="submit" value="Generate Report">
  </p>
</form><?php

echo boxEnd();
echo htmlfooter();
