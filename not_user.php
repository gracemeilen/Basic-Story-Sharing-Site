<!DOCTYPE HTML>
    <html>
        <head>
             <title> Here are our stories! </title>
             <link rel="stylesheet" type="text/css" href="news.css">
        </head>
        <body>
            <div id="header">
                <h1> Meilen-Hilerio News Sharing Center</h1>
            </div>
            <?php
                require 'database.php';
                
                // Select all the stories that are stored in the table 
                $stmt = $mysqli->prepare("select story_id, story, link from stories");
                if(!$stmt){
                    echo "Query Prep Failed: %s\n";
                    exit;
                }
 
 
                $stmt->execute();

                $stmt->bind_result($story_id, $story, $link);
                
                echo "These are all the stories that we have in our database!"; 
                echo "<ul>\n";
                // display all the stories in the table, with their link (if applicable)
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
            ?>
        
        
            <!-- view a specific story and the comments associated with it. -->
            <form action="viewstory.php" method="POST">
                <p>
                    <label>Enter the ID associated with the story you want to view: </label> <input name="view_story_id" type="text"/>
                </p>
                <p>
                    <input type="submit" value="View Story" />
                </p>
            </form>
        </body>
    </html>