@extends('layout.app')
@section('content')
<style>
    .custom-row {
        margin-bottom: 10px;
        /* Adjust the value as needed */
    }
</style>

<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Page-header start -->
                            <div class="page-header">
                                <div class="row align-items-end">
                                    <div class="col-lg-8">
                                        <div class="page-header-title">
                                            <div class="d-inline">
                                                <h4>Drivers</h4>
                                                <span>View and manage all driver information and their parking areas</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="page-header-breadcrumb">
                                            <!-- <ul class="breadcrumb-title">
                                                <li class="breadcrumb-item">
                                                    <a href="/dashboard"> <i class="feather icon-home"></i> </a>
                                                </li>
                                                <li class="breadcrumb-item"><a href="/driver/driver">Drivers</a></li>
                                            </ul> -->
                                            <a href="#largeModal" data-toggle="modal" data-target="#largeModal" class="text-end" style="float:right;" onclick="clear_input()">
                                                <button class="btn btn-success btn-round" style="background-color: #24b42e;">Add Driver <i class="fa fa-plus"></i></button>
                                            </a> <br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Page-header end -->

                            <!-- Table section start -->
                            <div class="card">
                                <div class="card-header">
                                    <h5>Driver Information</h5>
                                </div>
                                <div class="card-block">
                                    <div id="getView"></div>
                                </div>
                            </div>
                            <!-- Table section end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Profile view -->
<div class="modal fade" id="profileModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" style="font-size: middle; font-weight: 600;">Driver Information</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 card">
                        <div></div>
                        <img src="{{ asset('images/logo.png') }}" alt="logo.png" style="height: 200px; padding: 20px;">
                        <div class="mb-4"></div>
                        <div class="text-center">
                            <span class="">Ishaqa Maulidi</span> <br>
                            <span style="color: red;">Unverified</span>



                            <div style="padding-left: 20px; padding-top: 10px;">
                                <div class="">
                                    <span>Vehicle Number: </span>
                                    <span style="color: #8a9099;">MC123EEE</span>
                                </div>
                                <div class="">
                                    <span>Vehicle Type: </span>
                                    <span style="color: #8a9099;">Motorbike</span>
                                </div>
                                <div class="">
                                    <span>Ownership: </span>
                                    <span style="color: #8a9099;">Yes</span>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-8 card" style="padding: 20px;">
                        <h5 style="font-size: 1.2em; font-weight: 600;">Personal Details</h5>

                        <div class="mb-2"></div>
                        <div class="row">
                            <div class="col-md-6">
                                <span>Phone Number</span>
                                <p style="color: #8a9099;">075216312</p>

                            </div>
                            <div class="col-md-6">
                                <span>Gender</span>
                                <p style="color: #8a9099;">Male</p>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <span>Maritial Status</span>
                                <p style="color: #8a9099;">Merried</p>
                            </div>
                            <div class="col-md-6">
                                <span>Date of Birth</span>
                                <p style="color: #8a9099;">16/09/1900</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <span>License Number</span>
                                <p style="color: #8a9099;">1623282</p>
                            </div>
                            <div class="col-md-6">
                                <span>Residential Address</span>
                                <p style="color: #8a9099;">Sinza</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <span>Parking Area</span>
                                <p style="color: #8a9099;">Kinondoni</p>
                            </div>
                            <div class="col-md-6">
                                <span>Driver Status</span>
                                <p style="color: #8a9099;">Active</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <span>Parking ID</span>
                                <p style="color: #8a9099;">Mwananyamala</p>
                            </div>
                            <div class="col-md-6">
                                <span>Parking Area Leader</span>
                                <p style="color: #8a9099;">Urafiki</p>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="row card" style="padding: 20px;">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <h5 style="font-size: 1.2em; font-weight: 600;">Government Details</h5>
                                <div class="mb-2"></div>
                                <div class="mb-2">
                                    <span class="mr-2">Latra: </span>
                                    <span style="color: #8a9099;"><i class="fa fa-check" style="color: #24b42e;"></i></span>
                                </div>
                                <div class="">
                                    <span class="mr-2">Driving License: </span>
                                    <span style="color: #8a9099;"> <i class="fa fa-ban"></i></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h5 style="font-size: 1.2em; font-weight: 600;">Insurance Details</h5>
                                <div class="mb-2"></div>
                                <div class="mb-2">
                                    <span class="mr-2">Health: </span>
                                    <span style="color: #8a9099;"> <i class="fa fa-ban"></i></span>
                                </div>
                                <div class="">
                                    <span class="mr-2">Vehicle: </span>
                                    <span style="color: #8a9099;"><i class="fa fa-check" style="color: #24b42e;"></i></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h5 style="font-size: 1.2em; font-weight: 600;">Loan Details</h5>
                                <div class="mb-2"></div>
                                <div class="mb-2">
                                    <span class="mr-2">Motor: </span>
                                    <span style="color: #8a9099;"><i class="fa fa-check" style="color: #24b42e;"></i></span>
                                </div>
                                <div class="">
                                    <span class="mr-2">Non Motor: </span>
                                    <span style="color: #8a9099;"><i class="fa fa-ban"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row justify-content-center">
                    <span class="mr-2">
                        <button type="button" class="btn btn-primary waves-effect waves-light btn-round" style="background-color: #24b42e;">Change Parking</button>
                    </span>
                    <span class="mr-2">
                        <button type="button" class="btn btn-primary waves-effect waves-light btn-round" style="background-color: orange;">Disable Driver</button>
                    </span>
                    <!-- <div class="mr-2">
                        <button type="button" class="btn btn-primary waves-effect waves-light btn-round" style="background-color: red;">Delete Driver</button>
                        </span>
                    </div> -->

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Save driver -->
<div class="modal fade" id="largeModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Adding Driver</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- <h5>Park Details</h5> -->
                <form id="form" onsubmit="save(event)" enctype="form-data/multipart">
                    @csrf
                    <input type="hidden" class="form-control" id="hidden_id" name="hidden_id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fullName">Full Name</label>
                                <input type="text" class="form-control form-control-round" id="full_name" name="full_name" placeholder="e.g. Okansa Mwalungu">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phoneNUmber">Phone Number</label>
                                <input type="number" class="form-control form-control-round" id="phone_number" name="phone_number" placeholder="Enter Phone Number">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Gender">Gender</label>
                                <select class="form-control form-control-round" name="gender" id="gender">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="parkOwner">Birth Date</label>
                                <input type="date" class="form-control form-control-round" id="dob" name="dob">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="parkOwner">Marital Status</label>
                                <input type="text" class="form-control form-control-round" id="marital_status" name="marital_status" placeholder="e.g Single">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="parkOwner">Residence Address</label>
                                <input type="text" class="form-control form-control-round" id="residence_address" name="residence_address" placeholder="e.g. Kimala">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="parkOwner">License Number</label>
                                <input type="text" class="form-control form-control-round" id="license_number" name="license_number" placeholder="Enter License Number">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="parkOwner">Vehicle Type</label>
                                <select class="form-control form-control-round" id="vehicle_type" name="vehicle_type">
                                    <option>Select Vehicles</option>
                                    <option value="Motorcycle">Motorcycle</option>
                                    <option value="Tricycle">Tricycle</option>
                                    <option value="Both">Both</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="parkOwner">Vehicle Number</label>
                                <input type="text" class="form-control form-control-round" id="vehicle_number" name="vehicle_number" placeholder="Enter Vehicle Number">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="parkOwner">Profile Image</label>
                                <input type="file" class="form-control form-control-round" id="profile_image" name="profile_image">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="parkOwner">Ownership</label>
                                <select class="form-control form-control-round" id="ownership" name="ownership">
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div id="ownerFields" style="display: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="parkOwner">Owner Name</label>
                                    <input type="text" class="form-control form-control-round" id="vehicle_owner_name" name="vehicle_owner_name" placeholder="Enter Vehicle Owner">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="parkOwner">Owner Phone Number</label>
                                    <input type="text" class="form-control form-control-round" id="vehicle_owner_phone" name="vehicle_owner_phone" placeholder="Enter Vehicle Owner Phone Number">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect btn-round" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary waves-effect waves-light btn-round" style="background-color: #24b42e;" type="submit" id="submitBtn">Add Driver</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>






