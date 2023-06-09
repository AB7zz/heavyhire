<?php include 'db/db.php'; session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Heavy Hire</title>
    <?php include 'links.php' ?>
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="px-5 py-5 mt-5">
        <div class="custom-shadow h-[100px] rounded-[20px] px-10 py-8">
            <div class="flex justify-between">
                <input type="text" id="from" class="w-[80%] border-b text-gray-800 focus:outline-none" placeholder="From">
                <input type="text" id="to" class="w-[80%] border-b text-gray-800 focus:outline-none" placeholder="To">
                <select type="text" class="w-[80%] border-b text-gray-500">
                    <option value="" class="">Select your vehicle</option>
                    <option value="">Truck</option>   
                    <option value="">Select your vehicle</option>
                    <option value="">Select your vehicle</option>
                </select>
                <input type="time" name="" id="">
                <button class="rounded text-white bg-green-800 py-2 px-3 hover:bg-green-700">Search</button>
            </div>
        </div>
    </div>
    <div class="px-5 py- mb-20">
        <div class="custom-shadow h-[100%] rounded-[20px]">
            <!-- Card -->
            <?php
                $user_id = $_SESSION['acc_id'];
                $query = "select * from available";
                $run = $con->query($query);
                while($run && $row = $run->fetch_assoc()){
                    $avai_id = $row['avai_id'];
                    $Ufrom = $row['tfrom'];
                    $acc_id = $row['acc_id'];
                    $from = DateTime::createFromFormat('H:i:s.u', $Ufrom)->format('H:i');
                    $Uto = $row['tto'];
                    $to = DateTime::createFromFormat('H:i:s.u', $Uto)->format('H:i');
                    $v_id = $row['v_id'];
                    $loc = $row['loc'];
                    $query_vehicle = "select * from vehicle where v_id = $v_id";
                    $run_vehicle = $con->query($query_vehicle);
                    $vehicle_data = $run_vehicle->fetch_assoc();
                    $brand = $vehicle_data['brand'];
                    $model = $vehicle_data['model'];
                    $phone = $row['phone'];
                    $image = $row['image'];

                    $allStars = "select * from rating where acc_id = $acc_id";
                    $run_allStars = $con->query($allStars);
                    $sumStars = 0;
                    while($row_star = $run_allStars->fetch_assoc()){
                        $sumStars += $row_star['rating'];
                    }
                    $rating = floor($sumStars / $run_allStars->num_rows);
                    $checkBooked = "select * from book where user_id=$user_id AND avai_id=$avai_id";
                    $runCheckBooked = $con->query($checkBooked);
                    if($runCheckBooked->num_rows == 0){
                        echo "<div class='px-10 py-10 flex'>
                        <img src='../backend/availableImages/$image' class='w-[350px] h-[200px]' />
                        <div class='ml-5'>
                            <h2 class='text-2xl font-bold'>$brand $model</h2>
                            <p class='text-gray-800 text-xl mb-3'><i class='fa-sharp fa-solid fa-location-dot'></i> $loc</p>
                            <div class='mb-5 flex'>";
                        for($i=1; $i<=$rating; $i++){
                            echo "<i class='fa-solid fa-star text-yellow-500 cursor-pointer mr-2'></i>";
                        }
                        for($i=1;$i<=5-$rating; $i++){
                            echo "<i class='fa-regular fa-star text-yellow-500 cursor-pointer mr-2'></i>";
                        }
                        echo "
                            </div>
                            <p class='text-gray-800 text-lg'>Available timings :-</p>
                            <ul class='list-disc ml-5'>
                                <li>$from am - $to am</li>
                            </ul>
                        </div>
                        <div class='flex flex-col ml-auto'>
                            <form id='book_button'>
                                <input type='hidden' name='avai_id' value=$avai_id>
                                <input type='hidden' name='driver_id' value=$acc_id>
                                <button type='submit' class='rounded text-white bg-red-800 py-2 px-3 hover:bg-red-700 w-[1005] mb-5'>Book</button>
                            </form>
                            <button onclick='document.getElementById('myForm').submit();' id='contact_button' class='rounded text-white bg-blue-800 py-2 px-3 hover:bg-blue-700 mb-5'>$phone</button>
                            <button class='rounded text-white bg-black py-2 px-3 hover:bg-slate-700'>Message</button>
                        </div> 
                        <!-- Hidden form to trigger PHP code on button click -->
                        <form id='myForm' method='POST'>
                            <input type='hidden' name='button_clicked' value='true'>
                        </form>
                    </div>";
                    }
                }
            ?>
            <!-- Card -->
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <script>
        AOS.init();
    </script>
</body>

</html>

<script>

    const form = document.querySelector("#book_button");
    form.addEventListener("submit", (e) => {
        const driver_id = form.querySelector("input").value
        const pick_up = document.querySelector("#from").value
        const drop_off = document.querySelector("#to").value
        e.preventDefault();
        console.log(driver_id, pick_up, drop_off, localStorage.getItem('acc_id'))
        const data = new FormData();
        data.append('avai_id', localStorage.getItem('avai_id'));
        data.append('user_id', localStorage.getItem('acc_id'));
        data.append('driver_id', driver_id);
        data.append('pick_up', pick_up);
        data.append('drop_off', drop_off);
        fetch("../backend/book.php", {
            method: "POST",
            body: data
        })
        .then(response => response.json())
            .then(data => {
                window.location.replace('/heavyhire/client/user/booked.php')
            })
            .catch(error => {
                console.error(error);
            });
        console.log(data)
    })
</script>

<?php
    if (isset($_POST['button_clicked'])) {
        echo "<script>document.getElementById('contact_button').innerHTML = 'ss';</script>";
    }
?>