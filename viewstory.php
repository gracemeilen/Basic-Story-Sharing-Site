<!DOCTYPE HTML>
    <html>
        <head>
            <title> Stories </title>
            <link rel="stylesheet" type="text/css" href="news.css">	
        </head>
        <body>
            <div id="header">
                <h1> Meilen-Hilerio News Sharing Center</h1>
            </div>

<?php         
    
require 'database.php';

session_start();
$story_id = (string)$_POST['view_story_id'];

//A query that retrieves the story id, story and link associated with a given story id 
$stmt = $mysqli->prepare("select story_id, story, link from stories where story_id=?");
if(!$stmt){
    echo "Query Prep Failed: %s\n";
    exit;
}

$stmt->bind_param('s', $story_id);

$stmt->execute();

$stmt->bind_result($story_id, $story, $link);

echo "This is the story you chose to view"; 
echo "<ul>\n";

// displays the story with a link (if there is one associated with it) or without
while($stmt->fetch()){
    if ($link == null){
        printf( "\t<li>Story ID: %s. The story associated is:   %s</li>\n",
        htmlspecialchars($story_id),
        htmlspecialchars($story)
        );
    } else {
        printf( "\t<li>Story ID: %s. The story associated is:   %s.    <a href=%s>Link</a></li>\n",
        htmlspecialchars($story_id),
        htmlspecialchars($story),
        htmlspecialchars($link)
        );
    }
}
echo "</ul>\n";

$stmt->close();


// A query to select all the comments associated with a given story and display them along with the username who posted the comment. 
$cmt = $mysqli->prepare("select comment from comments where on_story=?");
$cmt->bind_param('i', $story_id);
if(!$cmt){
    echo "Query Prep Failed: %s\n";
    exit;
}


$cmt->execute();

$cmt->bind_result($comment);

echo "These are all the comments associated with that story"; 
echo "<ul>\n";
// Display the comments
while($cmt->fetch()){
    printf( "\t<li>%s</li>\n",
    htmlspecialchars($comment)
    );

}
echo "</ul>\n";
$cmt->close();

?>

<!-- Takes you back to the list of all stories.  -->
<form action= "not_user.php">
  <input id="button" type="submit" value="Back to the list of stories?">
</form>
        </body>
    </html>