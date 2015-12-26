<!DOCTYPE HTML>
    <html>
        <head>
            <title>Your Stories</title>
            <link rel="stylesheet" type="text/css" href="news.css">
        </head>
        <body>
            <div id="header">
                <h1> Meilen-Hilerio News Sharing Center</h1>
            </div>
            <?php
                require 'database.php';
                session_start();
                $username = (string)$_SESSION['user_id'];
                
                //
                // select all the stories associated with the current user
                //
                $stmt = $mysqli->prepare("select story_id, story, link from stories where user=?");
                if(!$stmt){
                    echo "Query Prep Failed: %s\n";
                    exit;
                }
 
                $stmt->bind_param('s', $username);
 
                $stmt->execute();

                $stmt->bind_result($story_id, $story, $link);
                
                echo "Here are all the stories that you have stored with us. "; 
                echo "<ul>\n";
                
                //
                //display all the stories associated with current user
                //
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
        
        
        <!-- allows you to submit a new story that will be associated with your name -->
         <form action="poststory.php" method="POST">
                <p>
                    <label>Enter a story you would like to be posted: </label> <input name="story" type="text"/>
                </p>
                <p>
                    <label>If you would like a link associated with this story, enter it here: </label> <input name="link" type="text"/>
                </p>
                <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
                <p>
                    <input type="submit" value="Post Story" />
                </p>
            </form>
         
            <!-- allows you to delete a  story associated with your name -->
            <form action="deletestory.php" method="POST">
                <p>
                    <label>Enter the ID associated with the story you want to delete: </label> <input name="delete_story_id" type="text"/>
                </p>
                <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
                <p>
                    <input type="submit" value="Delete Story" />
                </p>
            </form>
            
            
            <!-- allows you to update a  story associated with your name -->
            <form action="updatestory.php" method="POST">
                <p>
                    <label>Enter the ID associated with the story you want to update: </label> <input name="update_story_id" type="text"/>
                </p>
                <p>
                    <label>What would you like the story to say now?: </label> <input name="update_story" type="text"/>
                </p>
                <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
                <p>
                    <input type="submit" value="Update Story" />
                </p>
            </form>
        
            <!--Logout out of the current user -->            
            <form action= "logout_stories.php">
                <input type="submit" value="Log Out?">
            </form>
            
            <!-- destroy the current account -->
            <form action= "destroy_account.php" method="POST">
                <p>
                    <label>Would you like to destroy your account? WARNING your stories/comments will remain visibile to our users, and you will not be able to recover your account.</label>
                </p>
                <p>
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />   
                </p>
                <p>
                <input type="submit" value="Destroy Account">
                </p>
            </form>
            
            <!-- View all the stories that exist in the database --> 
            <form action= "all_stories.php" method="POST">
                <input type="submit" value="View All the Stories We have">
            </form>

        </body>
    </html>
