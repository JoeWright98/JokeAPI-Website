<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Joke Tasks</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
            <div class="content">
                <div class="title m-b-md">
                    Joke Tasks
                </div>

              </body>


    <?php

       if (array_key_exists('randoChuck', $_GET)) {//If the random chuck norris button is clicked call the random chuck method
           getRandomChuck();
       } elseif (array_key_exists('amountChuck', $_GET)) {//If the certain number of chuck norris button is clicked call the amount of chuck  jokes method
           getAmountChuck();
       } elseif (array_key_exists('randoJoke', $_GET)) {//If the random  button is clicked call the random  method
           getRando();
       } elseif (array_key_exists('randoJoke10', $_GET)) {//If the random 10 button is clicked call the random 10 method
           getRandoTen();
       } elseif (array_key_exists('catorJoke', $_GET)) {//If the random category  button is clicked call the random catergory method
           getCaterJoke();
       } elseif (array_key_exists('catorJoke10', $_GET)) {//If the random category 10 button is clicked call the random catergory 10 method
           getTenCaterJoke();
       } elseif (array_key_exists('svjoke', $_GET)) {
           getSvJoke();
       }


       function getRandomChuck()
       {//Method that retrieves JSON data from url, decodes the JSON and then echos the joke section of the object
           $jsondata = file_get_contents('http://api.icndb.com/jokes/random');
           $json= json_decode($jsondata);
           echo $json->value->joke;
       }
       function getAmountChuck()
       {//Method that retrieves the variable $amount from the text box, checks whether it is in the right ranged, then decodes the JSON and echos the amount of jokes
           $amount = $_GET["amountJokes"];
           if ($amount >= 1 && $amount <= 20) {
               $jsondata = file_get_contents("http://api.icndb.com/jokes/random/$amount");
               $json = json_decode($jsondata);

               foreach ($json->value as $joke) {//For each loop to iterate through the array of jokes
                   echo $joke->joke;
                   echo "<br>";
               }
           } else {//Error message to alert the user what they need to input
               echo "Please enter a number between 1 and 20";
           }
       }
         function getRando()
         {//Method that retrives the JSON from the URL , decodes the JSON then echos the setupline then the punchline in a readable manner
             $jsondata = file_get_contents('https://official-joke-api.appspot.com/random_joke');
             $json= json_decode($jsondata);
             echo $json->setup;
             echo "<br>";
             echo $json->punchline;
         }
         function getRandoTen()
         {//Method that retrives the JSON from the URL, decodes the json and loops through the array of ten jokes to print each one
             $jsondata = file_get_contents('https://official-joke-api.appspot.com/random_ten');
             $json= json_decode($jsondata);
             foreach ($json as $joke) {
                 echo $joke->setup;
                 echo "<br>";
                 echo "Punchline: $joke->punchline";
                 echo "<br>";
             }
         }
         function getCaterJoke()
         {//Method that retrieves catergory from the drop down, retrieves JSON from URL, decodes the JSON, retrieves a random joke from a chosen catergory by the user (Note: For some reason this returns a JSON array even though its only one joke so have to loop through it)
             $catergory = $_GET["categories"];
             $jsondata = file_get_contents("https://official-joke-api.appspot.com/jokes/$catergory/random");
             $json= json_decode($jsondata);
             foreach ($json as $joke) {
                 echo $joke->setup;
                 echo "<br>";
                 echo  $joke->punchline;
             }
         }
         function getTenCaterJoke()
         {//Method that retrieves catergory from the drop down, retrieves the json, decodes it and loops through the array and prints out each joke
             $catergory = $_GET["categories"];
             $jsondata = file_get_contents("https://official-joke-api.appspot.com/jokes/$catergory/ten");
             $json= json_decode($jsondata);
             foreach ($json as $joke) {
                 echo $joke->setup;
                 echo "<br>";
                 echo "Punchline: $joke->punchline";
                 echo "<br>";
             }
         }
         function getSvJoke()
         {//Get Svjoke api - loops through the checkbox list (well suppose to) retrieve what catergories have been chosen, put them in the url, decode and print the joke
             $count = 1;
             if (isset($_GET['svjoke'])) {
                 if (!empty($_GET['catlist'])) {
                     $checked_count = count($_GET['catlist']);

                     // Loop to store and display values of individual checked checkbox.
                     foreach ($_GET['catlist'] as $value) {
                         $x = 'value'.$count;
                         $$x = $value;
                         $count++;
                     }
                     if ($checked_count = 3) {
                         $jsondata = file_get_contents("https://sv443.net/jokeapi/v2/joke/$value1,$value2,$value3");
                         $json = json_decode($jsondata);
                         echo $json->setup;
                         echo "<br>";
                         echo $json->delivery;
                     } elseif ($checked_count = 2) {
                         $jsondata = file_get_contents("https://sv443.net/jokeapi/v2/joke/$value1,$value2");
                         $json = json_decode($jsondata);
                         echo $json->setup;
                         echo "<br>";
                         echo $json->delivery;
                     } elseif ($checked_count = 1) {
                         $jsondata = file_get_contents("https://sv443.net/jokeapi/v2/joke/$value1");
                         $json = json_decode($jsondata);
                         echo $json->setup;
                         echo "<br>";
                         echo $json->delivery;
                     }
                 } else {
                     $jsondata = file_get_contents("https://sv443.net/jokeapi/v2/joke/Any");
                     $json = json_decode($jsondata);
                     echo $json->setup;
                     echo "<br>";
                     echo $json->delivery;
                 }
             }
         }






       ?>

