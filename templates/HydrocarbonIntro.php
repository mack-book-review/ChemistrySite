<?php
include "inc/citation.php";
?>
<hr>
<br>
<div class='container'>

<h1>Heat, Work, and Internal Energy</h1>

<p><b>Heat</b> is energy transferred between a system and its surroundings as a result of a temperature difference.</p>

<p>Work involved in the expansion or compression of gases is called <b>pressure-volume work.</b>  Pressure-volume, or <i>P-V,</i> work is the type of work performed by the explosives and gases formed in the combustion of gasoline in an automobile engine.</p>

<p><b>Internal Energy, <i>U</i>,</b> is the total energy (both kinetic and potential) in a system, including <i>translational kinetic energy</i> of molecules, the energy associated with molecular vibrations and rotations, the energy stored in chemical bonds and intermolecular attractions, and the energy associated with electrons in the atoms.</p>

</div>
<hr>
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
