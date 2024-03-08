const fs = require('fs');
const axios = require('axios');
const path = require('path');

const downloadImage = async (url, imagePath) => {
  const response = await axios({
    url,
    responseType: 'stream',
  });

  const writer = fs.createWriteStream(imagePath);

  response.data.pipe(writer);

  return new Promise((resolve, reject) => {
    writer.on('finish', resolve);
    writer.on('error', reject);
  });
};

const main = async () => {
  const data = fs.readFileSync('data.json', 'utf8');
  const imageLinks = JSON.parse(data);

  for (let i = 0; i < imageLinks.length; i++) {
    const url = imageLinks[i];
    const filename = path.basename(url);
    const imagePath = path.resolve(__dirname, 'img', filename);

    if (fs.existsSync(imagePath)) {
      console.log(`Image ${i + 1}/${imageLinks.length} already exists, skipping download.`);
      continue;
    }

    try {
      await downloadImage(url, imagePath);
      console.log(`Downloaded image ${i + 1}/${imageLinks.length}`);
    } catch (error) {
      console.error(`Failed to download image ${i + 1}/${imageLinks.length}: ${error}`);
    }
  }
};

main().catch(console.error);
