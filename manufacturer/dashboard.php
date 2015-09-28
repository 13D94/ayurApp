<?php require_once(__DIR__.'/../include/coreLibrary.php');
// Check the User Logged In Status, if not logged in redirect him to Manufacturer Login Page.
checkMfgLoggedInStatus("mfgDashboard");
$userSID = session_id();
//The parameter passed is the name of the current page.
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?=getHeadScriptTags('..');
      // load scripts and css from include/libs folder. Use . for previous directory
      ?>
    <!-- Site CSS -->
    <link rel="stylesheet" type="text/css" href="./style.css">
    <script type="text/javascript" src="../include/libs/cropit/jquery.cropit-0.4.4.js"></script>
    <link rel="stylesheet" type="text/css" href="../include/libs/bootstraptoggle/bootstrap-toggle.min.css">
    <script type="text/javascript" src="../include/libs/bootstraptoggle/bootstrap-toggle.min.js"></script>
    <title>Your Dashboard</title>
    <style type="text/css">
    .cropit-image-preview {
      width: 320px;
      height: 240px;
      cursor: move;
      border: 1px dashed green;
    }
  </style>
  <script type="text/javascript">
  $(function(){
   $('#image-cropper').cropit();
  });
  </script>
  </head>
  <body>
  <!-- Modals -->
  <div class="modal fade" id="addNewProductModal" tabindex="-1" role="dialog" aria-labelledby="addNewProductModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="addNewSubjectModal">Add a New Product</h4>
      </div>
      <div class="modal-body">
        <fieldset id="addNewProductFormFieldset">
        <form id="addNewProductForm" class="form-horizontal" data-parsley-validate>
          <div class="form-group">
            <label for="prodName" class="col-sm-2 control-label">Product Name :</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="prodName" id="prodName" placeholder="Name of the product" data-parsley-required-message="please enter the name of the product" required />
            </div>
          </div>
          <div class="form-group">
            <label for="prodImage" class="col-sm-2 control-label">Product Image :</label>
            <div class="col-sm-10">
              <div class="well well-sm">
              <!-- This wraps the whole cropper -->
              <div id="image-cropper" class="row">
                <div class="col-sm-6">
                   <input type="file" id="prodImage" class="cropit-image-input" data-parsley-trigger="change" data-parsley-required-message="please choosse an image for the product" required/>
                   <hr>
                   <p class="text-info">
                   Choose an image for your product and then adjust it with the help of the slider so that the product is clearly
                   visible.
                   </p>
                    <div style="text-align: center;margin-top:15px;">
                    <i class="fa fa-search-minus fa-2x" style="vertical-align: middle;"></i>&nbsp;
                    <input type="range" style="display: inline;width:inherit;vertical-align: middle;" class="cropit-image-zoom-input slider-custom" min="0" max="1" step="0.01">&nbsp;
                    <i class="fa fa-search-plus fa-2x" style="vertical-align: middle;"></i>
                    </div>
               </div>
                <div class=" col-sm-6 cropit-image-preview"></div>
                <input type="hidden" name="prodImage" class="cropped-image"/>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="prodReferences" class="col-sm-2 control-label">References :</label>
            <div class="col-sm-10">
              <textarea class="form-control" rows="3" name="prodReferences" id="prodReferences" placeholder="References of the Medicine (200 Characters)" style="resize: vertical;" data-parsley-required-message="please enter the references for the product" data-parsley-trigger="keyup" data-parsley-maxlength="200" required></textarea>
            </div>
          </div>
          <div class="form-group">
            <label for="prodIndicAndContradic" class="col-sm-2 control-label">Indication :<br>& Contradictions</label>
            <div class="col-sm-10">
              <textarea class="form-control" rows="3" name="prodIndicAndContradic" id="prodIndicAndContradic" placeholder="Indication and Contradictions of the Medicine (200 Characters)" style="resize: vertical;" data-parsley-required-message="please enter the indications and contradictions for the product" data-parsley-trigger="keyup" data-parsley-maxlength="200" required></textarea>
            </div>
          </div>
           <div class="form-group">
            <label for="prodDosage" class="col-sm-2 control-label">Dosage :</label>
            <div class="col-sm-10">
              <textarea class="form-control" rows="3" name="prodDosage" id="prodDosage" placeholder="Dosage of the Medicine (200 Characters)" style="resize: vertical;" data-parsley-required-message="please enter the dosage for the product" data-parsley-trigger="keyup" data-parsley-maxlength="200" required></textarea>
            </div>
          </div>
           <div class="form-group">
            <label for="prodUserGuide" class="col-sm-2 control-label">User Guide :</label>
            <div class="col-sm-10">
              <textarea class="form-control" rows="3" name="prodUserGuide" id="prodUserGuide" placeholder="User Guide of the Medicine (200 Characters)" style="resize: vertical;" data-parsley-required-message="please enter the user guide for the product" data-parsley-trigger="keyup" data-parsley-maxlength="200" required></textarea>
            </div>
          </div>
           <div class="form-group">
            <label for="prodMRP" class="col-sm-2 control-label">MRP 
            <i class="fa fa-rupee"></i> :</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="prodMRP" id="prodMRP" placeholder="Maximum Retail Price" data-parsley-required-message="please enter the mrp of the product" data-parsley-type="number" data-parsley-trigger="keyup" required / style="display:inline">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <input type="hidden" id="token" name="token" value="<?=$userSID;?>" />
              <button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Save the new product">Add Product</button>&nbsp;
              <button type="reset" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="Reset all the input data">Reset Fields</button>
            </div>
           </div>
        </form>
        </fieldset>
         <div class="form-group">
            <div class="col-sm-12 text-center" id="addProductStatusWindow">
           
            </div>
          </div>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    </div>
  </div>
  <div class="container">
    <div class="roundbox">
      <div class="row">
        <div class="col-md-2 col-md-offset-2 center-block" style="border-right: 1px solid #DDD;">
          <div class="well">
              <img src="..." alt="Manufacturer Company Logo" class="img-circle">
              <div class="caption">
                
              </div>
            </div>
            <form action="../include/logout.php" method="POST">
              <input type="hidden" name="logMeOut" value="mfg" />
              <input type="hidden" name="token" value="<?=$userSID;?>">
              <input type="submit" value="Logout" class="btn btn-danger" data-toggle="tooltip" data-placement="right" title="Log me out"/>
            </form>
        </div>
        <div class="col-md-6">
          <img src="" alt="maybeLogoHere" />
          our brand image and other stuffs.
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-md-3" style="border-right: 1px solid #DDD;">
          <div class="panel panel-primary">
            <div class="panel-heading">Quick Stats</div>
              <div class="panel-body">
                 <ul class="list-group">
                  <li class="list-group-item"><b>New Orders</b> <span class="label label-success label-as-badge" data-toggle="tooltip" data-placement="right" title="New Orders For You">42</span></li>
                  <li class="list-group-item">Processing Orders  <span class="label label-info label-as-badge" data-toggle="tooltip" data-placement="right" title="Orders You've marked Processing">12</span></li>
                </ul>
             </div>
          </div>
          <div class="panel panel-info">
             <div class="panel-heading">Notifications</div>
                <div class="panel-body">
                </div>
          </div>
          <hr>
        </div>  
        <div class="col-md-9">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
              <li role="presentation" class="active" data-toggle="tooltip" data-placement="top" title="All Order Details"><a href="#orders" aria-controls="orders" role="tab" data-toggle="tab">Orders</a></li>
              <li role="presentation" data-toggle="tooltip" data-placement="top" title="Products Management"><a href="#productCatalog" aria-controls="productCatalog" role="tab" data-toggle="tab">Product Catalog</a></li>
              <li role="presentation" data-toggle="tooltip" data-placement="top" title="View Your Reports"><a href="#reports" aria-controls="reports" role="tab" data-toggle="tab">Reports</a></li>
              <li role="presentation" data-toggle="tooltip" data-placement="top" title="Edit/Update Your Account"><a href="#myAccount" aria-controls="myAccount" role="tab" data-toggle="tab">My Account</a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane fade in active" id="orders">...</div>
              <div role="tabpanel" class="tab-pane fade" id="productCatalog">
                <div class="well" style="margin-top:10px;">
                  <div class="row">
                    <div class="col-sm-2">
                      <div data-toggle="tooltip" data-placement="top" title="Add a New Product">
                        <button class="btn btn-info" type="button" data-toggle="modal" data-target="#addNewProductModal">
                          <i class="fa fa-plus" aria-hidden="true"></i> Add Product
                        </button>
                      </div>
                   </div>
                     <div class="col-sm-2 pull-right" style="padding:0px;">
                    <div data-toggle="tooltip" data-placement="top" title="Sort Results">
                     <input type="checkbox" id="searchSorting" checked data-toggle="toggle" data-on="Ascending" data-width="120" data-off="Descending" data-onstyle="primary" data-offstyle="warning">
                      </div>
                   </div>
                   <div class="col-sm-3 pull-right">
                      <div data-toggle="tooltip" data-placement="top" title="List all Product">
                        <button class="btn btn-info" type="button" id="showAllProductsBtn">
                          <i class="fa fa-list" aria-hidden="true"></i> Show All My Products
                        </button>
                     </div>
                     </div>
                  </div>
                  <div class="row" style="margin-top:10px;">
                    <div class="col-sm-12">
                      <div class="input-group">
                        <input type="text" class="form-control" id="productSearchBox" placeholder="Enter a Product Name">
                        <span class="input-group-btn">
                          <button class="btn btn-success" type="button" id="productSearchBtn" data-toggle="tooltip" data-placement="top" title="Search Product">
                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Search
                          </button>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div role="tabpanel" class="tab-pane fade" id="reports">..ww.</div>
              <div role="tabpanel" class="tab-pane fade" id="myAccount">...ss</div>
            </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Site JS -->
  <script type="text/javascript" src="./script.js"></script>
  </body>
</html>