<!--Start of my html form code-->
       <form method="get">

          <br>
         <label>Chuck Norris API section</label>
          <br>
         <input type="submit" name="randoChuck"
                class="button" value="Get Random Chuck Joke!" />
          </br>
          </br>
      <input type="submit" name="amountChuck"class="button" value="Get the amount of Chuck jokes you asked for!" />
      <input type="text" id="fname" name="amountJokes" placeholder="How many jokes?"/>
          </br>
          </br>

      <label>Random Joke API section</label>
          <br>
      <input type="submit" name="randoJoke"class="button" value="Get a random joke!" />
          </br>
          </br>
      <input type="submit" name="randoJoke10"class="button" value="Get 10 random jokes!" />
          </br>
          </br>
      <label for="jokes">Choose a category:</label>
      <select id="categories" name="categories">
        <option value="general" name="generalJoke">General</option>
        <option value="programming" name="programmingJoke">Programming</option>
      </select>
      <input type="submit" name="catorJoke" value="Get your joke!">
      <input type="submit"  name="catorJoke10" value="Get 10 of your jokes!">
          </br>
      <label for="jokeapi">Sv443 Api Section</label>
          <div class="multiselect noselect" id="categoryWrapper" style="border-color: initial;"><label for ="categoryWrapper">Choose a catergory</label>
            <div>
            <input type="radio" name="catSelect" value="any" id="cat-radio1"><label for="cat-radio1">Any</label>
            </div>
            <div>
            <input type="radio" name="catSelect" value="multi" id="cat-radio2"><label for="cat-radio2">Custom:</label>

            <span id="catSelectMulti">
            <input type="checkbox" id="cat-cb1" onchange="" name="catlist[]" value="programming"><label for="cat-cb1">Programming</label>
            <input type="checkbox" id="cat-cb2" onchange="" name="catlist[]" value="miscellaneous"><label for="cat-cb2">Miscellaneous</label>
            <input type="checkbox" id="cat-cb3" onchange="" name="catlist[]"value="dark"><label for="cat-cb3">Dark</label>
            </span>
            <script>
            var customcheck = document.getElementById('cat-radio2');
            var anycheck = document.getElementById('cat-radio1');
            var programmingcheck = document.getElementById('cat-cb1');
            var misccheck = document.getElementById('cat-cb2');
            var darkcheck = document.getElementById('cat-cb3');
            anycheck.onchange = function() {
              programmingcheck.disabled = !!this.checked;
              misccheck.disabled = !!this.checked;
              darkcheck.disabled = !!this.checked;
            };
            customcheck.onchange = function(){
              programmingcheck.disabled = !this.checked;
              misccheck.disabled = !this.checked;
              darkcheck.disabled = !this.checked;

            }
            </script>
            <br>
            <input type="submit" name="svjoke" class="button" value="Get a SV joke!" />
        </div>
      </div>
  </td>








   </form>







    </body>
</html>
