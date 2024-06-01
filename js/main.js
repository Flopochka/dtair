document.addEventListener('DOMContentLoaded', function() {
    let popup = document.querySelector(".popup");
    if (popup) {
        popup.style.left = (window.innerWidth - popup.offsetWidth) / 2 + "px";
    }

    const destinationCards = document.querySelectorAll('.destination-card');

    destinationCards.forEach(function(card) {
        card.querySelector(".destination-favorite").addEventListener('click', function() {
            const hiddenData = card.querySelector('.hdndata').value;

            fetch('handlers/favorite.php', {
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
                    if (card.querySelector(".destination-favorite").src.includes("non-favorite.svg")) {
                        card.querySelector(".destination-favorite").src = "img/its-favorite.svg";
                    } else {
                        card.querySelector(".destination-favorite").src = "img/non-favorite.svg";
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

            fetch('handlers/favorite.php', {
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
});