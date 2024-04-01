<?php
session_start();
?>



<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Homepage</title>
  <link rel="stylesheet" href="homepage.css" type="text/css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>

<body >
  <header>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
      <a href="#" class="navbar-brand"> <img src="images/logo.png" alt=""> </a>
      <span class="navbar-text">CINEMATICA</span>

      <ul class="navbar-nav">
        <li class="nav-item active"> <a href="homepage.php" class="nav-link">Home</a> </li>
        <?php
        if (isset($_SESSION['id'])) {
          if ($_SESSION['id'] == 1) {
            echo "<li class='nav-item'> <a href='admin.php' class='nav-link'>Add movie</a> </li>";
          }
        }
        echo "<li class='nav-item'> <a href='account.php' class='nav-link'>Account</a> </li>
          <li class='nav-item'> <a href='payment.php' class='nav-link'>Subscription</a> </li>
          <li class='nav-item'> <a href='logout.php' class='nav-link'>Logout</a> </li>
        </ul>
      </nav>
      <div class='container-fluid'>
        <br><br><br>";
      include 'dbh.php';
      $id = $_SESSION['id'];
      $quer = "SELECT * FROM user1 WHERE id = '$id' ";
      $quer2 = "SELECT * FROM movies WHERE mid in (SELECT mid from user1 where id = '$id') ";
      $check = mysqli_query($conn, $quer);
      $rel = mysqli_fetch_assoc($check);
      $check2 = mysqli_query($conn, $quer2);
      $rel2 = mysqli_fetch_assoc($check2);

      echo "<h1 style='color:white;position:sticky; '>WELCOME </h1><b style = 'color: white;font-size: 25px'><i> " . ucwords($rel['name']) . " !</i></b>
        </div>
        </header>
        <section>


      <div class='jumbotron' style='margin-top:15px;padding-top:30px;padding-bottom:30px; background-color: #000;'>
      <div class='row'>
        <div class='col'>
          <form action='movie.php' method='POST'>
          <h4 style='color:black;font-size:30px; color:white'>Recent :
          <input type='submit' name='submit' class='btn btn-success' style='display:inline;width:200px;margin-left:20px;margin-right:20px;' value='" . ucwords($rel2['name']) . "'/></h4>
          </form>
        </div>
        <div class='col'>
          <form action='search.php' method='POST'>
            <select  name='option' style='padding:5px;'>
              <option selected>Search By</option>
              <option value='name'>Name</option>
              <option value='genre'>Genre</option>
              <option value='rdate'>Release year</option>
              <option value='lang'>Language</option>
            </select>
            <input type='text' placeholder='Enter..' style='margin-left:10px;margin-top:10px;padding:5px;' name='textoption'>

            <input type='submit' name='submit' class='btn btn-success' style='display:inline;width:100px;margin-left:20px;margin-right:20px;margin-top:5px;' value='Search'/></h4>
          </form>
        </div>
      </div>
      </div>";
    ?>
    <div class="jumbotron" style = "background-color:#000">
      <h2 style='margin-top:0px;padding-top:0px; color:white'>Latest updated</h2>
      <div class="row">
        <?php
        include 'latest-fetcher.php';
        ?>
      </div> 
    </div>
    <div class="jumbotron"  style = "background-color:#000">
      <h2 style = "color:white"> All movies</h2>

      <?php
      include 'fetcher.php';
      ?>
    </div>




    <div class="jumbotron" style="background-color:black">
    <h2 style="color:white;">Recommended Movies</h2>
    <div class="row">
    <?php
    // Get user's most watched genre from history
    $genre_query = "SELECT m.genre 
                    FROM history h
                    INNER JOIN movies m ON h.movie_id = m.mid
                    WHERE h.user_id = '$id'
                    GROUP BY m.genre
                    ORDER BY COUNT(*) DESC
                    LIMIT 1";
    $genre_result = mysqli_query($conn, $genre_query);

    if ($genre_result && mysqli_num_rows($genre_result) > 0) {
        $genre_row = mysqli_fetch_assoc($genre_result);
        $most_watched_genre = $genre_row['genre'];

        // Fetch recommended movies from the most watched genre that the user hasn't watched yet
        $recommendation_query = "SELECT * 
                                 FROM movies 
                                 WHERE genre = '$most_watched_genre' 
                                 AND mid NOT IN (SELECT movie_id FROM history WHERE user_id = '$id')
                                 ORDER BY viewers DESC
                                 LIMIT 3";
        $recommendation_result = mysqli_query($conn, $recommendation_query);

        if ($recommendation_result && mysqli_num_rows($recommendation_result) > 0) {
            while ($row = mysqli_fetch_assoc($recommendation_result)) {
                echo "<div class='col'>";
                echo "<form action='movie.php' method='POST'>";
                echo "<img src='uploads/" . $row['imgpath'] . "' height='250' width='200' style='margin-top: 30px;margin-left:50px;margin-right:20px;' />";
                echo "<div class='noob'>";
                echo "<input type='hidden' name='submit' value='" . $row['name'] . "' />";
                echo "<button type='submit' class='btn btn-outline-info' style='display:block;width:200px;padding-bottom:15px;margin-bottom:30px;margin-left:50px;margin-right:20px;'>" . ucwords($row['name']) . "</button>";
                echo "</div>";
                echo "</form>";
                echo "</div>";
            }
        } else {
            echo "<p>No recommended movies available.</p>";
        }
    } else {
        echo "<p>No viewing history found for the user.</p>";
    }
    ?>
</div>

</div>

    
    </section>
    <footer class="page-footer font-small blue">

      <div class="footer-copyright text-center py-3">© 2024 Copyright:
        <a href="">sonali82990@gmail.com</a><br>
        <a href="">prajna@gmail.com</a><br>
        <a href="">anshah@gmail.com</a><br>
      </div>

    </footer>
</body>

</html>
