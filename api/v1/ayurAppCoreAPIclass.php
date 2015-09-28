<?php
require_once 'baseAPIclass.php';
require_once '../../include/classes/manufacturerClass.php';
class MyAPI extends API
{
    protected $_origin;

    public function __construct($request, $origin) {
        parent::__construct($request);
        $this->_origin = $origin;
    }

    /**
     * Manufacturer Endpoint
     */
     protected function manufacturer($arguments) {

        $mfgObj = new ManufacturerClass;
        session_start();
       if ($this->method == 'POST') {
            switch ($this->verb) {
                case 'product':
                    {
                         if (session_id() != $this->request['token']) {
                             $data  = array(
                            'staus' => 'Failed',
                            'errorMsg' => 'Invalid User Token' );
                             return $data;
                        }else{

                            //Extract the POST values
                            $p_name = $this->request['prodName'];
                            $p_mfg_id = $_SESSION['MFG_ID'];
                            $p_reference = $this->request['prodReferences'];
                            $p_indic_contra = $this->request['prodIndicAndContradic'];
                            $p_dosage = $this->request['prodDosage'];
                            $p_user_guide = $this->request['prodUserGuide'];
                            $p_mrp = $this->request['prodMRP'];

                            // Save the Product details and retrive the p_id
                            $p_id = $mfgObj->addNewProduct($p_mfg_id,$p_name,'image/path',$p_reference,$p_indic_contra,$p_dosage,$p_user_guide,"batch","expiry",$p_mrp);
                            
                            // Decoding base64 Image data sent via POST
                            $encoded = $this->request['prodImage'];
                            $uploadedImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $encoded));

                            // Set the upload path of the file and save it.
                            $uploadPath = "../../manufacturer/images/m".$p_mfg_id."/products/p".$p_id.".png";
                            file_put_contents($uploadPath, $uploadedImage);

                            //Update the product info with the image uploaded path.
                            $mfgObj->updateProduct($p_id,$p_mfg_id,$p_name,$uploadPath,$p_reference,$p_indic_contra,$p_dosage,$p_user_guide,"batch","expiry",$p_mrp);

                            if($p_id != null){
                                $data = array('status' => 'success',
                                'prodID' =>$p_id,
                                'imgUploadPath' => $uploadPath,
                                'errorMsg' =>''
                                );
                            }else{
                                $data = array('status' => 'failed',
                                'errorMsg' =>'something went wrong'
                                );
                            }
                            return $data;
                        }
                        break;
                    }
                default:
                    $data  = array(
                        'staus' => 'Failed',
                        'errorMsg' => 'Invalid verb to this Endpoint' );
                    return $data;
                    break;
            }
            
        }else if ($this->method == 'GET') {
            switch ($this->verb) {
                case 'product':
                    {   
                        if (session_id() != $this->request['token']) {
                             $data  = array(
                            'staus' => 'Failed',
                            'errorMsg' => 'Invalid User Token' );
                             return $data;
                        }else{

                            if($this->args[0] == 'search'){

                                // Find out the sort
                                if($this->request['sort'] == 'A'){
                                    $sort = 'ASC';
                                }elseif ($this->request['sort'] == 'D') {
                                    $sort = 'DESC';
                                }else{
                                    $data = array('staus' =>'failure' ,
                                            'errorMsg' => 'Invalid sort option provided'
                                    );
                                     return $data;
                                }

                                // Check if search all
                                if($this->args[1] == '*'){
                                    $p_name = '%';
                                }else{
                                    $p_name = $this->args[1];
                                }

                                //Get the Manufacturer ID from session
                                $p_mfg_id = $_SESSION['MFG_ID'];
                                
                                // Fetch the Products results from the Database
                                $searchResults = $mfgObj->searchProduct($p_name,$p_mfg_id,$sort);

                                $data = array('staus' =>'success' ,
                                            'searchQuery' =>$this->args[1],
                                            'sort' => $sort,
                                            'searchResultsCount' =>count($searchResults),
                                            'searchResults' => $searchResults
                                 );
                                return $data;
                            
                            }else{
                                 $data  = array(
                                    'staus' => 'success',
                                    'errorMsg' => 'Endpoint ends here' );
                                return $data;
                            }
                        }
                       break; 
                    }
                default:
                    $data  = array(
                        'staus' => 'Failed',
                        'errorMsg' => 'Invalid verb to this Endpoint' );
                    return $data;
                    break;
            }
            
        
        } else {
            $data  = array(
                'staus' => 'Failed',
                'errorMsg' => 'This METHOD is not Allowed for this Endpoint'
            );
            return $data;
        }
     }
 }
 ?>