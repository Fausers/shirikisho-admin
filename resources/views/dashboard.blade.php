@extends('layout.app')
@section('content')
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">

                        <!-- statustic-card start -->
                        <div class="col-xl-3 col-md-6">
                            <div class="card text-white" style="background-color: #8ADAB2;">
                                <div class="card-block">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <p class="m-b-5">Active Members</p>
                                            <h4 class="m-b-0">852</h4>
                                        </div>
                                        <div class="col col-auto text-right">
                                            <i class="feather icon-user f-50"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card text-white" style="background-color: #83afa6; color: white">
                                <div class="card-block">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <p class="m-b-5">Inactive Members</p>
                                            <h4 class="m-b-0">5,852</h4>
                                        </div>
                                        <div class="col col-auto text-right">
                                            <i class="feather icon-credit-card f-50"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card  text-white" style="background-color: #B3C8CF;">
                                <div class="card-block">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <p class="m-b-5">Verified Members</p>
                                            <h4 class="m-b-0">42</h4>
                                        </div>
                                        <div class="col col-auto text-right">
                                            <i class="feather icon-book f-50"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card text-white" style="background-color: #8fc9ae; color: white">
                                <div class="card-block">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <p class="m-b-5">Unverified Members</p>
                                            <h4 class="m-b-0">5,242</h4>
                                        </div>
                                        <div class="col col-auto text-right">
                                            <i class="feather icon-shopping-cart f-50"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- statustic-card start -->

                        <!-- statustic-card start -->
                        <div class="col-xl-8 col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-header-left ">
                                        <h5>Monthly View</h5>
                                        <span class="text-muted">For Members Registration</span>
                                    </div>

                                    <form id="formGraph" onsubmit="filterGraph(event)">
                                        @csrf
                                        <div class="row">

                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="month_select">Month</label>
                                                    <select class="form-control form-control-round" id="month_select" name="month">
                                                        <option value="" disabled>Select Month</option>
                                                        <?php

                                                        use Illuminate\Support\Facades\Auth;

                                                        $months = [
                                                            1 => 'January',
                                                            2 => 'February',
                                                            3 => 'March',
                                                            4 => 'April',
                                                            5 => 'May',
                                                            6 => 'June',
                                                            7 => 'July',
                                                            8 => 'August',
                                                            9 => 'September',
                                                            10 => 'October',
                                                            11 => 'November',
                                                            12 => 'December'
                                                        ];
                                                        $currentMonth = date('n');
                                                        foreach ($months as $monthNumber => $monthName) {
                                                            $selected = ($monthNumber == $currentMonth) ? 'selected' : '';
                                                            echo '<option value="' . $monthNumber . '" ' . $selected . '>' . $monthName . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">

                                                    <label for="year_select">Year</label>

                                                    <select class="form-control form-control-round" id="year_select" name="year">
                                                        <?php
                                                        $currentYear = date('Y'); // Get the current year
                                                        for ($year = $currentYear; $year >= $currentYear - 10; $year--) {
                                                            $selected = ($year == $currentYear) ? 'selected' : '';
                                                            echo '<option value="' . $year . '" ' . $selected . '>' . $year . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="mb-2"></div>
                                                <div class="form-group">
                                                    <br>
                                                    <button type="submit" class="btn" style="background-color: #8fc9ae; color: white">Filter</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-block-big" style="position: relative;">
                                    <!-- Loader div centered using CSS flexbox -->
                                    <div id="loader" style="display: none; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                        <h3>Loading...</h3>
                                    </div>

                                    <canvas id="monthly-mixed-chart" style="height:250px"></canvas>
                                </div>

                            </div>

                        </div>
                        <div class="col-xl-2 col-md-12">
                            <div class="card feed-card">
                                <div class="card-block">
                                    <div class="row per-task-block text-center">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <div style="padding-bottom: 60px;"></div>
                                                    <h5 style="padding-right: 80px;">Marital Status</h5>
                                                </div>
                                                <div class="row per-task-block text-center">
                                                    <div class="col-6">
                                                        <div data-label="45%" class="radial-bar radial-bar-45 radial-bar-lg radial-bar-secondary" style="background-color: #83afa6; color: white;"></div>
                                                        <h6 class="text-muted">Married Driver</h6>
                                                        <p class="text-muted">642</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row per-task-block text-center">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 style="padding-right: 80px;">Driving License</h5>
                                                    <!-- Member verification -->
                                                </div>
                                                <div class="row per-task-block text-center">
                                                    <div class="col-6">
                                                        <div data-label="45%" class="radial-bar radial-bar-45 radial-bar-lg radial-bar-warning"></div>
                                                        <h6 class="text-muted">Licensed Driver</h6>
                                                        <p class="text-muted">642</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-md-12">
                            <div class="card feed-card">
                                <div class="card-block">
                                    <div class="row per-task-block text-center">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 style="padding-left: 40px;">Gender</h5>
                                                </div>
                                                <div class="card-block">
                                                    <canvas id="genderChart"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row per-task-block text-center">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 style="padding-left: 50px;">Insuarance</h5>
                                                    <!-- Member verification -->
                                                </div>
                                                <div class="card-block">
                                                    <canvas id="pieChart"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- statustic-card start -->

                        <!-- income start -->
                        <div class="col-xl-4 col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Transanctions</h5>
                                    <!-- put filter for month and year for polar chart -->
                                    <!-- <span></span> -->

                                </div>
                                <div class="card-block">
                                    <canvas id="polarChart" width="400" height="400"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Government Transaction</h5>
                                    <!-- filter for month and year -->
                                    <!-- <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span> -->

                                </div>
                                <div class="card-block">
                                    <canvas id="bubblechart" width="400" height="400"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Candlestick chart</h5>
                                    <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span>

                                </div>
                                <div class="card-block">
                                    <div id="chart_Candlestick" style="width: 100%; height: 300px;"></div>
                                </div>
                            </div>

                        </div>
                        <!-- income end -->

                        <!-- ticket and update start -->
                        <div class="col-xl-4 col-md-12">
                            <div class="card table-card">
                                <div class="card-header">
                                    <h5>(5) Latest Members</h5>
                                    <!-- <div class="card-header-right">
                                        <ul class="list-unstyled card-option">
                                            <li><i class="fa fa fa-wrench open-card-option"></i></li>
                                            <li><i class="fa fa-window-maximize full-card"></i></li>
                                            <li><i class="fa fa-minus minimize-card"></i></li>
                                            <li><i class="fa fa-refresh reload-card"></i></li>
                                            <li><i class="fa fa-trash close-card"></i></li>
                                        </ul>
                                    </div> -->
                                </div>
                                <div class="card-block">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-borderless">
                                            <thead>
                                                <tr>
                                                    <th>Profile Image</th>
                                                    <th>Full Name</th>
                                                    <th>Parking Area</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="height: 100px; width: 30px;">
                                                        <img src="{{ asset('files/profile.png') }}" alt="Description of the image" style="height: 100%; width: 100%;">
                                                    </td>

                                                    <td>Juma Hassan Mushi</td>
                                                    <td>Kamata</td>
                                                </tr>
                                                <tr>
                                                    <td style="height: 100px; width: 30px;">
                                                        <img src="{{ asset('files/profile.png') }}" alt="Description of the image" style="height: 100%; width: 100%;">
                                                    </td>
                                                    <td>Juma Hassan Mushi</td>
                                                    <td>Kamata</td>
                                                </tr>
                                                <tr>
                                                    <td style="height: 100px; width: 30px;">
                                                        <img src="{{ asset('files/profile.png') }}" alt="Description of the image" style="height: 100%; width: 100%;">
                                                    </td>
                                                    <td>Juma Hassan Mushi</td>
                                                    <td>Kamata</td>
                                                </tr>
                                                <tr>
                                                    <td style="height: 100px; width: 30px;">
                                                        <img src="{{ asset('files/profile.png') }}" alt="Description of the image" style="height: 100%; width: 100%;">
                                                    </td>
                                                    <td>Juma Hassan Mushi</td>
                                                    <td>Kamata</td>
                                                </tr>
                                                <tr>
                                                    <td style="height: 100px; width: 30px;">
                                                        <img src="{{ asset('files/profile.png') }}" alt="Description of the image" style="height: 100%; width: 100%;">
                                                    </td>
                                                    <td>Juma Hassan Mushi</td>
                                                    <td>Kamata</td>
                                                </tr>
                                                <tr>

                                            </tbody>
                                        </table>
                                        <div class="text-right m-r-20">
                                            <a href="#!" class=" b-b-primary text-primary">View all Members</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-12">
                            <div class="card table-card">
                                <div class="card-header">
                                    <h5>(5) Best Recruiters</h5>
                                    <!-- <div class="card-header-right">
                                        <ul class="list-unstyled card-option">
                                            <li><i class="fa fa fa-wrench open-card-option"></i></li>
                                            <li><i class="fa fa-window-maximize full-card"></i></li>
                                            <li><i class="fa fa-minus minimize-card"></i></li>
                                            <li><i class="fa fa-refresh reload-card"></i></li>
                                            <li><i class="fa fa-trash close-card"></i></li>
                                        </ul>
                                    </div> -->
                                </div>
                                <div class="card-block">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-borderless">
                                            <thead>
                                                <tr>
                                                    <th>Profile Image</th>
                                                    <th>Full Name</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="height: 100px; width: 30px;">
                                                        <img src="{{ asset('files/profile.png') }}" alt="Description of the image" style="height: 100%; width: 100%;">
                                                    </td>

                                                    <td>Asha Mussa Said</td>
                                                    <td>420</td>
                                                </tr>
                                                <tr>
                                                    <td style="height: 100px; width: 30px;">
                                                        <img src="{{ asset('files/profile.png') }}" alt="Description of the image" style="height: 100%; width: 100%;">
                                                    </td>
                                                    <td>Asha Mussa Said</td>
                                                    <td>620</td>
                                                </tr>
                                                <tr>
                                                    <td style="height: 100px; width: 30px;">
                                                        <img src="{{ asset('files/profile.png') }}" alt="Description of the image" style="height: 100%; width: 100%;">
                                                    </td>
                                                    <td>Asha Mussa Said</td>
                                                    <td>790</td>
                                                </tr>
                                                <tr>
                                                    <td style="height: 100px; width: 30px;">
                                                        <img src="{{ asset('files/profile.png') }}" alt="Description of the image" style="height: 100%; width: 100%;">
                                                    </td>
                                                    <td>Asha Mussa Said</td>
                                                    <td>250</td>
                                                </tr>
                                                <tr>
                                                    <td style="height: 100px; width: 30px;">
                                                        <img src="{{ asset('files/profile.png') }}" alt="Description of the image" style="height: 100%; width: 100%;">
                                                    </td>
                                                    <td>Asha Mussa Said</td>
                                                    <td>300</td>
                                                </tr>
                                                <tr>

                                            </tbody>
                                        </table>
                                        <div class="text-right m-r-20">
                                            <a href="#!" class=" b-b-primary text-primary">View all Recruiters</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-12">
                            <div class="card table-card">
                                <div class="card-header">
                                    <h5>(10) Latest Transactions</h5>
                                    <!-- <div class="card-header-right">
                                        <ul class="list-unstyled card-option">
                                            <li><i class="fa fa fa-wrench open-card-option"></i></li>
                                            <li><i class="fa fa-window-maximize full-card"></i></li>
                                            <li><i class="fa fa-minus minimize-card"></i></li>
                                            <li><i class="fa fa-refresh reload-card"></i></li>
                                            <li><i class="fa fa-trash close-card"></i></li>
                                        </ul>
                                    </div> -->
                                </div>
                                <div class="card-block">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-borderless">
                                            <thead>
                                                <tr>
                                                    <th>Full Name</th>
                                                    <th>Service</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Khadija Salehe Hashimu</td>
                                                    <td>Latra</td>
                                                    <td>TZS 129000.00</td>
                                                </tr>
                                                <tr>
                                                    <td>Khadija Salehe Hashimu</td>
                                                    <td>Disposable</td>
                                                    <td>TZS 129000.00</td>
                                                </tr>
                                                <tr>
                                                    <td>Khadija Salehe Hashimu</td>
                                                    <td>Mkopo Chap</td>
                                                    <td>TZS 129000.00</td>
                                                </tr>
                                                <tr>
                                                    <td>Khadija Salehe Hashimu</td>
                                                    <td>Muonekano Mpya</td>
                                                    <td>TZS 129000.00</td>
                                                </tr>
                                                <tr>
                                                    <td>Khadija Salehe Hashimu</td>
                                                    <td>Bima Ya Chombo</td>
                                                    <td>TZS 129000.00</td>
                                                </tr>
                                                <tr>
                                                    <td>Khadija Salehe Hashimu</td>
                                                    <td>Leseni</td>
                                                    <td>TZS 129000.00</td>
                                                </tr>
                                                <tr>
                                                    <td>Khadija Salehe Hashimu</td>
                                                    <td>Kidebe</td>
                                                    <td>TZS 129000.00</td>
                                                </tr>
                                                <tr>
                                                    <td>Khadija Salehe Hashimu</td>
                                                    <td>Bima Ya Afya</td>
                                                    <td>TZS 129000.00</td>
                                                </tr>
                                                <tr>
                                                    <td>Khadija Salehe Hashimu</td>
                                                    <td>Ada</td>
                                                    <td>TZS 129000.00</td>
                                                </tr>
                                                <tr>
                                                    <td>Khadija Salehe Hashimu</td>
                                                    <td>Maegesho</td>
                                                    <td>TZS 129000.00</td>
                                                </tr>
                                                <tr>

                                            </tbody>
                                        </table>
                                        <div class="text-right m-r-20">
                                            <a href="#!" class=" b-b-primary text-primary">View all Transactions</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ticket and update end -->
                    </div>
                </div>
            </div>

            <div id="styleSelector">

            </div>
        </div>
    </div>
</div>

<!-- Include ApexCharts JavaScript library -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>


<?php
$currentMonth = date('n');
$currentYear = date('Y');
?>
<script>
    var userss = <?= json_encode(Auth::user()) ?>;
    if (userss.role == 1) {
        document.addEventListener("DOMContentLoaded", function() {

            document.getElementById('month_select').value = '<?php echo $currentMonth; ?>';
            document.getElementById('year_select').value = '<?php echo $currentYear; ?>';


            filterGraphOnLoad();
            loadPieChart();

        });
    }
    $(document).ready(function() {
        polarGraph();
        bubbleChart();
        candleChart();
        genderChart();
        verificationGraph();
    });



    function filterGraphOnLoad() {
        var event = new Event('click');
        filterGraph(event);
    }

    function filterGraph(e) {
        e.preventDefault();

        showLoader();

        // disableBtn("submitBtn", true);
        var form = document.getElementById('formGraph');
        var formData = new FormData(form);

        jQuery.ajax({
            type: "POST",
            url: "/driver/filter-all-drivers/",
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
                hideLoader();
                if (data.status == 200) {
                    toastr.success(data.message)
                    loadChart(data.data);
                    // clear_input()
                } else {
                    toastr.warning(data.message)
                }

            },
            error: function(xhr, status, error) {
                // Hide loader in case of error
                hideLoader();

                console.error('Error:', error);
            }
        });
    }

    // Function to show loader
    function showLoader() {
        document.getElementById('loader').style.display = 'block';
    }

    // Function to hide loader
    function hideLoader() {
        document.getElementById('loader').style.display = 'none';
    }



    function loadChart(data) {
        var rowData = data;

        // Extract data for line chart
        var lineLabels = rowData.map(function(item) {
            return item.day;
        });
        var lineDataPoints = rowData.map(function(item) {
            return item.total_users;
        });

        // Extract data for bar chart
        var barDataPoints = rowData.map(function(item) {
            return item.total_users;
        });

        // Get canvas element for mixed chart
        var mixedCtx = document.getElementById('monthly-mixed-chart').getContext('2d');

        var existingChart = window.myChart;

        // console.log('existingChart', existingChart);

        // Destroy the existing chart instance
        if (existingChart) {
            existingChart.destroy();
        }

        // Create mixed chart
        window.myChart = new Chart(mixedCtx, {
            type: 'bar',
            data: {
                labels: lineLabels,
                datasets: [{
                    label: 'Total Drivers (Line)',
                    data: lineDataPoints,
                    type: 'line',
                    fill: false,
                    borderColor: 'rgba(240, 138, 23, 0.8)',
                    backgroundColor: 'rgba(240, 138, 23, 0.8)',
                    borderWidth: 1
                }, {
                    label: 'Total Drivers (Bar)',
                    data: barDataPoints,
                    backgroundColor: '#8fc9ae',
                    borderColor: '#8fc9ae',
                    borderWidth: 1
                }]
            },
            options: {
                animation: {
                    duration: 2000,
                    easing: 'easeInOutQuart'
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            },
        });

    };

    function polarGraph() {
        // Hardcoded data for the polar chart
        var data = {
            labels: ['Government', 'Insurance', 'Uniform', 'Ada', 'Others'],
            datasets: [{
                label: 'Dataset 1',
                data: [12, 19, 5, 2, 3],
                backgroundColor: [
                    '#79a8a9',
                    '#d9dad7',
                    // '#83afa6',
                    '#f0d587',
                    '#0b88a8',
                    '#678c40'
                ],
                borderColor: [
                    '#79a8a9',
                    '#d9dad7',
                    // '#83afa6',
                    '#f0d587',
                    '#0b88a8',
                    '#678c40'
                ],
                borderWidth: 1
            }]
        };

        // Configuration options for the polar chart
        var options = {
            scale: {
                ticks: {
                    beginAtZero: true
                }
            }
        };

        // Get the canvas element
        var ctx = document.getElementById('polarChart').getContext('2d');

        // Create the polar chart
        var polarChart = new Chart(ctx, {
            type: 'polarArea',
            data: data,
            options: options
        });
    }

    function bubbleChart() {
        // Hardcoded data for the bubble chart
        var data = {
            datasets: [{
                label: 'Transactions(License, Latra, Maegesho)',
                data: [{
                        x: 20,
                        y: 30,
                        r: 15
                    },
                    {
                        x: 40,
                        y: 10,
                        r: 10
                    },
                    {
                        x: 10,
                        y: 40,
                        r: 20
                    },
                    {
                        x: 30,
                        y: 20,
                        r: 25
                    },
                    {
                        x: 50,
                        y: 50,
                        r: 30
                    }
                ],
                backgroundColor: '#8fc9ae',
                borderColor: '#8fc9ae',
            }]
        };

        // Configuration options for the bubble chart
        var options = {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        };

        // Get the canvas element
        var ctx = document.getElementById('bubblechart').getContext('2d');

        // Create the bubble chart
        var bubbleChart = new Chart(ctx, {
            type: 'bubble',
            data: data,
            options: options
        });
    }

    function candleChart() {
        // Sample data for Candlestick chart
        var series = [{
            data: [{
                    x: new Date('2024-04-05'),
                    y: [40, 90, 30, 80]
                },
                {
                    x: new Date('2024-04-06'),
                    y: [50, 95, 35, 85]
                },
                {
                    x: new Date('2024-04-07'),
                    y: [30, 70, 20, 60]
                },
                {
                    x: new Date('2024-04-08'),
                    y: [35, 85, 25, 75]
                },
                {
                    x: new Date('2024-04-09'),
                    y: [30, 80, 25, 70]
                }
            ]
        }];

        // Initialize Candlestick chart
        var options = {
            chart: {
                type: 'candlestick',
                height: 300,
            },
            series: series,
            xaxis: {
                type: 'datetime',
            },
            yaxis: {
                tooltip: {
                    enabled: true
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart_Candlestick"), options);
        chart.render();
    }

    function genderChart() {
        // Sample data for gender distribution
        var data = {
            labels: ['Male', 'Female'],
            datasets: [{
                data: [45, 55], // Sample percentage distribution
                backgroundColor: [
                    '#8fc9ae', // Male
                    '#d9dad7' // Female
                ],

                borderWidth: 0
            }]
        };

        // Options for the gender chart
        var options = {
            legend: {
                display: false // Hide legend
            },
            responsive: true
        };

        // Create the gender chart
        var ctx = document.getElementById('genderChart').getContext('2d');
        var genderChart = new Chart(ctx, {
            type: 'doughnut',
            data: data,
            options: options
        });
    }

    function verificationGraph() {
        // Sample data for the pie chart
        var data = {
            // labels: ['Red', 'Purple',],
            datasets: [{
                data: [12, 2], // Sample data values
                backgroundColor: [
                    '#d9dad7',
                    '#8fc9ae'
                ],
                borderWidth: 0
            }]
        };

        // Options for the pie chart
        var options = {
            responsive: true
        };

        // Create the pie chart
        var ctx = document.getElementById('pieChart').getContext('2d');
        var pieChart = new Chart(ctx, {
            type: 'pie',
            data: data,
            options: options
        });
    }
</script>






@endsection