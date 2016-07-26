<?php
include 'database_con.php';
session_start();
?>
<html>
  <head>
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
          crossorigin="anonymous"/>

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css"
          rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1"
          crossorigin="anonymous">

    <link rel = 'stylesheet' href = './css/see_reviews.css'/>

    <meta charset ='utf-8'/>
    <title>GTtravel</title>
  </head>
  <body>
    <nav class = 'navbar navbar-light navbar-fixed-top'>
        <div id = "spy-scroll-id" class = 'container'>
          <ul class="nav navbar-nav navbar-right">
            <li class = 'active'><a href="home.php"><i class="fa fa-home"></i>Home</a></li>
            <li><a href = "login.php"><i class ="fa fa-user"></i>Logout</a></li>
          </ul>
          <a href = '#' class = "pull-left navbar-left"><img id = "logo" src = "./images/LogoMakr.png"></a>
        </div>
    </nav>
    <div class="container text-center">
      <div class='jumbotron'>
        <h2><center>See All Reviews</center></h2>
          <?php
            error_reporting(E_ALL);
            ini_set("display_errors", 1);
            $con = mysqli_connect($db_host, $db_user, $db_password, $db_database) or die("Connection Failed");
            if(isset($_SESSION['user'])) {
                  $user = $_SESSION['user'];
                  $sql = "SELECT Review.RSubject, Review.RDate, Review.Score, Review.Description, Review.ReviewableID
                    FROM Review
                  WHERE Review.Username = \"$user\";";
                  $result = mysqli_query($con, $sql);
                  if(mysqli_num_rows($result) > 0) {
                      $_SESSION['user_reviews'] = $result;
                      //echo "<script>window.location.href='country_search_results.php'</script>";
                      echo "<table class= \"tbale table-striped\" border=\"1\">";
                      echo "<tr>";
                      echo "<th>Subject</th><th>Date</th><th>Score</th><th>Critic Level</th><th>Description</th>";
                      echo "</tr>";
                      while($val = mysqli_fetch_array($result)) {
                          $sql2 = "SELECT AVG(Score) as AvgScore FROM Review WHERE Review.ReviewableID = $val[4]";
                          $result2 = mysqli_query($con, $sql2);
                          $my_array=mysqli_fetch_assoc($result2);
                          $avgrev=$my_array['AvgScore'];
                          if ($avgrev == $val[2]){
                            $harshness = "Average";
                          } else if ($avgrev > $val[2]){
                            $harshness = "Harsh";
                          } else {
                            $harshness = "Easy";
                          }
                          echo "<tr>";
                          echo "<td><a href = \"update_review.php?a=$val[4]\">" . $val[0] . "</td>";
                          echo "<td>" . $val[1] . "</td>";
                          echo "<td>" . $val[2] . "</td>";
                          echo "<td>" . $harshness . "</td>";
                          echo "<td>" . $val[3] . "</td>";
                          echo "</tr>";
                      }
                      echo "</table>";
                  } else {
                      echo "You have not written any reviews";
                  }
              }
             ?>
      </div>
    </div>

  </body>
</html>
