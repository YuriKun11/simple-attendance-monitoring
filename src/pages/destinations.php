<?php
$all_destinations = [
    [
        'name' => 'Ma-Cho Temple',
        'tag' => 'Cultural Landmark',
        'image' => '../assets/img/attractions/temple.jpg',
        'description' => 'Ma-Cho Temple (Taoist temple) is a place of worship and a tourist attraction. Please be observant and respect the rules. You can appreciate the beautiful architecture of this place with a picture perfect spot on the top wherein you can view the vast lands of San Fernando.',
        'location' => 'San Fernando, La Union'
    ],
    [
        'name' => 'Saint William the Hermit Cathedral',
        'tag' => 'Historical Church',
        'image' => '../assets/img/attractions/church.jpg',
        'description' => 'Saint William the Hermit Cathedral, commonly known as San Fernando Cathedral, is the seat of the Roman Catholic Diocese of San Fernando de La Union, in the Philippines. The diocese was created on January 19, 1970, with Saint William the Hermit as the titular saint.',
        'location' => 'San Fernando, La Union'
    ],
    [
        'name' => 'Pindangan Ruins',
        'tag' => 'Historic Site',
        'image' => '../assets/img/attractions/ruins.jpg',
        'description' => 'The Pindangan Ruins are the remnants of the first Catholic church in San Fernando, built in 1764 by Spanish missionaries. The ruins are located within the compound of the Carmelite Monastery, where the Carmelite nuns have helped preserve the historical site.',
        'location' => 'San Fernando, La Union'
    ],
    [
        'name' => 'Pagoda Hill',
        'tag' => 'Scenic Viewpoint',
        'image' => '../assets/img/attractions/pagoda.jpg',
        'description' => 'Pagoda Hill or the Filipino-Chinese Friendship Park Pagoda, a viewpoint located on a hill with a panoramic view of the city and harbor. It is a popular spot for both locals and tourists to enjoy scenic sunrises or sunsets.',
        'location' => 'San Fernando, La Union'
    ],
    [
        'name' => 'Poro Point Lighthouse',
        'tag' => 'Maritime History',
        'image' => '../assets/img/attractions/lighthouse.jpg',
        'description' => 'The Poro Point Lighthouse is a historic lighthouse in San Fernando, La Union, Philippines, that guides ships and offers scenic views of the coastline. It was built in the early 20th century and is a functioning navigational aid.',
        'location' => 'Poro Point, San Fernando, La Union'
    ],
    [
        'name' => 'SM City La Union',
        'tag' => 'Shopping & Leisure',
        'image' => '../assets/img/attractions/sm.jpg',
        'description' => 'SM City La Union is a shopping mall owned by SM Prime Holdings. It is the first SM Supermall in the province of La Union. Located along Diversion Road, it is a convenient stop for shopping and dining.',
        'location' => 'San Fernando, La Union'
    ],
    [
        'name' => 'Urbiztondo Beach',
        'tag' => 'Surfing & Sunsets',
        'image' => '../assets/img/attractions/urbiztondo.jpg',
        'description' => 'The most famous beach in San Juan, La Union, known for its consistent waves perfect for surfing beginners and enthusiasts alike. It is also the perfect spot to enjoy a vibrant nightlife and spectacular sunsets.',
        'location' => 'San Juan, La Union'
    ],
    [
        'name' => 'Tangadan Falls',
        'tag' => 'Adventure Trekking',
        'image' => '../assets/img/attractions/falls.jpg',
        'description' => 'A stunning multi-tiered waterfall accessible via a scenic trek. It offers cool, refreshing waters for swimming and a truly rewarding natural experience after a hike.',
        'location' => 'San Gabriel, La Union'
    ],
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TouRide - All Destinations</title>
    <link href="../output.css" rel="stylesheet"> 
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="min-h-screen">

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

  <?
    include '../component/destinationsNavbar.php';
   ?>
    
    
    <main class="mt-12 mb-16">

      <section id="attractions" class="py-10">
            <h1 class="text-4xl font-extrabold text-center text-slate-900 mb-4">Discover La Union: Top Tourist Attractions</h1>
        <p class="text-xl text-center text-gray-600 mb-12 max-w-4xl mx-auto">Explore the rich cultural, historical, and natural beauty of La Union. Plan your journey to these spots easily with TouRide.</p>

        <hr class="my-10"/>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php foreach ($all_destinations as $attraction): ?> 
                <div class="bg-white rounded-xl shadow-xl overflow-hidden group hover:shadow-2xl transition duration-300">
                    <div class="h-48 overflow-hidden">
                        <img src="<?php echo $attraction['image']; ?>" alt="<?php echo $attraction['name']; ?>" 
                                    class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                    </div>
                    <div class="p-5">
                        <h3 class="text-xl font-bold text-slate-900 mb-1"><?php echo $attraction['name']; ?></h3>
                        <p class="text-blue-600 font-semibold mb-2 text-sm"><?php echo $attraction['tag']; ?></p>
                        <p class="text-gray-500 text-xs italic mb-3"><?php echo $attraction['location']; ?></p> 
                        <p class="text-gray-700 text-sm mb-4 line-clamp-3"><?php echo $attraction['description']; ?></p> 
                        <a href="../login.php" class="text-gray-600 text-sm font-medium hover:text-blue-600 transition duration-150 flex items-center">
                            Book Trip →
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
                </div>
        </section>


        <hr class="my-10"/>

        <section id="live-map" class="mt-3 pt-10 mb-16">
            <h2 class="text-3xl font-bold text-center text-slate-900 mb-6">🗺️Map of La Union</h2>
            <div class="w-full h-[800px] overflow-hidden rounded-xl shadow-2xl border-4 border-blue-600">
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d976624.0766642678!2d119.73864306635173!3d16.61541306378634!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x338e1aab0d2d9b71%3A0x2b6b90b14486f0ce!2sLa%20Union!5e0!3m2!1sen!2sph!4v1730664862143!5m2!1sen!2sph"
                width="100%"
                height="550"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
              </iframe>
            </div>
        </section>
        </main>

        <div class="text-center mt-12">
            <a href="../index.php" class="btn-outline inline-block px-8 py-3 font-semibold rounded-lg transition duration-300">
                ← Back to Homepage
            </a>
        </div>
</div>
 <?
    include '../component/pagefooter.php';
   ?>
<script src="../assets/js/app.js"></script>

</body>
</html>