document.addEventListener('DOMContentLoaded', () => {
    const editLinks = document.querySelectorAll('.edit-link');
    editLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const input = e.target.previousElementSibling;
            if (input.disabled) {
                input.disabled = false;
                input.focus();
                e.target.textContent = 'Сохранить';
            } else {
                input.disabled = true;
                e.target.textContent = 'Изменить';
                // Логика для сохранения изменений
            }
        });
    });

    const deleteButton = document.querySelector('.delete-button');
    deleteButton.addEventListener('click', () => {
        if (confirm('Вы уверены, что хотите удалить личный кабинет?')) {
            // Логика для удаления профиля
            alert('Личный кабинет удален');
        }
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('.registration-form');

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        // Валидация форм (пример)
        const inputs = form.querySelectorAll('input');
        let valid = true;

        inputs.forEach(input => {
            if (!input.value) {
                valid = false;
                input.style.borderColor = 'red';
            } else {
                input.style.borderColor = '#ccc';
            }
        });

        if (valid) {
            alert('Регистрация успешна!');
            // Логика для отправки формы на сервер
        } else {
            alert('Пожалуйста, заполните все поля.');
        }
    });

    // Удаление красной рамки при вводе данных
    form.querySelectorAll('input').forEach(input => {
        input.addEventListener('input', () => {
            input.style.borderColor = '#ccc';
        });
    });
});

