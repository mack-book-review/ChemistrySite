

function get_chem_data(identifier){
	$.get("commonchemistry.cas.org/api",{q:identifier},function(data){
		console.log(data);
	},"json");
}

get_chem_data("ethane");
