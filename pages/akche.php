<?php
require ('../includes/x7chat.php');
require ('../includes/user.php');

//$x7 = new x7chat ();
 
 /** 
 * @author tin
 * 
 */
class akche {
	// TODO - Insert your code here
	
	public  $baslangicAkcesi;
	
	function akceDusur($miktar){
		echo $this->baslangicAkcesi-$miktar . "\xA";
	}
	
	function akceEkle($miktar){
		echo $this->baslangicAkcesi+$miktar . "\xA";
	}
	function muhasebeTut( $borcVerilenUser, $miktar){
		echo ("Hakan Murat'tan: ".$miktar);
	}
	
	function borcVer($miktar, $borcVerilenUser ){
		 $this->akceDusur($miktar);
		 $borcVerilenAkceObj=new akche();
		 $borcVerilenAkceObj=$borcVerilenUser->getUserAkce();
		 $borcVerilenAkceObj->akceEkle($miktar);
		 $this->muhasebeTut($borcVerilenUser, $miktar);
	     
	}
	/**
	 */
	function __construct() {
 		// TODO - Insert your code here
	}
	
	/**
	 */
	function __destruct() {
		
		// TODO - Insert your code here
	}
	
	function main() {
	
		    $akche= new akche();
            $akche->baslangicAkcesi=1000;
            $user = new x7_user ();
	        $akche->borcVer(50,$user);
	}
	
}

   akche::main();
     
     
?>