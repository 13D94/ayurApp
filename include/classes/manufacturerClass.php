<?php
// Require the ayurCoreLibrary
require_once(__DIR__."/../coreLibrary.php");
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
	 *
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
	 *
	 * To close the Database connection link.
	 * @public
	 */
	public function __destruct() {
		mysqli_close($this->db);
	}

	/**
	 * To get mfg_id of the provided username.
	 *
	 * This function can be used to get the mfg_id of the username provided from the database. This is can be used to store in the session during login.
	 * @return (integer) Returns mfg_id.
	 * @param $mfg_username (string) username of the manufacturer.
	 * @public
	 */
	public function getMfgIdFromMfgUname($mfg_username){
		// Trimming and Escaping Username
		$mfg_username = $this->db->real_escape_string(trim($mfg_username));
		$sql = <<<SQL
		SELECT `mfg_id` 
		FROM `tb_mfg` 
		WHERE `mfg_username`='$mfg_username'
SQL;
		if(!$result = $this->db->query($sql)){
			errorHandler('DB_MFG_LOGIN_GETMFGID_QUERY_ERROR',$this->db->error);
			return;
		}else{
			if($result->num_rows > 0){
				$mfgUser = $result->fetch_assoc();
				$mfg_id = $mfgUser['mfg_id'];
				return $mfg_id;
			}else{
				errorHandler('DB_MFG_LOGIN_GETMFGID_ERROR',$this->db->error);
				return;
			}

		}
	}

	/**
	 * Check if a manufacturer's account is registered or not.
	 *
	 * This function can be used to authenticate the login process of a manufacturer user.
	 * The passed parameters are escaped and trimmed before substituting them into the SQL Query.
	 * This function will generate the hash of the password and verify it with hash stored in the database.
	 * @return (string) Returns MFG_USER_REGISTERED if user is registered and MFG_USER_INCORRECT_CREDENTIALS if credentials are invalid and MFG_USER_UNREGISTERED if user is unregistered.
	 * @param $mfg_username (string) username of the manufacturer.
	 * @param $mfg_user_password (string) Password of the account
	 * @public
	 */
	public function checkMfgAccountRegistration($mfg_username,$mfg_user_password){
		// Trimming and Escaping Username
		$mfg_username = $this->db->real_escape_string(trim($mfg_username));

		// Trimming and Escaping Password
		$mfg_user_password = $this->db->real_escape_string(trim($mfg_user_password));

		$sql = <<<SQL
		SELECT `mfg_password_hash` 
		FROM `tb_mfg` 
		WHERE `mfg_username`='$mfg_username'
SQL;
		if(!$result = $this->db->query($sql)){
			errorHandler('DB_MFG_LOGIN_CREDENTIALS_QUERY_ERROR',$this->db->error);
			return;
		}else{
			if($result->num_rows > 0){
				$mfgUser = $result->fetch_assoc();
				$storedPasswordHash = $mfgUser['mfg_password_hash'];
				if (password_verify($mfg_user_password, $storedPasswordHash)) {
					return("MFG_USER_REGISTERED");
				}else{
					return("MFG_USER_INCORRECT_CREDENTIALS");
				}
			}else{
				return("MFG_USER_UNREGISTERED");
			}

		}

	}

	/**
	 * For the manufacturer to add a new product
	 *
	 * This parameters of this functions must be verified for their types before passing.
	 * @return $p_id (integer) The product id of the product added, this is autoincremented in the database
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
	public function addNewProduct($p_mfg_id,$p_name,$p_image,$p_reference,$p_indic_contra,$p_dosage,$p_user_guide,$p_batch_no,$p_expiry_date,$p_mrp) {
		$sql = <<<SQL
		INSERT INTO `tb_mfg_products`
		(`p_mfg_id`, `p_name`, `p_image`, `p_reference`, `p_indic_contra`, `p_dosage`, `p_user_guide`, `p_batch_no`, `p_expiry_date`, `p_mrp`)
		VALUES ('$p_mfg_id','$p_name','$p_image','$p_reference','$p_indic_contra','$p_dosage','$p_user_guide','$p_batch_no','$p_expiry_date','$p_mrp')
SQL;
		if(!$result = $this->db->query($sql)){
			errorHandler('DB_MFG_INSERT_PRODUCT_ERROR',$this->db->error);
			return;
		}else{
			return $this->db->insert_id;
		}
	}

	/**
	 * For the manufacturer to update an existing product
	 *
	 * p_id and p_mfg_id must be used to match the product
	 * This parameters of this functions must be verified for their types before passing.
	 * @return nothing.
	 * @param $p_id (integer) The product id of the product added, this is autoincremented in the database
	 * @param $p_mfg_id (integer) The product's manufacturer id. this will be taken from the session when a manufacturer is adding a new product.
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
	public function updateProduct($p_id,$p_mfg_id,$p_name,$p_image,$p_reference,$p_indic_contra,$p_dosage,$p_user_guide,$p_batch_no,$p_expiry_date,$p_mrp) {
		$sql = <<<SQL
		UPDATE `tb_mfg_products` SET
		`p_name`='$p_name',`p_image`='$p_image',`p_reference`='$p_reference',`p_indic_contra`='$p_indic_contra',`p_dosage`='$p_dosage',`p_user_guide`='$p_user_guide',`p_batch_no`='$p_batch_no',`p_expiry_date`='$p_expiry_date',`p_mrp`='$p_mrp'
		 WHERE `p_id`='$p_id' AND `p_mfg_id`='$p_mfg_id'
SQL;
		
		if(!$result = $this->db->query($sql)){
			errorHandler('DB_MFG_INSERT_PRODUCT_ERROR',$this->db->error);
			return;
		}
	}

	/**
	 * For the manufacturer to remove an existing product
	 *
	 * p_id and p_mfg_id must be used to match the product
	 * This parameters of this functions must be verified for their types before passing.
	 * @return nothing
	 * @param $p_id (integer) The product id of the product added, this is autoincremented in the database
	 * @param $p_mfg_id (integer) The product's manufacturer id. this will be taken from the session when a manufacturer is adding a new product.
	 * @public
	 */
	public function deleteProduct($p_id,$p_mfg_id) {
		$sql = <<<SQL
		DELETE FROM `tb_mfg_products`
		WHERE `p_id`='$p_id' AND `p_mfg_id`='$p_mfg_id'
SQL;
		
		if(!$result = $this->db->query($sql)){
			errorHandler('DB_MFG_DELETE_PRODUCT_QUERY_ERROR',$this->db->error);
 			return;
		}else{
			if($this->db->affected_rows == 0){
				errorHandler('DB_MFG_DELETE_PRODUCT_ERROR',"Product might have already been deleted or product doesnt exist in the DB");
				return;
			}
		}
	}

	/**
	 * For searching products from the database
	 *
	 * p_name used to match the product
	 * This parameters of this functions must be verified for their types before passing.
	 * @return $resultsArray (mixed) Array of the results.
	 * @param $p_name (string) The product name, this is fixed with wildcard characters and then searched.
	 * @param $p_mfg_id (integer) The Manufacturer ID, of whom the products belong.
	 * @param $sort (string) ASC for ascending search results, and DESC for descending search results.
	 * @public
	 */
	public function searchProduct($p_name,$p_mfg_id,$sort) {
		$sql = <<<SQL
		SELECT * FROM `tb_mfg_products`
		WHERE `p_name` LIKE '%$p_name%'
		AND `p_mfg_id` = '$p_mfg_id'
		ORDER BY `p_name` $sort
SQL;
		if(!$result = $this->db->query($sql)){
			errorHandler('DB_MFG_SEARCH_PRODUCT_QUERY_ERROR',$this->db->error);
 			return;
		}else{
			$resultsArray = array();
			while ($row = $result->fetch_array(MYSQL_ASSOC)) {
				$resultsArray[] = $row;
			}
			return $resultsArray;
		}
	}

	/**
	 * For geting details about a particular product
	 *
	 * p_id used to match the product
	 * This parameters of this functions must be verified for their types before passing.
	 * @return $prodDetailsArray (mixed) details about the product.
	 * @param $p_id (integer) Product id of the product.
	 * @param $p_mfg_id (integer) The calling manufacturer's id
	 * @public
	 */
	public function getProductInfo($p_id,$p_mfg_id){
		$sql = <<<SQL
		SELECT * FROM `tb_mfg_products`
		WHERE `p_id` = '$p_id'
		AND `p_mfg_id` = '$p_mfg_id'
SQL;
		if(!$result = $this->db->query($sql)){
			errorHandler('DB_MFG_GET_PRODUCT_QUERY_ERROR',$this->db->error);
 			return;
		}else{
			$resultsArray = array();
			$prodDetailsArray = $result->fetch_array(MYSQL_ASSOC);
			return $prodDetailsArray;
		}

	}
}

//$mfg = new ManufacturerClass;
//$mfg->addNewProduct('1',"adsf","fdsf","fsdf","t4twr","213","fddsfd","123",'2015-09-20 14:45:51',"23324");
//$mfg->updateProduct('11','1',"adsffds","ffdsfsdsf","f1fdfsfsdf","tsdfsfs4twr","1213","fddsfd","123",'2015-09-20 14:45:51',"23324");
//	echo "inserted";
//$mfg->deleteProduct('19','1');
//echo "deleted";
//$status = $mfg->checkMfgAccountRegistration("ptk","ptk1");
//echo $status;
?>
