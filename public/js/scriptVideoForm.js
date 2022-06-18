function selectItem(item) {
    if (item.id === 'video') {
        document.getElementById('name').innerText = item.files[0].name.split('.')[0];
        document.getElementById('size').innerText = Math.round(item.files[0].size / 1024 / 1024) + " MB";
    } else {
        document.getElementById('thumbnail-picture').src = URL.createObjectURL(item.files[0]);
    }
}

function count(item, counter, limit) {
    counter = document.getElementById(counter)
    item = document.getElementById(item)
    counter.innerText = item.value.length + " / " + limit

    if (item.value.length > limit) {
        counter.style.color = "red"
        item.classList.add("border-danger")
    } else {
        counter.style.color = "black"
        item.classList.remove("border-danger")
    }
}

function categoriesAutocomplete(input, autocompleteName, API) {
    autocomplete = document.getElementById(autocompleteName);
    input = document.getElementById(input)

    if (input.value[input.value.length - 1] === '\n') {
        input.value = input.value.slice(0, -1)
    }

    autocomplete.innerHTML = ""

    if (API === 'categories') {
        let xmlHttp = new XMLHttpRequest();
        xmlHttp.open( "GET", "{{ route('API_categories') }}?search=" + input.value + "&limit=5", false ); // false for synchronous request
        xmlHttp.send( null );
        let response = JSON.parse(xmlHttp.responseText)

        for (let i = 0; i < response.length; i++) {
            let element = document.createElement("p")
            element.classList.add("dropdown-item")
            element.classList.add("py-2")
            element.classList.add("mb-0")
            element.innerText = response[i].category_name
            element.setAttribute("onclick", "selectCategory('category', '" + response[i].category_name + "', '" + autocompleteName + "')")

            autocomplete.appendChild(element)
        }
    }
}

function checkMatch(item) {
    item = document.getElementById(item)

    if (item.value.length === 1) {
        console.log("match")
        if (item.value[item.value.length -1] !== '#') {
            item.value = '#' + item.value
        }
    } else if (item.value[item.value.length - 1] === ' ') {
        if (item.value.length > 1) {
            item.value = item.value + '#'
        }
    }
}

function selectCategory(item, name, autocomplete) {
    document.getElementById(item).value = name
    document.getElementById(autocomplete).innerHTML = ""
}
