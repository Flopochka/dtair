document.addEventListener('DOMContentLoaded', function() {
    const stylesheetLink = document.querySelector('link[rel="stylesheet"]');

    // Получаем значение атрибута href
    const hrefValue = stylesheetLink.getAttribute('href');

    // Теперь убираем "css/style.css" и оставляем только путь к корню
    const rootPath = hrefValue.replace('css/style.css', '');
    let popup = document.querySelector(".popup");
    if (popup) {
        popup.style.left = (window.innerWidth - popup.offsetWidth) / 2 + "px";
    }

    const destinationCards = document.querySelectorAll('.destination-card');

    destinationCards.forEach(function(card) {
        card.querySelector(".destination-favorite").addEventListener('click', function() {
            const hiddenData = card.querySelector('.hdndata').value;

            fetch(rootPath+'/handlers/favorite.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'type=1&id=' + encodeURIComponent(hiddenData)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(data => {
                if (data.trim() === 'true') {
                    const favoriteImg = card.querySelector(".destination-favorite").src;
                    if (favoriteImg.includes("non-favorite.svg")) {
                        card.querySelector(".destination-favorite").src = favoriteImg.replace("non-favorite.svg", "its-favorite.svg");
                    } else {
                        card.querySelector(".destination-favorite").src = favoriteImg.replace("its-favorite.svg", "non-favorite.svg");
                    }
                    card.querySelector(".destination-favorite").classList.toggle("favorited");
                    console.log("good",data);
                } else {
                    console.log("BAD",data);
                }
            })
            .catch(error => {
                console.error('There has been a problem with your fetch operation:', error);
            });

        });
    });
    const placeCards = document.querySelectorAll('.place-card');

    placeCards.forEach(function(card) {
        card.querySelector(".place-btn").addEventListener('click', function() {
            const hiddenData = card.querySelector('.hdndata').value;

            fetch(rootPath+'/handlers/favorite.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'type=2&id=' + encodeURIComponent(hiddenData)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(data => {
                if (data.trim() === 'true') {
                    const btnText = card.querySelector(".place-btn").textContent;
                    if (btnText === "В избранное") {
                        card.querySelector(".place-btn").textContent = "Избранное";
                    } else {
                        card.querySelector(".place-btn").textContent = "В избранное";
                    }
                    console.log("good", data);
                } else {
                    console.log("BAD", data);
                }
            })
            .catch(error => {
                console.error('There has been a problem with your fetch operation:', error);
            });

        });
    });


    const table = document.getElementById('flightTable');
    const headers = table.querySelectorAll('th');
    let currentSort = { index: -1, direction: 'none' };

    headers.forEach((header, index) => {
        header.addEventListener('click', () => {
            const isSameColumn = currentSort.index === index;
            if (isSameColumn) {
                if (currentSort.direction === 'none' || currentSort.direction === 'desc') {
                    currentSort.direction = 'asc';
                } else if (currentSort.direction === 'asc') {
                    currentSort.direction = 'desc';
                } else {
                    currentSort.direction = 'none';
                }
            } else {
                currentSort.index = index;
                currentSort.direction = 'asc';
            }

            headers.forEach(h => h.classList.remove('sort-asc', 'sort-desc'));
            if (currentSort.direction !== 'none') {
                headers[index].classList.add(`sort-${currentSort.direction}`);
            }

            sortTable(table, index, currentSort.direction);
        });
    });

    function sortTable(table, columnIndex, direction) {
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));

        if (direction === 'none') {
            rows.sort((a, b) => a.rowIndex - b.rowIndex);
        } else {
            rows.sort((a, b) => {
                const aText = a.children[columnIndex].innerText;
                const bText = b.children[columnIndex].innerText;

                if (!isNaN(aText) && !isNaN(bText)) {
                    return direction === 'asc' ? aText - bText : bText - aText;
                } else if (Date.parse(aText) && Date.parse(bText)) {
                    return direction === 'asc' ? new Date(aText) - new Date(bText) : new Date(bText) - new Date(aText);
                } else {
                    return direction === 'asc' ? aText.localeCompare(bText) : bText.localeCompare(aText);
                }
            });
        }

        rows.forEach(row => tbody.appendChild(row));
    }
});