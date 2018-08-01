<!DOCTYPE html>
<!--
https://www.quandl.com/api/v3/datasets/NSE/SHIVAMILLS?start_date=2018-02-26&end_date=2018-02-28&api_key=TfT9zWLy8_yLUciHocNr
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php 
ini_set('display_errors', '1'); 
include_once 'dbmysqliclass.php';
$db = new Db('localhost', 'root', '', 'research');
$data = $db->select('nse_codes',array('symbol'));

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>NSE data by symble.</title>
        <link rel="stylesheet" href="./css/bootstrap.min.css" >
        <script src="js/jquery-3.3.1.min.js" type="text/javascript"></script>
        <script src="./js/bootstrap.min.js" ></script>
       
        <script>
            localStorage.setItem('nse',<?php echo $data; ?>);
            localStorage.setItem('bse', '{"k3":"Tombb","k4":"towb"}');
            var nse = JSON.parse(localStorage.getItem('nse'));
            var bse = JSON.parse(localStorage.getItem('bse'));
            var nseoptions = '';
            
            for (const [key, value] of Object.entries(nse)) {
            nseoptions += '<option value="' + key + '">' + value + '</option>';
            }
            
            var bseoptions = '';
            for (const [key, value] of Object.entries(bse)) {
            bseoptions += '<option value="' + key + '">' + value + '</option>';
            }
            $(document).ready(function(){

                $('input[name="exchange"]').on('click change', function(e) {
                    var ex = $(this).val();
                        if (ex == 'nse'){
                            $("#symbol").html(nseoptions);
                        }
                        if (ex == 'bse'){
                            $("#symbol").html(bseoptions);
                        }
                });
            });


        </script>
    </head>

    <body>
<?php
$url = "https://www.quandl.com/api/v3/datasets/NSE/ANDHRABANK.json?start_date=2018-02-26&end_date=2018-03-05&api_key=TfT9zWLy8_yLUciHocNr";
$curl = curl_init();
curl_setopt_array($curl, array(CURLOPT_URL => $url, CURLOPT_SSL_VERIFYPEER => false, CURLOPT_RETURNTRANSFER => true));
$resp = curl_exec($curl);
$res = json_decode($resp, true);
$data = $res['dataset'];
curl_close($curl);
?>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-4">

                    <div class="col-sm-12 col-lg-12">
                        <form class="form-horizontal" role="form">


                            <div class="radio">                            
                                <label><input type="radio" name="exchange" value="nse">NSE</label> 
                                <label><input type="radio" name="exchange" value="bse">BSE</label>
                            </div>

                            <div class="form-group">
                                <label for="symbol">Select symbol:</label>
                                <select class="form-control" name='symbol' id="symbol">

                                </select>
                            </div>
                            <div class="form-group">
                                <label for="fromdate">Select From Date:</label>
                                <input type="date" class="form-control" name="fromdate" id="fromdate">
                            </div>
                            <div class="form-group">
                                <label for="todate">Select To Date:</label>
                                <input type="date" class="form-control" name="todate" id="todate">
                            </div>
                        </form>

                    </div>
                </div>

                <div class="col-sm-8">
                    <h2><?php echo $data['name']; ?></h2>
                    <span class="float-left"><?php echo $data['database_code'] . ": "; ?><?php echo $data['dataset_code']; ?></span>
                    <p><?php echo $data['description']; ?></p>
                    <table class="table">
                        <thead>
                            <tr>
                                <th> <?php echo implode("</th><th>", $data['column_names']) ?></th>
                            </tr>
                        </thead>
                        <tbody>
<?php foreach ($data['data'] as $val): ?>
                                <?php
                                $diff = $val['5'] - $val['1'];
                                if ($diff == 0) {
                                    $class = 'bg-info';
                                }
                                if ($diff < 0) {
                                    $class = 'bg-danger';
                                }
                                if ($diff > 0) {
                                    $class = 'bg-success';
                                }
                                ?>
                                <tr class="<?php echo $class; ?>"><td> <?php echo implode("</td><td>", $val) ?></td></tr>
                            <?php endforeach; ?>
                            </tr> 
                        </tbody>
                    </table>
                </div>            

            </div>
        </div>
    </body>
</html>
