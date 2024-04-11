<nav class="pcoded-navbar">
    <div class="pcoded-inner-navbar" style="background-color: #f0f0f0;">

        <ul class="pcoded-item pcoded-left-item">
            <div class="container" style="max-width: 220px;">
                <a href="/dashboard">
                    <img class="img-fluid" src="{{ asset('images\shiri.png')}}" alt="Theme-Logo" style=" padding-bottom: 20px;padding-top: 10px">
                </a>
            </div>
            <li class="pcoded-hasmenu">
                <a href="/dashboard" style="padding-left: 30px;">
                    <span class="pcoded-micon"><i class="feather icon-home" style="color: #333;"></i></span>
                    <span class="pcoded-mtext" style="color: #333;font-weight: normal;">Dashboard</span>
                </a>
            </li>
            <li class="pcoded-hasmenu">
                <a href="/driver/driver" style="padding-left: 30px;">
                    <span class="pcoded-micon"><i class="fa fa-users" style="color: #333;"></i></span>
                    <span class="pcoded-mtext" style="color: #333;font-weight: normal;">Drivers</span>
                </a>
            </li>
            <li class="">
                <a href="#" style="padding-left: 30px;">
                    <span class="pcoded-micon"><i class="fa fa-puzzle-piece" style="color: #333;"></i></span>
                    <span class="pcoded-mtext" style="color: #333;font-weight: normal;">Services</span>
                </a>
            </li>
            <li class="pcoded-hasmenu">
                <a href="#" style="padding-left: 30px;">
                    <span class="pcoded-micon"><i class="fa fa-archive" style="color: #333;"></i></span>
                    <span class="pcoded-mtext" style="color: #333;font-weight: normal;">Collections</span>
                </a>
            </li>
            <li class="pcoded-hasmenu">
                <a href="#" style="padding-left: 30px;">
                    <span class="pcoded-micon"><i class="feather icon-layers" style="color: #333;"></i></span>
                    <span class="pcoded-mtext" style="color: #333;font-weight: normal;">Arrears</span>
                </a>
            </li>
            <li class="pcoded-hasmenu">
                <a href="#" style="padding-left: 30px;">
                    <span class="pcoded-micon"><i class="fa fa-book" style="color: #333;"></i></span>
                    <span class="pcoded-mtext" style="color: #333;font-weight: normal;">Reports</span>
                </a>
            </li>
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)" style="padding-left: 30px;">
                    <span class="pcoded-micon"><i class="fa fa-cogs" style="color: #333;"></i></span>
                    <span class="pcoded-mtext" style="color: #333;font-weight: normal;">Management</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="">
                        <a href="/location/region">
                            <span class="pcoded-mtext">Region</span>
                        </a>
                    </li>
                    <li class="">
                        <a href="/location/district">
                            <span class="pcoded-mtext">District</span>
                        </a>
                    </li>
                    <li class=" ">
                        <a href="/location/ward">
                            <span class="pcoded-mtext">Ward</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="pcoded-hasmenu">
                <a href="/parking/parking" style="padding-left: 30px;">
                    <span class="pcoded-micon"><i class="fa fa-car" style="color: #333;"></i></span>
                    <span class="pcoded-mtext" style="color: #333;font-weight: normal;">Parking Areas</span>
                </a>
            </li>
            <li class="#">
                <a href="javascript:void(0)" style="padding-left: 30px;">
                    <span class="pcoded-micon"><i class="fa fa-users" style="color: #333;"></i></span>
                    <span class="pcoded-mtext" style="color: #333;font-weight: normal;">Associations</span>
                </a>
            </li>
        </ul>
    </div>
</nav>

<script>
    // Wait for the DOM to be fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Get the current URL
        var currentUrl = window.location.href;

        // Select all menu items
        var menuItems = document.querySelectorAll('.pcoded-item.pcoded-left-item li');

        // Loop through each menu item
        menuItems.forEach(function(item) {
            // Get the link inside the menu item
            var link = item.querySelector('a');

            // Get the href attribute value of the link
            var href = link.getAttribute('href');

            // Check if the current URL contains the href attribute value
            if (currentUrl.includes(href)) {
                // If it does, add the active class to the parent menu item
                item.classList.add('active');

                // Get the span elements inside the menu item
                var spans = item.querySelectorAll('span');

                // Loop through each span and update their styles
                spans.forEach(function(span) {
                    span.style.color = '#fff'; // Change text color to white
                });

                // Additionally, change icon color to white
                var icon = item.querySelector('.pcoded-micon i');
                if (icon) {
                    icon.style.color = '#fff';
                }
            }
        });
    });
</script>