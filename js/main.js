document.addEventListener('DOMContentLoaded', function() {
    try {
        const stylesheetLink = document.querySelector('link[rel="stylesheet"]');

        // Получаем значение атрибута href
        const hrefValue = stylesheetLink.getAttribute('href');

        // Теперь убираем "css/style.css" и оставляем только путь к корню
        const rootPath = hrefValue.replace('css/style.css', '');
        let popup = document.querySelector(".popup");
        if (popup) {
            popup.style.left = (window.innerWidth - popup.offsetWidth) / 2 + "px";
        }
    } catch (error) {console.log(error)}

    try {
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
    } catch (error) {console.log(error)}
    
    try {
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
    } catch (error) {console.log(error)}
<<<<<<< HEAD
});

//замена аватарки

=======
    var lazyloadImages = document.querySelectorAll(".lazy-load");
    lazyloadImages.forEach(function(img) {
        img.style.backgroundImage = "url(" + img.getAttribute("data-bg") + ")";
    });
});
>>>>>>> 5401a14cca30f9b8b0b7cc52ef7c654768202218
