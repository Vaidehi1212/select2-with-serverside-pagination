<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="images/favicon.png">
    <title>Josuqadmin</title>
    <!--Core CSS -->
    <link href="<?php echo base_url('assets/bs3/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/bootstrap-switch.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/js/jquery-ui/jquery-ui-1.10.1.custom.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/bootstrap-reset.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/font-awesome/css/font-awesome.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/js/jvector-map/jquery-jvectormap-1.2.2.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/clndr.css'); ?>" rel="stylesheet">
    <!--clock css-->
    <link href="<?php echo base_url('assets/js/css3clock/css/style.css'); ?>" rel="stylesheet">
    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/js/morris-chart/morris.css'); ?>">
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/style-responsive.css'); ?>" rel="stylesheet"/>
    <link href="<?php echo base_url('assets/css/custom-css.css'); ?>" rel="stylesheet"/>

    <!--responsive table-->
    <link href="<?php echo base_url('assets/css/table-responsive.css'); ?>" rel="stylesheet"/>

    <!--dynamic table-->
    <link href="<?php echo base_url('assets/js/advanced-datatable/css/demo_page.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/js/advanced-datatable/css/demo_table_new.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/js/data-tables/DT_bootstrap.css'); ?>" rel="stylesheet">
    <script src="<?php echo base_url('assets/js/jquery.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery-ui/jquery-ui-1.10.1.custom.min.js'); ?>"></script>

    <!--dynamic table-->
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/rowreorder/1.2.5/css/rowReorder.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js" />
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/data-tables/DT_bootstrap.js"></script>

    <!--common script init for all pages-->
    <script src="<?php echo base_url('assets/js/scripts.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap-switch.js'); ?>"></script>
    <script src="<?php echo base_url('assets/bs3/js/bootstrap.min.js'); ?>"></script>
    <script src="https://cdn.ckeditor.com/4.7.3/standard-all/ckeditor.js"></script>


    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

    <!-- <link href="<?php echo base_url('assets/js/select2/select2.css'); ?>" rel="stylesheet"> -->

</head>

<style>
.modalFooter{
    margin-bottom:-15px !important;
}
.control-label{
    text-align: left !important;
}
.form-horizontal .form-group {
    margin-left: 0px !important; 
    margin-right: 0px !important;
}
</style>

<body>
<section id="container">
<header class="header fixed-top clearfix">

    <div class="brand">
        <a href="index.html" class="logo">
            <img src="<?php echo base_url('assets/images/logo.png') ?>" alt="">
        </a>
        <div class="sidebar-toggle-box">
            <div class="fa fa-bars"></div>
        </div>
    </div>

    <div class="top-nav clearfix">
        <ul class="nav pull-right top-menu">
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <span class="username">Admin</span>
                </a>
                <ul class="dropdown-menu extended logout">
                    <li><a href="<?php echo base_url('index.php/Logout'); ?>"  onclick="javascript:logout()"><i class="fa fa-key"></i> Log Out</a></li>
                </ul>
            </li>

            <?php
                $role_id = $this->session->userdata['admindata']['admin_role_id'];
                if ($role_id == 1) {?>
                    <li>
                        <form method="post" action="<?php //echo base_url('index.php/city/changeLocation'); ?>">
                        <?php
                        $this->load->model('City_model');
                        $citylist = $this->City_model->getAllCititesByCountry();
                        if (count($citylist) > 0) {
                        ?>
                            <select class="js-example-data-ajax" style="width: 100%" id="select2">  </select>
                        <?php }?> 
                        </form>
                    </li>
           <?php }?> 
        </ul>
    </div>

</header>

<script type="text/javascript">
jQuery(document).ready(function(){

    var location ='<?php echo $this->session->userdata('location'); ?>'
    var locationName ='<?php echo $this->session->userdata('locationName'); ?>'

    if(location){
            var data = {
            id: location,
            cityName: locationName
        };
        var newOption = new Option(data.cityName, data.id, false, false);
        $('#select2').append(newOption).trigger('change');
    }

    // $("#changeLocations").on("change",function(){
    $("#select2").on("change",function(){

        console.log('city change select 2');
        

        unqid=jQuery(this).val();
        if(unqid.length == 0){
            alert("Please select city");
            return false;
        }
        $.ajax({
            url: "<?php echo base_url('index.php/city/changeLocation'); ?>",
            method: "POST",
            dataType: 'json',
            data: {id:unqid},
            success: function(data){
                if(data.success){
                    window.location.reload();
                }else{
                    jQuery(".alert-danger").show().html(data.error).delay(5000).fadeOut();
                }
            }
        });
    });

    // select2()
});

$('#select2').click(function(){
        select2()
})

function select2(){
    $(".js-example-data-ajax").select2({
            ajax: {
                url: "<?php echo base_url('index.php/city/getAllCities'); ?>",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term , // search term
                        page: params.page || 1
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    
                    if(params.page==1){
                        var d0 = {id:"0",cityName:"Select All"}
                        data.items.unshift(d0)
                    }    

                    return {
                        results: data.items,
                        pagination: {
                        more: (params.page * 10) < data.total_count
                        }
                    };
                },
                cache: true
            },
            placeholder: 'Search for a city',
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            //   minimumInputLength: 1,
            templateResult: formatRepo,
            templateSelection: formatRepoSelection
        });
}

// function changeCity(repo){
//     debugger
//     var location ='<?php echo $this->session->userdata('location'); ?>'
//         var unqid;
//         if(repo.id != '' && repo.id != null && repo.id != 'undefined') {
//             unqid=repo.id;
//         } else {
//             return;
//         }
//         if(unqid==location){
//             return;
//         }

//         jQuery.ajax({
//             url: "<?php echo base_url('index.php/city/changeLocation'); ?>",
//             method: "POST",
//             dataType: 'json',
//             data: {id:unqid},
//             success: function(data){
//                 if(window.localStorage.getItem('loadCity')==null){
//                     window.localStorage.setItem('loadCity',true)
//                 }
//                 window.location.reload();
//             }
//         });
// }

    function formatRepo (repo) {
        
        if (repo.loading) {
            return repo.text;
        }
        if(repo.cityName !='Select All'){
            var markup = "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'>" + repo.cityName+'-' + repo.countryName + "</div>";
        return markup;
        }else{
            var markup = "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'>" + repo.cityName+ "</div>";
        return markup;
        }
        
    }

    function formatRepoSelection (repo) {
        return repo.cityName || repo.text;
    }

function logout(){
    // window.localStorage.removeItem('loadCity');
}

</script>