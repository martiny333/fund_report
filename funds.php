<?php

$exclude = array(
"dadj",
"dbind",
"dcali",
"dcop",
"dequ",
"dhein",
"diii",
"dill",
"dlex",
"dmem",
"dmicr",
"dmisc",
"dmm",
"dnm",
"dnsp",
"doclc",
"doff",
"dper",
"dpub",
"dser",
"dsupp",
"dweb",
"dwlaw",
"LOMFY",
"sp",
"SP");

date_default_timezone_set("America/New_York");
$t_stamp = date('YmdHis');

$mode = $_POST['s'];
$param = $_POST['fid'];
if(!preg_match("/[*]/i", $param)) {
    $param = "*".$param."*"; //wildcard fool proof
}


$my_file = "Funds_report_".$t_stamp.".csv";


$q = '/finance/budgets?query=name=='.$param.'&limit=1000';
$t=",";
$l="\n";

$result = getFolioData($q);

$has = $result['totalRecords'];
if ($has==0) {
    $report = false;
}else{
    $report = true;
}

# process the json output;
if($report) {
    ob_start();

    $hdr =  "FundName,Allocated,NetTransfers,Encumbered,".
    "Expenditures,Available,TotalFunding\n";
    echo "$hdr";

    for($i=0;$i<$has;$i++){
        $fund = $result['budgets'][$i]['name'];

        //however, the fund might be for Law or LOM
        $law = explode("-", $fund)[0];
        $lom = substr(explode("-", $fund)[1],0,5);
        $sp = substr(explode("-", $fund)[0],-2);
        $excl = true;  //by default, exclude anything;

        if ($mode == 'ga'){

            if(!in_array($law,$exclude)
                && !in_array($lom,$exclude)
                && !in_array($sp,$exclude)){
                $excl = false;
            }

        }elseif($mode =="sp"){

            if($sp == "sp"){ // or $sp == "SP"){
                $excl = false;
            }

        }elseif($mode == "all"){
            $excl = false;
        }

        if(!$excl){  //if values needed in report

            $allocated = $result['budgets'][$i]['allocated'];
            $net = $result['budgets'][$i]['netTransfers'];
            $encumb = $result['budgets'][$i]['encumbered'];
            $expend = $result['budgets'][$i]['expenditures'];
            $avail = $result['budgets'][$i]['available'];
            $total = $result['budgets'][$i]['totalFunding'];

            $line =  "$fund$t$allocated$t$net$t$encumb$t".
                        "$expend$t$avail$t$total$l";
                echo $line;
                }
        }
    
    $csv_file = ob_get_clean();

    header("Cache-Control: no-store, max-age=0");
    header("Content-Disposition: attachment; filename=\"".$my_file."\";" );
    header("Content-Type: text/csv");
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: ".strlen($csv_file));

    echo $csv_file;
    exit(0);

}else{
    echo htmlHeader();
    echo boxBegin();

    $error =  'No records matching, please try again.';
    $msg = $error;
    echo $msg;
    echo boxEnd();
    echo htmlFooter();
}  //end of report
