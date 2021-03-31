<div class="container">


	<h1 class="text-center">Welkom bij Mauro project voor Fonky </h1>

	<p class="text-center">Hieronder vind u de uitleg over hoe alles is gedaan en waar je alles kan vinden</p>

	<p><br></p>

	<h4 class="text-center">Uitleg database class</h4>

	<p class="text-center">Voor dit project heb ik gekozen om het CSV bestand om te zetten naar een databse table.</br> 
	Vanuit deze database table haal ik met verschillende functies de verschillende resultaten op die u kunt zien op de pagina's.</p>

	<p class="text-center">In het bestand class-fonky-db.php te vinden in de map classes wordt de database connectie gemaakt en de verschillende functies die het insert en select vanuit de database regelt.</p>


	<p class="text-center">
		De eerst funcite is <strong>"fonky_query_insert"</strong> die zorgt er voor dat je alle data in de databse kan toevoegen als de goede variable zijn meegegeven.
	</p>

	<p class="text-center">
		De tweede funcite is <strong>"fonky_query_select"</strong> die zorgt er voor dat je alle infromatie kan uitlezen vanuit de databse als de goede variable zijn meegegeven.
	</p>

	<p class="text-center">
		De derde funcite is <strong>"fonky_query_select_distinct"</strong> die zorgt er voor dat je alle infromatie kan uitlezen vanuit de databse maar dat je alleen een keer het resultaat terug krijgt ondanks dat er meerder voor komen.
	</p>

	<p><br></p>

	<h4 class="text-center">Uitleg csv class</h4>

	<p class="text-center">
		In de csv class wordt eigelijk gebruikt gemaakt van de databse class om het csv bestand uit te lezen en vervolgens te push naar de database.
	</p>

	<p><br></p>

	<h4 class="text-center">Verschillende pagina</h4>

	<p class="text-center">
		Op de pagina <strong>"Totaal"</strong> kunt u het totaal overzicht zien van alle bestellingen die in de databse voorkomen.
		Door verschillende zoekopdrachten kun je de infroamtie beperken en of filter van nieuwe naar oud.
	</p>
	<p class="text-center">
		Op de pagina <strong>"Medewerkers"</strong> kunt u een overzicht zien van elke medeweker en hun verkochten producten.
	</p>

</div>