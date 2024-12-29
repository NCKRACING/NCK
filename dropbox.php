<?php
// dropbox.php

// dropbox.php

// After doing whatever necessary actions, you can redirect the user to skinhub.html.
header('Location: skinhub.html');  // Redirect to the skinhub.html page
exit();  // Ensure no further code is executed after the redirect
?>

// Dropbox API endpoint for listing files/folders
$apiUrl = 'https://api.dropboxapi.com/2/files/list_folder';

// Access token you get from Dropbox API
$accessToken = 'sl.CDe2KwCCTVguh9gfX4z0S1kMeZTXO6qWz7hGjfAWb6CxXif4oOwUDBrg0CtX13eLfQTjDUC6bjS_9sZ9Y7RnRknCbqdBCoeiQp6TbpUxCcJlzKlQGbFgEOFpwSQnMXZ5MUCYggbxPv3n4MzlWg6I-6k';

// Set the folder path you want to list files from
$folderPath = '/Apps/MXBSKINS/mods';  // Target folder

$headers = [
    "Authorization: Bearer $accessToken",
    "Content-Type: application/json"
];

// The data to send (request to list files in the folder)
$data = json_encode([
    "path" => $folderPath,  // Folder path
    "recursive" => true,     // Recurse into subfolders
    "limit" => 100           // Max number of items to fetch at once
]);

// Set up the cURL request
$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

// Execute the cURL request and capture the response
$response = curl_exec($ch);
curl_close($ch);

// Check if the request was successful
if ($response === false) {
    die('Error fetching folders from Dropbox.');
}

// Decode the JSON response from Dropbox
$folders = json_decode($response, true);

// Check if there are entries
if (isset($folders['entries'])) {
    echo "<ul class='folder-list'>";
    // Iterate through each entry (folder or file)
    foreach ($folders['entries'] as $folder) {
        // Only list .pnt files
        if (isset($folder['name']) && substr($folder['name'], -4) === '.pnt') {
            echo "<li class='folder-item'>" . htmlspecialchars($folder['name']) . "</li>";
        }
    }
    echo "</ul>";
} else {
    echo "<p>No .pnt files found.</p>";
}
?>
