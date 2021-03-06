function restrictYears(selectedYear, restrictedYears, direction) {
    let year = document.getElementById(selectedYear).value;
    let years = document.getElementById(restrictedYears);
    let children = years.children;

    for (let i = 0; i < children.length; i++) {
        if (children[i].textContent * direction > year * direction) children[i].classList.add("hide");
        else children[i].classList.remove("hide");
    }
}

function initFiltersResize() {
    let isMoved = false;

    function onResize() {
        reportWindowSize();

        let widthOfScreen = document.body.offsetWidth;
        let rightBlock = document.getElementsByClassName("right-block")[0];
        let filters = document.querySelectorAll(".films-filters");
        let comments = document.querySelectorAll(".films-comments");


        if (widthOfScreen < 720) {
            let filtersContainer = document.getElementsByClassName("filters")[0];
            let commentsContainer = document.getElementsByClassName("comments")[0];
            filtersContainer.appendChild(filters[0]);
            commentsContainer.appendChild(comments[0]);
            isMoved = true;
        } else if (isMoved) {
            rightBlock.appendChild(filters[0]);
            rightBlock.appendChild(comments[0]);
            isMoved = false;
        }
    }

    onResize();
    window.onresize = onResize;
}

function findFilmsByFilters() {
    let formData = new FormData(document.getElementById("form-filters"));

    let request = new XMLHttpRequest();
    request.open('GET', "/list/filter/find?genre=" + formData.get("genre") +
        "&country=" + formData.get("country") +
        "&from=" + formData.get("from") +
        "&to=" + formData.get("to") +
        "&sort=" + formData.get("sort") +
        "&min=" + formData.get("min"), true);
    request.addEventListener('readystatechange', function () {
        if ((request.readyState === 4) && (request.status === 200)) {
            if (request.responseText !== "") {
                document.getElementById("filter-films").value = "Найдено (" + request.responseText + ")";
            } else {
                alert("Ошибка");
            }
        }
    });
    request.send();
}

function clearFilters() {
    document.getElementById("form-filters").reset();
    document.getElementById("filter-films").value = "Найти";
}