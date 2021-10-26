var url = "/proj2/api.php?function="

function checkLogin() {
    var fetchUrl = url + "loggedIn";

    fetch(fetchUrl).then(function(response) {
        console.log(response.status);
    })

}

function formPost(action) {
    var node = document.getElementById(action)
    var fetchUrl = url + action;
    var formData = new FormData;
    for (var i=0; i < node.parentElement.length; i++) {
        formData.append(node.parentElement[i].name, node.parentElement[i].value);
    }
    fetch(fetchUrl, {method: 'post', body: formData}).then(function(response){
        console.log(response.status);
        if (response.status == 201) {
            //document.location.reload();
        }

        else if (response.status == 203) {
            console.log('user is already in the database');
        }
        else {
            console.log('evil face')
        }
    })
}

function userCheck() {
    var fetchUrl = url + "alreadyUser";
    var formData = new FormData;
    formData.append('username', document.getElementById('RG_user').value);
    fetch(fetchUrl, {method: 'post', body: formData}).then(function(response) {
        console.log(response.status);
    })
}

function logout() {

    var fetchUrl = url + 'logout';
    fetch(fetchUrl).then(function(response) {
        console.log(response.status);
        document.location.reload();
    })
}

function select(action, Eclass, id) {

    if (id == null) {
        var fetchUrl = url + action;
    }
    else {
        var fetchUrl = url + action + "&restaurant=" + id;
    }
    fetch(fetchUrl).then(function(response) {
        console.log(response.status);
        return response.json();
    }).then(function(data) {
        if (Eclass == 'UD_users' || Eclass == 'UD_restaurant') {
            var fields = document.getElementsByClassName(Eclass);
            for (var i=0; i < fields.length; i++) {
                fields[i].value = data[fields[i].name];
            }
        }
        else if (Eclass == 'account') {
            document.getElementById(Eclass).innerHTML = `
            <h1>` + data['username'] + `</h1>
            <p>` + data['firstName'] + " " + data['lastName'] + "</p>";
        }

        else if (Eclass == 'restaurants') {
            for (var i=0; i < data.length; i++) {
                document.getElementById(Eclass).innerHTML += '<h1>' + data[i].restaurantName + '</h1>';
            }
        }

        else if (Eclass == 'getDrink') {
            console.log('hey');
            for (var i=0; i < data.length; i++) {
                console.log('hey');
                document.getElementById(Eclass).innerHTML += "<option value='" + data[i].drinkID + "'>" + data[i].drinkName + "</option>";
            }
        }

        else if (Eclass == 'drinks') {
            var drink = document.getElementById(Eclass);
            drink.innerHTML = '<h1>' + data[0].restaurantName + '</h1>';
            for (var i=0; i < data.length; i++) {
                drink.innerHTML += '<p>' + data[i].drinkName + `</p>
                <img src='` + data[i].drinkImage + "'>";
            }
        }

    })
}

function deleteInfo(action, id) {

    if (id == 'id') {
        var fetchUrl = url + action + "&ID=" + document.getElementById('getDrink').value;
    }
    else {
        var fetchUrl = url + action;
    }
    fetch(fetchUrl).then(function(response) {
        console.log(response.status);
        if (response.status == 204) {
            document.location.reload();
        }
    })
}

function sendFile(evt) {
    evt.preventDefault();
    console.log(evt);

    var postFormData = new FormData();
    postFormData.append(evt.target.name, evt.target.files[0]);

    var fetchUrl = url + "image";

    fetch(fetchUrl, {method: 'post', body: postFormData}).then(function(response) {
        console.log('200');
    })
}