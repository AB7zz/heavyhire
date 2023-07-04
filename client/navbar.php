
<header class="bg-dark">
    <div class="container">
        <nav>
            <div>
                <a href="index.php" class="logo">Heavy Hire</a>
                <ul class="nav-links">
                    <li><a href="#">Company</a></li>
                    <li><a href="#">Safety</a></li>
                    <li><a href="#">Help</a></li>
                </ul>
            </div>
            <div id="not_logged">
                <ul id="nav-links" class="nav-links">
                    <li><a href="#">english</a></li>
                    <li><a href="#">Products</a></li>
                    <li><a href="login.php">Log in</a></li>
                    <li><a href="signup.php" class="nav__cta">Sign up</a></li>
                </ul>
            </div>
            <div id="logged" style="display: none;">
                <ul id="nav-links" class="nav-links">
                    <li><a href="#">english</a></li>
                    <li><a href="#">Products</a></li>
                    <li><a href="profile.php" id="logged_name" class="nav__cta"></a></li>
                    <li><a id="logged_side_btn">View Available Vehicles</a></li>
                    <li><a href="#" id="logout_btn">Log out</a></li>
                </ul>
            </div>
            <div class="hamburger">
                <span class="hamburger-bar"></span><span class="hamburger-bar"></span>
                <span class="hamburger-bar"></span>
            </div>
        </nav>
    </div>
</header>
<script>
    if (localStorage.getItem('name')) {
        document.getElementById('not_logged').style.display = 'none';
        document.getElementById('logged').style.display = 'block';
        document.getElementById('logged_name').innerHTML = localStorage.getItem('name');
        if (localStorage.getItem('type_id') == "1") {
            document.getElementById('logged_side_btn').href = "driverDashboard.php";
            document.getElementById('logged_side_btn').innerHTML = "Dashboard";
        } else if (localStorage.getItem('type_id') == "2") {
            document.getElementById('logged_side_btn').href = "availableVehicles.php";
            document.getElementById('logged_side_btn').innerHTML = "View available vehicles";
        }
    } else {
        document.getElementById('not_logged').style.display = 'block';
        document.getElementById('logged').style.display = 'none';
    }
    
    document.getElementById('logout_btn').addEventListener('click', function() {
        // Clear local storage and perform logout actions
        localStorage.clear();
        // Redirect to the logout page or perform any other desired action
        window.location.href = 'logout.php';
    });
</script>
