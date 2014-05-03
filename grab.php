<?php
/*====== Hack for storing all friends image in server ========
 *
 * @author Siv.S
 * @time  20th October 2013, at 2:30 pm
 *
 * @about
 * " Uses the graph search method to get all
 * the facebook friends image in folders "
 * 
 ****************************************************************/



# to override the 30 second php limit
set_time_limit(0);

#file_get_contents_curl($url)
/* 
 * @about "function tho fetch a file from url"
 * @parms $url the url of file 
 * 
 * @returns the file from the remote server
*/
function file_get_contents_curl($url) {
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
    curl_setopt($ch, CURLOPT_URL, $url);
    
    $data = curl_exec($ch);
    curl_close($ch);
    
    return $data;
}

#fetch the user from the json file
$users = json_decode(file_get_contents('friends.json'), true);


#loop till the user count
for($i =0 ; $i< count($users['id']) ;$i++){
    
	#fetching the file form the graph method
    $what_ever = file_get_contents_curl('http://graph.facebook.com/'.$users['id'][$i].'?fields=id,name,picture.width(550),cover');

    #decoding the json
    $data = json_decode($what_ever, true);

    #saving the picture img in pic folder
    $content = file_get_contents($data['picture']['data']['url']);
    file_put_contents('images/pic/'.$data['name'].'.jpg',  $content);

    #saving the cover img in cover folder
    $content = file_get_contents($data['cover']['source']);
    file_put_contents('images/cover/'.$data['name'].'.jpg',  $content);

}


echo "saved!";

?>