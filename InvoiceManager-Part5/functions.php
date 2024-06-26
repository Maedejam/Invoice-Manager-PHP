<?php
 require_once "data.php";


 function getInvoiceNumber($length = 5) {
    $letters = range('A', 'Z');
    $number = [];
    
    for ($i = 0; $i < $length; $i++) {
      array_push($number, $letters[rand(0, count($letters) - 1)]);
    }
    return implode($number);
  }
  
function displayInvoices($invoices){
    
    foreach ($invoices as $invoice) {
        echo '<div class="invoice padding">';
        echo "#" . $invoice['number'];
        echo '<a href="mailto:' . $invoice['email'] . '">' . $invoice['client'] . '</a>';
        echo "$ " . $invoice['amount'];

        $statusClass = '';
        $status = 'UnKnown';
        if (isset($invoice['status_id'])) {
            switch ($invoice['status_id']) {
                case 3:
                    $statusClass = 'paid';
                    $status = 'paid';
                    break;
                case 2:
                    $statusClass = 'pending';
                    $status = 'pending';
                    break;
                case 1:
                    $statusClass = 'draft';
                    $status = 'draft';
                    break;
                
            }
            echo '<button class="' . $statusClass . '">' . $status . '</button><br>';
        } else {
            echo '<button class="unknown">Unknown Status</button><br>';
        }
        $pdfFile = 'documents/' . $invoice['number'] . '.pdf';
        if (file_exists($pdfFile)) {
            echo '<button class="edit"><a href="' . $pdfFile . '" target="_blank">View</a></button>';
        }
        echo '<button class="edit"><a href="update.php?id=' . $invoice['number'].'">Edit</a></button>';

        echo '<form action="delete.php" method="post">';
        echo '<input type="hidden" name="number" value="' . $invoice['number'] . '">';    
        echo '<button type= "submit" class="delete">Delete</button>'; 
        echo '</form>';        
        echo '</div>';
       
      }
    
}

function filterStatus($invoices, $status_id){
    return array_filter($invoices, function($invoice) use ($status_id) {
        return isset($invoice['status_id']) && $invoice['status_id'] == $status_id;
    });
}


  function saveForm ($number) {

    $form = $_FILES['form'];
    if ($form['error'] === UPLOAD_ERR_OK)
    {
        $ext = pathinfo($form['name'], PATHINFO_EXTENSION);
        if ($ext === 'pdf') {
        $filename= $number . ".{$ext}";
        if (!file_exists('documents')){
            mkdir('documents');
        }
        $dest = 'documents/' . $filename;
        if (file_exists($dest)){
            unlink($dest);
        }
        return move_uploaded_file($form['tmp_name'], $dest);
    }
  }
  return false;
}
  
  function addInvoice($invoice) {
    global $db;
    $number = getInvoiceNumber();

    $sql= "INSERT INTO invoices (number, amount, status_id, client, email) VALUES (:number, :amount, :status_id, :client, :email)";
    $stmt= $db->prepare($sql);
    $stmt->execute([
        ':number' => $number,
        ':amount' => $invoice['amount'],
        ':status_id' => $invoice['status_id'],
        ':client' => $invoice['client'],
        ':email' => $invoice['email']
    ]);
    
    saveForm($number);
  }

  function updateInvoice($invoice) {
    global $db;

    $sql= "UPDATE invoices SET amount= :amount, status_id= :status_id, client= :client, email= :email WHERE number= :number";
    $stmt= $db->prepare($sql);
    $stmt->execute([
        ':number' => $invoice['number'],
        ':amount' => $invoice['amount'],
        ':status_id' => $invoice['status_id'],
        ':client' => $invoice['client'],
        ':email' => $invoice['email']
    ]);
    saveForm($invoice['number']);
  }

  function deleteInvoice($number) {
    global $db;

    $sql= "DELETE FROM invoices WHERE number= :number";
    $stmt= $db->prepare($sql);
    $stmt->execute([':number' => $number]);
  }

function sanitize($data){
   return array_map(function($value){
       return htmlspecialchars(stripslashes(trim($value)));
   }, $data);
}

function validate($invoice){
    $fields= ['client', 'amount', 'email', 'status_id'];
    $errors=[];
    global $statuses;

    foreach($fields as $field){
        switch($field){
            case 'client':
                if(empty($invoice[$field])){
                    $errors[$field]= 'It should not be empty';
                }else if (strlen($invoice[$field])>255){
                    $errors[$field] = 'Characters should be less than 255';
                }else if (!preg_match('/^[a-zA-Z\s]+$/', $invoice[$field])){
                    $errors[$field] = 'It should be contain just letters and space';
                }
                break;
            case 'amount':
                if(empty($invoice[$field])){
                    $errors[$field]= 'It should not be empty';
                }else if(filter_var($invoice[$field], FILTER_VALIDATE_INT) === false){
                    $errors[$field]='It should contain integer';
                }
                break;
            case 'email':
                if(empty($invoice[$field])){
                    $errors[$field]= 'It should not be empty';
                }else if(filter_var($invoice[$field], FILTER_VALIDATE_EMAIL)=== false){
                    $errors[$field]= 'Please provide a valid email address';
                }
                break;
            case 'status_id':
                if(empty($invoice[$field])){
                    $errors[$field]= 'It should not be empty';
                } else {
                    $valid_status = false;
                    foreach ($statuses as $status) {
                        if ($status['id'] == $invoice[$field]) {
                            $valid_status = true;
                            break;
                        }
                    }
                    if (!$valid_status) {
                        $errors[$field] = 'Invalid status';
                    }
                }
                break;
        }
    }
    return $errors;
}