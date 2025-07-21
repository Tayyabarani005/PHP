<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "form";
$port = 3307;
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname, $port);
if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}
if($_SERVER['REQUEST_METHOD']=='POST'){
    $username = $_POST['username'];
    $password = $_POST['password'];

$sql = "INSERT INTO login (username, password) VALUES ('$username', '$password')";
mysqli_query($conn, $sql);


    mysqli_close($conn);
}





?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./output.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Home page</title>
</head>

<body>
    <div class="hero bg-repeat  " style="background-image: url('background.jpg');  ">

        <h1 class="text-center text-5xl font-bold h-max  text-purple-400">Discover The World!</h1>
        <div class=" grid grid-cols-4  gap-3 m-3">
            <div class="h-80 max-w-60 bg-purple-300 mt-10 rounded-sm m-5 ">
                <img src="paris.png" alt="">
                <h1 class="font-bold text-purple-600 mt-1 text-center ml-1">Paris, France</h1>
                <p class="text-purple-900">The City of Light is famous for its iconic landmarks like the Eiffel Tower,
                    Notre-Dame Cathedral, and the Louvre Museum.</p>
            </div>
            <div class=" h-80 max-w-60 bg-purple-300 mt-10 rounded-sm m-5 ">
                <img src="bangkok.png" alt="">
                <h1 class="font-bold  text-purple-600 mt-1 text-center ml-1">Bangkok, Thailand</h1>
                <p class="text-purple-900">This bustling metropolis is known for its street food, night markets, and
                    ornate temples like the Grand Palace and Wat Phra Kaew.</p>

            </div>
            <div class=" h-80 max-w-60 bg-purple-300 mt-10 rounded-sm m-5 ">
                <img src="uk.png" alt="">
                <h1 class="font-bold  text-purple-600 mt-1 text-center ml-1">London, UK</h1>
                <p class="text-purple-900">England's capital city is steeped in history and culture, with attractions
                    like Buckingham Palace, the British Museum, and the Tower of London.</p>
            </div>
            <div class=" h-80 max-w-60 bg-purple-300 mt-10 rounded-sm m-5">
                <img src="uae.png" alt="">
                <h1 class="font-bold  text-purple-600 mt-1 text-center ml-1">Dubai, UAE</h1>
                <p class="text-purple-900">This luxurious city is famous for its modern architecture, world-class
                    shopping, and iconic landmarks like the Burj Khalifa and Palm Jumeirah. </p>
            </div>
            <div class=" h-80 max-w-60 bg-purple-300 mt-10 rounded-sm m-5  ">
                <img src="singapore.png" alt="">
                <h1 class="font-bold  text-purple-600 mt-1 text-center ml-1">Singapore</h1>
                <p class="text-purple-900">This cosmopolitan city-state is known for its Gardens by the Bay, Marina Bay
                    Sands, and vibrant food scene.</p>
            </div>
            <div class=" h-80 max-w-60 bg-purple-300 mt-10 rounded-sm m-5 ">
                <img src="kaula.png" alt="">
                <h1 class="font-bold  text-purple-600 mt-1 text-center ml-1">Kuala Lumpur, Malaysia</h1>
                <p class="text-purple-900">The Petronas Twin Towers, Batu Caves, and vibrant night markets make KL a
                    popular destination in Southeast Asia.</p>
            </div>
            <div class=" h-80 max-w-60 bg-purple-300 mt-10 rounded-sm m-5 ">
                <img src="newyork.png" alt="">
                <h1 class="font-bold  text-purple-600 mt-1 text-center ml-1">New York City, USA</h1>
                <p class="text-purple-900">The City That Never Sleeps is famous for its iconic skyline, Central Park,
                    and world-class museums like the Met and MoMA.</p>
            </div>
            <div class=" h-80 max-w-60 bg-purple-300 mt-10 rounded-sm m-5 ">
                <img src="china.png" alt="">
                <h1 class="font-bold  text-purple-600 mt-1 text-center ml-1">Shenzhen, China</h1>
                <p class="text-purple-900">This modern city is known for its theme parks like Window of the World and
                    Splendid China Folk Village, as well as its shopping and nightlife. </p>
            </div>
            <div class=" h-80 max-w-60  bg-purple-300 mt-10 rounded-sm m-5 ">
                <img src="istanbul.png" alt="">
                <h1 class="font-bold  text-purple-600 mt-1 text-center ml-1">Istanbul, Turkey</h1>
                <p class="text-purple-900">Straddling Europe and Asia, Istanbul is famous for its Hagia Sophia, Topkapi
                    Palace, and bustling bazaars.</p>
            </div>
            <div class=" h-80 max-w-60 bg-purple-300 mt-10 rounded-sm m-5 ">
                <img src="spain.png" alt="">
                <h1 class="font-bold  text-purple-600 mt-1 text-center ml-1">Barcelona, Spain</h1>
                <p class="text-purple-900">The capital of Catalonia is known for its modernist architecture, beaches,
                    and cultural attractions like La Sagrada Familia and Park Güell.</p>
            </div>
            <div class=" h-80 max-w-60 bg-purple-300 mt-10 rounded-sm m-5 ">
                <img src="japan.png" alt="">
                <h1 class="font-bold  text-purple-600 mt-1 text-center ml-1">Japan, Tokyo</h1>
                <p class="text-purple-900">Neon skyscrapers meet ancient temples, Tokyo's vibrant pulse blends tradition
                    with innovation, where cherry blossoms dance in the city's gentle breeze.</p>
            </div>
            <div class=" h-80 max-w-60 bg-purple-300 mt-10 rounded-sm m-5 ">
                <img src="italy.png" alt="">
                <h1 class="font-bold  text-purple-600 mt-1 text-center ml-1">Italy, Rome</h1>
                <p class="text-purple-900">Rome's beauty unfolds like a Renaissance masterpiece. Fountain's shimmering
                    waters to Colosseum's majestic arches, captivating hearts.</p>
            </div>


        </div>
        <div class="bg-purple-300 p-3">
            <h1 class="font-bold text-5xl text-center cursor-pointer text-purple-600">Book Your Tickets Now!</h1>
            <p class="mt-2 text-center text-purple-900">Secure your spot on our guided tours and experiences<br>Get
                instant confirmation and e-tickets</p>
        </div>
        <div class="button font-bold text-center flex justify-center text-purple-300 "><button
                class="bg-purple-900 text-5xl rounded-full mt-4 p-3"><a href="form.html">Book Now</a></button></div>
        <a class="font-bold underline text-white" href="index.html"> Click here to return to main Page</a>
    </div>

</body>

</html>