<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/2.0.3/css/dataTables.dataTables.min.css">
<script src="//cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>

<script>
    document.getElementById('ownership').addEventListener('change', function() {
        var ownerFields = document.getElementById('ownerFields');
        if (this.value === 'No') {
            ownerFields.style.display = 'block';
        } else {
            ownerFields.style.display = 'none';
        }
    });

    $(document).ready(function() {

        getView()
    });

    function getView() {


        jQuery.ajax({
            type: "GET",
            url: "/driver/driver_view",
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
            url: "/driver/driverSave",
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
                if (data.status == 200) {
                    toastr.success(data.message)
                    clear_input()
                    $('#largeModal').modal('hide');
                } else {
                    toastr.warning(data.message)
                }

                disableBtn("submitBtn", false);
                $("#submitBtn").html("Save")
            }
        });
    }


    function editDriver(id) {
        document.getElementById('form').reset();
        $("#hidden_id").val("")

        jQuery.ajax({
            type: "GET",
            url: "/driver/editDriver/" + id,
            dataType: 'json',
            success: function(data) {
                $("#hidden_id").val(data.id)

                var rowData = data.data;

                $("#full_name").val(rowData.full_name);
                $("#phone_number").val(rowData.phone_number);
                $("#gender").val(rowData.gender);
                $("#dob").val(rowData.dob);
                $("#marital_status").val(rowData.marital_status);
                $("#residence_address").val(rowData.residence_address);
                $("#license_number").val(rowData.license_number);


                // Update the button text
                $("#submitBtn").html("Update");

                // Open the modal
                $('#largeModal').modal('show');
            }
        });
    }

    function deleteDriver(id) {
        var conf = confirm("Are you sure you want to delete a driver  ?");
        if (!conf) {
            return;
        }

        jQuery.ajax({
            type: "GET",
            url: "/driver/deleteDriver/" + id,
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

    function viewDiver(id) {
            // document.getElementById('formviewMore').reset();
            // $("#hidden_id").val("")

            jQuery.ajax({
                type: "GET",
                url: "/driver/viewDiver/" + id,
                dataType: 'json',
                success: function(data) {
                    // $("#hidden_id").val(data.id)

                    var rowData = data.data;

                    // Open the modal
                    $('#profileModal').modal('show');
                }
            });
        }
</script>

@endsection