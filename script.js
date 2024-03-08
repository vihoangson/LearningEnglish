const axios = require('axios');
const cheerio = require('cheerio');
const fs = require('fs');

const url = 'https://www.trumtuvung.com/bo-tu-vung-thong-dung-oxford/page-';

const getData = async (page) => {
  const response = await axios.get(url + page);
  const $ = cheerio.load(response.data);

  const images = [];
  $('.vocabulary-image').each((i, el) => {
    const imageLink = $(el).attr('src');
    console.log(imageLink); // In ra console URL của hình ảnh
    images.push(imageLink);
  });

  return images;
};

const main = async () => {
  const data = [];

  for (let page = 1; page <= 300; page++) {
    const images = await getData(page);
    data.push(...images);
  }

  fs.writeFile('data.json', JSON.stringify(data), (err) => {
    if (err) throw err;
    console.log('Dữ liệu đã được ghi vào file data.json');
  });
};

main();
