<!DOCTYPE html>
<html lang="en">
<head>
    <title>FLAMES</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Form Box -->
    <div class="form-box" id="form">
        <form method="post">
            <h1>FLAMES</h1>
            <!-- First Person's Details Section -->
            <h2>First Person's Details</h2>
            <div class="input-box">
                <input type="text" name="name1" placeholder="Name" required>
                <ion-icon name="person"></ion-icon>
            </div>
            <div class="input-box">
                <input type="date" name="birthdate1" placeholder="mmm/dd/yyyy" required>
            </div>
            <!-- Second Person's Details Section -->
            <h2>Second Person's Details</h2>
            <div class="input-box">
                <input type="text" name="name2" placeholder="Name" required>
                <ion-icon name="person"></ion-icon>
            </div>
            <div class="input-box">
                <input type="date"  name="birthdate2" placeholder="mmm/dd/yyyy" required>
            </div>
            <!-- Submit Button Section -->
            <div class="btn-box">
                <button type="submit" class="btn" id="submit">Submit</button>
            </div>
        </form>
    </div>

    <div class="tarot-box" id="tarot">
        <?php
        // Function to get zodiac sign based on birthdate
        function getZodiacSign($birthdate) {
            $monthDay = date("m-d", strtotime($birthdate));
            $zodiacSigns = array(
                'Aries' => array('03-21', '04-19'),
                'Taurus' => array('04-20', '05-20'),
                'Gemini' => array('05-21', '06-20'),
                'Cancer' => array('06-21', '07-22'),
                'Leo' => array('07-23', '08-22'),
                'Virgo' => array('08-23', '09-22'),
                'Libra' => array('09-23', '10-22'),
                'Scorpio' => array('10-23', '11-21'),
                'Sagittarius' => array('11-22', '12-21'),
                'Capricorn' => array('12-22', '01-19'),
                'Aquarius' => array('01-20', '02-18'),
                'Pisces' => array('02-19', '03-20')
            );
            foreach ($zodiacSigns as $sign => $dates) {
                if ($monthDay >= $dates[0] && $monthDay <= $dates[1]) {
                    return $sign;
                }
            }
            return "";
        }

        // Function to calculate FLAMES compatibility
        function calculateFLAMES($name1, $name2) {
            // Convert names to lowercase and remove spaces
            $name1 = strtolower(str_replace(' ', '', $name1));
            $name2  = strtolower(str_replace(' ', '', $name2));

            // Count occurrences of each letter in both names
            $name1_counts = array_count_values(str_split($name1));
            $name2_counts = array_count_values(str_split($name2));

            // Find common letters between the two names
            $common_letters = array_intersect_key($name1_counts, $name2_counts);
           
            // Initialize arrays and variables for counting common letters
            $name1_common_counts = [];
            $name2_common_counts = [];
            $total_name1_common = 0;
            $total_name2_common = 0;

            // Iterate over common letters and count occurrences in each name
            foreach ($common_letters as $letter => $count) {
                $name1_common_counts[$letter] = isset($name1_counts[$letter]) ? $name1_counts[$letter] : 0;
                $name2_common_counts[$letter] = isset($name2_counts[$letter]) ? $name2_counts[$letter] : 0;
                $total_name1_common += $name1_common_counts[$letter];
                $total_name2_common += $name2_common_counts[$letter];
            }

            // Calculate total count of common letters
            $total_of_common =  $total_name1_common +  $total_name2_common;
            
            // Determine FLAMES result based on total count of common letters
            if ($total_of_common > 0) {
                $result = $total_of_common % 6;
                if ($result == 0) {
                    $resultIndex = 5;
                } else {
                    $resultIndex = $result - 1;
                }
                $flamesArray = ["Friends", "Lovers", "Anger", "Married", "Engaged", "Soulmates"];
                $compatibility_result = $flamesArray[$resultIndex];
            } else {
                $compatibility_result = "No common letters";
            }
            return $compatibility_result;
        }

        // Process form submission
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve form data
            $name1 = $_POST['name1'];
            $name2 = $_POST['name2'];
            $birthdate1 = $_POST['birthdate1'];
            $birthdate2 = $_POST['birthdate2'];

            // Calculate zodiac signs for both persons
            $zodiacSign1 = getZodiacSign($birthdate1);
            $zodiacSign2 = getZodiacSign($birthdate2);

            // Calculate FLAMES compatibility between the two persons
            $flamesResult = calculateFLAMES($name1, $name2);

            // Define images for zodiac signs
            $zodiacSignImages = array(
                'Aries' => 'aries.png',
                'Taurus' => 'taurus.png',
                'Gemini' => 'gemini.png',
                'Cancer' => 'cancer.png',
                'Leo' => 'leo.png',
                'Virgo' => 'virgo.png',
                'Libra' => 'libra.png',
                'Scorpio' => 'scorpio.png',
                'Sagittarius' => 'sagittarius.png',
                'Capricorn' => 'capricorn.png',
                'Aquarius' => 'aquarius.png',
                'Pisces' => 'pisces.png'
            );

            // Output HTML displaying tarot cards and compatibility result
            echo '<div class="tarot-card-box" style="animation: fadeIn 1s ease forwards;">
                    <div class="tarot-card" id="tarotCard1" style="animation: flipCard 1.5s forwards; animation-delay: 0.7s;">
                        <div class="front">
                        </div>
                        <div class="back">
                            <div class="image-container">
                                <img src="zodiac-images/' . $zodiacSignImages[$zodiacSign1] . '" alt="' . $zodiacSign1 . '">
                            </div>   
                            <h3>'. $name1 .'</h3>
                            <p>'. $birthdate1 .'</p>
                        </div>
                    </div>
                    <div class="tarot-card" id="tarotCard2" style="animation: flipCard 1.5s forwards; animation-delay: 0.7s;">
                        <div class="front">
                        </div>
                        <div class="back">
                            <div class="image-container">
                                <img src="zodiac-images/' . $zodiacSignImages[$zodiacSign2] . '" alt="' . $zodiacSign2 . '">
                            </div>   
                            <h3>'. $name2 .'</h3>  
                            <p>'. $birthdate2 .'</p>
                        </div>
                    </div>
                </div>
                <div class="results" style="animation: fadeIn 1s ease forwards; animation-delay: 1s;">
                    <h1>Compatibility: '. $flamesResult .'</h1>
                </div>
            </div>';
        }     
        ?>
    </div>
        
    <script>
        // Prevent form resubmission on page reload
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>

    <!-- Load Ionicons library with ES module support -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <!-- Fallback for browsers that do not support ES modules -->
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>