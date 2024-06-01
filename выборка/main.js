// Функция для чтения файла .csv
function readCSV(file) {
    const reader = new FileReader();
    reader.onload = function(e) {
      const text = e.target.result;
      const data = parseCSV(text);
      // Обработка данных и создание SQL-запросов
      const sqlQueries = createSQLQueries(data);
      document.body.innerText+=sqlQueries
    };
    reader.readAsText(file);
  }
  
  // Функция для парсинга текста .csv в массив объектов
  function parseCSV(text) {
    const lines = text.split('\n');
    const headers = lines[0].split(';').map(header => header.trim());
    return lines.slice(1).map(line => {
      const data = line.split(';');
      const obj = {};
      headers.forEach((header, index) => {
        obj[header] = data[index] && data[index].replace(/^"|"$/g, '').trim();
      });
      return obj;
    });
  }
  
  // Функция для создания SQL-запросов
  function createSQLQueries(data) {
    return data.map(row => {
      if (!row['num_code'] || !row['airline'] || !row['from'] || !row['to'] || !row['dep_time']) {
        console.error('Некоторые данные отсутствуют:', row);
        return ''; // Возвращаем пустую строку для неполных данных
      }
      return `INSERT INTO flights (id, num, airline_id, dest_from, dest_to, time) VALUES (NULL, '${row['num_code']}', '${row['airline']}', '${row['from']}', '${row['to']}', '${row['dep_time']}');`;
    }).filter(Boolean); // Удаляем пустые строки из результатов
  }
  
  // Пример использования
  const fileInput = document.getElementById('yourFileInput'); // Замените на ваш элемент input
  fileInput.addEventListener('change', function(e) {
    const file = e.target.files[0];
    readCSV(file);
  });


