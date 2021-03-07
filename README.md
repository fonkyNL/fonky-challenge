# fonky-challenge
Dit is de opdracht voor developers die bij Fonky Sales solliciteren

Bij het interviewen van development posities, vinden we het belangrijk om code te zien en te bespreken. Daarom vragen we jou om aan een challenge te werken. Het is niet de bedoeling dat het je superveel tijd kost, een paar uur zou voldoende moeten zijn. De opdracht is breed geformuleerd; je zou er weken of dagen mee bezig kunnen zijn, natuurlijk is er maar zoveel dat je kunt doen in 2 uur. Maak je daar geen zorgen om, het gaat er niet om dat het af is, maar dat jij iets werkends laat zien waarbij je je skills etaleert.

**De opdracht**

In deze repository vind je een folder Data met daarin orders.csv. In dit bestand zitten de orders van Fonky van verschillende vestigingen van één klant.
Maak een dashboard van de resultaten voor deze klant. Je mag hier zelf weten wat je presenteert.
Maak een pull request aan waarin je in ieder geval een readme hebt opgenomen die uitlegt wat je moet doen om het resultaat te kunnen bekijken.

**Vrijheid**

Deze opdracht is expres ruim geformuleerd. Je mag de technieken en tools gebruiken die je het liefst gebruikt. Je mag je tijd besteden aan de aspecten die je zelf het belangrijkst vindt. Er is geen tijd om alles te doen: maak een keuze. Bij Fonky werken we met PHP, JavaScript, HTML en CSS. Je mag frameworks en libraries gebruiken. Je mag de data in een ander formaat omzetten of importeren in databases. Dan wel in de readme uitleggen hoe een ander het werkend kan krijgen.

De minimale requirement in de opdracht is "wat zijn de resultaten van deze klant voor Fonky". Dat kan in een lijstje, in een grafisch vorm, het kan als getallen of kleuren. Je kan het vergelijken met vorige week of een gemiddelde score. Probeer te bedenken wat voor Fonky het belangrijkst is.

## Voorwaarden

**MySQL**: Een MySQL server is nodig voor dit programma. In file `database.inc.php` kan je de credentials toevoegen.

**Chart.js**: In dit programma wordt gebruik gemaakt van de [Chart.js](https://chartjs.org) Javascrip library.

## Hoe te gebruiken

Download de hele package en plaats alles in een folder in je host. Navigeer daarna naar de folder in je browser.

Het programma probeert alle data te importeren in het eerste gebruik.

### Besteden

**index.php** is het hoofd bestand. Dit bestand laadt de rapporten en libraries.

**csv.inc.php** is de class en de functies gerelateerd aan de CSV bestanden.

**database.inc.php** is de class en functies voor de database.

**raport.inc.php** laadt de verschillende rapporten. Dit is het bestand dat je kan bewerken om meerdere rapporten toe te voegen.

**Rest van de bestanden**: `orders.csv` is de rauwe data in CSV formaat. `style.css` is de stylesheet van het programma. `utils.js` zijn een aantal variabelen en configs voor Chart.js lib.
