<?php

// $target_website = "netflix.com";

// $key = "kSTytmr43soxaiw9fm20";
// $secret_key = "AlL7hLVVG1JX7ZKDbCkl";

// // Use URL-safe base64 encoding
// $base64_target_website = str_replace(array('+', '/'), array('-', '_'), base64_encode($target_website));

// $api_url = sprintf("https://api.webshrinker.com/categories/v3/%s", $base64_target_website);

// $ch = curl_init();
// curl_setopt($ch, CURLOPT_URL, $api_url);
// curl_setopt($ch, CURLOPT_USERPWD, "{$key}:{$secret_key}");
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// $result = json_decode(curl_exec($ch));
// $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// switch ($status_code) {
//     case 200:
//         // Do something with the JSON response
//         $category_data = $result->data[0]->categories;

//         // Build a string array containing the category ID, the human friendly category name, score and confident values for each entry
//         $categories = array();
//         foreach ($category_data as $entry) {
//             if ($entry->confident) {
//                 $categories[] = sprintf("(%s) %s", $entry->id, $entry->label);
//             }
//         }            

//         $formatted_categories = implode("\n", $categories);
//         print "{$target_website} => {$formatted_categories}";
//         break;
//     case 202:
//         // The request is being categorized right now in real time, check again for an updated answer
//         print "{$target_website} => uncategorized";
//         break;
//     default:
//         // The different status codes are covered in the documentation:
//         // https://docs.webshrinker.com/v3/website-category-api.html
//         print "An error occurred: HTTP {$status_code}\n";
//         if (isset($result->error)) {
//             $error = $result->error->message;
//             print "{$error}\n";
//         }
//         break;
// }

Route::get('/', 'PagesController@showHomePage');