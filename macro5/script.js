// show add panel
document.getElementById("addBtn").onclick = function() {
    document.querySelector(".add-panel").classList.remove("hidden");
}

// cancel to hide panel
document.getElementById("cancel").onclick = function() {
    document.querySelector(".add-panel").classList.add("hidden");

    // clear form fields
    document.getElementById("activity-title").value = "";
    document.querySelector(".select-category").selectedIndex = 0;
    document.querySelector("#description-text").value = "";
    document.querySelector(".add-panel").classList.add("hidden");
    document.getElementById("error-message").classList.add("hidden");
}

// click save button
document.getElementById("save").onclick = function() {

    let title = document.getElementById("activity-title").value;
    let category = document.querySelector(".select-category").value;
    let description = document.getElementById("description-text").value;
    let errorMessage = document.getElementById("error-message");
    let container = document.querySelector(".container");

    // test if one of the entries is empty
    if ( title == "" || category == "" || description == "") {
        errorMessage.classList.remove("hidden");
        return;
    } else {
        errorMessage.classList.add("hidden");
    }

    // create a new item
    let item = document.createElement("div");
    item.classList.add("activity");
    item.innerHTML = `<h3>${title}</h3>`;
    item.dataset.name = title;
    item.dataset.season = category;
    item.dataset.description = description;
    item.dataset.createdTime = new Date().toLocaleString();

    // add delete button
    let deleteBtn = document.createElement("img");
    deleteBtn.src = "images/delete_button.png";
    deleteBtn.classList.add("delete-button");

    deleteBtn.onclick = function() {
        container.removeChild(item);
        updateBtn();
    }
    item.appendChild(deleteBtn);

    // add left button
    let leftBtn = document.createElement("img");
    leftBtn.src = "images/left_button.png";
    leftBtn.classList.add("left-button");

    leftBtn.onclick = function() {
        let previous = item.previousElementSibling;
        if (previous) {
            container.insertBefore(item, previous);
        }
        updateBtn();
    }
    item.appendChild(leftBtn);

    // add right button
    let rightBtn = document.createElement("img");
    rightBtn.src = "images/right_button.png";
    rightBtn.classList.add("right-button");

    rightBtn.onclick = function() {
        let next = item.nextElementSibling;
        if (next) {
            container.insertBefore(next, item);
        }
        updateBtn();
    }
    item.appendChild(rightBtn);


    if (category == "spring") {
        item.style.backgroundColor = "pink";
    } else if (category == "summer") {
        item.style.backgroundColor = "yellow";
    } else if (category == "fall") {
        item.style.backgroundColor = "orange";
    } else if (category == "winter") {
        item.style.backgroundColor = "lightblue";
    }

    // revert the drop down menu back to select all
    document.querySelector("select[name='seasons']").value = "all";
    document.querySelector("select[name='seasons']").dispatchEvent(new Event('change'));

    container.appendChild(item);
    updateBtn();

    // clear form fields
    document.getElementById("activity-title").value = "";
    document.querySelector(".select-category").selectedIndex = 0;
    document.querySelector("#description-text").value = "";
    document.querySelector(".add-panel").classList.add("hidden");
}

// open info panel
document.querySelector(".container").addEventListener("click", function(event) {
    if (event.target.classList.contains("activity")){
        if (event.target.classList.contains("delete-button")){
            return;
        } else {
            let item = event.target.closest(".activity");
            let panel = document.querySelector(".info-panel");
            
            // get current time and set it as last accessed time
            let lastAccessTime = new Date().toLocaleString();
            item.dataset.lastAccess = lastAccessTime;

            // modify the info panel
            panel.querySelector(".panel-name").textContent = item.dataset.name;
            panel.querySelector(".season").textContent = "Season: " + item.dataset.season;
            panel.querySelector(".description-text").textContent = item.dataset.description;
            panel.querySelector(".created-time").textContent = "Created: " + item.dataset.createdTime;
            panel.querySelector(".last-access-time").textContent = "Last Accessed: " + item.dataset.lastAccess;

            panel.classList.remove("hidden");
        }
    }
})

// close info panel
document.getElementById("close").onclick = function() {
    document.querySelector(".info-panel").classList.add("hidden");
}

// drop down menu reaction
document.querySelector("select[name='seasons']").addEventListener("change", function() {
    let selected = this.value;
    let items = document.querySelectorAll(".container .activity");
    for (let i = 0; i < items.length; i++) {
        if (selected === "all" || items[i].dataset.season === selected) {
            //remove any "display:none" style if the season satisfy the selected choice
            items[i].style.display = "";
        } else {
            items[i].style.display = "none";
        }
    }
})

// function to test if the left or right button should be hidden
function updateBtn() {
    let container = document.querySelector(".container");
    let items = container.querySelectorAll(".activity");

    for (let i = 0; i < items.length; i++) {
        let leftBtn = items[i].querySelector(".left-button");
        let rightBtn = items[i].querySelector(".right-button");

        if (i === 0) {
            leftBtn.style.display = "none";
        } else {
            leftBtn.style.display = "";
        }

        if (i === items.length - 1) {
            rightBtn.style.display = "none";
        } else {
            rightBtn.style.display = "";
        }
    }
}