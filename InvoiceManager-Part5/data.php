<?php

$dsn= "mysql:host=localhost;dbname=invoice_manager";
$username="root";
$password= "";

try{
  $db= new PDO($dsn, $username, $password);
}catch(PDOException $e){
  $error = $e->getMessage();
  echo $error;
  exit;
}  




$sql = "SELECT * FROM statuses";
$result = $db->query($sql);
$statuses = $result->fetchAll(PDO::FETCH_ASSOC);

  // session_start();

  // $statuses = ['all', 'draft', 'pending', 'paid'];


  // $invoices = [
  //   [
  //     'number' => 'BIRHN',
  //     'amount' => 1690,
  //     'status' => 'paid',
  //     'client' => 'Lilia Harding',
  //     'email'  => 'liliaharding@enormo.com',
  //   ],
  //   [
  //     'number' => 'RNJQH',
  //     'amount' => 2928,
  //     'status' => 'pending',
  //     'client' => 'Estelle Velez',
  //     'email'  => 'estellevelez@enormo.com',
  //   ],
  //   [
  //     'number' => 'MLEDE',
  //     'amount' => 6751,
  //     'status' => 'pending',
  //     'client' => 'Beatriz Banks',
  //     'email'  => 'beatrizbanks@enormo.com',
  //   ],
  //   [
  //     'number' => 'LAJCG',
  //     'amount' => 3629,
  //     'status' => 'draft',
  //     'client' => 'Rios Cunningham',
  //     'email'  => 'rioscunningham@enormo.com',
  //   ],
  //   [
  //     'number' => 'ZZNYO',
  //     'amount' => 1208,
  //     'status' => 'pending',
  //     'client' => 'Drake Boyer',
  //     'email'  => 'drakeboyer@enormo.com',
  //   ],
  //   [
  //     'number' => 'CLGOW',
  //     'amount' => 8631,
  //     'status' => 'draft',
  //     'client' => 'Stella Atkins',
  //     'email'  => 'stellaatkins@enormo.com',
  //   ],
  //   [
  //     'number' => 'QVEXN',
  //     'amount' => 4552,
  //     'status' => 'pending',
  //     'client' => 'Holder Powell',
  //     'email'  => 'holderpowell@enormo.com',
  //   ],
  //   [
  //     'number' => 'AQJWU',
  //     'amount' => 8628,
  //     'status' => 'pending',
  //     'client' => 'Aline Allen',
  //     'email'  => 'alineallen@enormo.com',
  //   ],
  //   [
  //     'number' => 'RSKSN',
  //     'amount' => 3551,
  //     'status' => 'pending',
  //     'client' => 'Carroll Byrd',
  //     'email'  => 'carrollbyrd@enormo.com',
  //   ],
  //   [
  //     'number' => 'SITJT',
  //     'amount' => 9141,
  //     'status' => 'draft',
  //     'client' => 'Banks Alston',
  //     'email'  => 'banksalston@enormo.com',
  //   ],
  //   [
  //     'number' => 'ZKGRP',
  //     'amount' => 5511,
  //     'status' => 'draft',
  //     'client' => 'Mayer Battle',
  //     'email'  => 'mayerbattle@enormo.com',
  //   ],
  //   [
  //     'number' => 'GGMLQ',
  //     'amount' => 7977,
  //     'status' => 'paid',
  //     'client' => 'Rowland Ray',
  //     'email'  => 'rowlandray@enormo.com',
  //   ],
  //   [
  //     'number' => 'LJULN',
  //     'amount' => 3943,
  //     'status' => 'paid',
  //     'client' => 'Lindsey Rodriguez',
  //     'email'  => 'lindseyrodriguez@enormo.com',
  //   ],
  //   [
  //     'number' => 'OLOIL',
  //     'amount' => 8757,
  //     'status' => 'pending',
  //     'client' => 'Meyers Payne',
  //     'email'  => 'meyerspayne@enormo.com',
  //   ],
  //   [
  //     'number' => 'YNTIP',
  //     'amount' => 8261,
  //     'status' => 'paid',
  //     'client' => 'Rosalie Hunt',
  //     'email'  => 'rosaliehunt@enormo.com',
  //   ],
  //   [
  //     'number' => 'ZYNOC',
  //     'amount' => 1959,
  //     'status' => 'draft',
  //     'client' => 'Foreman Holcomb',
  //     'email'  => 'foremanholcomb@enormo.com',
  //   ],
  //   [
  //     'number' => 'HVMRO',
  //     'amount' => 4208,
  //     'status' => 'draft',
  //     'client' => 'Tyson Roth',
  //     'email'  => 'tysonroth@enormo.com',
  //   ],
  //   [
  //     'number' => 'VCTQD',
  //     'amount' => 7171,
  //     'status' => 'draft',
  //     'client' => 'Maryann Case',
  //     'email'  => 'maryanncase@enormo.com',
  //   ],
  //   [
  //     'number' => 'FDGPI',
  //     'amount' => 8595,
  //     'status' => 'pending',
  //     'client' => 'Vargas Lawson',
  //     'email'  => 'vargaslawson@enormo.com',
  //   ],
  //   [
  //     'number' => 'OREYP',
  //     'amount' => 2264,
  //     'status' => 'pending',
  //     'client' => 'Pamela Figueroa',
  //     'email'  => 'pamelafigueroa@enormo.com',
  //   ],
  //   [
  //     'number' => 'EILWH',
  //     'amount' => 1866,
  //     'status' => 'pending',
  //     'client' => 'Todd Bishop',
  //     'email'  => 'toddbishop@enormo.com',
  //   ],
  //   [
  //     'number' => 'RVDFY',
  //     'amount' => 2283,
  //     'status' => 'pending',
  //     'client' => 'Craig Compton',
  //     'email'  => 'craigcompton@enormo.com',
  //   ],
  //   [
  //     'number' => 'FFUWM',
  //     'amount' => 2577,
  //     'status' => 'draft',
  //     'client' => 'Margery Barry',
  //     'email'  => 'margerybarry@enormo.com',
  //   ],
  //   [
  //     'number' => 'SQRVR',
  //     'amount' => 5356,
  //     'status' => 'draft',
  //     'client' => 'Candace Ramos',
  //     'email'  => 'candaceramos@enormo.com',
  //   ],
  //   [
  //     'number' => 'SJLET',
  //     'amount' => 5045,
  //     'status' => 'pending',
  //     'client' => 'Darcy Thompson',
  //     'email'  => 'darcythompson@enormo.com',
  //   ]
  // ];
 

  // if(isset($_SESSION['invoices'])){
  //   $invoices = $_SESSION['invoices'];
  // }else{
  //   $_SESSION['invoices'] = $invoices;
  // }
