<?php 


$test = "python3 recomend.py '";
$film_name = $_GET['film']; #, $_GET["film"]
if (isset($_GET['film']))
{
$test .= $film_name;
$test .= "'";
$is_debug = 0;
#var_dump($test);
$command = escapeshellcmd($test);
if($is_debug==0)
{
	$output = shell_exec($command);
}
else
{
	$output = "IMDB::The Lord of the Rings: The Return of the King::The Lord of the Rings: The Fellowship of the Ring::Tangled::Underclassman::I Am Sam::Brothers::Steamboy::Krull::Transformers::Small Apartments::TMDB::The Lord of the Rings: The Two Towers::The Lord of the Rings: The Fellowship of the Ring::The Hobbit: The Desolation of Smaug::The Hobbit: The Battle of the Five Armies::The Hobbit: An Unexpected Journey::Warcraft::The Last Witch Hunter::The Mummy: Tomb of the Dragon Emperor::The Monkey King 2::The Sorcerer's Apprentice";
}
//$ro = preg_replace('/\s+/', ' ', $output);
$output1 = explode("::", $output);
//var_dump($output1);
$output2;
$counter = 0;
$counter_2 = 0;


//echo '<pre>' , var_dump($output1) , '</pre>';

for ($i=0;$i<count($output1);$i++)
{
	if (preg_match('/\bIMDB\b/', $output1[$i]) || preg_match('/\bTMDB\b/', $output1[$i]))
	{
		
		$counter = $output1[$i];
		
	}
	else
	{
		if (preg_match('/\bobject\b/', $output1[$i]))
	{

			unset($output1[$i]);

	}
	else
	{
		
		$output2[$counter][$counter_2] =  $output1[$i];
		$counter_2++;
	
	}
	
	}
	//var_dump($output1[$i]);
	
}
//echo '<pre>' , var_dump($output2) , '</pre>';








    
function array2table($array, $recursive = false, $null = '&nbsp;')
{
    // Sanity check
    if (empty($array) || !is_array($array)) {
        return false;
    }
    if (!isset($array[0]) || !is_array($array[0])) {
        $array = array($array);
    }
    // Start the table
    $table = "<table>\n";
    // The header
    $table .= "\t<tr>";
    // Take the keys from the first row as the headings
    foreach (array_keys($array[0]) as $heading) {
        $table .= '<th>' . $heading . '</th>';
    }
    $table .= "</tr>\n";
    // The body
    foreach ($array as $row) {
        $table .= "\t<tr>";
        foreach ($row as $cell) {
            $table .= '<td>';
            // Cast objects
            if (is_object($cell)) {
                $cell = (array) $cell;
            }
            if ($recursive === true && is_array($cell) && !empty($cell)) {
                // Recursive mode
                $table .= "\n" . array2table($cell, true, true) . "\n";
            } else {
                $table .= strlen($cell) > 0 ? htmlspecialchars((string) $cell) : $null;
            }
            $table .= '</td>';
        }
        $table .= "</tr>\n";
    }
    $table .= '</table>';
    return $table;
}


//foreach ($output2 as $mark){
//    echo "<tr><td class=\"bg0\">".$mark['IMDB']."</td><td class=\"bg0\">".$mark['TMDB']."</td></tr>";
//}

#echo array2table($output2);


//body {
//    background-image: url(bg.jpg);
//       }
	   
echo "<html>


<head>

 <meta charset=\"UTF-8\"/>
<link rel=\"stylesheet\" type=\"text/css\" rel=\"noopener\" target=\"_blank\" href=\"main.css\">

<style>
body { 
    background-image: url(bg.jpg);
       }
 
  </style>
</head><style>table, th, td {
  border: 1px solid;
}
td.bg0 {
  background-color:rgb(209 138 19 / 33%);
  
}
th.bg0 {
  background-color:rgb(56 47 98 / 71%);
  
}
</style><form action=><fieldset>
        <legend>Результаты подбора для фильма {$film_name}</legend>
        <div class=\"form-control\"><table>";
$counter_column=0;
$counter_column_1=0;
echo "<tr>";
foreach ($output2 as $key => $value) {
	if ($counter_column_1=0)
		{
			$counter_column_1++;
			echo "<tr>";
		}
		else
		{
			$counter_column_1=0;
		}
	echo "<th class=\"bg0\">$key</th>";
	if(preg_match('/\bTMDB\b/', $key))
	{
		echo "</tr>";
	}
   
}


$top20_films = array_merge($output2['IMDB'],$output2['TMDB']);
//var_dump($testastasd);
for ($i=0;$i<count($top20_films)/2;$i++)
{
	
		echo "<tr>";
		
	if (array_count_values($output1)[$top20_films[$i]]>1)
	{
		echo "<td class=\"bg0\">$top20_films[$i]</td>"; // Get value.
		if (array_count_values($output1)[$top20_films[$i+5]]>1)
		{
			$curr = $top20_films[$i+5];
		echo "<td class=\"bg0\">$curr</td>"; // Get value.
		}
		else
		{
			$curr = $top20_films[$i+5];
			echo "<td>$curr</td>"; // Get value.
		}
	}
	else
	{
		echo "<td>$top20_films[$i]</td>"; // Get value.
		if (array_count_values($output1)[$top20_films[$i+5]]>1)
		{
			$curr = $top20_films[$i+5];
			echo "<td class=\"bg0\">$curr</td>"; // Get value.
		}
		else
		{
			$curr = $top20_films[$i+5];
			echo "<td>$curr</td>"; // Get value.
		}
	}
	echo "</tr>";
}
	
//foreach ($output2 as $key => $value) {
//	
//    for ($i=0;$i<$value;$i++)  {
//        
//			echo "<tr>";
//		
//		
//		
//        if (array_count_values($output1)[$value[$i]]>1)
//		{
//			 echo "<td class=\"bg0\">$v</td>"; // Get value.
//		}
//		else
//		{
//			 echo "<td>$v</td>"; // Get value.
//		}
//		if ($counter_column=0)
//		{
//			$counter_column++;
//			
//		}
//		else
//		{
//			$counter_column=0;
//			
//			echo "</tr>";
//		}
//        
//    }
//}



echo "</table><p><a href=\"index.php\">Назад</a></p></form>";




}
else
{
	echo "
	<html>


<head>

 <meta charset=\"UTF-8\">
<link rel=\"stylesheet\" type=\"text/css\" rel=\"noopener\" target=\"_blank\" href=\"main.css\">
<script type=\"text/javascript\">
    function disableButton(btn) {
        document.getElementById(btn.id).disabled = true;
        alert(\"Button has been disabled.\");
    }
</script>
<style>
   body {
    background-image: url(bg.jpg);
       }
  </style>
</head>



<body>
<form id=\"test\" action=index.php>
      <fieldset>
        <legend>Подбор фильма</legend>
        <div class=\"form-control\">
          <label for=\"name\">Название фильма</label>
          <select class=\"js-select2\" name=\"film\" placeholder=\"Выберите фильм\">
<option value=\"\"></option>

<option value=\"The Shawshank Redemption\" >The Shawshank Redemption</option>
<option value=\"Fight Club\" >Fight Club</option>
<option value=\"The Dark Knight\" >The Dark Knight</option>
<option value=\"Pulp Fiction\" >Pulp Fiction</option>
<option value=\"Inception\" >Inception</option>
<option value=\"The Godfather\" >The Godfather</option>
<option value=\"Interstellar\" >Interstellar</option>
<option value=\"Forrest Gump\" >Forrest Gump</option>
<option value=\"The Lord of the Rings: The Return of the King\" >The Lord of the Rings: The Return of the King</option>
<option value=\"The Empire Strikes Back\" >The Empire Strikes Back</option>
<option value=\"The Lord of the Rings: The Fellowship of the Ring\" >The Lord of the Rings: The Fellowship of the Ring</option>
<option value=\"Star Wars\" >Star Wars</option>
<option value=\"Schindler's List\" >Schindler's List</option>
<option value=\"Whiplash\" >Whiplash</option>
<option value=\"The Lord of the Rings: The Two Towers\" >The Lord of the Rings: The Two Towers</option>
<option value=\"Se7en\" >Se7en</option>
<option value=\"Guardians of the Galaxy\" >Guardians of the Galaxy</option>
<option value=\"The Matrix\" >The Matrix</option>
<option value=\"Spirited Away\" >Spirited Away</option>
<option value=\"Inside Out\" >Inside Out</option>
<option value=\"Back to the Future\" >Back to the Future</option>
<option value=\"The Green Mile\" >The Green Mile</option>
<option value=\"Django Unchained\" >Django Unchained</option>
<option value=\"The Imitation Game\" >The Imitation Game</option>
<option value=\"The Godfather: Part II\" >The Godfather: Part II</option>
<option value=\"The Lion King\" >The Lion King</option>
<option value=\"The Silence of the Lambs\" >The Silence of the Lambs</option>
<option value=\"The Wolf of Wall Street\" >The Wolf of Wall Street</option>
<option value=\"Inglourious Basterds\" >Inglourious Basterds</option>
<option value=\"Memento\" >Memento</option>
<option value=\"Gone Girl\" >Gone Girl</option>
<option value=\"The Grand Budapest Hotel\" >The Grand Budapest Hotel</option>
<option value=\"Gladiator\" >Gladiator</option>
<option value=\"The Shining\" >The Shining</option>
<option value=\"The Prestige\" >The Prestige</option>
<option value=\"GoodFellas\" >GoodFellas</option>
<option value=\"Saving Private Ryan\" >Saving Private Ryan</option>
<option value=\"Shutter Island\" >Shutter Island</option>
<option value=\"WALL·E\" >WALL·E</option>
<option value=\"Big Hero 6\" >Big Hero 6</option>
<option value=\"American History X\" >American History X</option>
<option value=\"Return of the Jedi\" >Return of the Jedi</option>
<option value=\"One Flew Over the Cuckoo's Nest\" >One Flew Over the Cuckoo's Nest</option>
<option value=\"The Usual Suspects\" >The Usual Suspects</option>
<option value=\"Alien\" >Alien</option>
<option value=\"Reservoir Dogs\" >Reservoir Dogs</option>
<option value=\"The Departed\" >The Departed</option>
<option value=\"Up\" >Up</option>
<option value=\"The Dark Knight Rises\" >The Dark Knight Rises</option>
<option value=\"Her\" >Her</option>
<option value=\"Harry Potter and the Prisoner of Azkaban\" >Harry Potter and the Prisoner of Azkaban</option>
<option value=\"The Truman Show\" >The Truman Show</option>
<option value=\"12 Years a Slave\" >12 Years a Slave</option>
<option value=\"Room\" >Room</option>
<option value=\"The Martian\" >The Martian</option>
<option value=\"Eternal Sunshine of the Spotless Mind\" >Eternal Sunshine of the Spotless Mind</option>
<option value=\"Dead Poets Society\" >Dead Poets Society</option>
<option value=\"Toy Story\" >Toy Story</option>
<option value=\"Blade Runner\" >Blade Runner</option>
<option value=\"Psycho\" >Psycho</option>
<option value=\"Scarface\" >Scarface</option>
<option value=\"Kill Bill: Vol. 1\" >Kill Bill: Vol. 1</option>
<option value=\"American Beauty\" >American Beauty</option>
<option value=\"Finding Nemo\" >Finding Nemo</option>
<option value=\"Captain America: The Winter Soldier\" >Captain America: The Winter Soldier</option>
<option value=\"V for Vendetta\" >V for Vendetta</option>
<option value=\"Prisoners\" >Prisoners</option>
<option value=\"Titanic\" >Titanic</option>
<option value=\"The Avengers\" >The Avengers</option>
<option value=\"Batman Begins\" >Batman Begins</option>
<option value=\"2001: A Space Odyssey\" >2001: A Space Odyssey</option>
<option value=\"Deadpool\" >Deadpool</option>
<option value=\"12 Angry Men\" >12 Angry Men</option>
<option value=\"The Good, the Bad and the Ugly\" >The Good, the Bad and the Ugly</option>
<option value=\"Terminator 2: Judgment Day\" >Terminator 2: Judgment Day</option>
<option value=\"Harry Potter and the Philosopher's Stone\" >Harry Potter and the Philosopher's Stone</option>
<option value=\"Pirates of the Caribbean: The Curse of the Black Pearl\" >Pirates of the Caribbean: The Curse of the Black Pearl</option>
<option value=\"Taxi Driver\" >Taxi Driver</option>
<option value=\"Dallas Buyers Club\" >Dallas Buyers Club</option>
<option value=\"The Theory of Everything\" >The Theory of Everything</option>
<option value=\"Amélie\" >Amélie</option>
<option value=\"Howl's Moving Castle\" >Howl's Moving Castle</option>
<option value=\"Edge of Tomorrow\" >Edge of Tomorrow</option>
<option value=\"Princess Mononoke\" >Princess Mononoke</option>
<option value=\"Jurassic Park\" >Jurassic Park</option>
<option value=\"Good Will Hunting\" >Good Will Hunting</option>
<option value=\"Raiders of the Lost Ark\" >Raiders of the Lost Ark</option>
<option value=\"Ex Machina\" >Ex Machina</option>
<option value=\"Catch Me If You Can\" >Catch Me If You Can</option>
<option value=\"Iron Man\" >Iron Man</option>
<option value=\"X-Men: Days of Future Past\" >X-Men: Days of Future Past</option>
<option value=\"Monsters, Inc.\" >Monsters, Inc.</option>
<option value=\"Toy Story 3\" >Toy Story 3</option>
<option value=\"The Hobbit: The Desolation of Smaug\" >The Hobbit: The Desolation of Smaug</option>
<option value=\"Gran Torino\" >Gran Torino</option>
<option value=\"Into the Wild\" >Into the Wild</option>
<option value=\"Harry Potter and the Goblet of Fire\" >Harry Potter and the Goblet of Fire</option>
<option value=\"The Hateful Eight\" >The Hateful Eight</option>
<option value=\"Donnie Darko\" >Donnie Darko</option>
<option value=\"The Big Lebowski\" >The Big Lebowski</option>
<option value=\"Braveheart\" >Braveheart</option>
<option value=\"Requiem for a Dream\" >Requiem for a Dream</option>
<option value=\"Kill Bill: Vol. 2\" >Kill Bill: Vol. 2</option>
<option value=\"Aliens\" >Aliens</option>
<option value=\"The Hunger Games: Catching Fire\" >The Hunger Games: Catching Fire</option>
<option value=\"The Sixth Sense\" >The Sixth Sense</option>
<option value=\"Spotlight\" >Spotlight</option>
<option value=\"The Fault in Our Stars\" >The Fault in Our Stars</option>
<option value=\"Trainspotting\" >Trainspotting</option>
<option value=\"Apocalypse Now\" >Apocalypse Now</option>
<option value=\"The Notebook\" >The Notebook</option>
<option value=\"A Beautiful Mind\" >A Beautiful Mind</option>
<option value=\"No Country for Old Men\" >No Country for Old Men</option>
<option value=\"Harry Potter and the Chamber of Secrets\" >Harry Potter and the Chamber of Secrets</option>
<option value=\"The Perks of Being a Wallflower\" >The Perks of Being a Wallflower</option>
<option value=\"Ratatouille\" >Ratatouille</option>
<option value=\"Snatch\" >Snatch</option>
<option value=\"How to Train Your Dragon\" >How to Train Your Dragon</option>
<option value=\"Oldboy\" >Oldboy</option>
<option value=\"Harry Potter and the Order of the Phoenix\" >Harry Potter and the Order of the Phoenix</option>
<option value=\"Nightcrawler\" >Nightcrawler</option>
<option value=\"Harry Potter and the Half-Blood Prince\" >Harry Potter and the Half-Blood Prince</option>
<option value=\"The Incredibles\" >The Incredibles</option>
<option value=\"Die Hard\" >Die Hard</option>
<option value=\"The Pianist\" >The Pianist</option>
<option value=\"Avatar\" >Avatar</option>
<option value=\"Indiana Jones and the Last Crusade\" >Indiana Jones and the Last Crusade</option>
<option value=\"Avengers: Age of Ultron\" >Avengers: Age of Ultron</option>
<option value=\"How to Train Your Dragon 2\" >How to Train Your Dragon 2</option>
<option value=\"Pan's Labyrinth\" >Pan's Labyrinth</option>
<option value=\"The Revenant\" >The Revenant</option>
<option value=\"Edward Scissorhands\" >Edward Scissorhands</option>
<option value=\"Birdman\" >Birdman</option>
<option value=\"The Pursuit of Happyness\" >The Pursuit of Happyness</option>
<option value=\"Star Trek\" >Star Trek</option>
<option value=\"Mad Max: Fury Road\" >Mad Max: Fury Road</option>
<option value=\"American Sniper\" >American Sniper</option>
<option value=\"Star Trek Into Darkness\" >Star Trek Into Darkness</option>
<option value=\"Million Dollar Baby\" >Million Dollar Baby</option>
<option value=\"Gravity\" >Gravity</option>
<option value=\"Slumdog Millionaire\" >Slumdog Millionaire</option>
<option value=\"Now You See Me\" >Now You See Me</option>
<option value=\"The King's Speech\" >The King's Speech</option>
<option value=\"About Time\" >About Time</option>
<option value=\"Frozen\" >Frozen</option>
<option value=\"Cast Away\" >Cast Away</option>
<option value=\"Fury\" >Fury</option>
<option value=\"Rush\" >Rush</option>
<option value=\"Back to the Future Part II\" >Back to the Future Part II</option>
<option value=\"The Lego Movie\" >The Lego Movie</option>
<option value=\"Me Before You\" >Me Before You</option>
<option value=\"Drive\" >Drive</option>
<option value=\"The Help\" >The Help</option>
<option value=\"Captain Phillips\" >Captain Phillips</option>
<option value=\"The Hangover\" >The Hangover</option>
<option value=\"Black Swan\" >Black Swan</option>
<option value=\"Dawn of the Planet of the Apes\" >Dawn of the Planet of the Apes</option>
<option value=\"Aladdin\" >Aladdin</option>
<option value=\"Tangled\" >Tangled</option>
<option value=\"Life of Pi\" >Life of Pi</option>
<option value=\"Furious 7\" >Furious 7</option>
<option value=\"The Terminator\" >The Terminator</option>
<option value=\"Shrek\" >Shrek</option>
<option value=\"The Conjuring\" >The Conjuring</option>
<option value=\"The Fifth Element\" >The Fifth Element</option>
<option value=\"Casino Royale\" >Casino Royale</option>
<option value=\"Jaws\" >Jaws</option>
<option value=\"Toy Story 2\" >Toy Story 2</option>
<option value=\"The Great Gatsby\" >The Great Gatsby</option>
<option value=\"Captain America: Civil War\" >Captain America: Civil War</option>
<option value=\"Shaun of the Dead\" >Shaun of the Dead</option>
<option value=\"The Bourne Identity\" >The Bourne Identity</option>
<option value=\"Mulan\" >Mulan</option>
<option value=\"Despicable Me\" >Despicable Me</option>
<option value=\"Big Fish\" >Big Fish</option>
<option value=\"District 9\" >District 9</option>
<option value=\"Taken\" >Taken</option>
<option value=\"The Curious Case of Benjamin Button\" >The Curious Case of Benjamin Button</option>
<option value=\"E.T. the Extra-Terrestrial\" >E.T. the Extra-Terrestrial</option>
<option value=\"Ocean's Eleven\" >Ocean's Eleven</option>
<option value=\"X-Men: First Class\" >X-Men: First Class</option>
<option value=\"The Hobbit: An Unexpected Journey\" >The Hobbit: An Unexpected Journey</option>
<option value=\"Seven Pounds\" >Seven Pounds</option>
<option value=\"The Bourne Ultimatum\" >The Bourne Ultimatum</option>
<option value=\"The Exorcist\" >The Exorcist</option>
<option value=\"Zombieland\" >Zombieland</option>
<option value=\"Boyhood\" >Boyhood</option>
<option value=\"The Hobbit: The Battle of the Five Armies\" >The Hobbit: The Battle of the Five Armies</option>
<option value=\"Groundhog Day\" >Groundhog Day</option>
<option value=\"Kick-Ass\" >Kick-Ass</option>
<option value=\"Wreck-It Ralph\" >Wreck-It Ralph</option>
<option value=\"Hot Fuzz\" >Hot Fuzz</option>
<option value=\"The Big Short\" >The Big Short</option>
<option value=\"Star Wars: Episode III - Revenge of the Sith\" >Star Wars: Episode III - Revenge of the Sith</option>
<option value=\"Children of Men\" >Children of Men</option>
<option value=\"Ant-Man\" >Ant-Man</option>
<option value=\"Sherlock Holmes\" >Sherlock Holmes</option>
<option value=\"Ice Age\" >Ice Age</option>
<option value=\"Midnight in Paris\" >Midnight in Paris</option>
<option value=\"The Age of Adaline\" >The Age of Adaline</option>
<option value=\"(500) Days of Summer\" >(500) Days of Summer</option>
<option value=\"The Maze Runner\" >The Maze Runner</option>
<option value=\"The Hunger Games\" >The Hunger Games</option>
<option value=\"Pirates of the Caribbean: Dead Man's Chest\" >Pirates of the Caribbean: Dead Man's Chest</option>
<option value=\"The Bourne Supremacy\" >The Bourne Supremacy</option>
<option value=\"Blood Diamond\" >Blood Diamond</option>
<option value=\"Pitch Perfect\" >Pitch Perfect</option>
<option value=\"300\" >300</option>
<option value=\"Sin City\" >Sin City</option>
<option value=\"Argo\" >Argo</option>
<option value=\"The Social Network\" >The Social Network</option>
<option value=\"Skyfall\" >Skyfall</option>
<option value=\"Despicable Me 2\" >Despicable Me 2</option>
<option value=\"Bridge of Spies\" >Bridge of Spies</option>
<option value=\"Maleficent\" >Maleficent</option>
<option value=\"Predator\" >Predator</option>
<option value=\"Mission: Impossible - Rogue Nation\" >Mission: Impossible - Rogue Nation</option>
<option value=\"Southpaw\" >Southpaw</option>
<option value=\"American Psycho\" >American Psycho</option>
<option value=\"The Butterfly Effect\" >The Butterfly Effect</option>
<option value=\"Rise of the Planet of the Apes\" >Rise of the Planet of the Apes</option>
<option value=\"Zodiac\" >Zodiac</option>
<option value=\"The Girl with the Dragon Tattoo\" >The Girl with the Dragon Tattoo</option>
<option value=\"Sicario\" >Sicario</option>
<option value=\"The Equalizer\" >The Equalizer</option>
<option value=\"Back to the Future Part III\" >Back to the Future Part III</option>
<option value=\"Sherlock Holmes: A Game of Shadows\" >Sherlock Holmes: A Game of Shadows</option>
<option value=\"Creed\" >Creed</option>
<option value=\"Lost in Translation\" >Lost in Translation</option>
<option value=\"The Last Samurai\" >The Last Samurai</option>
<option value=\"Indiana Jones and the Temple of Doom\" >Indiana Jones and the Temple of Doom</option>
<option value=\"Saw\" >Saw</option>
<option value=\"Source Code\" >Source Code</option>
<option value=\"Monsters University\" >Monsters University</option>
<option value=\"Scott Pilgrim vs. the World\" >Scott Pilgrim vs. the World</option>
<option value=\"Minority Report\" >Minority Report</option>
<option value=\"I Am Legend\" >I Am Legend</option>
<option value=\"Iron Man 3\" >Iron Man 3</option>
<option value=\"22 Jump Street\" >22 Jump Street</option>
<option value=\"Silver Linings Playbook\" >Silver Linings Playbook</option>
<option value=\"Divergent\" >Divergent</option>
<option value=\"Fast Five\" >Fast Five</option>
<option value=\"Pirates of the Caribbean: At World's End\" >Pirates of the Caribbean: At World's End</option>
<option value=\"The Secret Life of Walter Mitty\" >The Secret Life of Walter Mitty</option>
<option value=\"Home Alone\" >Home Alone</option>
<option value=\"Men in Black\" >Men in Black</option>
<option value=\"The Devil Wears Prada\" >The Devil Wears Prada</option>
<option value=\"Corpse Bride\" >Corpse Bride</option>
<option value=\"The Man from U.N.C.L.E.\" >The Man from U.N.C.L.E.</option>
<option value=\"The Hurt Locker\" >The Hurt Locker</option>
<option value=\"Watchmen\" >Watchmen</option>
<option value=\"Nerve\" >Nerve</option>
<option value=\"127 Hours\" >127 Hours</option>
<option value=\"Spider-Man\" >Spider-Man</option>
<option value=\"Crazy, Stupid, Love.\" >Crazy, Stupid, Love.</option>
<option value=\"Rise of the Guardians\" >Rise of the Guardians</option>
<option value=\"Gangs of New York\" >Gangs of New York</option>
<option value=\"Thor: The Dark World\" >Thor: The Dark World</option>
<option value=\"Les Misérables\" >Les Misérables</option>
<option value=\"Kung Fu Panda\" >Kung Fu Panda</option>
<option value=\"The Intern\" >The Intern</option>
<option value=\"Juno\" >Juno</option>
<option value=\"X-Men\" >X-Men</option>
<option value=\"Hugo\" >Hugo</option>
<option value=\"Troy\" >Troy</option>
<option value=\"Superbad\" >Superbad</option>
<option value=\"Mission: Impossible - Ghost Protocol\" >Mission: Impossible - Ghost Protocol</option>
<option value=\"Batman\" >Batman</option>
<option value=\"The Impossible\" >The Impossible</option>
<option value=\"The Conjuring 2\" >The Conjuring 2</option>
<option value=\"X2\" >X2</option>
<option value=\"The Terminal\" >The Terminal</option>
<option value=\"Love Actually\" >Love Actually</option>
<option value=\"World War Z\" >World War Z</option>
<option value=\"Mean Girls\" >Mean Girls</option>
<option value=\"The Simpsons Movie\" >The Simpsons Movie</option>
<option value=\"Pacific Rim\" >Pacific Rim</option>
<option value=\"We're the Millers\" >We're the Millers</option>
<option value=\"Brave\" >Brave</option>
<option value=\"American Hustle\" >American Hustle</option>
<option value=\"Die Hard: With a Vengeance\" >Die Hard: With a Vengeance</option>
<option value=\"Spider-Man 2\" >Spider-Man 2</option>
<option value=\"21 Jump Street\" >21 Jump Street</option>
<option value=\"Unbreakable\" >Unbreakable</option>
<option value=\"Hotel Transylvania\" >Hotel Transylvania</option>
<option value=\"Snow White and the Seven Dwarfs\" >Snow White and the Seven Dwarfs</option>
<option value=\"I, Robot\" >I, Robot</option>
<option value=\"10 Cloverfield Lane\" >10 Cloverfield Lane</option>
<option value=\"Charlie and the Chocolate Factory\" >Charlie and the Chocolate Factory</option>
<option value=\"Captain America: The First Avenger\" >Captain America: The First Avenger</option>
<option value=\"The Croods\" >The Croods</option>
<option value=\"Iron Man 2\" >Iron Man 2</option>
<option value=\"The Matrix Reloaded\" >The Matrix Reloaded</option>
<option value=\"Thor\" >Thor</option>
<option value=\"In Time\" >In Time</option>
<option value=\"A Bug's Life\" >A Bug's Life</option>
<option value=\"Non-Stop\" >Non-Stop</option>
<option value=\"Independence Day\" >Independence Day</option>
<option value=\"Now You See Me 2\" >Now You See Me 2</option>
<option value=\"The Hunger Games: Mockingjay - Part 1\" >The Hunger Games: Mockingjay - Part 1</option>
<option value=\"Shrek 2\" >Shrek 2</option>
<option value=\"The Jungle Book\" >The Jungle Book</option>
<option value=\"Snowpiercer\" >Snowpiercer</option>
<option value=\"A.I. Artificial Intelligence\" >A.I. Artificial Intelligence</option>
<option value=\"Looper\" >Looper</option>
<option value=\"Pitch Perfect 2\" >Pitch Perfect 2</option>
<option value=\"Mission: Impossible\" >Mission: Impossible</option>
<option value=\"The Chronicles of Narnia: The Lion, the Witch and the Wardrobe\" >The Chronicles of Narnia: The Lion, the Witch and the Wardrobe</option>
<option value=\"Focus\" >Focus</option>
<option value=\"Transformers\" >Transformers</option>
<option value=\"The Hunger Games: Mockingjay - Part 2\" >The Hunger Games: Mockingjay - Part 2</option>
<option value=\"Cars\" >Cars</option>
<option value=\"Cinderella\" >Cinderella</option>
<option value=\"Jurassic World\" >Jurassic World</option>
<option value=\"Easy A\" >Easy A</option>
<option value=\"The Fast and the Furious\" >The Fast and the Furious</option>
<option value=\"Madagascar\" >Madagascar</option>
<option value=\"The Adventures of Tintin\" >The Adventures of Tintin</option>
<option value=\"The Amazing Spider-Man\" >The Amazing Spider-Man</option>
<option value=\"Chappie\" >Chappie</option>
<option value=\"Man of Steel\" >Man of Steel</option>
<option value=\"Cloud Atlas\" >Cloud Atlas</option>
<option value=\"Megamind\" >Megamind</option>
<option value=\"Kung Fu Panda 2\" >Kung Fu Panda 2</option>
<option value=\"RED\" >RED</option>
<option value=\"Real Steel\" >Real Steel</option>
<option value=\"Star Trek Beyond\" >Star Trek Beyond</option>
<option value=\"Underworld\" >Underworld</option>
<option value=\"The Mask\" >The Mask</option>
<option value=\"Super 8\" >Super 8</option>
<option value=\"King Kong\" >King Kong</option>
<option value=\"The Amazing Spider-Man 2\" >The Amazing Spider-Man 2</option>
<option value=\"Ender's Game\" >Ender's Game</option>
<option value=\"The Book of Eli\" >The Book of Eli</option>
<option value=\"50 First Dates\" >50 First Dates</option>
<option value=\"Rango\" >Rango</option>
<option value=\"The Purge: Anarchy\" >The Purge: Anarchy</option>
<option value=\"Dredd\" >Dredd</option>
<option value=\"Chronicle\" >Chronicle</option>
<option value=\"The Italian Job\" >The Italian Job</option>
<option value=\"Die Hard 2\" >Die Hard 2</option>
<option value=\"Mr. & Mrs. Smith\" >Mr. & Mrs. Smith</option>
<option value=\"Ice Age: The Meltdown\" >Ice Age: The Meltdown</option>
<option value=\"The Da Vinci Code\" >The Da Vinci Code</option>
<option value=\"Flight\" >Flight</option>
<option value=\"Horrible Bosses\" >Horrible Bosses</option>
<option value=\"Ice Age: Dawn of the Dinosaurs\" >Ice Age: Dawn of the Dinosaurs</option>
<option value=\"The Cabin in the Woods\" >The Cabin in the Woods</option>
<option value=\"Pirates of the Caribbean: On Stranger Tides\" >Pirates of the Caribbean: On Stranger Tides</option>
<option value=\"Friends with Benefits\" >Friends with Benefits</option>
<option value=\"Hellboy\" >Hellboy</option>
<option value=\"Oblivion\" >Oblivion</option>
<option value=\"X-Men: Apocalypse\" >X-Men: Apocalypse</option>
<option value=\"Rio\" >Rio</option>
<option value=\"Alice in Wonderland\" >Alice in Wonderland</option>
<option value=\"Minions\" >Minions</option>
<option value=\"Angels & Demons\" >Angels & Demons</option>
<option value=\"Mission: Impossible III\" >Mission: Impossible III</option>
<option value=\"Ocean's Thirteen\" >Ocean's Thirteen</option>
<option value=\"Star Wars: Episode II - Attack of the Clones\" >Star Wars: Episode II - Attack of the Clones</option>
<option value=\"Blade\" >Blade</option>
<option value=\"Dumb and Dumber\" >Dumb and Dumber</option>
<option value=\"Elysium\" >Elysium</option>
<option value=\"The Matrix Revolutions\" >The Matrix Revolutions</option>
<option value=\"Maze Runner: The Scorch Trials\" >Maze Runner: The Scorch Trials</option>
<option value=\"Bruce Almighty\" >Bruce Almighty</option>
<option value=\"Warm Bodies\" >Warm Bodies</option>
<option value=\"Wanted\" >Wanted</option>
<option value=\"Armageddon\" >Armageddon</option>
<option value=\"American Pie\" >American Pie</option>
<option value=\"Cloverfield\" >Cloverfield</option>
<option value=\"Ocean's Twelve\" >Ocean's Twelve</option>
<option value=\"Live Free or Die Hard\" >Live Free or Die Hard</option>
<option value=\"Resident Evil\" >Resident Evil</option>
<option value=\"Lucy\" >Lucy</option>
<option value=\"National Treasure\" >National Treasure</option>
<option value=\"White House Down\" >White House Down</option>
<option value=\"Prometheus\" >Prometheus</option>
<option value=\"Ted\" >Ted</option>
<option value=\"Spectre\" >Spectre</option>
<option value=\"Star Wars: Episode I - The Phantom Menace\" >Star Wars: Episode I - The Phantom Menace</option>
<option value=\"The Wolverine\" >The Wolverine</option>
<option value=\"X-Men: The Last Stand\" >X-Men: The Last Stand</option>
<option value=\"Jack Reacher\" >Jack Reacher</option>
<option value=\"Night at the Museum\" >Night at the Museum</option>
<option value=\"TRON: Legacy\" >TRON: Legacy</option>
<option value=\"Home Alone 2: Lost in New York\" >Home Alone 2: Lost in New York</option>
<option value=\"This Is the End\" >This Is the End</option>
<option value=\"Warcraft\" >Warcraft</option>
<option value=\"Kick-Ass 2\" >Kick-Ass 2</option>
<option value=\"Men in Black 3\" >Men in Black 3</option>
<option value=\"X-Men Origins: Wolverine\" >X-Men Origins: Wolverine</option>
<option value=\"Insurgent\" >Insurgent</option>
<option value=\"The Hangover Part II\" >The Hangover Part II</option>
<option value=\"Olympus Has Fallen\" >Olympus Has Fallen</option>
<option value=\"Hancock\" >Hancock</option>
<option value=\"Tomorrowland\" >Tomorrowland</option>
<option value=\"Neighbors\" >Neighbors</option>
<option value=\"Ice Age: Continental Drift\" >Ice Age: Continental Drift</option>
<option value=\"The Lost World: Jurassic Park\" >The Lost World: Jurassic Park</option>
<option value=\"Ted 2\" >Ted 2</option>
<option value=\"The Day After Tomorrow\" >The Day After Tomorrow</option>
<option value=\"Dracula Untold\" >Dracula Untold</option>
<option value=\"War of the Worlds\" >War of the Worlds</option>
<option value=\"Prince of Persia: The Sands of Time\" >Prince of Persia: The Sands of Time</option>
<option value=\"Salt\" >Salt</option>
<option value=\"Riddick\" >Riddick</option>
<option value=\"2 Fast 2 Furious\" >2 Fast 2 Furious</option>
<option value=\"The 40 Year Old Virgin\" >The 40 Year Old Virgin</option>
<option value=\"Transformers: Dark of the Moon\" >Transformers: Dark of the Moon</option>
<option value=\"The Incredible Hulk\" >The Incredible Hulk</option>
<option value=\"Quantum of Solace\" >Quantum of Solace</option>
<option value=\"The Expendables 2\" >The Expendables 2</option>
<option value=\"Taken 2\" >Taken 2</option>
<option value=\"The Twilight Saga: Breaking Dawn - Part 2\" >The Twilight Saga: Breaking Dawn - Part 2</option>
<option value=\"300: Rise of an Empire\" >300: Rise of an Empire</option>
<option value=\"The Interview\" >The Interview</option>
<option value=\"Taken 3\" >Taken 3</option>
<option value=\"John Carter\" >John Carter</option>
<option value=\"Paper Towns\" >Paper Towns</option>
<option value=\"Underworld: Awakening\" >Underworld: Awakening</option>
<option value=\"Night at the Museum: Secret of the Tomb\" >Night at the Museum: Secret of the Tomb</option>
<option value=\"Shrek Forever After\" >Shrek Forever After</option>
<option value=\"Percy Jackson & the Olympians: The Lightning Thief\" >Percy Jackson & the Olympians: The Lightning Thief</option>
<option value=\"Click\" >Click</option>
<option value=\"The Mummy Returns\" >The Mummy Returns</option>
<option value=\"Shrek the Third\" >Shrek the Third</option>
<option value=\"The Purge\" >The Purge</option>
<option value=\"The Bourne Legacy\" >The Bourne Legacy</option>
<option value=\"The Expendables\" >The Expendables</option>
<option value=\"San Andreas\" >San Andreas</option>
<option value=\"Men in Black II\" >Men in Black II</option>
<option value=\"Transformers: Revenge of the Fallen\" >Transformers: Revenge of the Fallen</option>
<option value=\"Mission: Impossible II\" >Mission: Impossible II</option>
<option value=\"Night at the Museum: Battle of the Smithsonian\" >Night at the Museum: Battle of the Smithsonian</option>
<option value=\"Allegiant\" >Allegiant</option>
<option value=\"Terminator 3: Rise of the Machines\" >Terminator 3: Rise of the Machines</option>
<option value=\"Transcendence\" >Transcendence</option>
<option value=\"The Lone Ranger\" >The Lone Ranger</option>
<option value=\"Jason Bourne\" >Jason Bourne</option>
<option value=\"Terminator Salvation\" >Terminator Salvation</option>
<option value=\"The Secret Life of Pets\" >The Secret Life of Pets</option>
<option value=\"Spider-Man 3\" >Spider-Man 3</option>
<option value=\"Cars 2\" >Cars 2</option>
<option value=\"Suicide Squad\" >Suicide Squad</option>
<option value=\"The Twilight Saga: Eclipse\" >The Twilight Saga: Eclipse</option>
<option value=\"Teenage Mutant Ninja Turtles\" >Teenage Mutant Ninja Turtles</option>
<option value=\"Transformers: Age of Extinction\" >Transformers: Age of Extinction</option>
<option value=\"Snow White and the Huntsman\" >Snow White and the Huntsman</option>
<option value=\"Twilight\" >Twilight</option>
<option value=\"Terminator Genisys\" >Terminator Genisys</option>
<option value=\"Jurassic Park III\" >Jurassic Park III</option>
<option value=\"Lara Croft: Tomb Raider\" >Lara Croft: Tomb Raider</option>
<option value=\"Dark Shadows\" >Dark Shadows</option>
<option value=\"RoboCop\" >RoboCop</option>
<option value=\"Indiana Jones and the Kingdom of the Crystal Skull\" >Indiana Jones and the Kingdom of the Crystal Skull</option>
<option value=\"Hansel & Gretel: Witch Hunters\" >Hansel & Gretel: Witch Hunters</option>
<option value=\"Exodus: Gods and Kings\" >Exodus: Gods and Kings</option>
<option value=\"The 5th Wave\" >The 5th Wave</option>
<option value=\"G.I. Joe: The Rise of Cobra\" >G.I. Joe: The Rise of Cobra</option>
<option value=\"Oz: The Great and Powerful\" >Oz: The Great and Powerful</option>
<option value=\"Clash of the Titans\" >Clash of the Titans</option>
<option value=\"Sausage Party\" >Sausage Party</option>
<option value=\"Noah\" >Noah</option>
<option value=\"The Twilight Saga: New Moon\" >The Twilight Saga: New Moon</option>
<option value=\"Pixels\" >Pixels</option>
<option value=\"Batman v Superman: Dawn of Justice\" >Batman v Superman: Dawn of Justice</option>
<option value=\"Battleship\" >Battleship</option>
<option value=\"The Legend of Tarzan\" >The Legend of Tarzan</option>
<option value=\"Jack the Giant Slayer\" >Jack the Giant Slayer</option>
<option value=\"2012\" >2012</option>
<option value=\"Fantastic 4: Rise of the Silver Surfer\" >Fantastic 4: Rise of the Silver Surfer</option>
<option value=\"Ghostbusters\" >Ghostbusters</option>
<option value=\"G.I. Joe: Retaliation\" >G.I. Joe: Retaliation</option>
<option value=\"Jupiter Ascending\" >Jupiter Ascending</option>
<option value=\"Fifty Shades of Grey\" >Fifty Shades of Grey</option>
<option value=\"Green Lantern\" >Green Lantern</option>
<option value=\"A Good Day to Die Hard\" >A Good Day to Die Hard</option>
<option value=\"After Earth\" >After Earth</option>
<option value=\"Independence Day: Resurgence\" >Independence Day: Resurgence</option>
<option value=\"Fantastic Four\" >Fantastic Four</option>	
	...
</select>
 
        </div>

        
        <input type=\"submit\" id=\"erfiuehrfiuehrfi\" value=\"Получить результат\" onclick=\"disableButton(this) class=\"submit-btn\"/>
      </fieldset>
</form>
<script>
    $(document).ready(function () {

        $(\"#test\").submit(function (e) {

            
            e.preventDefault();

            
            $(\"#erfiuehrfiuehrfi\").attr(\"disabled\", true);

          
            $(\"#erfiuehrfiuehrfi\").attr(\"disabled\", true);

            return true;

        });
    });
</script>

<link rel=\"stylesheet\" href=\"./css/select2.min.css\">
<script src=\"./js/jquery.min.js\"></script>
<script src=\"./js/select2.min.js\"></script>
<script src=\"./js/i18n/ru.js\"></script>
 
<script>
$(document).ready(function() {
	$('.js-select2').select2({
		placeholder: \"Выберите фильм\",
		maximumSelectionLength: 2,
		language: \"ru\"
	});
});
</script>


</body>


</html>
	";
}
?>
