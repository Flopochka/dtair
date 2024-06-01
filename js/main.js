document.addEventListener('DOMContentLoaded', function() {
    let popup = document.querySelector(".popup")
    if (popup) {
        popup.style.left = (window.innerWidth - popup.offsetWidth) / 2+"px";
    }
    
    const destinationCards = document.querySelectorAll('.destination-card');
    
    destinationCards.forEach(function(card) {
        card.querySelector(".destination-favorite").addEventListener('click', function() {
            const hiddenData = card.querySelector('.hdndata').value;
            
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'handlers/favorite.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    console.log(xhr.responseText);
                }
            };
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    const response = xhr.responseText.trim();
                    if (response === 'true') {
                        card.querySelector(".destination-favorite").classList.toggle("favorited")
                        console.log("good")
                    } else{
                        console.log(xhr.responseText)
                    }
                }
            };
            const params = 'type=1&id=' + encodeURIComponent(hiddenData);
            xhr.send(params);

        });
    });
});