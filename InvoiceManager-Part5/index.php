<?php   
      require "data.php";
      require 'functions.php';

      $sql= "SELECT * FROM invoices";
      $result= $db->query($sql);
      $invoices= $result->fetchAll(PDO::FETCH_ASSOC);

      if(isset($_POST['client'])){
        $invoice = sanitize($_POST);
        $errors = validate($invoice);

        if (empty($errors)) {
            addInvoice($invoice);  
            header("Location: index.php");
            exit;   
        }       
      }

      if(isset($_GET['status_id'])){
       $status_id = $_GET['status_id'];
      } else{
        $status_id = 'all';
      }
      

      if($status_id === 'all'){
        $filteredInvoices = $invoices;
      } else{
        $filteredInvoices = filterStatus($invoices, $status_id);
      }

      $invoiceCount = count($filteredInvoices);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Manager</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Invoice Manager</h1>
    <p>There are <?php echo $invoiceCount; ?> invoices.</p>
    <section class='container'>
    <a class="new" href="add.php">Add>></a>

    <nav>
    <div class="element">
                <a href="index.php?status_id=all">All</a>
            </div>
    <?php foreach ( $statuses as $status) : ?>
    <div class="element">
        
        <a href="index.php?status_id=<?php echo $status['id']; ?>"><?php echo $status['status']; ?></a>
        
    </div>
        <?php endforeach ?>
    </nav>
    </section>
    <hr>
    
    <?php displayInvoices($filteredInvoices); ?>
</body>
</html>