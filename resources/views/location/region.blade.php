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
                                                <h4>Region</h4>
                                                <span>View and manage all Regions</span>

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
                                                <button class="btn btn-success btn-round" style="background-color: #24b42e;">Add Region <i class="fa fa-plus"></i></button>
                                            </a> <br>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Page-header -->



                            <!-- Table section -->
                            <div class="card">
                                <div class="card-header">
                                    <h5>Region</h5>
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
                <h4 class="modal-title">Adding Region</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- <h5>Park Details</h5> -->
                <form id="form" onsubmit="save(event)" enctype="form-data/multipart">
                    @csrf
                    <input type="hidden" class="form-control" id="hidden_id" name="hidden_id">
                    <table id="tableID2">
                        <tr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control form-control-round" id="name" name="name[]" required placeholder="Enter region">
                                    </div>
                                </div>
                            </div>

                        </tr> <br>

                    </table>
                    <div style="float: left;">
                        <button style="float:right;" class="btn btn-info waves-effect" type="button" onclick="addMore2()">Add</button>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect btn-round" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary waves-effect waves-light btn-round" style="background-color: #24b42e;" type="submit" id="submitBtn">Save</button>
                    </div>
                </form>
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
            url: "/location/region_view",
            dataType: 'html',
            cache: false,
            success: function(data) {
                $("#getView").html(data)
            }
        });
    }


    function addMore2() {
        var table = document.getElementById("tableID2");
        var table_len = (table.rows.length);
        var id = parseInt(table_len);
        var rowId = 'row2' + id;

        // Check if the row with the given ID already exists
        if (document.getElementById(rowId)) {
            var i = parseInt(id);
            var n = i + 10;
            for (i; i < n; i++) {
                id = i;
                n++;
                if (!document.getElementById('row2' + id)) {
                    break
                }
            }
        }



        var div = '<div class="row">' +
            '<div class="col-md-6">' +
            '<div class="form-group">' +
            '<label for="name">Name</label>' +
            '<input type="text" class="form-control form-control-round" id="name' + id + '" name="name[]" required placeholder="Enter Region">' +
            '</div>' +
            '</div>' +
            '<div class="col-md-2">' +
            '<div class="form-group">' +
            '<label for="name"></label>' + '<br>' +
            '<button type="button" class="btn btn-danger" onclick="delete_row2(' + id + ')">Delete</button>' +
            '</div>' +
            '</div>' + '<br>';

        var row = table.insertRow(table_len).outerHTML = "<tr id='row2" + id + "'><td>" + div + "</td></tr>";
    }


    function delete_row2(id) {
        var table = document.getElementById("tableID2");
        var rowCount = table.rows.length;
        $("#row2" + id).remove();
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
            url: "/location/saveRegion",
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
                $("#submitBtn").html("Save Patient")
            }
        });
    }


    function editRegion(id) {
        document.getElementById('form').reset();
        $("#hidden_id").val("")

        jQuery.ajax({
            type: "GET",
            url: "/location/editRegion/" + id,
            dataType: 'json',
            success: function(data) {
                $("#hidden_id").val(data.id)

                var rowData = data.data;

                $("#name").val(rowData.name);


                // Update the button text
                $("#submitBtn").html("Update");

                // Open the modal
                $('#large-Modal').modal('show');
            }
        });
    }

    function deleteRegion(id) {
        var conf = confirm("Are you sure you want to delete a region  ?");
        if (!conf) {
            return;
        }

        jQuery.ajax({
            type: "GET",
            url: "/location/deleteRegion/" + id,
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
</script>

@endsection