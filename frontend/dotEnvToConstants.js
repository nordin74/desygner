const fs = require('fs');
const defaultOutputFile = 'constants.js'
const outFile = process.argv[2] ?? defaultOutputFile

fs.readFile('.env', 'utf8', (err, data) => {
  if (err) {
    console.error(err);
    return;
  }

  data = data
  .split(/\r\n|\n/)
  .filter((line) => line.replace(/\s/g, '') !== '' && // delete white spaces
    !line.replace(/\s/g, '').includes('#'), // delete comments
  );


  const file = fs.createWriteStream(outFile);
  data.forEach(value => file.write(`export const ${value};\n`));
  file.end();
});
