function createRequestObject() {
    var ro;
    var browser = navigator.appName;
    if(browser == "Microsoft Internet Explorer"){
        ro = new ActiveXObject("Microsoft.XMLHTTP");
    }else{
        ro = new XMLHttpRequest();
    }
    return ro;
}

var http = createRequestObject();

function rename_camp(id) {

    http.open('post', 'renameajax.php', 'true');
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    http.send('id='+id);

    http.onreadystatechange = handleResponse;
    
}

function del(id,type) {

    http.open('post', 'deleteajax.php', 'true');
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    http.send('id='+id+'&type='+type);

    http.onreadystatechange = handleResponse;
    
}



function edit_banner(id, count) {

    http.open('post', 'editajax.php', 'true');
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    http.send('id='+id+'&count='+count);

    http.onreadystatechange = handleResponse;
}

function rename_process() {

	var name = encodeURI(document.renameform.name.value);
	var id = encodeURI(document.renameform.id.value);
	
    http.open('post', 'renameajax.php', 'true');
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    
    http.send('id='+id+'&name='+name);

    http.onreadystatechange = handleResponse;
}

function edit_process() {

	var id = escape(document.editform.id.value);
	var name = escape(document.editform.name.value);
	var weight = escape(document.editform.weight.value);
	var code = escape(document.editform.code.value);
	var edit = "Edit";
	
    http.open('post', 'editprocessajax.php', 'true');
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    
    http.send('id='+id+'&name='+name+'&weight='+weight+'&code='+code+'&edit='+edit);

    http.onreadystatechange = handleResponse;
}

function getcode(id) {

	var count = encodeURI(document.getcode.count.value);

    http.open('post', 'getcode.php', 'true');
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    
    http.send('id='+id+'&count='+count);

    http.onreadystatechange = handleResponse;
}

function handleResponse() {
    if(http.readyState == 4){
        var response = http.responseText;
        var update = new Array();

        if(response.indexOf('|' != -1)) {
            update = response.split('|');
            document.getElementById(update[0]).innerHTML = update[1];     
        }
    }
}
