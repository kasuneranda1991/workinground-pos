<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer;
// use Mike42\Escpos\EscposImage;

use App\Jobs;

class PrintController extends Controller
{
    public function PrintJobBoolean(Request $request)
    {
        Jobs::where('id',$request['print_job_id'])->update(['print_receipt' => 1]);
    }
    public function PrintReceipt()
    {
    	$item = array(55);
		
		/*|1234567| |89| |10,11,12|*/
		$product = str_split("Vanilla ice cream@");
		$qty = str_split("quanti@");
		$price = str_split("Rs.1500.45@");

		for($i=0; $i< 56 ; $i++){
			
			if($i< 35){
				foreach($product as $key => $value){
					
					if($i <= $key){
						if($i == $key){
							$item[$i] = $value;
						}
					}else{
						$item[$i] = " ";
					}
				}
			}
			
			else if($i<42){

				foreach($qty as $key => $value){
					$key = $key + 35;
					if($i <= $key){
						if($i == $key){
							$item[$i] = $value;
						}
					}else{
						$item[$i] = " ";
					}
				}
			}

			else if($i<55){

				foreach($price as $key => $value){
					$key = $key + 42;
					if($i <= $key){
						if($i == $key){
							$item[$i] = $value;
						}
					}else{
						$item[$i] = "*";
					}
				}
			}		
		}

		foreach($item as $key => $value){
			
			echo "|";
			echo $value;
		}
    }

    public function PrintJobReceipt()
    {
    	$connector = new NetworkPrintConnector("192.168.10.100", 9100);
        $printer = new Printer($connector);
        /* Initialize */
        $printer -> initialize();

        /* Text */
        $printer -> selectPrintMode(Printer::MODE_DOUBLE_HEIGHT);
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> text("My Shop Name\n");
        $printer -> selectPrintMode(Printer::MODE_FONT_B);
        $printer -> text("Job Received Note\n");
        $printer -> text("Contact:0258485269\n");
        $printer -> feed();
        $printer -> setJustification(Printer::JUSTIFY_LEFT);
        $printer -> text(" Received By:Kasun\n");
        $printer -> text(" Bill No:#845584\n");
        $printer -> text(" Date:21 Aug,2018 10:18:56 PM\n");
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> text("________________________________________________________\n");
        
        $printer -> setJustification(Printer::JUSTIFY_LEFT);
       
        $printer -> selectPrintMode(Printer::MODE_EMPHASIZED);
        $printer -> text("Customer Name:");
        $printer -> selectPrintMode(Printer::MODE_FONT_B);
        $printer -> text("Kasun Eranda\n");

        $printer -> selectPrintMode(Printer::MODE_EMPHASIZED);
        $printer -> text("NIC:");
        $printer -> selectPrintMode(Printer::MODE_FONT_B);
        $printer -> text("913014979V\n");

        $printer -> selectPrintMode(Printer::MODE_EMPHASIZED);
        $printer -> text("Priority:");
        $printer -> selectPrintMode(Printer::MODE_FONT_B);
        $printer -> text("Normal\n");
       
        $printer -> selectPrintMode(Printer::MODE_EMPHASIZED);
        $printer -> text("Description:");
        $printer -> selectPrintMode(Printer::MODE_FONT_B);
        $printer -> text("Laptob Repair\n");

        $printer -> selectPrintMode(Printer::MODE_EMPHASIZED);
        $printer -> text("Remark:");
        $printer -> selectPrintMode(Printer::MODE_FONT_B);
        $printer -> text("100 advance and laptop cable handovered\n");

        $printer -> selectPrintMode(Printer::MODE_EMPHASIZED);
        $printer -> text("TOTAL:");
        $printer -> selectPrintMode(Printer::MODE_FONT_B);
        $printer -> text("Rs.1000\n");
        
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> text("THANK YOU, Come Again\n");
        $printer -> feed();
        $printer -> selectPrintMode(Printer::MODE_FONT_B);
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> text("Copyright©workinground.com\n");
        $printer -> text("All Rights Reserved\n");
		$printer -> close();
    }
}
