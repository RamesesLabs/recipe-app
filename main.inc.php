<h2 align="center">The Latest Recipes</h2><br>
<?php

$con = mysqli_connect("localhost", "root", "password", "recipe") or die('Sorry, could not connect to database server');

$query = "SELECT recipeid,title,poster,shortdesc, ingredients, directions from recipes order by recipeid desc limit 0,5";
$result = mysqli_query($con, $query) or die('Sorry, could not get recipes at this time ');

if (mysqli_num_rows($result) == 0)
{
   echo "<h3>Sorry, there are no recipes posted at this time, please try back later.</h3>";
} else
{
   while($row=mysqli_fetch_array($result, MYSQLI_ASSOC))
   {
      $recipeid = $row['recipeid'];
      $title = $row['title'];
      $poster = $row['poster'];
      $shortdesc = $row['shortdesc'];       
      $ingredients = $row['ingredients'];
      $directions = $row['directions'];

      $ingredients = nl2br($ingredients);
      $directions = nl2br($directions);

   echo "<h2>$title</h2>\n";

   echo "by $poster <br><br>\n";
   echo "$shortdesc<br><br>\n";
   echo "<h3>Ingredients:</h3>\n";
   echo "$ingredients<br><br>\n";

   echo "<h3>Directions:</h3>\n";
   echo "$directions";
   echo "<br><br>\n";
   
   $query = "SELECT count(commentid) from comments where recipeid = $recipeid";
   $result = mysqli_query($con, $query);
   $row=mysqli_fetch_array($result, MYSQLI_ASSOC);
   if  (mysqli_num_rows($result) == 0)
   {
      echo "No comments posted yet.&nbsp;&nbsp;\n";
      echo "<a href=\"index.php?content=newcomment&id=$recipeid\">Add a comment</a>\n";
      echo "&nbsp;&nbsp;&nbsp;<a href=\"print.php?id=$recipeid\" target=\"_blank\">Print recipe</a>\n";
      echo "<hr>\n";
   } else
   {
      echo $row[0] . "\n";
      echo "&nbsp;comments posted.&nbsp;&nbsp;\n";
      echo "<a href=\"index.php?content=newcomment&id=$recipeid\">Add a comment</a>\n";
      echo "&nbsp;&nbsp;&nbsp;<a href=\"print.php?id=$recipeid\" target=\"_blank\">Print recipe</a>\n";
      echo "<hr>\n";
      echo "<h2>Comments:</h2>\n";

      $query = "SELECT date,poster,comment from comments where recipeid = $recipeid order by commentid desc";

      $result = mysqli_query($con, $query) or die('Could not retrieve comments');
      while($row=mysqli_fetch_array($result, MYSQLI_ASSOC))
      {
         $date = $row['date'];
         $poster = $row['poster'];
         $comment = $row['comment'];
         $comment = nl2br($comment);

         echo "$date  - posted by  $poster<br>\n";
         echo "$comment\n";
         echo "<br><br>\n";
      }
   }
   }
}
?>