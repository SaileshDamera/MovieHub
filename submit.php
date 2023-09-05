<?php

if($_SERVER["REQUEST_METHOD"]=="GET")
{
$server="localhost";
$username="root";
$password="";
$database="movies";

$conn=mysqli_connect($server,$username,$password,$database);
$name=$_GET['print'];

$sql="INSERT INTO `users` (`movie_name`) VALUES ('$name')";
$res=mysqli_query($conn,$sql);
}

$api_url = 'http://www.omdbapi.com/';
$api_key = 'b5aa97c6';
$movie_title = $name;
$api_params = array(
    'apikey' => $api_key,
    't' => $movie_title
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $api_url . '?' . http_build_query($api_params));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$movie_data = json_decode($response, true);

if ($movie_data['Response'] == 'True') {
    echo '<div class="movie-container">
            <div class="movie-details">
                <h2>' . $movie_data['Title'] . ' (' . $movie_data['Year'] . ')</h2>
                <p><strong>Director:</strong> ' . $movie_data['Director'] . '</p>
                <p><strong>Actors:</strong> ' . $movie_data['Actors'] . '</p>
                <p><strong>Plot:</strong> ' . $movie_data['Plot'] . '</p>
                <p><strong>Release Date:</strong> ' . $movie_data['Released'] . '</p>
                <p><strong>Runtime:</strong> ' . $movie_data['Runtime'] . '</p>
                <p><strong>IMDB Rating:</strong> ' . $movie_data['imdbRating'] . '</p>
            </div>
            <div class="movie-poster">
                <img src="' . $movie_data['Poster'] . '" alt="' . $movie_data['Title'] . ' Poster">
            </div>
          </div>';
} else {
    echo '<div class="error-message">Movie not found</div>';
}

?>