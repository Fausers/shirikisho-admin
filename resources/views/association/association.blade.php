@extends('layout.app')
@section('content')
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Page-header -->
                            <div class="page-header">
                                <div class="row align-items-end">
                                    <div class="col-lg-8">
                                        <div class="page-header-title">
                                            <div class="d-inline">
                                                <h4>Associations</h4>
                                                <span>View and manage all Associations</span>

                                                <!-- <ul class="breadcrumb-title">
                                                <li class="breadcrumb-item">
                                                    <a href="/dashboard"> <i class="feather icon-home"></i> </a>
                                                </li>
                                                <li class="breadcrumb-item"><a href="/parking/parking">Parking</a></li>
                                            </ul> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="page-header-breadcrumb">
                                            <a href="#largeModal" data-toggle="modal" data-target="#large-Modal" class="text-end" style="float:right;" onclick="clear_input()">
                                                <button class="btn btn-round"  style="background-color: #8fc9ae; color: white">Add Associations <i class="fa fa-plus"></i></button>
                                            </a> <br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Page-header -->

                            <!-- Filter section -->
                            <div class="card" style="padding: 20px;">
                                <form id="formfilter" enctype="form-data/multipart">

                                    <!-- <input type="hidden" class="form-control" id="hidden_id" name="hidden_id"> -->
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="Region">Region</label>
                                                <select name="select" class="form-control form-control-round">
                                                    <option value="">Select</option>
                                                    <option value="opt2">Type 2</option>
                                                    <option value="opt3">Type 3</option>
                                                    <option value="opt4">Type 4</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="Region">Districts</label>
                                                <select name="select" class="form-control form-control-round">
                                                    <option value="">Select</option>
                                                    <option value="opt2">Type 2</option>
                                                    <option value="opt3">Type 3</option>
                                                    <option value="opt4">Type 4</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4"></div>
                                        <div class="col-md-2 text-right">
                                            <!-- <button class="btn btn-info btn-round btn-mini">Clear Filter</button> -->
                                            <button type="submit" class="btn  btn-round btn-min"  style="background-color: #8fc9ae; color: white" id="btnfilter">Filter</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- End Filter section -->

                            <!-- Table section -->
                            <div class="card">
                                <div class="card-header">
                                    <h5>Associations</h5>
                                    <span></span>
                                </div>
                                <div class="card-block">
                                    <div id="getView"></div>
                                </div>
                            </div>
                            <!-- End Table section -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="large-Modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Associations</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- <h5>Park Details</h5> -->
                <form id="form" onsubmit="save(event)" enctype="form-data/multipart">
                    @csrf
                    <input type="hidden" id="hidden_id" name="hidden_id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Name">Name</label>
                                <input type="text" class="form-control form-control-round" id="name" name="name" placeholder="e.g. Chama">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="region">Region</label>
                                <select name="region_id" id="region_id" class="form-control form-control-round" onchange="getRegionDistrict(this.value)">
                                    <option value="">Select Region</option>
                                    @foreach($region as $reg)
                                    <option value="{{$reg->id}}">{{$reg->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="district">District</label>
                                <select name="district_id" id="district_id" class="form-control form-control-round">
                                    <option value="">Select District</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect btn-round" data-dismiss="modal">Close</button>
                        <button class="btn waves-effect waves-light btn-round"  style="background-color: #8fc9ae; color: white" type="submit" id="submitBtn">Add Association</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="viewAssociationModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" style="font-size: middle; font-weight: 600;">Association Details</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="col-md-12 card" style="padding: 20px;">
                        <h5 style="font-size: 1.2em; font-weight: 600;">Personal Details</h5>

                        <div class="mb-2"></div>
                        <div class="row">
                            <div class="col-md-6">
                                <span>Name</span>
                                <p style="color: #8a9099;">075216312</p>

                            </div>
                            <div class="col-md-6">
                                <span>Region</span>
                                <p style="color: #8a9099;">Male</p>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <span>District</span>
                                <p style="color: #8a9099;">Merried</p>
                            </div>
                            <div class="col-md-6">
                                <span>Ward</span>
                                <p style="color: #8a9099;">16/09/1900</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <span>Driver Capacity</span>
                                <p style="color: #8a9099;">1623282</p>
                            </div>
                            <div class="col-md-6">
                                <span>Park Owner</span>
                                <p style="color: #8a9099;">Sinza</p>
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <span class="mr-2">
                                <button type="button" class="btn waves-effect waves-light btn-round" style="background-color: orange; color:white">Disable Park</button>
                            </span>
                            <span class="mr-2">
                                <button type="button" class="btn  waves-effect waves-light btn-round"  style="background-color: #8fc9ae; color: white">View Members</button>
                            </span>

                        </div>
                    </div>



                </div>
                <div class="row" style="padding-left: 20px;padding-right: 20px;">
                    <div class="col-md-12">
                        <div>
                            <h5 style="font-size: 1.2em; font-weight: 600;">Leader Details</h5>
                        </div>
                        <div class="row">
                            <div class="col-md-4 card">
                                <!-- <div class="mb-2"></div> -->
                                <img src="{{ asset('images/logo.png') }}" alt="logo.png" style="height: 200px; padding: 20px;">

                            </div>
                            <div class="col-md-8 card" style=" padding: 20px;">
                                <!-- <div class="mb-2"></div> -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <span>Phone Number</span>
                                        <p style="color: #8a9099;">075216312</p>

                                    </div>
                                    <div class="col-md-6">
                                        <span>Email Address</span>
                                        <p style="color: #8a9099;">Male</p>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <span>Uniform No.</span>
                                        <p style="color: #8a9099;">Merried</p>
                                    </div>
                                    <div class="col-md-6">
                                        <span>Residence</span>
                                        <p style="color: #8a9099;">16/09/1900</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <span>Birth Date</span>
                                        <p style="color: #8a9099;">1623282</p>
                                    </div>
                                    <div class="col-md-6">
                                        <span>Gender</span>
                                        <p style="color: #8a9099;">Sinza</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row" style="padding-left: 20px;padding-right: 20px;">
                    <div class="col-md-12">
                        <div>
                            <h5 style="font-size: 1.2em; font-weight: 600;">Association Leadership</h5>
                        </div>
                        <div class="row">
                            <div class="col-md-12 card" style=" padding: 20px;">
                                <!-- <div class="mb-2"></div> -->
                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <span>Type of Leader</span>
                                            <select class="form-control form-control-round" id="leader_type" name="leader_type">
                                                <option value="Secretary">Secretary</option>
                                                <option value="Vise Chair">Vise Chair</option>
                                                <option value="Chairperson">Chairperson</option>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <span>List of Members</span>
                                            <select class="form-control form-control-round" id="members" name="members">
                                                <option value="Select Member"></option>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3"></div>
                                        <button type="button" class="btn waves-effect waves-light btn-round"  style="background-color: #8fc9ae; color: white">Vote to Leadership</button>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>






    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/2.0.3/css/dataTables.dataTables.min.css">
    <script src="//cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            getView()
        });

        function getView() {


            jQuery.ajax({
                type: "GET",
                url: "/associations/association_view",
                dataType: 'html',
                cache: false,
                success: function(data) {
                    $("#getView").html(data)
                }
            });
        }

        function clear_input() {
            document.getElementById('form').reset();
            $("#hidden_id").val("")
            $("#submitBtn").html("Save")
            getView()
        }

        function save(e) {
            e.preventDefault();


            //disableBtn("submitBtn", true);
            var form = document.getElementById('form');
            var formData = new FormData(form);

            jQuery.ajax({
                type: "POST",
                url: "/associations/saveAssociation",
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    if (data.status == 200) {
                        toastr.success(data.message)
                        clear_input()
                        $('#large-Modal').modal('hide');
                    } else {
                        toastr.warning(data.message)
                    }

                    disableBtn("submitBtn", false);
                    $("#submitBtn").html("Save")
                }
            });
        }



        function getRegionDistrict(id) {

            $("#district_id").html("")
            jQuery.ajax({
                type: "GET",
                url: "/location/getRegionDistrict/" + id,
                dataType: 'json',
                success: function(data) {
                    var div = "";
                    $.each(data, function(index, row) {

                        div += "<option value='" + row.id + "'>" + row.name + "</option>";
                    })

                    $("#district_id").html("<option value=''>Select District</option>")
                    $("#district_id").append(div)
                    $("#district_id").select2()
                }
            });
        }

        function editAssociation(id) {
            document.getElementById('form').reset();
            $("#hidden_id").val("")

            jQuery.ajax({
                type: "GET",
                url: "/associations/editAssociation/" + id,
                dataType: 'json',
                success: function(data) {
                    $("#hidden_id").val(data.id)

                    var rowData = data.data;

                    $("#name").val(rowData.name);
                    $("#region_id").val(rowData.region_id);
                    $("#district_id").html("<option value='" + rowData.district_id + "'>" + data.district.name + "</option>");


                    // Update the button text
                    $("#submitBtn").html("Update");

                    // Open the modal
                    $('#large-Modal').modal('show');
                }
            });
        }

        function deleteAssociation(id) {
            var conf = confirm("Are you sure you want to delete a Association  ?");
            if (!conf) {
                return;
            }

            jQuery.ajax({
                type: "GET",
                url: "/associations/deleteAssociation/" + id,
                dataType: 'json',
                success: function(data) {
                    if (data.status == 200) {
                        toastr.success(data.message)
                        clear_input()
                    } else {
                        toastr.warning(data.message)
                    }
                }
            });
        }


        function viewAssociation(id) {
            // document.getElementById('formviewMore').reset();
            // $("#hidden_id").val("")

            jQuery.ajax({
                type: "GET",
                url: "/associations/viewAssociation/" + id,
                dataType: 'json',
                success: function(data) {
                    // $("#hidden_id").val(data.id)

                    var rowData = data.data;

                    $("#naaa").val(rowData.name);

                    // Update the button text
                    // $("#submitBtn").html("Update");

                    // Open the modal
                    $('#viewAssociationModal').modal('show');
                }
            });
        }
    </script>

    @endsection