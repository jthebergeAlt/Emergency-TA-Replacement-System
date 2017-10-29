const compression = require('compression');
const express = require('express');
const bodyParser = require('body-parser');
const path = require('path');
const port = process.env.PORT || 8080;
const app = express();

app.use(compression());
app.use(express.static(__dirname + '/src'));
app.use(express.static(__dirname));

// parse application/x-www-form-urlencoded
app.use(bodyParser.urlencoded({ extended: false }))

// parse application/json
app.use(bodyParser.json())

app.get('*', (req, res) => {
  res.sendFile(path.resolve(__dirname, 'src/login.html'))
});

app.post('/', function (req, res) {
  if (req.body.password === 'test')
    res.sendFile(path.resolve(__dirname, 'src/scheduling.html'));
  else
    res.sendFile(path.resolve(__dirname, 'src/loginFailed.html'));
});

app.listen(port);
console.info("Server started on port " + port);
