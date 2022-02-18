<?php

// This file is your starting point (= since it's the index)
// It will contain most of the logic, to prevent making a messy mix in the html

// This line makes PHP behave in a more strict way
declare(strict_types=1);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// We are going to use session variables so we need to enable sessions
session_start();

// Use this function when you need to need an overview of these variables
function whatIsHappening() {
    echo '<h2>$_GET</h2>';
    var_dump($_GET);
    echo '<h2>$_POST</h2>';
    var_dump($_POST);
    echo '<h2>$_COOKIE</h2>';
    var_dump($_COOKIE);
    echo '<h2>$_SESSION</h2>';
    var_dump($_SESSION);
}
function pre($var){
    ?><pre>
        <?php print_r ($var); ?>
    </pre>
    <?php
}
// TODO: provide some products (you may overwrite the example)
$products = [
    ['name' => 'Aloo pie', 'price' => 1.5],
    ['name' => 'Apple crisp', 'price' => 3.5],
    ['name' => 'Apple pie', 'price' => 2.5],
];
function printSelectedProducts($products){
    //whatIsHappening();
    
    if(!empty($_POST["products"])){
        echo '<div class="alert alert-info" role="alert">
      your order was succesfull! </br> These are your selected products: ';
        ?></br><?php
            foreach($_POST["products"]as $i=>$product){               
                
                echo $products[$i]['name'] ;
                ?></br><?php          
            }
        ?></div><?php
    }
}

$totalValue = 0;
function calculateTotalValue($products){
    $total=0;
    if(!empty($_POST["products"])){
        foreach($_POST["products"]as $i=>$product){               
                
            $total=$total+$products[$i]['price'];
        }
    }
       
    return $total;
}
function validate()
{   $invalidFields=[];
    if(empty($_POST['email'])){
        array_push($invalidFields,'email');
    }
    if(empty($_POST['street'])){
        array_push($invalidFields,'street');
    }
    if(empty($_POST['streetnumber'])){
        array_push($invalidFields,'streetnumber');
    }
    if(empty($_POST['city'])){
        array_push($invalidFields,'city');
    }
    if(empty($_POST['zipcode'])){
        array_push($invalidFields,'zipcode');
    }
    if(empty($_POST['products'])){
        array_push($invalidFields,'products');
    }      
    // This function will send a list of invalid fields back
    return $invalidFields;
}

function handleForm()
{
    // TODO: form related tasks (step 1)
    // Validation (step 2)
    $invalidFields = validate();
    
    if (!empty($invalidFields)) {
        foreach($invalidFields as $invalidField){
           
            if($invalidField=='products'){
                ?><div class="alert alert-warning" role="alert">
                Please select at least 1 product.
                </div><?php
            }else{
                ?><div class="alert alert-warning" role="alert">
                Please fill in the <?php echo $invalidField;?> field.
                </div><?php
            }
        }
        return false;        
    } else {
        // handle successful submission  
        return true;    
    }
}

// TODO: replace this if by an actual check
$validSubmit=false;
if (!empty($_POST)) {    
    $validSubmit=handleForm(); 
    if($validSubmit==true){$totalValue=calculateTotalValue($products);  }
}

require 'form-view.php';