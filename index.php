<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "templates/header.php";
include "templates/navbar.php";
?>


<div class="container mt-2 mb-2 ml-2">
	<h1>Welcome to Independent Claws Chemistry Review!</h1>
</div>



<?php

include "classes/Hydrocarbons.php";
include "classes/Alkanes.php";
include "classes/Alkenes.php";

include "classes/ChemRxnRenderer.php";
include "classes/Quizmaker.php";
?>

<div class="container">
	<?php
$sample_quiz1 = Quizmaker::Make_Sample_Quiz1();

echo $sample_quiz1->get_quiz_html_form("index.php");
?>
</div>

<div class="container">
	<h1>Hydrocarbons</h1>

	<p>Hydrocarbons are substances composed mostly of hydrogen and carbon.  Below, we will consider the properties of three common subclasses of hydrocarbons: alkanes, alkenes, and alkynes.</p>
</div>

<div class="container">
	<h1>Alkanes</h1>

<p>Alkanes are full saturated hydrocarbon.  This means that all of the hydrogens are singly-bonded to the carbons to which they are attached.  Below is table showing molar mass and standard enthalpy of formation for alkanes.</p>

<p>Nomenclature for alkanes is relatively simple.  Just add the suffix "ane" to the prefix corresponding to the number of carbons in the compound.  If there is only one carbon, the correct prefix is "meth," giving the name "methane." If there are two carbons, the correct prefix is "eth," giving the name "ethane."</p>

<?php

echo ChemRxnRenderer::Get_HTML_Molar_Mass_Table(Alkane::GET_COMMON_ALKANES());

?>

</div>

<div class="container">
	<h1>Alkenes</h1>

<p>Alkenes are hydrocarbons with a least one double bond.  An alkene with a single double bond cannot exist by definition.  For alkenes with more than 3 carbons, the double bond can exist at one of several possible locations, making the nomenclature more complicated.</p>

<p>Firstly, as in the case of alkanes, one must add the suffix "ene" to the prefix corresponding to the number of carbons in the compound.  If there are two carbons, the correct prefix is "eth," giving the name "ethene." For a three-carbon chain, the correct name would be "propene." </p>

<p>When the number of carbons in the carbon chain exceeds three, however, the location of the double bond must be specified.</p>

<?php

?>

</div>



<?php
include "templates/footer_menu.php";
include "templates/footer.php";
?>