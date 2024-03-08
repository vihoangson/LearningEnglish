const express = require('express');
const fs = require('fs');
const path = require('path');
const paginate = require('express-paginate');

const app = express();
app.use(paginate.middleware(40, 50)); // Set limit to 40 and maximum limit to 50

app.get('/api/images', async (req, res) => {
  const imageFiles = fs.readdirSync(path.join(__dirname, 'img'));
  const pageCount = Math.ceil(imageFiles.length / req.query.limit);
  const pages = paginate.getArrayPages(req)(3, pageCount, req.query.page);
  const images = imageFiles.slice(req.skip, req.skip + req.query.limit);

  res.json({
    images: images.map(image => ({
      url: `/img/${image}`,
      name: path.basename(image, path.extname(image))
    })),
    pageCount,
    pages
  });
});

app.listen(1986, () => {
  console.log('Server is running on port 1986');
});
