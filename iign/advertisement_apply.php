<?php 
ini_set('display_errors', 1);
include("include/loader.php");
$advt_id = $userobj->getVariable("id");
$userid = $sesobj->get("user_id");
if(!$sesobj->isassign("user_id") || $advt_id == '' || !$advt_id) {
    header("Location: index.php");  
}else {	
    $query = "SELECT * FROM staff_recruitment_advertisement WHERE status = 1 AND is_deleted = 0 AND closing_date < DATE_ADD(CURDATE(), INTERVAL 1 DAY) AND id = '".$advt_id."'";
    $advertisement_det = $sqlobj->getdatalistfromquery($query);
    $basic_info_qry = "SELECT * FROM users WHERE user_id = '".$userid."'";
    $basic_details = $sqlobj->getdatalistfromquery($basic_info_qry);
    $countries_qry = "SELECT * FROM countries";
    $countries_list = $sqlobj->getdatalistfromquery($countries_qry);
    $fee_qry = "SELECT * FROM user_application_fee WHERE user_id = '".$userid."'";
    $fee_details =  $sqlobj->getdatalistfromquery($fee_qry);
       
    if(!count($advertisement_det))
        header("Location: index.php");       
}
include_once("header.php");
?>
<div class="header-fixed-top sidebar-partial sidebar-visible-lg sidebar-no-animations" id="page-container">
        <div id="sidebar">
            <div class="sidebar-scroll">
                <div class="sidebar-content">
                    <a class="sidebar-brand" href="#"><i class="fa fa-graduation-cap"></i><strong>IIT </strong>
                        GN </a>
                    <div class="sidebar-section sidebar-user clearfix">
                      <!--  <div class="sidebar-user-avatar">
                            <a href="#">
                                <img alt="avatar" src="img/user_photo.jpg">
                            </a>
                        </div>
                        <div class="sidebar-user-name">
                            Cheekati Yeshwanth
                        </div>-->
                    </div>
               <ul class="sidebar-nav">
                        <li class="active"><a href="#"><i class="fa fa-file sidebar-nav-icon"></i>Application Form
                             </a></li>
                        <li ><a href="#"><i class="fa fa-info-circle sidebar-nav-icon"></i>
                            Instructions </a></li>
                    </ul> 
                </div>
            </div>
        </div>
        <div id="main-container">
            <header class="navbar navbar-default navbar-fixed-top">
               <ul class="nav navbar-nav-custom">
               
                  <li><a onclick="App.sidebar('toggle-sidebar');" href="javascript:void(0)"><i class="fa fa-bars fa-fw">
                     </i></a>
                  </li>
               </ul>
             <!--  <form role="search" class="navbar-form-custom" method="post" action="">
                  <div class="form-group">
                     <input type="text" placeholder="Search.." class="form-control" name="top-search" id="top-search">
                  </div>
               </form>-->


             <ul class="nav navbar-nav-custom pull-right">
                
                     <li>
                     <a style="color:#394263; font-size:20px; padding-right:20px;"> Staff Application Portal</a>
                  </li>
                

                  </ul> 
            </header>
            <div id="page-content"  >
             <!--   <ul class="breadcrumb breadcrumb-top">
                    <li><i class="fa fa-home"></i>Home </li>
                   <li>
                     <a href="">
                     Charts
                     </a>
                     </li>
                </ul>-->
                <h3>
                    Application for Staff Appointment</h3>
                <div class="block">
                    <form onsubmit="return false;" class="form-horizontal" method="post" action="">
                    <div class="form-group">
                        <div class="col-md-4">
                            <label for="example-nf-email">
                                Date of Application</label>
                            <input type="text" placeholder="dd/mm/yy" data-date-format="dd/mm/yy" disabled="disabled" class="form-control input-datepicker"
                                name="example-datepicker2" id="example-datepicker2" value="<?php echo date('d/m/Y'); ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="example-nf-email">
                                Post applied for:</label>
                              <input type="text" placeholder="Post" value="<?php echo $advertisement_det[0]['position']; ?>" disabled="disabled" class="form-control" name="example-text-input"
                                            id="Text26">
                        </div>                      
                    </div>
                    </form>
                </div>




                <div class="panel-group" id="faq2">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <h4 class="panel-title"><i class="fa fa-angle-right"></i> <a href="#faq2_q1" data-parent="#faq2" data-toggle="collapse" class="accordion-toggle">
                                            
                                            Basic Information</a></h4>
                                        </div>
                                        <div class="panel-collapse collapse in" id="faq2_q1" style="height: auto;">
                                            <div class="panel-body">
                                            
                                            
                             
                    <form onsubmit="return false;" class="form-horizontal form-bordered" method="post"
                            action="" name="basicInfoFrm" id="basicInfoFrm">
                        <fieldset>
                                <legend>Name</legend>                               
               
                                <div class="form-group">
                                  
                                    <div class="col-md-4">
                                        <input type="text" name="first_name" id="first_name" placeholder="First Name" class="form-control" 
                                            value="<?php echo $basic_details[0]['first_name']; ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" placeholder="Middle Name" class="form-control" name="middle_name"
                                            id="middle_name" value="<?php echo $basic_details[0]['middle_name']; ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" placeholder="Last Name/Sur Name" class="form-control" name="last_name"
                                            id="last_name" value="<?php echo $basic_details[0]['last_name']; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                  
                                    <div class="col-md-4">
                                        <input type="text" placeholder="Name of Spouse / Father" class="form-control" name="father_name"
                                            id="father_name" value="<?php echo $basic_details[0]['father_name']; ?>">
                                    </div>
                                    
                                </div>
                                
                            </fieldset>
                            <fieldset>
                                <legend>Personal Details</legend>
                                  <div class="form-group">
                                    <div class="col-md-4">
                                        <label for="example-nf-email">
                                            Category
                                        </label>
                                         <select size="1" class="form-control" name="category" id="category">
                                            <option value="0">Please select</option>
                                            <option value="general" <?php echo ($basic_details[0]['category'] == 'general') ? 'selected' : ''; ?>>General</option>
                                            <option value="sc" <?php echo ($basic_details[0]['category'] == 'sc') ? 'selected' : ''; ?>>SC</option>
                                            <option value="st" <?php echo ($basic_details[0]['category'] == 'st') ? 'selected' : ''; ?>>ST</option>
                                            <option value="obc" <?php echo ($basic_details[0]['category'] == 'obc') ? 'selected' : ''; ?>>OBC</option>
                                             <option value="pwd(sc)" <?php echo ($basic_details[0]['category'] == 'pwd(sc)') ? 'selected' : ''; ?>>PWD(SC)</option>
                                            <option value="pwd(st)" <?php echo ($basic_details[0]['category'] == 'pwd(st)') ? 'selected' : ''; ?>>PWD(ST)</option>
                                            <option value="pwd(obc)" <?php echo ($basic_details[0]['category'] == 'pwd(obc)') ? 'selected' : ''; ?>>PWD(OBC)</option>
                                            <option value="pwd(general)" <?php echo ($basic_details[0]['category'] == 'pwd(general)') ? 'selected' : ''; ?>>PWD(General)</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                    <input type="file" id="category_Certificate" name="category_Certificate">
                                    <span class="help-block"> (For SC/ST/PH.OBC-non creamy layer category pl.attach self attested copy of certificate) </span>
                                   
                                    </div>

                                    <div class="col-md-4">
                                        <label for="example-nf-email">
                                            Minority
                                        </label>
                                        <select size="1" class="form-control" name="example-select" id="Select9">
                                            <option value="0">Please select</option>
                                            <option value="yes" <?php echo ($basic_details[0]['minority'] == 'yes') ? 'selected' : ''; ?>>Yes</option>
                                            <option value="no" <?php echo ($basic_details[0]['minority'] == 'no') ? 'selected' : ''; ?>>No</option>
                                        </select>
                                    </div>
                                  </div>
                                   <div class="form-group">

                                   <div class="col-md-4">
                                        <label for="example-nf-email">
                                            Community
                                        </label>
                                         <select id="Select10" name="example-select" class="form-control" size="1">
                                            <option value="0">Please select</option>
                                            <option value="muslims" <?php echo ($basic_details[0]['community'] == 'muslims') ? 'selected' : ''; ?>>Muslims</option>
                                            <option value="christians" <?php echo ($basic_details[0]['community'] == 'christians') ? 'selected' : ''; ?>>Christians</option>
                                            <option value="sikhs" <?php echo ($basic_details[0]['community'] == 'sikhs') ? 'selected' : ''; ?>>Sikhs</option>
                                            <option value="buddhism" <?php echo ($basic_details[0]['community'] == 'buddhism') ? 'selected' : ''; ?>>Buddhism</option>
                                             <option value="zoroastrianism (parsi)" <?php echo ($basic_details[0]['community'] == 'zoroastrianism (parsi)') ? 'selected' : ''; ?>>zoroastrianism (Parsi)</option>
                                            <option value="jains" <?php echo ($basic_details[0]['community'] == 'jains') ? 'selected' : ''; ?>>Jains</option>
                                            
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="example-nf-email">
                                            Ex-Servicemen
                                        </label>
                                         <select id="ex_serviceman" name="ex_serviceman" class="form-control" size="1">
                                             <option value="0">Please select</option>
                                            <option value="yes" <?php echo ($basic_details[0]['ex_serviceman'] == 'yes') ? 'selected' : ''; ?>>Yes</option>
                                            <option value="no" <?php echo ($basic_details[0]['ex_serviceman'] == 'no') ? 'selected' : ''; ?>>No</option>
                                            
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="example-nf-email">
                                            Currently working in Any IIT
                                           </label>
                                        <select size="1" class="form-control" name="example-select" id="Select12">
                                            <option value="0">Please select</option>
                                            <option value="yes" <?php echo ($basic_details[0]['working_in_iit'] == 'yes') ? 'selected' : ''; ?>>Yes</option>
                                            <option value="no" <?php echo ($basic_details[0]['working_in_iit'] == 'no') ? 'selected' : ''; ?>>No</option>
                                        </select>
                                    </div>


                                   </div>
                                <?php
                                    if($basic_details[0]['dob'] != '')
                                    {                                        
                                        $myDateTime = DateTime::createFromFormat('Y-m-d', $basic_details[0]['dob']);
                                        $dbvalue = $myDateTime->format('d/m/Y');
                                    }
                                    else
                                        $dbvalue = '';
                                ?>
                                   
                                <div class="form-group">

                                <div class="col-md-4">
                                        <label for="example-nf-email">
                                            Date of Birth
                                        </label>
                                        <input type="text" id="dob" name="dob" value="<?php echo $dbvalue; ?>" class="form-control input-datepicker" data-date-format="dd/mm/yy" placeholder="dd/mm/yy">
                                    </div>


                                    <div class="col-md-4">
                                        <label for="example-nf-email">
                                            Gender
                                        </label>
                                        <select id="gender" name="gender" class="form-control" size="1">
                                            <option value="0">Please select</option>
                                            <option value="male" <?php echo ($basic_details[0]['gender'] == 'male') ? 'selected' : ''; ?>>Male</option>
                                            <option value="female" <?php echo ($basic_details[0]['gender'] == 'female') ? 'selected' : ''; ?>>Female</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="example-nf-email">
                                            Marital Status
                                        </label>
                                           <select id="marital_status" name="marital_status" class="form-control" size="1">
                                             <option value="0">Please select</option>
                                            <option value="single" <?php echo ($basic_details[0]['marital_status'] == 'single') ? 'selected' : ''; ?>>Single</option>
                                            <option value="married" <?php echo ($basic_details[0]['marital_status'] == 'married') ? 'selected' : ''; ?>>Married</option>
                                            
                                        </select>
                                    </div>
                                </div>

                                    <div class="form-group">
                                    <div class="col-md-4">
                                        <label for="example-nf-email">
                                            Nationality
                                        </label>
                                        <select style="width: 250px; display: none;" data-placeholder="Choose a Country.."
                                            class="select-chosen" name="nationality" id="nationality">
                                            <option></option>
                                            <!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                              <option value="0">Please select</option>
                                            <?php foreach($countries_list as $key => $val) { ?>
                                                <option value="<?php echo $val['country_code']; ?>" <?php echo ($basic_details[0]['nationality'] == $val['country_code']) ? 'selected' : ''; ?>><?php echo $val['country_name']; ?></option>
                                            <?php } ?>
                                         </select>
                                    </div>
                                    </div>


                           

                            </fieldset>
                            <fieldset>
                                <legend>Address</legend>
                                <div class="form-group">
                                    
                                    <div class="col-md-6">
                                        <label for="example-nf-email">
                                            Mailing Address
                                        </label>
                                        <textarea placeholder="Address.." class="form-control" rows="3" name="mailing_address"
                                            id="mailing_address" value="<?php echo $basic_details[0]['mailing_address']; ?>"></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="example-nf-email">
                                            Permanant Address
                                        </label>
                                        <textarea placeholder="Address.." class="form-control" rows="3" name="permanent_address"
                                            id="permanent_address" value="<?php echo $basic_details[0]['permanent_address']; ?>"></textarea>
                                    </div>
                                </div>
                            </fieldset>
                              <fieldset>
                                <legend>Contact Details (with STD/ISD code) </legend>
                                <div class="form-group">
                                   
                                    <div class="col-md-6">
                                        <label for="example-nf-email">
                                            Phone (Mobile):
                                        </label>
                                        <input type="text" placeholder="" class="form-control" name="mobile"
                                            id="mobile" value="<?php echo $basic_details[0]['mobile']; ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="example-nf-email">
                                            Phone (Landline):
                                        </label>
                                        <input type="text" placeholder="" class="form-control" name="landline"
                                            id="landline" value="<?php echo $basic_details[0]['landline']; ?>">
                                    </div>
                                 
                                </div>
                                <div class="form-group">
                                   <div class="col-md-6">
                                        <label for="example-nf-email">
                                            Fax:
                                        </label>
                                        <input type="text" placeholder="" class="form-control" name="example-email-input"
                                            id="Email7" value="<?php echo $basic_details[0]['fax']; ?>">
                                      
                                    </div>
                                   
                                    <div class="col-md-6">
                                        <label for="example-nf-email">
                                            E-mail ID:
                                        </label>
                                        <input type="email" placeholder="" class="form-control" name="email"
                                            id="email" value="<?php echo $basic_details[0]['email']; ?>">
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Application Fee Details  </legend>
                                <div class="form-group">
                                   
                                    <div class="col-md-4">
                                        <label for="example-nf-email">
                                            DD Number
                                        </label>
                                        <input type="text" placeholder="" class="form-control" name="dd_no"
                                            id="dd_no" value="<?php echo (isset($fee_details[0]['dd_no'])) ? $fee_details[0]['dd_no'] : '' ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="example-nf-email">
                                           Date of Issue
                                        </label>
                                          <input type="text" placeholder="dd/mm/yy" data-date-format="dd/mm/yy" class="form-control input-datepicker"
                                            name="date_of_issue" id="date_of_issue" value="<?php echo (isset($fee_details[0]['date_of_issue'])) ? date_format('d/m/Y', strtotime($fee_details[0]['date_of_issue'])) : '' ?>">
                                    </div>

                                        <div class="col-md-4">
                                        <label for="example-nf-email">
                                           Issuing Bank
                                        </label>
                                        <input type="text" placeholder="" class="form-control" name="bank"
                                            id="bank" value="<?php echo (isset($fee_details[0]['bank'])) ? $fee_details[0]['bank'] : '' ?>">
                                    </div>
                                 
                                </div>
                                <div class="form-group">
                                   <div class="col-md-4">
                                        <label for="example-nf-email">
                                            Issuing Branch
                                        </label>
                                        <input type="text" placeholder="" class="form-control" name="branch"
                                            id="branch" value="<?php echo (isset($fee_details[0]['branch'])) ? $fee_details[0]['branch'] : '' ?>">
                                        
                                    </div>
                                   
                                    <div class="col-md-4">
                                        <label for="example-nf-email">
                                          Amount
                                        </label>
                                        <input type="email" placeholder="" class="form-control" name="amount"
                                            id="amount" value="<?php echo (isset($fee_details[0]['amount'])) ? $fee_details[0]['amount'] : '' ?>">
                                    </div>
                                </div>
                            </fieldset>

                                    <div class="form-group form-actions">
                                        <div class="col-md-12">
                                            <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-save"></i> Save</button>
                                            <button class="btn btn-sm btn-warning" type="reset"><i class="fa fa-repeat"></i> Reset</button>
                                        </div>
                                    </div>
                            </form>                                            
                                            
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <h4 class="panel-title"><i class="fa fa-angle-right"></i> <a href="#faq2_q2" data-parent="#faq2" data-toggle="collapse" class="accordion-toggle collapsed">Academic Qualifications</a></h4>
                                        </div>
                                        <div class="panel-collapse collapse" id="faq2_q2">
                                            <div class="panel-body">
                                            
                                                <form onsubmit="return false;" class="form-horizontal form-bordered" method="post"
                            action="">
                            <fieldset>
                                <legend> Academic record starting with Bachelor’s degree For Group A, Academic record starting with Matriculation degree For Group B & C 
                                </legend>

                                     
                                <div class="form-group">

                                <!-- <div class="col-md-12">
                                        <label for="example-nf-email">
                                             Attach File
                                        </label>
                                         <input type="file" multiple="" name="example-file-multiple-input" id="example-file-multiple-input">
                                        <span class="help-block">(Please attach unofficial transcripts/ mark sheets/ grade cards
                                            for all your degrees):</span>
                                    </div>!-->

                                     </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="block full">
                                            <div class="block-title">
                                                <h2>
                                                    Details
                                                </h2>
                                                <div class="block-options pull-right">
                                                    <a title="" data-toggle="tooltip" class="btn btn-alt btn-sm btn-default btn-option"
                                                        href="javascript:void(0)" data-original-title="Edit"><i class="fa fa-pencil"></i>
                                                    </a><a title="" data-toggle="tooltip" class="btn btn-alt btn-sm btn-success btn-option"
                                                        href="javascript:void(0)" data-original-title="Add"><i class="fa fa-plus"></i>
                                                    </a><a title="" data-toggle="tooltip" class="btn btn-alt btn-sm btn-danger btn-option"
                                                        href="javascript:void(0)" data-original-title="Delete"><i class="fa fa-times"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-vcenter table-striped">
                                                    <thead>
                                                        <tr>
                                                            <td style="width: 50px">
                                                                <input type="checkbox">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <strong>Degree</strong>
                                                            </td>
                                                            <td style="width: 15%">
                                                                <strong>Specialization / Discipline</strong>
                                                            </td>
                                                            <td style="width: 35%">
                                                                <strong>College/University/Institute</strong>
                                                            </td>
                                                            <td style="width: 10%">
                                                                <strong>Year of joining</strong>
                                                            </td>
                                                            <td style="width: 10%">
                                                                <strong>Year of leaving</strong>
                                                            </td>
                                                            <td style="width: 10%">
                                                                <strong>Percentage/ CGPA</strong>
                                                            </td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox">
                                                            </td>
                                                            <td>
                                                                <input type="text" placeholder="Degree" class="form-control" name="example-text-input"
                                                                    id="Text4">
                                                            </td>
                                                            <td>
                                                                <input type="text" placeholder="Specialization / Discipline" class="form-control"
                                                                    name="example-text-input" id="Text5">
                                                            </td>
                                                            <td>
                                                                <input type="text" placeholder="College/University/Institute" class="form-control"
                                                                    name="example-text-input" id="Text6">
                                                            </td>
                                                            <td>
                                                                <input type="text" placeholder="Year of joining" class="form-control" name="example-text-input"
                                                                    id="Text7">
                                                            </td>
                                                            <td>
                                                                <input type="text" placeholder="Year of leaving" class="form-control" name="example-text-input"
                                                                    id="Text8">
                                                            </td>
                                                            <td>
                                                                <input type="text" placeholder="Percentage/ CGPAe" class="form-control" name="example-text-input"
                                                                    id="Text9">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="form-group form-actions">
                                        <div class="col-md-12">
                                            <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-save"></i> Save</button>
                                            <button class="btn btn-sm btn-warning" type="reset"><i class="fa fa-repeat"></i> Reset</button>
                                        </div>
                                    </div>
                                  
                            </form>
                                            
                                            
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <h4 class="panel-title"><i class="fa fa-angle-right"></i> <a href="#faq2_q3" data-parent="#faq2" data-toggle="collapse" class="accordion-toggle collapsed">Work Experience</a></h4>
                                        </div>
                                        <div class="panel-collapse collapse" id="faq2_q3">
                                            <div class="panel-body">
                                            
                                            <div  class="form-horizontal form-bordered"  >
                                            <fieldset>
                                <legend>    Employment History  (in chronological order, ending with present job

                                </legend>
                                
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="block full">
                                            <div class="block-title">
                                                <h2>
                                                    Details
                                                </h2>
                                                <div class="block-options pull-right">
                                                    <a title="" data-toggle="tooltip" class="btn btn-alt btn-sm btn-default btn-option"
                                                        href="javascript:void(0)" data-original-title="Edit"><i class="fa fa-pencil"></i>
                                                    </a><a title="" data-toggle="tooltip" class="btn btn-alt btn-sm btn-success btn-option"
                                                        href="javascript:void(0)" data-original-title="Add"><i class="fa fa-plus"></i>
                                                    </a><a title="" data-toggle="tooltip" class="btn btn-alt btn-sm btn-danger btn-option"
                                                        href="javascript:void(0)" data-original-title="Delete"><i class="fa fa-times"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-vcenter table-striped">
                                                    <thead>
                                                        <tr>
                                                            <td style="width: 50px">
                                                                <input type="checkbox">
                                                            </td>
                                                            <td style="width: 10%">
                                                                <strong>Designation</strong>
                                                            </td>
                                                            <td style="width: 20%">
                                                                <strong>Organization/Institution</strong>
                                                            </td>
                                                           <td>
                                                           <strong>Nature of Work</strong>
                                                           </td>
                                                            <td style="width: 10%">
                                                                <strong>Date of joining</strong>
                                                            </td>
                                                            <td style="width: 10%">
                                                                <strong>Date of leaving</strong>
                                                            </td>
                                                            <td style="width: 5%">
                                                                <strong>Duration In Months</strong>
                                                            </td>
                                                                <td style="width: 10%">
                                                                <strong>Pay Band with Grade Pay</strong>
                                                            </td>
                                                             </td>
                                                                <td style="width: 10%">
                                                                <strong>Gross Salary</strong>
                                                            </td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox">
                                                            </td>
                                                            <td>
                                                                <input type="text" placeholder="Designation" class="form-control" name="example-text-input"
                                                                    id="Text10">
                                                            </td>
                                                            <td>
                                                                <input type="text" placeholder="Organization/Institution" class="form-control"
                                                                    name="example-text-input" id="Text11">
                                                            </td>
                                                              <td>
                                                                <input type="text" placeholder="Nature of work" class="form-control" name="example-text-input"
                                                                    id="Text22">
                                                            </td>
                                                          
                                                            <td>
                                                                <input type="text" placeholder="Date of joining" class="form-control" name="example-text-input"
                                                                    id="Text13">
                                                            </td>

                                                            <td>
                                                                <input type="text" placeholder="Date of leaving" class="form-control" name="example-text-input"
                                                                    id="Text14">
                                                            </td>
                                                            <td>
                                                                <input type="text" placeholder="Duration" class="form-control" name="example-text-input"
                                                                    id="Text15">
                                                            </td>
                                                              <td>
                                                                <input type="text" placeholder="Pay Band with Grade Pay" class="form-control" name="example-text-input"
                                                                    id="Text23">
                                                            </td>
                                                              <td>
                                                                <input type="text" placeholder="Gross Salary" class="form-control" name="example-text-input"
                                                                    id="Text27">
                                                            </td>   
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>



                                        </div>
                                    </div>
                                </div>



                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="block full">
                                            <div class="block-title">
                                                <h2>
                                                    Membership of Professional Bodies:
                                                </h2>
                                                <div class="block-options pull-right">
                                                    <a title="" data-toggle="tooltip" class="btn btn-alt btn-sm btn-default btn-option"
                                                        href="javascript:void(0)" data-original-title="Edit"><i class="fa fa-pencil"></i>
                                                    </a><a title="" data-toggle="tooltip" class="btn btn-alt btn-sm btn-success btn-option"
                                                        href="javascript:void(0)" data-original-title="Add"><i class="fa fa-plus"></i>
                                                    </a><a title="" data-toggle="tooltip" class="btn btn-alt btn-sm btn-danger btn-option"
                                                        href="javascript:void(0)" data-original-title="Delete"><i class="fa fa-times"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-vcenter table-striped">
                                                    <thead>
                                                        <tr>
                                                            <td style="width: 50px">
                                                                <input type="checkbox">
                                                            </td>
                                                            <td style="width: 70%">
                                                                <strong>Name of Body</strong>
                                                            </td>
                                                            <td style="width: 20%">
                                                                <strong>Statues of Membership : Life/ Annual (For Group A)</strong>
                                                            </td>
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox">
                                                            </td>
                                                            <td>
                                                                <input type="text" placeholder="" class="form-control" name="example-text-input"
                                                                    id="Text24">
                                                            </td>
                                                            <td>
                                                                <input type="text" placeholder="" class="form-control"
                                                                    name="example-text-input" id="Text25">
                                                            </td>
                                                               
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>



                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="form-group form-actions">
                                        <div class="col-md-12">
                                            <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-save"></i> Save</button>
                                            <button class="btn btn-sm btn-warning" type="reset"><i class="fa fa-repeat"></i> Reset</button>
                                        </div>
                                    </div>
                            </div>
                                            
                                            
                                            
                                            
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <h4 class="panel-title"><i class="fa fa-angle-right"></i> <a href="#faq2_q4" data-parent="#faq2" data-toggle="collapse" class="accordion-toggle collapsed">Professional Training
</a></h4>
                                        </div>
                                        <div class="panel-collapse collapse" id="faq2_q4">
                                            <div class="panel-body">
                                            
                                           <div class="form-horizontal form-bordered">

                                           
                            <fieldset>
                                <legend> Not leading to a degree
                                </legend>
                                
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="block full">
                                            <div class="block-title">
                                                <h2>
                                                    Details
                                                </h2>
                                                <div class="block-options pull-right">
                                                    <a title="" data-toggle="tooltip" class="btn btn-alt btn-sm btn-default btn-option"
                                                        href="javascript:void(0)" data-original-title="Edit"><i class="fa fa-pencil"></i>
                                                    </a><a title="" data-toggle="tooltip" class="btn btn-alt btn-sm btn-success btn-option"
                                                        href="javascript:void(0)" data-original-title="Add"><i class="fa fa-plus"></i>
                                                    </a><a title="" data-toggle="tooltip" class="btn btn-alt btn-sm btn-danger btn-option"
                                                        href="javascript:void(0)" data-original-title="Delete"><i class="fa fa-times"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-vcenter table-striped">
                                                    <thead>
                                                        <tr>
                                                            <td style="width: 50px">
                                                                <input type="checkbox">
                                                            </td>
                                                            <td style="width: 30%">
                                                                <strong>Name of Institution</strong>
                                                            </td>
                                                            <td style="width: 30%">
                                                                <strong>Description</strong>
                                                            </td>
                                                           
                                                            <td style="width: 15%">
                                                                <strong>Start Date</strong>
                                                            </td>
                                                               <td style="width: 15%">
                                                                <strong>End Date</strong>
                                                            </td>
                                                            <td style="width: 20%">
                                                                <strong>Duration In Days</strong>
                                                            </td>
                                                         
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox">
                                                            </td>
                                                            <td>
                                                                <input type="text" placeholder="" class="form-control" name="example-text-input"
                                                                    id="Text12">
                                                            </td>
                                                            <td>
                                                                <input type="text" placeholder="" class="form-control"
                                                                    name="example-text-input" id="Text16">
                                                            </td>
                                                          
                                                            <td>
                                                                   <input type="text" placeholder="dd/mm/yy" data-date-format="dd/mm/yy" class="form-control input-datepicker"
                                            name="example-datepicker2" id="Text17">
                                                            </td>
                                                            <td>
                                                                   <input type="text" placeholder="dd/mm/yy" data-date-format="dd/mm/yy" class="form-control input-datepicker"
                                            name="example-datepicker2" id="Text18">
                                                            </td>
                                                             <td>
                                                                <input type="text" placeholder="" class="form-control"
                                                                    name="example-text-input" id="Text20">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>


                    
                            <div class="form-group form-actions">
                                        <div class="col-md-12">
                                            <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-save"></i> Save</button>
                                            <button class="btn btn-sm btn-warning" type="reset"><i class="fa fa-repeat"></i> Reset</button>
                                        </div>
                                    </div>
                                           
                                           </div>
                                            
                                            
                                            </div>
                                        </div>
                                    </div>


                                        

                                      <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <h4 class="panel-title"><i class="fa fa-angle-right"></i> <a href="#faq2_q6" data-parent="#faq2" data-toggle="collapse" class="accordion-toggle collapsed">Overall Grading (only for Deputation) </a></h4>
                                        </div>
                                        <div class="panel-collapse collapse" id="faq2_q6">
                                            <div class="panel-body">
                                            
                                            <div class="form-horizontal form-bordered">

                 <fieldset>
                                <legend>In APARs for last 5 years :
                                </legend>
                                
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="block full">
                                            <div class="block-title">
                                                <h2>
                                                    Details
                                                </h2>
                                            
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-vcenter table-striped">
                                                    <thead>
                                                        <tr>
                                                          
                                                           
                                                            <td style="width: 20%">
                                                                <strong>09-10</strong>
                                                            </td>
                                                            <td style="width: 20%">
                                                                <strong>10-11</strong>
                                                            </td>
                                                               <td style="width: 20%">
                                                                <strong>11-12</strong>
                                                            </td>
                                                                
                                                               <td style="width: 20%">
                                                                <strong>12-13</strong>
                                                            </td>
                                                             <td style="width: 20%">
                                                                <strong>13-14</strong>
                                                            </td>
                                                         
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                          
                                                            <td>
                                                                <input type="text" placeholder="" class="form-control"
                                                                    name="example-text-input" id="Text73">
                                                            </td>
                                                          
                                                            <td>
                                                                <input type="text" placeholder="" class="form-control" name="example-text-input"
                                                                    id="Text74">
                                                            </td>
                                                            <td>
                                                                <input type="text" placeholder="" class="form-control" name="example-text-input"
                                                                    id="Text75">
                                                            </td>
                                                             <td>
                                                                <input type="text" placeholder="" class="form-control" name="example-text-input"
                                                                    id="Text76">
                                                            </td>
                                                          
                                                              <td>
                                                                <input type="text" placeholder="" class="form-control" name="example-text-input"
                                                                    id="Text78">
                                                            </td>
                                                          
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>

                            
                            <div class="form-group form-actions">
                                        <div class="col-md-12">
                                            <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-save"></i> Save</button>
                                            <button class="btn btn-sm btn-warning" type="reset"><i class="fa fa-repeat"></i> Reset</button>
                                        </div>
                                    </div>
                                           
                                           </div>
                                            
                                            
                                            </div>
                                        </div>
                                    </div>

                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <h4 class="panel-title"><i class="fa fa-angle-right"></i> <a href="#faq2_q7" data-parent="#faq2" data-toggle="collapse" class="accordion-toggle collapsed">Finalize Application</a></h4>
                                        </div>
                                        <div class="panel-collapse collapse" id="faq2_q7">
                                            <div class="panel-body">
                                            
                                            <div class="form-horizontal form-bordered">
                                              <fieldset>
                                <legend> Information of Three Referees 
                                </legend>
                                
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="block full">
                                            <div class="block-title">
                                                <h2>
                                                   It is preferable that you include your Reporting Officer and someone who is familiar with your recent work
                                                </h2>
                                                 
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-vcenter table-striped">
                                                    <thead>
                                                        <tr>
                                                             <td style="width:25%"></td>
                                                            <td style="width: 25%">
                                                                <strong>Referee 1 </strong>
                                                            </td>
                                                            <td style="width: 25%">
                                                                <strong>Referee 2</strong>
                                                            </td>
                                                           
                                                            <td style="width: 25%">
                                                                <strong>Referee 3</strong>
                                                            </td>
                                                             
                                                         
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                               Name
                                                            </td>
                                                            <td>
                                                                <input type="text" placeholder="" class="form-control" name="example-text-input"
                                                                    id="Text34">
                                                            </td>
                                                            <td>
                                                                <input type="text" placeholder="" class="form-control"
                                                                    name="example-text-input" id="Text35">
                                                            </td>
                                                          
                                                            <td>
                                                                <input type="text" placeholder="" class="form-control" name="example-text-input"
                                                                    id="Text36">
                                                            </td>
                                                            
                                                          
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                              Designation
                                                            </td>
                                                            <td>
                                                                <input type="text" placeholder="" class="form-control" name="example-text-input"
                                                                    id="Text37">
                                                            </td>
                                                            <td>
                                                                <input type="text" placeholder="" class="form-control"
                                                                    name="example-text-input" id="Text38">
                                                            </td>
                                                          
                                                            <td>
                                                                <input type="text" placeholder="" class="form-control" name="example-text-input"
                                                                    id="Text39">
                                                            </td>
                                                            
                                                          
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                             Organization/Institute
                                                            </td>
                                                            <td>
                                                                <input type="text" placeholder="" class="form-control" name="example-text-input"
                                                                    id="Text40">
                                                            </td>
                                                            <td>
                                                                <input type="text" placeholder="" class="form-control"
                                                                    name="example-text-input" id="Text41">
                                                            </td>
                                                          
                                                            <td>
                                                                <input type="text" placeholder="" class="form-control" name="example-text-input"
                                                                    id="Text42">
                                                            </td>
                                                            
                                                          
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                             Mailing Address
                                                            </td>
                                                            <td>
                                                                <input type="text" placeholder="" class="form-control" name="example-text-input"
                                                                    id="Text43">
                                                            </td>
                                                            <td>
                                                                <input type="text" placeholder="" class="form-control"
                                                                    name="example-text-input" id="Text44">
                                                            </td>
                                                          
                                                            <td>
                                                                <input type="text" placeholder="" class="form-control" name="example-text-input"
                                                                    id="Text45">
                                                            </td>
                                                            
                                                          
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                             Mobile Number  
                                                            </td>
                                                            <td>
                                                                <input type="text" placeholder="" class="form-control" name="example-text-input"
                                                                    id="Text46">
                                                            </td>
                                                            <td>
                                                                <input type="text" placeholder="" class="form-control"
                                                                    name="example-text-input" id="Text47">
                                                            </td>
                                                          
                                                            <td>
                                                                <input type="text" placeholder="" class="form-control" name="example-text-input"
                                                                    id="Text48">
                                                            </td>
                                                            
                                                          
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                            Alternate Telephone
                                                            </td>
                                                            <td>
                                                                <input type="text" placeholder="" class="form-control" name="example-text-input"
                                                                    id="Text49">
                                                            </td>
                                                            <td>
                                                                <input type="text" placeholder="" class="form-control"
                                                                    name="example-text-input" id="Text50">
                                                            </td>
                                                          
                                                            <td>
                                                                <input type="text" placeholder="" class="form-control" name="example-text-input"
                                                                    id="Text51">
                                                            </td>
                                                            
                                                          
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                            Fax
                                                            </td>
                                                            <td>
                                                                <input type="text" placeholder="" class="form-control" name="example-text-input"
                                                                    id="Text52">
                                                            </td>
                                                            <td>
                                                                <input type="text" placeholder="" class="form-control"
                                                                    name="example-text-input" id="Text53">
                                                            </td>
                                                          
                                                            <td>
                                                                <input type="text" placeholder="" class="form-control" name="example-text-input"
                                                                    id="Text54">
                                                            </td>
                                                            
                                                          
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                            Email
                                                            </td>
                                                            <td>
                                                                <input type="text" placeholder="" class="form-control" name="example-text-input"
                                                                    id="Text55">
                                                            </td>
                                                            <td>
                                                                <input type="text" placeholder="" class="form-control"
                                                                    name="example-text-input" id="Text56">
                                                            </td>
                                                          
                                                            <td>
                                                                <input type="text" placeholder="" class="form-control" name="example-text-input"
                                                                    id="Text57">
                                                            </td>
                                                            
                                                          
                                                        </tr>   
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>

                            
                            
                            <fieldset>
                                <legend> Statement of Objectives (Mandatory for Group A Positions) </legend>
                                <div class="form-group">
 
                                  <div class="form-group">

                              
                                 
                                    <div class="col-md-12">
                                         <label for="example-nf-email">
                                          Please indicate as to why you wish to join IIT Gandhinagar. (upto 200 words)
                                        </label>
                                        <textarea placeholder=" " class="form-control" rows="3" name="example-textarea-input"
                                            id="Textarea2"></textarea>
                                    </div>
                                    
                                </div>
                                    <div class="col-md-12">
                                         <label for="example-nf-email">
                                            How in your opinion do you meet the job requirements as advertised? (upto 200 words)
                                        </label>
                                        <textarea placeholder=" " class="form-control" rows="3" name="example-textarea-input"
                                            id="Textarea8"></textarea>
                                    </div>
                                    
                                </div>

                               

                            </fieldset>

                          

                            <fieldset>
                                <legend> Upload Your Passport size
                                </legend>

                                     
                                <div class="form-group">

                                 <div class="col-md-12">
                                        <label for="example-nf-email">
                                             Photo
                                        </label>
                                         <input type="file" multiple="" name="example-file-multiple-input" id="File3">
                                        <span class="help-block">Attach your colour passport size Max 50kb </span>
                                    </div>

                                     </div>
                                
                            </fieldset>

                             <div class="form-group form-actions">
                                        <div class="col-md-12">
                                            <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-save"></i> Save</button>
                                            <button class="btn btn-sm btn-warning" type="reset"><i class="fa fa-repeat"></i> Reset</button>
                                        </div>
                                    </div>


                                            </div>
                                            
                                            
                                            </div>
                                        </div>
                                    </div>
                                </div>



               <div class="block full">
                        <!-- Toolbars Title -->
                     
                        <!-- END Toolbars Title -->

                        <!-- Toolbars Content -->
                        <div class="row">

                        <div class="col-md-12">

                        <input type="checkbox">

                       I hereby declare that I have carefully read and understood all the instructions attached to the Advertisement No. JT/01/2014  as available on IIT Gandhinagar web site www.iitgn.ac.in, and that all entries in this form as well as the attachments are true to the best of my knowledge and belief
                        
                        </div>

                        <br />
                        <br />
                            <br />
                        <br />
                        <div class="form-group">
                         <div class="col-md-4">
                                        <label for="example-nf-email">
                                            Name
                                        </label>
                                        <input type="email" id="Email5" name="example-email-input" class="form-control" placeholder="Name">
                                    </div>
                             
                                   <!-- <div class="col-md-2">
                                        <label for="example-nf-email">
                                            Date 
                                        </label>
                                        <input type="text" id="Text59" name="example-datepicker2" class="form-control input-datepicker" data-date-format="dd/mm/yy" placeholder="dd/mm/yy">
                                    </div>-->
                                    <div class="col-md-4">
                                        <label for="example-nf-email">
                                            Place
                                        </label>
                                        <input type="email" id="Email2" name="example-email-input" class="form-control" placeholder="Place">
                                    </div>
                                    <div class="col-md-4    ">
                                        <label for="example-nf-email">
                                            If selected how much time you need to join
                                        </label>
                                        <input type="email" id="Email8" name="example-email-input" class="form-control" placeholder="Months">
                                    </div>

                                  <!--  <div class="col-md-3">
                                      <label for="example-nf-email">
                                            Signature
                                        </label>
                                        
                                    <input type="file" multiple="" name="example-file-multiple-input" id="File1">
                                    <span class="help-block"> (Signature of Applicant)
[Digital signature or scanned signature is acceptable]
 </span>
                                   
                                    </div>-->
                                   
                                </div>
                      
                            
                            
                        </div>
                        <!-- END Toolbars Content -->
                    </div>

 <div class="block full">
                        <!-- Toolbars Title -->
                     
                        <!-- END Toolbars Title -->

                        <!-- Toolbars Content -->
                        <div class="row">

                        <div class="col-md-6">
              
                        </div>
                            <div class="col-md-6">

                                <div class="btn-toolbar pull-right">
                                       <a class="btn btn-lg btn-danger" type="reset"><i class="fa fa-times"></i> Cancel</a>
                                <a class="btn btn-lg btn-info" data-toggle="modal"
                                                                    title="Feedback" data-toggle="tooltip" href="#confirm" data-original-title="Confirm"><i class="fa fa-check">
                                </i> Submit Application</a>





                                </div>
                            </div>
                            
                        </div>
                 
                    </div>
             
      
             
      




                
                           


                <div class="row" style="display:none">
                    <div class="col-md-12">
                        <div class="block">

                     




                     




                            <form onsubmit="return false;" class="form-horizontal form-bordered" method="post"
                            action="">
                            <!-- Jquery Tags Input (class is initialized in js/app.js -> uiInit()), for extra usage examples you can check out https://github.com/xoxco/jQuery-Tags-Input -->
                      
                      
                      
                      
                      
                      
                           
                          
                            



                            

                            <fieldset>
                                <legend> Long-term career objectives </legend>

                                  <div class="form-group">
                                    <div class="col-xs-12">
                                    <label for="example-nf-email">
                                          Please write briefly (maximum 1 page) why you wish to be considered for a faculty position at IITGN and how do your long-term career objectives tie in with a position at IITGN? Briefly, also write about how you propose to contribute to IITGN, and how the Institute can help for your best possible professional growth
                                        </label>
                              
                                    <textarea id="textarea-wysiwyg" name="textarea-wysiwyg" rows="10" class="form-control textarea-editor"></textarea>
                                </div>
                            </div>

                             
                            </fieldset>

                            <fieldset>
                                <legend> Brief Statement  </legend>



                                <div class="form-group">
                                 
                                    <div class="col-md-12">
                                      <label for="example-nf-email">
                                         Please attach a brief statement (maximum 2 pages) on your immediate short-term research plans (2-3 year time frame). Additionally, please also include the research facilities (equipment, space, funds, manpower) that you will need for the same.
                                        </label>
                                        <label for="example-nf-email">
                                           <input type="file" id="File2" name="example-file-multiple-input" multiple="">
                                           
                                        </label>
                                    </div>
                                    
                                </div>
                            </fieldset>


                            <fieldset>
                                <legend> Type of Courses  </legend>
                                <div class="form-group">
                                 
                                    <div class="col-md-12">
                                      <label for="example-nf-email">
                                          Please list the type of undergraduate and postgraduate courses that you will like to develop and/or teach at IIT Gandhinagar.
                                        </label>
                                        <textarea placeholder=" " class="form-control" rows="3" name="example-textarea-input"
                                            id="Textarea6"></textarea>
                                    </div>
                                    
                                </div>
                            </fieldset>

                           


                          

                            
                            </form>
                           
                        </div>
                    </div>
                </div>
            </div>

            <footer class="clearfix">
                    <div class="pull-left">
                       iProof
                    </div>
                </footer>

        </div>
    </div>
    <a id="to-top" href="#" style="display: inline;"><i class="fa fa-angle-double-up"></i>
    </a>

    <div aria-hidden="true" role="dialog" tabindex="-1" class="modal fade" id="confirm">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h2 class="modal-title">
                        <i class="fa fa-tick"></i> Confirm
                    </h2>
                </div>
                <div class="modal-body">
                

                <label class="alert alert-info" >You will not be able to make changes after you submit, please review all the information before submitting the application</label>
 
 

                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-sm btn-default" type="button">
                        Close</button>
                    <a class="btn btn-sm btn-primary" type="button" href="Staff_Submission.html">
                        Ok</a>
                </div>
            </div>
        </div>
    </div>


    <div aria-hidden="true" role="dialog" tabindex="-1" class="modal fade" id="modal-user-settings">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h2 class="modal-title">
                        <i class="fa fa-pencil"></i>Settings
                    </h2>
                </div>
                <div class="modal-body">
                    <form onsubmit="return false;" class="form-horizontal form-bordered" enctype="multipart/form-data"
                    method="post" action="#">
                    <fieldset>
                        <legend>Vital Info </legend>
                        <div class="form-group">
                            <label class="col-md-4 control-label">
                                Username
                            </label>
                            <div class="col-md-8">
                                <p class="form-control-static">
                                    Admin
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="user-settings-email" class="col-md-4 control-label">
                                Email
                            </label>
                            <div class="col-md-8">
                                <input type="email" value="admin@example.com" class="form-control" name="user-settings-email"
                                    id="user-settings-email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="user-settings-notifications" class="col-md-4 control-label">
                                Email Notifications
                            </label>
                            <div class="col-md-8">
                                <label class="switch switch-primary">
                                    <input type="checkbox" checked="" value="1" name="user-settings-notifications" id="user-settings-notifications">
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend>Password Update </legend>
                        <div class="form-group">
                            <label for="user-settings-password" class="col-md-4 control-label">
                                New Password
                            </label>
                            <div class="col-md-8">
                                <input type="password" placeholder="Please choose a complex one.." class="form-control"
                                    name="user-settings-password" id="user-settings-password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="user-settings-repassword" class="col-md-4 control-label">
                                Confirm New Password
                            </label>
                            <div class="col-md-8">
                                <input type="password" placeholder="..and confirm it!" class="form-control" name="user-settings-repassword"
                                    id="user-settings-repassword">
                            </div>
                        </div>
                    </fieldset>
                    <div class="form-group form-actions">
                        <div class="col-xs-12 text-right">
                            <button data-dismiss="modal" class="btn btn-sm btn-default" type="button">
                                Close
                            </button>
                            <button class="btn btn-sm btn-primary" type="submit">
                                Save Changes
                            </button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">    
    $("#basicInfoFrm").validate({
            rules: {
                first_name: "required",
                last_name: "required",
                middle_name: "required",
                father_name: "required",
                category: "required",
                category_Certificate: {
                   required : true,
                   accept: "image/*, application/pdf"
                },
                ex_serviceman: "required",
                gender: "required",
                dob: "required",
                nationality: "required",
                marital_status: "required",
                mailing_address: "required",
                permanent_address: "required",
                mobile: "required",
                landline: "required"
                
            },
            messages: {
            	first_name: "Required",
            	last_name: "Required",
            	middle_name: "Required",
            	father_name: "Required",
            	category: "Required",
            	category_Certificate: { 
            	    required: "Required",
            	    accept: "Allowed files: Image / PDF"
            	},
            	ex_serviceman: "Required",
            	gender: "Required",
            	dob: "Required",
            	nationality: "Required",
            	marital_status: "Required",
            	mailing_address: "Required",
            	permanent_address: "Required",
            	mobile: "Required",
            	landline: "Required"
            }
        });    
    </script>
<?php include_once("footer.php"); ?>