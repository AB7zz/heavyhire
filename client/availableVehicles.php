<?php include 'db/db.php' ?>
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
                <input type="text" class="w-[80%] border-b text-gray-800 focus:outline-none" placeholder="From">
                <input type="text" class="w-[80%] border-b text-gray-800 focus:outline-none" placeholder="To">
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
                $query = "select * from available";
                $run = $connect->query($query);
                while($row = $run->fetch_assoc()){
                    $Ufrom = $row['tfrom'];
                    $from = DateTime::createFromFormat('H:i:s.u', $Ufrom)->format('H:i');
                    $Uto = $row['tto'];
                    $to = DateTime::createFromFormat('H:i:s.u', $Uto)->format('H:i');
                    $v_id = $row['v_id'];
                    $loc = $row['loc'];
                    $query_vehicle = "select * from vehicle where v_id = $v_id";
                    $run_vehicle = $connect->query($query_vehicle);
                    $vehicle_data = $run_vehicle->fetch_assoc();
                    $brand = $vehicle_data['brand'];
                    $model = $vehicle_data['model'];
                    $phone = $row['phone'];
                    echo "<div class='px-10 py-10 flex'>
                    <img src='images/truck.jpg' class='w-[350px] h-[200px]' />
                    <div class='ml-5'>
                        <h2 class='text-2xl font-bold'>$brand $model</h2>
                        <p class='text-gray-800 text-xl mb-3'><i class='fa-sharp fa-solid fa-location-dot'></i> $loc</p>
                        <div class='mb-5 flex'>
                            <i class='fa-regular fa-star text-yellow-500 cursor-pointer mr-2'></i>
                            <i class='fa-regular fa-star text-yellow-500 cursor-pointer mr-2'></i>
                            <i class='fa-regular fa-star text-yellow-500 cursor-pointer mr-2'></i>
                            <i class='fa-regular fa-star text-yellow-500 cursor-pointer mr-2'></i>
                            <i class='fa-regular fa-star text-yellow-500 cursor-pointer mr-2'></i>
                        </div>
                        <p class='text-gray-800 text-lg'>Available timings :-</p>
                        <ul class='list-disc ml-5'>
                            <li>$from am - $to am</li>
                        </ul>
                    </div>
                    <div class='flex flex-col ml-auto'>
                        <button class='rounded text-white bg-red-800 py-2 px-3 hover:bg-red-700 w-[1005] mb-5'>Book</button>
                        <button onclick='document.getElementById('myForm').submit();' id='contact_button' class='rounded text-white bg-blue-800 py-2 px-3 hover:bg-blue-700 mb-5'>$phone</button>
                        <button class='rounded text-white bg-black py-2 px-3 hover:bg-slate-700' onclick='openChatDialog(<?php echo $phone; ?>)'>Message</button>

                    </div> 
                    <!-- Hidden form to trigger PHP code on button click -->
                    <form id='myForm' method='POST'>
                        <input type='hidden' name='button_clicked' value='true'>
                    </form>
                </div>";
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

<?php
    if (isset($_POST['button_clicked'])) {
        echo "<script>document.getElementById('contact_button').innerHTML = 'ss';</script>";
    }
?>



