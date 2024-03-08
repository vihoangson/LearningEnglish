const express = require('express');
const fs = require('fs');
const path = require('path');
const paginate = require('express-paginate');

const app = express();
app.use(paginate.middleware(30, 50));
app.use('/img', express.static(path.join(__dirname, 'img')));

app.get('/', async (req, res) => {
    const imageFiles = fs.readdirSync(path.join(__dirname, 'img'));
    const pageCount = Math.ceil(imageFiles.length / req.query.limit);
    const pages = paginate.getArrayPages(req)(10, pageCount, req.query.page);
    const images = imageFiles.slice(req.skip, req.skip + req.query.limit);

    res.send(`
    <!DOCTYPE html>
    <html>
    <head>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
      <style>
        .card-img-top {
          width: 200px;
          height: 200px;
          object-fit: cover;
        }
      </style>
    </head>
    <body>
      <div class="container">
          <div class="row">
           <div class="col-12">
          ${pages.map(page => `<a href="${page.url}" class="btn btn-primary">${page.number}</a>`).join('')}
        </div>
</div>
        <div class="row">

        
          ${images.map(image => `
            <div class="col-md-4">
              <div class="card mb-4 text-center">
              <div class="d-flex justify-content-center align-items-center" style="height: 300px;">
                <img src="/img/${image}" class="card-img-top" loading="lazy" />
              </div>
                <div class="card-body">
                  <p class="card-text">${path.basename(image, path.extname(image))}</p>
                </div>
              </div>
            </div>
          `).join('')}
        </div>
        <div>
          ${pages.map(page => `<a href="${page.url}" class="btn btn-primary">${page.number}</a>`).join('')}
        </div>
      </div>
    </body>
    </html>
  `);
});

app.listen(1986, () => {
    console.log('Server is running on port 1986');
});
