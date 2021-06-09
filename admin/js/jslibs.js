function onDelete(m,a,id){
	if(confirm("Are you sure delete this record?")){
		window.location.href="?m="+m+"&a="+a+"&id="+id;
	}
}