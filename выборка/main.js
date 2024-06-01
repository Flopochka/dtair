const fs = require('fs');

// Функция для чтения CSV файла и преобразования данных в массив
function readCSV(filePath) {
    return new Promise((resolve, reject) => {
        fs.readFile(filePath, 'utf8', (err, data) => {
            if (err) {
                reject(err);
            } else {
                resolve(data);
            }
        });
    });
}

// Функция для парсинга CSV данных
function parseCSV(data) {
    const lines = data.split('\n');
    const headers = lines[0].split(';');
    const rows = [];
    let currentRow = [];
    let inMultilineField = false;

    for (let i = 1; i < lines.length; i++) {
        const line = lines[i].trim();
        if (line.includes(';')) {
            if (inMultilineField) {
                currentRow[currentRow.length - 1] += ' ' + line.replace(/"/g, '');
                inMultilineField = false;
            } else {
                if (currentRow.length > 0) {
                    rows.push(currentRow);
                }
                currentRow = line.split(';');
            }
        } else {
            currentRow[currentRow.length - 1] += ' ' + line.replace(/"/g, '');
            inMultilineField = true;
        }
    }

    if (currentRow.length > 0) {
        rows.push(currentRow);
    }

    return rows.map(row => {
        return headers.reduce((obj, header, index) => {
            obj[header.trim()] = row[index] ? row[index].trim() : '';
            return obj;
        }, {});
    });
}

// Функция для создания SQL запроса
function createSQLInsertQuery(cities) {
    const sqlValues = cities.map(city => `('${city.replace(/'/g, "''")}', NULL)`).join(', ');
    return `INSERT INTO \`destinations\` (\`title\`, \`img\`) VALUES ${sqlValues};`;
}

// Основная функция
async function main() {
    
        const filePath = 'list.csv';
        const csvData = await readCSV(filePath);
        console.log(csvData)
        const parsedData = parseCSV(csvData);
        const cities = new Set();

        parsedData.forEach(row => {
            if (row['from']) cities.add(row['from'].toLowerCase());
            if (row['to']) cities.add(row['to'].toLowerCase());
        });

        const sqlQuery = createSQLInsertQuery(Array.from(cities));
        console.log(sqlQuery);
    
}

document.addEventListener('oncontentloaded',()=>{
  main();
})