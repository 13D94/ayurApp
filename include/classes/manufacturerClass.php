<?php
// Require the ayurCoreLibrary
require_once('../coreLibrary.php');
// SQL login user name for manufacturer
define("DB_MFG_USERNAME",'root');
// SQL password for manufacturer
define("DB_MFG_PASSWORD",''); 

/**
 * @class ManufacturerClass
 * PHP class for Manufacturer
 */
class ManufacturerClass
{	
	/**
	 * MYSQLi link
	 * @private
	 */
	private $db;
	
	//------------------------------------------------------------
	// METHODS
	//------------------------------------------------------------

	/**
	 * This is the class constructor.
	 * Connect to the Database and store the reference in $db
	 * @public
	 */
	public function __construct() {
		$this->db = new mysqli(DB_HOSTNAME, DB_MFG_USERNAME, DB_MFG_PASSWORD, DB_NAME);
		if($this->db->connect_errno > 0){
			errorHandler('DB_MFG_CONNECT_ERROR', $this->db->connect_error);
			return;
		}	
	}
	
	/**
	 * Default destructor.
	 * To close the Database connection link.
	 * @public
	 */
	public function __destruct() {
		mysqli_close($this->db);
	}
	
	/**
	 * For the manufacturer to add a new product
	 * This parameters of this functions must be verified for their types before passing.
	 * @param $p_id (integer) The product id of the product added, this is autoincremented in the database
	 * @param $p_mf_id (integer) The product's manufacturer id. this will be taken from the session when a manufacturer is adding a new product.
	 * @param $p_name (string) The name of the new added product.
	 * @param $p_image (string) path of the uploaded image of the product.
	 * @param $p_reference (string) The reference of the medicine.
	 * @param $p_indic_contra (string) Indication or the Contradiction of the medicine.
	 * @param $p_dosage (string) Dosage of the medicine.
	 * @param $p_user_guide (string) User Guide of the medicine.
	 * @param $p_batch_no (integer) Batch number of the manufactured medicine.
	 * @param $p_expiry_date (TIMESTAMP) Expiry date of the medicine.
	 * @param $p_mrp (integer) MRP of the medicine.
	 * @public
	 */
	//Adding a new product
	public function addNewProduct($p_mfg_id,$p_name,$p_image,$p_reference,$p_indic_contra,$p_dosage,$p_user_guide,$p_batch_no,$p_expiry_date,$p_mrp) {
		$expiry_date = mysqli_real_escape_string($this->db,$p_expiry_date);
		$sql = <<<SQL
		INSERT INTO `tb_mfg_products`
		(`p_mfg_id`, `p_name`, `p_image`, `p_reference`, `p_indic_contra`, `p_dosage`, `p_user_guide`, `p_batch_no`, `p_expiry_date`, `p_mrp`) 
		VALUES ('$p_mfg_id','$p_name','$p_image','$p_reference','$p_indic_contra','$p_dosage','$p_user_guide','$p_batch_no','$p_expiry_date','$p_mrp')
SQL;
		if(!$result = $this->db->query($sql)){
			//die('There was an error running the query [' . $db->error . ']');
			errorHandler('DB_MFG_INSERT_PRODUCT_ERROR',$this->db->error);
			return;
		}
	}
}

$mfg = new ManufacturerClass;
	$mfg->addNewProduct('1',"adsf","fdsf","fsdf","t4twr","213","fddsfd","123",'2015-09-20 14:45:51',"23324");
	echo "inserted"; 
?>