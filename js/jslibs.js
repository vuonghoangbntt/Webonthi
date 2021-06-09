function isString(v) {
    let reg = /^[A-Z a-z]+$/;
    return reg.test(v);
}

function isEmail(v) {
    let reg = /^[A-Za-z0-9\.\-\_]+\@[a-z0-9A-Z\-\_]+\.[a-zA-Z]{2,5}(\.[a-zA-Z]{2,4})?$/;
    return reg.test(v);
}

function isPhone(v) {
    let reg = /^((09|03|07|08|05|02)+([0-9]{8})\b)$/;
    return reg.test(v);
}

function isPwd(v) {
    let reg = /^[A-Za-z0-9]{5;10}$/;
    return reg.test(v);
}
function onDelete(m,a,id){
	if(confirm("Are you sure delete this record?")){
		window.location.href="?m="+m+"&a="+a+"&id="+id;
	}
}